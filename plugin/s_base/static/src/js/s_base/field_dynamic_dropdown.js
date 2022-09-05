/*
 * Copyright 2019 Brainbean Apps (https://brainbeanapps.com)
 * License AGPL-3.0 or later (https://www.gnu.org/licenses/agpl.html).
 */
odoo.define("web_widget_dropdown_dynamic.field_dynamic_dropdown", function (require) {
    "use strict";

    var core = require("web.core");
    var AbstractField = require("web.AbstractField");
    var field_registry = require("web.field_registry");
     var BasicModel = require("web.BasicModel");
    var _lt = core._lt;

    var FieldDynamicDropdown = AbstractField.extend({
        description: _lt("Dynamic Dropdown"),
        template: "FieldSelection",
        specialData: "_fetchDynamicDropdownValues",
        supportedFieldTypes: ["selection", "char", "integer"],
        events: _.extend({}, AbstractField.prototype.events, {
            change: "_onChange",
        }),
        /**
         * @override
         */
        init: function () {
            this._super.apply(this, arguments);
            this._setValues();
        },

        // --------------------------------------------------------------------------
        // Public
        // --------------------------------------------------------------------------

        /**
         * @override
         * @returns {jQuery}
         */
        getFocusableElement: function () {
            return this.$el.is("select") ? this.$el : $();
        },
        /**
         * @override
         */
        isSet: function () {
            return this.value !== false;
        },
        /**
         * Listen to modifiers updates to hide/show the falsy value in the dropdown
         * according to the required modifier.
         *
         * @override
         */
        updateModifiersValue: function () {
            this._super.apply(this, arguments);
            if (!this.attrs.modifiersValue.invisible && this.mode !== "readonly") {
                this._setValues();
                this._renderEdit();
            }
        },

        // --------------------------------------------------------------------------
        // Private
        // --------------------------------------------------------------------------

        /**
         * @override
         * @private
         */
        _formatValue: function (value) {
            var options = _.extend(
                {},
                this.nodeOptions,
                {data: this.recordData},
                this.formatOptions
            );
            var formattedValue = _.find(this.values, function (option) {
                return option[0] === value;
            });
            if (!formattedValue) {
                return value;
            }
            formattedValue = formattedValue[1];
            if (options && options.escape) {
                formattedValue = _.escape(formattedValue);
            }
            return formattedValue;
        },
        /**
         * @override
         * @private
         */
        _renderEdit: function () {
            this.$el.empty();
            for (var i = 0; i < this.values.length; i++) {
                this.$el.append(
                    $("<option/>", {
                        value: JSON.stringify(this.values[i][0]),
                        text: this.values[i][1],
                    })
                );
            }
            this.$el.val(JSON.stringify(this.value));
        },
        /**
         * @override
         * @private
         */
        _renderReadonly: function () {
            this.$el.empty().text(this._formatValue(this.value));
        },
        /**
         * @override
         */
        _reset: function () {
            this._super.apply(this, arguments);
            this._setValues();
        },
        /**
         * Sets the possible field values.
         *
         * @private
         */
        _setValues: function () {
            this.values = _.reject(this.record.specialData[this.name], function (v) {
                return v[0] === false && v[1] === "";
            });
            if (!this.attrs.modifiersValue || !this.attrs.modifiersValue.required) {
                this.values = [[false, this.attrs.placeholder || ""]].concat(
                    this.values
                );
            }
        },

        // --------------------------------------------------------------------------
        // Handlers
        // --------------------------------------------------------------------------

        /**
         * @private
         */
        _onChange: function () {
            var value = JSON.parse(this.$el.val());
            this._setValue(value.toString());
        },
    });
    field_registry.add("dynamic_dropdown", FieldDynamicDropdown);

    var DoNotify = AbstractField.extend({
        template: 's_oms_notify',
        _render: function () {
            var self = this
            if (this.value) {
                this.displayNotification({
                    type: 'success',
                    title: _lt("Notification"),
                    message: _lt(this.value),
                });
                // this.do_notify(_t("Notification"), this.value, false)
                setTimeout(function () {
                    self.reset_value()
                }, 500);
            }

        },
        reset_value: function () {
            var self = this
            var def = this._rpc({
                model: this.model,
                method: 'reset_notify',
                args: [this.res_id],
            }).then(function (res) {
            });
        }

    })

    field_registry.add('s_notify', DoNotify);


    BasicModel.include({
        /**
         * Fetches all the values associated to the given fieldName.
         *
         * @param {Object} record - an element from the localData
         * @param {Object} fieldName - the name of the field
         * @param {Object} fieldInfo
         * @returns {Promise<any>}
         *          The promise is resolved with the fetched special values.
         *          If this data is the same as the previously fetched one
         *          (for the given parameters), no RPC is done and the promise
         *          is resolved with the undefined value.
         */
        _fetchDynamicDropdownValues: function (record, fieldName, fieldInfo) {
            var model = fieldInfo.options.model || record.model;
            var method = fieldInfo.values || fieldInfo.options.values;
            if (!method) {
                return Promise.resolve();
            }

            var context = record.getContext({fieldName: fieldName});

            // Avoid rpc if not necessary
            var hasChanged = this._saveSpecialDataCache(record, fieldName, {
                context: context,
            });
            if (!hasChanged) {
                return Promise.resolve();
            }

            return this._rpc({
                model: model,
                method: method,
                context: context,
            });
        },
    });
    return FieldDynamicDropdown;
});

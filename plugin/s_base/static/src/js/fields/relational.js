odoo.define('s_base.relational_fields', function (require) {
    "use strict";

    var core = require('web.core');
    var config = require("web.config");
    var fields = require('web.relational_fields');

    var _t = core._t;
    var QWeb = core.qweb;

    fields.FieldStatus.include({
        _setState: function () {
            this._super.apply(this, arguments);
            if (config.device.isMobile) {
                _.map(this.status_information, function (value) {
                    value.fold = true;
                });
            }
        },
    });

    fields.FieldOne2Many.include({
        _renderButtons: function () {
            var result = this._super.apply(this, arguments);
            if (config.device.isMobile && this.$buttons) {
                var $buttons = this.$buttons.find('.btn-secondary');
                $buttons.addClass('btn-primary s_base_mobile_add');
                $buttons.removeClass('btn-secondary');
            }
            return result;
        }
    });

    fields.FieldMany2Many.include({
        _renderButtons: function () {
            var result = this._super.apply(this, arguments);
            if (config.device.isMobile && this.$buttons) {
                var $buttons = this.$buttons.find('.btn-secondary');
                $buttons.addClass('btn-primary s_base_mobile_add');
                $buttons.removeClass('btn-secondary');
            }
            return result;
        }
    });

    fields.FieldRadio.include({
        _renderReadonly: function () {
            var self = this;
            var currentValue;
            if (this.field.type === 'many2one') {
                currentValue = this.value && this.value.data.id;
            } else {
                currentValue = this.value;
            }
            this.$el.empty();
            _.each(this.values, function (value, index) {
                self.$el.append(QWeb.render('FieldRadio.buttonReadonly', {
                    checked: value[0] === currentValue,
                    id: self.unique_id + '_' + value[0],
                    index: index,
                    value: value,
                }));
            });
            var class_name = this.nodeOptions.horizontal ? ' o_horizontal' : ' o_vertical'
            if (this.$el.attr('class').indexOf('o_vertical') !== -1) {

            } else {
                this.$el.addClass(class_name)
            }
        },
    })
    fields.FieldSelection.include({
        _renderReadonly: function () {
            this.$el.empty();
            var raw_value = "Select..."
            if (this._getRawValue()) {
                var value = this._getRawValue()
                for (var i = 0; i < this.values.length; i++) {
                    if (value === this.values[i][0]) {
                        raw_value = this.values[i][1]
                    }
                }
            }

            this.$el = $(QWeb.render('FieldSelection.buttonReadonly', {value: raw_value}))
            var required = this.attrs.modifiersValue && this.attrs.modifiersValue.required;
            // for (var i = 0; i < this.values.length; i++) {
            //     var disabled = i > 0 || JSON.stringify(this.values[i][0]) === 'false';
            //
            //     this.$el.append($('<option/>', {
            //         value: JSON.stringify(this.values[i][0]),
            //         text: this.values[i][1],
            //         style: disabled ? "display: none" : "",
            //     }));
            //
            // }
            //     $('.btn-primary:visible:first').odooBounce();
            // }
            // this.$el.val(JSON.stringify(this._getRawValue()));
        },
    })
});
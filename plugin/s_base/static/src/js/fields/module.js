odoo.define('s_base_utils.ModuleBoolean', function (require) {
    "use strict";

    var core = require('web.core');
    var fields = require('web.basic_fields');
    var registry = require('web.field_registry');
    var framework = require('web.framework');

    var Dialog = require('web.Dialog');
    var AbstractField = require('web.AbstractField');

    var _t = core._t;
    var QWeb = core.qweb;

    var ModuleBoolean = fields.FieldBoolean.extend({
        supportedFieldTypes: [],
        events: _.extend({}, AbstractField.prototype.events, {
            'click input': '_onInputClicked',
        }),
        renderWithLabel: function ($label) {
            this.$label = $label;
            this._render();
        },
        _openDialog: function () {
            var buttons = [{
                text: _t("Download"),
                classes: 'btn-primary',
                close: true,
                click: this._confirmRedirect.bind(this),
            }, {
                text: _t("Cancel"),
                close: true,
            }];
            return new Dialog(this, {
                size: 'medium',
                buttons: buttons,
                $content: $('<div>', {
                    html: $(QWeb.render('s_base_utils.MissingModuleDialog')),
                }),
                title: _t("Missing Module"),
            }).open();
        },
        _confirmRedirect: function () {
            if (this.nodeOptions.url) {
                framework.redirect(this.nodeOptions.url);
            } else {
                var module = this.name.replace("module_", "");
                framework.redirect("https://apps.odoo.com/apps/modules/browse?search=" + module);
            }
        },
        _render: function () {
            this._super.apply(this, arguments);
            var $element = this.$label || this.$el;
            $element.append('&nbsp;').append($("<span>", {
                'text': _t("Store"),
                'class': "badge badge-primary oe_inline s_base_module_label"
            }));
        },
        _onInputClicked: function (event) {
            if ($(event.currentTarget).prop("checked")) {
                var dialog = this._openDialog();
                dialog.on('closed', this, this._resetValue.bind(this));
            }
        },
        _resetValue: function () {
            this.$input.prop("checked", false).change();
        },
    });

    registry.add('module_boolean', ModuleBoolean);

    return ModuleBoolean;

});
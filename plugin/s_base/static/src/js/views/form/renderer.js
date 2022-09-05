odoo.define('s_base_utils.FormRenderer', function (require) {
    "use strict";

    var core = require('web.core');

    var FormRenderer = require('web.FormRenderer');

    var _t = core._t;
    var QWeb = core.qweb;

    FormRenderer.include({
        _updateView: function ($newContent) {
            this._super.apply(this, arguments);
            _.each(this.allFieldWidgets[this.state.id], function (widget) {
                if (widget.attrs.widget === 'module_boolean') {
                    var inputID = this.idsForLabels[widget.name];
                    var $widgets = this.$('.o_field_widget[name=' + widget.name + ']');
                    var $label = inputID ? this.$('.o_form_label[for=' + inputID + ']') : $();
                    widget.renderWithLabel($label.eq($widgets.index(widget.$el)));
                }
            }, this);
        }
    });

});
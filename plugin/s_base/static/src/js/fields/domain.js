odoo.define('s_base_utils.domain', function (require) {
    "use strict";

    var core = require('web.core');
    var session = require('web.session');
    var fields = require('web.basic_fields');
    var view_dialogs = require('web.view_dialogs');

    var _t = core._t;
    var QWeb = core.qweb;

    fields.FieldDomain.include({
        _onShowSelectionButtonClick: function (e) {
            e.preventDefault();
            new view_dialogs.SelectCreateDialog(this, {
                context: this.attrs.context || {},
                title: _t("Selected records"),
                res_model: this._domainModel,
                domain: this.value || "[]",
                no_create: true,
                readonly: true,
                disable_multiple_selection: true,
            }).open();
        },
        isValid: function () {
            return (
                this._isValid && (!this.domainSelector || this.domainSelector.isValid())
            );
        },
    });

});

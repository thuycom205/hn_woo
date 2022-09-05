odoo.define('s_base_utils.abstract', function (require) {
    "use strict";

    var core = require('web.core');
    var session = require('web.session');
    var utils = require('web.field_utils');
    var fields = require('web.basic_fields');
    var registry = require('web.field_registry');

    var AbstractField = require('web.AbstractField');

    var _t = core._t;
    var QWeb = core.qweb;

    AbstractField.include({
        isFocusable: function () {
            if (!!this.attrs.skip_focus) {
                return false;
            }
            return this._super.apply(this, arguments);
        },
    });

});

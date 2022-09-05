odoo.define('s_base_utils.Notification', function (require) {
    "use strict";

    var core = require('web.core');

    var Notification = require('web.Notification');

    var _t = core._t;
    var QWeb = core.qweb;

    Notification.include({
        init: function (parent, params) {
            this._super.apply(this, arguments);
            this.icon = params.icon || this.icon;
            this.progress = params.progress;
        },
        updateProgress: function (state, text) {
            this.progress = {state: state, text: text};
            this.$(".progress-bar").text(text);
            this.$(".progress-bar").width(state + "%");
        },
    });

});
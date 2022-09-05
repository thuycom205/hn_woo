odoo.define('s_base.FormRenderer', function (require) {
    "use strict";

    var dom = require('web.dom');
    var core = require('web.core');
    var config = require("web.config");

    var FormRenderer = require('web.FormRenderer');

    var _t = core._t;
    var QWeb = core.qweb;

    FormRenderer.include({
        _renderHeaderButtons: function () {
            const $buttons = this._super.apply(this, arguments);
            if (
                !config.device.isMobile ||
                !$buttons.is(":has(>:not(.o_invisible_modifier))")
            ) {
                return $buttons;
            }

            $buttons.addClass("dropdown-menu");
            const $dropdown = $(
                core.qweb.render("s_base.MenuStatusbarButtons")
            );
            $buttons.addClass("dropdown-menu").appendTo($dropdown);
            return $dropdown;
        },
    });

});
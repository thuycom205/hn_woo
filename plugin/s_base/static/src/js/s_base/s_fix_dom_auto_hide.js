// Trigger onchange on popup field when enter keyboard
// Define new widget
odoo.define('s_base.s_fix_dom_auto_hide', function (require) {
    "use strict";
    var WebDom = require('web.dom');
    var session = require("web.session");
    var origin_initAutoMoreMenu = WebDom.initAutoMoreMenu;
    WebDom.initAutoMoreMenu = function($el, options) {
        options = _.extend({
            unfoldable: 'none',
            maxWidth: false,
            sizeClass: 'SM',
        }, options || {});
        var maxWidth = 6000
        if (session.is_admin){
            maxWidth = 800
        }
        options.maxWidth = function () {
                return maxWidth;
            }
        return origin_initAutoMoreMenu.apply(this, [$el, options])
    }
});


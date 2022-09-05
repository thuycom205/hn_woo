odoo.define('s_base.AppsMenu', function (require) {
    "use strict";

    var rpc = require('web.rpc');
    var core = require('web.core');
    var config = require("web.config");
    var session = require("web.session");

    var AppsMenu = require("web.AppsMenu");
    var MenuSearchMixin = require("s_base.MenuSearchMixin");

    var _t = core._t;
    var QWeb = core.qweb;
    var is_update_not_install_app = false;

    AppsMenu.include(_.extend({}, MenuSearchMixin, {
        events: _.extend({}, AppsMenu.prototype.events, {
            "keydown .s_base_search_input input": "_onSearchResultsNavigate",
            "click .s_base_menu_search_result": "_onSearchResultChosen",
            "shown.bs.dropdown": "_onMenuShown",
            "hidden.bs.dropdown": "_onMenuHidden",
            "hide.bs.dropdown": "_onMenuHide",
        }),
        init: function (parent, menuData) {
            this._super.apply(this, arguments);
            for (var n in this._apps) {
                this._apps[n].web_icon_data = menuData.children[n].web_icon_data;
            }
            this._searchableMenus = _.reduce(
                menuData.children, this._findNames.bind(this), {}
            );
            this._search_def = $.Deferred();
        },
        start: function () {
            this._setBackgroundImage();
            this.$search_container = this.$(".s_base_search_container");
            this.$search_input = this.$(".s_base_search_input input");
            this.$search_results = this.$(".s_base_search_results");
            return this._super.apply(this, arguments);
        },
        _onSearchResultChosen: function (event) {
            event.preventDefault();
            var $result = $(event.currentTarget),
                text = $result.text().trim(),
                data = $result.data(),
                suffix = ~text.indexOf("/") ? "/" : "";
            this.trigger_up("menu_clicked", {
                action_id: data.actionId,
                id: data.menuId,
                previous_menu_id: data.parentId,
            });
            var app = _.find(this._apps, function (_app) {
                return text.indexOf(_app.name + suffix) === 0;
            });
            core.bus.trigger("change_menu_section", app.menuID);
        },
        _onAppsMenuItemClicked: function (event) {
            this._super.apply(this, arguments);
            event.preventDefault();
        },
        _setBackgroundImage: function () {
            var self = this;
            // var url = session.url('/web/image', {
            //     model: 'res.company',
            //     id: session.company_id,
            //     field: 'background_image',
            // });
            this.$('.dropdown-menu').css({
                "background": 'url("/s_base/static/src/img/big_background.png")',
                "background-position": "center",
                "background-repeat": "no-repeat",
                "background-size": "cover",
            });
            // if (session.s_base_background_blend_mode) {
            //     this.$('.o-app-name').css({
            //         "mix-blend-mode": session.s_base_background_blend_mode,
            //     });
            // }
            if (!is_update_not_install_app) {
                rpc.query({
                    model: 'res.users',
                    method: 'get_not_install_app',
                    args: []
                }).then(function (data) {
                    is_update_not_install_app = true;
                    self.$('.dropdown-menu').append(data)
                });

            }

        },
        _onMenuHide: function (event) {
            return $('.oe_wait').length === 0 && !this.$('input').is(':focus');
        },
    }));

});
odoo.define('s_base.Menu', function (require) {
    "use strict";

    var core = require('web.core');
    var config = require("web.config");

    var Menu = require("web.Menu");
    var AppsBar = require("s_base.AppsBar");
    var session = require('web.session');

    var _t = core._t;
    var QWeb = core.qweb;

    Menu.include({
        events: _.extend({}, Menu.prototype.events, {
            "click .o_menu_apps a[data-toggle=dropdown]": "_onAppsMenuClick",
            "click .s_base_menu_mobile_section": "_onMobileSectionClick",
            "click .o_menu_sections [role=menuitem]": "_hideMobileSubmenus",
            "show.bs.dropdown .o_menu_systray, .o_menu_apps": "_hideMobileSubmenus",
            "click .o_menu_sections a": "_onclickMenuitem",
        }),
        menusTemplate: config.device.isMobile ?
            's_base.MobileMenu.sections' : Menu.prototype.menusTemplate,
        start: function () {
            var res = this._super.apply(this, arguments);
            console.log('menu')
            console.log(this)
            this.$menu_toggle = this.$(".s_base_menu_sections_toggle");
            this.$menu_apps_sidebar = this.$('.s_base_apps_sidebar_panel');
            this._appsBar = new AppsBar(this, this.menu_data);
            this._appsBar.appendTo(this.$menu_apps_sidebar);
            this.$menu_apps_sidebar.renderScrollBar();
            // this.is_not_admin = !session.is_admin
            // console.log(this.is_not_admin)
            if (config.device.isMobile) {
                var menu_ids = _.keys(this.$menu_sections);
                for (var i = 0; i < menu_ids.length; i++) {
                    var $section = this.$menu_sections[menu_ids[i]];
                    $section.on('click', 'a[data-menu]', this, function (ev) {
                        ev.stopPropagation();
                    });
                }
            }
            // update user name to right top avatar
            if (typeof session.username != 'undefined' && !session.is_admin) {
                var data = {}
                if (session.shopOwner !== undefined) {
                    data.user = 'Hi, ' + session.shopOwner
                } else {
                    data.user = session.username

                }
                data.href = 'https://' + session.username
                data.notifications = []
                if (session.notify !== undefined && session.notify) {
                    data.notify = session.notify
                    data.notifications = session.notifications
                }


                var $RightTop = this._render_right_top_avatar(data)
                $RightTop.appendTo(this.$('.o_main_navbar'))
            }
            return res;
        },


        _render_right_top_avatar: function (data) {
            return $(QWeb.render('s_base.RightTopAvatar', {data: data}));
        },

        _render_notify_modal: function (data) {
            return QWeb.render('s_base.s_af_alert', {data: data.notifications});

        },

        _onclickMenuitem: function (ev) {
            var prev_menu_active = this.$el.find('.s_menu_active')
            prev_menu_active.length > 0 ? prev_menu_active.removeClass('s_menu_active') : false
            if (!$(ev.currentTarget).hasClass('s_base_menu_no_icon')) {
                $(ev.currentTarget).addClass('s_menu_active')
                var current_menu_id = $(ev.currentTarget).attr('data-menu')
                document.cookie = "currentMenuID=" + current_menu_id;
            }
            if (window.innerWidth <= 768){
                if (!$('.o_menu_sections').hasClass('s-sm-none')){
                    $('.o_menu_sections').addClass('s-sm-none')
                    $('.s-modal').hide()
                }
            }
        },

        _hideMobileSubmenus: function () {
            if (this.$menu_toggle.is(":visible") && $('.oe_wait').length === 0 &&
                this.$section_placeholder.is(":visible")) {
                this.$section_placeholder.collapse("hide");
            }
        },
        _updateMenuBrand: function () {
            if (!config.device.isMobile) {
                return this._super.apply(this, arguments);
            }
        },
        _onAppsMenuClick: function (event, checkedCanBeRemoved) {
            // remove all menu active
            $('.s_menu_active').length > 0 ? $('.s_menu_active').removeClass('s_menu_active') : false
            document.cookie = "currentMenuID="
            var action_manager = this.getParent().action_manager;
            var controller = action_manager.getCurrentController();
            if (controller && !checkedCanBeRemoved) {
                controller.widget.canBeRemoved().then(function () {
                    $(event.currentTarget).trigger('click', [true]);
                    $(event.currentTarget).off('.bs.dropdown');
                });
                event.stopPropagation();
                event.preventDefault();
            }
        },
        _onMobileSectionClick: function (event) {
            event.preventDefault();
            event.stopPropagation();
            var $section = $(event.currentTarget);
            if ($section.hasClass('show')) {
                $section.removeClass('show');
                $section.find('.show').removeClass('show');
                $section.find('.fa-chevron-down').hide();
                $section.find('.fa-chevron-right').show();
            } else {
                $section.addClass('show');
                $section.find('ul:first').addClass('show');
                $section.find('.fa-chevron-down:first').show();
                $section.find('.fa-chevron-right:first').hide();
            }
        },
    });

});
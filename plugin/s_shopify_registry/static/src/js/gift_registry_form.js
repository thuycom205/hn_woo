odoo.define('giftregistry.basic_config_form', function (require) {
    'use strict';

    var FormController = require('web.FormController');
    var FormView = require('web.FormView');
    var FormRenderer = require('web.FormRenderer');
    var viewRegistry = require('web.view_registry');
    var session = require('web.session');
    var rpc = require('web.rpc');


    var EmployeeFormRenderer = FormRenderer.extend({

        _toggleMenu: function () {
            var o_main_navbar = jQuery('nav.o_main_navbar');
            if (o_main_navbar.length > 0) {
                var firNav = o_main_navbar.first();
                var is_menuprocessed = firNav.data('giftregistryprocessed');
                if (is_menuprocessed != '1') {

                    function initCss(e) {
                        window.AllFetchURL = 'https://app.thexseed.com';
                        var t = document.createElement("link");
                        t.setAttribute("rel", "stylesheet"), t.setAttribute("type", "text/css"),
                            t.onload = e, t.setAttribute("href", window.AllFetchURL + "/s_shopify_registry/static/src/bootstrap-polaris.min.css"), document.head.appendChild(t)
                    }

                    function initCss2(e) {
                        window.AllFetchURL = 'https://app.thexseed.com';
                        var t = document.createElement("link");
                        t.setAttribute("rel", "stylesheet"), t.setAttribute("type", "text/css"),
                            t.onload = e, t.setAttribute("href", window.AllFetchURL + "/s_shopify_registry/static/src/o_backend.css"), document.head.appendChild(t)
                    }

                    initCss();
                    initCss2();
                    var registry_setting = $('a[data-menu-xmlid= "s_shopify_registry.s_shopify_registry_view_setting"]');
                    var client = require('web.web_client');
                    var user_id = session.uid;

                     rpc.query({
                        model: 's_shopify_registry.setting',
                        method: 'get_setting_id',
                        args: [0],
                        kwargs: {context: session.user_context, user_id : user_id},

                    }, {
                        shadow: true,
                    }).then(function (response) {
                        var x = response;

                        window.user_registry_setting  = x;
                        // return self.do_action({
                        //     type: 'ir.actions.act_url',
                        //     url: url,
                        // });
                    });


                    if (registry_setting.length > 0) {

                        registry_setting.click(function (e) {
                            e.preventDefault();
                            client.do_action({
                                type: 'ir.actions.act_window',
                                res_model: 's_shopify_registry.setting',
                                views: [[false, 'form']],
                                res_id: window.user_registry_setting,
                            });
                            return false;

                        });
                    }

                    firNav.data('giftregistryprocessed', '1');

                }
            }

        },
        /**
         * @override
         */
        _render: function () {
            var self = this;
            return this._super.apply(this, arguments).then(function () {
                var head = document.getElementsByTagName('head')[0];


                setTimeout(self._toggleMenu, 500);
                setTimeout(self._toggleMenu, 1000);
                setTimeout(self._toggleMenu, 5000);


            });
        },

    });

    $('.mgn-header-sticky').click(function () {
        return false;
    });


    var EmployeeFormController = FormController.extend({
        custom_events: _.extend({}, FormController.prototype.custom_events, {
            open_chat: '_onOpenChat'
        }),

        _onOpenChat: function (ev) {
            var self = this;
            var dmChat = this.call('mail_service', 'getDMChatFromPartnerID', ev.data.partner_id);
            if (dmChat) {
                dmChat.detach();
            } else {
                var def = this.call('mail_service', 'createChannel', ev.data.partner_id, 'dm_chat').then(function (dmChatId) {
                    dmChat = self.call('mail_service', 'getChannel', dmChatId);
                    dmChat.detach();
                });
                Promise.resolve(def);
            }
        },
    });

    var EmployeeFormView = FormView.extend({
        config: _.extend({}, FormView.prototype.config, {
            Controller: EmployeeFormController,
            Renderer: EmployeeFormRenderer
        },),

        _extractParamsFromAction: function (action) {
            var params = this._super.apply(this, arguments);
            var inDialog = action.target === 'new';
            var inline = action.target === 'inline';
            var fullscreen = action.target === 'fullscreen';
            params.withControlPanel = !(inDialog || inline);
            params.footerToButtons = inDialog;
            params.hasSearchView = inDialog ? false : params.hasSearchView;
            params.hasSidebar = !inDialog && !inline;
            params.searchMenuTypes = inDialog ? [] : params.searchMenuTypes;
            params.mode = 'edit';
            return params;
        },
    });

    viewRegistry.add('giftregistry_form', EmployeeFormView);
    return EmployeeFormView;
});



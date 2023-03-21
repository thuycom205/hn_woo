odoo.define('registry.registry_list', function (require) {
    "use strict";
    var session = require('web.session');
    var viewRegistry = require('web.view_registry');
    var rpc = require('web.rpc');

    var ListController = require('web.ListController');

    var ListView = require('web.ListView');

    var GiftREgistryListController = ListController.extend({

        // -------------------------------------------------------------------------
        // Public
        // -------------------------------------------------------------------------

        init: function (parent, model, renderer, params) {
            this.context = renderer.state.getContext();
            return this._super.apply(this, arguments);
        },

        _toggleMenu: function () {
            var o_main_navbar = jQuery('nav.o_main_navbar');
            if (o_main_navbar.length > 0) {
                var firNav = o_main_navbar.first();
                var is_menuprocessed = firNav.data('giftregistryprocessed');
               // if (is_menuprocessed != '1') {

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
                        kwargs: {context: session.user_context, user_id: user_id},

                    }, {
                        shadow: true,
                    }).then(function (response) {
                        var x = response;

                        window.user_registry_setting = x;
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

                    });




                    firNav.data('giftregistryprocessed', '1');

                }
           // }

        },


        /**
         * @override
         */
        renderButtons: function ($node) {
           var self = this;

            this._super.apply(this, arguments);

            setTimeout(self._toggleMenu, 500);
            setTimeout(self._toggleMenu, 1000);
            setTimeout(self._toggleMenu, 3000);
            //setTimeout(self._toggleMenu, 4000);

            setTimeout(self._toggleMenu, 5000);
            //setTimeout(self._toggleMenu, 6000);
            //setTimeout(self._toggleMenu, 7000);
            //setTimeout(self._toggleMenu, 8000);
           // setTimeout(self._toggleMenu, 9000);
            setTimeout(self._toggleMenu, 10000);
        },

    });

    var RegistryListView = ListView.extend({
        config: _.extend({}, ListView.prototype.config, {
            Controller: GiftREgistryListController,
        }),
    });
    viewRegistry.add('giftregistry_list', RegistryListView);

    return RegistryListView;
});

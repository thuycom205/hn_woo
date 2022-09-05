odoo.define('s_base.Sidebar', function (require) {
    "use strict";

    /**
     * Action menus (or Action/Print bar, previously called 'Sidebar')
     * Khai bao 1 component moi inherit component core, truyen them bien vao constructor de dung trong xml
     * Dang ly component moi vao parent cua no
     */
    var ListModelHiddenSwitch = ['s.shopify.product.bundle.plan', 's.shopify.product.bundle.settings', 'shopify.tiktok.shop.setting', 's.shopify.sticky.bar.config', 's.shopify.mini.cart.config', 's.shopify.sticky.cart.config', 's.shopify.sticky.bar.config', 's.shopify.mobile.app.custom.design', 'sp.bought.together.plan',
        'sp.bought.together.integration', 'sp.bought.together.recommend.explorer', 'sp.bought.together.recommend.tuning', 'sp.bought.together.visual.preference','sp.bought.together.home']
    var ListModelHiddenPanels = ['s.shopify.product.bundle.plan', 'sp.bought.together.plan', 's.product.bundle.about', 's.product.bought.together.about', 's.sticky.add.to.cart.about', 's.sticky.cart.account', 's.google.feed.about', 's.google.feed.account', 's.tiktok.about', 's.tiktok.account', 's.shopify.mobile.app.about', 's.shopify.mobile.app.plan', 's.whatsapp.about', 's.whatsapp.plan'
    ,'s.oms.about','s.oms.account']
    var ListModelHideButtons = ['sp.bought.together.recommend.explorer', 's.sticky.cart.analytics', 's.shopify.mobile.app.getting.started', 'wsap.chat.whatsapp.chat.analytics',
        'wsap.chat.whatsapp.share.analytics', 'wsap.manual.abandoned.cart.analytics', 'wsap.manual.abandoned.cart.list', 'wsap.manual.order.crm.list', 'wsap.manual.order.crm.mess.logs', 's.shopify.product.bundle.report','s.oms.report','sp.bought.together.home']
    var ListModelHideBreadcrumb = ['s.shopify.mobile.app.getting.started', 's.shopify.product.bundle.report','s.oms.report']
    var ListModelSearchAction = ['wsap.manual.abandoned.cart.list', 'wsap.manual.order.crm.list', 'wsap.manual.order.crm.mess.logs']
    var ActionMenus = require('web.ActionMenus');
    var session = require('web.session');
    var ControlPanel = require('web.ControlPanel');
    const {useState} = owl.hooks;
    var has_home_page = ['s.product.bundle.about']

    ControlPanel.patch('custom.ControlPanel', T => {
        class ControlPanelPatch extends T {
            constructor() {
                super(...arguments);
                var model_name = typeof this.model != 'undefined' ? this.model.config.modelName : false
                this.state = useState({
                    is_admin: session.is_admin,
                    hide_switch: model_name ? ListModelHiddenSwitch.includes(model_name) : false,
                    hide_panels: model_name ? ListModelHiddenPanels.includes(model_name) : false,
                    hide_buttons: model_name ? ListModelHideButtons.includes(model_name) : false,
                    hide_breadcrumb: model_name ? ListModelHideBreadcrumb.includes(model_name) : false,
                    hide_searchActions: model_name ? ListModelSearchAction.includes(model_name) : false,
                    is_about_model: model_name ? model_name.includes('.about') : false,
                    has_home_page: model_name ? has_home_page.includes(model_name) : false,
                });
            }
        }

        return ControlPanelPatch;
    });
    ControlPanel.template = 'web.ControlPanelPatch'

    class SidebarPatch extends ActionMenus {
        constructor() {
            super(...arguments);
            this.props.is_admin = session.is_admin
            this.state = useState({
                is_admin : session.is_admin
            })
            if (!session.is_admin) {
                // this.props.items.other = []
                var other_items = []
                for (var k in this.props.items.other){
                    if (this.props.items.other[k].description === 'Delete'){
                        other_items.push(this.props.items.other[k])
                    }
                }
                this.props.items.other = other_items
                this.props.items.print = []
            }
        }
        async willUpdateProps(nextProps) {
            var other_items = []
            for (var k in nextProps.items.other){
                if (nextProps.items.other[k].description === 'Delete'){
                    other_items.push(nextProps.items.other[k])
                }
            }
            nextProps.items.other = other_items
            this.actionItems = await this._setActionItems(nextProps);
            this.printItems = await this._setPrintItems(nextProps);
        }
    }
    SidebarPatch.template = 'web.SidebarPatch';

    ControlPanel.components.ActionMenus = SidebarPatch

    var FilterMenu = require('web.FilterMenu')

    class FilterMenuPatch extends FilterMenu {
        constructor() {
            super(...arguments);
            this.state = useState({
                is_admin : session.is_admin
            })
            this.props.is_admin = session.is_admin
        }

    }

    FilterMenuPatch.template = 'web.FilterMenuPatch';
    ControlPanel.components.FilterMenu = FilterMenuPatch

    return {
        SidebarPatch: SidebarPatch
    }

});
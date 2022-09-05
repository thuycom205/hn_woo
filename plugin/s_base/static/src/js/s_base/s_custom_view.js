odoo.define('s.customView', function (require) {
    "use strict";
    var session = require('web.session');
    const SOURCE = {
        's_shopify_bought_together': {
            src: '/s_base/static/app_icon/fbt.png',
            name: 'Frequently Bought Together'
        },
        's_shopify_bundle': {
            src: '/s_base/static/app_icon/Bundles.png',
            name: 'Product Bundles'
        },
        's_shopify_google_feed':
            {
                src: '/s_base/static/app_icon/google-shopping.png',
                name: 'Google Shopping Feed'
            },
        's_shopify_mobile_app': {
            src: '/s_base/static/app_icon/mobile-app.png',
            name: 'Mobile App Builder'
        },
        's_shopify_tiktok': {
            src: '/s_base/static/app_icon/tiktok.png',
            name: 'One Click TikTok Pixel'
        },
        's_shopify_sticky_add_to_cart': {
            src: '/s_base/static/app_icon/Sticky-add-to-cart.png',
            name: 'Sticky Add To Cart'
        },
        's_shopify_whatsapp': {
            src: '/s_base/static/app_icon/whatsapp.png',
            name: 'WhatsApp Chat & Notifications+'
        },
        's_oms': {
            src: '/s_base/static/app_icon/oms.png',
            name: 'Order Management System'
        },
    }
    // const {useState} = owl.hooks;
    // var ControlPanel = require('web.ControlPanel');
    var AbstractView = require('web.AbstractView')
    var core = require('web.core');
    var qweb = core.qweb;



    AbstractView.include({
        init: function (viewInfo, params) {
            this._super.apply(this, arguments)
            if (!session.is_admin) {
                this._render_app_header()
            }
        },
        _render_app_header: function () {
            var self = this;
            var src = '/s_base/static/app_icon/mas.png'
            var app_name = 'MAS'
            // Lay ten app vaf icon tu xml string, name
            // VD <form string="Products Bundles" name="s_shopify_bundle">
            // <tree string="Products Bundles" name="s_shopify_bundle">
            if (typeof this.arch != 'undefined' && typeof this.arch.attrs.string != 'undefined' && this.arch.attrs.string != '') {
                app_name = this.arch.attrs.string
            }
            if (typeof this.arch != 'undefined' && typeof this.arch.attrs.name != 'undefined' && this.arch.attrs.name != '') {
                if (this.arch.attrs.name in SOURCE){
                    src = SOURCE[this.arch.attrs.name]['src']
                }
            }
            var $appHeader = $(qweb.render('s_base.app_title', {src: src, name: app_name}));
            $appHeader.find('.o_mobile_menu_toggle').on('click', self._mobile_toggle_menu.bind(self));
            if ($('.s_form_header').length > 0) {
                $('.s_form_header').remove()
            }
            $appHeader.insertAfter($('.o_main_navbar'))
        },

        _mobile_toggle_menu: function () {
            if (!($('.s-modal-backdrop').length > 0)) {
                var $modal = $('<div class="s-modal-backdrop s-modal show"/>');
                $modal.appendTo($('body'))
            }
            $('.s-modal').on('click', function () {
                $('.o_menu_sections').addClass('s-sm-none')
                $('.s-modal').hide()
            });
            // $('body').bind("keypress", function (ev) {
            //     console.log(ev.key)
            //     if (ev.key === "Escape") {
            //         // Close my modal window
            //          $('.o_menu_sections').addClass('s-sm-none')
            //          $('.s-modal').hide()
            //     }
            // });
            $(window).on('resize', function () {
                if ($(this).width() > 768) {
                    $('.s-modal').hide()
                }
            });
            if ($('.o_menu_sections').hasClass('s-sm-none')) {
                $('.o_menu_sections').removeClass('s-sm-none');
                $('.s-modal').show()
            } else {
                $('.o_menu_sections').addClass('s-sm-none');
                $('.s-modal').hide()
            }

        }

    })

});

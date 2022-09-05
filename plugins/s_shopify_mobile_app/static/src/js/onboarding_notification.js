odoo.define('s_shopify_mobile_app.notification_onboarding_form', function (require) {
    "use strict";
    var FormController = require('web.FormController');
    var FormView = require('web.FormView');
    var FormRenderer = require('web.FormRenderer');
    var viewRegistry = require('web.view_registry');
    var first_time_draw_iframe_interval;

    function update_generate_iframe_content(data) {
        if ($('#notification_iframe') != undefined) {
            if (data['app_icon_url']){
                var app_icon_url = '<img src="'+data['app_icon_url']+'" style="width: 15px; margin-top: 4px; height: 15px" alt="">\n'
            }else {
                app_icon_url = ''
            }
            if (data['img_url'].includes('NewId')){
                var img_url  = 'data:image/png;base64,' + data['attach_product']
            }else {
                img_url = data['img_url']
            }
            var preview_html =
               '<div class="main">\n' +
                   '<div class="container-preview">\n' +
                    '<div class="content-container">\n' +
                        '<div class="container">\n' +
                            '<div class="header-info">\n' +
                                '<div class="logo-title">\n' +
                                     app_icon_url +
                                '</div>\n' +
                                '<p class="title">'+data['title']+'</p>\n' +
                                '<p class="just-now">Just now</p>\n' +
                            '</div>\n' +
                            '<div class="subtitle-img">\n' +
                                '<div class="content">'+data['message']+'</div>\n' +
                                '<img src="'+img_url+'" alt="img" style="width: 24px; height: 24px; z-index: 3; margin: 95px -70px;">\n' +
                            '</div>\n' +
                        '</div>\n' +
                    '</div>\n' +
                   '</div>\n' +
                '</div>'

            $("#notification_onboarding_iframe").contents().find("#notification_onboarding_content").html(preview_html)
        }
    }

    function re_draw_s_shopify_notification(data) {
        first_time_draw_iframe_interval = setInterval(function () {
            var iframe = document.getElementById('notification_onboarding_iframe');
            if (iframe != undefined) {
                var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (iframeDoc.readyState == 'complete') {
                    if ($("#notification_onboarding_iframe").contents().find("#notification_onboarding_content") != undefined
                        && $("#notification_onboarding_iframe").contents().find("#notification_onboarding_content").length > 0) {
                        clearInterval(first_time_draw_iframe_interval);
                        update_generate_iframe_content(data);
                    }
                }
            }
        }, 100);
    }

    var OurFormController = FormController.extend({
        custom_events: _.extend({}, FormController.prototype.custom_events, {
            Controller: FormController,
            Renderer: FormRenderer,
        }),

        init: function (parent, model, renderer, params) {
            this._super.apply(this, arguments);
        },
        _confirmChange: function (id, fields, e) {
            if (fields.includes('title') || fields.includes('message') || fields.includes('img_url')){
                if (e.name === 'discard_changes' && e.target.reset){
                    var data = this.model.get(e.target.dataPointID).data
                }else {
                    data = this.model.get(this.handle).data
                }
                re_draw_s_shopify_notification(data)
            }
            return this._super.apply(this, arguments);
        },
        _update: function (state, params) {
            var result = this._super.apply(this, arguments)
            re_draw_s_shopify_notification(state.data)
            return result;
        },
    });

    var OurFormView = FormView.extend({
        config: _.extend({}, FormView.prototype.config, {
            Controller: OurFormController,
            Renderer: FormRenderer,
        }),
    });

    viewRegistry.add('notification_onboarding_form', OurFormView);
    return OurFormView
});


odoo.define('s_shopify_mobile_app.app_listing_onboarding_form', function (require) {
    "use strict";
    var FormController = require('web.FormController');
    var FormView = require('web.FormView');
    var FormRenderer = require('web.FormRenderer');
    var viewRegistry = require('web.view_registry');
    var first_time_draw_iframe_interval;

    function update_generate_iframe_content(data) {
        if ($('#app_listing_iframe') != undefined) {
            var app_icon = false
            if (data['app_icon']) {
                if (data['app_icon'].length > 50) {
                    app_icon = 'data:image/png;base64,' + data['app_icon']
                } else {
                    app_icon = data['img_url']
                }
            }
            else {
                app_icon = data['img_url']
            }
            var preview_html =
                '<img src="/s_shopify_mobile_app/static/src/img/app_list.png" alt="" width="300px"/>'
                + '<div class="title-header">'
                + '<p class="title-header-heading">' + data['name'] + '</p>'
                + '<p class="title-header-paragraph">' + data['app_subtitle'] + '</p>' +
                '</div>' +
                '<div>';

            if (app_icon) {
                preview_html += '<img src="' + app_icon + '" alt="img" class="img-header">'
            }
            preview_html += '</div>';
            $("#app_listing_onboarding_iframe").contents().find("#app_listing_onboarding_content").html(preview_html);
        }
    }

    function re_draw_s_shopify_app_listing(data) {
        first_time_draw_iframe_interval = setInterval(function () {
            var iframe = document.getElementById('app_listing_onboarding_iframe');
            if (iframe != undefined) {
                var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (iframeDoc.readyState == 'complete') {
                    if ($("#app_listing_onboarding_iframe").contents().find("#app_listing_onboarding_content") != undefined
                        && $("#app_listing_onboarding_iframe").contents().find("#app_listing_onboarding_content").length > 0) {
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
            if (e.name === 'discard_changes' && e.target.reset) {
                var data = this.model.get(e.target.dataPointID).data
            } else {
                data = this.model.get(this.handle).data
            }
            re_draw_s_shopify_app_listing(data);
            return this._super.apply(this, arguments);
        },
        _update: function (state, params) {
            var result = this._super.apply(this, arguments);
            re_draw_s_shopify_app_listing(state.data);
            return result;
        },
    });

    var OurFormView = FormView.extend({
        config: _.extend({}, FormView.prototype.config, {
            Controller: OurFormController,
            Renderer: FormRenderer,
        }),
    });

    viewRegistry.add('app_listing_onboarding_form', OurFormView);
    return OurFormView;
});


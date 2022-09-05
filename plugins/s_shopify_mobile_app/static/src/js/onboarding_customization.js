odoo.define('s_shopify_mobile_app.customization_onboarding_form', function (require) {
    "use strict";
    var FormController = require('web.FormController');
    var FormView = require('web.FormView');
    var FormRenderer = require('web.FormRenderer');
    var viewRegistry = require('web.view_registry');
    var first_time_draw_iframe_interval;

    function update_generate_iframe_content(data) {
        if ($('#customization_iframe') != undefined) {
            var color_primary = data['primary_color'];
            var color_secondary = data['secondary_color'];
            var menu = ''
            var menu_data = data['menu_list_ids']['data']
            if (menu_data.length > 0) {
                menu_data.sort(function (a, b) {
                    return a['data']['sequence'] - b['data']['sequence']
                });
                for (var i = 0; i < menu_data.length; i++) {
                    if (menu_data[i]['data']['menu_type_id'] && menu_data[i]['data']['svg_img'] && typeof (menu_data[i]['data']['menu_type_id']['data']['display_name']) != "undefined") {
                        var svg_img = menu_data[i]['data']['svg_img'];
                        var name_menu = menu_data[i]['data']['title'];
                        var res = svg_img.replace(/stroke="#999"/g, 'stroke=' + color_primary);
                        if (i === 2) {
                            res = svg_img.replace(/stroke="#999"/g, 'stroke=' + color_secondary);
                            menu += '<li class="footer-icon-memu">' + res + '<p class="footer-icon-content" style="color:' + color_secondary + '">' + name_menu + '</p></li>'
                        } else {
                            menu += '<li class="footer-icon-memu">' + res + '<p class="footer-icon-content" style="color:' + color_primary + '">' + name_menu + '</p></li>'
                        }
                    }
                }
            }
            var preview_html =
                '<section style="margin-left:-8px; max-width: 585px;">\n' +
                '                    <div class="footer-container">\n' +
                '                        <div class="footer-icon">\n' +
                '                            <ul class="icon-content">\n' +
                menu +
                '                            </ul>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </section>'
            $("#customization_onboarding_iframe").contents().find("#customization_onboarding_content").html(preview_html)
        }
    }

    function re_draw_s_shopify_customization(data) {
        first_time_draw_iframe_interval = setInterval(function () {
            var iframe = document.getElementById('customization_onboarding_iframe');
            if (iframe != undefined) {
                var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (iframeDoc.readyState == 'complete') {
                    if ($("#customization_onboarding_iframe").contents().find("#customization_onboarding_content") != undefined
                        && $("#customization_onboarding_iframe").contents().find("#customization_onboarding_content").length > 0) {
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
            re_draw_s_shopify_customization(data)
            return this._super.apply(this, arguments);
        },
        _update: function (state, params) {
            var result = this._super.apply(this, arguments)
            re_draw_s_shopify_customization(state.data)
            return result;
        },
    });

    var OurFormView = FormView.extend({
        config: _.extend({}, FormView.prototype.config, {
            Controller: OurFormController,
            Renderer: FormRenderer,
        }),
    });

    viewRegistry.add('customization_onboarding_form', OurFormView);
    return OurFormView
});


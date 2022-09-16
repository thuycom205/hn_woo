if (!window.is_hulk_load_js) {
    window.is_hulk_load_js = !0;
    var checkout_selectors = "input[name='checkout']:not(.hulkapps-ignore), input[value='Checkout']:not(.hulkapps-ignore), button[name='checkout']:not(.hulkapps-ignore), [href$='checkout']:not(.hulkapps-ignore), button[value='Checkout']:not(.hulkapps-ignore), input[name='goto_pp'], button[name='goto_pp'], input[name='goto_gc'], button[name='goto_gc'],.hulkapps_checkout";
    window.hulkLoadScript = function(t, i) {
        var e = document.createElement("script");
        e.type = "text/javascript",
            e.readyState ? e.onreadystatechange = function() {
                    "loaded" != e.readyState && "complete" != e.readyState || (e.onreadystatechange = null,
                        i())
                }
                : e.onload = function() {
                    i()
                }
            ,
            e.src = t,
            document.getElementsByTagName("head")[0].appendChild(e)
    }
        ,
        window.checkAppInstalled = function(t) {
            window.hulkapps.is_product_option = !0,
                hulkLoadScript("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js", function() {
                    commonJS(t),
                        cartPageJS(t),
                        productPageJS(t)
                })
        }
        ,
        window.commonJS = function(t) {
            function i(t) {
                var i, e;
                XMLHttpRequest.callbacks ? XMLHttpRequest.callbacks.push(t) : (XMLHttpRequest.callbacks = [t],
                        i = XMLHttpRequest.prototype.send,
                        XMLHttpRequest.prototype.send = function() {
                            if (XMLHttpRequest.callbacks)
                                for (e = 0; e < XMLHttpRequest.callbacks.length; e++)
                                    XMLHttpRequest.callbacks[e](this);
                            i.apply(this, arguments)
                        }
                )
            }
            window.getCartInfo(),
                window.fetch = new Proxy(window.fetch,{
                    apply(t, i, e) {
                        const a = t.apply(i, e);
                        return a.then(t=>{
                                var i = window.hulkappsParseURL(e[0])
                                    , a = !1;
                                ["/cart/change", "/cart/clear", "/cart/update", "/cart/add"].forEach(async function(i) {
                                    if (e[0] && e[0].includes(i)) {
                                        a = !0;
                                        var o = await t.clone().json();
                                        e[0].includes("/cart/add") && (o = undefined),
                                            window.getCartInfo(0, o)
                                    }
                                }),
                                !a && i && i.query && (i.query.get("section_id") && i.query.get("section_id").includes("cart") ? (a = !0,
                                    window.getCartInfo()) : i.query.get("view") && i.path.includes("/cart") && !i.path.includes("/cart.js") && (a = !0,
                                    window.getCartInfo())),
                                a || i && "/cart" === i.path && window.getCartInfo()
                            }
                        )["catch"](()=>{}
                        ),
                            a
                    }
                }),
                i(function(t) {
                    var i = !1
                        , e = window.hulkappsParseURL(t._url);
                    let a = ["/cart/change", "/cart/clear", "/cart/update", "/cart/add"];
                    var o = !1;
                    const n = function() {
                        t.readyState === XMLHttpRequest.DONE && (o = !0,
                            a.forEach(function(e) {
                                if (t._url && t._url.includes(e)) {
                                    i = !0;
                                    var a = t.status;
                                    if (0 === a || a >= 200 && a < 400) {
                                        var o = JSON.parse(t.response);
                                        t._url.includes("/cart/add") && (o = undefined),
                                            window.getCartInfo(0, o)
                                    }
                                }
                            }),
                        !i && e && e.query && (e.query.get("section_id") && e.query.get("section_id").includes("cart") ? (i = !0,
                            window.getCartInfo()) : e.query.get("view") && e.path.includes("/cart") && !e.path.includes("/cart.js") && (i = !0,
                            window.getCartInfo())),
                        i || e && "/cart" === e.path && window.getCartInfo())
                    }
                        , p = setInterval(function() {
                        o || (n(),
                            o = !0),
                        o && clearInterval(p)
                    }, 1e3)
                }),
                function(t) {
                    !function() {
                        "use strict";
                        Document.prototype._hulkappsAddEventListener = Document.prototype.addEventListener,
                            Document.prototype._hulkappsRemoveEventListener = Document.prototype.removeEventListener,
                            Document.prototype._hulkappsAddEventListener = function(t, i, e=!1) {
                                this._hulkappsAddEventListener(t, i, e),
                                this.hulkappsEventListenerList || (this.hulkappsEventListenerList = {}),
                                this.hulkappsEventListenerList[t] || (this.hulkappsEventListenerList[t] = []),
                                    this.hulkappsEventListenerList[t].push({
                                        type: t,
                                        listener: i,
                                        useCapture: e
                                    })
                            }
                            ,
                            Document.prototype._hulkappsRemoveEventListener = function(t, i, e=!1) {
                                this._hulkappsRemoveEventListener(t, i, e),
                                this.hulkappsEventListenerList || (this.hulkappsEventListenerList = {}),
                                this.hulkappsEventListenerList[t] || (this.hulkappsEventListenerList[t] = []);
                                for (let a = 0; a < this.hulkappsEventListenerList[t].length; a++)
                                    if (this.hulkappsEventListenerList[t][a].listener === i && this.hulkappsEventListenerList[t][a].useCapture === e) {
                                        this.hulkappsEventListenerList[t].splice(a, 1);
                                        break
                                    }
                                0 == this.hulkappsEventListenerList[t].length && delete this.hulkappsEventListenerList[t]
                            }
                            ,
                            Document.prototype.hulkappsGetEventListeners = function(t) {
                                return this.hulkappsEventListenerList || (this.hulkappsEventListenerList = {}),
                                    t === undefined ? this.hulkappsEventListenerList : this.hulkappsEventListenerList[t]
                            }
                    }(),
                        t("body").on("click", ".edit_cart_option", function(i) {
                            i.preventDefault();
                            var e = t(this).data("key")
                                , a = window.hulkapps.cart
                                , o = window.hulkapps.store_id
                                , n = t(this).data("product_id")
                                , p = t(this).data("variant_id");
                            t("[name^='properties']").each(function() {
                                "" == t(this).val() && t(this).attr("disabled", !0)
                            });
                            var s = t(this);
                            t.ajax({
                                type: "POST",
                                url: window.hulkapps.po_url + "/api/v2/store/edit_cart_extension",
                                data: {
                                    cart_data: a,
                                    item_key: e,
                                    store_id: o,
                                    variant_id: p,
                                    customer_tags: null != window.hulkapps.customer ? window.hulkapps.customer.tags.split(",") : ""
                                },
                                cache: !1,
                                crossDomain: !0,
                                success: function(i) {
                                    if ("ok" == i)
                                        location.reload();
                                    else {
                                        window.currentEditOptionSelector = s,
                                            t("body").addClass("body_fixed"),
                                            t("#edit_cart_popup").last().html(i),
                                            t(".edit_popup").appendTo("body"),
                                            t(".edit_popup").show(),
                                        "undefined" != typeof jQuery && jQuery(document).off("focusin");
                                        const e = document.hulkappsGetEventListeners("focusin");
                                        if (e)
                                            for (let t in e)
                                                document.removeEventListener("focusin", e[t].listener);
                                        calc_options_total(n, "hulkapps_edit_product_options"),
                                            conditional_rules(n, "hulkapps_edit_product_options")
                                    }
                                }
                            })
                        })
                }(hulkapps_jQuery),
                window.hulkDraftOrder = function() {
                    return window.is_draft_order
                }
                ,
                window.hulkappsDoActions = function(i) {
                    i.discounts.discount_show && t(".discount_code_box").css("display", "block"),
                    i.discounts.plan && t(".edit_cart_option").css("display", "block"),
                    "object" == typeof i.discounts && "object" == typeof i.discounts.cart && "object" == typeof i.discounts.cart.items && hulkappsShowCartDiscounts(i.discounts),
                    i.discounts.is_draft_order && t(document).on("click", checkout_selectors, function(t) {
                        if (t.preventDefault(),
                        "function" != typeof hulkappsCheckout && (window.location = "/checkout"),
                        "undefined" == typeof hulkappsCheckoutClick)
                            hulkappsCheckout(null);
                        else {
                            var i = hulkappsCheckoutClick();
                            1 == i.required ? hulkappsCheckout(i) : 0 != i.required && hulkappsCheckout(i)
                        }
                    })
                }
                ,
                window.hulkappsShowCartDiscounts = function(i) {
                    window.hulkapps.discounts = i,
                        i.cart.items.forEach(function(i) {
                            t(".hulkapps-cart-item-price[data-key='" + i.key + "']").html(i.original_price_format),
                                t(".hulkapps-cart-item-line-price[data-key='" + i.key + "']").html(i.original_line_price_format),
                                t("[data-hulkapps-line-price][data-key='" + i.key + "']").html(i.original_line_price_format),
                                t("[data-hulkapps-ci-price][data-key='" + i.key + "']").html(i.original_price_format)
                        });
                    var e = parseFloat(i.discount_cut_price);
                    i.discount_code && 1 == i.discount_error ? (t("[data-hulkapps-cart-total]").html(i.original_price_total),
                        hulkapps_jQuery(".hulkapps_summary").remove(),
                        t(".hulkapps_discount_hide").after("<span class='hulkapps_summary'>Discount code does not match</span>"),
                        localStorage.removeItem("discount_code"),
                        t("[data-hulkapps-cart-total]").html(i.original_price_total),
                        t("[data-hulkapps-cart-total]").css("text-decoration", "none"),
                        t(".hulkapps-summary-line-discount-code").html(""),
                        t(".after_discount_price").html("")) : i.is_free_shipping ? (t(".hulkapps_summary").remove(),
                        t("[data-hulkapps-cart-total]").html(i.original_price_total),
                        t("[data-hulkapps-cart-total]").css("text-decoration", "none"),
                        t(".hulkapps-summary-line-discount-code").html(""),
                        t(".after_discount_price").html(""),
                        t(".hulkapps_discount_hide").after("<span class='hulkapps-summary-line-discount-code'><span class='discount-tag'>" + i.discount_code + "<span class='close-tag'></span></span>Free Shipping")) : i.discount_code && e <= 0 && t(".discount_code_box").is(":visible") ? (t("[data-hulkapps-cart-total]").html(i.original_price_total),
                        t(".hulkapps_discount_hide").after("<span class='hulkapps_summary'>" + i.discount_code + " discount code isn\u2019t valid for the items in your cart</span>"),
                        t(".hulkapps_discount_code").val(""),
                        t("[data-hulkapps-cart-total]").html(i.original_price_total),
                        t("[data-hulkapps-cart-total]").css("text-decoration", "none"),
                        t(".hulkapps-summary-line-discount-code").html(""),
                        t(".after_discount_price").html(""),
                        localStorage.removeItem("discount_code")) : i.discount_code && t(".discount_code_box").is(":visible") ? (t(".discount_code_box").find(".hulkapps_summary").html(""),
                        t(".hulkapps-summary-line-discount-code,.after_discount_price").remove(),
                        t(".hulkapps_discount_hide").after("<span class='hulkapps-summary-line-discount-code'><span class='discount-tag'>" + i.discount_code + "<span class='close-tag'></span></span><span class='hulkapps_with_discount'> -" + i.with_discount + "</span></span><span class='after_discount_price'><span class='final-total'>Total</span>" + i.final_with_discounted_price + "</span>"),
                        t("[data-hulkapps-cart-total]").html(i.original_price_total),
                    i.original_price_total != i.final_with_discounted_price && t("[data-hulkapps-cart-total]").css("text-decoration", "line-through"),
                        t(".hulkapps-cart-total").remove()) : (t("[data-hulkapps-cart-total]").html(i.original_price_total),
                        t("[data-hulkapps-cart-total]").css("text-decoration", "none"),
                        t(".hulkapps-summary-line-discount-code").html(""),
                        t(".after_discount_price").html(""),
                        t(".discount_code_box").find(".hulkapps_summary").html(""))
                }
                ,
                window.hulkappsCheckout = function(i) {
                    var e = {};
                    null != i && 1 == i.shipping_status && (e = {
                        price: i.shipping_price,
                        title: i.shipping_method
                    });
                    var a = localStorage.getItem("discount_code");
                    t.getJSON("/cart.js", {
                        _: (new Date).getTime()
                    }, function(i) {
                        i && i.item_count > 0 && (window.hulkapps.cart = i,
                            t.ajax({
                                type: "POST",
                                url: window.hulkapps.po_url + "/store/create_draft_order",
                                data: {
                                    cart_json: window.hulkapps,
                                    store_id: window.hulkapps.store_id,
                                    discount_code: a,
                                    cart_collections: JSON.stringify(window.hulkapps.cart_collections),
                                    order_app: e,
                                    customer_tags: null != window.hulkapps.customer ? window.hulkapps.customer.tags.split(",") : ""
                                },
                                crossDomain: !0,
                                success: function(t) {
                                    window.location.href = "string" == typeof t ? t : "/checkout",
                                        localStorage.removeItem("discount_code")
                                }
                            }))
                    })
                }
                ,
                window.hulkappsStart = function(t) {
                    window.$first_add_to_cart_el = null;
                    var i = ["input[name='add']", "button[name='add']", "#add-to-cart", "#AddToCartText", "#AddToCart", 'form[action="/cart/add"] :input[type="submit"]']
                        , e = 0;
                    if (i.forEach(function(i) {
                        e += t(i).length,
                        null == window.$first_add_to_cart_el && e && (window.$first_add_to_cart_el = t(i).first())
                    }),
                    window.$first_add_to_cart_el && (window.$first_add_to_cart_el.attr("disabled", !0),
                        setTimeout(function() {
                            window.$first_add_to_cart_el.removeAttr("disabled")
                        }, 2500)),
                    "product" == window.hulkapps.page_type && null != window.$first_add_to_cart_el) {
                        var a = window.$first_add_to_cart_el;
                        a.parent().is("div") && (a = a.parent()),
                        0 == t("#hulkapps_custom_options_" + window.hulkapps.product_id).length && a.before('<div id="hulkapps_custom_options_' + window.hulkapps.product_id + '"></div>')
                    }
                    "product" == window.hulkapps.page_type && window.hulkapps.product_id && window.hulkapps.store_id && t.ajax({
                        type: "GET",
                        url: window.hulkapps.po_url + "/api/v2/store/get_all_relationships",
                        data: {
                            pid: window.hulkapps.product_id,
                            store_id: window.hulkapps.store_id,
                            tags: window.hulkapps.product.tags,
                            vendor: window.hulkapps.product.vendor,
                            ptype: window.hulkapps.product.type,
                            customer_tags: null != window.hulkapps.customer ? window.hulkapps.customer.tags.split(",") : ""
                        },
                        sync: !1,
                        crossDomain: !0,
                        success: function(a) {
                            if (window.$first_add_to_cart_el && window.$first_add_to_cart_el.removeAttr("disabled"),
                            "string" != t.type(a)) {
                                var o = "";
                                let R = {};
                                if (a.condition != undefined) {
                                    o += "<div id='conditional_rules' style='display:none'>";
                                    t.each(a.condition, function(i, e) {
                                        var n = e.id
                                            , p = hulkapps_jQuery.parseJSON(e.conditions);
                                        if ("OR" == p.apply_rule)
                                            var s = "0";
                                        else
                                            s = "1";
                                        o = o + "<div id='conditional_logic_" + n + "' name='conditional_logic_" + n + "' data-verify-all='" + s + "' style='display:none'>",
                                            t.each(p.rules, function(t, i) {
                                                var e = parseInt(i.option);
                                                if (a.option_id_array.indexOf(e) >= 0) {
                                                    if (1 == parseInt(i.rule_type))
                                                        var p = "==";
                                                    else
                                                        p = "!=";
                                                    o = o + "<div name='conditional_logic_" + n + "' data-field-num='" + e + "' data-verify-all='" + s + "' class='step_1'>**value11**" + p + i.option_val + "</div>"
                                                }
                                            }),
                                            o += "</div>";
                                        let l = [];
                                        t.each(p.actions, function(t, i) {
                                            var e = parseInt(i.option);
                                            if (l.push(e),
                                            a.option_id_array.indexOf(e) >= 0) {
                                                if (1 == parseInt(i.action_type))
                                                    var o = "show";
                                                else
                                                    o = "hide";
                                                " conditional_logic_" + n + "_" + o;
                                                var p = "condition_" + o + " conditional";
                                                a.hide_show_array[e] = p
                                            }
                                        }),
                                            R[n] = l
                                    }),
                                        o += "</div>"
                                }
                                var n = 0 != a.options_title.title_text.length ? a.options_title.title_text : "Choose Your Product Options:"
                                    , p = ".hulkapps_option_title{";
                                p += 0 != a.options_title.title_padding.length ? "padding: " + a.options_title.title_padding + "px;" : "padding: 15px;",
                                    p += 0 != a.options_title.title_font_size.length ? "font-size: " + a.options_title.title_font_size + "px;" : "font-size: 16px;",
                                    p += 0 != a.options_title.title_text_align.length ? "text-align: " + a.options_title.title_text_align + ";" : "text-align: left;",
                                    p += 0 != a.options_title.title_background.length ? "background-color: " + a.options_title.title_background + ";" : "background-color: #ffffff;",
                                    p += 0 != a.options_title.title_border.length ? "border: 1px solid " + a.options_title.title_border + ";" : "border: 1px solid #000000;",
                                    p += 0 != a.options_title.title_font_color.length ? "color: " + a.options_title.title_font_color + ";" : "color:#000000;",
                                    p += 1 == parseInt(a.options_title.title_bold) ? "font-weight:bold;" : "font-weight:normal;",
                                    p += 1 == parseInt(a.options_title.title_display) ? "" : "display:none;",
                                    p += "border-bottom: none;",
                                    p += "}";
                                a.options_container_style.enable_tooltip;
                                var s = a.options_container_style.enable_helptext
                                    , l = "#hulkapps_option_list_" + a.pid + "{";
                                l += 0 != a.options_container_style.background_color.length ? "background-color: " + a.options_container_style.background_color + ";" : "background-color: #fff;",
                                    l += 0 != a.options_container_style.border_color.length ? "border: 1px solid " + a.options_container_style.border_color + ";" : "border: 0 none;",
                                    l += 0 != a.options_container_style.padding.length ? "padding: " + a.options_container_style.padding + "px;" : "padding: 10px;",
                                    l += "}.hulkapps_option {width: 100%;display: block;",
                                    l += 0 != a.options_container_style.spacing_between_options.length ? "padding-bottom: #{@spacing_between_options}px;margin-bottom: " + a.options_container_style.spacing_between_options + "px;" : "padding-bottom: 6px;margin-bottom: 6px;",
                                    l += 0 != a.options_container_style.line_between_options.length ? "border-bottom: 1px solid " + a.options_container_style.line_between_options + ";" : "",
                                    l += "}";
                                var r = a.options_name_style.option_name_inline
                                    , d = ".hulkapps_option_name {";
                                d += 0 != a.options_name_style.option_name_width.length ? "width: " + a.options_name_style.option_name_width + "px;" : "width: 180px;",
                                    d += 0 != a.options_name_style.option_name_font_size.length ? "font-size: " + a.options_name_style.option_name_font_size + "px;" : "font-size: 14px;",
                                    d += 0 != a.options_name_style.option_name_text_align.length ? "text-align: " + a.options_name_style.option_name_text_align + ";" : "text-align: left;",
                                    d += 0 != a.options_name_style.font_color.length ? "color: " + a.options_name_style.font_color + ";" : "color: #424242;",
                                    d = (d += 1 == parseInt(a.options_name_style.on_title_bold) ? "font-weight: bold;" : "font-weight: normal;") + "display: table-cell;min-width: " + a.options_name_style.option_name_width + "px;padding-right: 15px;box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;-ms-box-sizing: border-box;vertical-align: top;}";
                                a.option_values_style.ov_padding,
                                    a.option_values_style.ov_width,
                                    a.option_values_style.spacing_left_of_values;
                                var _ = a.option_values_style.single_line
                                    , c = ".hulkapps_option_value {";
                                c += "width:100%;min-width: 100%;text-align: left;display: table-cell;vertical-align: top;}",
                                    c += ".hulkapps_option .hulkapps_option_value, .pn_render .hulkapps_option_child, .et_render .hulkapps_option_child, .tb_render .hulkapps_option_child, .ta_render .hulkapps_option_child, .fu_render .hulkapps_option_child, .dd_render .hulkapps_option_child, .dd_multi_render .hulkapps_option_child, .nf_render .hulkapps_option_child, .dp_render .hulkapps_option_child{",
                                    c += 0 != a.option_values_style.ov_font_size.length ? "font-size: " + a.option_values_style.ov_font_size + "px !important;" : "",
                                    c += 0 != a.option_values_style.ov_font_color.length ? "color: " + a.option_values_style.ov_font_color + " !important;" : "",
                                    c += a.option_values_style.ov_font_weight != undefined ? "font-weight:bold;" : "font-weight:normal;",
                                    c += a.option_values_style.ov_text_align != undefined ? "text-align: " + a.option_values_style.ov_text_align + " !important;" : "",
                                    c += "}";
                                var u = a.advanced_users.custom_js
                                    , h = a.advanced_users.custom_css
                                    , f = parseInt(a.swatch_settings.swatch_width)
                                    , v = parseInt(a.swatch_settings.swatch_height)
                                    , m = a.swatch_settings.tooltip_position
                                    , k = a.swatch_settings.tooltip_contains
                                    , y = parseInt(a.swatch_settings.tooltip_display)
                                    , g = parseInt(a.swatch_settings.round_corners)
                                    , $ = parseInt(a.swatch_settings.enable_swatch_images)
                                    , b = parseInt(a.swatch_settings.enable_swatch_with_text)
                                    , w = (f = "" == f || f < 0 ? "width:35px;" : "width:" + f + "px;",
                                    v = "" == v || v < 0 ? "height:35px;" : "height:" + v + "px;",
                                    m = "top" == m ? "top" : "bottom",
                                    g = 1 == g ? "-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;" : "",
                                    0 != a.button_option_settings.button_option_background.length ? "background-color: " + a.button_option_settings.button_option_background + ";" : "")
                                    , x = 0 != a.button_option_settings.button_option_font_color.length ? "color: " + a.button_option_settings.button_option_font_color + ";" : ""
                                    , C = 0 != a.button_option_settings.button_option_border_color.length ? "border-color: " + a.button_option_settings.button_option_border_color + ";" : ""
                                    , j = a.premium_option_settings.update_total_text
                                    , I = a.premium_option_settings.amount_note_display == undefined ? 1 : a.premium_option_settings.amount_note_display
                                    , S = a.premium_option_settings.post_total_text
                                    , L = a.premium_option_settings.total_container_background_color
                                    , P = a.premium_option_settings.total_container_border_color
                                    , E = a.premium_option_settings.total_container_font_color
                                    , q = a.premium_option_settings.total_container_price_color
                                    , O = "#option_total {";
                                O += "" !== L ? "background: none repeat scroll 0 0 " + L + ";" : "background: none repeat scroll 0 0 #fff;",
                                    O += "" !== P ? "border:1px solid " + P + ";" : "border:1px solid #000000;",
                                    O += "" !== E ? "color: " + E + ";" : "color: #000;",
                                    O += "}#formatted_option_total {",
                                    O += "" !== q ? "color: " + q + ";" : "color: #000;",
                                    O += "}";
                                var Q = 0 == parseInt(_) ? "0px" : "10px"
                                    , D = p + l + d + c + O + ("#hulkapps_custom_options_" + a.pid + "{clear: both}#hulkapps_options_" + a.pid + "{margin:15px 0;}#hulkapps_option_list_" + a.pid + " select{width:100%;padding-top: 12px;padding-bottom: 12px}.popup_detail{position: fixed;background-color: #F7F7F7;padding: 15px;top: 50%;left: 50%;transform: translate(-50%, -50%);justify-content: space-between;z-index: 3;min-width: 300px;max-width: fit-content;overflow-y: auto;max-height: 300px;}.popup_detail a{cursor: pointer;}.popup_detail img{width: 15px;height: 15px;margin: 5px;}.popup_detail p{margin:0;}.overlay-popup{position: fixed;display: none;width: 100%;height: 100%;top: 0;left: 0;bottom: 0;background-color: rgba(0,0,0,0.5);z-index: 2;}.popup_render{margin-bottom:0!important;display:flex;align-items:center!important}.popup_render .hulkapps_option_value{min-width:auto!important}.popup_render a{text-decoration:underline!important;transition:all .3s!important;font-weight: normal !important;}.popup_render a:hover{color:#6e6e6e}.cut-popup-icon{display:flex;align-items:center}.cut-popup-icon-span{display:flex}.des-detail{font-weight: normal;}#hulkapps_option_list_" + a.pid + " input[type='text']{width:100%;border-radius:0}#hulkapps_option_list_" + a.pid + " input,#hulkapps_option_list_" + a.pid + " textarea,#hulkapps_option_list_" + a.pid + " select{border:1px solid #ddd;box-shadow: none;-webkit-appearance: none;padding: 6px 10px;min-height: 36px;}#hulkapps_option_list_" + a.pid + " .validation_error{color:#FF0808;background-color:#FFF8F7;border-style:solid;border-width:1px;border-color:#FFCBC9;border-bottom: 1px solid #ffcbc9 !important;padding: 2px 6px;display: inline-block;margin-top: 2px;}#hulkapps_option_list_" + a.pid + " .validation_error .hulkapps_option_value{color:#FF0808}#hulkapps_option_list_" + a.pid + " .validation_error .hulkapps_option_name{color:#FF0808}.hulkapps_option_value:first-child{display:flex;align-items: center;} .hulkapps_option_value:first-child span{display: flex;padding-right: 10px;}.hulkapps_option_value:first-child a{cursor: pointer;} .hulkapps_helptext{color: #000 !important;}.conditional{display:none !important}.hulkapps_full_width{width:100%;font-size:16px !important;padding:5px;display:block;}.hulkapps_check_option,.hulkapps_radio_option{display:block;margin-right:0;font-weight:normal !important;}.single_line .hulkapps_option_value .hulkapps_check_option,.single_line .hulkapps_option_value .hulkapps_radio_option{display:inline-flex !important;margin-right:20px;font-weight:normal; align-items: center; }#hulkapps_option_list_" + a.pid + " input[type='checkbox']{margin-right: 5px;vertical-align: baseline;min-height:auto; height: auto;display: inline-block !important;-webkit-appearance: checkbox;-moz-appearance: checkbox;appearance: checkbox;}.hulkapps_check_option input[type='checkbox']{margin-right:5px;}#hulkapps_option_list_" + a.pid + " input[type='radio']{margin-right:5px;vertical-align:baseline;display: none;}i.hulkapps_tooltip_identifier{color:rgb(255, 255, 255);border-radius:12px;font-size:10px;margin-right:6px;margin-left:4px;padding:0px 4px;background:#000000}span.hulkapps_option_name_additional_info{position:relative}span.hulkapps_option_name_additional_info .hulkapps_tool_tip{display:none}span.hulkapps_option_name_additional_info:hover .hulkapps_tool_tip{content:attr(data-additional-info);padding:4px 8px;color:#fff;position:absolute;left:0;bottom:160%;z-index:20px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;display:block;background:#000000;width:150px}span.hulkapps_option_name_additional_info:hover:after{display:block}i.hulkapps_tooltip_identifier:before{content:'?';font-style:normal}#formatted_option_total{font-weight:bold;margin:0 7px}.td_render .hulkapps_option_name.full_name{float:none;width:auto}.hulkapps_option.full_width .hulkapps_option_name,.hulkapps_option.full_width .hulkapps_option_value{width:100%;display:block;}.hulkapps_option.full_width .hulkapps_option_name{padding-bottom:5px}.hulkapps_option:after{content:'';clear:both;display:block}.hulkapps_option_name a:link {color: grey;text-decoration: none;font-weight: normal;}.hulkapps_option_name a:hover {color: rgb(93, 156, 236);background: transparent;}.hulkapps_swatch_option .hulkapps_option_child{border: 2px solid #ccc;cursor: pointer;}.hulkapps_mswatch_option .hulkapps_option_child{border: 2px solid #ccc;cursor: pointer;}.hulkapps_swatch_option .swatch_selected,.button_selected{border: 2px solid #00a9a2;}.hulkapps_radio_option .radio_selected{border: 2px solid #0090FA;background:#0090FA;color:#fff;}.radio_div{border: 2px solid #eee;padding: 8px 20px;padding: 6px 12px;}.radio_div:hover{border: 2px solid #0090FA;cursor:pointer;}.tooltip.in{opacity:1 !important;}#option_display_total_format{padding-left:5px;}.hulkapps_swatch_option .tooltip-inner{padding: 0px 5px !important;}.hulkapps_check_option,.hulkapps_radio_option{margin-right:" + Q + "}.hulkapps_swatch_option,.hulkapps_mswatch_option{ margin-right:10px !important; display: inline-block !important;vertical-align: middle;}.hulkapps-tooltip.tooltip-left-pos .hulkapps-tooltip-inner.swatch-tooltip{left: 0 !important;right: auto !important;}.hulkapps-tooltip.tooltip-left-pos .hulkapps-tooltip-inner.swatch-tooltip:after{right: auto !important;left: 10px !important;}.hulkapps-tooltip.tooltip-right-pos .hulkapps-tooltip-inner.swatch-tooltip{right: 0 !important;left: auto !important;}.hulkapps-tooltip.tooltip-right-pos .hulkapps-tooltip-inner.swatch-tooltip:after{left: auto !important;right: 10px !important;}.hulkapps-tooltip.tooltip-center-pos .hulkapps-tooltip-inner.swatch-tooltip{left: 50% !important;transform: translateX(-50%);}.hulkapps-tooltip.tooltip-center-pos .hulkapps-tooltip-inner.swatch-tooltip:after{left: 50% !important;transform: translateX(-50%);}.phone_number{padding: 6px 10px 6px 50px !important;}#option_total{padding:3px 6px;}.hulkapps_mswatch_option .swatch_selected{border: 2px solid #00a9a2;}.hulkapps-tooltip.tooltip-left-pos .hulkapps-tooltip-inner.multiswatch-tooltip{left: 0 !important;right: auto !important;}.hulkapps-tooltip.tooltip-left-pos .hulkapps-tooltip-inner.multiswatch-tooltip:after{right: auto !important;left: 10px !important;}.hulkapps-tooltip.tooltip-right-pos .hulkapps-tooltip-inner.multiswatch-tooltip{right: 0 !important;left: auto !important;}.hulkapps-tooltip.tooltip-right-pos .hulkapps-tooltip-inner.multiswatch-tooltip:after{left: auto !important;right: 10px !important;}.hulkapps-tooltip.tooltip-center-pos .hulkapps-tooltip-inner.multiswatch-tooltip{left: 50% !important;transform: translateX(-50%);}.hulkapps-tooltip.tooltip-center-pos .hulkapps-tooltip-inner.multiswatch-tooltip:after{left: 50% !important;transform: translateX(-50%);}.hulkapps_swatch_option, .hulkapps_mswatch_option{margin-bottom: 10px !important;}.hulkapps_buton_option .hulkapps_option_child{ width: auto;min-height: 36px;padding: 6px 12px;border:  2px solid;border-radius: 0;font-weight: 500;display: flex;justify-content: center;align-items: center;margin: 2px;}.button_selected {color: #00A9A2 !important;background-color: #fff !important;border-color: #00A9A2 !important;font-weight: 700 !important;}input::placeholder,textarea::placeholder {color: #a9a9a9;font-size: 16px !important;font-weight: 700;font-family: sans-serif;}") + h
                                    , M = (u = "<script>(function($) {$('.hulkapps_swatch_option, .hulkapps_mswatch_option').mouseover(function() {var x = $(this).find('.hulkapps-tooltip ').position();var right = $(window).width() - x.left - $(this).find('.hulkapps-tooltip ').width();if(x.left < 205){$(this).find('.hulkapps-tooltip ').addClass('tooltip-left-pos');}if(right < 160){$(this).find('.hulkapps-tooltip ').addClass('tooltip-right-pos');}});$(window).width()<=768&&$('.hulkapps-tooltip').each(function(){var t=$(this).position(),i=$(window).width()-t.left-$(this).width(),o=t.left-i;o<50&&o>-50?$(this).addClass('tooltip-center-pos'):t.left<i?$(this).addClass('tooltip-left-pos'):i<t.left&&$(this).addClass('tooltip-right-pos')});" + a.advanced_users.custom_js + "}(hulkapps_jQuery))</script>",
                                "<div id='hulkapps_options_" + a.pid + "' class='hulkapps_product_options'>");
                                M = (M = (M = M + "" + o + "<style>" + D + "</style>" + u) + "<div class='hulkapps_option_title'>" + n + "</div>") + "<div id='hulkapps_option_list_" + a.pid + "' >",
                                    "" !== I || 1 == parseInt(I) ? M += "<input type='hidden' id='hulk_amount_dis' value='1'>" : M += "<input type='hidden' id='hulk_amount_dis' value='0'>";
                                a.relationship;
                                var A = "";
                                if (0 != a.relationship_option.length) {
                                    var T = "<span class='hulkapps-required'> * </span>";
                                    M += "<div class='hulkapps_option_set'>",
                                        t.each(a.relationship_option, function(i, e) {
                                            var o = parseInt(e[0]);
                                            let n = [];
                                            for (const [t,i] of Object.entries(R))
                                                i.includes(o) && n.push(t);
                                            var p = e[1];
                                            if (a.option_id_array.indexOf(o) >= 0) {
                                                var l = t.trim(a.option_associative_array[o].option_name)
                                                    , d = t.trim(a.option_associative_array[o].tooltip)
                                                    , c = t.trim(a.option_associative_array[o].helptext)
                                                    , u = t.trim(a.option_associative_array[o].id_name)
                                                    , h = "" != u ? 'id="' + u + '"' : ""
                                                    , j = t.trim(a.option_associative_array[o].class_name)
                                                    , I = t.trim(a.option_associative_array[o].placeholder)
                                                    , S = d.length > 0 ? "<div class='hulkapps-tooltip'><span aria-describedby='tooltip_" + o + "'><img src='" + window.hulkapps.po_url + "/tooltip.svg' style='width:15px;'></span><div class='hulkapps-tooltip-inner' id='tooltip_" + o + "' role='tooltip'>" + d + "</div></div>" : ""
                                                    , L = c.length > 0 ? "<span class='hulkapps_helptext'>" + c + "</span>" : ""
                                                    , P = a.option_associative_array[o].extra_field
                                                    , E = a.option_associative_array[o].option_type
                                                    , q = o
                                                    , O = t.parseJSON(a.option_associative_array[o].values_json)
                                                    , Q = a.hide_show_array[q] ? a.hide_show_array[q] : "";
                                                let i = ""
                                                    , e = "";
                                                n.forEach(o=>{
                                                        t.each(a.condition, function(a, n) {
                                                            let p = n.id;
                                                            var s = hulkapps_jQuery.parseJSON(n.conditions);
                                                            p == o && t.each(s.actions, function(t, a) {
                                                                return 1 == parseInt(a.action_type) && Q.includes("condition_show") ? (i += " conditional_logic_" + o + "_" + (e = "show"),
                                                                    !1) : Q.includes("condition_hide") ? (i += " conditional_logic_" + o + "_" + (e = "hide"),
                                                                    !1) : void 0
                                                            })
                                                        })
                                                    }
                                                );
                                                var D = "required" == p ? "required" : ""
                                                    , M = 0 == parseInt(r) ? "full_width" : ""
                                                    , z = "required" == p ? T : ""
                                                    , F = "1" == a.options_container_style.enable_tooltip ? S : ""
                                                    , N = "1" == s ? "<div>" + L + "</div>" : "";
                                                if ("dropdown" == E)
                                                    V = "<div class='hulkapps_option dd_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id= " + q + ">",
                                                        V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        V += "<select class='hulkapps_option_child hulkapps_option_" + q + "_visible hulkapps_full_width hulkapps_dd' data-option-key='dd_" + q + "' id='" + q + "' name='properties[" + l + "]'>",
                                                        V += "" == I ? "<option value=''>Choose " + l + "</option>" : "<option value=''>" + I + "</option>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = null != e && "" != e ? " [ " + a.currency_symbol + e + " ]" : ""
                                                                , n = null != e && "" != e ? " (+" + a.currency_symbol + e + ")" : ""
                                                                , p = null != e && "" != e ? e : "0.00"
                                                                , s = "undefined" == typeof i[6] == 1 ? i[4] != undefined && ("true" == i[4] || "false" == i[4]) ? i[4] : i[2] : i[4];
                                                            V = V + "<option class='" + ("" != p ? "price-change" : "") + "' " + (1 == s ? "selected" : "") + " data-price='" + p + "' data-conditional-value='" + i[0].toString().trim() + "' value='" + i[0].toString().trim() + o + "'>" + i[0].toString().trim() + n + "</option>"
                                                        }),
                                                        V += "</select><script>(function($) {$(document).on('change','.hulkapps_product_options #hulkapps_option_list_" + a.pid + " #" + q + "', function() {conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "','dd_render','hulkapps_product_options');});}(hulkapps_jQuery))</script></div></div>",
                                                        A += V;
                                                else if ("dropdown_multiple" == E) {
                                                    var J = P != undefined && "" != P && "" != P.minimum_selection && P.minimum_selection != undefined ? P.minimum_selection.toString() : "0"
                                                        , X = P != undefined && "" != P && "" != P.maximum_selection && P.maximum_selection != undefined ? P.maximum_selection.toString() : "0"
                                                        , H = "0" != J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose from " + J + " to " + X + " values]" : "0" != J && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose atleast " + J + " values]" : "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose upto " + X + " values]" : ""
                                                        , V = "<div class='hulkapps_option dd_multi_render " + i + " " + D + " " + M + "  option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>";
                                                    undefined,
                                                        undefined;
                                                    V += "<div class='hulkapps_option_name'><div>" + l + " " + z + " " + F + " </div>" + H + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        V += "<select multiple class='hulkapps_option_child hulkapps_option_" + q + "_visible hulkapps_full_width hulkapps_dd' data-option-key='dd_" + q + "' id='" + q + "' name='hulkapps_multiple_dropdown' style='background:none;' data-min='" + J + "' data-max='" + X + "'>";
                                                    var U = []
                                                        , Y = 0;
                                                    t.each(O, function(t, i) {
                                                        var e = i[1]
                                                            , o = null != e && "" != e ? " [ " + a.currency_symbol + e + " ]" : ""
                                                            , n = null != e && "" != e ? " (+" + a.currency_symbol + e + ")" : ""
                                                            , p = null != e && "" != e ? e : "0.00"
                                                            , s = "undefined" == typeof i[6] == 1 ? i[4] != undefined && ("true" == i[4] || "false" == i[4]) ? i[4] : i[2] : i[4];
                                                        1 == s && (Y += 1,
                                                            U.push(i[0].toString().trim() + o)),
                                                            V = V + "<option class='" + ("" != p ? "price-change" : "") + "' " + (1 == s ? "selected" : "") + " data-price='" + p + "' data-conditional-value='" + i[0].toString().trim() + "' value='" + i[0].toString().trim() + o + "'>" + i[0].toString().trim() + n + "</option>"
                                                    }),
                                                    Y > 0 && ("0" != J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? (parseInt(Y) < parseInt(J) || parseInt(Y) > parseInt(X)) && (V += '</select><span class="validation_error error_span">Choose from ' + J + " to " + X + " values</span>") : "0" != J && "0" == X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? parseInt(Y) < parseInt(J) && (V += '</select><span class="validation_error error_span">Choose atleast ' + J + " values</span>") : "0" == J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && parseInt(Y) > parseInt(X) && (V += '</select><span class="validation_error error_span">Choose upto ' + X + " values</span>"));
                                                    var B = '<span class="validation_error error_span" >';
                                                    V += "<input class='hulkapps_option_child' type='hidden' value='" + U.join(", ") + "' id='hulkapps_option_" + q + "_hidden' name='properties[" + l + "]'><script>(function($) {$(document).on('change','.hulkapps_product_options #hulkapps_option_list_" + a.pid + " #" + q + "', function() {if ((" + J + " != 0) && (" + X + " != 0) && (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + "))) {if ($(this).find('option:selected').length < '" + J + "') {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').find('.hulkapps_option_value #" + q + "').after('" + B + "Choose from " + J + " to " + X + " values</span>');if ($(this).find('option:selected').length == 0) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if ($(this).find('option:selected').length > " + X + ") {$('#" + q + " option:selected:last').prop('selected',false);$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').find('.hulkapps_option_value #" + q + "').after('" + B + "Choose from " + J + " to " + X + " values</span>');if ($(this).find('option:selected').length == '" + X + "') {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + ") && " + J + " != 0) {if ($(this).find('option:selected').length < '" + J + "') {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').find('.hulkapps_option_value #" + q + "').after('" + B + "Choose atleast " + J + " values</span>');} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + ") && " + X + " != 0) {if ('" + X + "' >= $(this).find('option:selected').length) {if ('" + X + "' == $(this).find('option:selected').length) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').find('.hulkapps_option_value #" + q + "').after('" + B + "Choose upto " + X + " values</span>');}} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$('.hulkapps_product_options').find('#" + q + " option:selected:last').prop('selected',false);}} else {$(this).parents('.hulkapps_option').removeClass('validation_error');}var chkMulti = $.map($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible :selected'), function(el, i) {return $(el).val();});$('.hulkapps_product_options').find('#hulkapps_option_" + q + "_hidden').val(chkMulti.join(', '));conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'dd_multi_render','hulkapps_product_options');});}(hulkapps_jQuery))</script></div></div>",
                                                        A += V
                                                } else if ("swatch" == E) {
                                                    var G = 0;
                                                    V = "<div class='hulkapps_option swatch_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "' >";
                                                    V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = "" != i[0] ? i[0] : ""
                                                                , n = "" != i[2] ? i[2] : ""
                                                                , p = "" != i[3] ? i[3] : ""
                                                                , s = null != e && "" != e ? " [ " + a.currency_symbol + e + " ]" : ""
                                                                , r = null != e && "" != e ? " (+" + a.currency_symbol + e + ")" : ""
                                                                , d = null != e && "" != e ? e : "0.00"
                                                                , _ = "" != d ? "price-change" : ""
                                                                , c = "undefined" == typeof i[8] == 1 ? i[6] != undefined && ("true" == i[6] || "false" == i[6]) ? i[6] : i[4] : i[6]
                                                                , u = 1 == c ? "swatch_selected" : ""
                                                                , h = 1 == c ? "checked" : ""
                                                                , $ = "<p>" + i[0] + " <br> " + r + "</p>";
                                                            if ("image" == n)
                                                                x = "background-image:url(" + p + "); background-size:cover;background-position: center center;" + g,
                                                                    C = "data-image='" + p + "'",
                                                                    p;
                                                            else {
                                                                try {
                                                                    var w = p.split(",")
                                                                } catch (I) {
                                                                    w = null
                                                                }
                                                                if (null != w)
                                                                    if (w[1] != undefined) {
                                                                        swatch_color_dual_ton = "background: linear-gradient(to bottom, " + w[0] + " 0%, " + w[0] + " 50%, " + w[1] + " 50%, " + w[1] + " 100%); " + g;
                                                                        var x = swatch_color_dual_ton
                                                                            , C = "data-image=''"
                                                                    } else
                                                                        x = "background-color:" + w[0] + ";" + g,
                                                                            C = "data-image=''"
                                                            }
                                                            if ($ != undefined)
                                                                if (p != undefined)
                                                                    if ("both" == k)
                                                                        var j = "<div style='text-align:center;'><div class='swatch_tooltip_title'> " + $ + "</div><div class='swatch_tooltip_data' style='width:100%;padding-top:100%;" + x + "'></div></div>";
                                                                    else
                                                                        j = "image_only" == k ? "<div style='text-align:center;'><div class='swatch_tooltip_data' style='width:100%;padding-top:100%;" + x + "'></div></div>" : "<div style='text-align:center;'><div class='swatch_tooltip_title'> " + $ + "</div></div>";
                                                                else
                                                                    j = "<div style='text-align:center;'><div class='swatch_tooltip_title'> " + $ + "</div></div>";
                                                            else
                                                                j = "<div style='text-align:center;'><div class='swatch_tooltip_title'></div></div>";
                                                            tooltip_val = "<div class='hulkapps-tooltip-inner swatch-tooltip' style='width:200px;'><div>" + j + "</div></div>",
                                                                tooltip_display_html = 1 == parseInt(y) ? tooltip_val : "",
                                                                swatch_with_text = 1 == parseInt(b) ? o : "",
                                                                V += "<label class='hulkapps_swatch_option'><div class='hulkapps-tooltip " + m + "'>" + tooltip_display_html + "<div><div id='" + q + "_" + G + "' data-option-key='rb_" + q + "_" + G + "' class='hulkapps_option_child " + u + " hulkapps_option_" + q + " " + _ + " '  data-price='" + d + "' data-conditional-value='" + i[0].toString().trim() + "' value='" + i[0].toString().trim() + "' style='" + f + v + x + "' " + m + "><input type='radio' name='properties[" + l + "]' value='" + i[0].toString().trim() + s + "' class='swatch_radio' " + h + " style='display:none;' " + C + " ></div></div></div><div style='display: inline-block;vertical-align: middle;margin-left: 5px;'>" + swatch_with_text + "</div></label>",
                                                                G += 1
                                                        }),
                                                        V += "<script>(function($) {$('.hulkapps_product_options .hulkapps_option_" + q + "').on('touchend', function(event) {$(this).click();});$('.hulkapps_product_options .hulkapps_option_" + q + "').click(function (){",
                                                    1 == $ && (V += "var swatch_image_url = " + t(this).find(".swatch_radio").attr("data-image") + "if (" + swatch_image_url + " != ''){$('.hulkapps_swatch_image_change img').attr('src'," + swatch_image_url + ");$('.hulkapps_swatch_image_change img').attr('srcset'," + swatch_image_url + ");$('.hulkapps_swatch_image_change img').attr('data-srcset'," + swatch_image_url + ");}"),
                                                        V += "$(this).find('swatch_radio').prop('checked', true);$(this).parents('.swatch_render').find('.swatch_selected').removeClass('swatch_selected');$(this).addClass('swatch_selected');conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "','swatch_render','hulkapps_product_options');});}(hulkapps_jQuery))</script></div></div>",
                                                        A += V
                                                } else if ("button" == E) {
                                                    if (checkPlan("button_option", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period)) {
                                                        var Z = 0;
                                                        V = "<div class='hulkapps_option button_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "' >";
                                                        V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                            V += "<div class='hulkapps_option_value'>",
                                                            t.each(O, function(t, i) {
                                                                var e = i[1]
                                                                    , o = ("" != i[0] && i[0],
                                                                    "" != i[2] ? i[2] : "")
                                                                    , n = null != e && "" != e ? " [ " + a.currency_symbol + e + " ]" : ""
                                                                    , p = null != e && "" != e ? " (+" + a.currency_symbol + e + ")" : ""
                                                                    , s = null != e && "" != e ? e : "0.00"
                                                                    , r = "" != s ? "price-change" : ""
                                                                    , d = "undefined" == typeof i[7] == 1 ? i[5] != undefined && ("true" == i[5] || "false" == i[5]) ? i[5] : i[3] : i[5]
                                                                    , _ = 1 == d ? "button_selected" : ""
                                                                    , c = 1 == d ? "checked" : ""
                                                                    , u = i[0] + " <br> " + p;
                                                                u != undefined ? titlee = "<div style='text-align:center;'><div class='button_tooltip_title'> " + u + "</div></div>" : titlee = "<div style='text-align:center;'><div class='button_tooltip_title'></div></div>",
                                                                    tooltip_val = "<div class='hulkapps-tooltip-inner button-tooltip'>" + u + "</div>",
                                                                    tooltip_display_html = 1 == parseInt(y) ? tooltip_val : "",
                                                                    V += "<label class='hulkapps_buton_option'><div class='hulkapps-tooltip'>" + tooltip_display_html + "<div><div id='" + q + "_" + Z + "' data-option-key='rb_" + q + "_" + Z + "' class='hulkapps_option_child " + _ + " hulkapps_option_" + q + " " + r + " '  data-price='" + s + "' data-conditional-value='" + i[0].toString().trim() + "' value='" + i[0].toString().trim() + "' style='" + w + x + C + "'><input type='radio' name='properties[" + l + "]' value='" + i[0].toString().trim() + n + "' class='button_radio' " + c + " style='display:none;'><span>" + o + "</span></div></div></div></label>",
                                                                    Z += 1
                                                            }),
                                                            V += "<script>(function($) {$('.hulkapps_product_options .hulkapps_option_" + q + "').on('touchend', function(event) {$(this).click();});$('.hulkapps_product_options .hulkapps_option_" + q + "').click(function (){",
                                                            V += "$(this).find('button_radio').prop('checked', true);$(this).parents('.button_render').find('.button_selected').removeClass('button_selected');$(this).addClass('button_selected');conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "','button_render','hulkapps_product_options');});}(hulkapps_jQuery))</script></div></div>",
                                                            A += V
                                                    }
                                                } else if ("swatch_multiple" == E) {
                                                    J = P != undefined && P.minimum_selection != undefined && "" != P && "" != P.minimum_selection ? P.minimum_selection.toString() : "0",
                                                        X = P != undefined && P.maximum_selection != undefined && "" != P && "" != P.maximum_selection ? P.maximum_selection.toString() : "0",
                                                        G = 0,
                                                        H = "0" != J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose from " + J + " to " + X + " values]" : "0" != J && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose atleast " + J + " values]" : "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose upto " + X + " values]" : "",
                                                        V = "<div class='hulkapps_option multiswatch_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "' >";
                                                    V += "<div class='hulkapps_option_name'><div>" + l + " " + z + " " + F + " </div> " + H + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>";
                                                    U = [],
                                                        Y = 0;
                                                    t.each(O, function(t, i) {
                                                        var e = i[1]
                                                            , o = "" != i[0] ? i[0] : ""
                                                            , n = "" != i[2] ? i[2] : ""
                                                            , p = "" != i[3] ? i[3] : ""
                                                            , s = null != e && "" != e ? " [ " + a.currency_symbol + e + " ]" : ""
                                                            , l = null != e && "" != e ? " (+" + a.currency_symbol + e + ")" : ""
                                                            , r = null != e && "" != e ? e : "0.00"
                                                            , d = "" != r ? "price-change" : ""
                                                            , _ = "undefined" == typeof i[8] == 1 ? i[6] != undefined && ("true" == i[6] || "false" == i[6]) ? i[6] : i[4] : i[6];
                                                        1 == _ && (Y += 1,
                                                            U.push(i[0].toString().trim() + s));
                                                        var c = 1 == _ ? "swatch_selected" : ""
                                                            , u = 1 == _ ? "checked" : ""
                                                            , h = "<p>" + i[0] + " <br> " + l + "</p>";
                                                        if ("image" == n)
                                                            w = "background-image:url(" + p + ");background-size:cover;background-position: center center;" + g,
                                                                x = "data-image='" + p + "'",
                                                                p;
                                                        else {
                                                            try {
                                                                var $ = p.split(",")
                                                            } catch (j) {
                                                                $ = null
                                                            }
                                                            if (null != $)
                                                                if (null != $[1]) {
                                                                    swatch_color_dual_ton = "background: linear-gradient(to bottom, " + $[0] + " 0%, " + $[0] + " 50%, " + $[1] + " 50%, " + $[1] + " 100%); " + g;
                                                                    var w = swatch_color_dual_ton
                                                                        , x = "data-image=''"
                                                                } else
                                                                    w = "background-color:" + $[0] + ";" + g,
                                                                        x = "data-image=''"
                                                        }
                                                        if (h != undefined)
                                                            if ("" != p)
                                                                if ("both" == k)
                                                                    var C = "<div style='text-align:center;'><div class='multiswatch_tooltip_title'> " + h + "</div><div class='multiswatch_tooltip_data' style='width:100%;padding-top:100%;" + w + "'></div></div>";
                                                                else
                                                                    C = "image_only" == k ? "<div style='text-align:center;'><div class='multiswatch_tooltip_data' style='width:100%;padding-top:100%;" + w + "'></div></div>" : "<div style='text-align:center;'><div class='multiswatch_tooltip_title'> " + h + "</div></div>";
                                                            else
                                                                C = "<div style='text-align:center;'><div class='multiswatch_tooltip_title'> " + h + "</div></div>";
                                                        else
                                                            C = "<div style='text-align:center;'><div class='swatch_tooltip_title'></div></div>";
                                                        tooltip_val = "<div class='hulkapps-tooltip-inner multiswatch-tooltip' style='width:200px;'><div>" + C + "</div></div>",
                                                            tooltip_display_html = 1 == parseInt(y) ? tooltip_val : "",
                                                            swatch_with_text = 1 == parseInt(b) ? o : "",
                                                            V += "<label class='hulkapps_mswatch_option'><div class='hulkapps-tooltip " + m + "'>" + tooltip_display_html + "<div><div id='" + q + "_" + G + "' data-option-key='rb_" + q + "_" + G + "' class='hulkapps_option_child " + c + " hulkapps_option_" + q + " " + d + "'  data-price=" + r + " data-conditional-value='" + i[0].toString().trim() + "' value='" + i[0].toString().trim() + "' style='" + f + v + w + "' " + m + "><input type='checkbox' data-conditional-value='" + i[0].toString().trim() + "' data-price=" + r + " id='" + q + "' value='" + i[0].toString().trim() + s + "' class='swatch_checkbox hulkapps_option_child hulkapps_option_" + q + "_visible " + d + "' " + u + " style='display:none !important;' " + x + " ></div></div></div><div style='display: inline-block;vertical-align: middle;margin-left: 5px;'>" + swatch_with_text + "</div></label>",
                                                            G += 1
                                                    }),
                                                    1 == $ && (V += "var swatch_image_url = " + t(this).find(".swatch_radio").attr("data-image") + "if (" + swatch_image_url + " != ''){$('.hulkapps_swatch_image_change img').attr('src'," + swatch_image_url + ");$('.hulkapps_swatch_image_change img').attr('srcset'," + swatch_image_url + ");$('.hulkapps_swatch_image_change img').attr('data-srcset'," + swatch_image_url + ");}"),
                                                    Y > 0 && ("0" != J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? (parseInt(Y) < parseInt(J) || parseInt(Y) > parseInt(X)) && (V += '<span class="validation_error error_span">Choose from ' + J + " to " + X + " values</span>") : "0" != J && "0" == X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? parseInt(Y) < parseInt(J) && (V += '<span class="validation_error error_span">Choose atleast ' + J + " values</span>") : "0" == J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && parseInt(Y) > parseInt(X) && (V += '<span class="validation_error error_span">Choose upto ' + X + " values</span>"));
                                                    B = '<span class="validation_error error_span" >';
                                                    V += "<input class='hulkapps_option_child' value='" + U.join(", ") + "' type='hidden' id='hulkapps_option_" + q + "_hidden' name='properties[" + l + "]'><script>(function($) {$(document).on('click','.hulkapps_product_options .hulkapps_option_" + q + "', function() {$(this).addClass('swatch_selected');if ((" + J + " != 0) && (" + X + " != 0) && (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + "))) {if (($('.hulkapps_option_" + q + "_visible:checkbox:checked').length) < parseInt('" + J + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose from " + J + " to " + X + " values</span>');if (($('.hulkapps_option_" + q + "_visible:checkbox:checked').length) == 0) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length) > parseInt('" + X + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose from " + J + " to " + X + " values</span>');if (($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length) != parseInt('" + X + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}$(this).find(':checkbox').prop('checked', false);} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (" + J + " != 0 && (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + "))) {if (($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length) < parseInt('" + J + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose atleast " + J + " values</span>');} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (" + X + " != 0 && (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + "))) {if (parseInt('" + X + "') >= ($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length)) {if (parseInt('" + X + "') == ($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length)) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose upto " + X + " values</span>');}} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).find(':checkbox').prop('checked', false);}}conditional_rules(" + a.pid + ",'hulkapps_product_options');var chkMulti = $.map($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checked'), function(el, i) {return $(el).val();});$('.hulkapps_product_options').find('#hulkapps_option_" + q + "_hidden').val(chkMulti.join(',  '));if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'multiswatch_render','hulkapps_product_options');});$(document).on('change','.hulkapps_option_" + q + "_visible',function(e){$(this).is(':checked')?$(this).parent().addClass('swatch_selected'):$(this).parent().removeClass('swatch_selected')});}(hulkapps_jQuery))</script></div></div>",
                                                        A += V
                                                } else if ("checkbox" == E) {
                                                    J = P != undefined && "" != P && P.minimum_selection != undefined && "" != P.minimum_selection ? P.minimum_selection.toString() : "0",
                                                        X = P != undefined && "" != P && P.maximum_selection != undefined && "" != P.maximum_selection ? P.maximum_selection.toString() : "0";
                                                    var K = 1 == parseInt(_) ? "single_line" : "";
                                                    H = "0" != J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose from " + J + " to " + X + " values]" : "0" != J && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features) ? "[Choose atleast " + J + " values]" : "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? "[Choose upto " + X + " values]" : "",
                                                        V = "<div class='hulkapps_option cb_render " + i + " " + D + " " + M + " " + K + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "' data-min='" + J + "' data-max='" + X + "'>";
                                                    V += "<div class='hulkapps_option_name'><div>" + l + " " + z + " " + F + "  </div> " + H + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value hulkapps_product_page_options'>";
                                                    U = [],
                                                        Y = 0;
                                                    t.each(O, function(t, i) {
                                                        var e = i[1]
                                                            , o = null != e && "" != e ? " [ " + a.currency_symbol + e + " ]" : ""
                                                            , n = null != e && "" != e ? " (+" + a.currency_symbol + e + ")" : ""
                                                            , p = null != e && "" != e ? e : "0.00"
                                                            , s = "undefined" == typeof i[6] == 1 ? i[4] != undefined && ("true" == i[4] || "false" == i[4]) ? i[4] : i[2] : i[4];
                                                        1 == s && (Y += 1,
                                                            U.push(i[0].toString().trim() + o)),
                                                            V += "<label class='hulkapps_check_option'><input type='checkbox' " + (1 == s ? "checked" : "") + " data-option-key='cbm_" + q + "' id='" + q + "' class='hulkapps_option_child hulkapps_option_" + q + "_visible hulkapps_product_option_" + q + "_visible " + ("" != p ? "price-change" : "") + "' data-price='" + p + " '  data-conditional-value='" + i[0].toString().trim() + "' value='" + i[0].toString().trim() + o + "'>" + i[0].toString().trim() + n + "</label>"
                                                    }),
                                                    Y > 0 && ("0" != J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? (parseInt(Y) < parseInt(J) || parseInt(Y) > parseInt(X)) && (V += '</select><span class="validation_error error_span">Choose from ' + J + " to " + X + " values</span>") : "0" != J && "0" == X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) ? parseInt(Y) < parseInt(J) && (V += '</select><span class="validation_error error_span">Choose atleast ' + J + " values</span>") : "0" == J && "0" != X && checkPlan("validation_for_min_max_option_selection", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && parseInt(Y) > parseInt(X) && (V += '</select><span class="validation_error error_span">Choose upto ' + X + " values</span>"));
                                                    B = '<span class="validation_error error_span" >';
                                                    V += "<input class='hulkapps_option_child' value='" + U.join(", ") + "' type='hidden' id='hulkapps_option_" + q + "_hidden' name='properties[" + l + "]'><script>(function($) {$(document).on('change','.hulkapps_product_option_" + q + "_visible', function() {if ((" + J + " != 0) && (" + X + " != 0) && (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + "))) {if (($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length) < parseInt('" + J + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose from " + J + " to " + X + " values</span>');if (($('.hulkapps_option_" + q + "_visible:checkbox:checked').length) == 0) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length) > parseInt('" + X + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose from " + J + " to " + X + " values</span>');if (($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length) != parseInt('" + X + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}this.checked = false;} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (" + J + " != 0 && (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + "))) {if (($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length) < parseInt('" + J + "')) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose atleast " + J + " values</span>');} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();}} else if (" + X + " != 0 && (checkPlan('validation_for_min_max_option_selection','boolean'," + a.plan_id + "," + a.plans_features + "," + a.is_on_trial_period + "))) {if (parseInt('" + X + "') >= ($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length)) {if (parseInt('" + X + "') == ($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checkbox:checked').length)) {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();$(this).parents('.hulkapps_option').append('" + B + "Choose upto " + X + " values</span>');}} else {$(this).parents('.hulkapps_option').removeClass('validation_error').find('.error_span').remove();this.checked = false;}}conditional_rules(" + a.pid + ",'hulkapps_product_options');var chkMulti = $.map($('.hulkapps_product_options').find('.hulkapps_option_" + q + "_visible:checked'), function(el, i) {return $(el).val();});$('.hulkapps_product_options').find('#hulkapps_option_" + q + "_hidden').val(chkMulti.join(', '));if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'cb_render','hulkapps_product_options');});}(hulkapps_jQuery))</script></div></div>",
                                                        A += V
                                                } else if ("textbox" == E) {
                                                    var W = ""
                                                        , tt = P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined ? "[Maximum " + P.character_limit + " character]" : "";
                                                    V = "<div class='hulkapps_option tb_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>";
                                                    V += "<div class='hulkapps_option_name'><div>" + l + " " + z + " " + F + " </div> " + tt + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = (null != e && "" != e && a.currency_symbol,
                                                                null != e && "" != e ? e : "0.00")
                                                                , n = ""
                                                                , p = "" != o ? "price-change" : "";
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (n = "maxlength=" + P.character_limit),
                                                                V += "<input type='text' data-option-key='tb_" + q + "' id='" + q + "' placeholder='" + I + "' class='hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + " " + p + "' data-price='" + o + "' " + n + "><input type='hidden' name='properties[" + l + "]' class='tb_property_val'>",
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (V += "<input type='hidden' value='" + P.character_limit + "' class='character_count'><div id='char_count_" + q + "'>" + P.character_limit + " " + a.display_settings.charcter_count_message + "</div>"),
                                                                W += "<script>(function($) {$(document).on('change input','.hulkapps_product_options .hulkapps_option_" + q + "',function() { var price = $(this).data('price'); var tb_val = $(this).val(); if (tb_val != '') {if(price != '0.00'){var res = tb_val + ' [ " + a.currency_symbol + "' + price + ' ]';}else{var res = tb_val}$(this).parent().find('.tb_property_val').val(res);$(this).addClass('textbox_selected');}else{$(this).parent().find('.tb_property_val').val('');$(this).removeClass('textbox_selected');}conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'tb_render','hulkapps_product_options');});",
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (W += "$(document).on('input', '.hulkapps_product_options .hulkapps_option_" + q + "', function() { check_character_limit(" + P.character_limit + ",'" + q + "','" + a.display_settings.charcter_count_message + "','hulkapps_product_options');});"),
                                                                W += "}(hulkapps_jQuery))</script>"
                                                        }),
                                                        A += V = V + W + "</div></div>"
                                                } else if ("textarea" == E) {
                                                    W = "",
                                                        tt = P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined ? "[Maximum " + P.character_limit + " character]" : "",
                                                        V = "<div class='hulkapps_option ta_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>";
                                                    V += "<div class='hulkapps_option_name'><div>" + l + " " + z + " " + F + " </div> " + tt + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = (null != e && "" != e && a.currency_symbol,
                                                                null != e && "" != e ? e : "0.00")
                                                                , n = ""
                                                                , p = "" != o ? "price-change" : "";
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (n = "maxlength=" + P.character_limit),
                                                                V += "<textarea placeholder='" + I + "' data-option-key='ta_" + q + "' id='" + q + "' class='hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + " " + p + "' data-price='" + o + "' " + n + "></textarea>",
                                                                V += "<input type='hidden' name='properties[" + l + "]' class='ta_property_val'>",
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (V += "<input type='hidden' value='" + P.character_limit + "' class='character_count'><div id='char_count_" + q + "'>" + P.character_limit + " " + a.display_settings.charcter_count_message + "</div>"),
                                                                W += "<script>(function($) {$(document).on('change input','.hulkapps_product_options .hulkapps_option_" + q + "',function() { var price = $(this).data('price'); var ta_val = $(this).val(); if (ta_val != '') {if(price != '0.00'){var res = ta_val + ' [ " + a.currency_symbol + "' + price + ' ]';}else{var res = ta_val}$(this).parent().find('.ta_property_val').val(res);$(this).addClass('textbox_selected');}else{$(this).parent().find('.ta_property_val').val('');$(this).removeClass('textbox_selected');}conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'ta_render','hulkapps_product_options');});",
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (W += "$(document).on('input', '.hulkapps_product_options .hulkapps_option_" + q + "', function() { check_character_limit(" + P.character_limit + ",'" + q + "','" + a.display_settings.charcter_count_message + "','hulkapps_product_options');});"),
                                                                W += "}(hulkapps_jQuery))</script>"
                                                        }),
                                                        A += V = V + W + "</div></div>"
                                                } else if ("radiobutton" == E) {
                                                    var it = 0;
                                                    K = 1 == parseInt(_) ? "single_line" : "";
                                                    V = "<div class='hulkapps_option rb_render " + i + " " + D + " " + M + " " + K + "  option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "' >",
                                                        V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = null != e && "" != e ? " [ " + a.currency_symbol + e + " ]" : ""
                                                                , n = null != e && "" != e ? " (+" + a.currency_symbol + e + ")" : ""
                                                                , p = null != e && "" != e ? e : "0.00"
                                                                , s = "undefined" == typeof i[6] == 1 ? i[4] != undefined && ("true" == i[4] || "false" == i[4]) ? i[4] : i[2] : i[4]
                                                                , r = 1 == s ? "radio_selected" : "";
                                                            V += "<label class='hulkapps_radio_option'><input id='" + q + "_" + it + "' data-option-key='rb_" + q + "_" + it + "'  type='radio' " + (1 == s ? "checked" : "") + " class='hulkapps_option_child hulkapps_option_" + q + " " + ("" != p ? "price-change" : "") + " ' data-price='" + p + "' data-conditional-value='" + i[0].toString().trim() + "' name='properties[" + l + "]' value='" + i[0].toString().trim() + o + "'><div class='radio_div " + r + "' for='" + q + "_" + it + "'>" + i[0].toString().trim() + n + "</div></label>",
                                                                it += 1
                                                        }),
                                                        V += "<script>(function($) {$('.hulkapps_product_options .hulkapps_radio_option').on('touchend', function(event) {$(this).find('.hulkapps_option_" + q + "').click();});$('.hulkapps_product_options .hulkapps_option_" + q + "').click(function (){$(this).parent().siblings().find('.radio_div').removeClass('radio_selected');$(this).parent().find('.radio_div').addClass('radio_selected');conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "','rb_render','hulkapps_product_options');});}(hulkapps_jQuery))</script></div></div>",
                                                        A += V
                                                } else if ("file_upload" == E)
                                                    V = "<div class='hulkapps_option fu_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + "  data-parent-id='" + q + "'>",
                                                        V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'><input type='file' data-option-key='fu_" + q + "' id='" + q + "' class='hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + "' name='properties[" + l + "]'><script>(function($) {$('.hulkapps_product_options #" + q + "').change(function (){conditional_rules(" + a.pid + ",'hulkapps_product_options');validate_single_option('option_type_id_" + q + "','fu_render','hulkapps_product_options');})}(hulkapps_jQuery))</script></div></div>",
                                                        A += V;
                                                else if ("email" == E) {
                                                    W = "";
                                                    V = "<div class='hulkapps_option et_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>",
                                                        V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + " </div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = (null != e && "" != e && a.currency_symbol,
                                                            null != e && "" != e && a.currency_symbol,
                                                                null != e && "" != e ? e : "0.00");
                                                            "undefined" == typeof i[6] == 1 ? i[4] != undefined && ("true" == i[4] || "false" == i[4]) ? i[4] : i[2] : i[4];
                                                            V += "<input type='email' placeholder='" + I + "' data-option-key='et_" + q + "' id='" + q + "' class='hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + " " + ("" != o ? "price-change" : "") + "' data-price='" + o + "'><input type='hidden' name='properties[" + l + "]' class='et_property_val'>",
                                                                W += "<script>(function($) {$(document).on('change','.hulkapps_product_options .hulkapps_option_" + q + "',function() {var price = $(this).data('price');var et_val = $(this).val();if (et_val != '') {if(price != '0.00'){var res = et_val + ' [ " + a.currency_symbol + "' + price + ' ]';}else{var res = et_val}$(this).parent().find('.et_property_val').val(res);$(this).addClass('emailbox_selected');}else{ $(this).parent().find('.et_property_val').val('');$(this).removeClass('emailbox_selected');}conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'et_render','hulkapps_product_options');});}(hulkapps_jQuery))</script>"
                                                        }),
                                                        A += V = V + W + "</div></div>"
                                                } else if ("date_picker" == E) {
                                                    W = "";
                                                    V = "<div class='hulkapps_option dp_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>",
                                                        V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = (null != e && "" != e && a.currency_symbol,
                                                            null != e && "" != e && a.currency_symbol,
                                                                null != e && "" != e ? e : "0.00");
                                                            "undefined" == typeof i[6] == 1 ? i[4] != undefined && ("true" == i[4] || "false" == i[4]) ? i[4] : i[2] : i[4];
                                                            V += "<input type='date' data-option-key='dp_" + q + "' id='" + q + "' name='input' placeholder='mm/dd/yyyy' class='hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + " " + ("" != o ? "price-change" : "") + "' data-price='" + o + "'><input type='hidden' name='properties[" + l + "]' class='dp_property_val'>",
                                                                W = W + "<script>(function($) {$(document).on('change','.hulkapps_product_options .hulkapps_option_" + q + "',function() {var price = $(this).data('price');var dp_val = $(this).val();if (dp_val != '') {if(price != '0.00'){var res = dp_val + ' [ " + a.currency_symbol + "' + price + ' ]';}else{var res = dp_val}$(this).parent().find('.dp_property_val').val(res);$(this).addClass('datepicker_selected');}else{ $(this).parent().find('.dp_property_val').val('');$(this).removeClass('datepicker_selected');}conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'dp_render','hulkapps_product_options');});}(hulkapps_jQuery))</script>"
                                                        }),
                                                        A += V = V + W + "</div></div>"
                                                } else if ("color_picker" == E) {
                                                    if (checkPlan("color_picker_option", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period)) {
                                                        W = "";
                                                        V = "<div class='hulkapps_option cp_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>",
                                                            V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                            V += "<div class='hulkapps_option_value'>",
                                                            t.each(O, function(t, i) {
                                                                var e = i[1]
                                                                    , o = (null != e && "" != e && a.currency_symbol,
                                                                null != e && "" != e && a.currency_symbol,
                                                                    null != e && "" != e ? e : "0.00");
                                                                V += "<input type='color' data-option-key='cp_" + q + "' id='" + q + "' name='input'style='padding: 0;width: 100px;' class='hulkapps_option_child  hulkapps_option_" + q + " " + ("" != o ? "price-change" : "") + "' data-price='" + o + "'><input type='hidden' name='properties[" + l + "]' class='cp_property_val'>",
                                                                    W = W + "<script>(function($) {$(document).on('change','.hulkapps_product_options .hulkapps_option_" + q + "',function() {var price = $(this).data('price');var cp_val = $(this).val();if (cp_val != '') {if(price != '0.00'){var res = cp_val + ' [ " + a.currency_symbol + "' + price + ' ]';}else{var res = cp_val}$(this).parent().find('.cp_property_val').val(res);$(this).addClass('colorpicker_selected');}else{ $(this).parent().find('.cp_property_val').val('');$(this).removeClass('colorpicker_selected');}conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'cp_render','hulkapps_product_options');});}(hulkapps_jQuery))</script>"
                                                            }),
                                                            A += V = V + W + "</div></div>"
                                                    }
                                                } else if ("number_field" == E) {
                                                    W = "";
                                                    P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features) && "" != P.character_limit && (P.character_limit,
                                                        undefined),
                                                        tt = P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined ? "[Maximum " + P.character_limit + " character]" : "",
                                                        V = "<div class='hulkapps_option nf_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>";
                                                    V += "<div class='hulkapps_option_name'><div>" + l + " " + z + " " + F + " </div> " + tt + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = (null != e && "" != e && a.currency_symbol,
                                                                null != e && "" != e ? e : "0.00")
                                                                , n = ""
                                                                , p = ""
                                                                , s = "" != o ? "price-change" : "";
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (n = "maxlength=" + P.character_limit,
                                                                p = "onKeyPress='if(this.value.length==" + P.character_limit + ") return false;'"),
                                                                V += "<input type='number' " + p + " pattern='d*' min=0 step='any' data-option-key='nf_" + q + "' id='" + q + "' placeholder='" + I + "'  class='hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + " " + s + "' data-price='" + o + "' " + n + "><input type='hidden' name='properties[" + l + "]' class='nf_property_val'>",
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (V += "<input type='hidden' value='" + P.character_limit + "' class='character_count'><div id='char_count_" + q + "'>" + P.character_limit + " " + a.display_settings.charcter_count_message + "</div>"),
                                                                W += "<script>(function($) {$(document).on('change input','.hulkapps_product_options .hulkapps_option_" + q + "',function() { var price = $(this).data('price'); var nf_val = $(this).val(); if (nf_val != '') {if(price != '0.00'){var res = nf_val + ' [ " + a.currency_symbol + "' + price + ' ]';}else{var res = nf_val}$(this).parent().find('.nf_property_val').val(res);$(this).addClass('numberfield_selected');}else{$(this).parent().find('.nf_property_val').val('');$(this).removeClass('numberfield_selected');}conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'nf_render','hulkapps_product_options');});",
                                                            P != undefined && checkPlan("character_limit", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && "" != P.character_limit && P.character_limit != undefined && (W += "$(document).on('input', '.hulkapps_product_options .hulkapps_option_" + q + "', function() { if(this.value.length > Number($(this).attr('maxlength'))){val=this.value.slice(0, $(this).attr('maxlength'));$(this).val(val);}check_character_limit(" + P.character_limit + ",'" + q + "','" + a.display_settings.charcter_count_message + "','hulkapps_product_options');});"),
                                                                W += "}(hulkapps_jQuery))</script>"
                                                        }),
                                                        A += V = V + W + "</div></div>"
                                                } else if ("phone_number" == E) {
                                                    W = "",
                                                        V = "<div class='hulkapps_option pn_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>";
                                                    V += "<div class='hulkapps_option_name'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[1]
                                                                , o = (null != e && "" != e && a.currency_symbol,
                                                                null != e && "" != e ? e : "0.00");
                                                            V += "<input type='textbox' data-option-key='tb_" + q + "' id='" + q + "' class='phone_number phone_number" + q + " hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + " " + ("" != o ? "price-change" : "") + "' data-price='" + o + "'><input type='hidden' name='properties[" + l + "]' class='tb_property_val'><span id='valid-msg' class='hide'>\u2713 Valid</span><span id='error-msg' class='hide'>Invalid number</span>",
                                                                W += "<script>(function($) {$(document).ready(function(){$('.hulkapps_product_options .phone_number" + q + "').keypress(function (e) {if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {return false;}});var telInput = $('.hulkapps_product_options').find('.phone_number" + q + "');var errorMsg = $('.hulkapps_product_options').find('.phone_number" + q + "').closest('.hulkapps_option_value').find('#error-msg');var validMsg = $('.hulkapps_product_options').find('.phone_number" + q + "').closest('.hulkapps_option_value').find('#valid-msg');var iti = window.intlTelInput(telInput.get(0), {initialCountry: 'auto',geoIpLookup: function(callback) {var countryCode = '" + a.country + "';callback(countryCode);},customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {return 'e.g. ' + selectedCountryPlaceholder;}, utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.min.js'});var reset = function() {telInput.removeClass('error');errorMsg.innerHTML = '';errorMsg.addClass('hide');validMsg.addClass('hide');};telInput.blur(function() {reset();if ($.trim($('.phone_number" + q + "').val())) {if(iti.isValidNumber()){validMsg.removeClass('hide');$('.hulkapps_product_options').find('.phone_number" + q + "').parents('.hulkapps_option_value').find('#error-msg').css('cssText', 'display: none !important');telInput.val(iti.getNumber(intlTelInputUtils.numberFormat.E164));var tb_val = $('.hulkapps_product_options').find('.phone_number" + q + "').val();var price = $(this).data('price');if(price != '0.00'){var res = tb_val + ' [ " + a.currency_symbol + "' + price + ' ]';}else{var res = tb_val}$(this).parents('.hulkapps_option_value').find('.tb_property_val').val(res);$(this).addClass('textbox_selected');} else {telInput.addClass('error');$('.hulkapps_product_options').find('.phone_number" + q + "').parents('.hulkapps_option_value').find('#error-msg').css('cssText', 'display: block !important');$(this).parents('.hulkapps_option_value').find('.tb_property_val').val(res);$(this).removeClass('textbox_selected');}}else{$('.hulkapps_product_options').find('.phone_number').parents('.hulkapps_option_value').find('#error-msg').css('cssText', 'display: none !important');$(this).parents('.hulkapps_option_value').find('.tb_property_val').val(res);$(this).removeClass('textbox_selected');}conditional_rules(" + a.pid + ",'hulkapps_product_options');if($('#hulk_amount_dis').val() == '1'){calc_options_total(" + a.pid + ",'hulkapps_product_options');}validate_single_option('option_type_id_" + q + "', 'pn_render','hulkapps_product_options');});});}(hulkapps_jQuery))</script>"
                                                        }),
                                                        A += V = V + W + "</div></div>"
                                                } else if ("hidden" == E) {
                                                    if (checkPlan("hidden_field_option", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period)) {
                                                        V = "<div class='hulkapps_option hf_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>";
                                                        V += "<div class='hulkapps_option_value'>",
                                                            t.each(O, function(t, i) {
                                                                var e = i[0];
                                                                V += "<input type='hidden' data-option-key='hf_" + q + "' id='" + q + "' class='hulkapps_option_child hulkapps_full_width hulkapps_option_" + q + "'><input type='hidden' name='properties[" + l + "]' class='hf_property_val' value='" + e + "'>"
                                                            }),
                                                            A += V += "</div></div>"
                                                    }
                                                } else
                                                    "popup" == E && checkPlan("popup_option", "boolean", a.plan_id, a.plans_features, a.is_on_trial_period) && (V = "<div class='hulkapps_option popup_render " + i + " " + D + " " + M + " option_type_id_" + q + " " + Q + " " + j + "' " + h + " data-parent-id='" + q + "'>",
                                                        V += "<div class='hulkapps_option_name' style='display: none;'>" + l + " " + z + " " + F + " " + N + "</div>",
                                                        V += "<div class='hulkapps_option_value'>",
                                                        t.each(O, function(t, i) {
                                                            var e = i[0]
                                                                , a = null != i[3] ? i[3] : "";
                                                            V += "" != a ? "<div  class='cut-popup-icon'><span class='cut-popup-icon-span'><img src='" + a + "' style='width: 24px;height: 24px;'></span><a   style='cursor: pointer;' data-id='" + q + "' data-option-key='popup_" + q + "' id='" + q + "' class='hulkapps_option_child hulkapps_full_width popup_open_link hulkapps_option_" + q + "'>" + e + "</a></div>" : "<div style='display: flex; align-items: center;'><a   style='cursor: pointer;' data-id='" + q + "' data-option-key='popup_" + q + "' id='" + q + "' class='hulkapps_option_child hulkapps_full_width popup_open_link hulkapps_option_" + q + "'>" + e + "</a></div>",
                                                                V += "<div class='popup_detail' id='popupdetailsdesing_" + q + "' style='display: none'><div><div class='des-title'></div><div class='des-detail' style='padding: 10px;'>" + i[2] + "</div></div><a class='popup_close_link' data-id='" + q + "'><img src='" + window.hulkapps.po_url + "/images/close.png' alt='close-icon'></a></div><div class='overlay-popup'></div>"
                                                        }),
                                                        A += V += "</div></div>")
                                            }
                                        });
                                    var z = "<input type='hidden' name='currency_symbol' value='" + a.currency_symbol + "'>";
                                    "" !== A && (M = M + A + z),
                                        M += "</div>",
                                    1 != parseInt(I) && "" != I || (M += "<div id='option_total' style='display: none;'><input type='hidden' id='raw_option_total' value='0'><div id='option_display_total_format'>" + j + "<span id='formatted_option_total'>" + a.currency_symbol + "<span id='calculated_option_total'>0.00</span></span>" + S + "</div></div>"),
                                        M += "<div id='error_text'></div>",
                                        M += "</div></div>"
                                }
                                if (0 == t("#hulkapps_custom_options_" + window.hulkapps.product_id).length) {
                                    i.forEach(function(i) {
                                        e += t(i).length,
                                        null == window.$first_add_to_cart_el && e && (window.$first_add_to_cart_el = t(i).first())
                                    });
                                    var F = window.$first_add_to_cart_el;
                                    F.parent().is("div") && (F = F.parent()),
                                        F.before('<div id="hulkapps_custom_options_' + window.hulkapps.product_id + '"></div>')
                                }
                                console.log(t("#hulkapps_custom_options_" + window.hulkapps.product_id)),
                                    t("#hulkapps_custom_options_" + window.hulkapps.product_id).html(M),
                                    conditional_rules(window.hulkapps.product_id, "hulkapps_product_options"),
                                    t("#hulkapps_options_" + window.hulkapps.product_id).closest("form").find(":submit").addClass("hulkapps_submit_cart"),
                                "" == t("#hulkapps_option_list_" + window.hulkapps.product_id + " .hulkapps_option_set").html() && t("#hulkapps_options_" + window.hulkapps.product_id).css("display", "none")
                            }
                        },
                        error: function() {
                            window.$first_add_to_cart_el && window.$first_add_to_cart_el.removeAttr("disabled")
                        }
                    }),
                        t("body").on("change", 'input[name="updates[]"]', function() {
                            t('[name="update"]').click()
                        })
                }
                ,
                window.hulkappsParseURL = function(t) {
                    if (t) {
                        var i = RegExp("^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\\?([^#]*))?(#(.*))?")
                            , e = t.match(i)
                            , a = e[7];
                        return a && (a = new URLSearchParams(a)),
                            {
                                scheme: e[2],
                                authority: e[4],
                                path: e[5],
                                query: a,
                                fragment: e[9]
                            }
                    }
                }
                ,
                hulkappsStart(t)
        }
        ,
        window.getCartInfo = function(t=0, i="", e=hulkapps_jQuery) {
            i = i;
            if (0 != t) {
                var a = t.key;
                let i = t.properties;
                if (i) {
                    var o = "";
                    Object.keys(i).forEach(function(t) {
                        if (i[t].includes("uploads")) {
                            var e = i[t].split("/")
                                , a = e[e.length - 1];
                            o += '<div class="product-option"><dt>' + t + ': </dt><dd>  <a href="' + i[t] + '" class="link" target="_blank">' + a + "</a></dd></div>"
                        } else
                            o += '<div class="product-option"><dt>' + t + ": </dt><dd>" + i[t] + "</dd></div>"
                    }),
                        window.currentEditOptionSelector.parents("[data-hulkapps-lineitem]").find("[data-hulkapps-line-properties]").html(o)
                } else
                    window.currentEditOptionSelector.parents("[data-hulkapps-lineitem]").find("[data-hulkapps-line-properties]").html("")
            }
            new Promise(function(t) {
                    i ? t(i) : e.getJSON("/cart.js", {
                        _: (new Date).getTime()
                    }, function(i) {
                        t(i)
                    })
                }
            ).then(function(t) {
                if (t && t.item_count > 0) {
                    var i = localStorage.getItem("discount_code");
                    if (window.hulkapps.cart = t,
                    "" != i) {
                        e(".hulkapps_discount_code").val(i);
                        var o = {
                            cart_data: window.hulkapps,
                            store_id: window.hulkapps.store_id,
                            discount_code: i,
                            cart_collections: JSON.stringify(window.hulkapps.cart_collections),
                            customer_tags: null != window.hulkapps.customer ? window.hulkapps.customer.tags.split(",") : ""
                        }
                    } else
                        o = {
                            cart_data: window.hulkapps,
                            store_id: window.hulkapps.store_id,
                            customer_tags: null != window.hulkapps.customer ? window.hulkapps.customer.tags.split(",") : ""
                        };
                    var n = 0;
                    t.items.forEach(function(t) {
                        null != t.properties && t.properties != {} && n++
                    }),
                        n > 1 ? e(checkout_selectors).attr("disabled", !0) : e(checkout_selectors).attr("disabled", !1),
                        e(checkout_selectors).attr("disabled", !0),
                        e.ajax({
                            type: "POST",
                            url: window.hulkapps.po_url + "/store/get_cart_details",
                            data: o,
                            crossDomain: !0,
                            success: function(t) {
                                e(checkout_selectors).attr("disabled", !1),
                                    t.discounts.cart.items.forEach(function(t) {
                                        setTimeout(function() {
                                            a && t.key == a && (window.currentEditOptionSelector.parents("[data-hulkapps-lineitem]").find(".hulkapps-cart-item-line-price").html(t.original_line_price_format),
                                                window.currentEditOptionSelector.parents("[data-hulkapps-lineitem]").find(".hulkapps-cart-item-price").html(t.original_price_format),
                                                window.currentEditOptionSelector.parents("[data-hulkapps-lineitem]").find("[data-hulkapps-line-price]").html(t.original_line_price_format),
                                                window.currentEditOptionSelector.parents("[data-hulkapps-lineitem]").find("[data-hulkapps-ci-price]").html(t.original_price_format))
                                        }, 500)
                                    }),
                                    hulkappsDoActions(t),
                                    t.discounts.is_draft_order ? window.is_draft_order = !0 : window.is_draft_order = !1
                            },
                            error: function() {
                                e(checkout_selectors).attr("disabled", !1)
                            }
                        })
                }
            })["catch"](function() {})
        }
        ,
        window.hulkappsRadioOption = function(t, i, e) {
            hulkapps_jQuery(".hulkapps_edit_product_options .hulkapps_radio_option").on("touchend", function() {
                hulkapps_jQuery(this).find(".hulkapps_option_" + t).click()
            }),
                hulkapps_jQuery(".hulkapps_edit_product_options .hulkapps_option_" + t).click(function() {
                    hulkapps_jQuery(this).parent().siblings().find(".radio_div").removeClass("radio_selected"),
                        hulkapps_jQuery(this).parent().find(".radio_div").addClass("radio_selected"),
                        conditional_rules(i, "hulkapps_edit_product_options"),
                    e && calc_options_total(i, "hulkapps_edit_product_options"),
                        validate_single_option("option_type_id_" + t, "rb_render", "hulkapps_edit_product_options")
                })
        }
        ,
        window.cartPageJS = function(t) {
            t(document).on("keypress", ".hulkapps_discount_code", function(i) {
                13 == i.which && t(".hulkapps_discount_button").click()
            }),
                t(document).on("click", ".hulkapps_discount_button", function(i) {
                    i.preventDefault();
                    var e = t(this).parents(".discount_code_box").find(".hulkapps_discount_code").val();
                    "" == (e = t.trim(e)) ? t(".hulkapps_discount_code").addClass("discount_error") : (localStorage.setItem("discount_code", e),
                        t(".hulkapps_discount_code").removeClass("discount_error")),
                        window.getCartInfo()
                }),
                t(document).on("click", ".close-tag", function() {
                    localStorage.removeItem("discount_code"),
                        window.getCartInfo()
                }),
                t(document).on("click", ".hulkapp_save", function(i) {
                    if (i.preventDefault(),
                        validate_options(t(this).data("product_id"), "hulkapps_edit_product_options")) {
                        t(checkout_selectors).attr("disabled", !0);
                        var e = parseInt(t(this).parents(".hulkapp_popupBox").find(".hulkapp_mainContent").find(".h_index").val()) + 1
                            , a = t(this).attr("data-quantity")
                            , o = t(this).parents(".hulkapp_popupBox").find(".hulkapp_mainContent").find(".h_variant_id").val()
                            , n = {};
                        if (t("#edit_cart_popup [name^='properties']").each(function() {
                            var i;
                            "" == t(this).val() && t(this).remove(),
                                "radio" == this.type ? this.checked && (i = this.name.replace("properties[", "").replace("]", ""),
                                t.trim(this.value).length > 0 && (n[i] = this.value)) : (this.type,
                                    i = this.name.replace("properties[", "").replace("]", ""),
                                t.trim(this.value).length > 0 && (n[i] = this.value))
                        }),
                            t.isEmptyObject(n))
                            "" != t(".upload_cls").val() ? t(".upload_h_cls").remove() : t(".upload_cls").remove(),
                                t("#edit_cart_popup .conditional").each(function() {
                                    t(this).find('.hulkapps_option_value input[type="hidden"]').val("")
                                }),
                                t("[name^='properties']").each(function() {
                                    "" == t(this).val() && t(this).remove()
                                }),
                                t.ajax({
                                    type: "POST",
                                    url: "/cart/change.js",
                                    data: {
                                        quantity: 0,
                                        line: e
                                    },
                                    dataType: "json",
                                    success: function() {
                                        "" != t(".upload_cls").val() ? t(".upload_h_cls").remove() : t(".upload_cls").remove(),
                                            t("#edit_cart_popup .conditional").each(function() {
                                                t(this).find('.hulkapps_option_value input[type="hidden"]').val("")
                                            }),
                                            t("[name^='properties']").each(function() {
                                                "" == t(this).val() && t(this).remove()
                                            }),
                                            t.ajax({
                                                type: "POST",
                                                url: "/cart/add.js",
                                                data: {
                                                    quantity: a,
                                                    id: o
                                                },
                                                dataType: "json",
                                                success: function(i) {
                                                    window.currentEditOptionSelector.data("key", i.key),
                                                        window.getCartInfo(i),
                                                        t(".hulkapp_close").click()
                                                }
                                            })
                                    }
                                });
                        else {
                            var p = new FormData(t("#edit_cart_popup")[0]);
                            p.append("quantity", a),
                                p.append("line", e),
                                "" != t(".upload_cls").val() ? t(".upload_h_cls").remove() : t(".upload_cls").remove(),
                                t("#edit_cart_popup .conditional").each(function() {
                                    t(this).find('.hulkapps_option_value input[type="hidden"]').val("")
                                }),
                                t("[name^='properties']").each(function() {
                                    "" == t(this).val() && t(this).remove()
                                }),
                                t.ajax({
                                    type: "POST",
                                    url: "/cart/change.js",
                                    data: {
                                        quantity: 0,
                                        line: e
                                    },
                                    dataType: "json",
                                    success: function() {
                                        "" != t(".upload_cls").val() ? t(".upload_h_cls").remove() : t(".upload_cls").remove(),
                                            t("#edit_cart_popup .conditional").each(function() {
                                                t(this).find('.hulkapps_option_value input[type="hidden"]').val("")
                                            }),
                                            t("[name^='properties']").each(function() {
                                                "" == t(this).val() && t(this).remove()
                                            }),
                                            t.ajax({
                                                type: "POST",
                                                url: "/cart/add.js",
                                                data: p,
                                                dataType: "json",
                                                contentType: !1,
                                                processData: !1,
                                                success: function(i) {
                                                    window.currentEditOptionSelector.data("key", i.key),
                                                        window.getCartInfo(i),
                                                        t(".hulkapp_close").click()
                                                }
                                            })
                                    }
                                })
                        }
                    }
                }),
                t(document).on("click touchstart", ".hulkapp_close", function() {
                    t(".edit_popup").hide(),
                        t("body").removeClass("body_fixed")
                })
        }
        ,
        window.productPageJS = function($) {
            $(document).on("click", ".popup_open_link", function() {
                var t = $(this).attr("data-id");
                $("#popupdetailsdesing_" + t).css("display", "flex"),
                    $(".overlay-popup").css("display", "block")
            }),
                $(document).on("click", ".popup_close_link", function() {
                    var t = $(this).attr("data-id");
                    $("#popupdetailsdesing_" + t).css("display", "none"),
                        $(".overlay-popup").css("display", "none")
                }),
                window.conditional_rules = function(prod_id, hulkapps_parents="") {
                    var hulkapps_parents = hulkapps_parents;
                    "" == hulkapps_parents && (hulkapps_parents = "hulkapps_product_options"),
                        pass = !1,
                        verify_all = Array(),
                        verify_any = Array(),
                        verified_condition = Array(),
                        pass_array = Array(),
                        $("." + hulkapps_parents).find(".condition_hide").removeClass("conditional"),
                        $("." + hulkapps_parents).find(".condition_show").addClass("conditional"),
                        $("." + hulkapps_parents + "  #conditional_rules").children().each(function() {
                            pass_array = Array(),
                                pass = !1,
                                $(this).children().each(function() {
                                    pass = !1;
                                    var condition_rule = $(this).text(), field_value;
                                    if (1 == $("." + hulkapps_parents).find(".option_type_id_" + $(this).attr("data-field-num")).hasClass("dd_multi_render")) {
                                        var aa = condition_rule;
                                        aa.indexOf("!=") >= 0 && (pass = !0);
                                        var count = $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + "_visible:visible :selected").length
                                            , ct = 1
                                            , selected_array = Array();
                                        $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + "_visible:visible :selected").length > 0 ? $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + "_visible:visible :selected").each(function() {
                                            var condition_rule = aa;
                                            if (field_value = $(this).data("conditional-value"),
                                                condition_rule = condition_rule.replace("**value11**", field_value),
                                            condition_rule.indexOf("==") >= 0) {
                                                var condition_rule = condition_rule.split("==");
                                                condition_rule[0] == condition_rule[1] ? pass = !0 : pass = !1
                                            } else {
                                                var condition_rule = condition_rule.split("!=");
                                                condition_rule[0] != condition_rule[1] ? pass = !0 : pass = !1
                                            }
                                            if (selected_array.push(pass),
                                            ct == count && count > 1) {
                                                var result = selected_array.join(" || ");
                                                result = eval(result),
                                                    pass_array.push(result)
                                            } else
                                                1 == count && pass_array.push(pass);
                                            ct += 1
                                        }) : pass_array.push(!1)
                                    } else if (1 == $(".option_type_id_" + $(this).attr("data-field-num")).hasClass("cb_render")) {
                                        var aa = condition_rule;
                                        aa.indexOf("!=") >= 0 && (pass = !0);
                                        var ctt = 1
                                            , checked_array = Array()
                                            , countt = $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + "_visible:visible:checked").length;
                                        $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + "_visible:visible:checked").each(function() {
                                            var condition_rule = aa;
                                            if (field_value = $(this).data("conditional-value"),
                                                condition_rule = condition_rule.replace("**value11**", field_value),
                                            condition_rule.indexOf("==") >= 0) {
                                                var condition_rule = condition_rule.split("==");
                                                condition_rule[0] == condition_rule[1] ? pass = !0 : pass = !1
                                            } else {
                                                var condition_rule = condition_rule.split("!=");
                                                condition_rule[0] != condition_rule[1] ? pass = !0 : pass = !1
                                            }
                                            if (checked_array.push(pass),
                                            ctt == countt && countt > 1) {
                                                var result = checked_array.join(" || ");
                                                result = eval(result),
                                                    pass_array.push(result)
                                            } else
                                                1 == countt && pass_array.push(pass);
                                            ctt += 1
                                        })
                                    } else if (1 == $("." + hulkapps_parents).find("#hulkapps_option_list_" + prod_id + " .option_type_id_" + $(this).attr("data-field-num")).hasClass("multiswatch_render")) {
                                        var aa = condition_rule;
                                        aa.indexOf("!=") >= 0 && (pass = !0);
                                        var ctt = 1
                                            , checked_array = Array()
                                            , countt = $("." + hulkapps_parents).find("#hulkapps_option_list_" + prod_id + " .hulkapps_option_" + $(this).attr("data-field-num") + "_visible:checked").length;
                                        $("." + hulkapps_parents).find("#hulkapps_option_list_" + prod_id + " .hulkapps_option_" + $(this).attr("data-field-num") + "_visible:checked").each(function() {
                                            var condition_rule = aa;
                                            if (field_value = $(this).data("conditional-value"),
                                                condition_rule = condition_rule.replace("**value11**", field_value),
                                            condition_rule.indexOf("==") >= 0) {
                                                var condition_rule = condition_rule.split("==");
                                                condition_rule[0] == condition_rule[1] ? pass = !0 : pass = !1
                                            } else {
                                                var condition_rule = condition_rule.split("!=");
                                                condition_rule[0] != condition_rule[1] ? pass = !0 : pass = !1
                                            }
                                            if (checked_array.push(pass),
                                            ctt == countt && countt > 1) {
                                                var result = checked_array.join(" || ");
                                                result = eval(result),
                                                    pass_array.push(result)
                                            } else
                                                1 == countt && pass_array.push(pass);
                                            ctt += 1
                                        })
                                    } else {
                                        if (pass = !1,
                                        1 == $("." + hulkapps_parents).find(".option_type_id_" + $(this).attr("data-field-num")).hasClass("dd_render"))
                                            field_value = $("." + hulkapps_parents).find("#" + $(this).attr("data-field-num") + " option:selected").attr("data-conditional-value");
                                        else if (1 == $("." + hulkapps_parents).find(".option_type_id_" + $(this).attr("data-field-num")).hasClass("rb_render"))
                                            field_value = $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + ":checked").data("conditional-value");
                                        else if (1 == $("." + hulkapps_parents).find(".option_type_id_" + $(this).attr("data-field-num")).hasClass("swatch_render"))
                                            field_value = $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + ".swatch_selected").data("conditional-value");
                                        else if (1 == $("." + hulkapps_parents).find(".option_type_id_" + $(this).attr("data-field-num")).hasClass("button_render"))
                                            field_value = $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + ".button_selected").data("conditional-value");
                                        else if (1 == $("." + hulkapps_parents).find(".option_type_id_" + $(this).attr("data-field-num")).hasClass("dp_render")) {
                                            if (field_value = $("." + hulkapps_parents).find(".hulkapps_option_" + $(this).attr("data-field-num") + ".datepicker_selected").val(),
                                            field_value != undefined) {
                                                var splitedValues = field_value.split("-");
                                                field_value = splitedValues[1] + "/" + splitedValues[2] + "/" + splitedValues[0]
                                            }
                                        } else
                                            field_value = $("." + hulkapps_parents).find("#" + $(this).attr("data-field-num")).val();
                                        if (condition_rule = condition_rule.replace("**value11**", field_value),
                                        condition_rule.indexOf("==") >= 0) {
                                            var condition_rule = condition_rule.split("==");
                                            condition_rule[0] == condition_rule[1] ? pass = !0 : pass = !1
                                        } else {
                                            var condition_rule = condition_rule.split("!=");
                                            condition_rule[0] != condition_rule[1] ? pass = !0 : pass = !1
                                        }
                                        pass_array.push(pass)
                                    }
                                });
                            var type_rule = $(this).attr("data-verify-all")
                                , condition_id = $(this).attr("name");
                            if ("0" == type_rule)
                                var res = pass_array.join(" || ");
                            else
                                var res = pass_array.join(" && ");
                            if (res = eval(res),
                                res) {
                                var updated_is = !0;
                                $("." + hulkapps_parents).find("." + condition_id + "_show").removeClass("conditional"),
                                    $("." + hulkapps_parents).find("." + condition_id + "_hide").addClass("conditional")
                            }
                        }),
                        $("." + hulkapps_parents + " #conditional_rules").children().each(function() {
                            var t = $(this).attr("name");
                            $("." + hulkapps_parents).find("." + t + "_hide.conditional").find(".hulkapps_option_child").each(function() {
                                conditional_change($(this))
                            }),
                                $("." + hulkapps_parents).find("." + t + "_show.conditional").find(".hulkapps_option_child").each(function() {
                                    conditional_change($(this))
                                })
                        }),
                        calc_options_total(prod_id, hulkapps_parents)
                }
                ,
                window.conditional_change = function(t) {
                    "select-one" == t.prop("type") ? t.val() && (t.val("").change(),
                        t.parent().removeClass("selected")) : "select-multiple" == t.prop("type") ? t.val() && (t.val(""),
                        t.parent().removeClass("selected")) : "radio" == t.prop("type") ? t.prop("checked") && (t.prop("checked", !1),
                        t.parent().find(".radio_selected").removeClass("radio_selected")) : "file" == t.prop("type") ? (t.val(""),
                        t.parent(".hulkapps_option_value").find(".upload_h_cls").val("")) : "textarea" == t.prop("type") || "number" == t.prop("type") || "text" == t.prop("type") || "hidden" == t.prop("type") || "file" == t.prop("type") || "email" == t.prop("type") || "date_picker" == t.prop("type") || "color_picker" == t.prop("type") ? t.val() && (t.val("").change(),
                        t.parents(".hulkapps_option_value").find(".tb_property_val").val(""),
                        t.parents(".hulkapps_option_value").find("#valid-msg").remove()) : "checkbox" == t.prop("type") ? t.prop("checked") && (t.prop("checked", !1),
                        t.parent().removeClass("swatch_selected")) : "DIV" == t.prop("tagName") && t.find(".swatch_radio").prop("checked") && (t.find(".swatch_radio").prop("checked", !1),
                        t.removeClass("swatch_selected"))
                }
                ,
                window.calc_options_total = function(t, i="") {
                    var e;
                    "" == (i = i) && (i = "hulkapps_product_options");
                    var a = 0;
                    window.hulkapps.money_format;
                    for (checked_variant = $("." + i + " #hulkapps_option_list_" + t + ":visible .price-change:checked, ." + i + " #hulkapps_option_list_" + t + ":visible .price-change:selected, ." + i + " .hulkapps_swatch_option .swatch_selected,." + i + " .textarea_selected,." + i + " .textbox_selected,." + i + " .emailbox_selected,." + i + " .datepicker_selected,." + i + " .numberfield_selected,." + i + " .colorpicker_selected,." + i + " .button_selected"),
                             e = 0; e < checked_variant.length; e++)
                        $(checked_variant[e]).parents(".hulkapps_option").hasClass("conditional") || (a = Number($(checked_variant[e]).attr("data-price")) + Number(a));
                    $("." + i + " #raw_option_total").val(a),
                        $("." + i + " #calculated_option_total").html(a.toFixed(2)),
                        a > 0 ? $("." + i + " #option_total").slideDown() : $("." + i + " #option_total").slideUp()
                }
                ,
                window.checkPlan = function(t, i, e, a, o) {
                    return is_allowed = !0,
                        t && i && a && e && a[e] ? ("string" == $.type(a) && (a = JSON.parse(a)),
                        0 == a[e][t] && "boolean" == i && (is_allowed = !1),
                        1 == o && 1 == a[e][t] && (is_allowed = !0)) : is_allowed = !1,
                        is_allowed
                }
                ,
                window.check_character_limit = function(t, i, e, a="") {
                    "" == (a = a) && (a = "hulkapps_product_options");
                    var o = t - $("." + a + " .hulkapps_option_value .hulkapps_option_" + i).val().length;
                    $("." + a + " #char_count_" + i).html(o + " " + e)
                }
                ,
                window.validate_options = function(t, i) {
                    "" != (i = i) && i != undefined || (i = "hulkapps_product_options");
                    var e = !0;
                    $("." + i).find(".hulkapps_option:visible").each(function() {
                        $(this).hasClass("validation_error") && (e = !1)
                    }),
                        $("." + i + " #error_text").html("");
                    var a, o = $("." + i).find("#hulkapps_option_list_" + t + ":visible .required:visible");
                    for (a = 0; a < o.length; a++)
                        1 != hulkapps_jQuery(o[a]).find("select[name^='properties']").length || hulkapps_jQuery(o[a]).find("select[name^='properties']").val() ? $(o[a]).find(".hulkapps_radio_option").length && !$(o[a]).find("input[name^='properties']:checked").length ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find(".hulkapps_buton_option").length && !$(o[a]).find("input[name^='properties']:checked").length ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find(".hulkapps_swatch_option").length && !$(o[a]).find("input[name^='properties']:checked").length ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find(".hulkapps_button_option").length && !$(o[a]).find("input[name^='properties']:checked").length ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find("input[type='text']").length > 1 ? $(o[a]).find("input[type='text']").each(function() {
                            "" == $(this).val() && ($(o[a]).addClass("validation_error"),
                                e = !1)
                        }) : $(o[a]).find("input[type='text']").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find("input[type='email']").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find("input[type='color']").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find(".hulkapps_check_option").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find("input[type='file']").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).hasClass("cb_render") && $(o[a]).find("input[type='checkbox']:checked").length && !$(o[a]).find("input[name^='properties']").length ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).hasClass("multiswatch_render") && $(o[a]).find("input[type='checkbox']:checked").length && !$(o[a]).find("input[name^='properties']").length ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find("textarea").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find("select[multiple]").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).find("input[type='number']").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).hasClass("dp_render") && $(o[a]).find("input[type='date']").length && !$(o[a]).find("input[name^='properties']").val() ? ($(o[a]).addClass("validation_error"),
                            e = !1) : $(o[a]).removeClass("validation_error") : (hulkapps_jQuery(o[a]).addClass("validation_error"),
                            e = !1);
                    return $("." + i).find("#hulkapps_option_list_" + t + " .cb_render:visible").each(function() {
                        $(this).hasClass("required") && $(this).find("input[type='checkbox']").length ? $(this).find("input[name^='properties']").val() ? $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                            e = !1) : $(this).removeClass("validation_error") : ($(this).addClass("validation_error"),
                            e = !1) : $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                            e = !1) : $(this).removeClass("validation_error")
                    }),
                        $("." + i).find("#hulkapps_option_list_" + t + " .multiswatch_render:visible").each(function() {
                            $(this).hasClass("required") && $(this).find("input[type='checkbox']").length ? $(this).find("input[name^='properties']").val() ? $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).removeClass("validation_error") : ($(this).addClass("validation_error"),
                                e = !1) : $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).removeClass("validation_error")
                        }),
                        $("#hulkapps_option_list_" + t + " .dd_multi_render:visible").each(function() {
                            $(this).hasClass("required") && $(this).find("select[multiple]").length ? $(this).find("input[name^='properties']").val() ? $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).removeClass("validation_error") : ($(this).addClass("validation_error"),
                                e = !1) : $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).removeClass("validation_error")
                        }),
                        $("." + i).find("#hulkapps_option_list_" + t + " .et_render.required:visible").each(function() {
                            if ($(this).find("input[type='email']").length && (!$(this).find("input[name^='properties']").val() && $(this).hasClass("required") || "" != $(this).find("input[type='email']").val())) {
                                var t = $(this).find("input[type='email']").val();
                                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,5}|[0-9]{1,3})(\]?)$/.test(t) ? $(this).removeClass("validation_error") : ($(this).addClass("validation_error"),
                                    e = !1)
                            }
                        }),
                        $("." + i).find("#hulkapps_option_list_" + t + " .pn_render.required:visible").each(function() {
                            $(this).find("input[type='textbox']").length && !$(this).find("input[name^='properties']").val() && $(this).hasClass("required") ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).find(".phone_number").hasClass("error") ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).removeClass("validation_error")
                        }),
                        $("." + i).find("#hulkapps_option_list_" + t + " .dp_render:visible").each(function() {
                            $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).removeClass("validation_error")
                        }),
                        $("." + i).find("#hulkapps_option_list_" + t + " .dp_render.required:visible").each(function() {
                            $(this).find("input[type='date']").length && !$(this).find("input[name^='properties']").val() && $(this).hasClass("required") ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).find(".error_span").length > 0 ? ($(this).addClass("validation_error"),
                                e = !1) : $(this).removeClass("validation_error")
                        }),
                        e
                }
                ,
                window.validate_single_option = function(t, i, e="") {
                    if ("" == (e = e) && (e = "hulkapps_product_options"),
                    "dd_render" == i)
                        1 == $("." + e).find("." + t).find("select[name^='properties']").length && !$("." + e).find("." + t).find("select[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("dd_multi_render" == i)
                        $("." + e).find("." + t).find("select[multiple]").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("swatch_render" == i)
                        $("." + e).find("." + t).removeClass("validation_error");
                    else if ("multiswatch_render" == i)
                        $("." + e).find("." + t).find(".hulkapps_swatch_option").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("button_render" == i)
                        $("." + e).find("." + t).find(".hulkapps_buton_option").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("cp_render" == i)
                        $("." + e).find("." + t).find("input[type='text']").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("cb_render" == i)
                        $("." + e).find("." + t).find(".hulkapps_check_option").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("tb_render" == i)
                        $("." + e).find("." + t).find("input[type='text']").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("nf_render" == i)
                        $("." + e).find("." + t).find("input[type='number']").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("dp_render" == i)
                        if ($("." + e).find("." + t).find("input[type='date']").length && $("." + e).find("." + t).find("input[name^='properties']").val()) {
                            var a = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/
                                , o = $("." + e).find("." + t).find("input[type='date']").val();
                            if (o.includes("-")) {
                                var n = o.split("-");
                                o = n[1] + "/" + n[2] + "/" + n[0]
                            }
                            var p = o.match(a);
                            if (null == p)
                                $("." + e).find("." + t).addClass("validation_error"),
                                    $("." + e).find("." + t).find(".validation_error").remove(),
                                    $("." + e).find("." + t).find("input[type='date']").after('<span class="validation_error error_span">Enter valid date format mm/dd/yyyy</span>');
                            else if (dtMonth = p[1],
                                dtDay = p[3],
                                dtYear = p[5],
                            dtMonth < 1 || dtMonth > 12)
                                $("." + e).find("." + t).addClass("validation_error"),
                                    $("." + e).find("." + t).find(".validation_error").remove(),
                                    $("." + e).find("." + t).find("input[type='date']").after('<span class="validation_error error_span">Enter valid date format mm/dd/yyyy</span>');
                            else if (dtDay < 1 || dtDay > 31)
                                $("." + e).find("." + t).addClass("validation_error"),
                                    $("." + e).find("." + t).find(".validation_error").remove(),
                                    $("." + e).find("." + t).find("input[type='date']").after('<span class="validation_error error_span">Enter valid date format mm/dd/yyyy</span>');
                            else if (4 != dtMonth && 6 != dtMonth && 9 != dtMonth && 11 != dtMonth || 31 != dtDay)
                                if (2 == dtMonth) {
                                    var s = dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0);
                                    dtDay > 29 || 29 == dtDay && !s ? ($("." + e).find("." + t).addClass("validation_error"),
                                        $("." + e).find("." + t).find(".validation_error").remove(),
                                        $("." + e).find("." + t).find("input[type='date']").after('<span class="validation_error error_span">Enter valid date format mm/dd/yyyy</span>')) : ($("." + e).find("." + t).removeClass("validation_error"),
                                        $("." + e).find("." + t).find(".validation_error").remove())
                                } else
                                    "/" !== p[2] || "/" !== p[4] ? ($("." + e).find("." + t).addClass("validation_error"),
                                        $("." + e).find("." + t).find(".validation_error").remove(),
                                        $("." + e).find("." + t).find("input[type='date']").after('<span class="validation_error error_span">Enter valid date format mm/dd/yyyy</span>')) : ($("." + e).find("." + t).removeClass("validation_error"),
                                        $("." + e).find("." + t).find(".validation_error").remove());
                            else
                                $("." + e).find("." + t).addClass("validation_error"),
                                    $("." + e).find("." + t).find(".validation_error").remove(),
                                    $("." + e).find("." + t).find("input[type='date']").after('<span class="validation_error error_span">Enter valid date format mm/dd/yyyy</span>')
                        } else
                            $("." + e).find("." + t).find("input[type='date']").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? ($("." + e).find("." + t).addClass("validation_error"),
                                $("." + e).find("." + t).find(".validation_error").remove()) : ($("." + e).find("." + t).find(".validation_error").remove(),
                                $("." + e).find("." + t).removeClass("validation_error"));
                    else if ("ta_render" == i)
                        $("." + e).find("." + t).find("textarea").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("rb_render" == i)
                        $("." + e).find("." + t).removeClass("validation_error");
                    else if ("fu_render" == i)
                        $("." + e).find("." + t).find("input[type='file']").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? $("." + e).find("." + t).addClass("validation_error") : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("pn_render" == i)
                        $("." + e).find("." + t).find("input[type='textbox']").length && !$("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") ? ($("." + e).find("." + t).addClass("validation_error"),
                            good = !1) : $("." + e).find("." + t).find(".phone_number").hasClass("error") ? ($("." + e).find("." + t).addClass("validation_error"),
                            good = !1) : $("." + e).find("." + t).removeClass("validation_error");
                    else if ("et_render" == i)
                        if ($("." + e).find("." + t).find("input[type='email']").length && ($("." + e).find("." + t).find("input[name^='properties']").val() && $("." + e).find("." + t).hasClass("required") || "" != $("." + e).find("." + t).find("input[type='email']").val().length)) {
                            var l = $("." + e).find("." + t).find("input[type='email']").val();
                            /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,5}|[0-9]{1,3})(\]?)$/.test(l) ? $("." + e).find("." + t).removeClass("validation_error") : $("." + e).find("." + t).addClass("validation_error")
                        } else
                            $("." + e).find("." + t).removeClass("validation_error")
                }
            ;
            var hulk_flag = 0;
            $(document).on("click", ".hulkapps_submit_cart", function(t) {
                if (0 == hulk_flag) {
                    t.preventDefault();
                    validate_options(window.hulkapps.product_id, "hulkapps_product_options") && ($("[name^='properties']").each(function() {
                        "" == $(this).val() && $(this).attr("disabled", !0)
                    }),
                        hulk_flag = 1,
                        $(".hulkapps_submit_cart").click(),
                    1 == hulk_flag && ($("[name^='properties']").each(function() {
                        "" == $(this).val() && $(this).attr("disabled", !1)
                    }),
                        hulk_flag = 0))
                }
            })
        }
        ,
    "undefined" != typeof window.hulkapps && ("undefined" == typeof jQuery || 3 == parseInt(jQuery.fn.jquery) && parseFloat(jQuery.fn.jquery.replace(/^1\./, "")) < 2.1 ? hulkLoadScript("//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js", function() {
        hulkapps_jQuery = jQuery.noConflict(!0),
            checkAppInstalled(hulkapps_jQuery)
    }) : (hulkapps_jQuery = jQuery,
        checkAppInstalled(hulkapps_jQuery)))
}

function initJQuery(e) {
    var x = 1;
   // var t;
   // "undefined" == typeof jQuery ? ((t = document.createElement("SCRIPT")).src = "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", t.type = "text/javascript", t.onload = e, document.head.appendChild(t)) : e()
}

function initCss(e) {

    var t = document.createElement("link");
    t.setAttribute("rel", "stylesheet"), t.setAttribute("type", "text/css"),
        t.onload = e, t.setAttribute("href", window.AllFetchURL + "/s_shopify_registry/static/src/css/shopify_frontend.css"), document.head.appendChild(t)
}

function initCss2(e) {

    var t = document.createElement("link");
    t.setAttribute("rel", "stylesheet"), t.setAttribute("type", "text/css"),
        t.onload = e, t.setAttribute("href", window.AllFetchURL + "/s_shopify_registry/static/src/registry_frontend.css"), document.head.appendChild(t)
}

function allfetchWAPGetShopify() {
    if (null != window.Shopify) return window.Shopify.shop;
    var e = window.location.href;
    return (e.indexOf("://") > -1 ? e.split("/")[2] : e.split("/")[0]).split(":")[0]
};

function mobilecheck() {
    var e, t = !1;
    return e = navigator.userAgent || navigator.vendor || window.opera, (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(e) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(e.substr(0, 4))) && (t = !0), t
};

function is_order_checkout_page() {
    return !(!window.location.pathname.match("(.*)/orders/(.*)") && !window.location.pathname.match("(.*)/checkouts/(.*)"))
}

function is_product_page() {
    var is_page = !!window.location.pathname.match("(.*)/products/(.*)");
    //console.log(is_page);
    return is_page;
}

//tested
function _is_product_collection_page() {
    var is_page = !(!window.location.pathname.match("(.*)/collections/(.*)") && !window.location.pathname.match("(.*)/collections") || window.location.pathname.match("(.*)/products/(.*)") || window.location.pathname.match("(.*)/products"))
    //console.log(is_page);
    return is_page;
}

//tested
function allfetchWAP_is_cart_page() {
    var is_page = !(!window.location.pathname.match("(.*)/cart/(.*)") && !window.location.pathname.match("(.*)/cart"));
    //console.log(is_page);
    return is_page;

}

function allfetchWAP_is_blog_page() {
    var is_page = !(!window.location.pathname.match("(.*)/blogs/(.*)") && !window.location.pathname.match("(.*)/blogs"));
    //console.log(is_page);
    return is_page;
}

function allfetchWAP_is_ending_with_pages() {
    var is_page = !(!window.location.pathname.match("(.*)/pages/(.*)") && !window.location.pathname.match("(.*)/pages"));
    //console.log(is_page);
    return is_page;
}

function allfetchWAP_is_thankyou_page() {
    var is_page = !(!window.location.pathname.match("(.*)/thank_you/(.*)") && !window.location.pathname.match("(.*)/thank_you")) ||
        !(!window.location.pathname.match("(.*)/orders/(.*)") && !window.location.pathname.match("(.*)/orders"));

    return is_page;
}

function allfetchWAP_is_account_page() {
    var is_page = !(!window.location.pathname.match("(.*)/account/(.*)") && !window.location.pathname.match("(.*)/account"));
    return is_page;

}

function allfetchWAP_is_checkout_page() {
    var is_page = !(!window.location.pathname.match("(.*)/checkout/(.*)") && !window.location.pathname.match("(.*)/checkout"));
    return is_page;

}

//tested
function allfetchWAP_is_homepage() {
    var is_page = ("/" === window.location.pathname);
    //console.log(is_page);
    return is_page;

}

var giftregistryApp = {}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function submit_form_registry(element) {
    // window.lc_gr_input_error = false;
    //    var registrant_email = jQuery('#registrant_email').val();
    //
    // var validateResult = validateEmail(registrant_email);
    //
    // if (!validateResult) {
    //     jQuery('#lc_gr_form_info').addClass('was-validated');
    // }
    // return validateResult;
    var el = jQuery(element);
    if (el == undefined)
        return false;

    if (el.length > 0) {
        var id = jQuery(element).attr('id');
        if (id == 'lc_gr_form_info') {
            console.log('form');
            var password = $('input[name="password"]').val();
            if (password == undefined) {
                password = ' '
            }

            var is_public = $('input[name="is_public"]:checked').val();

            var data = {
                jsonrpc: '2.0',
                method: 'call',
                registry_id: window.lcRegistryId,
                customer_id: $('input[name="customer_id"]').val(),
                shop_domain: $('input[name="shop_domain"]').val(),
                registrant_first_name: $('input[name="registrant_first_name"]').val(),
                registrant_last_name: $('input[name="registrant_last_name"]').val(),
                registrant_email: $('input[name="registrant_email"]').val(),

                event_title: $('input[name="title"]').val(),
                public_message: $('input[name="public_message"]').val(),
                event_date: $('input[name="event_date"]').val(),
                event_location: $('input[name="event_location"]').val(),
                is_public: is_public,
                password: password,
                sa_first_name: $('input[name="sa_first_name"]').val(),
                sa_last_name: $('input[name="sa_last_name"]').val(),
                sa_phone: $('input[name="sa_phone"]').val(),

                sa_country: $('select[name="sa_country"]').val(),
                sa_city: $('input[name="sa_city"]').val(),
                sa_street: $('input[name="sa_street"]').val(),
                sa_zip: $('input[name="sa_zip"]').val(),

                sa_province: $('input[name="sa_province"]').val(),
                sa_province_code: $('input[name="sa_province_code"]').val(),

            }

            $.ajax({
                url: 'https://app.thexseed.com/gift-registryx/save',
                type: $(element).attr('method'),
                dataType: 'json',
                data: JSON.stringify(data),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
                },
                contentType: "application/json",
                mimetype: 'application/json',
                success: function (data) {
                    location.reload();

                },
                error: function (xhr, err) {
                    jQuery('.banner--success').hide();
                    jQuery('.banner--critical').show();
                    return false;
                }
            });

        } else {
            x = 1;
            return false;
        }
    }


    return false;

}

function renderGiftRegistryDetail(data) {
    var registryData = data.result.registry;
    renderLCForm(registryData);

    var itemsData = data.result.items;
    var orders = data.result.orders;

    renderLCItemTable(itemsData);
    renderLCOrderTable(orders);

}

function lgr_delete_item_action(element) {
    if (element == undefined) return;

    var attrIden = $(element).attr('data-iden');
    if (attrIden == undefined) return;

    var itemId = $(element).attr('data-id');

    if (itemId == undefined) return;

    var data = {
        jsonrpc: '2.0',
        method: 'call',
        id: 1,
        params: {
            item_id: parseInt(itemId),
            customer_id: window.customerId,
            shop_domain: window.lcShopdomain,

        }
    }

    $('#ajax-loader').show();
    $('#ajax-loader').css('visibility', 'visible');
    $.ajax({
        url: 'https://app.thexseed.com/giftregistry/delete_item',
        type: 'POST',
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
        },
        data: JSON.stringify(data),

        contentType: "application/json",
        mimetype: 'application/json',
        error: function () {
            console.log('error');
            //callback();
        },
        success: function (res) {

            location.reload();
        },
        complete: function () {
            $('#ajax-loader').hide();
        }
    });

}

function lgr_edit_item_action(element) {
    if (element == undefined) return;

    var attrIden = $(element).attr('data-iden');
    if (attrIden == undefined) return;
    var tr = $(element).parent().parent();
    var masterData = tr.attr('data-master');
    var itemData = JSON.parse(masterData);

    var productName = itemData.name;
    var qty = itemData.qty;
    var priority = itemData.priority;
    var option = itemData.option;
    var itemId = itemData.id;

    var product_type = itemData.product_type;
    var status = itemData.status;

    $('#edit_item_name').html(productName);
    $('#edit_item_qty').val(qty);
    $('#edit_item_priority').val(priority);
    $('#edit_item_qty_product_type').val(product_type);
    $('#edit_item_id').val(itemId)

    if (product_type == 'variant') {
        if (status == 'not_finish') {
            var optionsJson = JSON.parse(option);
            var strOption = option;
            $("#edit_item_option").empty();

            for (var i = 0; i < optionsJson.length; i++) {
                var op = optionsJson[i];
                var option = $('<option></option>').attr("value", op.variant_id).text(op.variant_title);
                $("#edit_item_option").append(option);
            }
        } else {
            $('#edit_item_option_wrapper').hide();
        }
    } else {
        $('#edit_item_option_wrapper').hide();
    }
    $('#edit_item_btn').attr('data-json', strOption);
    $('#edit_item_btn').attr('data-item-id', itemId);

    $('#lgr_edit_item_form_wrapper').show();
    $('html, body').animate({
        scrollTop: $("#lgr_edit_item_form_wrapper").offset().top
    }, 2000);

}

function submit_edit_item_action(element) {
    //
    if (element != undefined) {
        var id = $(element).attr('id');
        if (id != 'edit_item_btn') return;

        if (id == 'edit_item_btn') {

            var strData = $('#edit_item_btn').attr('data-json');
            var itemId = $('#edit_item_id').val();

            var edit_item_qty = $('#edit_item_qty').val();
            var edit_item_priority = $('#edit_item_priority').val();
            var variant_id = $('#edit_item_option').val();

            var product_type = $('#edit_item_qty_product_type').val();

            //edit the variant pr
            if (product_type == 'variant') {
                var data = {
                    jsonrpc: '2.0',
                    method: 'call',
                    id: 1,
                    params: {
                        registry_id: window.lc_gift_registry_id,
                        item_id: itemId,
                        qty: edit_item_qty,
                        priority: edit_item_priority,
                        variant_id: variant_id,
                        product_type: product_type
                    }
                }
                $.ajax({
                    url: 'https://app.thexseed.com/gift-registry/edit_item',
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
                    },
                    data: JSON.stringify(data),

                    contentType: "application/json",
                    mimetype: 'application/json',
                    error: function () {
                        console.log('error');
                        //callback();
                    },
                    success: function (res) {
                        console.log(res);
                        location.reload();
                    }
                });
            }
        }
    }
}

function generate_qr_code(element) {
    if (element == undefined) return;
    if ($(element).attr('id') == 'btn_qr') {
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: window.fbShareUrl,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }

}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function renderLCItemTable(itemsData) {
    if (itemsData.length == 0) {
        $('#empty_gift_registry_item').show();
        $('#lc-registry-item-table').hide();
        return;
    } else {
        $('#empty_gift_registry_item').hide();
        $('#lc-registry-item-table').show();
    }
    for (var i = 0; i < itemsData.length; i++) {
        var item = itemsData[i];

        if (item.price == false) item.price = '';

        if (item.variant_title == false) item.variant_title = '';

        var htmlRow = '<tr class="lc-item-tr" data-master=\'{{data-master}}\'>\n' +
            '                        <td>#</td>\n' +
            '                        <td> {{name}}</td>\n' +
            '                        <td> {{price}}</td>\n' +
            '                        <td><img class="lc-product-img" src="{{product_img_url}}" alt="{{name}}"/></td>\n' +
            '                        <td><div class="lc_s_product_option" data-id="{{id}}" ><select disabled> <option>{{variant_title}}</option></select></div></td>\n' +
            '                        <td> {{qty}}</td>\n' +
            '                        <td> {{priority}}</td>\n' +
            '                        <td> {{status}}</td>\n' +
            '                        <td>\n' +
            '                            <button data-iden="edit_btn" class="btn" data-id="{{id}}" onclick="lgr_edit_item_action(this)" >Edit</button>\n' +
            '                            <button data-iden="edit_btn"  class="btn" data-id="{{id}}" onclick="lgr_delete_item_action(this)" >Delete</button>\n' +
            '                        </td>\n' +
            '                    </tr>';


        var htmlResult = htmlRow.replace("{{title}}", item.title)
            .replace("{{name}}", item.name)
            .replace("{{name}}", item.name)
            .replace("{{product_img_url}}", item.product_img_url)
            .replace("{{price}}", item.price)
            .replace("{{qty}}", item.qty)
            .replaceAll("{{id}}", item.id)
            .replace("{{status}}", item.status)
            .replace("{{variant_title}}", item.variant_title)
            .replace("{{product_id}}", item.product_id)
            .replace("{{variant_id}}", item.variant_id)
            .replace("{{variant_title}}", item.variant_title)
            .replace("{{priority}}", item.priority)
            .replace("{{data-master}}", JSON.stringify(item));
        jQuery('#lc-registry-item-table').find('tbody').append(htmlResult);
    }
}

function updateLCItemTable(data) {
    var response = data.result;

    if (response == undefined) return;

    if (data.result.new_single_product == undefined) return;

    var items = data.result.new_single_product;

    for (var i = 0; i < items.length; i++) {
        var htmlRow = '<tr class="lc-item-tr">\n' +
            '                                <td> <input type="checkbox" data-id="{{id}}"/> </td>\n' +
            '                                <td> {{Product Name}}</td>\n' +
            '                                <td> {{Desired qty}}</td>\n' +
            '                                <td> {{Priority}}</td>\n' +
            '                            </tr>';
        var item = items[i];
        var htmlRow = '<tr class="lc-item-tr row_template" style="display: none">\n' +
            '                        <td>#</td>\n' +
            '                        <td> {{Product Name}}</td>\n' +
            '                        <td> {{price}}</td>\n' +
            '                        <td><img class="lc-product-img" src="{{product_img_url}}" alt="{{Product Name}}"/></td>\n' +
            '                        <td><div class="lc_s_product_option" data-id="{{id}}" ><select> <option>None</option></select></div></td>\n' +
            '                        <td> {{Desired qty}}</td>\n' +
            '                        <td> {{Priority}}</td>\n' +
            '                        <td> <button class="btn" data-id="{{id}}" >Edit</button> <button class="btn"data-id="{{id}}" >Delete</button></td>\n' +
            '                    </tr>';

        var htmlResult = htmlRow.replace("{{title}}", item.title)
            .replace("{{Product Name}}", item.name)
            .replace("{{Product Name}}", item.name)
            .replace("{{Desired qty}}", item.qty)
            .replace("{{id}}", item.id)
            .replace("{{id}}", item.id)
            .replace("{{id}}", item.id)
            .replace("{{price}}", item.price)
            .replace("{{product_img_url}}", item.product_img_url)
            .replace("{{Priority}}", item.priority);
        jQuery('#lc-registry-item-table').find('tbody').append(htmlResult);
    }
}

function renderLCOrderTable(itemsData) {
    if (itemsData.length == 0) {
        $('#empty_gift_registry_order').show();
        jQuery('#lc-registry-order-tbl').hide();
    } else {
        $('#empty_gift_registry_order').hide();
        jQuery('#lc-registry-order-tbl').show();
    }
    for (var i = 0; i < itemsData.length; i++) {
        var htmlRow = '<tr>\n' +
            '                                <td> <input type="checkbox" data-id="{{id}}"/></td>\n' +
            '                                <td>{{order_id}}</td>\n' +
            '                                <td> {{note}}</td>\n' +
            '                                <td>{{create_date}}</td>\n' +
            '                            </tr>';
        var item = itemsData[i];

        var htmlResult = htmlRow.replace("{{order_id}}", item.order_id)
            .replace("{{note}}", item.note)
            .replace("{{Product Name}}", item.name)
            .replace("{{create_date}}", item.create_date)
            .replace("{{id}}", item.id);
        jQuery('#lc-registry-order-tbl').find('tbody').append(htmlResult);
    }
}

function mas_r_copy_sharelink(element) {
    if (element == undefined) return;
    var idAttr = $(element).attr('id');
    if (idAttr == 'mas_r_sharelink_img') {
        /* Get the text field */
        var copyText = document.getElementById("mas_r_sharelink_input_text");

        /* Select the text field */
        copyText.select();
        // copyText.setSelectionRange(0, 99999);

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);
        alert('The unique url of your gift registry is copied.You can post it on Blog, Facebook,Instagram to share with your friend' );
    }


}

function fbs_click() {
    var u = window.fbShareUrl;
    var t = document.fbShareTitle;
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t),
        'sharer',
        'toolbar=0,status=0,width=626,height=436');

    return false;
}

function renderLCForm(registryData) {

    window.lc_detail_gift_registry_id = registryData.id;
    var not_encode_link = window.lcShopdomain + '/apps/gift-registry/view/' + registryData.id.toString();
    window.fbShareUrl = not_encode_link;
    window.fbShareTitle = 'My gift registry';

    $('#share_not_encode_link').html(not_encode_link);
    $('#mas_r_sharelink_input_text').val(not_encode_link);
    var encodeUrl = encodeURIComponent(not_encode_link);
    // var fbshareLink ="https://www.facebook.com/sharer.php?s=100" + "&amp;p[url]" + encodeUrl;
    // $('#mas_facebook_share').attr('href',fbshareLink);
    //$twitter_share_link  = "https://twitter.com/share?url=" . $url . "&amp;text=" . $twitter_summary;
    var twshareLink = "https://twitter.com/share?url=" + encodeUrl;

    $('#mas_tw_share').attr('href', twshareLink);


    if (registryData.registrant_first_name) jQuery('input[name="registrant_first_name"]').val(registryData.registrant_first_name);
    if (registryData.registrant_last_name) jQuery('input[name="registrant_last_name"]').val(registryData.registrant_last_name);
    if (registryData.registrant_email) jQuery('input[name="registrant_email"]').val(registryData.registrant_email);

    if (registryData.title) jQuery('input[name="title"]').val(registryData.title);
    if (registryData.event_date) jQuery('input[name="event_date"]').val(registryData.event_date);
    if (registryData.event_location) jQuery('input[name="event_location"]').val(registryData.event_location);
    if (registryData.public_message) jQuery('input[name="public_message"]').val(registryData.public_message);

    if (registryData.sa_first_name) jQuery('input[name="sa_first_name"]').val(registryData.sa_first_name);
    if (registryData.sa_last_name) jQuery('input[name="sa_last_name"]').val(registryData.sa_last_name);
    if (registryData.sa_phone) jQuery('input[name="sa_phone"]').val(registryData.sa_phone);

    // if (registryData.sa_country) jQuery('select[name="sa_country"]').val(registryData.sa_country_code);

    if (registryData.sa_city) jQuery('input[name="sa_city"]').val(registryData.sa_city);
    if (registryData.sa_street) jQuery('input[name="sa_street"]').val(registryData.sa_street);
    if (registryData.sa_zip) jQuery('input[name="sa_zip"]').val(registryData.sa_zip);

    if (registryData.sa_province) jQuery('input[name="sa_province"]').val(registryData.sa_province);
    if (registryData.sa_province_code) jQuery('input[name="sa_province_code"]').val(registryData.sa_province_code);

    if (registryData.is_public == 1 || registryData.is_public == '1' || registryData.is_public == true) {
        jQuery('#is_public').prop('checked', true);
        jQuery('#is_private').prop('checked', false);
    } else {
        jQuery('#is_public').prop('checked', false);
        jQuery('#is_private').prop('checked', true);

        $('#password_form_group').show();
    }

    if (registryData.sa_country_code) jQuery('select[name="sa_country"]').select2().val(registryData.sa_country_code).trigger("change");
}

function openRegistryTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it


window.isLoadGr = false;

function lc_back_registry() {
    jQuery('#lc_gift_registry_list_container').show();
    jQuery('#lcr_dashboard_container').hide();


}

function registry_delete(element) {

    if (element == undefined) return;

    var attr_item = $(element).attr('data-item');

    if (attr_item != undefined) {
        var id = parseInt(jQuery(element).attr('data-item'));
        var customer_id = parseInt(window.customerId);

        var data = {
            jsonrpc: '2.0',
            method: 'call',
            id: 1,
            params: {
                registry_id: id,
                customer_id: customer_id,
            }
        }

        $('#ajax-loader').show();
        $('#ajax-loader').css('visibility', 'visible');

        $.ajax({
            url: 'https://app.thexseed.com/delete-gift-registry/by_id',
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
            },
            data: JSON.stringify(data),

            contentType: "application/json",
            mimetype: 'application/json',
            error: function () {
                console.log('error');
                //callback();
            },
            success: function (res) {
                location.reload();
            },
            complete: function () {
                $('#ajax-loader').hide();
                // location.reload();
            }
        });
    }

}

function registry_detail(element) {
    var id = parseInt(jQuery(element).attr('data-item'));

    window.lcRegistryId = id;
    //json get detail of registry  then display it by updating the DOM

    //hide the gift registry list
    jQuery('#lc_gift_registry_list_container').hide();
    //ajax get the gift registry detail
    jQuery('#lcr_dashboard_container').show();

    //var customer_id = window.customerId;
    var shop_domain = window.lcShopdomain;

    var data = {
        jsonrpc: '2.0',
        method: 'call',
        id: 1,
        params: {
            registry_id: id,
            shop_domain: shop_domain,
        }
    }

    $('#ajax-loader').show();
    $('#ajax-loader').css('visibility', 'visible');
    $.ajax({
        url: 'https://app.thexseed.com/get-gift-registry/by_id',
        type: 'POST',
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
        },
        data: JSON.stringify(data),

        contentType: "application/json",
        mimetype: 'application/json',
        error: function () {
            console.log('error');
            //callback();
        },
        success: function (res) {
            renderGiftRegistryDetail(res);
        },
        complete: function () {
            $('#ajax-loader').hide();
        }
    });


}


function parseGiftRegistry(data) {
    var x = data;
    if (data.result == undefined) {
        return false;

    }

    if (data.result.length == 0) {
        $('#empty_gift_registry').show();
        $('#gift-registry-list').hide();
        return;
    } else {
        $('#empty_gift_registry').hide();
        $('#gift-registry-list').show();
    }

    for (var i = 0; i < data.result.length; i++) {

        var htmlRow = ' <tr>\n' +
            '            <td> <input type="checkbox" value="0" name="registry_cb" /></td>\n' +
            '            <td> {{title}}</td>\n' +
            '            <td> {{registrant_first_name}}</td>\n' +
            '            <td> {{registrant_last_name}}</td>\n' +
            '            <td> {{event_date}}</td>\n' +
            '            <td> {{status}}</td>\n' +
            '            <td> <button class="btn"  data-item="{{id}}" onclick="registry_delete(this)" > Delete</button> <button class="btn"  data-item="{{id}}" onclick="registry_detail(this)" >Detail</button></td>\n' +
            '        </tr>';
        var item = data.result[i];

        var htmlResult = htmlRow.replace("{{title}}", item.title).replace("{{registrant_first_name}}", item.registrant_first_name)
            .replace("{{registrant_last_name}}", item.registrant_last_name)
            .replace("{{id}}", item.id).replace("{{id}}", item.id).replace("{{event_date}}", item.event_date).replace("{{status}}", item.status);

        jQuery('#gift-registry-list').find('tbody').append(htmlResult);
    }
}

function loadGiftRegistry() {
    ////enable the app
    if ( window.lcShopdomain == undefined) {
      var domain =   allfetchWAPGetShopify();
      window.lcShopdomain = domain;
    }
     var data = {
            jsonrpc: '2.0',
            method: 'call',
            id: 1,
            params: {
                shop_domain: window.lcShopdomain,

            }
        }

        $('#ajax-loader').show();
        $('#ajax-loader').css('visibility', 'visible');
        $.ajax({
            url: 'https://app.thexseed.com/gift-registry/get_store_status',
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
            },
            data: JSON.stringify(data),

            contentType: "application/json",
            mimetype: 'application/json',
            error: function () {
                console.log('error');
                //callback();
            },
            success: function (res) {
              var response = res;
              var responseStatus = response.result[0];

              if (responseStatus.status == false) {
                 if ($('#lc_gift_registry_list_container').length > 0 ) $('#lc_gift_registry_list_container').hide();
                 if ($('#lcr_dashboard_container').length > 0 ) $('#lcr_dashboard_container').hide();
                 if ($('#lc_gift_registry_list_container_not_signed_in').length > 0 )$('#lc_gift_registry_list_container_not_signed_in').hide();
                 if ($('#lc_gift_registry_list_container_public_view').length > 0 )$('#lc_gift_registry_list_container_public_view').hide();

                 if ($('#gift_registry_link').length > 0 )$('#gift_registry_link').hide();
              }
            },
            complete: function () {
                $('#ajax-loader').hide();
            }
        });
    ////
        if (allfetchWAP_is_account_page()) {
        var is_append_gr = jQuery('body').attr('is_append_gr');

        if (is_append_gr != '1') {
            if ($('#customer_logout_link') != undefined && $('#customer_logout_link').length > 0) {
                $('#customer_logout_link').parent().append('<div><a id="gift_registry_link" href="/apps/gift-registry/list" >Gift Registry </a> </div>');
                jQuery('body').attr('is_append_gr', '1');
            }

        }
    }

     if(typeof $.fn.select2 == 'undefined' || typeof $.fn.selectize == 'undefined' || typeof $.fn.flatpickr == 'undefined' || typeof $.fn.tooltipster == 'undefined') {
         var x = 1;
             if (window.lc_gift_registry_id != undefined) {
        var processed = jQuery('#lc_public_registry').attr('data-process');

        if (processed != '1') {
            var data = {
                jsonrpc: '2.0',
                method: 'call',
                id: 1,
                params: {
                    registry_id: window.lc_gift_registry_id
                }
            }
            $.ajax({
                url: 'https://app.thexseed.com/get-gift-registry-public/by_id_public_view',
                type: 'POST',
                dataType: 'json',
                beforeSend: function (xhr) {
                    $('.ajax-loader').show();
                    $('.ajax-loader').css('visibility', 'visible');
                    xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
                },
                data: JSON.stringify(data),

                contentType: "application/json",
                mimetype: 'application/json',
                error: function () {
                    console.log('error');
                    //callback();
                },
                success: function (res) {
                    $('.ajax-loader').hide();
                    renderGiftRegistryPublic(res);
                }
            });

            // jQuery('#visible-banner')
            jQuery('#lc_public_registry').attr('data-process', '1');
        }
    }
     }  else {
    var is_load_gr = jQuery('body').attr('is_load_gr');
    if (!window.isLoadGr && window.customerId != undefined && is_load_gr != '1') {

        var data = {
            jsonrpc: '2.0',
            method: 'call',
            id: 1,
            params: {
                customer_id: window.customerId,
                shop_domain: window.lcShopdomain,

            }
        }

        $('#ajax-loader').show();
        $('#ajax-loader').css('visibility', 'visible');
        $.ajax({
            url: 'https://app.thexseed.com/get-gift-registry/customer',
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                jQuery('body').attr('is_load_gr', '1');
                xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
            },
            data: JSON.stringify(data),

            contentType: "application/json",
            mimetype: 'application/json',
            error: function () {
                console.log('error');
                //callback();
            },
            success: function (res) {
                console.log(res);

                parseGiftRegistry(res);
            },
            complete: function () {
                $('#ajax-loader').hide();
            }
        });

        //get country json
        $.ajax({
            url: 'https://app.thexseed.com/gr_search/country',
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
            },
            data: JSON.stringify(data),

            contentType: "application/json",
            mimetype: 'application/json',
            error: function () {
                console.log('error');
                //callback();
            },
            success: function (res) {
                $("select[name='sa_country']").select2({
                    data: res.result
                });


            },

        });
        //end of get country json


        window.isLoadGr = true;
    }

    if (jQuery('#lcr_dashboard_container').length > 0) {
        var processed = jQuery('#lcr_dashboard_container').attr('data-process');
        if (processed != '1') {
            jQuery('#lcr_dashboard_container').attr('data-process', '1');
            jQuery('#lcr_dashboard_container').hide();

            $('#lcselect-product').selectize({
                valueField: 'id',
                labelField: 'title',
                searchField: 'title',
                options: [],
                create: false,
                render: {
                    option: function (item, escape) {
                        var actors = [];
                        for (var i = 0, n = item.length; i < n; i++) {
                            actors.push('<span>' + escape(item[i].title) + '</span>');
                        }

                        return '<div>' +

                            '<span class="title">' +
                            '<span class="name">' + escape(item.title) + '</span>' +
                            '</span>' +
                            '</div>';
                    },
                    'item': function (data, escape) {
                        return '<div class="item" ' + 'data-img="' + data.title + '"' + ' >' + escape(data.title) + '</div>';
                    }
                },
                load: function (query, callback) {
                    var data = {
                        param: {
                            query
                        },
                        shop_domain: window.lcShopdomain
                    }
                    if (!query.length) return callback();
                    $.ajax({
                        url: 'https://app.thexseed.com/giftregistry/search_product',
                        type: 'POST',
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
                        },
                        data: JSON.stringify(data),
                        contentType: "application/json",
                        error: function () {
                            // callback();
                        },
                        success: function (res) {
                            console.log(res);
                            callback(res.result);
                        }
                    });
                }
            });

        }
    }

    if (jQuery('#lc-registry-form-tab').length > 0) {
        var processed = jQuery('#lc-registry-form-tab').attr('data-process');
        if (processed != '1') {
            jQuery('#lc-registry-form-tab').attr('data-process', '1');
            document.getElementById("lc-registry-form-tab").click();

            //trigger init global
             $('.tooltipster').tooltipster();
            var flatpcickrConf = {
                enableTime: false,
                dateFormat: "d-m-Y"
            };
            $("input[name='event_date']").flatpickr(flatpcickrConf);

            jQuery('.banner').hide();
            jQuery('#lgr_edit_item_form_wrapper').hide();
            jQuery('#item-banner').hide();
            var data = {
                shop_domain: window.lcShopdomain
            }

            $('#password_form_group').hide();
            $('input:radio[name="is_public"]').change(function () {
                if ($(this).val() == '0') {
                    $('#password_form_group').show();
                } else {
                    $('#password_form_group').hide();
                    ;
                }
            });
        }
        //////
        // document.getElementById('giraffe').oninput = function() { this.classList.add('error-input-border'); }
    }



}
     }


function mas_submit_password(element) {
    console.log('click button');
    if (element != undefined) {
        var name = $(element).attr('name');

        if (name == 'password_submit') {
            var passw = $('#mas_password').val();

            if (passw == '' || passw == undefined) {
                alert('Please enter password');
                return false;
            }
            var data = {
                jsonrpc: '2.0',
                method: 'call',
                id: 1,
                params: {
                    registry_id: window.lc_gift_registry_id,
                    password: passw
                }
            }
            $.ajax({
                url: 'https://app.thexseed.com/get-gift-registry-public/unlock',
                type: 'POST',
                dataType: 'json',
                beforeSend: function (xhr) {
                    $('.ajax-loader').show();
                    $('.ajax-loader').css('visibility', 'visible');
                    xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
                },
                data: JSON.stringify(data),

                contentType: "application/json",
                mimetype: 'application/json',
                error: function () {
                    console.log('error');
                    //callback();
                },
                success: function (res) {
                    $('.ajax-loader').hide();
                    renderGiftRegistryPublicForLockedItem(res);
                }
            });

        }
    }
}

function displayPublicTable(data) {
    var items = data.result.items;
    var registry = data.result.registry;

    jQuery('#lcgf_public_message').html(registry.public_message);
    window.public_registry_id = registry.id;

    for (var i = 0; i < items.length; i++) {
        var item = items[i];

        if (!item.variant_title) item.variant_title = 'None';

        var htmlRow = '<tr class="">\n' +
            '                                <td>{{name}}</td>\n' +
            '                                <td>{{price}}</td>\n' +
            '                                <td><img class="lc-product-img" src="{{product_img_url}}" alt="{{name}}"/></td>\n' +
            '                                <td><div class="lc_s_product_option" data-id="{{id}}" ><select disabled> <option>None</option></select></div></td>\n' +
            '                                <td> {{priority}}</td>\n' +
            '                                <td><input type="text" id="public_gr_qt" name="qty" data-productid="{{id}}"y value="{{qty}}"/></td>\n' +
            '                                <td>\n' +
            '                                    <button class="btn btn-primary" data-productid="{{id}}" data-variant-id="{{variant_id}}"\n' +
            '                                            onclick="lc_gc_add_to_cart(this)"> Add to cart\n' +
            '                                    </button>\n' +
            '                                </td>\n' +
            '                            </tr>';
        var htmlResult = htmlRow.replaceAll('{{name}}', item.name)
            .replace('{{price}}', item.price)
            .replace('{{qty}}', item.qty)
            .replace('{{priority}}', item.priority)
            .replaceAll('{{id}}', item.id)
            .replaceAll('None', item.variant_title)
            .replaceAll('{{variant_id}}', item.variant_id)
            .replace('{{product_img_url}}', item.product_img_url);

        jQuery('#lc_rg_public_view_tbl').append(htmlResult);

    }

}

function renderGiftRegistryPublic(data) {
    var items = data.result.items;
    var registry = data.result.registry;

    if (!registry.is_public) {
        var password = registry.password;

        $('#lc_rg_table_wrapper').hide();
        $('#lcgf_public_message').parent().hide();
        $('#mas_pw_protect_container').show();


    } else {
        $('#lc_rg_table_wrapper').show();
        $('#lcgf_public_message').parent().show();

        $('#mas_pw_protect_container').hide();
        displayPublicTable(data);
    }
}

function renderGiftRegistryPublicForLockedItem(data) {
    var items = data.result.items;
    var registry = data.result.registry;

    if (registry.status == '403') {

        $('#lc_rg_table_wrapper').hide();
        $('#mas_pw_protect_container').show();
        var message = 'Your password is incorrect';

        var html = '<span id="mas_incorrect_password" data-count="0" style="color: red">' + message + '</span>';

        if ($('#mas_incorrect_password').length > 0) {
            var c = $('#mas_incorrect_password').attr('data-count');
            var c_int = parseInt(c);

            var c_int = c_int + 1;
            $('#mas_incorrect_password').attr('data-count',c_int);
            message = 'Your password is incorrect ' +  c_int + ' times';
            $('#mas_incorrect_password').html(message);

        } else {
            $('#mas_pw_protect_container').append(html);
        }

    } else {

        $('#lc_rg_table_wrapper').show();
        $('#mas_pw_protect_container').hide();

        displayPublicTable(data);
    }
}

function lc_gr_add_new_gift_registry(element) {
    jQuery('#lc_gift_registry_list_container').hide();
    jQuery('#lcr_dashboard_container').show();

    window.lcRegistryId = 0;
    jQuery('body').attr('lc_is_add_new', '1');

}

function lc_gc_add_to_cart(element) {
    if (element != undefined) {
        var el = jQuery(element);
        if (el != undefined) {
            var productId = el.attr('data-productid');
            var variant_id = el.attr('data-variant-id');

            if (productId != undefined) {
                var refineProductId = parseInt(productId);
                if (refineProductId != NaN) {
                    var qtyEl = $(element).parent().prev().find('input');
                    var qty = qtyEl.val();
                    var data = {
                        jsonrpc: '2.0',
                        method: 'call',
                        id: 1,
                        params: {
                            product_id: refineProductId,
                            variant_id: variant_id,
                            registry_id: window.public_registry_id,
                            shop_domain: window.lcShopdomain,
                            qty: qty
                        }
                    };
                    $.ajax({
                        url: 'https://app.thexseed.com/gift-registry/checkout',
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function (xhr) {
                            $('.ajax-loader').show();
                            $('.ajax-loader').css('visibility', 'visible');
                            xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
                        },
                        data: JSON.stringify(data),

                        contentType: "application/json",
                        mimetype: 'application/json',
                        error: function () {
                            console.log('error');
                            //callback();
                        },
                        success: function (res) {
                            $('.ajax-loader').hide();
                            if (typeof res.result != 'undefined' && typeof res.result.checkout != 'undefined') {
                                window.location = res.result.checkout.invoice_url
                            }
                        }
                    });
                }
            }
        }
    }

}

function myFunction() {
    myVar = setInterval(loadGiftRegistry, 200);
}

// myFunction();

function lcGRaddproduct(element) {

    var vals = $('#lcselect-product').selectize().val();
    var inputDiv = $('.selectize-input');

    var productsArr = [];

    var inputC = inputDiv.find('.item');
    inputC.each(function (index) {
        var title = $(this).attr('data-img');
        var value = $(this).attr('data-value');
        productsArr.push({'title': title, 'id': value});

    });

    var data = {
        jsonrpc: '2.0',
        method: 'call',
        id: 1,
        params: {
            products: productsArr,
            shop_domain: window.lcShopdomain,
            customer_id: window.customerId,
            registry_id: window.lcRegistryId,
        }
    };

    $.ajax({
        url: 'https://app.thexseed.com/giftregistry/save_gift_registry_item',
        type: 'POST',
        dataType: 'json',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Content-Type', 'application/json', 'Access-Control-Allow-Origin', '*');
        },
        data: JSON.stringify(data),

        contentType: "application/json",
        mimetype: 'application/json',
        error: function () {
            console.log('error');
            //callback();
        },
        success: function (res) {
            // console.log(res);
            //updateLCItemTable(res);
            location.reload();

        }
    });

    //check if it not exist in table then add to table
    //send request to server to save in database


}

initJQuery(function () {
    if (window.AllFetchURL == undefined) {
        window.AllFetchURL = 'https://app.thexseed.com';
        initCss(window.lcregistry);
        initCss2();
    } else {
        //console.log('---processed--');
    }

});


    setTimeout(loadGiftRegistry, 200);
   setTimeout(loadGiftRegistry, 500);
   setTimeout(loadGiftRegistry, 1000);
   setTimeout(loadGiftRegistry, 3000);




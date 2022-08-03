function maswagetCookie(name) {
    function escape(s) { return s.replace(/([.*+?\^$(){}|\[\]\/\\])/g, '\\$1'); }
    var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
    return match ? match[1] : null;
}
function maswasetCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";";
}
function maswaeraseCookie(name) {
    document.cookie = name + '=; Max-Age=-99999999;';
}
jQuery(document).ready(function () {
    jQuery('#wa-chat-bubble').hide();

    if (maswaObj.isUserLogin) {
        var popupCookieForWA = maswagetCookie('maswapopup');
        if (popupCookieForWA != null) {
            jQuery('#add_to_cart_mask').hide();

        } else {
            jQuery('.single_add_to_cart_button ').hide();
            jQuery('#add_to_cart_mask').click(function () {
                maswasetCookie('maswpopup', 'opened');
                jQuery.featherlight('#wa-optin', {

                    afterClose: function (event) {
                        jQuery('.single_add_to_cart_button ').click();
                        //code here
                    }
                });

            });
        }
    }
});
maswaObj.close = function (element) {
    jQuery('#wa-chat-bubble').hide();
    jQuery('#wa-chat-btn-root').show();

}


maswaObj.openWidget = function (element) {
    jQuery('#wa-chat-bubble').show();
    jQuery('#wa-chat-btn-root').hide();
}
maswaObj.html_chat_box = '<div id="wa-chat-btn-root"  class="wa-chat-btn-fixed wa-splmn-chat-btn-offset wa-chat-btn-base-cta wa-chat-btn-container-size-big wa-chat-btn-theme-cta-new" onclick="maswaObj.openWidget(this)">' +
    '<img class="wa-chat-btn-icon-cta-big" alt="Whatsapp Chat Button" style="" ' +
    'src="{{whatsapp_icon_url}}">' +
    '<div id="wa-chat-button-cta-text" style="">{{click_here}}</div>' +
    '</div>';
maswaObj.html_widget_header = '<div  onclick="maswaObj.close(this)" id="wa-chat-bubble"\n' +
    '     class="wa-chat-bubble-floating-popup animated wa-greeting-widget-z-index wa-chat-bubble-pos-right bounceUp">\n' +
    '    <div  onclick="maswaObj.close(this)" class="wa-chat-bubble-header-common wa-chat-bubble-header-1">\n' +
    '        <div class="wa-chat-bubble-close-btn" onclick="maswaObj.close(this)"><img style="display: table-row"\n' +
    '                                                   src="{{close_icon_url}}">\n' +
    '        </div>\n' +
    '        <div class="wa-chat-bubble-header-title" style="">{{greeting1}}!!!</div>\n' +
    '        <div class="wa-chat-bubble-header-desc" style="">\n' +
    '            {{greeting2}}\n' +
    '        </div>\n' +
    '    </div>\n' +
    '    <div class="wa-chat-bubble-chat">\n' +
    '        <div class="wa-chat-multiple-cs">';
maswaObj.html_widget_footer = '       </div>\n' +
    '    </div> </div>';

jQuery(document).ready(function () {
    jQuery('#wa-chat-bubble').hide();

    var data = { action: 'maswa_ajax_get_agents' };
    jQuery.ajax({
        type: 'post',
        url: maswaObj.adminUrl,
        data: data,
        beforeSend: function (response) {
        },
        success: function (response) {

            // console.log(response);
            let hasGr = Array.isArray(response);

            if (hasGr && maswaObj.chat_box_enable == 'yes') {
                maswaObj.items = response;
                appendChatbox();
                appendWidget();
            } else {
                // viewModel.state('empty');
                // viewModel.gifts.push();
            }
        },
        complete: function (response) {
            // viewModel.state('loaded');
        },
    });

    // jQuery('body').append(html_chat_box);
    //  jQuery('body').append(html_agent);

    //if customer click on confirm , store the phone number


});

function maswaClosePopup(element) {
    jQuery.featherlight.close();
}
function popupWhatsapp(element) {
    jQuery.featherlight.close();
    var phoneNo ;

    var countryCode = jQuery('#wa-optin-country-code').val();
    var phoneNumber = jQuery('#wa-optin-phone-number').val();
    jQuery('.input-country-code').each(function (index,element) {
      if (jQuery(element).val() != '')  {
          countryCode= jQuery(element).val();
      }
    });
    jQuery('.input-maswa-phoneno').each(function (index,element) {
      if (jQuery(element).val() != '')  {
          phoneNumber= jQuery(element).val();
      }
    });
    if (countryCode ==undefined || countryCode =='' || phoneNumber == undefined || countryCode=='') {
        alert('please enter valid phone number');
        return;
    } else {
        phoneNo = countryCode + phoneNumber;
        var data = { action: 'maswa_ajax_save_customer_phoneno', 'phoneno': phoneNo };
        jQuery.ajax({
            type: 'post',
            url: maswaObj.adminUrl,
            data: data,
            beforeSend: function (response) {
            },
            success: function (response) {

                // console.log(response);
                let hasGr = Array.isArray(response);

                if (hasGr && maswaObj.chat_box_enable == 'yes') {

                } else {
                    // viewModel.state('empty');
                    // viewModel.gifts.push();
                }
            },
            complete: function (response) {
                // viewModel.state('loaded');
            },
        });

    }
}
function appendChatbox() {
    maswaObj.html_chat_box = maswaObj.html_chat_box.replace('{{whatsapp_icon_url}}', maswaObj.whatsapp_icon_url)
        .replace('{{click_here}}', maswaObj.click_here);
    jQuery('body').append(maswaObj.html_chat_box);
}

function appendWidget() {
    refineHeaderWidget();
    var html = "";
    for (var i = 0; i < maswaObj.items.length; i++) {
        var currentAgent = maswaObj.items[i];
        html = html + refineTemple(currentAgent);
    }
    var widgetHtml = maswaObj.html_widget_header + html + maswaObj.html_widget_footer;
    jQuery('body').append(widgetHtml);
    jQuery('#wa-chat-bubble').hide();


}

function refineHeaderWidget() {
    var headerHtml = maswaObj.html_widget_header.replace("{{close_icon_url}}", maswaObj.close_icon_url)
        .replace("{{greeting1}}", maswaObj.greeting1)
        .replace("{{greeting2}}", maswaObj.greeting2)
        ;

    maswaObj.html_widget_header = headerHtml;
}
/** item is object **/
function refineTemple(item) {
    var htmlRow = '<div number="{{phone}}" id={{phone}} class="list-cs" onclick="maswaTalkToAgent({{phone}})">\n' +
        '                <div><img class="wa-chat-bubble-whatsapp-avatar"\n' +
        '                          src="{{wa_icon_url}}">\n' +
        '                    <div class="wa-chat-bubble-avatar"><img style="height: 55px; width: 55px; border-radius: 50%; "\n' +
        '                                                            class="avatar-theme-1"\n' +
        '                                                            src="{{wa_ava_url}}">\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="wa-chat-bubble-cs-profile">\n' +
        '                    <div class="wa-chat-bubble-profile-name">{{cs_name}}</div>\n' +
        '                    <p>{{cs_role}}</p></div>\n' +
        '            </div>';
    var phone = item.country_code + item.phone_number;
    var htmlResult = htmlRow.replace("{{wa_icon_url}}", item.wa_icon_url)
        .replace("{{wa_ava_url}}", item.avatar)
        .replace("{{cs_name}}", item.agent_name)
        .replaceAll("{{phone}}", phone)
        .replace("{{cs_role}}", item.agent_role);
    return htmlResult;
}

function maswaTalkToAgent(number) {
    var encoded= "Hello";
    var link = "https://wa.me/" + number + "/?text=" + encoded;
    window.open(link);
}

'use strict';
jQuery(document).ready(function () {
    jQuery('.lmask').css('display','none');
    jQuery('.vi-ui.tabular.menu .item').vi_tab({
        history: true,
        historyType: 'hash'
    });


    /*Init JS input*/
    jQuery('.vi-ui.checkbox').checkbox();
    jQuery('select.vi-ui.dropdown').dropdown();
    jQuery('.select2').select2();

    // jQuery("#IncludeFieldsMulti").select2("val", selectedItems);

    /*Save Submit button*/
    jQuery('.wlb-submit').one('click', function () {
        jQuery(this).addClass('loading');
    });
    jQuery('.select2-multiple').select2({
        width: '100%' // need to override the changed default
    });
    /*Color picker*/
    jQuery('.color-picker').iris({
        change: function (event, ui) {
            jQuery(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
            var ele = jQuery(this).data('ele');
            if (ele == 'highlight') {
                jQuery('#message-purchased').find('a').css({'color': ui.color.toString()});
            } else if (ele == 'textcolor') {
                jQuery('#message-purchased').css({'color': ui.color.toString()});
            } else {
                jQuery('#message-purchased').css({backgroundColor: ui.color.toString()});
            }
        },
        hide: true,
        border: true
    }).click(function () {
        jQuery('.iris-picker').hide();
        jQuery(this).closest('td').find('.iris-picker').show();
    });

    jQuery('body').click(function () {
        jQuery('.iris-picker').hide();
    });
    jQuery('.color-picker').click(function (event) {
        event.stopPropagation();
    });

    jQuery('.wlb-get-access-token').on('click', function (e) {
        var popup_frame;
        e.preventDefault();
        var url = jQuery(this).attr('data-href');
        popup_frame = window.open(url, "myWindow", "width=500,height=300");
        popup_frame.focus();
        var timer = setInterval(function () {
            if (popup_frame.closed) {
                clearInterval(timer);
                window.location.reload(); // Refresh the parent page
            }
        }, 1000);
    });

    jQuery('.wlb-nav-pos select').on('change', function () {
        if (jQuery(this).val() === '0') {
            jQuery('.wlb-alignment').hide();
        } else {
            jQuery('.wlb-alignment').show();
        }
    });



    /**
     * Start Get download key
     */
    jQuery('.villatheme-get-key-button').one('click', function (e) {
        let v_button = jQuery(this);
        v_button.addClass('loading');
        let data = v_button.data();
        let item_id = data.id;
        let app_url = data.href;
        let main_domain = window.location.hostname;
        main_domain = main_domain.toLowerCase();
        let popup_frame;
        e.preventDefault();
        let download_url = v_button.attr('data-download');
        popup_frame = window.open(app_url, "myWindow", "width=380,height=600");
        window.addEventListener('message', function (event) {
            /*Callback when data send from child popup*/
            let obj = jQuery.parseJSON(event.data);
            let update_key = '';
            let message = obj.message;
            let support_until = '';
            let check_key = '';
            if (obj['data'].length > 0) {
                for (let i = 0; i < obj['data'].length; i++) {
                    if (obj['data'][i].id == item_id && (obj['data'][i].domain == main_domain || obj['data'][i].domain == '' || obj['data'][i].domain == null)) {
                        if (update_key == '') {
                            update_key = obj['data'][i].download_key;
                            support_until = obj['data'][i].support_until;
                        } else if (support_until < obj['data'][i].support_until) {
                            update_key = obj['data'][i].download_key;
                            support_until = obj['data'][i].support_until;
                        }
                        if (obj['data'][i].domain == main_domain) {
                            update_key = obj['data'][i].download_key;
                            break;
                        }
                    }
                }
                if (update_key) {
                    check_key = 1;
                    jQuery('.villatheme-autoupdate-key-field').val(update_key);
                }
            }
            v_button.removeClass('loading');
            if (check_key) {
                jQuery('<p><strong>' + message + '</strong></p>').insertAfter(".villatheme-autoupdate-key-field");
                jQuery(v_button).closest('form').submit();
            } else {
                jQuery('<p><strong> Your key is not found. Please contact support@villatheme.com </strong></p>').insertAfter(".villatheme-autoupdate-key-field");
            }
        });
    });
    /**
     * End get download key
     */

    /**
     * if the key is set then save it , then get the boards, if reponse is 200 then show connected icon
     * if not then show not connected.
     *
     */
    jQuery( "#trello_card" )
        .change(function () {
            var str = "";
            jQuery( "select option:selected" ).each(function() {

                var masrAjaxUrl,masrUserLoggedIn,trelloToken;
                masrAjaxUrl = jQuery('#mastrello_admin_url').attr('data-adminurl') + '?action=trello_fetch_list';
                masrUserLoggedIn = jQuery('#mastrello_admin_url_user_id').attr('data-userid');
                trelloToken = jQuery('#trello-key').val();
                var boardId =  jQuery(this).val();
                if (boardId !=0 && boardId !='0' && boardId !=1 && boardId !='1') {
                    jQuery('.lmask').css('display','block');

                    jQuery.ajax({
                        type: "post",
                        url: masrAjaxUrl,
                        data: {
                            data_token: trelloToken,
                            board_id: jQuery(this).val()
                        },
                        success: function(response){
                            jQuery('.lmask').css('display','none');

                            jQuery('#trello_list').children().remove();

                            var cardObjs = JSON.parse(response);
                            for (var key in cardObjs) {
                                if (cardObjs.hasOwnProperty(key)) {
                                    console.log(key + " -> " + cardObjs[key]);
                                    var optionText =  cardObjs[key];
                                    jQuery('#trello_list').append(new Option(optionText, key));
                                }
                            }

                            if (init_board_value != undefined && init_board_value !='' && init_card_value!=0) {
                                jQuery('#trello_list').val(init_board_value).change();

                            }

                        }
                    });
                }
            });
        })
        .change();
    /**
     * init the value for card
     */
    var init_card_value = jQuery('#trello_card_init').attr('data-value');
    var init_board_value = jQuery('#trello_list_init').attr('data-value');

    if (init_card_value !=undefined && init_card_value !=''  && init_card_value !=0) {
        mas_connect_trello(jQuery('#trello_card'), init_card_value);
    }
});

//select_shopify_product

function mas_connect_trello(element, initValue) {
    var masrAjaxUrl,masrUserLoggedIn,trelloToken;
    masrAjaxUrl = jQuery('#mastrello_admin_url').attr('data-adminurl') + '?action=trello_fetch_card';
    masrUserLoggedIn = jQuery('#mastrello_admin_url_user_id').attr('data-userid');
    trelloToken = jQuery('#trello-key').val();
    jQuery('.lmask').css('display','none');

    jQuery.ajax({
        type: "post",
        url: masrAjaxUrl,
        data: {
            data_token: trelloToken,
        },
        success: function(response){
            jQuery('.lmask').css('display','block');

            var cardObjs = JSON.parse(response);
            for (var key in cardObjs) {
                if (cardObjs.hasOwnProperty(key)) {
                    console.log(key + " -> " + cardObjs[key]);
                    var optionText =  cardObjs[key];
                    jQuery('#trello_card').append(new Option(optionText, key));
                }
            }
            if (initValue != undefined) {
                jQuery('#trello_card').val(initValue).change();
            }

        }
    });
}
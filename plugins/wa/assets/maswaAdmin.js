function sendWhatsappMessage(element,number,text) {
    var orderData = jQuery(element).data('order');
    var postid = jQuery(element).data('postid');
    var data = {action:'maswa_update_mess_status' ,order : orderData , id:postid };

    jQuery.ajax({
        type: 'post',
        url: maswaAdminParam.url,
        data: data,
        beforeSend: function (response) {
        },
        success: function (response) {
            jQuery(element).attr('disabled','disabled');
            // console.log(response);
        },
        complete: function (response) {
            // viewModel.state('loaded');
        },
    });
    let encoded = encodeURI(text);
    var link = "https://wa.me/" + number + "/?text=" + encoded;
    window.open(link);
}

function sendWhatsappMessage2(element,number,text) {
    var orderData = jQuery(element).data('order');
    var postid = jQuery(element).data('postid');
    var data = {action:'maswa_update_mess_status_two' ,order : orderData , id:postid };

    jQuery.ajax({
        type: 'post',
        url: maswaAdminParam.url,
        data: data,
        beforeSend: function (response) {
        },
        success: function (response) {
            jQuery(element).attr('disabled','disabled');
            // console.log(response);
        },
        complete: function (response) {
            // viewModel.state('loaded');
        },
    });
    let encoded = encodeURI(text);
    var link = "https://wa.me/" + number + "/?text=" + encoded;
    window.open(link);
}
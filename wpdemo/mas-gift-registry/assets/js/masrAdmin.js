setInterval(function () {
    var adminMenu = jQuery('#toplevel_page_edit-post_type-mas_gift');
    if (adminMenu.length > 0 ) {
        var ulE = adminMenu.find('ul');
        if (ulE.length > 0 ) {
            var li = ulE.find('li');
            if (li.length > 0) {
                li.last().hide();
                console.log('hide');
            }
        }
    }
},100);
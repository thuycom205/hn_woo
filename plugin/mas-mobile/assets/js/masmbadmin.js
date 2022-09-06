'use strict';
function init() {
    jQuery("#visibility-radio-private").prop("checked", true);
    jQuery("#submitdiv").parent().parent().css('display','none');

    jQuery("#wp-admin-bar-user-actions").css('display','none');
    jQuery("#screen-options-link-wrap").css('display','none');

    jQuery("a[href$='wp-admin/post-new.php?post_type=mas_mobile_x']").css("display", "none");

    // var frame,
    //     metaBox = jQuery('main'), // Your meta box id here
    //     addImgLink = jQuery('.masmb-upload-img'),
    //     delImgLink = jQuery('.masmb-delete-img'),
    //     imgContainer = jQuery('.masmb-image-container'),
    //     imgIdInput = jQuery('.masmb-image-data');
    var frame;
    var  addImgLink = jQuery('.masmb-upload-img');
    var delImgLink = jQuery('.masmb-delete-img');
    var imgContainer =jQuery('.masmb-image-container');
    var imgIdInput= jQuery('.masmb-image-data');


    // ADD IMAGE LINK
    addImgLink.on('click', function (event) {

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title   : 'Select or Upload Media',
            button  : {
                text: 'Use image'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });


        // When an image is selected in the media frame...
        frame.on('select', function () {

            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            // Send the attachment URL to our custom image input field.
            imgContainer.append('<img class="masmb" src="' + attachment.url + '" alt="" style="max-width:100%;"/>');

            // Send the attachment id to our hidden input
            imgIdInput.val(attachment.id);

            // Hide the add image link
            addImgLink.addClass('hidden');

            // Unhide the remove image link
            delImgLink.removeClass('hidden');
        });

        // Finally, open the modal on click
        frame.open();
    });


    // DELETE IMAGE LINK
    delImgLink.on('click', function (event) {

        event.preventDefault();

        // Clear out the preview image
        imgContainer.html('');

        // Un-hide the add image link
        addImgLink.removeClass('hidden');

        // Hide the delete image link
        delImgLink.addClass('hidden');

        // Delete the image id from the hidden input
        imgIdInput.val('');
        jQuery('.masmb').html('');

    });


}

jQuery(document).ready(function () {
    var postElement = jQuery('#post_type');
    if (postElement.length > 0) {
        var postTypeValue = postElement.val();

        if (postTypeValue =='mas_mobile_x') {
            init();

        }

    }
    if (jQuery('#qrcode').length > 0) {
        var url = jQuery('#qrcode').attr('data-token');
        new QRCode(document.getElementById("qrcode"), url);
        //alert('qr processing');

    }
});

function masmb_copytext(element) {
        /* Get the text field */
        var copyText = document.getElementById("mobile_preview_token");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
        alert("text is copied.Please paste it into preview mobile app" );
}

function masmbSubmit(element) {
    jQuery('#publish').click();
}
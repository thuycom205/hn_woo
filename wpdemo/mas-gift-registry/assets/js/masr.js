jQuery(document).ready(function ($) {
   if ( jQuery('#masr_add-to-giftregistry-list').length > 0) {
       var marsObj = {
           state: 'loading',
           registryId  : '0',
           registryData : {},
           addToRegistry : function () {
               $('#loader').show();
               $('body').addClass('overlay');
               var masr_giftregistry = {};

               masr_giftregistry['add-registry'] = 1;
               masr_giftregistry['add-to-giftregistry'] = parseInt(window.marsObj.registryId );
               masr_giftregistry['quantity'] = 1;
               var variationE = jQuery('.variation_id');
               if (variationE.length > 0) {
                   masr_giftregistry['masr_variation_id'] = jQuery('.variation_id').first().val();
               }
               var $form = jQuery('.variations_form');
               $form.trigger( 'check_variations' );
               console.log( jQuery('.variation_id').first().val());
               masr_giftregistry['masr_variation_id'] = jQuery('.variation_id').first().val();

               $product_id = jQuery( "input[name='add-to-cart']" ).val();
               if ($product_id == undefined || $product_id == null) {
                   $product_id = jQuery( "button[name='add-to-cart']" ).val();
               }
               masr_giftregistry['product_id'] = $product_id;
               masr_giftregistry['query'] =  jQuery('form.cart').first().serialize();


               var masrAjaxUrl,masrUserLoggedIn,masrAccountPage;

               masrAjaxUrl = jQuery('#masr_admin_url').val();
               masrUserLoggedIn = jQuery('#masr_user_id').val();
               masrAccountPage = jQuery('#masr_giftregistry_variation_id').val();
               jQuery.ajax({
                   type: "post",
                   url: masrAjaxUrl,
                   data: {
                       action: 'masr_add_item',
                       data_giftregistry: masr_giftregistry,
                   },
                   success: function(){
                       if(masrUserLoggedIn == '1'){
                           location.reload();
                       }
                       else{
                           window.location.href = masrAccountPage + '?request_login=true';
                       }
                   }
               });
           },
           addItem: function (id) {
               window.marsObj.registryId = id;
               marsObj.addToRegistry();
           }
       }
       window.marsObj = marsObj;
       var nonce = jQuery('#mars_nonce').val();
       var adminUrl = jQuery('#masr_admin_url').val();

       var data = {
           action: 'masr_ajax_get_registry',
           security: nonce,
       };
       jQuery.ajax({
           type: 'post',
           url: adminUrl,
           data: data,
           beforeSend: function (response) {
               marsObj.state= 'loading' ;
           },
           success: function (response) {
               let hasGr= Array.isArray(response);

               if (hasGr) {
                   marsObj.state= 'loaded' ;
                   marsObj.registryData  = response;
               } else {
                   marsObj.state= 'empty' ;
               }
           },
           complete: function (response) {
           },
       });
       jQuery('#masr_add-to-giftregistry-list').click(function () {
           var is_login = parseInt(jQuery('#mars_is_user_login').val());
           if (is_login != 1) {
               new jQuery.Zebra_Dialog('you have to login to add items to the gift registry',
                   {
                       width: 600,
                       'title': 'Login is required'
                   });
           } else if (marsObj.registryData.length == 0) {
               new jQuery.Zebra_Dialog('you have to create a gift registry before adding item ',
                   {
                       width: 600,
                       'title': 'Please create gift registry'
                   });
           } else if (marsObj.registryData.length == 1) {
               window.marsObj.registryId = marsObj.registryData[0]['ID'];
           } else {
               var selectContent = jQuery('.grlist').first().html();
               new jQuery.Zebra_Dialog(selectContent,
                   {
                       width: 600,
                       'title': 'Select a gift registry'
                   });
           }



       });
   }
});
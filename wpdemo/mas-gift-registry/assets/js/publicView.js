function post_to_url(path, params, method,query) {
    method = method || "post";

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    let parser = url => url.slice(url.indexOf('?') + 1).split('&');
               
    var atc_query_arr = parser(query);
    for (var i = 0; i < atc_query_arr.length ; i++) {
       var kp =  atc_query_arr[i];
       var kpArr = kp.explode('=');
       var nameStr =kpArr[0]; 
       var valStr =kpArr[1]; 
       //params.push({nameStr: valStr});
       params[nameStr] = valStr;
    }

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", 'add-to-cart');
    hiddenField.setAttribute("value", params['product_id']);

    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
}
function masr_add_item_cart(element,actionUrl,giftRegistryId) {
    var productId = jQuery(element).attr('data-product-id');
    var variationId = jQuery(element).attr('data-variation-id');
    var qty = jQuery(element).attr('data-qty');
    var atcQuery = jQuery(element).attr('data-query');
    var grItemId= jQuery(element).attr('data-gr-itemid');

    if (variationId !=0) {
        post_to_url(actionUrl, {
            quantity:qty,
            product_id:productId,
            variation_id:variationId,
            gift_registry_id:giftRegistryId,
            grItemId:grItemId
        }, 'post', atcQuery);
    } else  {
        post_to_url(actionUrl, {
            quantity:qty,
            product_id:productId,
            gift_registry_id:giftRegistryId,
            grItemId:grItemId
        }, 'post',atcQuery);
    }
}

jQuery( document ).ready(function() {
    console.log( "ready!" );
    if (masrPriority != undefined) {
        if (jQuery('.masr_priority').length > 0) {
            jQuery( '.masr_priority' ).each(function( index , element) {
                var option = "";
                var selectedValue = jQuery(this).attr("data-val");
                for (var i = 0; i < masrPriority.length; i++) {
                    var optionItem = masrPriority[i];

                    if (selectedValue == optionItem.value) {
                        option = option + "<option selected='selected' value=" + " '"  + optionItem.value + "'" + ">"
                            + optionItem.label + "</option>";
                    } else {
                        option = option + "<option value=" + " '"  + optionItem.value + "'" + ">"  + optionItem.label + "</option>";
                    }
                }
                jQuery(this).append(option);

            });
        }
    }

});


String.prototype.explode = function (separator, limit)
{
    const array = this.split(separator);
    if (limit !== undefined && array.length >= limit)
    {
        array.push(array.splice(limit - 1).join(separator));
    }
    return array;
};
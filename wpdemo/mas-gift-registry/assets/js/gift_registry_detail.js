var GiftModel = function(gifts) {
    var self = this;
    //currentTab value is item,share,info
    self.currentTab = ko.observable('item');

    self.currentRoute = ko.observable('list');
    self.gifts = ko.observableArray(gifts);
    //state is loading, error, empty,loaded
    this.state = ko.observable('loading');
    this.currentGift = ko.observable();

    self.itemTabClick = function(element) {
        self.currentTab('item');
    };

    self.shareTabClick = function(element) {
        self.currentTab('share');
    };

    self.infoTabClick = function (element) {
        self.currentTab('info');
    }

    self.backToList = function () {
        self.currentRoute('list');
    }
    self.deleteItemAction = function (element, id)
    {
        var dataId = jQuery(element).attr('data-id');

        var data = {
            action: 'masr_ajax_update_item',
            id: dataId,
            type:'delete',
            _ajax_nonce:masr_nonce
        };
        jQuery.ajax({
            type: 'post',
            url: ajax_url,
            data: data,
            beforeSend: function (response) {
                viewModel.state ('loading' );
            },
            success: function (response) {
                viewModel.state ('loaded' );

                if (typeof response === 'object' &&
                    response !== null && response.message != undefined) {
                    var trId = "#tr" + dataId;
                    jQuery(trId).css('display' , 'none');
                    new jQuery.Zebra_Dialog('you have delete item successfully',
                        {
                            width: 600,
                            'title': ' '
                        });
                } else {
                    new jQuery.Zebra_Dialog('there is error happened',
                        {
                            width: 600,
                            'title': ' '
                        });
                }

            },
        }).fail(function (data) {
            viewModel.state ('loaded' );
            new jQuery.Zebra_Dialog('there is error happened',
                {
                    width: 600,
                    'title': ' '
                });
        });
    }
    self.changePriorityAction = function (element,type) {
        var dataId = jQuery(element).attr('data-id');
        var priority = jQuery(element).val();
        if (dataId != undefined && dataId!='') {

            var data = {
                action: 'masr_ajax_update_item',
                id: dataId,
                priority : priority,
                type:'priority',
                _ajax_nonce:masr_nonce
            };
            jQuery.ajax({
                type: 'post',
                url: ajax_url,
                data: data,
                beforeSend: function (response) {
                    viewModel.state ('loading' );
                },
                success: function (response) {
                    viewModel.state ('loaded' );

                    if (typeof response === 'object' &&
                        response !== null && response.message != undefined) {
                        new jQuery.Zebra_Dialog('you have updated item priority',
                            {
                                width: 600,
                                'title': ' '
                            });
                    } else {
                        new jQuery.Zebra_Dialog('there is error happened',
                            {
                                width: 600,
                                'title': ' '
                            });
                    }

                },
            }).fail(function (data) {
                viewModel.state ('loaded' );
                new jQuery.Zebra_Dialog('there is error happened',
                    {
                        width: 600,
                        'title': ' '
                    });
            });
        }
    }

    self.changeQuantityAction = function (element) {
        var dataId = jQuery(element).attr('data-id');
        var qty = jQuery(element).val();
        if (dataId != undefined && dataId!='') {
            var adminUrl = jQuery('#masr_admin_url').val();

            var data = {
                action: 'masr_ajax_update_item',
                id: dataId,
                quantity : qty,
                type:'quantity',
                _ajax_nonce:masr_nonce
            };
            jQuery.ajax({
                type: 'post',
                url: ajax_url,
                data: data,
                beforeSend: function (response) {
                    viewModel.state ('loading' );
                },
                success: function (response) {
                    viewModel.state ('loaded' );

                    if (typeof response === 'object' &&
                        response !== null && response.message != undefined) {
                        new jQuery.Zebra_Dialog('you have updated item priority',
                            {
                                width: 600,
                                'title': ' '
                            });
                    } else {
                        new jQuery.Zebra_Dialog('there is error happened',
                            {
                                width: 600,
                                'title': ' '
                            });
                    }

                },
            }).fail(function (data) {
                viewModel.state ('loaded' );
                new jQuery.Zebra_Dialog('there is error happened',
                    {
                        width: 600,
                        'title': ' '
                    });
            });
        }
    }

    self.submitGift = function () {
        var adminUrl = jQuery('#masr_admin_url').val();

        var data = {
            action: 'masr_ajax_submit_registry',
            security:ajax_nonce_sr,
            title: jQuery('#masr_title').val(),
            description : jQuery('#masr_description').val(),
            last_name : jQuery('#masr_last_name').val(),
            first_name : jQuery('#masr_first_name').val(),
            email : jQuery('#masr_email').val(),
            id : jQuery('#masr_id').val(),
            edit: true
        };
        jQuery.ajax({
            type: 'post',
            url: ajax_url,
            data: data,
            beforeSend: function (response) {
                viewModel.state ('loading' );
            },
            success: function (response) {
                viewModel.state ('loaded' );

            },
            complete: function (response) {
                viewModel.state ('loaded' );
            },

        }).fail(function (data) {
            viewModel.state ('loaded' );

            console.log(data);
        });
    }


};

var viewModel = new GiftModel([

]);
viewModel.currentRoute('list');

if (!masIsLogin) {
    viewModel.currentRoute('guest');
}
var data = {
    action: 'masr_ajax_get_registry',
    security: ajax_nonce,
    title: jQuery('#masr_title').val(),
};
var adminUrl = jQuery('#masr_admin_url').val();
jQuery.ajax({
    type: 'post',
    url: ajax_url,
    data: data,
    beforeSend: function (response) {
        viewModel.state ('loading' );
    },
    success: function (response) {
        viewModel.state('loaded');
        // console.log(response);
        let hasGr= Array.isArray(response);

        if (hasGr) {
            viewModel.state('loaded');
            for (var i = 0 ; i < response.length ; i++) {
                viewModel.gifts.push(response[i]);
            }
        } else {
           // viewModel.state('empty');
            // viewModel.gifts.push();
        }
    },
    complete: function (response) {
        viewModel.state('loaded');

    },
});


ko.applyBindings(viewModel);

window.$root = viewModel;
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

    if (masrQtyArr != undefined) {
        if (jQuery('.masr_qty').length > 0) {
            jQuery( '.masr_qty' ).each(function( index , element) {
                var option = "";
                var selectedValue = jQuery(this).attr("data-val");
                for (var i = 0; i < masrQtyArr.length; i++) {
                    var optionItem = masrQtyArr[i];

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

function masrGenerateQr(url) {
    new QRCode(document.getElementById("qrcode"), url);

}
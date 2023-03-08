function ValidateEmail(input) {

    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (input.value.match(validRegex)) {

        alert("Valid email address!");

        document.form1.text1.focus();

        return true;

    } else {

        alert("Invalid email address!");

        document.form1.text1.focus();

        return false;

    }

}
var GiftModel = function(gifts) {
    var self = this;

    self.newTitle = ko.observable('');
    self.newDes = ko.observable('');
    self.newLastName = ko.observable('');
    self.newFirstName = ko.observable('');
    self.newEmail = ko.observable('');

    self.validTitle = ko.observable();
    self.validDes = ko.observable();
    self.validLastName = ko.observable();
    self.validFirstName = ko.observable();
    self.validEmail = ko.observable();


    self.currentRoute = ko.observable('list');
    self.gifts = ko.observableArray(gifts);
    //state is loading, error, empty,loaded
    this.state = ko.observable('loading');
    this.currentGift = ko.observable();

    self.addGift = function() {
        self.currentRoute('form');

    };

    self.removeGift = function(gift) {
        //submit ajax request to remove item
        var data = {
            action: 'masr_ajax_remove_registry',
            security: ajax_nonce_rm,
            registry_id: gift.ID,
        };
        var adminUrl = jQuery('#masr_admin_url').val();
        jQuery.ajax({
            type: 'post',
            url: adminUrl,
            data: data,
            beforeSend: function (response) {
                viewModel.state ('loading' );
            },
            success: function (response) {
                viewModel.state ('loaded' );
                console.log(response);

                if (typeof response === 'object' &&
                    response !== null && response.message != undefined)
                {
                    if (response['success'] == 1) {
                        self.gifts.remove(gift);
                        new jQuery.Zebra_Dialog('you have deleted gift registry successfully',
                            {
                                width: 600,
                                'title': ' '
                            });

                    } else {
                        alert(response['message']);
                    }
                } else {
                     alert('There is problem , please contact admin');
                    // viewModel.gifts.push();
                }
            },


        }).fail(function (data) {
            viewModel.state ('loaded' );
            console.log(data);
            alert('remove request is failed');
        });


    };

    self.viewDetail = function (gift) {
        var id = gift.ID;
        var endpoint = masEndpoint.replace('0', id);
        window.location = endpoint;

        self.currentRoute('edit');
        self.currentGift(gift);
    }

    self.backToList = function () {
        self.currentRoute('list');

        var data = {
            action: 'masr_ajax_get_registry',
            security: ajax_nonce,
            title: jQuery('#masr_title').val(),
        };
        var adminUrl = jQuery('#masr_admin_url').val();
        jQuery.ajax({
            type: 'post',
            url: adminUrl,
            data: data,
            beforeSend: function (response) {
                viewModel.state ('loading' );
            },
            success: function (response) {
                console.log(response);
                let hasGr= Array.isArray(response);

                if (hasGr) {
                    viewModel.state('loaded');
                    viewModel.gifts.removeAll();
                    for (var i = 0 ; i < response.length ; i++) {
                        viewModel.gifts.push(response[i]);
                    }
                } else {
                    viewModel.state('empty');
                    // viewModel.gifts.push();
                }
            }
        }).fail(function (data) {
            viewModel.state ('error' );
            console.log(data);
        });
    }

    self.submitGift = function () {
        var isValid = true;
        if (self.newTitle() =='') {
            var x = self.newTitle();
            self.validTitle('failed');
            isValid = false;
        }   else {
            self.validTitle('passed');
        }
        if (self.newDes() =='') {
            var x = self.newDes();
            self.validDes('failed');
            isValid = false;
        }     else {
            self.validDes('passed');
        }
        if (self.newLastName() =='') {
            var x = self.newTitle();
            self.validLastName('failed');
            isValid = false;
        }  else {
            self.validLastName('passed');
        }
        if (self.newFirstName() =='') {
            self.validFirstName('failed');
            isValid = false;
        } else {
            self.validFirstName('passed');
        }
        if (self.newEmail() =='') {
            self.validEmail('failed');
            isValid = false;
        } else {
            var x = self.newEmail();
            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (self.newEmail().match(validRegex)) {
                self.validEmail('passed');
            } else {
                self.validEmail('failed');
                isValid = false;
            }
        }
        if (!isValid) {
            return false;
        }

        var adminUrl = jQuery('#masr_admin_url').val();

        var data = {
            action: 'masr_ajax_submit_registry',
            security: ajax_nonce_sb,
            title: jQuery('#masr_title').val(),
            description : jQuery('#masr_description').val(),
            last_name : jQuery('#masr_last_name').val(),
            first_name : jQuery('#masr_first_name').val(),
            email : jQuery('#masr_email').val(),
        };
        jQuery.ajax({
            type: 'post',
            url: adminUrl,
            data: data,
            beforeSend: function (response) {
                viewModel.state ('loading' );
            },
            success: function (response) {
                console.log(response);
                viewModel.state ('loaded' );
                jQuery('#create_gr_guide').html('Thank you for creating gift registry');


            }
        }).fail(function (data) {
            viewModel.state ('error' );
            console.log(data);
        });
    }

    self.save = function(form) {
        alert("Could now transmit to server: " + ko.utils.stringifyJson(self.gifts));
        // To actually transmit to server as a regular form post, write this: ko.utils.postJson($("form")[0], self.gifts);
    };
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
    url: adminUrl,
    data: data,
    beforeSend: function (response) {
        viewModel.state ('loading' );
    },
    success: function (response) {
        console.log(response);
        let hasGr= Array.isArray(response);

        if (hasGr) {
            viewModel.state('loaded');
            for (var i = 0 ; i < response.length ; i++) {
                viewModel.gifts.push(response[i]);
            }
        } else {
            viewModel.state('empty');
            // viewModel.gifts.push();
        }
    },
}).fail(function (data) {
    viewModel.state ('error' );
    console.log(data);
});


ko.applyBindings(viewModel);
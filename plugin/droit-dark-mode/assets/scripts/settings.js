"use strict";
(function ($) {
    var $ = jQuery;
    // start tab control function here
    var $tabl = document.querySelectorAll(".tab-menu-link"),
        $tab_con = document.querySelectorAll(".tab-bar-content");

    function droit_set_tabs(b) {
        $tabl.forEach(function (c) {
            c.addEventListener("click", droit_tabcontrol);
        });
    }

    function droit_tabcontrol($event) {
        $event.preventDefault();

        let $this = (this);
        let $target = $this.getAttribute('data-content');
        if (!$target) {
            return;
        }
        // active link
        let ur = window.location.href;
        let urlspl = ur.split('#');
        if (urlspl[1]) {
            ur = urlspl[0];
        }

        setTimeout(function () {
            window.location.href = ur + '#' + $target;
            droit_tbs_href();
        }, 10);
        // remove pro features
        drdt_pro_message_remove();
    }

    function droit_tbs_href() {

        $(window).scrollTop(0);

        let ur = window.location.href;
        let urlspl = ur.split('#');

        if (urlspl) {
            let tab = urlspl[1];
            let $this = document.querySelector('button[data-content="' + tab + '"]');
            if (!$this) {
                $this = document.querySelector('button[data-content]');
            }

            if (!$this) {
                return;
            }
            let $target = $this.getAttribute('data-content');

            $tab_con.forEach(function (d) {
                d.classList.remove("active");
            });
            $tabl.forEach(function (d) {
                d.classList.remove("active");
            });

            // add active class
            $this.classList.add("active");
            document.querySelector("#" + $target).classList.add("active");
        }

    }
    $(window).on("load", function () {
        droit_set_tabs();
        droit_tbs_href();
    });
    // end tab control function here

    // save setting data start
    $('form.dtdr-dark-form').on('submit', function (ev) {
        // form event close when submit this form
        ev.preventDefault();

        let $this = $(this);

        // get button icon class
        let $btn = $this.find('button.setting-submit');
        let $btnicon = $this.find('button.setting-submit > i');

        // load the ajax submit when click the submit button
        $.ajax({
            url: dtdr.ajax_url + '?action=dtsave_settings',
            type: "post",
            data: {
                form_data: $this.serialize(),
                message: 'save settings data'
            },
            // before ajax action
            beforeSend: function () {
                $btn.html('<i class="fa fa-spinner fa-spin"></i> Saving');
                $this.addClass('drdt-loading');
            },
            // success ajax 
            success: function (res) {
                // consoole.log(res);
                var tim = setInterval(function () {
                    $btn.html('<i></i> Save Settings');
                    clearInterval(tim);
                }, 1500);
                $btnicon.removeAttr('class');
            },
            // error ajax page
            error: function (res) {
                alert('Something is wrong!!');
            },
            // ajax complate function 
            complete: function () {
                $btn.html('<i></i> Saved');
                $btnicon.removeAttr('class');
                $this.removeClass('drdt-loading');
            },
        });
    });
    // save the form setting data end

    // button select options
    $('.stylebutton > .switch').on('click', function (ev) {
        var $this = $(this);

        if ($this.hasClass('disabeld')) {
            // message box
            drdt_pro_message_add();
            return;
        }
        // remove all active class
        $('.stylebutton > .switch').each(function ($n) {
            var $in = $(this);
            $in.removeClass('actived');
        });
        // add active class
        $this.addClass('actived');
        drdt_pro_message_remove();
    });

    // condition check
    $('*[data-condition]').on('click', function (ev) {
        let $this = $(this);
        let $currentValue = $this.val();
        let $checker = $this.data('checker');
        let $target = $this.data('condition');

        $($target).each(function () {
            let $self = $(this);
            if ($currentValue == 'yes') {
                $self.toggleClass('dt-display-off');
            } else {
                if ($currentValue == $checker) {
                    $self.removeClass('dt-display-off');
                } else {
                    $self.addClass('dt-display-off');
                }
            }

        });
    });

    // pro section enable
    $('.drdt-disabled').on('click', function ($ev) {
        drdt_pro_message_add();
        $ev.preventDefault();
    });
    $('.drdt-dark-close-popup').on('click', function ($ev) {
        drdt_pro_message_remove();
        $ev.preventDefault();
    });

    // select 2
    if ($('.option-select2').length > 0) {
        $('.option-select2').select2();
    }


    // pro message box
    function drdt_pro_message_add() {
        var $alert = $('.drdt-dark-pro-alert');
        $alert.addClass('show');
    }

    function drdt_pro_message_remove() {
        var $alert = $('.drdt-dark-pro-alert');
        $alert.removeClass('show');
    }


    // repeater settings
    if ($('.drdt-repeater')) {
        $('.drdt-repeater').repeater({});
    }

    // custom image loading
    function drdt_image_loader($id) {
        var frame,
            addImgLink = document.querySelectorAll($id);
        if (addImgLink.length > 0) {
            addImgLink.forEach(function ($k, $i) {
                if ($k) {
                    $k.classList.add('rep-' + $i);
                    $k.setAttribute('data-repindex', $i);
                    $k.removeEventListener('dblclick', drdt_insert_media);
                    $k.addEventListener('dblclick', drdt_insert_media);
                }
            });
        }
    }


    function drdt_insert_media(e) {
        e.preventDefault();
        var frame;
        if (frame) {
            frame.open();
            return;
        }
        var $this = (this);
        frame = wp.media({
            title: 'Choose Images',
            button: {
                text: 'Use this media'
            },
            multiple: false
        });
        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $this.value = attachment.url;
        });
        frame.open();
    }

    function drdt_delete_media(e) {
        e.preventDefault();
        var $this = (this);
        $this.value = '';
        return true;
    }


    drdt_image_loader('.upload-drdt-img');

    $('input[data-repeater-create]').click(function (e) {
        e.preventDefault();
        drdt_image_loader('.upload-drdt-img');
    });

    // Media Library.
    $( document ).on( 'click', '.drdt-image-upload__btn', function( e ) {
        e.preventDefault();
        var $this = $( this );
        var input = $this.prev();
        var frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Select'
            },
            multiple: false
        });
        frame.on( 'select', function() {
            var attachment = frame.state().get( 'selection' ).first().toJSON();
            input.val( attachment.url );
        });
        frame.open();
    });

})(jQuery);


// range slider js
function drdt_rangeSlider() {
    let slider = document.querySelectorAll(".range-slider");
    let range = document.querySelectorAll(".range-slider__range");
    let value = document.querySelectorAll(".range-slider__value");

    slider.forEach((currentSlider) => {
        value.forEach((currentValue) => {
            let val = currentValue.previousElementSibling.getAttribute("value");
            currentValue.innerText = val;
        });

        range.forEach((elem) => {
            elem.addEventListener("input", (eventArgs) => {
                elem.nextElementSibling.innerText = eventArgs.target.value;
            });
        });
    });
}
drdt_rangeSlider();

// date picker
document.querySelectorAll('.dldark-flattimepicker').flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});

// active license
(function ($) {
    var $ = jQuery;
    $('button.next_active_license-button').on('click', function (ev) {
        // form event close when submit this form
        ev.preventDefault();

        let $this = $(this);

        // get button icon class
        let $btn = $this;
        let $btnicon = $this.find('i');

        let $message = $this.parents('.droitdark_container').find('.droitdark-message');

        // load the ajax submit when click the submit button
        $.ajax({
            url: dtdr.ajax_url + '?action=nextactive_droitdark',
            type: "post",
            data: {
                'key_license': $this.parents('.droitdark_container').find('#key_license').val()
            },
            // before ajax action
            beforeSend: function () {
                $btn.html('<i class="fa fa-spinner fa-spin"></i> Checking License');
                $this.parents('.droitdark_container').addClass('drdt-loading');
            },
            // success ajax 
            success: function (response) {
                var res = JSON.parse(response);
                // console.log(res);

                if (res.success == false) {
                    $message.addClass('next-danger');
                    $message.html(res.message);
                    $this.parents('.droitdark_container').removeClass('drdt-loading');
                    return;
                } else {
                    $message.addClass('next-success');
                    $message.html(res.message);
                }

                var tim = setInterval(function () {
                    if (res.success == false) {
                        $btn.html('<i></i> Active License');
                    } else {
                        $btn.html('<i></i> Actived License');
                    }
                    window.location.reload();
                    clearInterval(tim);
                }, 1500);

                $btnicon.removeAttr('class');
            },
            // error ajax page
            error: function (res) {
                alert('Something is wrong!!');
            },
            // ajax complate function 
            complete: function () {
                $btn.html('<i></i> Checked');
                $btnicon.removeAttr('class');
                $this.parents('.droitdark_container').removeClass('drdt-loading');
            },
        });
    });

    $(".__revoke_license").click(function (t) {
        t.preventDefault();
        var n = $(this),
            a = n.data("keys");
        if (a) {
            var o = {
                keys: a
            };
            jQuery.ajax({
                data: o,
                type: "get",
                url: dtdr.ajax_url + "?action=nextinactive_droitdark",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (e) {
                    e.status ?
                        setTimeout(function () {
                            window.location.reload();
                        }, 1e3) :
                        (n.innerHTML = "Sorry!! do not Revoke License");
                },
            });
        }
    });
})(jQuery);
// save the form setting data end
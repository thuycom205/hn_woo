'use strict';

const wlbObj = () => {
    jQuery(document).ready(function ($) {

        const reRunScript = (src) => {
            $(`script[src="${src}"]`).remove();
            $('<script>').attr('src', src).appendTo('head');
        };

        var lookbooks = [];
        $('.wlb-lookbook-instagram-item, .wlb-lookbook-item-wrapper').each(function () {
            var lookbook = $(this).find('.wlb-zoom').attr('data-id');
            lookbooks.push(lookbook);
        });

        /*Zoom, Next, Previous, Ajax quick view*/
        $('.wlb-zoom,.wlb-controls-next,.wlb-controls-previous,.wlb-ajax').bind('click', function () {
            $('.wlb-product-frame').hide();
            $('.woocommerce-lookbook-quickview, .wlb-loading').fadeIn(200);
            var l_id = $(this).attr('data-id');
            var p_id = $(this).attr('data-pid');

            /*Get lookbook on instagram*/
            if (l_id) {

                $('.wlb-controls-next,.wlb-controls-previous').removeAttr('data-pid'); //Remove product ID on next and previous button

                //Add Lookbook ID for next and previous button
                let index = lookbooks.indexOf(l_id),
                    next = 0, prev = lookbooks.length - 1;
                if (index < (lookbooks.length - 1)) {
                    next = index + 1;
                }
                if (index > 0) {
                    prev = index - 1;
                }

                $('.wlb-controls-next').attr('data-id', lookbooks[next]);
                $('.wlb-controls-previous').attr('data-id', lookbooks[prev]);
                /*Ajax get Instagram image*/
                $.ajax({
                    type: 'POST',
                    data: {action: 'wlb_get_lookbook', lookbook_id: l_id},
                    xhrFields: {
                        withCredentials: true
                    },
                    url: _woocommerce_lookbook_params.ajax_url,
                    success: function (data) {

                        if (data.left) {
                            $('.wlb-left .wlb-lookbook-data').html(data.left);
                        }
                        if (data.right) {
                            $('.wlb-right .wlb-product-data').html(data.right);
                        }
                        $('.wlb-loading').hide();
                        $('.wlb-product-frame').fadeIn(500);
                        let wlbWidth = $('.wlb-lookbook-data').width();
                        $('.wlb-0 .wlb-right').css({'max-height': wlbWidth + 'px'});
                        variations();
                        submit_form();
                        $('.woocommerce-product-gallery').each(function () {
                            $(this).trigger('wc-product-gallery-before-init', [this, wc_single_product_params]);
                            $(this).wc_product_gallery(wc_single_product_params);
                            $(this).trigger('wc-product-gallery-after-init', [this, wc_single_product_params]);
                        });
                    },
                    error: function (html) {
                    }
                })
            }

            /*Product quick view*/
            if (p_id) {
                /*Remove product ID on next and previous button*/
                $('.wlb-controls-next,.wlb-controls-previous').removeAttr('data-id');
                var products = [],products_url=[];
                $(this).closest('.wlb-lookbook-item-wrapper').find('.wlb-ajax').each(function () {
                    var product = $(this).attr('data-pid');
                    var product_url = $(this).attr('data-purl');
                    products.push(product);
                    products_url.push(product_url);
                });
                if (products.length < 1) {
                    products = $('.wlb-controls').attr('data-products');
                    products = products.split(',');
                    products_url = $('.wlb-controls').attr('data-products_url');
                    products_url = products_url.split(',');
                } else {
                    $('.wlb-controls').attr('data-products', products).attr('data-products_url', products_url);
                }

                /*Add Lookbook ID for next and previous button*/
                var index = products.indexOf(p_id);
                // console.log(index);
                var next = 0;
                var prev = products.length - 1;
                if (index < (products.length - 1)) {
                    next = index + 1;
                }
                if (index > 0) {
                    prev = index - 1;
                }

                $('.wlb-controls-next').attr('data-pid', products[next]).attr('data-purl', products_url[next]);
                $('.wlb-controls-previous').attr('data-pid', products[prev]).attr('data-purl', products_url[prev]);
                /*Get Product information*/
                var str_data = '&product_id=' + p_id;
                $.ajax({
                    type: 'POST',
                    data:  str_data,
                    // data: 'action=wlb_get_product' + str_data,
                    url: _woocommerce_lookbook_params.wc_ajax_url.toString().replace('%%endpoint%%', 'wlb_get_product'),
                    // url: _woocommerce_lookbook_params.ajax_url,
                    success: function (data) {
                        if (data.left) {
                            $('.wlb-left .wlb-lookbook-data').html(data.left);
                        }
                        if (data.right) {
                            $('.wlb-right .wlb-product-data').html(data.right);
                        }
                        $('.wlb-loading').hide();
                        $('.wlb-product-frame').fadeIn(500);
                        variations();
                        submit_form();
                        if ($('.woocommerce-lookbook-quickview-inner .woodmart-swatch').length > 0) {
                            woodmartThemeModule.init();
                        }
                        $('.woocommerce-product-gallery').each(function () {
                            $(this).trigger('wc-product-gallery-before-init', [this, wc_single_product_params]);
                            $(this).wc_product_gallery(wc_single_product_params);
                            $(this).trigger('wc-product-gallery-after-init', [this, wc_single_product_params]);
                        });


                    },
                    error: function (html) {
                    }
                })
            }
        });

        /*Hide quick view*/
        $('body').on('click', function (e) {
            if ($(e.target).is(' .wlb-left,.wlb-product-wrapper')) {
                $('.woocommerce-lookbook-quickview').fadeOut(200);
            }
        });

        $('body').on('keyup', function (e) {
            if (e.key === 'Escape') {
                $('.woocommerce-lookbook-quickview').fadeOut(200);
            }
        });

        $('.wlb-overlay,.wlb-close').bind('click', function () {
            $('.woocommerce-lookbook-quickview').fadeOut(200);
            // $('html').attr('style', '');
        });
        /*Short code Slide*/
        // $('.wlb-lookbook-slide').slidesjs({
        //     width: _woocommerce_lookbook_params.width,
        //     height: _woocommerce_lookbook_params.height,
        //     navigation: {
        //         active: _woocommerce_lookbook_params.navigation,
        //         effect: _woocommerce_lookbook_params.effect
        //     },
        //     pagination: {
        //         active: _woocommerce_lookbook_params.pagination,
        //         effect: _woocommerce_lookbook_params.effect
        //     },
        //     play: {
        //         auto: _woocommerce_lookbook_params.auto,
        //         interval: _woocommerce_lookbook_params.time,
        //         pauseOnHover: true,
        //         effect: _woocommerce_lookbook_params.effect
        //     }
        // });

        if ($('.wlb-lookbook-carousel').length > 0) {
            var window_size = $(window).width(),
                animation = _woocommerce_lookbook_params.effect,
                items_per_row = _woocommerce_lookbook_params.cols,
                itemWidth = 220;
            if (_woocommerce_lookbook_params.gallery_to_slide === '1' && $('.wlb-lookbook-carousel').hasClass('wlb-flag')) {
                if (window_size >= 768) {
                    $('.wlb-lookbook-carousel.wlb-flag').hide();
                    $('.wlb-lookbook-gallery.wlb-flag').show();
                } else {
                    $('.wlb-lookbook-gallery.wlb-flag').hide();
                    $('.wlb-lookbook-carousel.wlb-flag').show();
                    itemWidth = 150;
                }
            } else {
                if (items_per_row === undefined || items_per_row === '') {
                    items_per_row = 3;
                }
                if (window_size < 768 && window_size >= 600) {
                    items_per_row = 2;
                }
                if (window_size < 600) {
                    items_per_row = 1;
                }
            }

            if (animation === 'fade') {
                items_per_row = 1;
            }

            var controlNav = _woocommerce_lookbook_params.pagination ? true : false;
            var autoPlay = _woocommerce_lookbook_params.auto ? true : false;
            $('.wlb-lookbook-carousel').vi_flexslider({
                namespace: "woocommerce-lookbook-",
                selector: '.wlb-lookbook-items >.wlb-lookbook-item-wrapper',
                animation: animation,
                animationLoop: true,
                itemWidth: itemWidth,
                itemMargin: 10,
                controlNav: controlNav,
                maxItems: items_per_row,
                reverse: false,
                slideshow: autoPlay,
                slideshowSpeed: _woocommerce_lookbook_params.time
                // rtl: false
            });

            if (!_woocommerce_lookbook_params.navigation) {
                $('.woocommerce-lookbook-direction-nav').remove();
            }
        }


        /*Instagram Carousel*/
        if ($('.wlb-lookbook-carousel').length > 0) {
            /*Check responsive*/
            var item_per_row = $('.wlb-lookbook-carousel').attr('data-col');
            var windowsize = $(window).width();
            if (item_per_row == undefined) {
                item_per_row = 4;
            }
            if (windowsize < 768 && windowsize >= 600) {
                item_per_row = 2;
            }
            if (windowsize < 600) {
                item_per_row = 1;
            }

            var rtl = $('.wlb-lookbook-carousel').attr('data-rtl');
            if (parseInt(rtl)) {
                rtl = true;
            } else {
                rtl = false;
            }

            $('.wlb-lookbook-carousel').vi_flexslider({
                namespace: "woocommerce-lookbook-",
                selector: '.woocommerce-lookbook-inner >.wlb-lookbook-instagram-item',
                animation: "slide",
                animationLoop: false,
                itemWidth: 200,
                itemMargin: 10,
                controlNav: false,
                maxItems: item_per_row,
                reverse: false,
                slideshow: false,
                rtl: rtl
            });
        }

        /*Reinit Product variation*/
        function variations() {
            var form_variation = $('.variations_form');
            form_variation.each(function () {
                $(this).wc_variation_form();
            })
        }

        function submit_form() {
            $('.wlb-product-frame').unbind();
            $('.wlb-product-frame').on('submit', '.wlb-right:not(.wlb-external) .cart, .wlb-product-gallery:not(.wlb-external) .cart', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                var button = $(this).find('button[type="submit"]');
                button.attr('disabled', 'disabled').addClass('wlb-adding');
                data.push({name: button.attr('name'), value: button.val()});
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: data,
                    success: function (html) {
                        var parser = new DOMParser();
                        var htmlDoc = parser.parseFromString(html, 'text/html');
                        var alert = $(htmlDoc).find('.woocommerce [role=alert]');
                        if (alert.length) {
                            alert.find('a').remove();
                            $('.wlb-added').html(alert).fadeIn(500);
                        } else {
                            $('.wlb-added').fadeIn(500);
                        }
                        $('.wlb-added').fadeOut(3000);
                        $('.wlb-added').unbind();

                        button.removeAttr('disabled').removeClass('wlb-adding');
                        if (_woocommerce_lookbook_params.redirect_url) {
                            window.location.href = _woocommerce_lookbook_params.redirect_url;
                        }
                        $('body').trigger("wc_fragment_refresh");
                    }
                });
            });
        }
    });
}

wlbObj();

jQuery(window).on('elementor/frontend/init', function () {
    if (window.elementor) {
        elementorFrontend.hooks.addAction('frontend/element_ready/woocommerce-lookbook.default', function () {
            wlbObj();
        });
    }
});
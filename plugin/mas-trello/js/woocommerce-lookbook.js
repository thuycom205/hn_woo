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
            var p_url = $(this).attr('data-purl');

            /*Get lookbook on instagram*/
            if (l_id) {
                window.lcShopdomain = 'hanetest1.myshopify.com';
              var shopifyProduct = 'https://' + window.lcShopdomain + '/products/' + p_url;
              window.open(shopifyProduct);
            }

            /*Product quick view*/
            if (p_id) {
               // window.lcShopdomain = 'hanetest1.myshopify.com';
                var shopifyProduct = 'https://' + window.lcShopdomain + '/products/' + p_url;
                window.open(shopifyProduct);
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
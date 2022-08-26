(function ($) {
    "use strict";

    // Closes responsive menu when a scroll trigger link is clicked
    $('td.product-quantity .product-qty input.input-text.qty.text').change(function() {
        $('.woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled]').removeAttr('disabled');
    });

    $('.main-menu-link').on('click', function() {
        $('.navbar-collapse').collapse('hide');
    });

    /*---------------sticky header on scroll js ---------------*/
    $(".navbar").sticky({topSpacing: 0});
    //    //shrink header trnsparent
    $(window).on("scroll", function () {
        if ($(document).scrollTop() > 70) {
            $('.transparent-nav').addClass('shrink');
        } else {
            $('.transparent-nav').removeClass('shrink');
        }
    });
    
    $('.faq_accordian_two .card').each(function () {
        var $this = $(this);
        $this.on('click', function (e) {
            var has = $this.hasClass('active');
            $('.faq_accordian_two .card').removeClass('active');
            if(has) {
                $this.removeClass('active');
            } else {
                $this.addClass('active');
            }
        });
    });

    /*---------------testimonial-sliderjs --------*/
    function testimoni(){
        var testimonials = $(".testimonial-carousel");
        if( testimonials.length ){
            testimonials.owlCarousel({
                loop:true,
                margin:0,
                items:2,
                autoplay:true,
                autoplayHoverPause: true,
                smartSpeed:1000,
                nav: false,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1, 
                    },
                    720:{
                        items:2, 
                    }
                }
            });
        }
    }
    testimoni();
    
    /*---------------testimonial_slider-eight js --------*/
    function testimonialTwo(){
        var testimonialstwo = $(".testimonial_slider_eight");
        if( testimonialstwo.length ){
            testimonialstwo.owlCarousel({
                loop:true,
                margin:0,
                items:1,
                autoplay:true,
                autoplayHoverPause: true,
                smartSpeed:1000,
                nav: false,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1, 
                    },
                    720:{
                        items:1, 
                    }, 
                },
                
            });
        }
    }
    testimonialTwo();
    
     /*=============================================== 
      Skrollr Init
    ================================================*/
    var mySkrollr = skrollr.init({
        forceHeight: false,
        easings: {
            easeOutBack: function (p, s) {
                s = 1.70158;
                p = p - 1;
                return (p * p * ((s + 1) * p + s) + 1);
            }
        },
        mobileCheck: function() {
            //hack - forces mobile version to be off
            return false;
        }
    });
    
    /*=============================================== 
	      5. Parallax Init
	  ================================================*/
	if ($('#apps_craft_animation,.back_bg').length > 0 ) {
	  $('#apps_craft_animation,.back_bg').parallax();
	}

    
    /*==========Start player js ===========*/
    // poster frame click event
    $(".js-videoPoster").on('click',function(ev) {
        ev.preventDefault();
        var $poster = $(this);
        var $wrapper = $poster.closest('.js-videoWrapper');
        videoPlay($wrapper);
    });

    // play the targeted video (and hide the poster frame)
    function videoPlay($wrapper) {
        var $iframe = $wrapper.find('.js-videoIframe');
        var src = $iframe.data('src');
        // hide poster
        $wrapper.addClass('videoWrapperActive');
        // add iframe src in, starting the video
        $iframe.attr('src',src);
    }
    // stop the targeted/all videos (and re-instate the poster frames)
    $(".play-btn").on("click",function(ev){
        var $wrapper = $('.js-videoWrapper');
        var $iframe = $wrapper.find('.js-videoIframe');
        var src = $iframe.data('src'); 
        if( $wrapper.hasClass('videoWrapperActive')){
            $wrapper.removeClass('videoWrapperActive');
            $iframe.attr('src','');
        }
        else{
            $wrapper.addClass('videoWrapperActive');
            $iframe.attr('src',src);
        }
        return false;
    });
    
    /*===========Start clients logo js ===========*/
    function clientsSlider(){
        var clientslg_slider = $(".clients-lg-slider");
        if( clientslg_slider.length){
            clientslg_slider.owlCarousel({
                loop:true,
                margin:0,
                items:4,
                autoplay:true,
                smartSpeed:1000,
                autoplayHoverPause: true,
                nav: false,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1, 
                    },
                    420:{
                        items:2, 
                    },
                    550:{
                        items:3, 
                    }, 
                    992:{
                        items:4,   
                    }
                },
            })
        }
    }
    clientsSlider();
    /*===========End clients logo js ===========*/
    
    
    /*===========Start clients logo js ===========*/
    function teamSlider(){
        var team = $(".team-slider");
        if( team.length){
            team.owlCarousel({
                loop:true,
                margin:0,
                items:3,
                autoplay:true,
                center: true,
                smartSpeed:1000,
                autoplayHoverPause: true,
                nav: false,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1, 
                    },
                    420:{
                        items:2, 
                    },
                    550:{
                        items:3, 
                    }
                },
            })
        }
    }
    teamSlider();
    /*===========End clients logo js ===========*/
    
    /*==========End player js ===========*/
    
    // preloader js
    $(window).load(function() { // makes sure the whole site is loaded
		$('.loader-container').fadeOut(); // will first fade out the loading animation
		$('.loader').delay(150).fadeOut('slow'); // will fade out the white DIV that covers the website.
		$('body').delay(150).css({'overflow':'visible'})
    })
    
    var slider_text = $('.text_slider');

    function text_slider() {
        if (slider_text.length) {
            slider_text.owlCarousel({
                loop: false,
                margin: 0,
                dots: false,
                autoplay: true,
                mouseDrag: true,
                touchDrag: true,
                animateOut: 'slideOutUp',
                animateIn: 'fadeInUp',
                navSpeed: 500,
                items: 1,
                smartSpeed: 2500,
            })
        }
    }
    text_slider();
    var slider_bg = $('.screenshot_carousel');

    function home_slider() {
        if (slider_bg.length) {
            slider_bg.owlCarousel({
                loop: false,
                margin: 68,
                dots: false,
                autoplay: true,
                mouseDrag: true,
                touchDrag: true,
                items: 3,
                smartSpeed: 2500,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1
                    },
                    500:{
                        items:3,
                        margin:10
                    },
                    768:{
                        items:3,
                        margin:30
                    },
                    1199:{
                        items:2,
                        margin :150,
                    },
                    1450:{
                        items:3, 
                    }
                }
            })
        }
    }
    home_slider();
    $('.home_screen_nav .testi_next').on('click', function() {
        slider_text.trigger('next.owl.carousel');
        slider_bg.trigger('next.owl.carousel');
    });
    $('.home_screen_nav .testi_prev').on('click', function() {
        slider_text.trigger('prev.owl.carousel');
        slider_bg.trigger('prev.owl.carousel');
    });
    
    //open and close popup
	$(document).on('click', '.open-popup', function(){
		$('.popup-content').removeClass('active');
		$('.popup-wrapper, .popup-content[data-rel="'+$(this).data('rel')+'"]').addClass('active');
		$('html').addClass('overflow-hidden');
		return false;
	});

	$(document).on('click', '.popup-wrapper .button-close, .popup-wrapper .layer-close', function(){
		$('.popup-wrapper, .popup-content').removeClass('active');
		$('html').removeClass('overflow-hidden');
		setTimeout(function(){
			$('.ajax-popup').remove();
		},300);
		return false;
	});

    // video Popup
    if ($("#video-item").length > 0){
        $("#video-item").magnificPopup({
            type: "iframe"
        });
    }
    


    /*=========animation js =========*/
    function bodyScrollAnimation() {
        // var scrollAnimate = $('body').data('scroll-animation');
        if($(window).width() > 668){
            new WOW({
                animateClass: 'animated', // animation css class (default is animated)
                offset:       0,          // distance to the element when triggering the animation (default is 0)
                mobile:       true,
                duration:     1000,
            }).init()
        }
    }
    bodyScrollAnimation();


    function bgVideo(){
        var bgndVideo = $("#bgndVideo");
        if(bgndVideo.length){
            bgndVideo.YTPlayer();
        }
    }
    bgVideo();

    // partical JS Bg
    function particalBGone () {
        if ($("#particles-js").length) {
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 70,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        },
                        "image": {
                            "src": "img/github.svg",
                            "width": 100,
                            "height": 100
                        }
                    },
                    "opacity": {
                        "value": 0.1,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.2,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 2,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 4,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": false,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });
        }
    }
    particalBGone();
    
    if ($('#scene').length > 0) {
        $('#scene').parallax();
    }
})(jQuery);


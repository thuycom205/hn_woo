<?php

function appart_scripts() {
	$opt = get_option('appart_opt');
    /**
     * Register Google fonts.
     *
     * @return string Google fonts URL for the theme.
     */
    function appart_fonts_url() {
        $fonts_url = '';
        $fonts     = array();
        $subsets   = '';

        /* translators: If there are characters in your language that are not supported by this font, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== esc_html_x( 'on', "Poppins font: on or off", 'appart' ) ) {
            $fonts[] = "Poppins:400,400i,500,600,700,800";
        }
        /* translators: If there are characters in your language that are not supported by this font, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== esc_html_x( 'on', "Montserrat font: on or off", 'appart' ) ) {
            $fonts[] = "Montserrat:400,500,600,700,800";
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }

    wp_enqueue_style('bootstrap',  APPART_DIR_CSS.'/bootstrap.css');
    wp_enqueue_style('bootstrap-rtl',  APPART_DIR_CSS.'/bootstrap-rtl.css');
    wp_enqueue_style('font-awesome',  APPART_DIR_CSS.'/font-awesome.min.css');
    wp_enqueue_style('YTPlayer',  APPART_DIR_VEND.'/video-player/css/jquery.mb.YTPlayer.min.css');
    wp_enqueue_style('themify-icon',  APPART_DIR_VEND.'/themify-icon/themify-icons.css');
    wp_enqueue_style('swiper',  APPART_DIR_VEND.'/swipper/swiper.min.css');
    wp_enqueue_style('linearicons',  APPART_DIR_CSS.'/linearicons.css');
    wp_enqueue_style('owl-carousel',  APPART_DIR_VEND.'/owl-carousel/owl.carousel.min.css');
    wp_enqueue_style('owl-carousel-animate',  APPART_DIR_VEND.'/owl-carousel/animate.css');
    wp_enqueue_style('magnific-popup',  APPART_DIR_VEND.'/magnific-popup/magnific-popup.css');
    wp_register_style('appart-shop',  APPART_DIR_CSS.'/shop.css');
    wp_register_style('slick',  APPART_DIR_VEND.'/slick/slick.css');
    wp_register_style('slick-theme',  APPART_DIR_VEND.'/slick/slick-theme.css');

    if(class_exists('WooCommerce')) {
        if(is_shop()) {
            wp_enqueue_style('appart-shop');
        }
        if(is_singular('product') ||  is_tax('product_cat')) {
            wp_enqueue_style('appart-shop');
            wp_enqueue_style('appat-shop-details',  APPART_DIR_CSS.'/shop-details.css');
            
        }
    }

    wp_enqueue_style('appart-fonts', appart_fonts_url(), array(), null);
    wp_enqueue_style('appart-wpd-style', APPART_DIR_CSS.'/wpd-style.css');
    if(is_home() || is_single() || is_search() || is_archive()) { wp_enqueue_style('appart-blog', APPART_DIR_CSS.'/blog.css'); }
    if(is_page() || is_single()) { wp_enqueue_style('appart-comments', APPART_DIR_CSS.'/comments.css'); }
    if(is_404() || is_search()) {
        wp_enqueue_style('appart-404', APPART_DIR_CSS.'/404.css');
    }
    wp_enqueue_style('appart-main', APPART_DIR_CSS.'/style.css');
    wp_enqueue_style('appart-responsive', APPART_DIR_CSS . '/responsive.css');
    wp_enqueue_style('appart-gutenburg',  APPART_DIR_CSS.'/appart-gutenburg.css');
    wp_enqueue_style('appart-root', get_stylesheet_uri());

    $dynamic_css = '';

    if(is_singular('post') || is_page()) {
    	$dynamic_css .= '.banner-area {background: url("'.get_the_post_thumbnail_url(get_the_ID()).'") no-repeat scroll center 0/cover;}';
    }

    if(is_singular('product')) {
        $product_metaboxes = get_post_meta(get_the_ID(), 'product_metaboxes', true);
        $dynamic_css .=
            (!empty($product_metaboxes['bg_image'])) ?
            '.banner-area {background: url("'.$product_metaboxes['bg_image'].'") no-repeat scroll center 0/cover;}' :
            '';
    }

    if(function_exists('cs_get_option')) {
        $page_metaboxes = get_post_meta(get_the_ID(), 'page_metaboxes', true);
        if(!empty($page_metaboxes['menu_color'])) {
            $dynamic_css .= ".navbar-expand-lg.navbar .navbar-nav li > a {color: {$page_metaboxes['menu_color']} !important}";
            $dynamic_css .= ".navbar-expand-lg.navbar .navbar-nav li:after {background-color: {$page_metaboxes['menu_color']} !important}";
        }
        if(!empty($page_metaboxes['titlebar_bg_color'])) {
            $dynamic_css .= ".banner-area:before { background: {$page_metaboxes['titlebar_bg_color']} !important;}";
        }
    }


    if(class_exists('ReduxFrameworkPlugin')) {

        if(is_404()) {
            if(!empty($opt['404_bg']['url']))
                $dynamic_css .= ".error_page_area{ background: url({$opt['404_bg']['url']}) no-repeat scroll center 0/cover;}";
        }

        if($opt['menu_btn_label'] == '') {
            $dynamic_css .= '
                .navbar-expand-lg.navbar .navbar-nav li:last-child {
                    margin-right: 0px;
                }';
        }

	    $blog_header_bg = isset($opt['blog_header_bg']['url']) ? $opt['blog_header_bg']['url'] : '';
	    $dynamic_css .= !empty($blog_header_bg) ? "
            .blog .banner-area {
                background: url(".esc_url($blog_header_bg).") no-repeat scroll center 0/cover;
            }
            " : '';
	    $footer_bg_image = isset($opt['footer_bg_image']['url']) ? "footer.footer-area {
				               background: url(".esc_attr($opt['footer_bg_image']['url']).") no-repeat scroll center center/cover;   
				           }" : '';

	    $footer_link_hover = !empty($opt['footer_link_hover']) ? '
			.footer-five .footer-top .footer_sidebar .widget.widget_social .social-icon li a:hover,
			.footer-top .footer_sidebar .widget.about_us_widget .social_icon li:hover i,
			.footer-top .footer_sidebar .widget.widget_contact ul li .fleft a:hover,
			.widget.widget_pages ul li a:hover,
			.footer_sidebar ul li a:hover,
			.footer-five .footer_bottom a:hover,
			.footer-top .footer_sidebar .widget.widget_twitter .tweets li .tweets-text a:hover {
			    color:'.esc_attr($opt['footer_link_hover']).' !important;
		    }' : '';
	    $accent_gradient = isset($opt['accent_gradient']['from']) ? "
	        .navbar-expand-lg.navbar.shrink .get-btn:hover {
	            border-color: ".esc_attr($opt['accent_gradient']['from'])." !important;
	        }
	        .price .pricing-box .pricing-header,
	        .price .pricing-box:hover .pricing-header,
	        .subscribe_area_two .subcribes.input-group .btn-submit,
	        .n_banner_btn, .error_content h1,
	        .app-details .app-icon:before,
	        .faq_accordian_two .card:before,
	        .b_features_icon .hover_color,
	        .price_box_two .purchase_btn_two:before {
	            background-image: -moz-linear-gradient( 180deg, ".esc_attr($opt['accent_gradient']['from'])." 0%, ".esc_attr($opt['accent_gradient']['to'])." 100%);
                background-image: -webkit-linear-gradient( 180deg, ".esc_attr($opt['accent_gradient']['from'])." 0%, ".esc_attr($opt['accent_gradient']['to'])." 100%);
                background-image: -ms-linear-gradient( 180deg, ".esc_attr($opt['accent_gradient']['from'])." 0%, ".esc_attr($opt['accent_gradient']['to'])." 100%);
	        }	        
	        " : '';

	    $menu_btn_hover_bg_color = !empty($opt['menu_btn_hover_bg_color']) ? $opt['menu_btn_hover_bg_color'] : '';
	    if($menu_btn_hover_bg_color == '') {
	        $dynamic_css .= "\n .get-btn:before {
	            background-image: -moz-linear-gradient( 180deg, ".esc_attr($opt['accent_gradient']['from'])." 0%, ".esc_attr($opt['accent_gradient']['to'])." 100%);
                background-image: -webkit-linear-gradient( 180deg, ".esc_attr($opt['accent_gradient']['from'])." 0%, ".esc_attr($opt['accent_gradient']['to'])." 100%);
                background-image: -ms-linear-gradient( 180deg, ".esc_attr($opt['accent_gradient']['from'])." 0%, ".esc_attr($opt['accent_gradient']['to'])." 100%);
	        }";
        }
	    $dynamic_css .= "
	        $accent_gradient
            $footer_bg_image
            $footer_link_hover
        ";
	    if(!empty($opt['custom_css'])) {
	        $dynamic_css .= $opt['custom_css'];
        }
    }

    wp_add_inline_style('appart-root', $dynamic_css);

    // Scripts
    $dynamic_js = '';
	wp_enqueue_script( 'tether', APPART_DIR_JS.'/tether.min.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'bootstrap', APPART_DIR_JS.'/bootstrap.min.js', array('jquery'), '4.0.0', true );
    wp_enqueue_script( 'jquery-easing', APPART_DIR_JS.'/jquery.easing.min.js', array('jquery'), '1.3.2', true );
    wp_enqueue_script( 'smooth-scroll', APPART_DIR_JS.'/smooth-scroll.min.js', array('jquery'), '10.2.1', true );
    wp_enqueue_script( 'owl-carousel', APPART_DIR_VEND.'/owl-carousel/owl.carousel.min.js', array('jquery'), '2.2.0', true );
    wp_enqueue_script( 'jquery-sticky', APPART_DIR_JS.'/jquery.sticky.js', array('jquery'), '2.2.0', true );
    wp_enqueue_script( 'sckroller', APPART_DIR_VEND.'/sckroller/sckroller.js', array('jquery'), '0.6.30', true );
    wp_enqueue_script( 'wow', APPART_DIR_VEND.'/wow/wow.min.js', array('jquery'), '1.1.3', true );
    wp_enqueue_script( 'parallax-scroll', APPART_DIR_JS.'/parallax-scroll.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'jquery-easing', APPART_DIR_JS.'/jquery.easing.min.js', array('jquery'), '1.3.2', true );
    wp_enqueue_script( 'YTPlayer', APPART_DIR_VEND.'/video-player/jquery.mb.YTPlayer.js', array('jquery'), '', true );
    wp_enqueue_script( 'magnific-popup', APPART_DIR_VEND.'/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true );
    wp_enqueue_script( 'particle', APPART_DIR_JS.'/particles.min.js', array('jquery'), '2.0.0', true );
    wp_enqueue_script( 'parallax', APPART_DIR_JS.'/parallax.js', array('jquery'), '2.0.0', true );
    wp_enqueue_script( 'appart-custom', APPART_DIR_JS.'/custom.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'appart-custom-wp', APPART_DIR_JS.'/custom-wp.js', array('jquery'), '1.0', true );

    /*Google Map */
    if(is_page_template('page-contact.php')) {
        if(!empty($opt['map_api'])) {
            wp_enqueue_script('appart-googleapis-map', 'http://maps.googleapis.com/maps/api/js?key='.esc_attr($opt['map_api']).'');
        };
        $dynamic_js .= '
        if (jQuery("#googleMap").length > 0) {
            let lat =  '.esc_attr($opt['latitude']).';
            let long = '.esc_attr($opt['longitude']).';
            var myCenter = new google.maps.LatLng(
                lat, long 
            );
            function changeMarker(newLogo) {
                "use strict";
                var marker = new google.maps.Marker({
                    position: myCenter,
                    icon: newLogo
                });
                var map = new google.maps.Map(document.getElementById("googleMap"), {
                    center: myCenter,
                    zoom: '.esc_attr($opt['map_zoom']).',
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    rotateControl: false,
                    fullscreenControl: false,
                });
                marker.setMap(map);
            }
            google.maps.event.addDomListener(window, "load", function () {
                changeMarker("'.esc_url($opt['map_marker']['url']).'");
            });
        }';
    }


    if(is_rtl()) {
        wp_dequeue_script('appart-custom');
        wp_enqueue_script( 'appart-rtl', APPART_DIR_JS.'/rtl.js', array('jquery'), '1.0', true );
    }
    $is_preloader = !empty($opt['is_preloader']) ? $opt['is_preloader'] : '';
    if($is_preloader=='1') {
        $dynamic_js .= "
        //<![CDATA[
            jQuery(window).on('load', function() { // makes sure the whole site is loaded 
                jQuery('#status').fadeOut(); // will first fade out the loading animation 
                jQuery('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
                jQuery('body').delay(350).css({'overflow':'visible'});
            })
        //]]>" . "\n";
    }

    if(class_exists('ReduxFrameworkPlugin') & !empty($opt['custom_js'])) {
        $dynamic_js .= $opt['custom_js'];
    }

    wp_add_inline_script('appart-custom-wp', $dynamic_js);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'appart_scripts');


add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style('appart-admin', APPART_DIR_CSS.'/appart_admin.css');
});
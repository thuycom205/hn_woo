<?php
if( !function_exists('acrony_assets_setup') ){
    function acrony_assets_setup(){
        /*
        * Make theme available for translation.
        * If you're building a theme based on Acrony, use a find and replace
        * to change 'acrony' to the name of your theme in all the template files
        */
        load_theme_textdomain( 'acrony', get_theme_file_path('/languages/') );
        
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        
        /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
        add_theme_support( 'title-tag' );
        
        /*
        * Enable support for custom logo.
        */
        add_theme_support( 'custom-logo', array(
            'height'      => 240,
            'width'       => 240,
            'flex-height' => true,
        ) );
        
        // Setup the WordPress core custom background feature.

        /**
         * Filter Acrony custom-header support arguments.
         *
         * @since Acrony 1.0
         *
         * @param array $args {
         *     An array of custom-header support arguments.
         *
         *     @type string $default-color     		Default color of the header.
         *     @type string $default-attachment     Default attachment of the header.
         * }
         */
        add_theme_support( 
            'custom-background',
                apply_filters(
                    'acrony_custom_background_args', array(
                        'default-color'      => 'ffffff',
                        'default-attachment' => 'fixed',
                    )
            )
        );     
        
        // Setup the WordPress core custom header background feature.
    
        add_theme_support( 'custom-header', apply_filters( 'acrony_custom_header_args', array(
            'default-image'          => get_theme_file_uri('/assets/images/header-bg.jpg'),
            'default-text-color'     => 'ffffff',
            'wp-head-callback'       => 'acrony_header_style',
        ) ) );
        
        if ( ! function_exists( 'acrony_header_style' ) ) {
           function acrony_header_style() {
                $header_text_color = get_header_textcolor();
                if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
                    return;
                }
            } 
        }        
        
        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
        */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary_menu' => esc_html__( 'Primary Menu', 'acrony' )
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ) );
        
        /*
        * Enable support for woocommerce.
        */
        if( class_exists( 'WooCommerce' ) ){   
            add_theme_support( 'woocommerce', 
                array(
                    'thumbnail_image_width' => 400,
                    'gallery_thumbnail_image_width' => 300,
                    'single_image_width'    => 800,
                    'product_grid' => array(
                        'default_rows'    => 4,
                        'min_rows'        => 1,
                        'max_rows'        => 6,
                        'default_columns' => 3,
                        'min_columns'     => 1,
                        'max_columns'     => 5,
                    ),
                )
            );
            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );
        }
        
        add_image_size( 'acrony_blog_thumb' ,'750','500',true );        
        
        // Indicate widget sidebars can use selective refresh in the Customizer.
        add_theme_support( 'customize-selective-refresh-widgets' );
        
        // User for full widht container.
        add_theme_support( 'align-wide' );     
        add_theme_support(
            'gutenberg',
            array( 'wide-images' => true )
        );        
        
        // Used for OnePage Template Back Link 
        if( !function_exists('acrony_detect_homepage') ){
            function acrony_detect_homepage() {
                $onepage = '';
                $onepage = get_post_meta( get_the_ID(), '_acrony_one_page_scroll', true );
                /*If front page is set to display a static page, get the URL of the posts page.*/
                $homepage_id = get_option( 'page_on_front' );
                /*current page id*/
                $current_page_id = ( is_page( get_the_ID() ) ) ? get_the_ID() : '';
                if( $homepage_id == $current_page_id or $onepage == 'on'  ) {
                    return true;
                } else {
                    return false;
                }

            }
        }
        
    }
}
add_action( 'after_setup_theme','acrony_assets_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Acrony 1.0.0
 */
if( !function_exists('acrony_content_width') ){    
    function acrony_content_width() {
        $GLOBALS['content_width'] = apply_filters( 'acrony_content_width', 750 );
    }
}
add_action( 'after_setup_theme', 'acrony_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Acrony 1.0.0
 */
if( !function_exists('acrony_widgets_init') ){
    function acrony_widgets_init() {
        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar', 'acrony' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'acrony' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
        register_sidebar( array(
            'name'          => esc_html__( 'Footer Top', 'acrony' ),
            'id'            => 'sidebar-2',
            'description'   => esc_html__( 'Add widgets here to appear in footer tio.', 'acrony' ),
            'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s col-xs-12 col-sm-6 col-md-3 xs-full masonry-item">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );   
        if( class_exists( 'WooCommerce' ) ){            
            register_sidebar( array(
                'name'          => esc_html__( 'Sidebar Shop', 'acrony' ),
                'id'            => 'sidebar-shop',
                'description'   => esc_html__( 'Add widgets here to appear in your woocommerce sidebar.', 'acrony' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ) );
        }
    }
}
add_action( 'widgets_init', 'acrony_widgets_init' );

if ( !function_exists( 'acrony_fonts_url' ) ) {
    /**
     * Register Google fonts for Acrony.
     *
     * Create your own acrony_fonts_url() function to override in a child theme.
     *
     * @since Acrony 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function acrony_fonts_url() {
        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Roboto, translate this to 'off'. Do not translate into your own language. */
        $fonts[] = 'Poppins:300,400,500,600,700';

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), '//fonts.googleapis.com/css' );
        }

        return esc_url_raw($fonts_url);
    }
}

/**
 * Enqueues scripts and styles.
 *
 * @since Acrony 1.0.0
 */
if( !function_exists('acrony_enqueue_scripts') ){
    function acrony_enqueue_scripts() {
        
        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style( 'acrony-fonts', acrony_fonts_url(), array(), null );

        // Add Font-awesome, used for font icons.
        wp_enqueue_style( 'font-awesome-5-pro', get_theme_file_uri('/assets/css/font-awesome-5-pro.css'), array(), '5.8.1' );

        // Add Bootstrap, Used for default grid system.
        wp_enqueue_style( 'bootstrap', get_theme_file_uri('/assets/css/bootstrap-min.css'), array(), '3.3.7' );
        
        // Add slicknav, Used for responsive mobile menu.
        wp_enqueue_style( 'slicknav', get_theme_file_uri('/assets/css/slicknav.css'), array(), '1.0.10' );

        if( class_exists( 'WooCommerce' ) ){      
            // Add slicknav, Used for responsive mobile menu.
            wp_enqueue_style( 'acrony-wc-style', get_theme_file_uri('/assets/css/wc-style.css'), array(), '1.0.10' );
        }
        // Add Lity, Used for lightbox popup
        wp_enqueue_style( 'lity', get_theme_file_uri('/assets/css/lity-min.css'), array(), '1.0.0' );

        // Add Acrony Theme CSS, Used for important structure style.
        wp_enqueue_style( 'acrony-theme', get_theme_file_uri('/assets/css/theme.css'), array(), '1.0.0' );
               
        // Add Normalizer, Used for remove default tag style.
        wp_enqueue_style( 'normalizer', get_theme_file_uri('/assets/css/normalize.css'), array(), '1.0.0' );
                        
        // Theme stylesheet.
        wp_enqueue_style( 'acrony-style', get_stylesheet_uri() );
                
        // Add responsive, Used for mobile style.
        wp_enqueue_style( 'acrony-responsive', get_theme_file_uri('/assets/css/responsive.css'), array(), '1.0.0' );
        
        // Add Bootstrap, Used for default normal effect.
        wp_enqueue_script( 'bootstrap', get_theme_file_uri('/assets/js/vendor/bootstrap-min.js'), array('jquery'), '3.3.7', true );
        
        // Add WordPress Default Masonry, Used for attach grid.
        wp_enqueue_script('jquery-masonry');
        
        // Add WordPress Default imagesloaded, Used for image load.        
        wp_enqueue_script('imagesloaded');
        
        // Add SlickNav, Used for responsive mobile menu.
        wp_enqueue_script( 'slicknav', get_theme_file_uri('/assets/js/slicknav-min.js'), array('jquery'), '1.0.10', true );
        
        // Add Lity, Used for lightbox popup.
        wp_enqueue_script( 'lity', get_theme_file_uri('/assets/js/lity-min.js'), array('jquery'), '1.0.0', true );
        
        // Add jQuery-Fitvids, Used for responsive Video.
        wp_enqueue_script( 'jquery-fitvids', get_theme_file_uri('/assets/js/fitvids.js'), array('jquery'), '1.1.0', true );
        
        // Add prefixfree, Used for CSS Prefixer.
        wp_enqueue_script( 'prefixfree', get_theme_file_uri('/assets/js/prefixfree-min.js'), array('jquery'), '1.1.0', true );
        
        if(!get_theme_mod('acrony_scrollUp')){   
            // Add scrollUp, Used for scrolling  button to top.
            wp_enqueue_script( 'scrollUp-js', get_theme_file_uri('/assets/js/scrollUp-min.js'), array('jquery'), '2.4.1', true );
        }
                   
        // Add scrollUp, Used for script activation
        wp_enqueue_script( 'acrony-main', get_theme_file_uri('/assets/js/main.js'), array('jquery'), '1.0.0', true );

        $css_selector = array();
        $css_value    = array();
        
        $menu_text_color        = get_post_meta( get_the_ID(), '_acrony_menu_text_color', true );
        $menu_hover_text_color  = get_post_meta( get_the_ID(), '_acrony_menu_hover_text_color', true );
        $menu_bg_color          = get_post_meta( get_the_ID(), '_acrony_menu_bg_color', true );
        $menu_sticky_bg_color   = get_post_meta( get_the_ID(), '_acrony_menu_sticky_bg_color', true );  
        
        $css_value['header-overly-color'] = get_theme_mod('header_overly_color');
        
        if( !empty($menu_bg_color) ){
            $css_value['menu-bg-color'] = esc_attr($menu_bg_color);
        }else{
            $css_value['menu-bg-color'] = esc_attr(get_theme_mod('menu_bg_color'));
        }
        
        if( !empty($menu_sticky_bg_color) ){
            $css_value['menu-sticky-bg'] = esc_attr($menu_sticky_bg_color);
        }else{
            $css_value['menu-sticky-bg'] = esc_attr(get_theme_mod('menu_sticky_bg'));
        }
                
        $css_value['logo-text-color'] = get_theme_mod('logo_text_color');
        $css_value['logo-hover-text-color'] = get_theme_mod('logo_hover_text_color');
        
        if( !empty($menu_text_color) ){
            $css_value['menu-item-color'] = esc_attr($menu_text_color);
        }else{
            $css_value['menu-item-color'] = esc_attr(get_theme_mod('menu_item_color'));
        }
        
        if( !empty($menu_hover_text_color) ){
            $css_value['menu-item-hover-color'] = esc_attr($menu_hover_text_color);
        }else{
            $css_value['menu-item-hover-color'] = esc_attr(get_theme_mod('menu_item_hover_color'));
        }        
        
        $css_value['sticky-logo-color'] = get_theme_mod('sticky_logo_color');
        $css_value['button-text-color'] = get_theme_mod('button_text_color');
        $css_value['button-hover-text-color'] = get_theme_mod('button_hover_text_color');
        $css_value['button-bg-color'] = get_theme_mod('button_bg_color');
        $css_value['button-hover-bg-color'] = get_theme_mod('button_hover_bg_color');
        $css_selector[] = sprintf('.site-header { background-image: url(%s) }', esc_url(get_header_image()) );
        $css_selector[] = sprintf('.site-header .page-title, .site-header .sub-title, .site-header .sub-title a { color:  #%s }', esc_attr(get_header_textcolor()) );
        
        if( !empty($css_value['header-overly-color']) ){
            $css_selector[] = sprintf('.site-header { background-color: %s }', esc_attr($css_value['header-overly-color']) );
        }
        if( !empty($css_value['menu-bg-color']) ){
            $css_selector[] = sprintf('.mainmenu-area { background-color: %s }', esc_attr($css_value['menu-bg-color']) );
        }        
		
        if( !empty($css_value['menu-sticky-bg']) ){
            $css_selector[] = sprintf('.transparent-menu .mainmenu-area.affix, .mainmenu-area.affix { background-color: %s }', esc_attr($css_value['menu-sticky-bg']) );
        }        
        
        if( !empty($css_value['logo-text-color']) ){
            $css_selector[] = sprintf('.site-branding a { color: %s }', esc_attr($css_value['logo-text-color']) );
        }        
        
        if( !empty($css_value['logo-hover-text-color']) ){
            $css_selector[] = sprintf('.site-branding a:hover { color: %s }', esc_attr($css_value['logo-hover-text-color']) );
        }
        
        if( !empty($css_value['sticky-logo-color']) ){
            $css_selector[] = sprintf('.affix .site-branding a { color: %s }', esc_attr($css_value['sticky-logo-color']) );
        }
        
        if( !empty($css_value['menu-item-color']) ){
            $css_selector[] = sprintf('.primary-menu ul.nav > li > a { color: %s } .primary-menu ul.nav > li > a:before{ background-color: %s } ', esc_attr($css_value['menu-item-color']), esc_attr($css_value['menu-item-color']) );
        }
        
        if( !empty($css_value['menu_sticky_item_color']) ){
            $css_selector[] = sprintf('.affix .primary-menu ul.nav > li > a { color: %s } .affix .primary-menu ul.nav > li > a:before{ background-color: %s } ', esc_attr($css_value['menu_sticky_item_color']), esc_attr($css_value['menu_sticky_item_color']) );
        }        
        
        if( !empty($css_value['menu-item-hover-color']) ){
            $css_selector[] = sprintf('.primary-menu ul.nav li a:hover { color: %s }', esc_attr($css_value['menu-item-hover-color']) );
        }
        
        if( !empty($css_value['button-text-color']) ){
            $css_selector[] = sprintf('.header-button { color: %s }', esc_attr($css_value['button-text-color']) );
        }
        
        if( !empty($css_value['button-hover-text-color']) ){
            $css_selector[] = sprintf('.header-button:hover { color: %s }', esc_attr($css_value['button-hover-text-color']) );
        }
        if( !empty($css_value['button-bg-color']) ){
            $css_selector[] = sprintf('.header-button { background-color: %s }', esc_attr($css_value['button-bg-color']) );
        }
        if( !empty($css_value['button-hover-bg-color']) ){
            $css_selector[] = sprintf('.header-button:hover { background-color: %s }', esc_attr($css_value['button-hover-bg-color']) );
        }   
        
        $css_selector = implode( ' ', $css_selector );
        wp_add_inline_style( 'acrony-theme', $css_selector );
        
        // Add comment reply script.
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}

add_action( 'wp_enqueue_scripts', 'acrony_enqueue_scripts' );

// Acrony All Function Pack.
require get_theme_file_path('/inc/acrony-function.php');

// Customizer Add Option.
require get_theme_file_path('/inc/customizer.php');

// Default Template Tag Functions.
require get_theme_file_path('/inc/template-tags.php');

// Important Plugin Activation.
require get_theme_file_path('/inc/acrony-plugin-activation.php');

// OnePage Nav Waker Function.
require get_theme_file_path('/inc/nav-menu-walker.php');

// Importer.
require get_theme_file_path('/inc/importer.php');
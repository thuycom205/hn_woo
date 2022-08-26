<?php
/*
Plugin Name: Acrony Core
Description: Acrony Toolkit is a plugin which is working/Assisting Acrony WordPress Theme. 
Author: Ashekur Rahman
Author URI: https://quomodosoft.com
Version: 1.0.0
Text Domain: acrony-core
*/

if( !function_exists('acrony_plugins_loaded') ){    
    function acrony_plugins_loaded() {
         /*-- Used For Post Meta Field --*/
        require_once( dirname(__FILE__) . '/metabox/init.php');        
        if ( class_exists('KingComposer') ){
            /*-- Used For KingComposer Extra Addons --*/
            require_once( dirname(__FILE__) . '/addons/addons.php');
        }
        require_once( dirname(__FILE__) . '/post-share/index.php');
        require_once( dirname(__FILE__) . '/widget/populer-post.php');
        require_once( dirname(__FILE__) . '/widget/instagram.php');
        require_once( dirname(__FILE__) . '/widget/address-info.php');
        /*-- Support Plugin TextDomain --*/
        load_plugin_textdomain( 'acrony-core', false, basename(dirname(__FILE__)) . '/language/' );
    }
}
add_action( 'plugins_loaded', 'acrony_plugins_loaded' );

/*-- Load Plugin Scripts --*/
if( !function_exists('acrony_scripts') ){
    function acrony_scripts(){  
        /*-- Owl-Carousel Slider Main Style --*/
        wp_enqueue_style('owl-carousel',  plugins_url( '/assets/css/owl-carousel-min.css', __FILE__ ), array(), '1.3.3', 'all' );         
        /*-- Owl-Carousl Slider Theme Style --*/
        wp_enqueue_style('owl-theme',  plugins_url( '/assets/css/owl.theme.css', __FILE__ ), array(), '1.3.3', 'all' );          
        /*-- acrony-core Main Stylesheet --*/
        wp_enqueue_style('acrony-core-style',  plugins_url( '/assets/css/tools.css', __FILE__ ), array(), '1.0.0', 'all' );        
        /*-- Owl-Carousel Script JS --*/
        wp_enqueue_script('owl-carousel',  plugins_url( '/assets/js/owl-carousel-min.js', __FILE__ ), array('jquery'), '1.3.3', true );  
        /*-- acrony-core Active JS --*/
        wp_enqueue_script('acrony-core-active',  plugins_url( '/assets/js/active.js', __FILE__ ), array('jquery'), '1.0.0', true );        
    }
}
add_action('wp_enqueue_scripts','acrony_scripts');

if( !function_exists('acrony_admin_script') ){
    function acrony_admin_script(){
        /*-- Load Admin Style --*/
        wp_enqueue_style( 'acrony-core-admin', plugins_url( '/assets/css/admin.css',__FILE__) );
    }
}
add_action( 'admin_enqueue_scripts','acrony_admin_script' );



function acrony_set_post_views($postID) {
    $count_key = 'acrony_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function acrony_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    acrony_set_post_views($post_id);
}
add_action( 'wp_head', 'acrony_track_post_views');

// Register and load the widget
function acrony_load_widget() {
    register_widget( 'acrony_popular_posts' );
	register_widget( 'acrony_address_widget' );
}
add_action( 'widgets_init', 'acrony_load_widget' );

add_shortcode( 'acrony_social_menu', 'acrony_social_menu_link' );


/*=============================================
=            BREADCRUMBS			            =
=============================================*/
function acrony_breadcrumb(){
    // Set variables for later use
    $here_text        = __( 'You are currently here!' );
    $home_link        = home_url('/');
    $home_text        = __( 'Home' );
    $link_before      = '<span typeof="v:Breadcrumb">';
    $link_after       = '</span>';
    $link_attr        = ' rel="v:url" property="v:title"';
    $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $delimiter        = ' | ';              // Delimiter between crumbs
    $before           = '<span class="current">'; // Tag before the current crumb
    $after            = '</span>';                // Tag after the current crumb
    $page_addon       = '';                       // Adds the page number if the query is paged
    $breadcrumb_trail = '';
    $category_links   = '';
    /** 
     * Set our own $wp_the_query variable. Do not use the global variable version due to 
     * reliability
     */
    $wp_the_query   = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    // Handle single post requests which includes single pages, posts and attatchments
    if ( is_singular() ) 
    {
        /** 
         * Set our own $post variable. Do not use the global variable version due to 
         * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
         */
        $post_object = sanitize_post( $queried_object );
        // Set variables 
        $title          = apply_filters( 'the_title', $post_object->post_title );
        $parent         = $post_object->post_parent;
        $post_type      = $post_object->post_type;
        $post_id        = $post_object->ID;
        $post_link      = $before . $title . $after;
        $parent_string  = '';
        $post_type_link = '';
        if ( 'post' === $post_type ) 
        {
            // Get the post categories
            $categories = get_the_category( $post_id );
            if ( $categories ) {
                // Lets grab the first category
                $category  = $categories[0];

                $category_links = get_category_parents( $category, true, $delimiter );
                $category_links = str_replace( '<a',   $link_before . '<a' . $link_attr, $category_links );
                $category_links = str_replace( '</a>', '</a>' . $link_after,             $category_links );
            }
        }
        if ( !in_array( $post_type, ['post', 'page', 'attachment'] ) )
        {
            $post_type_object = get_post_type_object( $post_type );
            $archive_link     = esc_url( get_post_type_archive_link( $post_type ) );

            $post_type_link   = sprintf( $link, $archive_link, $post_type_object->labels->singular_name );
        }
        // Get post parents if $parent !== 0
        if ( 0 !== $parent ) 
        {
            $parent_links = [];
            while ( $parent ) {
                $post_parent = get_post( $parent );
                $parent_links[] = sprintf( $link, esc_url( get_permalink( $post_parent->ID ) ), get_the_title( $post_parent->ID ) );
                $parent = $post_parent->post_parent;
            }
            $parent_links = array_reverse( $parent_links );
            $parent_string = implode( $delimiter, $parent_links );
        }
        // Lets build the breadcrumb trail
        if ( $parent_string ) {
            $breadcrumb_trail = $parent_string . $delimiter . $post_link;
        } else {
            $breadcrumb_trail = $post_link;
        }

        if ( $post_type_link )
            $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

        if ( $category_links )
            $breadcrumb_trail = $category_links . $breadcrumb_trail;
    }
    // Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
    if( is_archive() )
    {
        if (    is_category()
             || is_tag()
             || is_tax()
        ) {
            // Set the variables for this section
            $term_object        = get_term( $queried_object );
            $taxonomy           = $term_object->taxonomy;
            $term_id            = $term_object->term_id;
            $term_name          = $term_object->name;
            $term_parent        = $term_object->parent;
            $taxonomy_object    = get_taxonomy( $taxonomy );
            $current_term_link  = $before . $taxonomy_object->labels->singular_name . ': ' . $term_name . $after;
            $parent_term_string = '';
            if ( 0 !== $term_parent )
            {
                // Get all the current term ancestors
                $parent_term_links = [];
                while ( $term_parent ) {
                    $term = get_term( $term_parent, $taxonomy );

                    $parent_term_links[] = sprintf( $link, esc_url( get_term_link( $term ) ), $term->name );

                    $term_parent = $term->parent;
                }
                $parent_term_links  = array_reverse( $parent_term_links );
                $parent_term_string = implode( $delimiter, $parent_term_links );
            }
            if ( $parent_term_string ) {
                $breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
            } else {
                $breadcrumb_trail = $current_term_link;
            }
        } elseif ( is_author() ) {
            $breadcrumb_trail = __( 'Author archive for ') .  $before . $queried_object->data->display_name . $after;
        } elseif ( is_date() ) {
            // Set default variables
            $year     = $wp_the_query->query_vars['year'];
            $monthnum = $wp_the_query->query_vars['monthnum'];
            $day      = $wp_the_query->query_vars['day'];

            // Get the month name if $monthnum has a value
            if ( $monthnum ) {
                $date_time  = DateTime::createFromFormat( '!m', $monthnum );
                $month_name = $date_time->format( 'F' );
            }

            if ( is_year() ) {

                $breadcrumb_trail = $before . $year . $after;

            } elseif( is_month() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), $year );

                $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

            } elseif( is_day() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ),             $year       );
                $month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), $month_name );

                $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
            }
        } elseif ( is_post_type_archive() ) {
            $post_type        = $wp_the_query->query_vars['post_type'];
            $post_type_object = get_post_type_object( $post_type );
            $breadcrumb_trail = $before . $post_type_object->labels->singular_name . $after;
        }
    }
    // Handle the search page
    if ( is_search() ) {
        $breadcrumb_trail = __( 'Search query for: ' ) . $before . get_search_query() . $after;
    }
    // Handle 404's
    if ( is_404() ) {
        $breadcrumb_trail = $before . __( 'Error 404' ) . $after;
    }
    // Handle paged pages
    if ( is_paged() ) {
        $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
        $page_addon   = $before . sprintf( __( ' ( Page %s )' ), number_format_i18n( $current_page ) ) . $after;
    }
    $breadcrumb_output_link  = '';
    $breadcrumb_output_link .= '<div class="bread">';
    if (    is_home()
         || is_front_page()
    ) {
        // Do not show breadcrumbs on page one of home and frontpage
        if ( is_paged() ) {
            $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
            $breadcrumb_output_link .= $page_addon;
        }
    } else {
        $breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
    $breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';

    echo $breadcrumb_output_link;
}

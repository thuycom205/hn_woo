<?php

require_once(ABSPATH . 'wp-admin/includes/file.php');

function acrony_body_classes( $classes ) {
    $menu_transparent = get_post_meta( get_the_ID(), '_acrony_transparent_menu', true );
    $remove_header = get_post_meta( get_the_ID(), '_acrony_page_header', true );
    $default_transparent = get_theme_mod('acrony_transparent_menu');
   
    
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
        
    if ( class_exists( 'WooCommerce' ) ) {
        $classes[] = 'woocommerce';
    }
    if( $menu_transparent == 'on' || $default_transparent == true ){
        $classes[] = 'transparent-menu';
    }
    if( $remove_header == 'on' ){
        $classes[] = 'header-remove';
    }
    
	return $classes;
}
add_filter( 'body_class', 'acrony_body_classes' );

/**
* BODY OPEN FUNCTION
*/
if ( !function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function acrony_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'acrony_pingback_header' );



function acrony_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
} 
add_filter( 'comment_form_fields', 'acrony_move_comment_field_to_bottom' );


/****************
Social Menu Link
****************/
function acrony_social_menu_link(){
    $data = array();        
    $facebook = get_theme_mod( 'facebook' );
    $twitter = get_theme_mod( 'twitter' );
    $linkedin = get_theme_mod( 'linkedin' );
    $instagram = get_theme_mod( 'instagram' );
    $flickr = get_theme_mod( 'flickr' );
    $pinterest = get_theme_mod( 'pinterest' );
    $dribbble = get_theme_mod( 'dribbble' );
    $youtube = get_theme_mod( 'youtube' );
    $data[] = '<div class="social-menu-list">';
    if( !empty($facebook) ){
        $data[] = '<a target="_blank" href="'.esc_url($facebook).'" ><i class="fab fa-facebook-f"></i></a>';
    }
    if( !empty($twitter) ){
        $data[] = '<a target="_blank" href="'.esc_url($twitter).'" ><i class="fab fa-twitter"></i></a>';
    }        
    if( !empty($linkedin) ){
        $data[] = '<a target="_blank" href="'.esc_url($linkedin).'" ><i class="fab fa-linkedin-in"></i></a>';
    }      
    if( !empty($instagram) ){
        $data[] = '<a target="_blank" href="'.esc_url($instagram).'" ><i class="fab fa-instagram"></i></a>';
    } 
    if( !empty($flickr) ){
        $data[] = '<a target="_blank" href="'.esc_url($flickr).'" ><i class="fab fa-flickr"></i></a>';
    }        
    if( !empty($pinterest) ){
        $data[] = '<a target="_blank" href="'.esc_url($pinterest).'" ><i class="fab fa-pinterest-p"></i></a>';
    }
    if( !empty($dribbble) ){
        $data[] = '<a target="_blank" href="'.esc_url($dribbble).'" ><i class="fab fa-dribbble"></i></a>';
    }       
    if( !empty($youtube) ){
        $data[] = '<a target="_blank" href="'.esc_url($youtube).'" ><i class="fab fa-youtube"></i></a>';
    }
    $data[] = '</div>';
    $data = implode( ' ',$data );
    return $data;
}


if ( class_exists( 'WooCommerce' ) ) {
    function acrony_custom_mini_cart() {
        echo '<div class="mini-cart-area">';        
        echo '<a href="#mini-cart-box" class="cart-icon" data-toggle="collapse"> ';
        echo '<i class="fal fa-shopping-cart"></i>';
        echo '</a>';
        echo '<sup class="cart-items-count count">';
        echo WC()->cart->get_cart_contents_count();
        echo '</sup>';
        echo '<div id="mini-cart-box" class="collapse mini-cart">';
        echo '<a href="#mini-cart-box" class="cart-close" data-toggle="collapse" >&times;</a>';
        echo '<div class="header-quickcart">';        
        woocommerce_mini_cart();
        echo '</div>';        
        echo '</div>';        
        echo '</div>';                
    }    
    add_filter( 'woocommerce_add_to_cart_fragments', 'acrony_cart_count_fragments' );
    function acrony_cart_count_fragments( $fragments ) {
        $fragments['sup.cart-items-count'] = '<sup class="cart-items-count" >' . WC()->cart->get_cart_contents_count() . '</sup>';
        ob_start();
        echo '<div class="header-quickcart">';
        woocommerce_mini_cart();
        echo '</div>';
        $fragments['div.header-quickcart'] = ob_get_contents();
        ob_end_clean();        
        return $fragments;    
    }
}


/*-- WooCommerce-Action-Remove --*/
if ( class_exists( 'woocommerce' ) ) {
    add_filter( 'woocommerce_output_related_products_args', 'acrony_related_products_args', 20 );
      function acrony_related_products_args( $args ) {
        $args['posts_per_page'] = 4; // 4 related products
        $args['columns'] = 3; // arranged in 2 columns
        return $args;
    }
    /*-- Remove-Action ---*/
    remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );    
    remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_title',5 );
    remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_rating',10 );
    remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_price',10 );
    remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt',20 );
    remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30 );
    remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta',40 );
    remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_sharing',50 );
    /*-- Add-Action --*/
    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_rating', 5 );
    add_action( 'woocommerce_single_product_summary','acrony_get_product_category_list', 10 );
    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_title', 15 );
    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_price', 20 );
    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta', 25 );
    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt', 30 );
    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_sharing', 35 );
    add_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 40 );
    function acrony_get_product_category_list(){
        echo wc_get_product_category_list( get_the_ID(), ', ', '<div class="category">', '</div>' );
    }    
}
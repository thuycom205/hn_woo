<?php

// Add WooCommerce product layout switch between the product result count and product ordering
add_action('woocommerce_before_shop_loop', function() {
    ?>
    <div class="col-lg-2 col-sm-3 col-5">
        <div class="product_view_grid">
           
        </div>
    </div>
    <?php
}, 25);


// Remove WooCommerce product pagination from woocommerce_after_shop_loop hook
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

// WooCommerce Product single page hooks rearrange


add_action('woocommerce_single_product_summary', function() {
    ?>
    <div class="share-link">
        <label> <?php esc_html_e('Share ON:', 'appart') ?> </label>
        <ul class="social-icon">
            <li><a class="facebook" title="Facebook" href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"> </i></a></li>
            <li><a class="twitter" title="Twitter" href="https://twitter.com/intent/tweet?text=<?php the_permalink(); ?>"><i class="fa fa-twitter"> </i></a></li>
            <li><a class="linkedin" title="Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>"><i class="fa fa-linkedin"> </i></a></li>
            <li><a class="rss" title="RSS" href="https://plus.google.com/share?url=<?php the_permalink() ?>"><i class="fa fa-google-plus"> </i></a></li>
        </ul>
    </div>
    <?php
}, 65);

// Enabling the gallery in themes that declare
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/* Adding Custom Hooks */
remove_action('woocommerce_single_product_summary' ,'woocommerce_template_single_title' , 5);
remove_action('woocommerce_single_product_summary' ,'woocommerce_template_single_meta' , 40);
remove_action('woocommerce_single_product_summary' ,'woocommerce_template_single_add_to_cart' , 30);
add_action('woocommerce_single_product_summary', 'hooks_open_div', 30 , 40);
function hooks_open_div() {
    echo '<div class="mb_50">';
     woocommerce_template_single_add_to_cart();
    echo '</div>';
          woocommerce_template_single_meta();
}

add_action('woocommerce_single_product_summary', 'hooks_close_div', 5);
function hooks_close_div() {
    echo '<div class=" ">';
    woocommerce_template_single_title();
    echo '</div>';

}
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);



/**
 * Checkout form fields customizing
 */
add_filter( 'woocommerce_checkout_fields' , function ( $fields ) {
    $fields['billing']['billing_first_name'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('First name *', 'placeholder', 'appart'),
        'required'  => true,
        'class'     => array('col-md-6'),
        'clear'     => true
    );
    $fields['billing']['billing_last_name'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Last name *', 'placeholder', 'appart'),
        'required'  => true,
        'class'     => array('col-md-6'),
        'clear'     => true
    );
    $fields['billing']['billing_company'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Company name (optional)', 'placeholder', 'appart'),
        'required'  => false,
        'class'     => array('col-md-12'),
        'clear'     => true
    );
    $fields['billing']['billing_city'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Town / City *', 'placeholder', 'appart'),
        'class'     => array('col-md-12'),
        'clear'     => true
    );
    $fields['billing']['billing_postcode'] = array(
        'label'     => '',
        'placeholder' => esc_html_x('Postcode / ZIP (optional)', 'placeholder', 'appart'),
        'class'     => array('col-md-12'),
        'clear'     => true
    );
    $fields['billing']['billing_phone'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Phone', 'placeholder', 'appart'),
        'required'  => false,
        'class'     => array('col-md-6'),
        'clear'     => true
    );
    $fields['billing']['billing_email'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Email address *', 'placeholder', 'appart'),
        'required'  => true,
        'class'     => array('col-md-6'),
        'clear'     => true
    );

    // Shipping Fields
    $fields['shipping']['shipping_first_name'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('First name *', 'placeholder', 'appart'),
        'required'  => false,
        'class'     => array('col-md-6'),
        'clear'     => true
    );
    $fields['shipping']['shipping_last_name'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Last name *', 'placeholder', 'appart'),
        'required'  => false,
        'class'     => array('col-md-6'),
        'clear'     => true
    );
    $fields['shipping']['shipping_company'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Company name (optional)', 'placeholder', 'appart'),
        'required'  => false,
        'class'     => array('col-md-12'),
        'clear'     => true
    );
    $fields['shipping']['shipping_city'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Town / City *', 'placeholder', 'appart'),
        'class'     => array('col-md-12'),
        'clear'     => true
    );
    $fields['shipping']['shipping_postcode'] = array(
        'label'     => '',
        'placeholder' => esc_html_x('Postcode / ZIP (optional)', 'placeholder', 'appart'),
        'class'     => array('col-md-12'),
        'clear'     => true
    );
    $fields['shipping']['shipping_phone'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Phone', 'placeholder', 'appart'),
        'required'  => false,
        'class'     => array('col-md-6'),
        'clear'     => true
    );
    $fields['shipping']['shipping_email'] = array(
        'label'     => '',
        'placeholder'   => esc_html_x('Email address *', 'placeholder', 'appart'),
        'required'  => true,
        'class'     => array('col-md-6'),
        'clear'     => true
    );

    return $fields;
});


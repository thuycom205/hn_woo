<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
$get_column = wc_get_loop_prop( 'columns' );
switch ($get_column) {
    case '3':
        $column = '4';
        break;
    case '4':
        $column = '3';
        break;
    case '2':
        $column = '6';
        break;
    case '6':
        $column = '2';
        break;
    default:
        $column = '3';
        break;
}
?>
<div <?php wc_product_class('col-lg-'.esc_attr($column).' col-sm-6'); ?>>
    <div class="sale_product_item pr_grid">
        <?php if($product->is_on_sale()) : ?>
            <div class="ribbon"><span class="text"> <?php esc_html_e('Sale', 'appart') ?> </span></div>
        <?php endif; ?>
        <?php if ( ! $product->managing_stock() && ! $product->is_in_stock() ) : ?>
            <div class="ribbon"><span class="text"> <?php esc_html_e('Out of Stock', 'appart') ?> </span></div>
        <?php endif; ?>
        <div class="product">
            <?php if (woocommerce_get_product_thumbnail()) : ?>
                <a href="<?php the_permalink() ?>" class="pr_img">
                    <?php the_post_thumbnail() ?>
                </a>
            <?php endif; ?>
            <div class="hover_contents">

                <?php if(shortcode_exists('ti_wishlists_addtowishlist')): ?>
                    <span class="wihslist-btn" title="<?php esc_attr_e('Add To Wishlist', 'appart') ?>">
                    <?php echo  do_shortcode('[ti_wishlists_addtowishlist]') ; ?>
                </span>
                <?php endif; ?>

                <span class="like" title="<?php echo esc_attr($product->single_add_to_cart_text()) ?>">
                    <a href="?add-to-cart=<?php echo get_the_ID() ?>">
                        <i class="ti-bag"></i>
                    </a>
                </span>
                <!--<span class="like" title="<?php /*esc_attr_e('Compare', 'appart') */?>">
                    <a href=""><i class="ti-tag"></i></a>
                </span>-->
            </div>
            <div class="pr_details">
                <a href="<?php the_permalink() ?>">
                    <h5 class="f_robot_c"> <?php the_title() ?> </h5>
                </a>
                <div class="pr_price">
                    <?php  woocommerce_template_loop_price(); ?>
                    <?php woocommerce_template_single_rating() ?>
                </div>
            </div>
        </div>
    </div>
</div>
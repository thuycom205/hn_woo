<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="mb_50">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <?php
    do_action( 'woocommerce_before_add_to_cart_quantity' );
    ?>
    <div class="product-qty">
       
        <?php
        woocommerce_quantity_input( array(
            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
        ) );
        ?>
       
    </div>
    <?php do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>

    <div class="cart_button">
        <?php if(shortcode_exists('ti_wishlists_addtowishlist')) : ?>
            <!-- Wishlist Button -->
            <?php echo do_shortcode('[ti_wishlists_addtowishlist]') ?>
        <?php endif; ?>
        <button type="submit" href="#" class="cart_btn single_add_to_cart_button">
            <i class="ti-bag"></i> <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
        </button>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="variation_id" class="variation_id" value="0" />
    </div>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</div>

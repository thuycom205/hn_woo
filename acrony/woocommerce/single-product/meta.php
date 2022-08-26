<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<ul class="product_meta">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<li class="sku_wrapper"><span class="title"><?php esc_html_e( 'SKU:', 'acrony' ); ?></span> <span class="sku"><?php echo wp_kses_post(( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'acrony' )); ?></span></li>
	<?php endif;    
    echo wc_get_product_tag_list( $product->get_id(), ', ', '<li class="tagged_as"><span class="title">'._n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'acrony' ).'</span>', '</li>' ); 

    do_action( 'woocommerce_product_meta_end' ); ?>

</ul>

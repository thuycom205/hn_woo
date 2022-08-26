<?php
global $woocommerce;
if(class_exists('WooCommerce')) {
    $opt = get_option('appart_opt');
    $is_cart_icon = !empty($opt['is_cart_icon']) ? $opt['is_cart_icon'] : '';
    if($is_cart_icon == '1') :
        ?>
        <div class="attr-nav">
            <ul class="nav navbar-nav">
                <li class="cart-menu dropdown">
                    <a class="dropdown-toggle" href="<?php echo wc_get_cart_url() ?>">
                        <span class="cart">
                            <?php echo esc_html($woocommerce->cart->cart_contents_count); ?>
                        </span>
                        <i class="ti-shopping-cart"></i>
                    </a>
                    <?php if($woocommerce->cart->cart_contents_count !== 0 ) : ?>
                    <ul class="dropdown-menu">
                        <?php
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                ?>
                                <li class="cart-single-item clearfix">
                                    <div class="cart-img">
                                        <?php
                                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                                        if (!$product_permalink) {
                                            echo appart_wp_kses($thumbnail);
                                        } else {
                                            printf('<a href="%s">%s</a>', esc_url($product_permalink), appart_wp_kses($thumbnail));
                                        }
                                        ?>
                                    </div>
                                    <div class="cart-content text-left">
                                        <p class="cart-title">
                                            <?php
                                            if (!$product_permalink) {
                                                echo appart_wp_kses(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                            } else {
                                                echo appart_wp_kses(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                            }

                                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                            // Meta data.
                                            echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                            // Backorder notification.
                                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                echo appart_wp_kses(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'appart') . '</p>'));
                                            }
                                            ?>
                                        </p>
                                        <p> <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                                            <?php if (!empty($cart_item['quantity'])) : ?>
                                                <span class="item-qty"> x <?php echo esc_html($cart_item['quantity']) ?> </span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="cart-remove">
                                        <?php
                                        // @codingStandardsIgnoreLine
                                        echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                            '<a href="%s" class="remove action" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="fa fa-close"></span></a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            esc_html__('Remove this item', 'appart'),
                                            esc_attr($product_id),
                                            esc_attr($_product->get_sku())
                                        ), $cart_item_key);
                                        ?>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php if (sizeof(WC()->cart->get_cart()) != 0) : ?>
                            <li class="cart_f">
                                <div class="cart-pricing">
                                    <p class="total">
                                        <?php esc_html_e('Subtotal :', 'appart') ?>
                                        <span class="p-total text-right"> <?php wc_cart_totals_order_total_html(); ?> </span>
                                    </p>
                                </div>
                                <div class="cart-button text-center">
                                    <a href="<?php echo wc_get_cart_url() ?>"
                                       class="btn btn-cart btn-animated-none"> <?php esc_html_e('View Cart', 'appart') ?> </a>
                                    <a href="<?php echo wc_get_checkout_url() ?>"
                                       class="btn btn-cart btn-animated-none"> <?php esc_html_e('Checkout', 'appart') ?> </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
                </li>
            </ul>
        </div>
        <?php
    endif;
}
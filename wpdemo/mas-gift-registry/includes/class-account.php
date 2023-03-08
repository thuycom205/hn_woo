<?php
if ( ! class_exists( 'Woo_Reg_Account' ) ):
class Woo_Reg_Account {
    public function account_menu_items($items) {
            $items['mas-gift-registry'] = __( 'Gift Registry', 'masr' );
            $items['customer-logout']  = __( 'Logout', 'woocommerce' );
            return $items;
    }

    public function show_add_gift_registry() {
        $product_id = get_the_ID();
        global $product;
        if ( is_user_logged_in() ) {
            $is_user_logged_in = '1';
        } else {
            $is_user_logged_in = '0';
        }
        ?>
        <div class="button-add-registry">
            <input type="hidden" name="action" value="masr_add_item"/>
            <input type="hidden" name="message" value="success" id="mars-message-gift-registry"/>
            <input type="hidden" name="add-registry" id="masr-add-registry"/>
            <input type="hidden" name="quantity" id="add-registry-qty" value="1"/>
            <input type="hidden" name="add-to-giftregistry" id="masr-add-to-giftregistry"
                   value="<?= $product_id; ?>"/>
            <input type="hidden" id="masr_admin_url" value="<?php echo admin_url( 'admin-ajax.php' ) ?>" />
            <input type="hidden" id="masr_user_id" value="<?php echo $is_user_logged_in ?>" />
            <input type="hidden" id="mars_account_page" value="<?php echo wc_get_page_permalink( 'myaccount' )?>" />
            <input type="hidden" name="masr_giftregistry_variation_id" id="masr_giftregistry_variation_id" value="0"
                   style="display: none;"/>
            <button class="button alt" id="masr_add-to-giftregistry-list">
                <?php echo __( 'Add gift registry', 'masr' ); ?>
            </button>
            <?php $ajax_nonce = wp_create_nonce("masr_ajax_get_registry"); ?>
            <input type="hidden"  id="mars_nonce" value="<?php echo $ajax_nonce?>">
            <input type="hidden"  id="mars_is_user_login" value="<?php echo $is_user_logged_in?>">
            <input type="hidden" id="masr_admin_url" value="<?php echo admin_url( 'admin-ajax.php' ) ?>" />
            <div style="display:none">
                <div class="grlist" >
                    <?php
                    $registries =  WooReg()->getRegistry();
                    ?>
                    <?php if ($registries) {
                        for ( $i = 0; $i < count($registries); $i++) {
                            $registry = $registries[$i];
                            ?>
                            <button onclick="window.marsObj.addItem('<?php echo $registry['ID'] ?>')" >  <?php echo $registry['title'] ?></button>
                        <?php }}?>
                </div>

            </div>
        </div>
      <?php
    }

    public function frontend_enqueue() {

        if ( is_user_logged_in() ) {
            $is_user_logged_in = '1';
        } else {
            $is_user_logged_in = '0';
        }
        if ( isset( $is_user_logged_in ) ) {
            $masrobj = array(
                'ajax_url'          => admin_url( 'admin-ajax.php' ),
                'is_user_logged_in' => $is_user_logged_in,
                'myaccount_url'     => wc_get_page_permalink( 'myaccount' )
            );
        } else {
            $masrobj = array(
                'ajax_url'      => admin_url( 'admin-ajax.php' ),
                'myaccount_url' => wc_get_page_permalink( 'myaccount' )
            );
        }
        wp_enqueue_script( 'zebra-dialog', WOOREG_URL . '/assets/js/masr.js', array( 'jquery' ), WOOREG_VERSION );
        wp_enqueue_script( 'masr-frontend-javascript', WOOREG_URL . '/assets/js/zebra_dialog.min.js', array( 'jquery' ), WOOREG_VERSION );
        wp_enqueue_script( 'masr-qr-javascript', WOOREG_URL . '/assets/js/qrcode.min.js', array( 'jquery' ), WOOREG_VERSION );

        wp_enqueue_style( 'masr-frontend-style', WOOREG_URL . '/assets/masr.css', array(), WOOREG_VERSION );
        wp_enqueue_style( 'masr-zebra-dialog', WOOREG_URL . '/assets/css/materialize/zebra_dialog.min.css', array(), WOOREG_VERSION );
    }
}
endif;

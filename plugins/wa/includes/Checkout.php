<?php

namespace Mas\Whatsapp;

class Checkout
{
     public function updateCart($order_id, $wc_old_status, $wc_new_status) {
         if ( 'pending' !== $wc_new_status && 'failed' !== $wc_new_status && 'cancelled' !== $wc_new_status && 'trash' !== $wc_new_status ) {
             if ( $order_id > 0 ) {
                 $cart_id = get_post_meta( $order_id, 'maswa_recover_order_placed', true );
                 if ((!$cart_id > 0 )||( WC()->session->get('email_sent_id') =='')) {
                     $abandoned_id = get_post_meta( $order_id, 'maswa_abandoned_cart_id', true );
                    if ($abandoned_id) {
                        $post = get_post((int)$abandoned_id);
                        if ($post) wp_delete_post();
                    }
                     //get cart post
                 }

             }
         } elseif ( 'pending' === $wc_old_status && 'cancelled' === $wc_new_status ) {
             $abandoned_id       = get_post_meta( $order_id, 'maswa_abandoned_cart_id', true );
             if ($abandoned_id) {
                 $postId = (int)$abandoned_id;
                 update_post_meta($postId,'cart_ignored' ,'1');
             }
         }
     }
}
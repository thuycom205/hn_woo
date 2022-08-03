<?php

namespace Mas\Whatsapp;

class Cart
{
    public function logQuote() {
        $this->_logQuote();
    }

    protected function _logQuote() {
        global $wpdb;
        $data = [];
        $user_id = 0;

        $quoteTbl = $wpdb->prefix . 'mas_quote';
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
//            $user_meta = get_metadata('user', $user_id);
            $user = wp_get_current_user();

//            if (isset($user_meta ['billing_email']) && isset($user_meta ['billing_email'][0])) {
//                $user_email = $user_meta ['billing_email'] [0];
//            }
//            $user_name = $user_meta ['first_name'] [0] . ' ' . $user_meta ['last_name'] [0];
            $user_email = $user->user_email;
            $user_nicename = $user->user_nicename;
            $data['is_registered'] = 1;
            $data['user_name'] = $user_nicename;
        }

        $currentTime = new \DateTime();
        $format = 'Y-m-d H:i:s';
        $current_time = $currentTime->format($format);

//        $query = "SELECT * FROM ".$quoteTbl." WHERE `user_id` = %s AND `is_abandoned` = %s AND `is_recovered` = %s AND `is_converted` = %s  ORDER BY `id` DESC;";

//        $results = $wpdb->get_row($wpdb->prepare($query, array($user_id, '0', '0', '0')), ARRAY_A);

        $cart_info_arr = get_user_meta($user_id, '_woocommerce_persistent_cart_'.get_current_blog_id(), true);
        $cart_info = json_encode($cart_info_arr);
        $total = 0;
        $cart = [];

        if ($cart_info_arr)  $cart = $cart_info_arr ['cart'];
        $data['user_id'] = $user_id;
        $data['cart_content'] = $cart_info;
        $data['abandoned_cart_time'] = $current_time;
        $data['is_abandoned'] =0;
        $data['is_recovered'] = 0;
        $data['is_converted'] = 0;
        $phone =  get_user_meta( $user_id, 'billing_phone', true ) ;


        if ($cart_info_arr)  $cart = $cart_info_arr ['cart'];
        try {
            $total = WC()->cart->get_cart_contents_total();
        } catch (\ErrorException $e) {
            foreach ($cart as $item_key => $item_value) {
                if (isset($item_value['line_total']))
                {
                    $total += $item_value['line_total'];
                }
            }
        }

        if ($cart_info_arr && !empty($cart) ) {

            if (isset($cart [key($cart)]) && isset($cart [key($cart)] ['line_total'])) {
                //cartId
                $unique = key($cart);
                $data['uniq'] = $unique;
                $query = "SELECT `uniq`,`id` FROM ".$quoteTbl." WHERE `uniq` = %s and `user_id`=%d";
                $row = $wpdb->get_row($wpdb->prepare($query,$unique,$user_id), ARRAY_A);
                if (!$row || empty ($row)) {
                    if (!isset($row['uniq']) || !$row['uniq']) {
                        // customer just add new product to cart so insert a record about it
                        if ($user_email) {
                            $data['user_email'] = $user_email;
                            $wpdb->insert($quoteTbl,$data);
                        }
                    } else{
                        $wpdb->update($quoteTbl, ['uniq' => $unique], ['id' => $row['id']]);
                    }
                } else {
                    /**
                     * update the quote and reset the is_abandoned cart to no
                     */
                    $wpdb->update($quoteTbl, array(
                        'cart_content' => $cart_info,
                        'abandoned_cart_time' => $current_time,
                        'total' => $total,
                        'is_abandoned' => 0,
                        'uniq' => $unique
                    ), array(
                        'id' => $row['id']
                    ));
                }
            }
        }
        //end of if
    }
}
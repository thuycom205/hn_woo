<?php
class Mars_GiftRegistry_Util
{
    public static function generateCouponForOrder($order_id,$subtotal, $gift_registry_id) {
         $xgiftregistry_enable = get_option('xgiftregistry_enable');
         $xgiftregistry_coupon_pattern = get_option('xgiftregistry_coupon_pattern');
         $xgiftregistry_coupon_ratio = get_option('xgiftregistry_coupon_ratio');

         if ($xgiftregistry_enable =='yes' && $xgiftregistry_coupon_pattern != '' && $xgiftregistry_coupon_ratio !='') {
                try {
                    $coupon_code =  self::generate_code($xgiftregistry_coupon_pattern);
                    $ration_f = floatval($xgiftregistry_coupon_ratio);
                    $c_amount = $subtotal*$ration_f/100;
                    self::generate_coupon($coupon_code,$c_amount,$gift_registry_id,$order_id);
                    update_post_meta($order_id,'_xgiftregistry_sent_mail','not_sent');
                } catch (Exception $e) {
                    error_log(print_r($e));
                }
            }
    }

    public static function generate_code($pattern)
    {
        if ($pattern == null || $pattern =='') {
           $pattern = get_option('xgiftcard_coupon_pattern','[A5]');
        }

        $gen_arr = array();
        preg_match_all("/\[[AN][.*\d]*\]/", $pattern, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $delegate = substr($match [0], 1, 1);
            $length = substr($match [0], 2, strlen($match [0]) - 3);
            if ($delegate == 'A') {
                $gen = self::generate_string($length);
            } elseif ($delegate == 'N') {
                $gen = self::generate_num($length);
            }

            $gen_arr [] = $gen;
        }

        foreach ($gen_arr as $g) {
            $pattern = preg_replace('/\[[AN][.*\d]*\]/', $g, $pattern, 1);
        }

        return $pattern;
    }

    public static function generate_string($length)
    {
        if ($length == 0 || $length == null || $length == '') {
            $length = 5;
        }
        $c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $rand = '';
        for ($i = 0; $i < $length; $i++) {
            $rand .= $c [rand() % strlen($c)];
        }

        return $rand;
    }

    /**
     * generate arbitratry string contain number digit
     *
     * @param int $length
     *
     * @return string
     */
    public static function generate_num($length)
    {
        if ($length == 0 || $length == null || $length == '') {
            $length = 5;
        }
        $c = "0123456789";
        $rand = '';
        for ($i = 0; $i < $length; $i++) {
            $rand .= $c [rand() % strlen($c)];
        }

        return $rand;
    }

    public static function generate_coupon($coupon_code,$amount,$gifregisry_id,$order_id)
    {
       // $coupon_code = 'UNIQUECODE'; // Code - perhaps generate this from the user ID + the order ID
        //$amount = '10'; // Amount
        $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product

        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type'     => 'shop_coupon'
        );

        $new_coupon_id = wp_insert_post( $coupon );

          // Add meta
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', 'no' );
        update_post_meta( $new_coupon_id, 'product_ids', '' );
        update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
        update_post_meta( $new_coupon_id, 'usage_limit', '1' );
        update_post_meta( $new_coupon_id, 'expiry_date', '' );
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
        update_post_meta( $new_coupon_id, 'xgifrestry_id', $gifregisry_id);
        update_post_meta( $new_coupon_id, 'xgifrestry_order_id', $order_id);
    }

    static function getCouponForGiftRegistry($registry_id) {
        $couponArr = [];
        $args = [
            'post_type' => ['shop_coupon'],
            //'posts_per_page' => 11,
            'meta_query' => [
                [
                    'key' => 'xgifrestry_id',
                    'value' => $registry_id,
                ]
            ],
        ];
        $query = new WP_Query($args);
        while ($query->have_posts()) {
            global $post;
            $query->the_post();
            $coupon_amount = get_post_meta($post->ID,'coupon_amount', true);
            $xgifrestry_order_id = get_post_meta($post->ID,'xgifrestry_order_id', true);

            $couponArr[] =['coupon' =>$post->post_title,
                'coupon_amount' =>$coupon_amount,
                'order_id' => $xgifrestry_order_id,
                'created_at' =>$post->post_date
            ];

        }
        wp_reset_postdata();

        return $couponArr;
    }

    static function getAllGiftRegistry() {
        $output = [];
        $args = array(
            'posts_per_page'   => 1,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'page',
            'name'      => 'giftregistry'
        );
        wp_reset_postdata();

        $page = get_posts( $args );
        if (!is_array($page));
        $gp = $page[0];
        $mas_gr_link = get_permalink( $gp->ID );
        $posts = get_posts(array(
            'post_type' => 'mas_gift',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));
        if( $posts ) {
            foreach ( $posts as $post ) {


                $publicViewUrl = add_query_arg(
                    array(
                        'view-gift-registry' =>$post->ID ,
                        'view-type' => 'public',
                    ),
                    $mas_gr_link
                );
                $output[]=[
                    'id' => $post->ID,
                    'title' =>$post->post_title,
                     'url' =>$publicViewUrl,
                    'des' =>$post->post_content,
                    'created_at' =>$post->post_date,
                    'first_name' =>get_post_meta($post->ID,'masr_first_name',true),
                    'last_name' =>get_post_meta($post->ID,'masr_last_name',true),
                ];
            }
        }
        wp_reset_postdata();
        return $output;
    }

    static function searchGiftRegistry($keyword='') {
        $output = [];
        $q1 = get_posts(array(
            'fields' => 'post_title',
            'post_type' => 'mas_gift',
            's' => $keyword
        ));
        $q2 = get_posts(array(
            'fields' => 'post_content',
            'post_type' => 'mas_gift',
            's' => $keyword
        ));

        $q3 = get_posts(array(
            'fields' => 'ids',
            'post_type' => 'mas_gift',
            'meta_query' => array(
                array(
                    'key' => 'masr_last_name',
                    'value' => $keyword,
                    'compare' => 'LIKE'
                )
            )
        ));
        $q4 = get_posts(array(
            'fields' => 'ids',
            'post_type' => 'mas_gift',
            'meta_query' => array(
                array(
                    'key' => 'masr_first_name',
                    'value' => $keyword,
                    'compare' => 'LIKE'
                )
            )
        ));

        $unique = array_unique( array_merge( $q1, $q2 ,$q3,$q4) );

        $posts = get_posts(array(
            'post_type' => 'mas_gift',
            'post__in' => $unique,
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));
        if( $posts ) {
            foreach ( $posts as $post ) {

                $output[]=[
                    'id' => $post->ID,
                    'title' =>$post->post_title,
                    'des' =>$post->post_content,
                    'created_at' =>$post->post_date,
                    'first_name' =>get_post_meta($post->ID,'masr_first_name',true),
                    'last_name' =>get_post_meta($post->ID,'masr_last_name',true),
                ];
            }
        }
        wp_reset_postdata();
        return $output;
    }
}
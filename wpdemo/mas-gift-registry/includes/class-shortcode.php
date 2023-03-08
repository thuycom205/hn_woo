<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

class MAS_Shortcode {
static $template_path = WOOREG_ABSPATH . 'template/';
static $default_path = WOOREG_ABSPATH . 'template/';

    public static function init() {
        // Define shortcodes
        $shortcodes = array(
            'mas_my_registry'                    => __CLASS__ . '::show_account_registry_page',
            'mas_table_giftregistry_public_view'  => __CLASS__ . '::show_table_giftregistry_public_view',
        );

        foreach ( $shortcodes as $shortcode => $function ) {
            add_shortcode( apply_filters( "{$shortcode}", $shortcode ), $function );
        };
    }
    public static function show_table_giftregistry_public_view() {
        ob_start();
        wc_get_template( 'mas_table_giftregistry_public_view.php', [], self::$template_path, self::$template_path );
        return ob_get_clean();
    }

    public static function show_account_registry_page() {
        $giftId = 0;
        if (isset($_REQUEST['view-gift-registry']) && isset($_REQUEST['view-type']) && $_REQUEST['view-type'] =='public') {
            ob_start();
            $giftId = (int) $_REQUEST ['view-gift-registry'];
            $items = self::getItems($giftId);
            $cartLink = get_permalink(wc_get_page_id( 'cart' ));
            $info = WooReg()::$main->getRegistryInfo($giftId);
            wc_get_template( 'public_view.php', array('cartlink'=>$cartLink,'id' =>$giftId , 'items'=> $items , 'info' =>$info ), self::$template_path, self::$template_path  );
            return ob_get_clean();
        } else if (isset ( $_REQUEST ['view-gift-registry'] )) {
            ob_start();
            $giftId =  $_REQUEST ['view-gift-registry'];
            $args = array(
                'posts_per_page'   => 1,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'page',
                'name'      => 'giftregistry'
            );

            $page = get_posts( $args );
            if (!is_array($page));
            $gp = $page[0];
            $mas_gr_link = get_permalink( $gp->ID );

            $publicViewUrl = add_query_arg(
                array(
                    'view-gift-registry' =>$giftId,
                    'view-type' => 'public',
                ),
                $mas_gr_link
            );
            $items = self::getItems($giftId);
            $info = WooReg()::$main->getRegistryInfo($giftId);

            wc_get_template( 'my_gift_registry_detail.php', array( 'id' => $_REQUEST ['view-gift-registry'] , 'items'=> $items , 'info' =>$info , 'publicViewUrl'=>$publicViewUrl), self::$template_path, self::$template_path  );

            return ob_get_clean();
        } else {
            ob_start();
            wc_get_template( 'my_gift_registry.php', [], self::$template_path, self::$template_path );
            return ob_get_clean();
        }
    }

    public  static function getItems($registry_id)  {
        $return_arr = [];
        if ( is_user_logged_in() ) {
            wp_get_current_user();

            $args = [
                'post_type'      => ['masr_registry_item'],
                'posts_per_page' => 50,
                'meta_query'     => [
                    [
                        'key'      => 'registry_id',
                        'value'    => $registry_id,
                    ],
                ],
            ];
            $query = new WP_Query( $args );
            while ( $query->have_posts() ) {
                global $post;
                $query->the_post();
                $price = get_post_meta($post->ID, 'price' , true);
                $name = get_post_meta($post->ID, 'name' , true);
                $price_html = get_post_meta($post->ID, 'price_html' , true);

                $quantity = get_post_meta($post->ID, 'quantity' , true);

                $product_id =(int) get_post_meta($post->ID, 'product_id' , true);
                $variation_id = (int) get_post_meta($post->ID, 'variation_id' , true);
                $priority = get_post_meta($post->ID, 'priority' , true);
                $queryStr = get_post_meta($post->ID, 'atcquery' , true);

                $productObj = wc_get_product( $product_id );
                $image =  wp_get_attachment_url( $productObj->get_image_id());
                array_push( $return_arr,['ID'=>$post->ID ,'title' =>get_the_title(),
                    'description' =>$post->description,
                    'name' =>$name,
                    'price'=>$price,
                    'product_id'=>$product_id,
                    'variation_id'=>$variation_id,
                    'price_html' =>$price_html,
                    'quantity' => $quantity,
                    'priority' =>$priority,
                    'query' =>$queryStr,
                    'img'=>$image
                ] );
            }
            wp_reset_postdata();
        }
        return $return_arr;
    }

    /**
     * @return string
     */
    public static function show_gift_registry_page() {

        if ( ! isset ( $_REQUEST ['giftregistry_id'] ) ) {
            ob_start();
            wc_get_template( 'giftregistry-index.php', array( 'order'    => 'r',
                'order_id' => '2'
            ), self::$template_path, self::$template_path );

            return ob_get_clean();
        } else {
            ob_start();
            wc_get_template( 'public-view-giftregistry.php', array( 'id' => $_REQUEST ['giftregistry_id'] ), self::$template_path, self::$template_path  );

            return ob_get_clean();
        }
    }
}
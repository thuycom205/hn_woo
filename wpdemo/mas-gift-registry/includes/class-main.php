<?php
if (!class_exists('RegDb')):
    class RegDb
    {
        public function add_item_action()
        {
            $product_type = 'simple';
            $message = [];
            $is_update_qty = false;

            if (!is_user_logged_in()) {
                $message[] = __('You have to log in');
            }
            if (!isset($_REQUEST['data_giftregistry']['add-to-giftregistry'])) {
                $message[] = __('You have to specify registry id');

            }

            if (!isset($_REQUEST['data_giftregistry']['product_id'])) {
                $message[] = __('You have to specify product id');
            }
            if (!empty($message) && count($message) > 0) {
                $html = '';
                for ($i = 0; $i < count($message); $i++) {
                    $html = $html .' '.  $message[$i];
                }
                wc_add_notice($html);
                return;
            }

            if (isset($_REQUEST['data_giftregistry']['masr_variation_id'])) {
                $product_type = 'variation';
            }
            $registry_id = (int)$_REQUEST['data_giftregistry']['add-to-giftregistry'];
            $quantity = (int)$_REQUEST['data_giftregistry']['quantity'];
            $product_id = (int)$_REQUEST['data_giftregistry']['product_id'];
            if (isset($_REQUEST['data_giftregistry']['masr_variation_id'])) {
                $variation_id = (int)$_REQUEST['data_giftregistry']['masr_variation_id'];
            } else {
                $variation_id = $product_id;
            }
            if (isset($_REQUEST['data_giftregistry']['query'])) {
                $atc_query = $_REQUEST['data_giftregistry']['query'];
            } else {
                $atc_query = $_REQUEST['data_giftregistry']['query'];
            }

            switch ($product_type) {
                case "variation":
                    $args = [
                        'post_type' => ['masr_registry_item'],
                        'posts_per_page' => 4,
                        'meta_query' => [
                            [
                                'key' => 'registry_id',
                                'value' => $registry_id,
                            ],
                            [
                                'key' => 'variation_id',
                                'value' => $variation_id,
                            ],

                        ],
                    ];
                    $query = new WP_Query($args);
                    while ($query->have_posts()) {
                        $is_update_qty = true;
                        global $post;
                        $query->the_post();
                        update_post_meta($post->ID, 'quantity', $quantity);
                    }

                    //insert new one
                    if (!$is_update_qty) {
                        $postarr = array(
                            'post_content' => 'content',
                            'post_title' => 'gift registry',
                            'post_status' => 'publish',
                            'post_type' => 'masr_registry_item',
                            'comment_status' => 'closed',
                            'post_name' => 'gift registry item'
                        );
                        $itemId = wp_insert_post($postarr);
                        update_post_meta($itemId, 'registry_id', $registry_id);
                        update_post_meta($itemId, 'variation_id', $variation_id);
                        update_post_meta($itemId, 'priority', 1);
                        update_post_meta($itemId, 'quantity', $quantity);
                        /** @var WC_Product_Variation $variation */
                        $variation = wc_get_product($variation_id);

                        /** @var WC_Product $product */
                        $product = wc_get_product($variation->get_parent_id());
                        $product_id = $product->get_id();
                        $price = $variation->get_price();
                        $price_html = $variation->get_price_html();
                        $attributes = $variation->get_attributes();
                        $variationName = $variation->get_name();
                        // $att_sum = $variation->get_attribute_summary();
                        update_post_meta($itemId, 'name', $variationName);
                        update_post_meta($itemId, 'price', $price);
                        update_post_meta($itemId, 'price_html', $price_html);
                        update_post_meta($itemId, 'product_id', $product_id);
                        $addCartQuery = $_POST['query'];
                        update_post_meta($itemId, 'atcquery', $atc_query);
                    }
                    wp_reset_postdata();
                    break;
                default:
                    $args = [
                        'post_type' => ['masr_registry_item'],
                        'posts_per_page' => 4,
                        'meta_query' => [
                            [
                                'key' => 'registry_id',
                                'value' => $registry_id,
                            ],
                            [
                                'key' => 'product_id',
                                'value' => $product_id,
                            ],
                        ],
                    ];
                    $query = new WP_Query($args);
                    while ($query->have_posts()) {
                        $is_update_qty = true;
                        global $post;
                        $query->the_post();
                        update_post_meta($post->ID, 'quantity', $quantity);
                    }

                    //insert new one
                    if (!$is_update_qty) {
                        $postarr = array(
                            'post_content' => 'content',
                            'post_title' => 'gift registry',
                            'post_status' => 'publish',
                            'post_type' => 'masr_registry_item',
                            'comment_status' => 'closed',
                            'post_name' => 'gift registry item'
                        );
                        $itemId = wp_insert_post($postarr);
                        update_post_meta($itemId, 'registry_id', $registry_id);
                        update_post_meta($itemId, 'product_id', $product_id);
                        update_post_meta($itemId, 'priority', 1);
                        update_post_meta($itemId, 'quantity', $quantity);
                        /** @var WC_Product_Variation $variation */
                        $productObj = wc_get_product($product_id);


                        $price = $productObj->get_price();
                        $price_html = $productObj->get_price_html();
                        $attributes = $productObj->get_attributes();
                        $productName = $productObj->get_name();
                        // $att_sum = $variation->get_attribute_summary();
                        update_post_meta($itemId, 'name', $productName);
                        update_post_meta($itemId, 'price', $price);
                        update_post_meta($itemId, 'price_html', $price_html);
                        update_post_meta($itemId, 'atcquery', $atc_query);

                    }
                    wp_reset_postdata();
            }
        }

        public function getRegistryInfo($id)
        {
            $post =get_post($id);
            $info = [];

            $info['ID'] = $post->ID;
            $info['title'] = $post->post_title;
            $info['description'] = $post->post_content;
            $email= get_post_meta($post->ID, 'masr_email' , true);
            $info['email'] = $email;
            $firstName = get_post_meta($post->ID, 'masr_first_name' , true);
            $info['first_name'] = $firstName;
            $lastName= get_post_meta($post->ID, 'masr_last_name' , true);
            $info['last_name'] = $lastName;
            global $current_user;
            wp_get_current_user();
            $userId =  $current_user->ID;


        return $info;
        }
    }
endif;

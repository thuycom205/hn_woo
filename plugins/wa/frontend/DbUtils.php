<?php

namespace Mas\Whatsapp;

class DbUtils
{
    public function getAbandonedCartList(int $row_per_page = 20, int $offset = 0, string $order_by = "id")
    {
        global $wpdb;
        $quoteTbl = $wpdb->prefix . 'mas_quote';
        $query = "SELECT * FROM " . $quoteTbl . " WHERE is_abandoned=1  ORDER BY %s ASC limit %d offset %d;";
        $results = $wpdb->get_results($wpdb->prepare($query, array($order_by, $row_per_page, $offset)), ARRAY_A);
        return $results;
    }

    public function getTotalAbandonedCartRecord()
    {
        global $wpdb;
        $quoteTbl = $wpdb->prefix . 'mas_quote';
        $query = "SELECT count(*) FROM " . $quoteTbl."  WHERE is_abandoned=1";
        $results = $wpdb->get_row($query, ARRAY_N);
        return $results;
    }

    public function getAgentList()
    {
        $out = [];
        $is_chat_box_enable = get_option('maswa_chat_box_enable');
        $args = [
            'post_type'      => ['maswa_agent'],
            'posts_per_page' => 50,
            'post_status'    => 'publish',
        ];
        $postslist = get_posts($args);
        $wa_icon_url = MASWA_URL .'/assets/img/whatsapp_icon.png';


        if ($postslist) {
            foreach ($postslist as $post) {
                $avatar = get_post_meta($post->ID, 'agent_ava', true);
                $avatarUrl = MASWA_URL .'/assets/img/';
                switch ($avatar) {
                    case '1':
                        $avatarUrl = $avatarUrl.'Male-1.png';
                        break;
                    case '2' :
                        $avatarUrl = $avatarUrl.'Male-2.png';
                        break;
                    case '3' :
                        $avatarUrl = $avatarUrl .'Female-1.png';
                        break;
                    case '4' :
                        $avatarUrl = $avatarUrl .'Female-2.png';     
                        break;
                }

                $out[] = [
                    'id' => $post->ID,
                    'country_code' => get_post_meta($post->ID, 'country_code', true),
                    'phone_number' => get_post_meta($post->ID, 'phone_number', true),
                    'agent_name' => get_post_meta($post->ID, 'agent_name', true),
                    'agent_role' => get_post_meta($post->ID, 'agent_role', true),
                    'avatar' => $avatarUrl ,
                    'wa_icon_url' =>$wa_icon_url
                ];
            }
        }
        return $out;
    }

    public function savePhoneNo()
    {
        $updatePhone = $_REQUEST['phoneno'];
        if (is_user_logged_in()) {
            $userId = get_current_user_id();
            $phone  = get_user_meta($userId, 'billing_phone', true);
            if ($phone !=   $updatePhone) {
                update_user_meta($userId, 'billing_phone', $updatePhone);
            }
        }
    }
}

<?php

namespace Mas\Whatsapp;

class AbandonedCart
{
    public function run() {
        global $wpdb;
        $quoteTbl = $wpdb->prefix . 'mas_quote';

        $query = "SELECT * FROM ".$quoteTbl." 
                  WHERE `abandoned_cart_time` <  %s 
                  AND is_abandoned = %d 
                  AND is_recovered = %d
                  AND is_converted = %d
                  ";
        $currentTime = new \DateTime();
        $format = 'Y-m-d H:i:s';
        $cutOffTime = get_option('maswa_abandoned_cart_period');
        $cutOffTimeInt =30;
        if ($cutOffTime!= null && $cutOffTime !='' ) {
            $refineCutOffTime = trim($cutOffTime);
            try {
                $cutOffTimeInt = (int)$refineCutOffTime;
            } catch (\Exception $ex) {
                $cutOffTimeInt =30;
            }
        }
        $cutOffTime=strval($cutOffTimeInt);
        $modify = '-' . '1' . ' minutes';
        $timeModifyAbandoned = $currentTime->modify($modify);
        $current_time = $timeModifyAbandoned->format($format);

        $rows = $wpdb->get_results( //phpcs:ignore
            $wpdb->prepare(
                $query,
                $current_time,
                0,
                0,
                0
            ), ARRAY_A
        );

         if ($rows && !empty ($rows)) {
             foreach ($rows as $row) {
                 $wpdb->update($quoteTbl, array(
                     'is_abandoned' => 1
                 ), array(
                     'id' => $row ['id']
                 ));

                 //generate whatsapp message
                 if (!$this->hasMessage($row)) {
                     $this->generateMessage($row);
                 }
             }
         }
    }

    /**
     * whether plugin generated message for the item yet
     * @param $id
     * @return void
     */
    public function hasMessage($quote) {
        $query = new \WP_Query(array(
            'post_type' => 'maswa_mess',
            'posts_per_page' => -1,
            'offset' => 0,
            'meta_query' => array(
                array(
                    'key'     => 'cart_content',
                    'value'   => $quote['cart_content'],
                    'compare' => '=',
                ),
                array(
                    'key'     => 'customer_id',
                    'value'   => $quote['user_id'],
                    'compare' => '=',
                ),
            )
        ));
        if ( $query->have_posts() ) {
            return true;
        }
        return false;
    }

    public function generateMessage($abandonedRecord) {

        $template1 = get_option('maswa_template_1');
        $template2 = get_option('maswa_template_2');
        $user_meta = get_metadata('user', $abandonedRecord ['user_id']);

        if (isset($user_meta ['first_name'] ) && isset($user_meta ['first_name'] [0] ) && $user_meta ['first_name'] [0]  !=='') {
            $recipient_name = $user_meta ['first_name'] [0] . ' ' . $user_meta ['last_name'] [0];
        } else {
            $recipient_name = $abandonedRecord['user_email'];
        }
        $content1 = $this->refineContent($template1,$abandonedRecord,$recipient_name);
        $content2 = $this->refineContent($template2,$abandonedRecord,$recipient_name);

        $postTitle = __('abandoned cart', 'maswa');
        $total = $abandonedRecord['total'];
        $postTitle = $postTitle .' '. ':'. ' '. $total;

        $my_post = array(
            'post_title'    => $postTitle,
            'post_content'  => $postTitle,
            'post_status'   => 'publish',
            'post_type' => 'maswa_mess',
            'comment_status' => 'closed',
        );
        $post_id = wp_insert_post($my_post);

        if (isset($abandonedRecord ['user_id'])) {
            $customer_id = $abandonedRecord ['user_id'];
            update_post_meta($post_id, 'customer_id',$customer_id);
            update_post_meta($post_id, 'cart_content',$abandonedRecord['cart_content']);
            update_post_meta($post_id, 'whatsapp_message',$content1);
            update_post_meta($post_id, 'whatsapp_message_2',$content2);
        }
        //update_post_meta($post_id, 'user_id',$user_id);
    }
    public function refineContent($content, $abandonedRecord,$customer_name){
        //$resume_link =get_permalink(get_option ( 'follow_up_emailtrack_page_id' )) ;
        $resume_link = get_site_url();
        $resume_link .= '?ats=' . $abandonedRecord['uniq'];
        $resume_text = "<a href='{$resume_link}'>" . __('Click here to restore cart', 'maswa') . "</a>";
        $replaces = array(
            '{{customer_name}}' => $customer_name,
            '{{store_url}}' => get_permalink(wc_get_page_id('shop')),
            '{{store_name}}' => get_bloginfo('name'),
            '{{restore_cart_link}}' => $resume_text,
        );
        $content = strtr($content, $replaces);
        // insert coupon and expiry date of coupon in email
        //$content = $this->preCoupon($content, $rule);
        return $content;
    }

}
<?php
/*
Plugin Name: WooCommerce Trello Integration
Plugin URI: https://thexseed.com
Description: Allows you to create card in trello board after a woocommerce order is placed
Version: 1.0.0
Author: Thexseed
Author URI: https://thexseed.com
Copyright 2018-2022 thexseed.com. All rights reserved.
Requires PHP: 7.0
Requires at least: 5.0
Tested up to: 5.9
WC requires at least: 4.0
WC tested up to: 6.3
*/

if (!defined('ABSPATH')) {
    exit;
}
define('WOO_TRELLO_VERSION', '1.0.0');
/**
 * Detect plugin. For use on Front End only.
 */

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('woocommerce/woocommerce.php')) {
    $init_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "mas-trello" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "define.php";
    require_once $init_file;
}

/**
 * Class WOO_LOOKBOOK
 */
class WOO_TRELLO
{
    public function __construct()
    {

        register_activation_hook(__FILE__, array($this, 'install'));
        register_deactivation_hook(__FILE__, array($this, 'uninstall'));
        add_action('admin_notices', array($this, 'global_note'));
        add_action('init', array($this, 'init'));
        add_action('init', array($this, 'xyz1234_my_custom_add_user'));
        /*Show Instagram on quickview*/
        add_action('wp_ajax_nopriv_trello_sync_card', array($this, 'trello_sync_card'));
        add_action('wp_ajax_trello_sync_card', array($this, 'trello_sync_card'));
        add_action('wp_ajax_trello_fetch_card', array($this, 'trello_fetch_card'));
        add_action('wp_ajax_trello_fetch_list', array($this, 'trello_fetch_list'));
        remove_action( 'login_init', 'send_frame_options_header' );
        remove_action( 'admin_init', 'send_frame_options_header' );
    }

    public function trello_fetch_card()
    {
        $token = $_REQUEST['data_token'];
        $utils = new WOO_TRELLO_Utils();
        $result = $utils->getting_all_trello_boards($token);
        echo wp_json_encode($result);
        wp_die();
    }

    public function trello_fetch_list()
    {
        $token = $_REQUEST['data_token'];
        $board_id = $_REQUEST['board_id'];
        $utils = new WOO_TRELLO_Utils();
        $result = $utils->bptc_gatting_spacific_board_lists($token, $board_id);
        echo wp_json_encode($result);
        wp_die();
    }

    public function trello_sync_card()
    {

        $cardName = '';
        $cardDes = '';
        $output = [];
        $output['id'] ;
        $logger = wc_get_logger();
        $context = array( 'source' => 'trello' );
        //$logger->log( 'debug', print_r(['thuy'=>'sync_card']), $context );
       // $action = $_REQUEST['action'];
        $logger->log( 'info', print_r($_REQUEST,1), $context );

        //this is key of the trello app. Not the key of the customer
        $key = 'fc37781b415ba6e22400ce1be85d4a1d';
        $shopDomain = $_REQUEST['shopDomain'];
       // $orderTotal = $_REQUEST['orderTotal'];
        $billingAddress = $_REQUEST['billingAddress'];
        $shippingAddress = $_REQUEST['shippingAddress'];
        $customerName = $_REQUEST['customerName'];
        $paymentMethod = $_REQUEST['paymentMethod'];
        $orderTotal = $_REQUEST['orderTotal'];

        if ($shopDomain) {
            $mysPos = strpos($shopDomain, 'myshopify.com');
            if ($mysPos) {
                $user = substr($shopDomain, 0, $mysPos - 1);
            }
            $user =  $user . '_trello';
            //
            $param = 'woo_trello_params_' . $user;
            $paramsConfig = get_option($param, array());

            $token = $paramsConfig['key'];
            $list = $paramsConfig['trello_list'];
            $color_label = $paramsConfig['color_label'];

            $cardName = $_REQUEST['orderNumber'];
            if (isset($paramsConfig['add_date_to_card_title']) && $paramsConfig['add_date_to_card_title'] ==1)  $cardName .='  Date: ' . date( "Y/m/d" ) ;
            if (isset($paramsConfig['sync_customer_name']) && $paramsConfig['sync_customer_name'] ==1)  $cardDes .= '  Customer name: ' .$customerName . PHP_EOL;
            if (isset($paramsConfig['sync_billing_address']) && $paramsConfig['sync_billing_address'] ==1)  $cardDes .= PHP_EOL. '  Billing address '. PHP_EOL .$billingAddress. PHP_EOL; ;
            if (isset($paramsConfig['sync_shipping_address']) && $paramsConfig['sync_shipping_address'] ==1)  $cardDes .= PHP_EOL.'  Shipping address ' .PHP_EOL.$shippingAddress. PHP_EOL; ;
            if (isset($paramsConfig['sync_payment_method']) && $paramsConfig['sync_payment_method'] ==1)  $cardDes .=PHP_EOL. ' Payment method '.PHP_EOL .$paymentMethod. PHP_EOL; ;
            if (isset($paramsConfig['sync_customer_name']) && $paramsConfig['sync_order_total'] ==1)  $cardDes .= PHP_EOL.' Order total ' .PHP_EOL. $orderTotal . PHP_EOL;;

            $card_url = 'https://api.trello.com/1/cards?name=' . urlencode($cardName) . '&desc=' . urlencode($cardDes) . '&pos=top&idList=' . $list . '&keepFromSource=all&key=' . $key . '&token=' . $token . '';

            $trello_response = wp_remote_post($card_url, array());
            if (!is_wp_error($trello_response) and isset($trello_response['response']['code'], $trello_response['body']) and $trello_response['response']['code'] == 200) {
                # Request is successful
                # Getting the New Created Card Id ;
                $trello_response_body = json_decode( $trello_response['body'], TRUE );
                # check and balance

                $logger->log( 'debug', 'thanhcong', $context );
                $output['id'] =  $trello_response_body['id'];
                $output['url'] =  $trello_response_body['url'];
               // $logger->log( 'debug', print_r($trello_response_body,1), $context );
                if ( isset( $trello_response_body['id'] ) and $trello_response_body['id'] ) {

                    ///
                    # Set Label Colour
                    if ( isset($paramsConfig['color_label']) && $paramsConfig['color_label'] != '' ) {
                        $trello_checklist_response=  wp_remote_post('https://api.trello.com/1/cards/'.$trello_response_body['id'].'/labels?color='.$paramsConfig['color_label'].'&key='.$key .'&token='.$token.'',array());
                        $logger->log( 'info', print_r($trello_checklist_response,1), $context );

                    }
                    ///
                    # URL builder
                    $output['id'] =  $trello_response_body['id'];
                    $output['url'] =  $trello_response_body['url'];
                    $check_list_url = 'https://api.trello.com/1/cards/' . $trello_response_body['id'] . '/checklists?name=Order Items&pos=top&key=' . $key . '&token=' . $token . '';
                    # Remote request for trello check list
                    $trello_checklist_response = wp_remote_post($check_list_url, array());
                    $logger->log( 'info', print_r($trello_checklist_response,1), $context );

                }
            }  else {
                # New Code Starts
               // $this->wootrello_write_status_on_order_meta( $order_info['orderID'], "wootrello_error" );
                # New Code ends
               // $this->wootrello_log( 'wootrello_create_trello_card', 716, 'ERROR: ' . json_encode( $trello_response ) );
                # return true
                $out = array( 'FALSE', "Trello wootrello_error!" );
                //$logger->log( 'debug', 'thatbai', $context );

               $logger->log( 'info', print_r($trello_response,1), $context );
            }

        }
        echo wp_json_encode($output);
        wp_die();
    }

    public function init()
    {
        add_image_size('trello', 400, 400, false);
    }

    public function xyz1234_my_custom_add_user()
    {
        global $lookbookuserid;
        global $wpdb;

        if (isset($_REQUEST['trello_shop_name'])) {
            $shop_name = $_REQUEST['trello_shop_name'];
            $email = $shop_name;
            $password = 'pasword123';
            $mysPos = strpos($shop_name, 'myshopify.com');
            if ($mysPos) {
                $user = substr($shop_name, 0, $mysPos - 1);
                $email = $user . '_trello@thexseedmab.com';
            }
            $username = $user . '_trello';

            //because this is 2nd app so
            //  $email = 'drew@example.com';

            // if (username_exists($username) == null && email_exists($email) == false) {
            if (username_exists($username) == null) {

                // Create the new user
                $user_id = wp_create_user($username, $password, $email);
                if (is_int($user_id)) {
                    $query = "UPDATE wp_users SET display_name =" . "'" . $shop_name . "'" . " WHERE user_id=" . $user_id;
                    $wpdb->query($query);
                    // Get current user object
                    $user = get_user_by('id', $user_id);

                    // Remove role
                    $user->remove_role('subscriber');

                    // Add role
                    $user->add_role('author_trello');
                    $this->login($username);
                    $current_user = wp_get_current_user();
                    $lookbookuserid = $current_user->ID;
                } else {
                    echo "Please contact admin";
                    var_dump($user_id);
                }

            } else {
                $this->login($username);
                $current_user = wp_get_current_user();
                $lookbookuserid = $current_user->ID;
            }
        } else {
            $x = 2;
            // login($username);
        }

    }

    public function login($username)
    {
        // Automatic login //
        $user = get_user_by('login', $username);

        // Redirect URL //
        if (!is_wp_error($user)) {
            wp_clear_auth_cookie();
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);

            $redirect_to = user_admin_url();
            $redirect_to = 'https://' . $_SERVER['HTTP_HOST'] . '/blog/wp-admin/edit.php?post_type=woocommerce-trello&page=trello-integration-settings#/update';

            wp_safe_redirect($redirect_to);
            exit();
        }
    }

    /**
     * Notify if WooCommerce is not activated
     */
    function global_note()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            ?>
            <div id="message" class="error">
                <p><?php _e('Please install and active WooCommerce. WooCommerce Multi Currency is going to working.', 'woocommerce-lookbook'); ?></p>
            </div>
            <?php
        }

    }

    /**
     * When active plugin Function will be call
     */
    public function install()
    {
        global $wp_version;
        if (version_compare($wp_version, "4.4", "<")) {
            deactivate_plugins(basename(__FILE__)); // Deactivate our plugin
            wp_die("This plugin requires WordPress version 2.9 or higher.");
        }

        $data_init = 'eyJleHRlcm5hbF9wcm9kdWN0IjoiMSIsImljb24iOiIxIiwiaWNvbl9jb2xvciI6IiMyMTIxMjEiLCJpY29uX2JhY2tncm91bmRfY29sb3IiOiIjZThjZTQwIiwiaWNvbl9ib3JkZXJfY29sb3IiOiIjZjdlYmFiIiwidGl0bGVfY29sb3IiOiIjMjEyMTIxIiwidGl0bGVfYmFja2dyb3VuZF9jb2xvciI6IiNlZWVlZWUiLCJsb2FkaW5nX2ljb24iOiIyIiwidGV4dF9jb2xvciI6IiMyMTIxMjEiLCJiYWNrZ3JvdW5kX2NvbG9yIjoiI2ZmZmZmZiIsImJvcmRlcl9yYWRpdXMiOiIyMCIsInNsaWRlX3dpZHRoIjoiMTE3MCIsInNsaWRlX2hlaWdodCI6IjYwMCIsInNsaWRlX2VmZmVjdCI6IjEiLCJzbGlkZV9uYXZpZ2F0aW9uIjoiMSIsInNsaWRlX3RpbWUiOiI1MDAwIiwiY3VzdG9tX2NzcyI6IiIsImtleSI6IiJ9';
        if (!get_option('woo_lookbook_params', '')) {
            update_option('woo_lookbook_params', json_decode(base64_decode($data_init), true));
        }
    }

    /**
     * When deactive function will be call
     */
    public function uninstall()
    {

    }
}

new WOO_TRELLO();
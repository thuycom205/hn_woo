<?php
/**
 * Plugin Name: 	Woocommerce multiple gift registries
 * Plugin URI: 		https://thexseed.com
 * Description: 	This allows your customers to share upcoming events with their friends and family, so they can buy gifts for them.
 * Version: 		4.0
 * Author: 			thexseed company
 * Author URI: 		https://thexseed.com
 * License: 		GPL-2.0+
 *
 * @package Woocommerce multiple gift registries
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if (!defined('WOOREG_PLUGIN_FILE')) {
    define('WOOREG_PLUGIN_FILE', __FILE__);
}
if (!defined('WOOREG_URL')) {
    $plugin_url = plugins_url( '', __FILE__ );
    define('WOOREG_URL', $plugin_url);
}

function isExistsWoocommerceWooReg()
{
    ob_start();
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        add_action('admin_notices', 'woocommerceMissingNoticeReg');
        return true;
    }
}
function woocommerceMissingNoticeReg()
{
    echo '<div class="error"><p>' . sprintf(__('Woocommerce multiple gift registries depends on the last version of %s or later to work!', 'masgr'), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . __('WooCommerce 6.7.0', 'woocommerce-colors') . '</a>') . '</p></div>';
}

add_action('admin_init', 'isExistsWoocommerceWooReg');

// Include the main  class.
if (!class_exists('WooReg')) {
    include_once dirname(__FILE__).'/includes/class-wooreg.php';
}

/**
 * Main instance of Woocommerce multiple gift registries
 *
 * Returns the main instance of WooReg to prevent the need to use globals.
 *
 * @since  1.0
 * @return WooReg
 */
function WooReg()
{
    return WooReg::instance();
}
// Global for backwards compatibility.
$GLOBALS['WOOREG'] = WooReg();
add_filter( 'cron_schedules', 'mgiftregistry_add_every_five_minutes' );
function mgiftregistry_add_every_five_minutes( $schedules ) {
    $schedules['every_five_minutes'] = array(
        'interval'  => 60 * 5,
        'display'   => __( 'Every 5 Minutes', 'xgiftcard' )
    );
    return $schedules;
}
// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'mgiftregistry_add_every_five_minutes' ) ) {
    wp_schedule_event( time(), 'every_five_minutes', 'mgiftregistry_add_every_five_minutes' );
}

// Hook into that action that'll fire every five minutes
add_action( 'mgiftregistry_add_every_five_minutes', 'mgiftregistrySendEmail' );
function set_html_content_type() {
    return 'text/html';
}
function mgiftregistrySendEmail()
{
    error_log(print_r('Hello World!', true));
    $args = array(
        'post_type' => 'shop_order',
        'meta_query' => array(
            array(
                'key' => '_xgiftregistry_sent_mail',
                'value' => 'not_sent',
            )
        )
    );

    $posts = get_posts($args);
    if ($posts) {
        foreach ($posts as $order) {
            $_mgiftregistry_id = get_post_meta($order->ID,'_mgiftregistry_id',true);
            $g_id = intval($_mgiftregistry_id);
            $masr_email = get_post_meta($g_id,'masr_email',true);
            $masr_last_name = get_post_meta($g_id,'masr_last_name',true);
            //from email ,to email, header, content
            $subject = get_option('masr_email_subject') ;
            $body = get_option('marsregistry_email_content') ;
            $headers = array();
            $headers [] = "Content-Type: text/html";
            $headers [] = 'From: ' . get_option('woocommerce_email_from_name') . ' <' . get_option('woocommerce_email_from_address') . '>';
            $to = $masr_last_name . '<' . $masr_email . '>';
            add_filter('wp_mail_content_type',  'set_html_content_type');
            return wp_mail($to, $subject, $body, $headers);
        }
    }
}

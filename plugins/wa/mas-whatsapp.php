<?php
/**
 * Plugin Name: 	A Mas Whatsapp
 * Plugin URI: 		https://thexseed.com/
 * Description: 	Recover abandoned cart via whatsapp and multiple agents chatbox via Whatsapp
 * Version: 		4.0
 * Author: 			Mobile app seed.
 * Author URI: 		https://thexseed.com/
 * License: 		GPL-2.0+
 *
 * @package Woo Whatsapp
 */
use Mas\Whatsapp\Whatsapp;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if (!defined('MASWA_PLUGIN_FILE')) {
    define('MASWA_PLUGIN_FILE', __FILE__);
}if (!defined('MASWA_URL')) {
    $plugin_url = plugins_url( '', __FILE__ );
    define('MASWA_URL', $plugin_url);
}
if ( ! function_exists( 'isExistsWoocommercebyMas' ) ) {
    function isExistsWoocommercebyMas()
    {
        ob_start();
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            add_action('admin_notices', 'isExistsWoocommercebyMas');
            // deactivate_plugins(dirname(__FILE__) . '/giftwrapper.php');
            return true;
        }
    }
}
if ( ! function_exists( 'isExistsWoocommercebyMas' ) ) {

    function woocommerceMissingNoticeReg()
    {
        echo '<div class="error"><p>' . sprintf(__('Wordpress WooCommerce Salesforce Connector depends on the last version of %s or later to work!', 'Wordpress WooCommerce Salesforce Connector'), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . __('WooCommerce 2.3', 'woocommerce-colors') . '</a>') . '</p></div>';
    }
}
//add_action('admin_init', 'isExistsWoocommercebyMas');

// Include the main MasWhatsApp class.
include_once dirname(__FILE__).'/includes/Whatsapp.php';

/**
 * Main instance .
 *
 * Returns the main instance of Whatsapp to prevent the need to use globals.
 *
 * @since  1.0
 * @return Whatsapp
 */
function MasWhatsApp()
{
    return Whatsapp::instance();
}
$GLOBALS['MASWA'] = MasWhatsApp();



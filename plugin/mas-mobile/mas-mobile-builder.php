<?php
/**
 * Plugin Name: 	A Mas mobile app builder
 * Plugin URI: 		https://mobileappseed.com/
 * Description: 	Connector that lets your Salesforce connect to WooCommerce store via REST API. (With Field Mapping)
 * Version: 		4.0
 * Author: 			Mobile app seed.
 * Author URI: 		https://mobileappseed.com/
 * License: 		GPL-2.0+
 *
 * @package Woo Gift Wrapper
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if (!defined('MASMB_PLUGIN_FILE')) {
    define('MASMB_PLUGIN_FILE', __FILE__);
}
if (!defined('MASMB_URL')) {
    $plugin_url = plugins_url( '', __FILE__ );
    define('MASMB_URL', $plugin_url);
}
if (!defined('MMB_ABPATH')) {
    $plugin_path = dirname( MASMB_PLUGIN_FILE). '/';
    define('MASMB_ABPATH', $plugin_path);
}
if (!defined('MMB_ABPATH')) {
    define('MASMB_VERSION', '1.0.0');
}
if (!class_exists('MasMobileBuilder')) {
    include_once dirname(__FILE__).'/includes/mas-mobile-builder.php';
}

/**
 *
 * Returns the main instance of MasGiftWrapper to prevent the need to use globals.
 *
 * @since  1.0
 * @return MasMobileBuilder
 */
function MasMobileBuilder()
{
    return MasMobileBuilder::instance();
}
$GLOBALS['MasMobileBuilder'] = MasMobileBuilder();


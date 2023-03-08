<?php
/**
 * Installation related functions and actions.
 *
 * @version 2.0
 */

defined('ABSPATH') || exit;
class WooRegInstall
{
    private static $instances = [];

    /**
     * Hook in tabs.
     */
    public static function init()
    {
        // require_once ABSPATH . 'wp-includes/pluggable.php';
        self::install();
    }
    public static function getInstance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Install .
     */
    public static function install()
    {
        // Check if we are not already running this routine.
        if ('yes' === get_transient('wooreg_installing')) {
            return;
        }

        // If we made it till here nothing is running yet, lets set the transient now.
        set_transient('wooreg_installing', 'yes', MINUTE_IN_SECONDS * 10);
        self::createTables();
        delete_transient('wooreg_installing');
        do_action('wooreg_flush_rewrite_rules');
        do_action('wooreg_installed');
    }


    private static function createTables()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;

        $wpdb->hide_errors();

        self::create_pages();
    }

    /**
     * create gift registry pages for plugin
     */
    static function create_pages() {
        if ( ! function_exists( 'wc_create_page' ) ) {
            include_once ABSPATH. 'wp-content/plugins/woocommerce/includes/admin/wc-admin-functions.php';
        }
        $pages = array(
            'giftregistry' => array(
                'name'    => _x( 'giftregistry', 'Page slug', 'masr' ),
                'title'   => _x( 'My Gift Registry', 'Page title', 'masr' ),
                'content' => '[mas_my_registry]
                              '
            )  ,
            'mas-gift-registry' => array(
                'name'    => _x( 'public_registry', 'Page slug', 'masr' ),
                'title'   => _x( 'Gift Registry', 'Page title', 'masr' ),
                'content' => '[mas_table_giftregistry_public_view]'
            )
        );
        foreach ( $pages as $key => $page ) {
            wc_create_page( esc_sql( $page ['name'] ), 'gift_registry' . $key . '_page_id', $page ['title'], $page ['content'], ! empty ( $page ['parent'] ) ? wc_get_page_id( $page ['parent'] ) : '' );
        }
    }
}

WooRegInstall::init();
<?php

namespace Mas\Whatsapp;

class Install
{
    public function install() {
        $this->create_custom_post_type();
        $this->createTables();
    }
    protected function create_custom_post_type()
    {
        $this->create_custom_post_type_agent();
        $this->create_custom_post_type_mess();
    }

    public function create_custom_post_type_agent() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        if ( post_type_exists( 'maswa_agent' ) ) {
            return;
        }
        $args = array(
            'labels'              => array(
                'name'               => esc_html__( 'Whatsapp Agent', 'woo-lucky-wheel' ),
                'singular_name'      => esc_html__( 'Whatsapp Agent', 'woo-lucky-wheel' ),
                'menu_name'          => esc_html_x( 'Whatsapp Agents', 'Admin menu', 'woo-lucky-wheel' ),
                'name_admin_bar'     => esc_html_x( 'Whatsapp Agents', 'Add new on Admin bar', 'woo-lucky-wheel' ),
                'view_item'          => esc_html__( 'View Whatsapp Agent', 'woo-lucky-wheel' ),
                'all_items'          => esc_html__( 'Whatsapp Agent', 'woo-lucky-wheel' ),
                'search_items'       => esc_html__( 'Search agent', 'woo-lucky-wheel' ),
                'parent_item_colon'  => esc_html__( 'Parent agent:', 'woo-lucky-wheel' ),
                'not_found'          => esc_html__( 'No agent found.', 'woo-lucky-wheel' ),
                'not_found_in_trash' => esc_html__( 'No agent found in Trash.', 'woo-lucky-wheel' )
            ),
            'description'         => esc_html__( 'Whatsapp Agent.', 'woo-lucky-wheel' ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => array( 'create_posts' => 'publish_posts' ),
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_menu'        => false,
            'hierarchical'        => false,
            'rewrite'             => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
        );
        register_post_type( 'maswa_agent', $args );
    }
    public function create_custom_post_type_mess() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        if ( post_type_exists( 'maswa_mess' ) ) {
            return;
        }
        $args = array(
            'labels'              => array(
                'name'               => esc_html__( 'Whatsapp Message', 'woo-lucky-wheel' ),
                'singular_name'      => esc_html__( 'Whatsapp Message', 'woo-lucky-wheel' ),
                'menu_name'          => esc_html_x( 'Whatsapp Messages', 'Admin menu', 'woo-lucky-wheel' ),
                'name_admin_bar'     => esc_html_x( 'Whatsapp Messages', 'Add new on Admin bar', 'woo-lucky-wheel' ),
                'view_item'          => esc_html__( 'View Whatsapp Message', 'woo-lucky-wheel' ),
                'all_items'          => esc_html__( 'Whatsapp Message', 'woo-lucky-wheel' ),
                'search_items'       => esc_html__( 'Search message', 'woo-lucky-wheel' ),
                'parent_item_colon'  => esc_html__( 'Parent message:', 'woo-lucky-wheel' ),
                'not_found'          => esc_html__( 'No message found.', 'woo-lucky-wheel' ),
                'not_found_in_trash' => esc_html__( 'No message found in Trash.', 'woo-lucky-wheel' )
            ),
            'description'         => esc_html__( 'Whatsapp Message.', 'woo-lucky-wheel' ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => array( 'create_posts' => 'publish_posts' ),
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_menu'        => false,
            'hierarchical'        => false,
            'rewrite'             => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
        );
        register_post_type( 'maswa_mess', $args );
    }

    protected function createTables(){
        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }
        global $wpdb;

        $wpdb->hide_errors();
        dbDelta(self::createQuoteTable());
    }
    protected function createQuoteTable() {
        global $wpdb;

        $collate = '';

        if ($wpdb->has_cap('collation')) {
            $collate = $wpdb->get_charset_collate();
        }
        $prefix = $wpdb->prefix;

        $tables = "
        CREATE TABLE IF NOT EXISTS `{$prefix}mas_quote` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `user_id` int(11) NOT NULL,
          `user_email` varchar(255) NULL,
          `user_name` VARCHAR(255)  NULL,
          `is_registered` int(11) NOT NULL,
          `cart_content` text NOT NULL,
          `total` varchar(255) NOT NULL,
          `shipping_method` varchar(255) NOT NULL,
          `payment_method` varchar(255) NOT NULL,
          `cart_id` int(11) NOT NULL,
          `abandoned_cart_time` datetime NOT NULL,
          `is_abandoned` tinyint NULL DEFAULT 0,
          `is_recovered` tinyint  NULL DEFAULT 0,
          `is_converted` tinyint  NULL DEFAULT 0,
          `is_sent` tinyint  NULL DEFAULT 0,
          `uniq` varchar(255) NULL,
			PRIMARY KEY (`id`)
			)$collate;
        ";

        return $tables;
    }

}
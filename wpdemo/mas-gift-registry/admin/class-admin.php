<?php
/**
 * @class   WooRegAdmin
 *
 * @version 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * WooRegAdminclass.
 */
class WooRegAdmin
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('init', array($this, 'includes'));
        add_action('admin_init', array($this, 'buffer'), 1);
    }

    /**
     * Output buffering allows admin screens to make redirects later on.
     */
    public function buffer()
    {
        ob_start();
    }

    /**
     * Include any classes we need within admin.
     */
    public function includes()
    {
        include_once dirname(__FILE__) . '/class-reg-admin-menus.php';
    }
}

return new WooRegAdmin();

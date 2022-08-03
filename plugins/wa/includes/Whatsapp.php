<?php

namespace Mas\Whatsapp;

use Mas\Whatsapp\PopUp;

class Whatsapp
{
    public $version = '1.0.0';

    protected static $_instance = null;
    static $install;
    static $admin;
    static $cart;
    static $cron;
    static $checkout;
    static $wcSetting;
    static $popup;
    /**
     * @var \Mas\Whatsapp\DbUtils;
     */
    static $dbUtil;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->defineConstants();
        $this->includes();
        $this->initHooks();
        do_action('masgw_loaded');
    }

    /**
     * Define Constants.
     */
    private function defineConstants()
    {
        $upload_dir = wp_upload_dir(null, false);
        $this->define('MASWA_ABSPATH', dirname(MASWA_PLUGIN_FILE) . '/');

        $this->define('MASWA_PLUGIN_BASENAME', plugin_basename(MASWA_PLUGIN_FILE));
        $this->define('MASWA_VERSION', $this->version);
        $this->define('MASWA_LOG_DIR', $upload_dir['basedir'] . '/masgw-logs/');
    }

    /**
     * Define constant if not already set.
     *
     * @param string $name Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {

        include_once MASWA_ABSPATH . 'frontend/Install.php';
        include_once MASWA_ABSPATH . 'admin/Admin.php';
        include_once MASWA_ABSPATH . 'admin/view/MetaBox.php';
        include_once MASWA_ABSPATH . 'admin/view/AbandonedCartTable.php';
        include_once MASWA_ABSPATH . 'admin/view/WhatsappMessage.php';
        include_once MASWA_ABSPATH . 'frontend/DbUtils.php';
        include_once MASWA_ABSPATH . 'includes/Cart.php';
        include_once MASWA_ABSPATH . 'includes/Cron.php';
        include_once MASWA_ABSPATH . 'includes/AbandonedCart.php';
        include_once MASWA_ABSPATH . 'includes/Checkout.php';
        include_once MASWA_ABSPATH . 'frontend/view/Popup.php';
        self::$admin = new \Mas\Whatsapp\Admin();
        self::$install = new \Mas\Whatsapp\Install();
        self::$cart = new \Mas\Whatsapp\Cart();
        self::$cron = new \Mas\Whatsapp\Cron();
        self::$checkout = new \Mas\Whatsapp\Checkout();
        self::$dbUtil = new \Mas\Whatsapp\DbUtils();
        self::$popup = new Popup();
    }

    private function initHooks()
    {
        add_action('init', array(self::$install, 'install'));
        add_action('init', array($this, 'add_scheduled_action'));
        add_action('maswa_cron_run', [self::$cron, 'run']);
        add_action('wp_enqueue_scripts', array($this, 'frontend_enqueue'));

        add_filter('woocommerce_get_settings_pages', array($this, 'add_settings_page'), 10, 1);

        add_action('add_meta_boxes', [self::$admin, 'add']);
        add_action('save_post', [self::$admin, 'save']);

        // Enqueue backend scripts
        add_action('admin_enqueue_scripts', array(self::$admin, 'admin_enqueue_scripts'), 99);
        add_action('admin_print_scripts', array(self::$admin, 'admin_print_scripts'));
        //admin menu
        add_action('admin_menu', array(self::$admin, 'admin_menu'));
        add_action('wp_ajax_maswa_ajax_get_abandoned_cart', array($this, 'maswa_ajax_get_abandoned_cart'));
        add_action('wp_ajax_maswa_ajax_get_agents', array($this, 'maswa_ajax_get_agent'));
        add_action('wp_ajax_nopriv_maswa_ajax_get_agents', array($this, 'maswa_ajax_get_agent'));

        add_action('wp_ajax_maswa_update_mess_status', array(self::$admin, 'maswa_update_mess_status'));
        add_action('wp_ajax_maswa_update_mess_status_two', array(self::$admin, 'maswa_update_mess_status_two'));
        add_action('wp_ajax_nopriv_maswa_ajax_save_customer_phoneno', [$this, 'maswa_ajax_save_customer_phoneno']);
        add_action('wp_ajax_maswa_ajax_save_customer_phoneno', [$this, 'maswa_ajax_save_customer_phoneno']);

        //insert and update information about abandoned cart when cart is updated
        add_action('woocommerce_mini_cart_contents', array(self::$cart, 'logQuote'));
        add_action('woocommerce_cart_updated', array(self::$cart, 'logQuote'));

        add_action('init', array($this, 'add_scheduled_action'));
        add_action('maswa_send_message_action', array(self::$cron, 'run'), 11);


        add_action('woocommerce_order_status_changed', array(self::$checkout, 'updateCart'), 10, 3);

        add_action('init', array($this, 'resume_abandoned_cart'), 5);
        add_action('add_meta_boxes', array($this, 'whatsapp_meta_boxes'));
        add_filter('manage_maswa_mess_posts_columns', array(self::$admin, 'add_column'), 10, 1);
        add_action('manage_maswa_mess_posts_custom_column', array(self::$admin, 'add_column_data'), 10, 2);
        add_action('woocommerce_after_add_to_cart_form', array(self::$popup, 'view'), 10, 1);
    }

    public function whatsapp_meta_boxes()
    {
        add_meta_box(
            'whatsapp_message',
            'Generated message',
            array(self::$admin, 'show_message'),
            ['maswa_mess']
        );
    }

    public function frontend_enqueue()
    {
        global $wp_scripts;

        wp_enqueue_style('maswa-css', MASWA_URL . '/assets/maswa.css');
        wp_enqueue_style('featherpopup-css', MASWA_URL . '/assets/featherlight.min.css');
        // $wp_scripts->registered[ 'wc-add-to-cart-variation' ]->src = MASWA_URL . '/assets/js/wc-add-to-cart-variation.js';


        wp_enqueue_script('maswachatbox', MASWA_URL . '/assets/maswaChatBox.js');
        wp_enqueue_script('featherpopup', MASWA_URL . '/assets/featherlight.min.js');

        $is_chat_box_enable = get_option('maswa_chat_box_enable');
        $isUserLogin = false;
        if (is_user_logged_in()) $isUserLogin = true;

        wp_localize_script(
            'maswachatbox',
            'maswaObj',
            array(
                'adminUrl' => admin_url('admin-ajax.php'),
                'chat_box_enable' => $is_chat_box_enable,
                'whatsapp_icon_url' => MASWA_URL . '/assets/img/whatsapp_icon.png',
                'close_icon_url' => MASWA_URL . '/assets/img/close.png',
                'click_here' => __('Click here', 'maswa'),
                'greeting1' => __('Hi there', 'maswa'),
                'greeting2' => __('We are here to help. Chat with us on WhatsApp for any question', 'maswa'),
                'isUserLogin' => $isUserLogin
            )
        );
    }

    public function add_scheduled_action()
    {
        if (function_exists('as_next_scheduled_action')) {
            if (false === as_next_scheduled_action('maswa_cron_run')) {
                wp_clear_scheduled_hook('maswa_cron_run'); // Remove the cron job is present.
                as_schedule_recurring_action(time() + 60, 60, 'maswa_cron_run'); // Schedule recurring action.
            }
        }
    }

    public function add_settings_page($settings)
    {
        include_once MASWA_ABSPATH . 'admin/WcSetting.php';

        self::$wcSetting = new \Mas\Whatsapp\WcSetting();
        $settings[] = self::$wcSetting;
        return apply_filters('maswa_setting_classes', $settings);
    }

    public function maswa_ajax_get_abandoned_cart()
    {
        $rows = self::$dbUtil->getAbandonedCartList(10, 0);
        $carts = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $item=[];
                $user_id = $row['user_id'];
                $user_meta = get_metadata('user', $user_id);
                if (isset($user_meta ['last_name']) && isset($user_meta ['last_name'] [0]) && $user_meta ['last_name'] [0] !== '') {
                    $row['last_name'] = $user_meta ['last_name'] [0];
                    $item[0] = $user_meta ['last_name'] [0];
                } else {
                    $item[0] = __('NA', 'maswa');
                }
                if (isset($user_meta ['first_name']) && isset($user_meta ['first_name'] [0]) && $user_meta ['first_name'] [0] !== '') {
                    $row['first_name'] = $user_meta ['first_name'] [0];
                    $item[1] = $user_meta ['first_name'] [0];
                } else {
                    $row['first_name'] = __('NA', 'maswa');
                    $item[1]  = __('NA', 'maswa');
                }
              $item[2] = $row['user_email'];
              $item[3] = $row['total'];
                $carts[]=$item;
            }
        }
        $total = self::$dbUtil->getTotalAbandonedCartRecord();
        $out = [
            'data' => $carts,
            "draw" => 1,
            "recordsTotal" => $total[0],
            "recordsFiltered" => $total[0],
        ];
        wp_send_json($out);
        wp_die();
    }

    public function maswa_ajax_get_agent()
    {
        $rows = self::$dbUtil->getAgentList();
        if ($rows) {
            wp_send_json($rows);
            wp_die();
        }
    }


    public function resume_abandoned_cart()
    {
        global $wpdb;
        if (isset($_REQUEST['ats'])) {
            $ats = $_REQUEST['ats'];
            $quoteTbl = $wpdb->prefix . 'hn_fue_quote';
            $query = "SELECT * FROM " . $quoteTbl . " WHERE `uniq` = %s";
            $results = $wpdb->get_results($wpdb->prepare($query, array($ats)), ARRAY_A);
            if (!empty($results)) {
                $cart = $results[0]['cart_content'];
                $cart = json_decode($cart, true);
                WC()->session->cart = $cart['cart'];
            }
        }
    }

    public function maswa_ajax_save_customer_phoneno()
    {
        self::$dbUtil->savePhoneNo();
    }
}

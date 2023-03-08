<?php

/**
 * @class WooReg
 *
 * @version 2.0
 */

defined('ABSPATH') || exit;

/**
 * Main WooCommerce Gift registry.
 *
 * @class WooReg
 */
final class WooReg
{
    /**
     * WooCommerce WooCommerce Gift registry
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The single instance of the class.
     *
     * @var WooReg
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * @var Woo_Reg_Account
     */
    static $account;

    /**
     * @var Woo_Reg_Main
     */
    static $main;

    public function __construct()
    {
        add_filter( 'manage_mas_gift_posts_columns', array( $this, 'add_column' ), 10, 1 );
        add_action( 'manage_mas_gift_posts_custom_column', array( $this, 'add_column_data' ), 10, 2 );
        add_filter( 'woocommerce_account_menu_items', array( $this, 'account_menu_items' ), 10, 1 );
        add_filter('woocommerce_calculated_total', array($this, 'buyForGiftRegistry'), 10, 1);
        add_action('woocommerce_checkout_create_order_line_item', [$this,'afterGiftRegistryPurchasing'],10, 3);
        add_action('woocommerce_order_status_changed', [$this, 'woocommerce_order_status_changed'], 10,3);


        $this->defineConstants();

        $this->includes();
        $this->initHooks();

        do_action('wooreg_loaded');
        add_action( 'init', array( 'MAS_Shortcode', 'init' ) );
    }
    /**
     * Define Constants.
     */
    private function defineConstants()
    {
        $upload_dir = wp_upload_dir(null, false);
        $this->define('WOOREG_ABSPATH', dirname(WOOREG_PLUGIN_FILE) . '/');
        $this->define('WOOREG_PLUGIN_BASENAME', plugin_basename(WOOREG_PLUGIN_FILE));
        $this->define('WOOREG_VERSION', $this->version);
        $this->define('WOOREG_LOG_DIR', $upload_dir['basedir'] . '/woogregistry-logs/');
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }
    public function buyForGiftRegistry() {
        global $wocommerce;
        if (isset($_POST['gift_registry_id'])) {
            if (isset( WC()->session ))   {
                WC()->session->gift_registry_id = $_POST['gift_registry_id'];
            }
        }
    }

    public function afterGiftRegistryPurchasing($item, $cart_key, $values) {
        if (isset(WC()->session)) {
            WC()->session->gift_registry_id;
            $item->add_meta_data( '_mgiftregistry_id' , WC()->session->gift_registry_id);
           }
    }
    public function woocommerce_order_status_changed($order_id, $old_status, $new_status ) {
        if (isset( WC()->session ))   {
            WC()->session->__unset('gift_registry_id');
        }

        /** @var  $order WC_Order */
        $order = wc_get_order( $order_id );
        // Get and Loop Over Order Items
        $subTotal = 0;
        $_mgiftregistry_id =0;
        foreach ( $order->get_items() as $item_id => $item ) {
            $product_id = $item->get_product_id();
            $variation_id = $item->get_variation_id();
            $product = $item->get_product(); // see link above to get $product info
            $product_name = $item->get_name();
            $quantity = $item->get_quantity();
            $subtotal = $item->get_subtotal();
            $total = $item->get_total();
            $tax = $item->get_subtotal_tax();
            $tax_class = $item->get_tax_class();
            $tax_status = $item->get_tax_status();
            $allmeta = $item->get_meta_data();
            $_mgiftregistry_id = $item->get_meta( '_mgiftregistry_id', true );

            if ($_mgiftregistry_id) {
                $subTotal +=$subtotal;
            }
        }

        if ($subTotal > 0) {
            update_post_meta($order_id,'_mgiftregistry_id', $_mgiftregistry_id);
        }

        if ($old_status != $new_status) {
            if ($new_status == 'completed' && $subTotal > 0) {
                // if gifting coupon , ratio are set ,then coupon is generate, with oder id, gift registry id
                Mars_GiftRegistry_Util::generateCouponForOrder($order_id,$subTotal,$_mgiftregistry_id);
            }
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {
        include_once WOOREG_ABSPATH . 'includes/class-install.php';

        include_once WOOREG_ABSPATH . 'admin/class-admin.php';
        include_once WOOREG_ABSPATH . 'admin/setting.php';

        include_once WOOREG_ABSPATH . 'includes/class-main.php';
        include_once WOOREG_ABSPATH . 'includes/class-shortcode.php';
        include_once WOOREG_ABSPATH . 'includes/class-account.php';
        include_once WOOREG_ABSPATH . 'includes/util.php';

        self::$account = new Woo_Reg_Account();
        self::$main = new RegDb();
        Mars_GiftRegistry_Setting::getInstance();
    }
    public  function create_custom_post_type() {
        $args = array(
            'labels'              => array(
                'name'               => esc_html__( 'Gift registry', 'masr' ),
                'singular_name'      => esc_html__( 'Gift registry', 'masr' ),
                'menu_name'          => esc_html_x( 'Gift registry', 'Admin menu', 'masr' ),
                'name_admin_bar'     => esc_html_x( 'Gift registry', 'Add new on Admin bar', 'masr' ),
                'view_item'          => esc_html__( 'View gift registry', 'masr' ),
                'all_items'          => esc_html__( 'Gift registry', 'masr' ),
                'search_items'       => esc_html__( 'Search gift registry', 'masr' ),
                'not_found'          => esc_html__( 'No gift registry.', 'masr' ),
                'not_found_in_trash' => esc_html__( 'No gift registry found in Trash.', 'masr' )
            ),
            'description'         => esc_html__( 'Gift registry for WooCommerce.', 'masr' ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_menu'        => false,
            'hierarchical'        => false,
            'rewrite'             => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
        );
        register_post_type( 'mas_gift', $args );

        //gift registry item
        if ( post_type_exists( 'mas_gift_item' ) ) {
            return;
        }
        $args = array(
            'labels'              => array(
                'name'               => esc_html__( 'Gift registry item', 'masr' ),
                'singular_name'      => esc_html__( 'Gift registry item', 'masr' ),
                'menu_name'          => esc_html_x( 'Gift registry item', 'Admin menu', 'masr' ),
                'name_admin_bar'     => esc_html_x( 'Gift registry item', 'Add new on Admin bar', 'masr' ),
                'view_item'          => esc_html__( 'View gift registry item', 'masr' ),
                'all_items'          => esc_html__( 'Gift registry item', 'masr' ),
                'search_items'       => esc_html__( 'Search gift registry item', 'masr' ),
                'not_found'          => esc_html__( 'No gift registry item.', 'masr' ),
                'not_found_in_trash' => esc_html__( 'No gift registry  itemfound in Trash.', 'masr' )
            ),
            'description'         => esc_html__( 'Gift registry item for WooCommerce.', 'masr' ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_menu'        => false,
            'hierarchical'        => false,
            'rewrite'             => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
        );
        register_post_type( 'mas_gift_item', $args );
    }

    public function add_column( $columns ) {
       // $columns['customer_name'] = esc_html__( 'Customer name', 'masr' );
        $columns['registry_email']         = esc_html__( 'Registry email', 'masr' );
        $columns['registry_name']     = esc_html__( 'Registry name', 'masr' );
        $columns['detail']     = esc_html__( 'Detail', 'masr' );
        $columns['coupon']     = esc_html__( 'Coupon', 'masr' );

        return $columns;
    }

    public function add_column_data( $column, $post_id ) {
        switch ( $column ) {
            case 'registry_email':
                if ( get_post_meta( $post_id, 'masr_email', true ) ) {
                    echo esc_html( get_post_meta( $post_id, 'masr_email', true ));
                }
                break;
            case 'registry_name':
                if ( get_post_meta( $post_id, 'masr_first_name', true ) ) {
                    $name =  get_post_meta( $post_id, 'masr_first_name', true ). ' '. get_post_meta( $post_id, 'masr_last_name', true );
                    echo esc_html($name);

                }
                break;

            case 'detail':
                      $url = admin_url('edit.php?post_type=mas_gift&page=masr_detail&id=' . $post_id);
                      $html = "<a class='button button-primary' href='" .$url . "' >". __('View','masr') . "</a>";
                      echo $html;
                break;
           case 'coupon':
                      $url = admin_url('edit.php?post_type=mas_gift&page=masr_detail&id=' . $post_id. "&coupon=true");
                      $html = "<a class='button button-primary' href='" .$url . "' >". __('View coupon','masr') . "</a>";
                      echo $html;
                break;
        }
    }
    /**
     * Hook into actions and filters.
     *
     * @since 1.0
     */
    private function initHooks()
    {
        register_activation_hook(WOOREG_PLUGIN_FILE, array('WooRegInstall', 'install'));
        add_action('init', array($this, 'create_custom_post_type'));

        register_shutdown_function(array($this, 'logErrors'));
        add_filter( 'woocommerce_account_menu_items', array( $this, 'account_menu_items' ), 10, 1 );
        add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'show_add_to_gift_registry_product_page' ), 10, 1 );
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 99);

        add_action( 'wp_ajax_masr_add_item', array( $this, 'add_item_action' ) );
        add_action( 'wp_ajax_nopriv_masr_add_item', array( $this, 'add_item_action' ) );

        add_action( 'wp_ajax_masr_ajax_get_registry', array( $this,'masr_ajax_get_registry' ));
        add_action( 'wp_ajax_nopriv_masr_ajax_get_registry',  array( $this,'masr_ajax_get_registry'));
        add_action( 'wp_ajax_masr_ajax_get_registry', array( $this,'masr_ajax_get_registry' ));
        add_action( 'wp_ajax_masr_ajax_submit_registry',  array( $this,'masr_ajax_submit_registry'));
        add_action( 'wp_ajax_nopriv_masr_ajax_submit_registry',  array( $this,'masr_ajax_submit_registry'));
        //remove item
        add_action('wp_ajax_masr_ajax_remove_registry' ,array($this,'masr_ajax_remove_registry'));

        add_action('wp_ajax_masr_ajax_update_item' ,array($this,'masr_ajax_update_item'));
        add_action('wp_ajax_masr_ajax_get_coupon' ,array($this,'get_coupon_list_per_gift_registry'));

        add_action( 'wp_ajax_fetch_gift_registry',  array( $this,'fetch_gift_registry'));
        add_action( 'wp_ajax_nopriv_fetch_gift_registry',  array( $this,'fetch_gift_registry'));
        add_action( 'wp_ajax_search_gift_registry',  array( $this,'search_gift_registry'));
        add_action( 'wp_ajax_nopriv_search_gift_registry',  array( $this,'search_gift_registry'));
    }

    public function admin_enqueue_scripts() {
        wp_enqueue_script( 'masr-admin-javascript', WOOREG_URL . '/assets/js/masrAdmin.js', array( 'jquery' ), 1.0 );

    }
    public function masr_ajax_update_item() {
        check_ajax_referer( 'masr_ajax_update_item', '_ajax_nonce' );
        $return_arr=[];
        if (isset($_REQUEST['type']) && isset($_REQUEST['id']) ){
            $id = (int)($_REQUEST['id']);

            global $current_user;
            wp_get_current_user();
            $userId =  $current_user->ID;
            if ( $_REQUEST['type'] == 'priority') {
                $post =get_post($id);
                $priority= (int)$_REQUEST['priority'];
                if (!in_array($priority, [1,2,3]) ){
                    wp_die('priority input value is invalid');
                }
                update_post_meta($id, 'priority', $priority);
                $return_arr['message'] = __('You updated priority successfully', 'masr');
                $return_arr['success'] = 1;
            } elseif ( $_REQUEST['type'] == 'quantity') {
                $quantity =(int) $_REQUEST['quantity'];
                if (!is_numeric($quantity)) {
                    wp_die('quantity input is invalid');
                }

                update_post_meta($id, 'quantity', $quantity);

                $return_arr['message'] = __('You updated quantity successfully', 'masr');
                $return_arr['success'] = 1;
            } else if ($_REQUEST['type'] == 'delete') {
                wp_delete_post($id);
                $return_arr['message'] = __('You have deleted item successfully', 'masr');
                $return_arr['success'] = 1;
            }
        }
        wp_send_json($return_arr);
        wp_die();
    }

    public function get_coupon_list_per_gift_registry() {
        $return_arr =Mars_GiftRegistry_Util::getCouponForGiftRegistry(36);
        //$return_arr =[];
        wp_send_json($return_arr);
        wp_die();
    }
    public function masr_ajax_remove_registry() {
        check_ajax_referer( 'masr_ajax_remove_registry', 'security' );
        if (isset($_REQUEST['registry_id']) && is_numeric($_REQUEST['registry_id'])) {
            $registryId = $_REQUEST['registry_id'];
            $out = $this->remove_registry($registryId);
            wp_send_json($out);
            wp_die();
        } else {
            $return_arr['message'] = __('You have to log in to delete gift registry');
            $return_arr['success'] = 0;
            wp_send_json($return_arr);
            wp_die();
        }
    }
    function remove_registry($id) {
        $return_arr=[];
        if ( is_user_logged_in() ) {
            $post =get_post($id);

            if ( $post) {
                wp_delete_post($id);
                $delete = true;
            }

            if ($delete) {
                $return_arr['message'] = __('You have delete the gift registry successfully');
                $return_arr['success'] = 1;
            }  else {
                $return_arr['message'] = __('The gift registry does not exist');
                $return_arr['success'] = 0;
            }
        } else {
            $return_arr['message'] = __('You have to log in to delete gift registry');
            $return_arr['success'] = 0;
        }
        return $return_arr;
    }
    public function masr_ajax_get_registry() {
        check_ajax_referer( 'masr_ajax_get_registry', 'security' );
        $return_arr = $this->getRegistry();
        wp_send_json($return_arr);
        wp_die();
    }

    public function getRegistry() {
        $return_arr = [];
        if ( is_user_logged_in() ) {
            global $current_user;
            wp_get_current_user();
            $userId =  $current_user->ID;
            $author_query = array(
                'posts_per_page' => '-1',
                'post_type'      => 'mas_gift',
                'author' =>$userId
            );
            $query = new WP_Query($author_query);
            while ( $query->have_posts() ) {
                global $post;
                $query->the_post();
                array_push( $return_arr,['ID'=>$post->ID ,'title' =>get_the_title(), 'description' =>$post->post_content] );
            }
            wp_reset_postdata();
        }

        return $return_arr;
    }


    public function masr_ajax_submit_registry() {
        check_ajax_referer( 'masr_ajax_submit_registry', 'security' );
        $return_arr=[];
        if (isset($_REQUEST['edit']) && isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
            /** @var WP_Post $post */
            $post = get_post($_REQUEST['id']);
            if ($post instanceof WP_Post) {
                $registry_id =$_REQUEST['id'];
                $postArr = ['ID' =>$_REQUEST['id'], 'post_title' => $_REQUEST['title'] , 'post_content' =>$_REQUEST['description']];
                wp_update_post($postArr);
                update_post_meta( $registry_id, 'masr_email',  $_REQUEST['email'] );
                update_post_meta( $registry_id, 'masr_first_name',  $_REQUEST['first_name'] );
                update_post_meta( $registry_id, 'masr_last_name',  $_REQUEST['last_name'] );

                $return_arr['message'] = __('You have updated info ', "masr");
                $return_arr['success'] = 1;
            }

        } else {
            $registry_id = wp_insert_post(
                array(
                    'post_title'   => $_REQUEST['title'],
                    'post_name'    => $_REQUEST['title'],
                    'post_content' => $_REQUEST['description'],
                    'post_status'  => 'publish',
                    'post_type'    => 'mas_gift',
                )
            );
            update_post_meta( $registry_id, 'masr_email',  $_REQUEST['email'] );
            update_post_meta( $registry_id, 'masr_first_name',  $_REQUEST['first_name'] );
            update_post_meta( $registry_id, 'masr_last_name',  $_REQUEST['last_name'] );

            $return_arr['message'] = __('You have saved registry' , 'masr');
            $return_arr['success'] = 1;
        }

        wp_send_json($return_arr);
        wp_die();
    }

    public function add_item_action() {
       self::$main->add_item_action();
    }
    public function account_menu_items($item) {
       return self::$account->account_menu_items($item);
    }
    public function show_add_to_gift_registry_product_page() {
        return self::$account->show_add_gift_registry();
    }
    public function frontend_enqueue() {
        return self::$account->frontend_enqueue();
    }

    /**
     * Ensures fatal errors are logged so they can be picked up in the status report.
     *
     * @since 1.0
     */
    public function logErrors()
    {
        $error = error_get_last();
        if ($error !=null && isset($error['type'])) {
            if (in_array($error['type'], array(E_ERROR, E_PARSE, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR))) {
                $logger = wc_get_logger();
                $logger->critical(
                /* translators: 1: error message 2: file name and path 3: line number */
                    sprintf(__('%1$s in %2$s on line %3$s', 'woosfrest'), $error['message'], $error['file'], $error['line']) . PHP_EOL,
                    array(
                        'source' => 'fatal-errors',
                    )
                );
                do_action('wooreg_shutdown_error', $error);
            }
        }
    }

    /**
     * Main WooCommerce Gift Registry Instance.
     *
     * Ensures only one instance of WooCommerce Gift Registry  is loaded or can be loaded.
     *
     * @since 1.0
     * @static
     * @see WooReg()
     * @return WooReg - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function fetch_gift_registry() {
        $output = Mars_GiftRegistry_Util::getAllGiftRegistry();
        wp_send_json($output);
        wp_die();
    }
    public function search_gift_registry() {
        $key = sanitize_title_for_query($_GET['query']);
        $output = Mars_GiftRegistry_Util::searchGiftRegistry($key);
        wp_send_json($output);
        wp_die();
    }
}


<?php

/**
 * @class WooReg
 *
 * @version 2.0
 */

defined('ABSPATH') || exit;

/**
 * Main WooCommerce Salesforce Connector REST API Class.
 *
 * @class WooReg
 */
final class MasMobileBuilder
{
    /**
     * WooCommerce Salesforce Connector REST API version.
     *
     * @var string
     */
    public $version = '1.0.0';


    protected static $_instance = null;



    static $main;
    public $admin;


    public function __construct()
    {
        add_action( 'init', array( $this, 'create_custom_post_type' ) );
//        add_filter( 'manage_mas_gift_posts_columns', array( $this, 'add_column' ), 10, 1 );
//        add_action( 'manage_mas_gift_posts_custom_column', array( $this, 'add_column_data' ), 10, 2 );
//        add_filter( 'woocommerce_account_menu_items', array( $this, 'account_menu_items' ), 10, 1 );

        $this->includes();
        $this->initHooks();

    }
 

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {
        include_once MASMB_ABPATH . 'admin/masadmin.php';

        include_once MASMB_ABPATH . 'includes/main.php';
        $this->admin = new MasMobileAdmin();
    }

      public function compile_post_type_capabilities($singular = 'post', $plural = 'posts') {
        return [
            'edit_post'		 => "edit_$singular",
            'read_post'		 => "read_$singular",
            'delete_post'		 => "delete_$singular",
            'edit_posts'		 => "edit_$plural",
            'edit_others_posts'	 => "edit_others_$plural",
            'publish_posts'		 => "publish_$plural",
            'read_private_posts'	 => "read_private_$plural",
            'read'                   => "read",
            'delete_posts'           => "delete_$plural",
            'delete_private_posts'   => "delete_private_$plural",
            'delete_published_posts' => "delete_published_$plural",
            'delete_others_posts'    => "delete_others_$plural",
            'edit_private_posts'     => "edit_private_$plural",
            'edit_published_posts'   => "edit_published_$plural",
            'create_posts'           => "edit_$plural",
        ];
    }
    public  function create_custom_post_type() {
        if ( post_type_exists( 'mas_mobile_setting' ) ) {
         //   return;
        }
        $capabilities = $this->compile_post_type_capabilities('mobile_app_setting', 'mobile_app_settings');

        $args = array(
            'labels'              => array(
                'name'               => esc_html__( 'Mobile app setting', 'masr' ),
                'singular_name'      => esc_html__( 'Mobile app setting', 'masr' ),
                'menu_name'          => esc_html_x( 'Mobile app setting', 'Admin menu', 'masr' ),
                'name_admin_bar'     => esc_html_x( 'Mobile app setting', 'Add new on Admin bar', 'masr' ),
                'view_item'          => esc_html__( 'View mobile app setting', 'masr' ),
                'all_items'          => esc_html__( 'Mobile app setting', 'masr' ),
                'search_items'       => esc_html__( 'Search mobile app setting', 'masr' ),
                'not_found'          => esc_html__( 'No mobile app setting.', 'masr' ),
                'not_found_in_trash' => esc_html__( 'No mobile app setting found in Trash.', 'masr' )
            ),
            'description'         => esc_html__( 'Mobile app setting for WooCommerce.', 'masr' ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => $capabilities,
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
        register_post_type( 'mas_mobile_setting', $args );
        $capabilities = $this->compile_post_type_capabilities('mobile_app_x', 'mobile_app_xs');

        $args = array(
            'labels'              => array(
                'name'               => esc_html__( 'Mobile app setting', 'masr' ),
                'add_new_item' => __( 'Add Mobile app setting' ),
                'add_new' => __( 'Add Mobile app setting' ),
                'edit_item' => __( 'Edit Mobile app setting' ),
                'item_updated'=>__('Mobile app setting updated'),
                'featured_image' => __( 'Mobile app setting Image' ),
                'set_featured_image' => __( 'Upload Mobile app setting Image' ),
                'remove_featured_image' => __( 'Remove Mobile app setting Images' ),
                'singular_name'      => esc_html__( 'Mobile app setting', 'masr' ),
                'menu_name'          => esc_html_x( 'Mobile app setting', 'Admin menu', 'masr' ),
                'name_admin_bar'     => esc_html_x( 'Mobile app setting', 'Add new on Admin bar', 'masr' ),
                'view_item'          => esc_html__( 'View mobile app setting', 'masr' ),
                'all_items'          => esc_html__( 'Mobile app setting', 'masr' ),
                'search_items'       => esc_html__( 'Search mobile app setting', 'masr' ),
                'not_found'          => esc_html__( 'No mobile app setting.', 'masr' ),
                'not_found_in_trash' => esc_html__( 'No mobile app setting found in Trash.', 'masr' )
            ),
            'description'         => esc_html__( 'Mobile app setting for WooCommerce.', 'masr' ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'capabilities'        => $capabilities,
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
        register_post_type( 'mas_mobile_x', $args );
    }

    private function initHooks()
    {
       // add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 99);
        add_action('admin_menu', array($this->admin, 'adminMenu'));
        add_action( 'add_meta_boxes', array( $this->admin, 'add_metabox' ) );
        add_action( 'save_post', array( $this->admin, 'save_metabox' ), 10, 2 );
        add_action('init', array( $this, 'xyz1234_my_custom_add_user'));
//        add_action( 'admin_menu', function () {
//            remove_meta_box( 'submitdiv', 'mas_mobile_x', 'side' );
//        } );
        add_action( 'wp_ajax_masmb_ajax_get_mobile', array( $this,'masmb_ajax_get_mobile' ));
        add_action( 'wp_ajax_nopriv_masmb_ajax_get_mobile',  array( $this,'masmb_ajax_get_mobile'));

    }
    public function masmb_ajax_get_mobile() {
        $token= $_REQUEST['token'];
        $return_arr = $this->getMobileAppConfig($token);
        wp_send_json($return_arr);
        wp_die();
    }
    private function get_data($post_id, $field, $default = '')
    {


        if (isset($this->data[$post_id]) && $this->data[$post_id]) {
            $params = $this->data[$post_id];
        } else {
            $this->data[$post_id] = get_post_meta($post_id, 'masmb_params', true);
            $params = $this->data[$post_id];
        }
        if (isset($params[$field]) && $field) {
            return $params[$field];
        } else {
            return $default;
        }
    }
    public function getMobileAppConfig($token) {
        global $wpdb;
        $posts = get_posts(array(
            'numberposts'   => -1,
            'post_type'     => 'post',
            'meta_key'      => 'token',
            'meta_value'    => $token
        ));
        if (!isset($posts[0])) {
            $postsx = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
            WHERE meta_key = 'token' AND  meta_value = '".$token."' LIMIT 1", ARRAY_A);

            if (is_array($postsx)) {
                $y = $postsx;
                $post = get_post($y[0]['post_id']);
            }
        } else {
            $post = $posts[0];
        }

        if (isset($post) && is_object($post)) {
            $postId = $post->ID;
            $output = [];
            $output['primary_color'] = $this->get_data($post->ID, 'primary_color');;
            $output['secondary_color'] = $this->get_data($post->ID, 'secondary_color');
           // $output['launch_screen']  =

            $output['app_state']  = true;
            $homeData = $this->get_data($post->ID, 'home');
            $cartData = $this->get_data($post->ID, 'cart');

            $infoData = $this->get_data($post->ID, 'info');
            $settingData = $this->get_data($post->ID, 'setting');

            if (isset($homeData['enable']) && $homeData['enable'] == 1) {
                $title = isset($homeData['title'])?$homeData['title']:'Home';
                $icon = isset($homeData['icon'])?'Home'.$homeData['icon']:'Home1';
                $output['menu'][]  =
                    [
                        'menu_type_id'=>'Home',
                        'title' =>$title,
                        'icon_name' =>$icon
                    ];
            }

            if (isset($cartData['enable']) && $cartData['enable'] == 1) {
                $title = isset($cartData['title'])?$cartData['title']:'Cart';
                $icon = isset($cartData['icon'])?'Cart'.$cartData['icon']:'Cart1';
                $output['menu'][]  =
                    [
                        'menu_type_id'=>'Cart',
                        'title' =>$title,
                        'icon_name' =>$icon
                    ];
            }
            if (isset($infoData['enable']) && $infoData['enable'] == 1) {
                $title = isset($infoData['title'])?$infoData['title']:'Setting';
                $icon = isset($infoData['icon'])?'Account'.$infoData['icon']:'Account1';
                $output['menu'][]  =
                    [
                        'menu_type_id'=>'Account',
                        'title' =>$title,
                        'icon_name' =>$icon
                    ];
            }
            if (isset($settingData['enable']) && $settingData['enable'] == 1) {
                $title = isset($settingData['title'])?$settingData['title']:'Setting';
                $icon = isset($settingData['icon'])?'Setting'.$settingData['icon']:'Setting1';
                $output['menu'][]  =
                    [
                        'menu_type_id'=>'Setting',
                        'title' =>$title,
                        'icon_name' =>$icon
                    ];
            }
        }
        $encodedShopName = get_post_meta($postId,'shop_name',true);
        //masmb
        $shopName = substr($encodedShopName,0,$encodedShopName.length - 5);
        $output['base_url'] ='https://'.$shopName.'.myshopify.com';
        $output['currencyCode'] ='USD';
        $output['app_state'] =true;

        return $output;
    }
    public function xyz1234_my_custom_add_user() {
        global $lookbookuserid;
        global $wpdb;

        if (isset($_REQUEST['mobile_shop_name']) ) {
            $shop_name = $_REQUEST['mobile_shop_name'];
            $email = $shop_name;
            $password = 'pasword123';
            $mysPos = strpos($shop_name,'myshopify.com');
            if ($mysPos) {
                $user =  substr($shop_name,0, $mysPos-1);
                $email = $user.'masmb@thexseedmab.com';
            }
            $username = $user.'masmb';

            //because this is 2nd app so
            //  $email = 'drew@example.com';

            // if (username_exists($username) == null && email_exists($email) == false) {
            if (username_exists($username) == null ) {

                // Create the new user
                $user_id = wp_create_user($username, $password,$email);
                if (is_int($user_id)) {
                    $query = "UPDATE wp_users SET display_name ="."'".$shop_name. "'". " WHERE user_id=".$user_id;
                    $wpdb->query($query);
                    // Get current user object
                    $user = get_user_by('id', $user_id);

                    // Remove role
                    $user->remove_role('subscriber');

                    // Add role
                    $user->add_role('author_mobileapp');
                    $this->login($username);
                    $current_user= wp_get_current_user();
                    $lookbookuserid = $current_user->ID;
                } else {
                    echo "Please contact admin";
                    var_dump($user_id);
                }

            } else {
                $this->login($username);
                $current_user= wp_get_current_user();
                $lookbookuserid = $current_user->ID;
            }
        } else{
            $x=2;
            // login($username);
        }

    }
    public function login($username) {
        // Automatic login //
        $user = get_user_by('login', $username );

        // Redirect URL //
        if ( !is_wp_error( $user ) )
        {
            wp_clear_auth_cookie();
            wp_set_current_user ( $user->ID );
            wp_set_auth_cookie  ( $user->ID );

            $redirect_to = user_admin_url();
            $redirect_to =  'https://'.$_SERVER['HTTP_HOST'].'/blog/wp-admin/admin.php?page=masmb_setting';

            wp_safe_redirect( $redirect_to );
            exit();
        }
    }
    public function getMobileSettingByUserId($user_id) {
        $args = array(
            'author'        => $user_id,
            'post_type' => 'mas_mobile_x',
            'post_status' => 'private',
            'posts_per_page' => 1,
            'orderby'       =>  'post_date',
            'order'         =>  'ASC'
        );

        $setting = get_posts( $args );
        return $setting;
    }
    public function admin_enqueue_scripts() {
        wp_enqueue_media();
        $wp_scripts = wp_scripts();

        wp_enqueue_style(
            'jquery-ui-theme-smoothness', //select ui theme: base...
            sprintf(
                'https://ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css',
                $wp_scripts->registered['jquery-ui-core']->ver
            )
        );
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
        wp_enqueue_script( 'masmb-qr-javascript', MASMB_URL . '/assets/js/qrcode.min.js', array( 'jquery' ), 1.0 );
        wp_enqueue_script( 'masmb-admin-javascript', MASMB_URL . '/assets/js/masmbadmin.js', array( 'jquery' ), 1.0 );
       // wp_enqueue_script( 'masr-admin-javascript', MASMB_URL . '/assets/js/masrAdmin.js', array( 'jquery' ), 1.0 );

    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}


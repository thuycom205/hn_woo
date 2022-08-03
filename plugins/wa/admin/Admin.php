<?php

namespace Mas\Whatsapp;
use Mas\Whatsapp\Admin\MetaBox;
use Mas\Whatsapp\Admin\AbandonedCartTable;
class Admin
{
    public $meta;
    public $setting;
    public function admin_enqueue_scripts()
    {
        wp_enqueue_style( 'maswa_css', MASWA_URL . '/assets/admin_maswa.css' );
        wp_enqueue_script( 'maswa-admin-javascript', MASWA_URL . '/assets/maswaAdmin.js', array( 'jquery' ), 1.0 );
        wp_localize_script( 'maswa-admin-javascript', 'maswaAdminParam', array(
            'url' => admin_url( 'admin-ajax.php' )
        ) );

    }

    public function admin_print_scripts() {

    }

    public function settings_page() {
        $wa = MasWhatsApp();
        $wa::$setting->view();
    }

    public function showAbandonedCartTable() {
        if(!class_exists('Mas\Whatsapp\Admin\AbandonedCartTable'))    include_once MASWA_ABSPATH . 'admin/view/AbandonedCartTable.php';

        $table = new AbandonedCartTable();
        $table->view();
    }
    public function test() {
        $wa = MasWhatsApp();
        $total = $wa::$dbUtil->getTotalAbandonedCartRecord();
        $list = $wa::$dbUtil->getAbandonedCartList();
        $is_chat_box_enable = get_option('maswa_chat_box_enable');

        $x = 1;
        $cron = new \Mas\Whatsapp\Cron();
        $cron->run();
    }

    public function show_message() {
        global $post;
        $meta =  new MetaBox($post);
        $meta->show_whatsapp_message();
    }
    public function admin_menu() {
        add_menu_page(
            esc_html__( 'Whatsapp Integration Premium', 'maswa' ),
            esc_html__( 'Whatsapp Integration Premium', 'maswa' ),
            'manage_options',
            'maswa_test',
            [$this, 'test'],   'dashicons-whatsapp', 2
        );
        add_menu_page(
            esc_html__( 'Whatsapp Integration Premium', 'maswa' ),
            esc_html__( 'Whatsapp Integration Premium', 'maswa' ),
            'manage_options',
            'maswa',
           [],   'dashicons-whatsapp', 2
        );
        add_submenu_page(
            'maswa',
            esc_html__( 'Whatsapp Setting', 'maswa' ),
            esc_html__( 'Whatsapp Setting', 'maswa' ),
            'manage_options',
            'admin.php?page=wc-settings&tab=maswa'
        );        add_submenu_page(
            'maswa',
            esc_html__( 'Whatsapp Agent', 'maswa' ),
            esc_html__( 'Whatsapp Agent', 'maswa' ),
            'manage_options',
            'edit.php?post_type=maswa_agent'
        );

        add_submenu_page(
            'maswa',
            esc_html__( 'Abandoned cart table', 'maswa' ),
            esc_html__( 'Abandoned cart table', 'maswa' ),
            'manage_options',
            'abandoned_cart_maswa',
            [$this,'showAbandonedCartTable']
        );

        add_submenu_page(
            'maswa',
            esc_html__( 'Whatsapp message', 'maswa' ),
            esc_html__( 'Whatsapp message', 'maswa' ),
            'manage_options',
            'edit.php?post_type=maswa_mess'
        );
    }
    /**
     * Set up and add the meta box.
     */
    public  function add() {
        global  $post;
        $this->meta = new MetaBox($post);
        $value = get_post_meta( $post->ID, '_wporg_meta_key', true );
        $screens = [  'maswa_agent' ];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'maswa_agent_box_id',          // Unique ID
                'Agent information', // Box title
                [  $this->meta ,'view'], // Content callback, must be of type callable
                $screen                  // Post type
            );
        }
    }
    public function add_column($columns) {
        $columns['message'] = esc_html__( 'Message', 'maswa' );
        $columns['send_action']         = esc_html__( 'Action', 'maswa' );
        $columns['message_2'] = esc_html__( 'Message 2', 'maswa' );
        $columns['send_action_2']         = esc_html__( 'Action 2', 'maswa' );

        return $columns;
    }
    public function add_column_data($column, $post_id) {
        $send_status1 ="";
        $send_status2 = "";
        $status1 = get_post_meta($post_id,'status_1',true);
        if ($status1=='yes') $send_status1 = "disabled";

        $status2 = get_post_meta($post_id,'status_2',true);
        if($status2 == 'yes') $send_status2 =  "disabled";

        switch ( $column ) {
            case 'message':
                if ( get_post( $post_id )->post_content ) {
                    echo esc_html( get_post_meta( $post_id, 'whatsapp_message', true ));
                }
                break;
            case 'send_action':
                $customer_id = get_post_meta( $post_id, 'customer_id', true );
                $phone =  get_user_meta( $customer_id, 'billing_phone', true ) ;
                if ( get_post_meta( $post_id, 'whatsapp_message', true ) && $phone ) {
                    ?>
                    <button data-postid="<?php echo $post_id ?>"  <?php echo $send_status1 ?> data-order="1" onclick="sendWhatsappMessage(this, '<?php echo $phone ?>','<?php echo get_post_meta( $post_id, 'whatsapp_message', true )?>')"><?php echo __('Send') ?> </button>

                <?php

                }
                break;
            case 'message_2':
                if ( get_post( $post_id )->post_content ) {
                    echo esc_html( get_post_meta( $post_id, 'whatsapp_message_2', true ));
                }
                break;
            case 'send_action_2':
                $customer_id = get_post_meta( $post_id, 'customer_id', true );
                $phone =  get_user_meta( $customer_id, 'billing_phone', true ) ;

                if ( get_post_meta( $post_id, 'whatsapp_message_2', true ) && $phone ) {
                    ?>
                    <button data-postid="<?php echo $post_id ?>" <?php echo $send_status2 ?>  data-order="2" onclick="sendWhatsappMessage2(this, '<?php echo $phone ?>','<?php echo get_post_meta( $post_id, 'whatsapp_message_2', true )?>')"><?php echo __('Send') ?> </button>

                    <?php

                }

        }
    }

    public function maswa_update_mess_status() {
        if (isset($_REQUEST['id'])) {
            try {
                $id = (int)$_REQUEST['id'];
                $order = $_REQUEST['order'];

                $meta_key = "status_".$order;
                update_post_meta($id,$meta_key,'yes');
            } catch (Exception $e) {
                return false;
            }
        }
        return true;
    }

    public function maswa_update_mess_status_two() {
        if (isset($_REQUEST['id'])) {
            try {
                $id = (int)$_REQUEST['id'];
                $order = $_REQUEST['order'];

                $meta_key = "status_".$order;
                update_post_meta($id,$meta_key,'yes');
            } catch (Exception $e) {
                return false;
            }
        }
        return true;
    }
    public function save(int $post_id ) {
        if ( array_key_exists( 'country_code', $_POST ) ) {
            update_post_meta(
                $post_id,
                'country_code',
                $_POST['country_code']
            );
        }
        if ( array_key_exists( 'phone_number', $_POST ) ) {
            update_post_meta(
                $post_id,
                'phone_number',
                $_POST['phone_number']
            );
        }
        if ( array_key_exists( 'agent_name', $_POST ) ) {
            update_post_meta(
                $post_id,
                'agent_name',
                $_POST['agent_name']
            );
        }
        if ( array_key_exists( 'agent_role', $_POST ) ) {
            update_post_meta(
                $post_id,
                'agent_role',
                $_POST['agent_role']
            );
        }
        if ( array_key_exists( 'agent_ava', $_POST ) ) {
            update_post_meta(
                $post_id,
                'agent_ava',
                $_POST['agent_ava']
            );
        }

    }
}
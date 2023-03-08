<?php
if ( ! class_exists( 'WC_Settings_Page' ) ) {
    include_once dirname( WOOREG_ABSPATH  ) . '/woocommerce/includes/admin/settings/class-wc-settings-page.php';
}
class Mars_GiftRegistry_Setting extends \WC_Settings_Page
{
    private static $instances = [];
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id    = 'marsregistry';
        $this->label = __( 'Gift Registry', 'masr' );

        add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 200 );
        add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
        add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
        add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
        add_action( 'woocommerce_admin_field_file', array( $this, 'display_file' ), 10 );

    }
    public static function getInstance(): Mars_GiftRegistry_Setting
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
    public function add_settings_page($settings_tabs)
    {
        $settings_tabs[$this->id] = __('Gift Registry', 'masr');
        return $settings_tabs;
    }

    /**
     * Output content
     */
    public function output()
    {
        global $current_section;
        if ($current_section == "") $current_section = 'marsregistry';
        parent::output();
    }
    public function get_settings()
    {

        $options = apply_filters('woocommerce_marsregistry_settings', array(
                array(
                    'title' => __('Gift registry incentive', 'masr'),
                    'type' => 'title',
                    'id' => 'xgiftregisry_options_title'
                ),
                array(
                    'title' => __('Enable coupon', 'masr'),
                    'desc' => __('Enable gifting coupon for gift registry owner', 'masr'),
                    'id' => 'xgiftregistry_enable',
                    'type' => 'checkbox',
                    'autoload' => false,
                ),
                array(
                    'title' => __('Coupon pattern', 'masr'),
                    'desc' => __('Coupon pattern', 'masr'),
                    'id' => 'xgiftregistry_coupon_pattern',
                    'type' => 'text',
                    'autoload' => false,
                ),
                array(
                    'title' => __('Ratio for coupon base on order total', 'masr'),
                    'desc' => __('If friends of gift registry\'s ower buying oder which has value of 500$ and this field value is 10 then gift registry owner receive $50 coupon ', 'masr'),
                    'id' => 'xgiftregistry_coupon_ratio',
                    'type' => 'text',
                    'autoload' => false,
                ),
                array(
                    'type' => 'sectionend',
                    'id' => 'marsregistry_options_title',
                ),
                array(
                    'title' => __('Email option', 'masr'),
                    'type' => 'title',
                    'id' => 'marsregistry_email_options',
                ),
                array(
                    'title' => __('Email subject', 'masr'),
                    'desc' => __('Gift registry\'s owner will get email with this subject', 'masr'),
                    'id' => 'masr_email_subject',
                    'type' => 'text',
                    'autoload' => false
                ),
                array(
                    'title' => __('Content', 'masr'),
                    'desc' => __('Gift registry\'s owner will get email with this content', 'masr'),
                    'id' => 'marsregistry_email_content',
                    'type' => 'textarea',
                    'autoload' => false
                ),

                array(
                    'type' => 'sectionend',
                    'id' => 'marsregistry_email_options',
                ),
            )
        );
        return $options;
    }
}

<?php

namespace Mas\Whatsapp;

class WcSetting extends \WC_Settings_Page
{
    public function __construct()
    {
        $this->id = 'maswa';
        $this->label = __('Whatsapp integration', 'maswa');

        add_filter('woocommerce_settings_tabs_array', array(
            $this,
            'add_settings_page'
        ), 20);
        add_action('woocommerce_settings_' . $this->id, array(
            $this,
            'output'
        ));
        add_action('woocommerce_settings_save_' . $this->id, array(
            $this,
            'save'
        ));
    }
    public function get_settings()
    {
        $options = apply_filters('woocommerce_maswa_settings', array(

                array(
                    'title' => __('Whatsapp integration option', 'maswa'),
                    'type' => 'title',
                    'id' => 'whatsapp_integration_options_title'
                ),
                array(
                    'title' => __('Time period to be considered as abandoned cart','maswa' ),
                    'desc' => __('Time period to be considered as abandoned cart , unit is minute.', 'maswa'),
                    'id' => 'maswa_abandoned_cart_period',
                    'default' => '40',
                    'type' => 'text',
                    'autoload' => false
                ) ,
                array(
                    'title' => __('Enable Whatsapp chat box','maswa' ),
                    'desc' => __('If this checkbox is checked then a chatbox will display on the botton right of website for customer sending message via Whatsapp.', 'maswa'),
                    'id' => 'maswa_chat_box_enable',
                    'type' => 'checkbox',
                    'autoload' => false
                ) ,
                array(
                    'title' => __('First message template','maswa' ),
                    'desc' => __('If customers abandon cart, this is first message template used to generate Whatsapp message', 'maswa'),
                    'id' => 'maswa_template_1',
                    'default' => 'This is temp 1',
                    'type' => 'textarea',
                    'autoload' => false
                ),
                array(
                    'title' => __('Second message template','maswa' ),
                    'desc' => __('If customers abandon cart, this is second message template used to generate Whatsapp message.', 'maswa'),
                    'id' => 'maswa_template_2',
                    'default' => 'This is tem 2',
                    'type' => 'textarea',
                    'autoload' => false
                )
            )
        );

        return $options;
    }

}
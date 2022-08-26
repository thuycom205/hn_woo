<?php
// About us
class Appart_contact_info extends WP_Widget {
    public function __construct()  { // 'About us' Widget Defined
        parent::__construct('contact_info', esc_html__('(Theme) Contact info', 'appart'), array(
            'description'   => esc_html__('About us widget by Appart', 'appart'),
            'classname'     => 'widget2 widget_contact'
        ));
    }

    // Front End
    public function widget($args, $instance) {
        $allowed_tags = array(
            'div' => array(
                'class' =>array(),
                'id' => array()
            ),
            'h4' => array(
                'class' =>array(),
                'id' => array()
            ),
            'h2' => array(
                'class' =>array(),
                'id' => array()
            ),
        );
        extract( $args );
        $title      = isset($instance['title']) ? $instance['title'] : '';
        $address    = isset($instance['address']) ? $instance['address'] : '';
        $email    = isset($instance['email']) ? $instance['email'] : '';
        $phone    = isset($instance['phone']) ? $instance['phone'] : '';
        echo wp_kses($args['before_widget'], $allowed_tags);
        echo wp_kses($args['before_title'], $allowed_tags).esc_html($title).wp_kses($args['after_title'], $allowed_tags);
        ?>
        <div class="widget_inner row m0">
            <ul>
                <li>
                    <i class="ti-location-pin"></i>
                    <div class="location_address fleft">
                        <?php echo wp_kses_post($address); ?>
                    </div>
                </li>
                <li>
                    <i class="ti-mobile"></i>
                    <div class="fleft contact_no">
                        <?php echo esc_html($phone); ?>
                    </div>
                </li>
                <li>
                    <i class="ti-email"></i>
                    <div class="fleft contact_mail">
                        <a href="mailto:<?php echo esc_attr($email) ?>"> <?php echo esc_html($email); ?> </a>
                    </div>
                </li>
            </ul>
        </div>
        <?php
        echo wp_kses($args['after_widget'], $allowed_tags);
    }

    // Backend
    function form( $instance ) {

        //
        // set defaults
        // -------------------------------------------------
        $instance   = wp_parse_args( $instance, array(
            'title'     => esc_html__('Contact Info', 'appart'),
            'email'     => '',
            'address'   => '',
            'phone'     => '',
        ));

        /**
         * Title field
         */
        $text_value = esc_attr( $instance['title'] );
        $text_field = array(
            'id'    => $this->get_field_name('title'),
            'name'  => $this->get_field_name('title'),
            'type'  => 'text',
            'title' => esc_html__('Title', 'appart')
        );
        echo cs_add_element( $text_field, $text_value );

        /**
         * Phone number field
         */
        $address_value = esc_attr( $instance['email'] );
        $address_field = array(
            'id'    => $this->get_field_name('email'),
            'name'  => $this->get_field_name('email'),
            'type'  => 'text',
            'title' => esc_html__('Email address', 'appart'),
        );
        echo cs_add_element( $address_field, $address_value );

        /**
         * Phone number field
         */
        $address_value = esc_attr( $instance['phone'] );
        $address_field = array(
            'id'    => $this->get_field_name('phone'),
            'name'  => $this->get_field_name('phone'),
            'type'  => 'text',
            'title' => esc_html__('Phone number', 'appart'),
        );
        echo cs_add_element( $address_field, $address_value );

        /**
         * Address field
         */
        $address_value = esc_attr( $instance['address'] );
        $address_field = array(
            'id'    => $this->get_field_name('address'),
            'name'  => $this->get_field_name('address'),
            'type'  => 'textarea',
            'title' => esc_html__('Address', 'appart'),
            'info'  => esc_html__('HTML supported', 'appart'),
            'sanitize' => 'disabled'
        );
        echo cs_add_element( $address_field, $address_value );
    }

    // Update Data
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['content'] = $new_instance['content'];
        $instance['address'] = $new_instance['address'];
        $instance['email']   = $new_instance['email'];
        $instance['phone']   = $new_instance['phone'];

        return $instance;
    }

}
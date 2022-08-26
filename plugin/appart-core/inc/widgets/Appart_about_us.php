<?php
// About us
class Appart_about_us extends WP_Widget {
    public function __construct()  { // 'About us' Widget Defined
        parent::__construct('about_us', esc_html__('(Theme) About us', 'appart'), array(
            'description'   => esc_html__('About us widget by Appart', 'appart'),
            'classname'     => 'widget1 about_us_widget'
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
        $logo = isset($instance['logo']) ? $instance['logo'] : '';
        $content = isset($instance['content']) ? $instance['content'] : '';
        $fcb_url  = isset($instance['fcb_url']) ? $instance['fcb_url'] : '';
        $twt_url  = isset($instance['twt_url']) ? $instance['twt_url'] : '';
        $rss_url  = isset($instance['rss_url']) ? $instance['rss_url'] : '';
        $pin_url  = isset($instance['pin_url']) ? $instance['pin_url'] : '';
        $dribble_url  = isset($instance['dribble_url']) ? $instance['dribble_url'] : '';
        $vimeo_url  = isset($instance['vimeo_url']) ? $instance['vimeo_url'] : '';
        $behance_url  = isset($instance['behance_url']) ? $instance['behance_url'] : '';
        $instagram_url  = isset($instance['instagram_url']) ? $instance['instagram_url'] : '';
        echo wp_kses($args['before_widget'], $allowed_tags);
        ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
            <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name') ?>">
        </a>
        <p> <?php echo esc_html($content) ?> </p>
        <ul class="nav social_icon row m0">
            <?php if(!empty($fcb_url)) : ?>
                <li><a href="<?php echo esc_url($fcb_url); ?>" title="<?php esc_attr_e('Faebook', 'appart') ?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(!empty($twt_url)) : ?>
                <li><a href="<?php echo esc_url($twt_url); ?>" title="<?php esc_attr_e('Twitter', 'appart') ?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if( ! empty($rss_url)) : ?>
                <li>
                    <a href="<?php echo esc_url($rss_url); ?>" title="<?php esc_attr_e('RSS', 'appart'); ?>">
                        <i class="fa fa-rss"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if( ! empty($pin_url) ) : ?>
                <li>
                    <a href="<?php echo esc_url($pin_url); ?>" title="<?php esc_attr_e('Pinterest', 'appart') ?>">
                        <i class="fa fa-pinterest"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if( ! empty($dribble_url) ) : ?>
                <li>
                    <a href="<?php echo esc_url($dribble_url); ?>" title="<?php esc_attr_e('Dribble', 'appart') ?>">
                        <i class="fa fa-dribbble"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if( ! empty($vimeo_url) ) : ?>
                <li>
                    <a href="<?php echo esc_url($vimeo_url); ?>" title="<?php esc_attr_e('Vimeo', 'appart') ?>">
                        <i class="fa fa-vimeo"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if( ! empty($behance_url) ) : ?>
                <li>
                    <a href="<?php echo esc_url($behance_url); ?>" title="<?php esc_attr_e('Behance', 'appart') ?>">
                        <i class="fa fa-behance"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if( ! empty($instagram_url) ) : ?>
                <li>
                    <a href="<?php echo esc_url($instagram_url); ?>" title="<?php esc_attr_e('Instagram', 'appart') ?>">
                        <i class="fa fa-instagram"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <?php

        echo wp_kses($args['after_widget'], $allowed_tags);
    }

    // Backend
    function form( $instance ) {

        //
        // set defaults
        // -------------------------------------------------
        $instance   = wp_parse_args( $instance, array(
            'logo'              => '',
            'content'           => '',
            'fcb_url'            => '',
            'twt_url'           => '',
            'rss_url'           => '',
            'pin_url'           => '',
            'dribble_url'       => '',
            'vimeo_url'         =>  '',
            'behance_url'       => '',
            'instagram_url'     => '',
        ));

        //
        // upload field example
        // -------------------------------------------------
        $upload_value = esc_attr( $instance['logo'] );
        $upload_field = array(
            'id'    => $this->get_field_name('logo'),
            'name'  => $this->get_field_name('logo'),
            'type'  => 'upload',
            'title' => esc_html__('Logo', 'appart'),
            'desc'  => esc_html__('Upload here a image the About us widget logo.', 'appart'),
        );
        echo cs_add_element( $upload_field, $upload_value );

        //
        // textarea field example
        // -------------------------------------------------
        $textarea_value = esc_attr( $instance['content'] );
        $textarea_field = array(
            'id'    => $this->get_field_name('content'),
            'name'  => $this->get_field_name('content'),
            'type'  => 'textarea',
            'title' => esc_html__('Content', 'appart'),
            'info'  => esc_html__('Write here some description text.', 'appart')
        );
        echo cs_add_element( $textarea_field, $textarea_value );

        // Facebook url field
        // -------------------------------------------------
        $facebook_value  = esc_attr($instance['fb_url']);
        $facebook_field   = array(
            'id'          => $this->get_field_name('fcb_url'),
            'name'         => $this->get_field_name('fcb_url'),
            'type'         => 'text',
            'title'        => esc_html__('Facebook URL:', 'appart'),
            'info'         => esc_html__('Write your facebook url here', 'appart'),
        );
        echo cs_add_element($facebook_field, $facebook_value);

        // Twitter url field
        $twitter_value     = esc_attr($instance['twt_url']);
        $twitter_field      = array(
            'id'            => $this->get_field_name('twt_url'),
            'name'          => $this->get_field_name('twt_url'),
            'type'          => 'text',
            'title'         => esc_html__('Twitter URL:', 'appart'),
            'info'          => esc_html__('Write here your Twitter url', 'appart'),
        );
        echo cs_add_element($twitter_field, $twitter_value);

        // RSS url field
        $rss_value     = esc_attr($instance['rss_url']);
        $rss_field      = array(
            'id'            => $this->get_field_name('rss_url'),
            'name'          => $this->get_field_name('rss_url'),
            'type'          => 'text',
            'title'         => esc_html__('Rss URL:', 'appart'),
            'info'          => esc_html__('Write here your RSS url', 'appart'),
        );
        echo cs_add_element($rss_field, $rss_value);

        // Pinterest url field
        $pin_value     = esc_attr($instance['rss_url']);
        $pin_field      = array(
            'id'            => $this->get_field_name('pin_url'),
            'name'          => $this->get_field_name('pin_url'),
            'type'          => 'text',
            'title'         => esc_html__('Pinterest URL:', 'appart'),
            'info'          => esc_html__('Write here your Pinterest url', 'appart'),
        );
        echo cs_add_element($pin_field, $pin_value);

        // Dribble url field
        $dribble_value     = esc_attr($instance['dribble_url']);
        $dribble_field      = array(
            'id'            => $this->get_field_name('dribble_url'),
            'name'          => $this->get_field_name('dribble_url'),
            'type'          => 'text',
            'title'         => esc_html__('Dribble URL:', 'appart'),
            'info'          => esc_html__('Write here your Dribble url', 'appart'),
        );
        echo cs_add_element($dribble_field, $dribble_value);

        // Vimeo url field
        $vimeo_value     = esc_attr($instance['vimeo_url']);
        $vimeo_field      = array(
            'id'            => $this->get_field_name('vimeo_url'),
            'name'          => $this->get_field_name('vimeo_url'),
            'type'          => 'text',
            'title'         => esc_html__('Vimeo URL:', 'appart'),
            'info'          => esc_html__('Write here your Vimeo url', 'appart'),
        );
        echo cs_add_element($vimeo_field, $vimeo_value);

        // Behance url field
        $behance_value     = esc_attr($instance['behance_url']);
        $behance_field      = array(
            'id'            => $this->get_field_name('behance_url'),
            'name'          => $this->get_field_name('behance_url'),
            'type'          => 'text',
            'title'         => esc_html__('Behance URL:', 'appart'),
            'info'          => esc_html__('Write here your Behance url', 'appart'),
        );
        echo cs_add_element($behance_field, $behance_value);

        // Instagram url field
        $instagram_value     = esc_attr($instance['instagram_url']);
        $instagram_field      = array(
            'id'            => $this->get_field_name('instagram_url'),
            'name'          => $this->get_field_name('instagram_url'),
            'type'          => 'text',
            'title'         => esc_html__('Instagram URL:', 'appart'),
            'info'          => esc_html__('Write here your Instagram url', 'appart'),
        );
        echo cs_add_element($instagram_field, $instagram_value);
    }

    // Update Data
    public function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['content'] = $new_instance['content'];
        $instance['logo'] = $new_instance['logo'];
        $instance['fcb_url'] = $new_instance['fcb_url'];
        $instance['twt_url']    = $new_instance['twt_url'];
        $instance['rss_url']    = $new_instance['rss_url'];
        $instance['pin_url']    = $new_instance['pin_url'];
        $instance['dribble_url']    = $new_instance['dribble_url'];
        $instance['vimeo_url']    = $new_instance['vimeo_url'];
        $instance['behance_url']    = $new_instance['behance_url'];
        $instance['instagram_url']    = $new_instance['instagram_url'];
        return $instance;
    }

}
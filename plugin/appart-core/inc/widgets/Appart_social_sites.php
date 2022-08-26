<?php
// About us
class Appart_social_sites extends WP_Widget {
	public function __construct()  { // 'About us' Widget Defined
		parent::__construct('social_site_links', esc_html__('(Theme) Social site links', 'appart'), array(
			'description'   => esc_html__('Display your social site links', 'appart'),
			'classname'     => 'widget4 widget_social'
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
		$facebook_url    = isset($instance['facebook_url']) ? $instance['facebook_url'] : '';
		$twitter_url    = isset($instance['twitter_url']) ? $instance['twitter_url'] : '';
		$google_plus_url    = isset($instance['google_plus_url']) ? $instance['google_plus_url'] : '';
		$linkedin_url    = isset($instance['linkedin_url']) ? $instance['linkedin_url'] : '';
		$pinterest_url    = isset($instance['pinterest_url']) ? $instance['pinterest_url'] : '';
		$instagram_url    = isset($instance['instagram_url']) ? $instance['instagram_url'] : '';
		$behance_url    = isset($instance['behance_url']) ? $instance['behance_url'] : '';
		echo wp_kses($args['before_widget'], $allowed_tags);
		echo wp_kses($args['before_title'], $allowed_tags).esc_html($title).wp_kses($args['after_title'], $allowed_tags);
		?>
		<ul class="social-icon">
			<?php if(!empty($instance['facebook_url'])) : ?>
			<li><a href="<?php echo esc_url($instance['facebook_url']) ?>"><i class="fa fa-facebook"></i>Facebook</a></li>
			<?php endif; ?>

			<?php if(!empty($instance['twitter_url'])) : ?>
			<li><a href="<?php echo esc_url($instance['twitter_url']) ?>"><i class="fa fa-twitter"></i> <?php esc_html_e('Twitter', 'appart'); ?> </a></li>
			<?php endif; ?>

			<?php if(!empty($instance['google_plus_url'])) : ?>
			<li><a href="<?php echo esc_url($instance['google_plus_url']) ?>"><i class="fa fa-google-plus"></i> <?php esc_html_e('Google plus', 'appart'); ?> </a></li>
			<?php endif; ?>

			<?php if(!empty($instance['instagram_url'])) : ?>
			<li><a href="<?php echo esc_url($instance['instagram_url']) ?>"><i class="fa fa-instagram"></i> <?php esc_html_e('Instagram', 'appart') ?> </a></li>
			<?php endif; ?>

			<?php if(!empty($instance['linkedin_url'])) : ?>
			<li><a href="<?php echo esc_url($instance['linkedin_url']) ?>"><i class="fa fa-linkedin"></i> <?php esc_html_e('Linkedin', 'appart') ?> </a></li>
			<?php endif; ?>

			<?php if(!empty($instance['pinterest_url'])) : ?>
			<li><a href="<?php echo esc_url($instance['pinterest_url']) ?>"><i class="fa fa-pinterest"></i> <?php esc_html_e('Pinterest', 'appart'); ?> </a></li>
			<?php endif; ?>

			<?php if(!empty($instance['behance_url'])) : ?>
			<li><a href="<?php echo esc_url($instance['behance_url']) ?>"><i class="fa fa-behance"></i> <?php esc_html_e('Behance', 'appart'); ?> </a></li>
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
			'title'     => esc_html__('Social Link', 'appart'),
			'facebook_url'      => '#',
			'twitter_url'       => '',
			'google_plus_url'   => '',
			'linkedin_url'      => '#',
			'pinterest_url'     => '#',
			'instagram_url'     => '#',
			'behance_url'       => '#',
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

		$facebook_url_value = esc_attr( $instance['facebook_url'] );
		$facebook_url = array(
			'id'    => $this->get_field_name('facebook_url'),
			'name'  => $this->get_field_name('facebook_url'),
			'type'  => 'text',
			'title' => esc_html__('Facebook URL', 'appart'),
		);
		echo cs_add_element( $facebook_url, $facebook_url_value );

		$twitter_url_value = esc_attr( $instance['twitter_url'] );
		$twitter_url = array(
			'id'    => $this->get_field_name('twitter_url'),
			'name'  => $this->get_field_name('twitter_url'),
			'type'  => 'text',
			'title' => esc_html__('Twitter URL', 'appart'),
		);
		echo cs_add_element( $twitter_url, $twitter_url_value );

		$google_plus_url_value = esc_attr( $instance['google_plus_url'] );
		$google_plus_url = array(
			'id'    => $this->get_field_name('google_plus_url'),
			'name'  => $this->get_field_name('google_plus_url'),
			'type'  => 'text',
			'title' => esc_html__('Google plus URL', 'appart'),
		);
		echo cs_add_element( $google_plus_url, $google_plus_url_value );

		$linkedin_url_value = esc_attr( $instance['linkedin_url'] );
		$linkedin_url = array(
			'id'    => $this->get_field_name('linkedin_url'),
			'name'  => $this->get_field_name('linkedin_url'),
			'type'  => 'text',
			'title' => esc_html__('Linkedin URL', 'appart'),
		);
		echo cs_add_element( $linkedin_url, $linkedin_url_value );

		$pinterest_url_value = esc_attr( $instance['pinterest_url'] );
		$pinterest_url = array(
			'id'    => $this->get_field_name('pinterest_url'),
			'name'  => $this->get_field_name('pinterest_url'),
			'type'  => 'text',
			'title' => esc_html__('Pinterest URL', 'appart'),
		);
		echo cs_add_element( $pinterest_url, $pinterest_url_value );

		$instagram_url_value = esc_attr( $instance['instagram_url'] );
		$instagram_url = array(
			'id'    => $this->get_field_name('instagram_url'),
			'name'  => $this->get_field_name('instagram_url'),
			'type'  => 'text',
			'title' => esc_html__('Instagram URL', 'appart'),
		);
		echo cs_add_element( $instagram_url, $instagram_url_value );

		$behance_url_value = esc_attr( $instance['behance_url'] );
		$behance_url = array(
			'id'    => $this->get_field_name('behance_url'),
			'name'  => $this->get_field_name('behance_url'),
			'type'  => 'text',
			'title' => esc_html__('Behance URL', 'appart'),
		);
		echo cs_add_element( $behance_url, $behance_url_value );

	}

	// Update Data
	public function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['facebook_url'] = $new_instance['facebook_url'];
		$instance['twitter_url'] = $new_instance['twitter_url'];
		$instance['google_plus_url'] = $new_instance['google_plus_url'];
		$instance['linkedin_url'] = $new_instance['linkedin_url'];
		$instance['pinterest_url'] = $new_instance['pinterest_url'];
		$instance['instagram_url']   = $new_instance['instagram_url'];
		$instance['behance_url']   = $new_instance['behance_url'];

		return $instance;
	}

}
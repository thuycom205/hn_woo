<?php
/**
 * Add Instagram_Widget widget.
 */
class Instagram_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     *
     **/
    function __construct() {
        parent::__construct(
            'instagram', // Base ID
            __('Instagram Feed', 'acrony-core'), // Name
            array( 'description' => __( 'Show Instagram feed to adding this widget.', 'acrony-core' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        if (! empty($total_items)) {
            echo "<p>".$instance['total_items']."</p>";
        }
        $widget_rand_id = rand(369,963);
		wp_enqueue_script( 'instafeed', plugins_url( '/assets/js/instafeed-min.js',dirname(__FILE__)), array('jquery'), '1.0.0', true );
        ?>
        <ul class="instagram" id="instagram-<?php echo $widget_rand_id; ?>"></ul>
        <script>
            jQuery(document).ready(function(){
                var feed = new Instafeed({
                    get: 'user',
                    userId: <?php if(isset($instance['user_id'])){echo $instance['user_id'];} ?>,
                    accessToken: '<?php if(isset($instance['access_token'])){echo $instance['access_token'];} ?>',
                    target: 'instagram-<?php echo $widget_rand_id; ?>',
                    limit: <?php if(isset($instance['total_items'])){ echo $instance['total_items'];} ?>, //max 60 images..
                    resolution: 'low_resolution', // Thumbnail, low_resolution, standard_resolution
                    template: '<li><a href="{{link}}"><img src="{{image}}" /></a></li>',
                    after: function () {
                        var el = document.getElementById('instagram-<?php echo $widget_rand_id; ?>');
                        if (el.classList)
                            el.classList.add('open');
                        else
                            el.className += ' ' + 'open';
                    }
                });
                feed.run();
            });
        </script>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'Instagram', 'acrony-core' );
        }

        if (isset($instance['user_id'])) {
            $user_id = $instance[ 'user_id' ];
        }else{
            $user_id = 11439846407;
        }

        if (isset($instance['access_token'])) {
            $access_token = $instance[ 'access_token' ];
        }else{
            $access_token = "11439846407.1677ed0.1ada3f9dbc4a44fc8f31de65bdbc7445";
        }

        if (isset($instance['total_items'])) {
            $total_items = $instance[ 'total_items' ];
        }else{
            $total_items = 9;
        }

        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','acrony-core' ); ?></label> 
        <input 
            class="widefat" 
            id="<?php echo $this->get_field_id( 'title' ); ?>" 
            name="<?php echo $this->get_field_name( 'title' ); ?>" 
            type="text" 
            value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php echo sprintf( __( 'Instagram <a target="_blank" href="%s">User ID</a>:','acrony-core' ),'https://codeofaninja.com/tools/find-instagram-user-id'); ?></label> 
        <input 
            class="widefat" 
            id="<?php echo $this->get_field_id( 'user_id' ); ?>" 
            name="<?php echo $this->get_field_name( 'user_id' ); ?>" 
            type="text" 
            value="<?php echo esc_attr( $user_id ); ?>">
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php echo sprintf( __( 'Instagram <a target="_blank" href="%s">Access Token</a>:','acrony-core' ),'https://instagram.pixelunion.net/'); ?></label> 
        <input 
            class="widefat" 
            id="<?php echo $this->get_field_id( 'access_token' ); ?>" 
            name="<?php echo $this->get_field_name( 'access_token' ); ?>" 
            type="text" 
            value="<?php echo esc_attr( $access_token ); ?>">
        </p>
        <p>

        <label for="<?php echo $this->get_field_id( 'total_items' ); ?>"><?php _e( 'Total Photo Show:','acrony-core' ); ?></label> 
        <input 
            class="widefat" 
            id="<?php echo $this->get_field_id( 'total_items' ); ?>" 
            name="<?php echo $this->get_field_name( 'total_items' ); ?>" 
            type="number" 
            value="<?php echo esc_attr( $total_items ); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['user_id'] = ( ! empty( $new_instance['user_id'] ) ) ? strip_tags( $new_instance['user_id'] ) : '';
        $instance['access_token'] = ( ! empty( $new_instance['access_token'] ) ) ? strip_tags( $new_instance['access_token'] ) : '';
        $instance['total_items'] = ( ! empty( $new_instance['total_items'] ) ) ? strip_tags( $new_instance['total_items'] ) : '';

        return $instance;
    }
}

function acronycore_instagram_widget(){
	register_widget( 'Instagram_Widget' );
}
add_action( 'widgets_init', 'acronycore_instagram_widget' );
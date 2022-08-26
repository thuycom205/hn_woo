<?php
// Creating the widget 
class acrony_address_widget extends WP_Widget {
 
function __construct() {
parent::__construct(
 
// Base ID of your widget
'acrony_address_widget', 
 
// Widget name will appear in UI
__('Acrony Address Widget', 'acrony-core'), 
 
// Widget description
array( 'description' => __( 'Acrony Address Information', 'acrony-core' ), ) 
);
} 
// Creating widget front-end 
public function widget( $args, $instance ) {
$title = $location = $mail = $phone = $website = '';
$title = apply_filters( 'widget_title', $instance['title'] );
$location = ( isset($instance['location']) ? $instance['location'] : '' );
$mail = ( isset($instance['mail']) ? $instance['mail'] : '' );
$phone = ( isset($instance['phone']) ? $instance['phone'] : '' );
$website = ( isset($instance['website']) ? $instance['website'] : '' );
 
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) ):
echo $args['before_title'] . $title . $args['after_title'];
endif;
    ?>
    <ul class="icon-list">
       <?php if( !empty($location) && isset($location) && $location != '' ): ?>
        <li>
            <div class="icon">
                <i class="fa fa-map-signs"></i>
            </div><?php echo wp_kses($location, wp_kses_allowed_html('post')) ?></li>
        <?php endif; ?>
        
       <?php if( !empty($mail) && isset($mail) && $mail != '' ): ?>
        <li>
            <div class="icon">
                <i class="fa fa-envelope"></i>
            </div><?php echo wp_kses($mail, wp_kses_allowed_html('post')) ?></li>
        <?php endif; ?>        
       <?php if( !empty($phone) && isset($phone) && $phone != '' ): ?>
        <li>
            <div class="icon">
                <i class="fa fa-phone-square"></i>
            </div><?php echo wp_kses($phone, wp_kses_allowed_html('post')) ?>
        </li>
        <?php endif; ?> 
       <?php if( !empty($website) && isset($website) && $website != '' ): ?>
        <li>
            <div class="icon">
                <i class="fa fa-globe"></i>
            </div><?php echo wp_kses($website, wp_kses_allowed_html('post')) ?>
        </li>
        <?php endif; ?>
    </ul>
    <?php    
echo $args['after_widget'];
}         
// Widget Backend 
public function form( $instance ) {    
    
$title = (isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '' );
$location = (isset( $instance[ 'location' ] ) ? $instance[ 'location' ] : '' );
$mail = (isset( $instance[ 'mail' ] ) ? $instance[ 'mail' ] :  '' );
$phone = (isset( $instance[ 'phone' ] ) ? $instance[ 'phone' ] : '' );
$website = (isset( $instance[ 'website' ] ) ? $instance[ 'website' ] : '' );

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','acrony-core' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'location' ); ?>"><?php esc_html_e( 'Location:','acrony-core' ); ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>" value="<?php echo esc_attr( $location ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'mail' ); ?>"><?php esc_html_e( 'Mail:','acrony-core' ); ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'mail' ); ?>" name="<?php echo $this->get_field_name( 'mail' ); ?>" value="<?php echo esc_attr( $mail ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php esc_html_e( 'Phone:','acrony-core' ); ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo esc_attr( $phone ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'website' ); ?>"><?php esc_html_e( 'Website:','acrony-core' ); ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'website' ); ?>" name="<?php echo $this->get_field_name( 'website' ); ?>" value="<?php echo esc_attr( $website ); ?>">
</p>
<?php 
}     
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['location'] = ( ! empty( $new_instance['location'] ) ) ? strip_tags( $new_instance['location'] ) : '';
$instance['mail'] = ( ! empty( $new_instance['mail'] ) ) ? strip_tags( $new_instance['mail'] ) : '';
$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : '';
$instance['website'] = ( ! empty( $new_instance['website'] ) ) ? strip_tags( $new_instance['website'] ) : '';
return $instance;
}
} // Class acrony_address_widget ends here


<?php
namespace DROIT_ELEMENTOR\WPML;

if( !class_exists('WPML_Elementor_Module_With_Items') ) {
    return;
}

use WPML_Elementor_Module_With_Items;

defined( 'ABSPATH' ) || die();

class Animated_Text extends WPML_Elementor_Module_With_Items {

    /**
     * @return string
     */
    public function get_items_field() {
        return '_dl_animated_heading_repeater';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return [ '_dl_animated_heading_repeater_text' ];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case '_dl_animated_heading_repeater_text':
                return __( 'Enter Text', 'droit-addons' );
            default:
                return '';
        }
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_editor_type( $field ) {
        switch ( $field ) {
            case '_dl_animated_heading_repeater_text':
                return 'LINE';
            default:
                return '';
        }
    }

}
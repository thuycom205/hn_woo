<?php
namespace DROIT_ELEMENTOR\WPML;

if( !class_exists('WPML_Elementor_Module_With_Items') ) {
    return;
}

use WPML_Elementor_Module_With_Items;

defined( 'ABSPATH' ) || die();

class Testimonial extends WPML_Elementor_Module_With_Items {

    /**
     * @return string
     */
    public function get_items_field() {
        return 'testimonial_list';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return [ 'testimonial_heading', 'testimonial_name', 'testimonial_designation', 'testimonial_text' ];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case 'testimonial_heading':
                return __( 'Enter Heading', 'droit-addons' );
            case 'testimonial_name':
                return __( 'Enter Name', 'droit-addons' );
            case 'testimonial_designation':
                return __( 'Enter Designation', 'droit-addons' );
            case 'testimonial_text':
                return __( 'Enter Content', 'droit-addons' );
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
            case 'testimonial_heading':
                return 'LINE';
            case 'testimonial_name':
                return 'LINE';
            case 'testimonial_designation':
                return 'LINE';
            case 'testimonial_text':
                return 'LINE';
            default:
                return '';
        }
    }



}
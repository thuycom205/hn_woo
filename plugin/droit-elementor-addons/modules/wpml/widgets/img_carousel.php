<?php
namespace DROIT_ELEMENTOR\WPML;

if( !class_exists('WPML_Elementor_Module_With_Items') ) {
    return;
}

use WPML_Elementor_Module_With_Items;

defined( 'ABSPATH' ) || die();

class Img_Carousel extends WPML_Elementor_Module_With_Items {

    /**
     * @return string
     */
    public function get_items_field() {
        return 'droit-img-carousel';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return [ '_dl_pro_testimonial_name', '_dl_pro_testimonial_text' ];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case '_dl_pro_testimonial_name':
                return __( 'Enter your title', 'droit-addons' );
            case '_dl_pro_testimonial_text':
                return __( 'Enter your description', 'droit-addons' );
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
            case '_dl_pro_testimonial_name':
                return 'LINE';
            case '_dl_pro_testimonial_text':
                return 'AREA';
            default:
                return '';
        }
    }


}
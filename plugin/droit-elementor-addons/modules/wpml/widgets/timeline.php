<?php
namespace DROIT_ELEMENTOR\WPML;

use WPML_Elementor_Module_With_Items;
if( !class_exists('WPML_Elementor_Module_With_Items') ) {
    return;
}


defined( 'ABSPATH' ) || die();

class Timeline extends WPML_Elementor_Module_With_Items {

    /**
     * @return string
     */
    public function get_items_field() {
        return 'droit-timeline';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return [ '_dl_timeline_title', '_dl_timeline_desc' ];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case '_dl_timeline_title':
                return __( 'Enter media name', 'droit-addons' );
            case '_dl_timeline_desc':
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
            case '_dl_timeline_title':
                return __( 'Enter media name', 'droit-addons' );
            case '_dl_timeline_desc':
                return __( 'Enter your description', 'droit-addons' );
            default:
                return '';
        }
    }



}
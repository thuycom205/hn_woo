<?php
namespace DROIT_ELEMENTOR\WPML;

if( !class_exists('WPML_Elementor_Module_With_Items') ) {
    return;
}

use WPML_Elementor_Module_With_Items;

defined( 'ABSPATH' ) || die();

class Process extends WPML_Elementor_Module_With_Items {

    /**
     * @return string
     */
    public function get_items_field() {
        return '_dl_process_lists';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return [ '_dl_process_title', '_dl_process_description_text' ];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case '_dl_process_title':
                return __( 'Enter your title', 'droit-addons' );
            case '_dl_process_description_text':
                return __( 'Enter your Description', 'droit-addons' );
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
            case '_dl_process_title':
                return 'LINE';
            case '_dl_process_description_text':
                return 'AREA';
            default:
                return '';
        }
    }

}
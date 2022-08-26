<?php
namespace DROIT_ELEMENTOR\WPML;

if( !class_exists('WPML_Elementor_Module_With_Items') ) {
    return;
}

use WPML_Elementor_Module_With_Items;

defined( 'ABSPATH' ) || die();

class Share_Buttons extends WPML_Elementor_Module_With_Items {

    /**
     * @return string
     */
    public function get_items_field() {
        return '_dl_share_buttons_lists';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return [ '_dl_share_buttons_label' ];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case '_dl_share_buttons_label':
                return __( 'Enter media name', 'droit-addons' );
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
            case '_dl_share_buttons_label':
                return 'LINE';
            default:
                return '';
        }
    }
}
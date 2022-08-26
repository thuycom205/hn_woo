<?php
namespace DROIT_ELEMENTOR\WPML;

if( !class_exists('WPML_Elementor_Module_With_Items') ) {
    return;
}

use WPML_Elementor_Module_With_Items;

defined( 'ABSPATH' ) || die();

class Bar_Chart extends WPML_Elementor_Module_With_Items {

    /**
     * @return string
     */
    public function get_items_field() {
        return 'dl_barchart_dataset_list';
    }

    /**
     * @return array
     */
    public function get_fields() {
        return [ 'dl_barchart_dataset_label' ];
    }

    /**
     * @param string $field
     * @return string
     */
    protected function get_title( $field ) {
        switch ( $field ) {
            case 'dl_barchart_dataset_label':
                return __( 'Enter Label', 'droit-addons' );
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
            case 'dl_barchart_dataset_label':
                return 'LINE';
            default:
                return '';
        }
    }



}
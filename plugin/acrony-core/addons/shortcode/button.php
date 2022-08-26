<?php
add_action( 'init','acrony_button_addons', 99 );
if( !function_exists('acrony_button_addons') ){
    function acrony_button_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(
                array(
                    'acrony_button' => array(
                        'name'      => esc_html__( 'Button','acrony-core' ),
                        'icon'      => 'acrony_icon  icon_button',
                        'category'  => 'Acrony',
                        'params'    => array(
                            'General' => array(
                                array(
                                    'name' => 'button_template',
                                    'label' => __('Button Template','acrony-core'),
                                    'type' => 'dropdown',
                                    'options' => array(
                                        'button_1' => esc_html__( 'Normal Button', 'acrony-core' ),
                                        'button_2' => esc_html__( 'Transparent Button', 'acrony-core' ),
                                    ),
                                    'value' => 'button_1',
                                    'description' => esc_html__('Default Select Template: Button 1','acrony-core'),
                                ),
                                array(
                                    'name'  => 'button_text',
                                    'label' => __( 'Button Text','acrony-core' ),
                                    'type'  => 'text',
                                    'value' => 'Button Text'
                                ),
                                array(
                                    'name' => 'button_event',
                                    'label' => __( 'Click Event','acrony-core' ),
                                    'type' => 'dropdown',
                                    'options' => array(
                                        'link' => __( 'Open Custom Link','acrony-core' ),
                                        'lightbox' => __( 'Open In Lightbox','acrony-core' )
                                    ),
                                    'description' => __( 'Select the click event when users click on the button.','acrony-core' )
                                ),
                                array(
                                    'name'  => 'button_link',
                                    'label' => __( 'Add Custom Link','acrony-core' ),
                                    'type'  => 'link',
                                    'description' => __('Add your relative URL. Each URL contains link, anchor text and target attributes.','acrony-core'),
                                    'relation' => array(
                                        'parent' => 'button_event',
                                        'show_when' => 'link'
                                    )
                                ),
                                array(
                                    'name' => 'popup_link',
                                    'type' => 'text',
                                    'label' => __( 'Image or Video URL','acrony-core' ),
                                    'description' => __( 'It will only supported Image, Youtube and Vimeo URL.','acrony-core' ),
                                    'relation' => array(
                                        'parent' => 'button_event',
                                        'show_when' => 'lightbox'
                                    )
                                    
                                ),
                                array(
                                    'name' => 'show_icon',
                                    'label' => __( 'Use Icon?','acrony-core' ),
                                    'type' => 'toggle'
                                ),
                                array(
                                    'name'      => 'button_icon',
                                    'label'     => __('Choose Icon','acrony-core'),
                                    'type'      => 'icon_picker',
                                    'relation'  => array(
                                        'parent'    => 'show_icon',
                                        'show_when' => 'yes'
                                    ),
                                    'description' => __( 'Select icon for button' , 'acrony-core' )
                                ),
                                array(
                                    'name' => 'extra_class',
                                    'label' => __( 'Button Extra Class','acrony-core' ),
                                    'description' => __('Add class name for a tag.','acrony-core'),
                                    'type' => 'text'
                                )
                            ),
                            'Styling' => array(
                                array(
                                    'name' => 'acrony_button_style',
                                    'type'    => 'css',
                                    'options' => array(
                                        array(
                                            "screens" => "any,1024,999,767,479",
                                            'Button' => array(
                                                array('property' => 'color', 'label' => 'Color'),
                                                array('property' => 'background', 'label' => 'Background'),
                                                array('property' => 'background-color', 'label' => 'Overlay BG','selector' => ':before'),
                                                array('property' => 'font-family', 'label' => 'Font Family'),
                                                array('property' => 'font-size', 'label' => 'Font Size'),
                                                array('property' => 'line-height', 'label' => 'Line Height'),
                                                array('property' => 'font-weight', 'label' => 'Font Weight'),
                                                array('property' => 'text-transform', 'label' => 'Text Transform'),
                                                array('property' => 'text-align', 'label' => 'Align'),
                                                array('property' => 'letter-spacing', 'label' => 'Letter Spacing'),
                                                array('property' => 'float', 'label' => 'Float'),
                                                array('property' => 'width', 'label' => 'Widht'),
                                                array('property' => 'height', 'label' => 'Height'),
                                                array('property' => 'display', 'label' => 'Display'),
                                                array('property' => 'border', 'label' => 'Border'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius'),
                                                array('property' => 'padding', 'label' => 'Padding'),
                                                array('property' => 'margin', 'label' => 'Margin') 
                                            ),                                        
                                            'Button Hover' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => ':hover'),
                                                array('property' => 'background', 'label' => 'Background', 'selector' => ':hover'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => ':hover'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => ':hover'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => ':hover'),
                                                array('property' => 'padding', 'label' => 'Padding', 'selector' => ':hover'),
                                                array('property' => 'margin', 'label' => 'Margin', 'selector' => ':hover')   
                                            ),
                                            'Icon' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => '.icon'),
                                                array('property' => 'background', 'label' => 'Background Color', 'selector' => '.icon'),
                                                array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.icon'),
                                                array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.icon'),
                                                array('property' => 'text-align', 'label' => 'Align', 'selector' => '.icon'),
                                                array('property' => 'float', 'label' => 'Float', 'selector' => '.icon'),
                                                array('property' => 'width', 'label' => 'Widht','selector' => '.icon'),
                                                array('property' => 'height', 'label' => 'Height', 'selector' => '.icon'),
                                                array('property' => 'display', 'label' => 'Display', 'selector' => '.icon'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => '.icon'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.icon'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.icon'),
                                                array('property' => 'padding', 'label' => 'Padding', 'selector' => '.icon'),
                                                array('property' => 'margin', 'label' => 'Margin', 'selector' => '.icon')
                                            ),
                                            'Hover Icon' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => ':hover .icon'),
                                                array('property' => 'background', 'label' => 'Background', 'selector' => ':hover .icon'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => ':hover .icon'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => ':hover .icon'),
                                            )
                                        )
                                    )                                
                                )
                            ),
                            'Animate' => array(
                                array(
                                    'name'    => 'animate',
                                    'type'    => 'animate'
                                )
                            )
                        )
                    )
                )
            );
        }
    }
    
}
 

if( !function_exists('acrony_button_content') ){
    function acrony_button_content( $attr, $content = '' ){
        
        //Addons Content Extract.
        extract($attr);
        
        // Default array Setup
        $data = $button_attr = $button_element = array();        
        
        // CSS Element Classes
        $button_classes         = apply_filters( 'kc-el-class', $attr );
        $button_classes[0]      = '';
        
        // Button Classes Set
        $button_classes[]       = ( !empty($button_template) ? esc_attr($button_template) : '' );
        $button_classes[]       = ( !empty($extra_class) ? esc_attr($extra_class) : '' );
        $button_classes[]       = 'bttn';
        
        // Lightbox Data Cullect and Setup
        if( $button_event == 'lightbox' ){
            $button_attr[] = ( !empty($popup_link) ? 'href="'.esc_url($popup_link).'"' : 'href="#"' );
            $button_attr[] = 'data-lity';
        }
        
        
        // Button Link Content Explode
        $button_link           = explode( '|',$button_link);
        
        if( $button_event == 'link' ){
            $button_attr[]     = ( !empty($button_link[0]) ? 'href="'.esc_url($button_link[0]).'"' : 'href="#"' );
            $button_attr[]     = ( !empty($button_link[1]) ? 'title="'.esc_html($button_link[1]).'"' : '' );
            $button_attr[]     = ( !empty($button_link[2]) ? 'target="'.esc_html($button_link[2]).'"' : '');
        }
        $button_attr[]         = ( !empty($button_classes) ? 'class="'.implode( ' ', $button_classes ).'"' : '' );
        
        // Button Contents
        $button_element[]      = ( (!empty($button_icon) and $show_icon == 'yes')  ? '<i class="icon '.esc_attr($button_icon).'"></i>' : '' );
        $button_element[]      = ( !empty($button_text) ? '<span>'.esc_html($button_text).'</span>' : '' );
        
        
        $data[] = '<a '.implode( ' ', $button_attr ).' >'.implode( '', $button_element ).'</a>';
        
        $data  = implode( ' ', $data );
        return $data;
        
    }
}
add_shortcode( 'acrony_button','acrony_button_content' );
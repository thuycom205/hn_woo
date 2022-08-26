<?php

add_action('init','acrony_big_button_addons',99);
if( !function_exists('acrony_big_button_addons')){
    function acrony_big_button_addons(){
        if(function_exists('kc_add_map')){
            kc_add_map(array(
                'acrony_big_button' => array(
                    'name' => esc_html('Big Button'),
                    'icon' => 'acrony_icon  icon_button',
                    'category' => 'Acrony',
                    'params' => array(
                        'General' => array(
                            array(
                                'name' => 'button_label',
                                'label' => esc_html__('Button Label',"acrony_toolkit"),
                                'type' => 'text',
                                'value' => 'Button Label',
                            ),
                            array(
                                'name' => 'button_text',
                                'label' => esc_html__('Button Text',"acrony_toolkit"),
                                'type' => 'text',
                                'value' => 'Button Text',
                            ),
                            array(
                                'name' => 'icon_switch',
                                'label' => esc_html__('Display Icon','acrony_toolkit'),
                                'type' => 'toggle'
                            ),
                            array(
                                'name' => 'button_icon',
                                'label' => esc_html__('Choose Icon','acrony_toolkit'),
                                'type' => 'icon_picker',
	                            'admin_label' => true,
                                'description' => esc_html__('Please choose your button icon.','acrony_toolkit'),
                                'relation' => array(
                                    'parent' => 'icon_switch',
                                    'show_when' => 'yes'
                                )
                            ),
                            array(
                                'name' => 'button_event',
                                'label' => esc_html__('Button On Event','acrony_toolkit'),
                                'type' => 'select',
                                'options' => array(
                                    'link' => esc_html('Link'),
                                    'lightbox' => esc_html('Lightbox'),
                                ),
                                'value' => 'link',
                                'description' => esc_html__('Default event is (link)','acrony_toolkit'),
                            ),
                            array(
                                'name' => 'button_link',
                                'label' => esc_html__('Button Link (URL)','acrony_toolkit'),
                                'type' => 'link',
                                'relation' => array(
                                    'parent' => 'button_event',
                                    'show_when' => 'link'
                                )
                            ),
                            array(
                                'name' => 'lightbox_link',
                                'label' => esc_html__('Lightbox Popup URL','acrony_toolkit'),
                                'type' => 'text',
                                'description' => esc_html('This lightbox will be supporting Image, YouTube Video URL, Vimeo Video URL Etc.'),
                                'relation' => array(
                                    'parent' => 'button_event',
                                    'show_when' => 'lightbox'
                                )
                            ),
                            array(
                                'name' => 'custom_class',
                                'label' => esc_html__('Custom class','acrony_toolkit'),
                                'type' => 'text',
                                'description' => esc_html__('Enter button extra class.','acrony_toolkit'),
                            )
                        ),
                        'Style' => array(
                            array(
                                'name' => 'acrony_button_style',
						        'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Button' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.ex-bttn'),
                                            array('property' => 'background', 'label' => 'Background', 'selector' => '.ex-bttn'),
                                            array('property' => 'background', 'label' => 'Hover Background', 'selector' => '.ex-bttn:hover'),
                                            array('property' => 'width', 'label' => 'Widht', 'selector' => ' ,.ex-bttn' ),
                                            array('property' => 'height', 'label' => 'Height', 'selector' => ' ,.ex-bttn' ),
                                            array('property' => 'display', 'label' => 'Display' ),
                                            array('property' => 'float', 'label' => 'Float' ),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.ex-bttn'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.ex-bttn'),
                                            array('property' => 'border', 'label' => 'Hover Border', 'selector' => '.ex-bttn:hover'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.ex-bttn'),
                                            array('property' => 'box-shadow', 'label' => 'Hover Shadow', 'selector' => '.ex-bttn:hover'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.ex-bttn'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.ex-bttn'),
                                            array('property' => 'margin', 'label' => 'Margin')                                            
                                        ),
                                        'Icon' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.ex-bttn .icon'),
                                            array('property' => 'color', 'label' => 'Hover Color','selector' => '.ex-bttn:hover .icon'),
                                            array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'background-color', 'label' => 'Hover BG Color', 'selector' => '.ex-bttn:hover .icon'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'width', 'label' => 'Widht','selector' => '.ex-bttn .icon'),
                                            array('property' => 'height', 'label' => 'Height', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.ex-bttn .icon'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.ex-bttn .icon')
                                        ),
                                        'Label' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.ex-bttn .button-label'),
                                            array('property' => 'color', 'label' => 'Hover Color','selector' => '.ex-bttn:hover .button-label'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'display', 'label' => 'Display', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.ex-bttn .button-label'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.ex-bttn .button-label')
                                        ),
                                        'Title' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.ex-bttn .button-text'),
                                            array('property' => 'color', 'label' => 'Hover Color','selector' => '.ex-bttn:hover .button-text'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'display', 'label' => 'Display', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.ex-bttn .button-text'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.ex-bttn .button-text')
                                        ),
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
            ));
        }
    }
}
    if( !function_exists('acrony_big_button_content')){
        function acrony_big_button_content( $atts, $content = '' ){

            extract(shortcode_atts(array(
                'button_text' => '',
                'button_label' => '',
                'icon_switch' => '',
                'button_icon' => '',
                'button_event' => '',
                'button_link' => '',
                'lightbox_link' => '',
                'custom_class' => ''
            ),$atts));            


            if( $icon_switch == 'yes' && !empty($button_icon) ){
                $button_icon = ' <span class="icon" ><i class="'.esc_attr($button_icon).'"></i></span> ';
            }else{
                $button_icon = '';
            }
            if( $button_event == 'link' && !empty($button_link) ){
                $button_link = explode('|',$button_link);                
                if( !empty($button_link[0] ) ){
                    $button_url = $button_link[0];
                }else {
                    $button_url = '#';
                }
                if( ! empty($button_link[1]) ){
                    $button_title = 'title="'.$button_link[1].'"';
                }else{
                    $button_title = '';
                }
                if( ! empty($button_link[2]) ){
                    $button_target = 'target="'.$button_link[2].'"';
                }else{
                    $button_target = '';
                }
            }
            if( $button_event == 'lightbox' ){
                if( ! empty($lightbox_link) ){
                    $button_url = $lightbox_link;
                    $data_lightbox = 'rel="prettyPhoto"';
                    $lightbox_class = 'kc-pretty-photo';
                    wp_enqueue_script('prettyPhoto');
                    wp_enqueue_style( 'prettyPhoto' );
                    
                }else{
                    $button_url = '#';
                }
                
            }
            if( !empty($custom_class) ){
                $custom_class = $custom_class;
            }else{
                $custom_class = '';
            }            
            $link_attr = array();
            $master_class = apply_filters( 'kc-el-class', $atts );
            $data = '';
            $link_attr['href'] = 'href="'.esc_url(( isset($button_url) and !empty($button_url) ? esc_url($button_url) : '#' )).'"';
            $link_attr['title'] = ( isset($button_title) and !empty($button_title) ? $button_title : '' );
            $link_attr['target'] = (isset($button_target) ? $button_target : '' );
            $link_attr['lightbox'] = (isset($data_lightbox) ? $data_lightbox : '');
            $link_attr['class'] = 'class="ex-bttn '.( isset($custom_class) and !empty($custom_class) ? $custom_class : '' ).' '.(isset($lightbox_class) ? $lightbox_class : '' ).'"';
            $data .= '<div class="'.esc_attr( implode( ' ', $master_class ) ).'" >';
            $data .= '<a '.implode(' ',$link_attr).' >';
            $data .= (isset($button_icon) ? $button_icon : '' );
            $data .= '<span class="content">';
            $data .= ( isset($button_label) ? '<span class="button-label" >'.esc_html($button_label).'</span>' : '' );
            $data .= ( isset($button_text) ? '<span class="button-text" >'.esc_html($button_text).'</span>' : '' );
            $data .= '</span>';
            $data .= '</a>';
            $data .= '</div>';
            return $data;
        }
    }
    add_shortcode('acrony_big_button','acrony_big_button_content');
?>
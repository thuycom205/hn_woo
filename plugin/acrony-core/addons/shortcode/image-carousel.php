<?php
add_action('init','acrony_carousel_addons',99);
if( ! function_exists('acrony_carousel_addons') ){
    function acrony_carousel_addons(){
        if(function_exists('kc_add_map')){
            kc_add_map(array(
                'acrony_carousel' => array(
                    'name' => esc_html__('Image Carousel','acrony-core'),
                    'icon' => 'acrony_icon carousel_icon',
                    'category' => 'Acrony',
                    'params' => array(
                        'General' => array(
                            array(
                                'name' => 'images',
                                'label' => esc_html__('Select Images','acrony-core'),
                                'type' => 'attach_images',
                                'description' => esc_html__('Select images from media library.','acrony-core')
                            ),
                            array(
                                'name' => 'image_size',
                                'label' => esc_html__('Image Size','acrony-core'),
                                'type' => 'select',
                                'options' => array(
                                    'full' => 'Full',
                                    'large' => 'Large',
                                    'medium' => 'Medium',
                                    'thumbnail' => 'Thumbnail'
                                ),
                                'description' => esc_html__('Select the image size whice size will show.','acrony-core'),
                                'value' => 'full'
                            ),
                            array(
                                'name' => 'items_number',
                                'label' => esc_html__('Items Per Slide','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 15,
                                    'show_input' => true
                                ),
                                'value' => 3,
                                'description' => esc_html__('The number of items displayed per slide (not apply for autoheight). Default is 3 items and 1 item on mobile.','acrony-core')
                            ),
                            array(
                                'name' => 'tablet',
                                'label' => esc_html__('Items On Tablet','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 10,
                                    'show_input' => true
                                ),
                                'value' => 2,
                                'description' => esc_html__('Display number of items per each slide (Tablet Screen)','acrony-core')
                            ),
                            array(
                                'name' => 'mobile',
                                'label' => esc_html__('Items On SmartPhone','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 5,
                                    'show_input' => true
                                ),
                                'value' => 1,
                                'description' => esc_html__('Display number of items per each slide (Mobile Screen)','acrony-core')
                            ),
                            array(
                                'name' => 'speed',
                                'label' => esc_html__('Speed','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 1500,
                                    'show_input' => true
                                ),
                                'value' => 500,
                                'description' => esc_html__('Set the speed at which auto playing sliders will transition (in second).','acrony-core')
                            ),
                            array(
                                'name' => 'delay',
                                'label' => esc_html__('Delay Time','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 15,
                                    'show_input' => true
                                ),
                                'value' => 8,
                                'description' => esc_html__('The delay time before moving on to a new slide.','acrony-core')
                            ),
                            array(
                                'name' => 'navigation',
                                'label' => esc_html__('Navigation','acrony-core'),
                                'type' => 'toggle'
                            ),
                            array(
                                'name' => 'pagination',
                                'label' => esc_html__('Pagination','acrony-core'),
                                'type' => 'toggle',
                                'description' => esc_html__('Show the pagination.','acrony-core')
                            ),
                            array(
                                'name' => 'auto_play',
                                'label' => esc_html__( 'Auto Play' , 'acrony-core' ),
                                'type' => 'toggle',
                                'description' => esc_html__('Add height to div "owl-wrapper-outer" so you can use diffrent heights on slides. Use it only for one item per page setting.','acrony-core'),
                            ),
                            array(
                                'name' => 'wrap_class',
                                'label' => esc_html__('Wrapper Class Name','acrony-core'),
                                'type' => 'text',
                                'description' => esc_html__('Custom class for wrapper of the shortcode widget.','acrony-core')
                            )
                        ),
                        'Styling' => array(
                            array(
                                'name' => 'acrony_carousel_image',
						        'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Boxes' => array(
                                            array('property' => 'background', 'label' => 'Background','selector' => '.owl-carousel .owl-wrapper-outer'),
									        array('property' => 'padding', 'label' => 'Padding','selector' => '.owl-carousel .owl-wrapper-outer'),
									        array('property' => 'margin', 'label' => 'Margin','selector' => '.owl-carousel .owl-wrapper-outer'),
									        array('property' => 'text-align', 'label' => 'Text Align','selector' => '.owl-carousel .owl-wrapper-outer')
                                        ),
                                        'Items' => array(
                                            array('property' => 'background', 'label' => 'Background', 'selector' => '.owl-carousel .owl-item .item'),
									        array('property' => 'padding', 'label' => 'Padding', 'selector' => '.owl-carousel .owl-item .item'),
									        array('property' => 'margin', 'label' => 'Margin', 'selector' => '.owl-carousel .owl-item .item'),
									        array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.owl-carousel .owl-item .item'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.owl-carousel .owl-item .item'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.owl-carousel .owl-item .item'),
                                            array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => '.owl-carousel .owl-item .item:hover'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.owl-carousel .owl-item .item'),
                                        ),
                                        'Arrow' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div:before'), 
                                            array('property' => 'color', 'label' => 'Hover Color', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div:hover:before'), 
                                            array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div'),  
                                            array('property' => 'background-color', 'label' => 'Hover Background Color', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div:hover'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div:before'),     
									        array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div:before'),   
                                            array('property' => 'width', 'label' => 'Width', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div'),     
									        array('property' => 'height', 'label' => 'Height', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div'),    
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div'),         
									        array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div'), 
                                            array('property' => 'padding', 'label' => 'Padding','selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div'),         
									        array('property' => 'margin', 'label' => 'Margin', 'selector' => '.owl-nav-arrow.owl-theme .owl-controls .owl-buttons div')
                                        ),                                        
                                        'Dots' => array(
                                            array('property' => 'width', 'label' =>  esc_html__('Width','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'height', 'label' =>  esc_html__('Height','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Dots Background','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Active Dot Background','acrony-core'), 'selector' => '.owl-controls .owl-page.active span:after' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'border-radius', 'label' =>  esc_html__('Border Radius','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Box Shadow','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                        ),                                        
                                        'Navigation' => array(
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Hover Color','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div:hover' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Background','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Hover Background','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div:hover' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'border-radius', 'label' =>  esc_html__('Border Radius','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Box Shadow','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'width', 'label' =>  esc_html__('Width','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'height', 'label' =>  esc_html__('Height','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                        )                                        
                                    )
                                )
                            )
                        ),
                        'animate' => array(
                            array(
                                'name'    => 'animate',
                                'type'    => 'animate'
                            )
                        ),
                    )
                )
            ));
        }
    }
}
if( !function_exists('acrony_carousel_content') ){
    function acrony_carousel_content($atts , $content = '' ){        
        $images = $image_size = $items_number = $item_on_tablet = $item_on_phone = '';
        $image_size 	= 'full';
        extract($atts);        
        $wrp_class 	= apply_filters( 'kc-el-class', $atts );        
        wp_enqueue_script( 'owl-carousel' );
        wp_enqueue_style( 'owl-theme' );
        wp_enqueue_style( 'owl-carousel' );
        wp_enqueue_style( 'acrony-image-carousel' );        
        $items_number = ( !empty($items_number) ? $items_number : 3 );
        $item_on_tablet = ( !empty($tablet) ? $tablet : 2 );
        $item_on_phone = ( !empty($mobile) ? $mobile : 1 );        
        if( !empty( $images ) ){
            $images = explode(',',$images);
        }        
        if( is_array($images) && !empty($images) ){
            foreach( $images as $image_id ){
                $attachment_data[] 		= wp_get_attachment_image( $image_id, $image_size );
            }
        }else{
            return '<div class="kc-carousel_images align-center" style="border:1px dashed #ccc;"><br /><h3>Carousel Images: '.__( 'No images upload', 'acrony-core' ).'</h3></div>';
        }        
        $element_attribute = array();
        $el_classes = array(
            'kc-carousel-images',
            'owl-carousel-images',
            'kc-sync1',
            $wrap_class
        );        
        $owl_option = array(
            'items' 		=> $items_number,
            'tablet' 	=> $item_on_tablet,
            'mobile' 	=> $item_on_phone,
            'speed' 		=> $speed,
            'navigation' 	=> $navigation,
            'pagination' 	=> $pagination,
            'delay' 		=> $delay,
            'autoplay' 		=> $auto_play
        );
        $owl_option = json_encode( $owl_option );        
        $element_attribute[] 	= 'class="'. esc_attr( implode( ' ', $el_classes ) ) .'"';
        $element_attribute[] 	= "data-owl-i-options='$owl_option'";        
        $data = '<div class="'.esc_attr( implode( ' ', $wrp_class ) ).'">';
        $data .= '<div '.implode(' ',$element_attribute).'>';
        ob_start();
        $i = 0;
        foreach( $attachment_data as $i => $image  ): ?>
            <div class="item">
                <?php echo  $attachment_data[$i]; ?>
            </div>
        <?php
        $i++;
        endforeach;        
        $data .= ob_get_clean(); 
        $data .= '</div>';
        $data .= '</div>';
        return $data;        
    }
}
add_shortcode('acrony_carousel','acrony_carousel_content');

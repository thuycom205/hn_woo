<?php
    add_action( 'cmb2_admin_init', 'acrony_register_post_metabox' );    
    function acrony_register_post_metabox() {        
        $prefix = '_acrony_';
     
        /*-- Page-Meta-Box-Fields --*/
        $acrony_page_meta = new_cmb2_box(array(
            'id'            => $prefix . 'page_options',
            'title'         => esc_html__('Page Options', 'acrony-core' ),
            'object_types'  => array( 'page' )
        ));  
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Transparent Menu:', 'acrony-core' ),
            'id'      => $prefix . 'transparent_menu',
            'type'    => 'checkbox',
            'description' => esc_html__('Check this field if you want transparent menu on this page.', 'acrony-core' )
        ));  
            
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Remove Page Header:', 'acrony-core' ),
            'id'      => $prefix . 'page_header',
            'type'    => 'checkbox',
            'description' => esc_html__('Check this field if you want remove page header on this page.', 'acrony-core' )
        ));
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Onepage Template:', 'acrony-core' ),
            'id'      => $prefix . 'one_page_template',
            'type'    => 'checkbox',
            'description' => esc_html__('Will this page use as a onepage template?', 'acrony-core' )
        ));
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Onepage Scroll:', 'acrony-core' ),
            'id'      => $prefix . 'one_page_scroll',
            'type'    => 'checkbox'
        ));
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Mainmenu Text Color', 'acrony-core' ),
            'id'      => $prefix . 'menu_text_color',
            'type'    => 'colorpicker',
            'options' => array(
            	'alpha' => true, // Make this a rgba color picker.
            ),
        ));
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Mainmenu Hover Text Color', 'acrony-core' ),
            'id'      => $prefix . 'menu_hover_text_color',
            'type'    => 'colorpicker',
            'options' => array(
            	'alpha' => true, // Make this a rgba color picker.
            ),
        ));  
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Mainmenu Background Color', 'acrony-core' ),
            'id'      => $prefix . 'menu_bg_color',
            'type'    => 'colorpicker',
            'options' => array(
            	'alpha' => true, // Make this a rgba color picker.
            ),
        ));
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Mainmenu Sticky BG Color', 'acrony-core' ),
            'id'      => $prefix . 'menu_sticky_bg_color',
            'type'    => 'colorpicker',
            'options' => array(
            	'alpha' => true, // Make this a rgba color picker.
            ),
        ));
        
        $acrony_page_meta->add_field(array(
            'name'    => esc_html__('Remove Footer Widget:', 'acrony-core' ),
            'id'      => $prefix . 'footer_widget',
            'type'    => 'checkbox',
            'description' => esc_html__('Check this field if you want remove footer widgets on this page.', 'acrony-core' )
        ));
                
        /*-- Post-Meta-Box-Content --*/
        $acrony_post_meta = new_cmb2_box( array(
            'id'           => $prefix.'post_metabox',
            'title'        => esc_html__('Additional Fields', 'acrony-core' ),
            'object_types' => array( 'post' ), // post type
        ) );
        
        $acrony_post_meta->add_field( array(
                'name'       => esc_html__( 'Photo Gallery',  'acrony-core'  ),
                'desc'       => esc_html__( 'This field for gallery images. This gallery show for select gallery format.',  'acrony-core'  ),
                'id'         => $prefix . 'post_gallery',
                'type'       => 'file_list',
                'text' => array(
                    'add_upload_files_text' => esc_html__('Add images', 'acrony-core' ), // default: "Add or Upload Files"
                ),
            )
        );
        
        $acrony_post_meta->add_field( array(
            'name' => esc_html__('Embed Video', 'acrony-core' ),
            'desc' => esc_html__('Enter a youtube, twitter, or instagram URL. Supports services listed at ', 'acrony-core' ).'<a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a> '.esc_html__('This video show for select video format', 'acrony-core' ),
            'id'   => $prefix . 'post_video_embed',
            'type' => 'oembed',
        ) );
        
        $acrony_post_meta->add_field( array(
            'name' => esc_html__('Embed Audio', 'acrony-core' ),
            'desc' => esc_html__('Enter a SoundCloud, Mixcloud, or ReverbNation etc URL. Supports services listed at ', 'acrony-core' ).'<a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a> '.esc_html__('This audio show for select audio format', 'acrony-core' ),
            'id'   => $prefix . 'post_audio_embed',
            'type' => 'oembed',
        ) );
        
        /*-- Protfolio-Meta-Box-Fields --*/
        $acrony_portfolio_meta = new_cmb2_box(array(
            'id'            => $prefix . 'portfolio_metabox',
            'title'         => esc_html__('Portfolio Entry Details','acrony-core'),
            'object_types'  => array( 'portfolio' )
        ));
                
        $acrony_portfolio_meta->add_field( array(
            'name' => __( 'Live link:', 'acrony-core' ),
            'id'   => $prefix . 'portfolio_live_link',
            'type' => 'text_url'
        ) );
                
        $acrony_portfolio_meta->add_field(array(
            'name'    => esc_html__('Author','acrony-core'),
            'id'      => $prefix . 'portfolio_quote_author',
            'type'    => 'text'
        )); 
                
        $acrony_portfolio_meta->add_field(array(
            'name'    => esc_html__('Date','acrony-core'),
            'id'      => $prefix . 'portfolio_date',
            'type'    => 'text_date'
        )); 
    }
    
    if( !function_exists("acrony_gallery_photo_list") ){
      function acrony_gallery_photo_list( $gallery_images, $img_size = 'acrony_blog_thumb' ) {
          if( empty($gallery_images) ){
              return false;
          }
            // Get the list of gallery
            $data = '<div class="post-photo-gallery media-content">';
            // Loop through them and output an image
            foreach ( (array) $gallery_images[0] as $image_id => $image_url ) {
                $data .= '<div class="gallery-item" >';
                $data .= wp_get_attachment_image( $image_id, $img_size );
                $data .= '</div>';
            }
            $data .= '</div>';
          return $data;
        }
    }
    
    if( !function_exists('acrony_video_embed_content') ){
        function acrony_video_embed_content($post_video_embed_url){
            if( empty($post_video_embed_url) ){
                return false;
            }
            return '<div class="media-content">'.wp_oembed_get( $post_video_embed_url ).'</div>';
        }
    }
    
    if( !function_exists('acrony_audio_embed_content') ){
        function acrony_audio_embed_content($post_audio_embed_url){
            if( empty($post_audio_embed_url) ){
                return false;
            }
            return '<div class="media-content">'.wp_oembed_get( $post_audio_embed_url ).'</div>';
        }
    }    
    if(!function_exists('acrony_admin_print_script')){
       function acrony_admin_print_script(){
            if( get_post_type() == 'post' ): ?>
<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).on('ready', function() {
            $('.cmb2-postbox .cmb-row').css({
                'border-bottom': 'none',
                'margin-bottom': '0'
            });
            $('#_acrony_post_metabox').hide(0);
            $('.cmb2-id--acrony-post-gallery').hide(0);
            $('.cmb2-id--acrony-post-video-embed').hide(0);
            $('.cmb2-id--acrony-post-audio-embed').hide(0);

            var id = $('input[name="post_format"]:checked').attr('id');

            if (id == 'post-format-gallery') {
                $('#_acrony_post_metabox').show(0);
                $('.cmb2-id--acrony-post-gallery').show();
            } else {
                $('.cmb2-id--acrony-post-gallery').hide();
            }
            if (id == 'post-format-video') {
                $('#_acrony_post_metabox').show(0);
                $('.cmb2-id--acrony-post-video-embed').show();
            } else {
                $('.cmb2-id--acrony-post-video-embed').hide();
            }
            if (id == 'post-format-audio') {
                $('#_acrony_post_metabox').show(0);
                $('.cmb2-id--acrony-post-audio-embed').show();
            } else {
                $('.cmb2-id--acrony-post-audio-embed').hide();
            }
            $('#post-formats-select .post-format').on('change', function() {
                $('#_acrony_post_metabox').hide(0);
                $('.cmb2-id--acrony-post-gallery').hide(0);
                $('.cmb2-id--acrony-post-video-embed').hide(0);
                $('.cmb2-id--acrony-post-audio-embed').hide(0);
                var id = $('input[name="post_format"]:checked').attr('id');
                if (id == 'post-format-gallery') {
                    $('#_acrony_post_metabox').show(0);
                    $('.cmb2-id--acrony-post-gallery').show();
                } else {
                    $('.cmb2-id--acrony-post-gallery').hide();
                }
                if (id == 'post-format-video') {
                    $('#_acrony_post_metabox').show(0);
                    $('.cmb2-id--acrony-post-video-embed').show();
                } else {
                    $('.cmb2-id--acrony-post-video-embed').hide();
                }
                if (id == 'post-format-audio') {
                    $('#_acrony_post_metabox').show(0);
                    $('.cmb2-id--acrony-post-audio-embed').show();
                } else {
                    $('.cmb2-id--acrony-post-audio-embed').hide();
                }
            });
        });
    }(jQuery));
</script>
<?php endif; 
       } 
    }
add_action( 'admin_print_scripts', 'acrony_admin_print_script',1000 );




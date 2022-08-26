<?php
if ( ! function_exists( 'acrony_header_post_meta' ) ) :
	function acrony_header_post_meta( $tmn = '', $cat = '' ) {
        $data = array();
        $data[] = '<div class="post-meta">';
        $data[] = '<span class="author meta-item"><span class="icon"><i title="'.esc_attr__( 'Post Author','acrony' ).'" class="fal fa-user"></i></span> '.get_the_author().'</span>';
        if( $tmn != 'none' ){
            $time_string = sprintf( wp_kses( '<time class="entry-date published updated" datetime="%1$s">%2$s</time>', wp_kses_allowed_html('post')),
                esc_attr( get_the_date( 'c' ) ),
                esc_html( get_the_date() )
            );
            $date_format = get_the_date('Y/m/d');
            $data[] = '<span class="meta-item"><i class="fal fa-calendar-alt"></i> <a href="'.esc_url(home_url($date_format)).'">'.$time_string.'</a></span>';        
        }
        
        // Category List.
        if ( 'post' === get_post_type() and $cat != 'none' ) {
            $data[] = '<span class="cat-list meta-item" ><i class="fal fa-folders"></i> '.get_the_category_list( ' , ', '' ).'</span>';
		}        
        $data[] = '</div>';
        
        $data = implode( ' ', $data );        
        return $data;        
	}
endif;


if ( ! function_exists( 'acrony_entry_footer' ) ) :
	function acrony_entry_footer() {
        
        $data   = array();
        $data[] = '<div class="post-footer-meta" >';
        // Post Date.
		$time_string = sprintf( wp_kses( '<time class="entry-date published updated" datetime="%1$s">%2$s</time>', wp_kses_allowed_html('post')),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
        $date_format = get_the_date('Y/m/d');
        $data[] = '<span class="post-date meta-item"><i title="'.esc_attr( 'Post publish date','acrony' ).'" class="fal fa-calendar-alt"></i> <a href="'.esc_url(home_url($date_format)).'">'.$time_string.'</a></span>';
        if ( 'post' === get_post_type() ) {
			$data[] = get_the_tag_list( '<span class="tags-list meta-item"><i title="'.esc_attr__('Tags','acrony').'" class="fal fa-tags"></i>',' , ','</span>'); 
		}        
        // Category List.
        if ( 'post' === get_post_type() and has_category() ) {
            $data[] = '<span class="tags-list meta-item"><i title="'.esc_attr__( 'Categorize','acrony' ).'" class="fal fa-folder-open"></i>'.get_the_category_list( ' &#44; ', '' ).'</span>';
		}
        if(current_user_can('edit_posts')){
            $data[] = '<span class="edit-post meta-item"><i title="'.esc_attr__( 'Edit this post','acrony' ).'" class="fal fa-pencil-ruler"></i> <a href="'.get_edit_post_link().'">'.esc_html__('Edit','acrony').'</a></span>';
        }
        $data[] = '</div>';        
        $data = implode( ' ', $data );        
        return $data;        
	}
endif;

if( !function_exists('acrony_author_meta') ){    
    function acrony_author_meta (){
        $data = '';
        $data .= '<div class="author-details">';
        $data .= '<div class="author-photo">';
        $data .= get_avatar( get_the_author_meta( 'ID' ) , 60 );
        $data .= '</div>';
        $data .= '<div class="author-name">';
        $data .= get_the_author_meta( 'display_name' );
        $data .= '</div>';
        $data .= '</div>';
        return $data;
    }
}


if ( ! function_exists( 'acrony_post_thumbnail' ) ) :
    function acrony_post_thumbnail( $thumb_size = 'acrony_blog_thumb' ) {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }
        if ( is_single() ) {
            // Is Single Page Attachment Content.
           printf( '<figure class="media-content">%s</figure>',get_the_post_thumbnail( '', $thumb_size )); 
        }else{
            // Is Post Page Attachment Content.
            printf( '<a class="media-content" href="%s" aria-hidden="true"><figure>%s</figure></a>', get_the_permalink(), get_the_post_thumbnail( '', $thumb_size ) );
        }
    }
endif;


if( !function_exists('acrony_post_footer_content') ){
    function post_footer_content(){
        ?>
    <div class="footer-content">
        <a href="<?php the_permalink(); ?>" class="read-more">
            <?php esc_html_e('Read More','acrony'); ?>
        </a>
        <?php 
                    if (! post_password_required() && ( comments_open() || get_comments_number() ) && get_comments_number() > 0) { 
                        $comment_count = get_comments_number_text(esc_html__('No comment','acrony'),esc_html__('1 Comment','acrony'),esc_html__('% Comments','acrony'));
                        $comment_count = '<span><i class="fal fa-comments"></i> '.esc_html($comment_count).'</span>'; 
                        printf( $comment_count , wp_kses_allowed_html('post') );
                    }
                ?> </div>
    <?php
    }
}
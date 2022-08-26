<div <?php post_class('post-single'); ?> >
    <?php     
        // Post-Attachment-function
        acrony_post_thumbnail('full');
    ?>
    <div class="post-content">
        <?php if(is_single() ): 
        /* translators: %s: Name of current post */
        the_content(
            sprintf(
                esc_html__( 'Continue reading %s', 'acrony' ),
                the_title( '<span class="screen-reader-text">', '</span>', false )
            )
        );
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'acrony' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span class="page-numbers" >',
            'link_after'  => '</span>',
            'next_or_number' => 'number',
            'nextpagelink'     => '<i class="fal fa-angle-right"></i>',
            'previouspagelink' => '<i class="fal fa-angle-left"></i>',
        ) );       
        ?>
        <?php else: ?>
        <?php
            the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            echo acrony_header_post_meta();
            echo wpautop(wp_trim_words( get_the_content(), 26, '[...]'));
            echo '<a href="'.get_the_permalink().'" class="read-more" >'.esc_html__('Read More','acrony').'</a>';
        endif; ?>
    </div>
</div>
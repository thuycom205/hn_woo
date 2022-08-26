<div <?php post_class(); ?> >  
    <?php
        the_content();
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
</div>
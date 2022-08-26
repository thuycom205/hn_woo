<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Acrony
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

    <div id="comments" class="comments-area">
        <?php 
            comment_form(array(
                'class_submit' => 'bttn-1'
            ));
        ?>
        <?php
            // If comments are closed and there are comments, let's leave a little note, shall we?
            if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'acrony' ); ?></p>
        <?php endif; ?>
        <?php if ( have_comments() ) : ?>
        <div class="comment-list-area">
            <h3 class="comments-title">
                <?php
                    $comments_number = get_comments_number();
                    if ( '1' === $comments_number ) {
                        /* translators: %s: post title */
                        printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'acrony' ), get_the_title() );
                    } else {
                        printf(
                            /* translators: 1: number of comments, 2: post title */
                            _nx(
                                '%1$s thought on &ldquo;%2$s&rdquo;',
                                '%1$s thoughts on &ldquo;%2$s&rdquo;',
                                $comments_number,
                                'comments title',
                                'acrony'
                            ),
                            number_format_i18n( $comments_number ),
                            get_the_title()
                        );
                    }
                ?>
            </h3>
            <div class="space-30"></div>
            <ol class="comment-list">
                <?php
                    wp_list_comments(
                        array(
                            'style'       => 'ul',
                            'short_ping'  => true,
                            'avatar_size' => 100
                        )
                    );
                ?>
            </ol>
            <?php 
                $paginet = array(
                    'prev_text' => '<i class="fal fa-angle-left"></i>',
                    'next_text' => '<i class="fal fa-angle-right"></i>',
                    'screen_reader_text' => ' ',
                    'type' => 'array',
                    'show_all' => true,
                );
                the_comments_pagination( $paginet );
            ?>
        </div>       
        <?php endif; // have_comments() ?>
    </div>
<!-- .comments-area -->
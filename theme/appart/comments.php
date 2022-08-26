<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package appart
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$is_comments = have_comments() ? 'have_comments' : 'no_comments';

?>

<section class="comment_area <?php echo esc_attr($is_comments); ?>" id="comments">

    <?php if ( have_comments() ) : ?>
        <div class="comments">
            <h2> <?php comments_number( ' ', esc_html__('1 Comment', 'appart'), esc_html__('% Comments', 'appart') ); ?> </h2>
            <?php
            the_comments_navigation();
            wp_list_comments(array(
                'style'      => 'ul',
                'short_ping' => true,
                'callback'	 => 'appart_comments'
            ));
            the_comments_navigation();
            ?>
        </div>
    <?php endif; ?>

    <div class="col-md-12">
        <div class="comment_text">
            <h2 class="comment-title"> <?php esc_html_e('Leave a comment', 'appart'); ?> </h2>
            <?php
            if(!is_user_logged_in()) { ?>
                <p> <?php esc_html_e('Sign in to post your comment or sign-up if you don\'t have any account.', 'appart'); ?> </p>
                <?php
            }
            ?>
        </div>
        <?php
        $commenter      = wp_get_current_commenter();
        $req            = get_option( 'require_name_email' );
        $aria_req       = ( $req ? " aria-required='true'" : '' );
        $fields =  array(
            'author' => '<input type="text" class="form-control" name="author" id="name" value="'.esc_attr($commenter['comment_author']).'" placeholder="'.esc_attr__('Name *', 'appart').'" '.$aria_req.'>',
            'email'	 => '<input type="email" class="form-control" name="email" id="email" value="'.esc_attr($commenter['comment_author_email']).'" placeholder="'.esc_attr__('Email *', 'appart').'" '.$aria_req.'>',
            'url'	 => '<input type="url" class="form-control" name="url" value="'.esc_attr($commenter['comment_author_url']).'" placeholder="'.esc_attr__('Website (Optional)', 'appart').'">',
        );
        $comments_args = array(
            'fields'                => apply_filters( 'comment_form_default_fields', $fields ),
            'class_form'            => 'contact-form',
            'class_submit'          => 'btn sub_btn',
            'title_reply'           => '',
            'comment_notes_before'  => '',
            'comment_field'         => '<textarea name="comment" class="form-control" placeholder="'.esc_attr__('Your Comment', 'appart').'"></textarea>',
            'comment_notes_after'   => '',
        );
        comment_form($comments_args);
        ?>
    </div>
</section>
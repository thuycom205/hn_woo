<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package appart
 */


// Image sizes
add_image_size('appart_350x360', 350, 360, true); // Products section's product thumbnail size
add_image_size('appart_350x400', 350, 400, true); // Product category thumbnail image
add_image_size('appart_80x80', 80, 80, true); // Testimonial author image
add_image_size('appart_570x340', 570, 340, true);
add_image_size('appart_100x80', 100, 80, true); // Recent posts widget post thumbnail size
add_image_size('appart_750x400', 750, 400, true);


// Pagination
function appart_pagination() {
    the_posts_pagination(array(
        'screen_reader_text' => ' ',
        'prev_text'          => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        'next_text'          => '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ));
}


// Comment list
function appart_comments($comment, $args, $depth){
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
    ?>
    <div class="media comment">
        <?php
        if(get_avatar($comment)) : ?>
        <div class="media-left">
            <?php echo get_avatar($comment, 70, null, null, array('class'=> 'img-circle')); ?>
        </div>
        <?php endif; ?>
        <div class="media-body">
            <h5 class="commenter-name"> <?php comment_author(); ?> </h5>
            <h6 class="comment_time"> <?php comment_time(get_option('date_format')); ?> </h6>
            <?php comment_text(); ?>
            <?php comment_reply_link(array_merge( $args, array('reply_text'=>'<i class="fa fa-reply"></i>'.esc_html__('Reply', 'appart'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
        </div>
    </div>
<?php
}


// Move the comment field to bottom
add_filter( 'comment_form_fields', function ( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
});


// Social Links
function appart_social_links() {
    $dribbble       = function_exists('cs_get_option') ? cs_get_option('dribbble') : '';
    $facebook       = function_exists('cs_get_option') ? cs_get_option('facebook') : '';
    $twitter        = function_exists('cs_get_option') ? cs_get_option('twitter') : '';
    $youtube        = function_exists('cs_get_option') ? cs_get_option('youtube') : '';
    $lnkedin        = function_exists('cs_get_option') ? cs_get_option('lnkedin') : '';
    $googleplus     = function_exists('cs_get_option') ? cs_get_option('googleplus') : '';
    $social_links   = function_exists('cs_get_option') ? cs_get_option('social_links') : '';
    ?>
        <?php if(!empty($facebook)) { ?>
            <li><a href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if(!empty($twitter)) { ?>
            <li><a href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if(!empty($dribbble)) { ?>
            <li><a href="<?php echo esc_url($dribbble); ?>"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if(!empty($youtube)) { ?>
            <li><a href="<?php echo esc_url($youtube); ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if(!empty($lnkedin)) { ?>
            <li><a href="<?php echo esc_url($lnkedin); ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php if(!empty($googleplus)) { ?>
            <li><a href="<?php echo esc_url($googleplus); ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
        <?php } ?>
        <?php
        if(is_array($social_links)) {
            foreach($social_links as $social_link) {
                echo '<li><a href="'.esc_url($social_link['social_link']).'"><i class="'.esc_attr($social_link['social_icon']).'" aria-hidden="true"></i></a></li>';
            }
        }
        ?>
<?php
}


// Search form
function appart_search_form($is_button=true) {
    ?>
    <div class="appart-search">
        <form class="form-wrapper search-form input-group" action="<?php echo esc_url(home_url('/')); ?>" _lpchecked="1">
            <input type="text" class="form-control" id="search" placeholder="<?php esc_attr_e('Search ...', 'appart'); ?>" name="s">
            <span class="input-group-addon"><button type="submit"><i class="ti-search"></i></button></span>
        </form>
        <?php if($is_button==true) { ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="home_btn"> <?php esc_html_e('Back to home Page', 'appart'); ?> </a>
        <?php } ?>
    </div>
    <?php
}

function appart_error_search_form($is_button=true) {
    ?>
    <div class="appart-search">
        <form class="form-wrapper" action="<?php echo esc_url(home_url('/')); ?>" _lpchecked="1">
            <input type="text" id="search" placeholder="<?php esc_attr_e('Search ...', 'appart'); ?>" name="s">
            <button type="submit" class="btn"><i class="fa fa-search"></i></button>
        </form>
        <?php if($is_button==true) { ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="home_btn"> <?php esc_html_e('Homepage', 'appart'); ?> </a>
        <?php } ?>
    </div>
    <?php
}


// add category nicenames in body and post class
function appart_post_class( $classes ) {
    global $post;
    if(!has_post_thumbnail()) {
        $classes[] = 'no-post-thumbnail';
    }
    return $classes;
}
add_filter( 'post_class', 'appart_post_class' );


// Body classes
add_filter( 'body_class', function($classes) {

    if(is_front_page()) {
        $classes[] = 'front-page';
    }elseif(is_tax('', 'product_cat')) {
        $classes[] = 'product_cat_archive';
    }
    return $classes;
});


// Limit latter length
function appart_limit_latter($string, $limit_length, $last_char='...') {
    if (strlen($string) > $limit_length) {
        echo substr($string, 0, $limit_length) . $last_char;
    }
    else {
        echo esc_html($string);
    }
}

// Day link to archive page
function appart_day_link() {
    $archive_year   = get_the_time('Y');
    $archive_month  = get_the_time('m');
    $archive_day    = get_the_time('d');
    echo get_day_link( $archive_year, $archive_month, $archive_day);
}


// Get comment count text
function appart_comment_count($post_id) {
    $comments_number = get_comments_number($post_id);
    if($comments_number == 0) {
        $comment_text = esc_html__('0 comment', 'appart');
    }elseif($comments_number == 1) {
        $comment_text = esc_html__('1 comment', 'appart');
    }elseif($comments_number > 1) {
        $comment_text = $comments_number.esc_html__(' Comments', 'appart');
    }
    echo esc_html($comment_text);
}


if(!function_exists('appart_wp_kses')) {
 
    function appart_wp_kses ( $data ) {
 
        $allow_html = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'p' => array(
                'cite' => array(),
                'title' => array(),
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(),
            'strong' => array(),
            'code' => array(),
            'li' => array(
                'class' => array(),
            ),
            'ol' => array(
                'class' => array(),
            ),
            'ul' => array(
                'class' => array(),
            ),
            'img' => array(
                'alt'    => array(),
                'class'  => array(),
                'height' => array(),
                'src'    => array(),
                'width'  => array(),
            ),
            'span'   => array(
                'class' => []
            ),
            'del'   => array(),
            'ins'   => array(),
        );
 
      return  wp_kses($data, $allow_html);
    }
}


// Change page featured image labels
add_filter( 'post_type_labels_page', function( $labels ) {
    $labels->featured_image 	= esc_html__('Title-bar Background Image', 'appart');
    $labels->set_featured_image 	= esc_html__('Set Title-bar Background Image', 'appart');
    $labels->remove_featured_image 	= esc_html__('Remove Title-bar Background Image', 'appart');
    $labels->use_featured_image 	= esc_html__('Use as Title-bar Background Image', 'appart');
    return $labels;
}, 10, 1 );
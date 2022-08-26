<?php
/********************************
* Post Share
*********************************/
if(!function_exists('acrony_post_share_social')){
    function acrony_post_share_social(){
        global $post;
        /* Get current page URL */
        $crunchifyURL = get_permalink();
        $crunchifyImage = get_the_post_thumbnail('full');
        $crunchifyDesc = get_the_content();
        /* Get current page title*/
        $crunchifyTitle = str_replace( ' ', '%20', get_the_title());
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$crunchifyTitle.'&amp;url='.$crunchifyURL.'&amp;via=Crunchify';
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$crunchifyURL;
        $linkedinURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$crunchifyURL;
        $pinterest = 'https://pinterest.com/pin/create/button/?url='.$crunchifyURL.'&media='.$crunchifyImage.'&description='.$crunchifyDesc;
        ?>
        <div class="share-menu">
            <a class="facebook" href="<?php echo esc_url($facebookURL); ?>" target="_blank">
                <i class="fab fa-facebook-f"></i> <span><?php esc_html_e('Facebook','acrony-core')?></span>
            </a>
            <a class="twitter" href="<?php echo esc_url($twitterURL); ?>" target="_blank">
                <i class="fab fa-twitter"></i> <span><?php esc_html_e('Twitter','acrony-core')?></span>
            </a>
            <a class="linkedin" href="<?php echo esc_url($linkedinURL); ?>" target="_blank">
                <i class="fab fa-linkedin-in"></i><span><?php esc_html_e('Linkedin','acrony-core')?></span>
            </a>
            <a class="pinterest" href="<?php echo esc_url($pinterest); ?>" target="_blank">
                <i class="fab fa-pinterest-p"></i><span><?php esc_html_e('Pinterest','acrony-core')?></span>
            </a>
        </div>
    <?php
    }
}
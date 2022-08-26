<?php
/**
 * Template Name: Contact
 */

get_header();

$opt = get_option('appart_opt');
$information_boxes = !empty($opt['information_boxes']) ? $opt['information_boxes'] : '';

/* Content Goes Here */?>
 <section class="contact_area sec-pad">
        <div class="contact_info">
            <div class="container">
                <div class="row">
                    <?php 
                    if(is_array($information_boxes)) :
                    foreach ($information_boxes as $infobox) : ?>
                        <div class="col-sm-4 col-xs-4">
                            <?php if(!empty( $infobox['title'])) : ?>
                                <div class="contact_info_item">
                                    <?php if(!empty($infobox['image'])) : ?>
                                    <div class="area_left">
                                         <img src="<?php echo esc_url($infobox['image']); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <div class="area_right">
                                         <h5><?php echo esc_html($infobox['title']); ?></h5>
                                        <?php if(!empty($infobox['description'])) : ?>
                                        <p><?php echo esc_html($infobox['description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                    endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <div class="contact_form_section">
            <div class="container">
                <div class="row">
                    <?php
                    if(!empty($opt['is_google_map'])): ?>
                        <div class="col-md-5 map">
                            <div id="googleMap" class="google-maps"></div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-<?php echo !empty($opt['is_google_map']) ? '7' : '12'; ?> contact-form-style">
                        <div class="contact_style">
                            <?php if(!empty($opt['contact_form_title'])) : ?>
                                <div class="form_title">
                                    <h6> <?php echo esc_html($opt['contact_form_title']) ?> </h6>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($opt['contact_form_shortcode'])) : ?>
                                <div class="contact_form">
                                    <?php echo do_shortcode($opt['contact_form_shortcode']) ?>
                                </div>
                            <?php endif; ?>
                         </div>
                    </div>
                </div>
            </div>
        </div>

         <?php while ( have_posts() ) : the_post();    ?>
             <?php   the_content();         ?>
         <?php endwhile; // End of the loop.?>

    </section>
<?php

get_footer();
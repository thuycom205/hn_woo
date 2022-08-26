<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-spy="scroll" data-target=".mainmenu-area">

<div class="error-area">
    <div class="container">
        <div class="row flex-box">
            <div class="col-xs-12 col-md-6">
                <div class="error-content">
                    <h1 class="big-text"><?php esc_html_e( 'Error','acrony' ); ?></h1>
                    <h3 class="medium-text"><?php esc_html_e( 'Oops! Page Not Found.','acrony' ); ?></h3>
                    <a href="<?php echo esc_url(home_url('/'))?>" class="error-button"><?php esc_html_e( "Go Home", 'acrony' ); ?></a>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="error-image">
                    <img src="<?php echo get_theme_file_uri('/assets/images/error-image.png'); ?>" class="error" alt="<?php esc_attr_e( '404 Image' , 'acrony' ); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php wp_footer(); ?>
</body>

</html>
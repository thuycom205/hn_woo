<header class="site-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php if( is_home() ): ?>
                <h3 class="page-title">
                    <?php esc_html_e( 'Blog Posts','acrony' ); ?>
                </h3>
                <div class="sub-title">
                    <?php bloginfo('description'); ?>
                </div>
                <?php elseif( class_exists( 'WooCommerce' ) and is_woocommerce() ): ?>
                <?php if( is_shop() ): ?>
                <h3 class="page-title">
                    <?php esc_html_e( 'Shop Page', 'acrony' ); ?>
                </h3>
                <?php else: ?>
                <h3 class="page-title">
                    <?php woocommerce_page_title(); ?>
                </h3>
                <?php endif; ?>
                <?php
                            if( function_exists('acrony_breadcrumb') ){ ?>
                <div class="sub-title">
                    <?php acrony_breadcrumb(); ?>
                </div>
                <?php
                            }
                        ?>
                <?php else: ?>
                <h3 class="page-title">
                    <?php single_post_title(); ?>
                </h3>
                <?php
                            if( function_exists('acrony_breadcrumb') ){ ?>
                <div class="sub-title">
                    <?php acrony_breadcrumb(); ?>
                </div>
                <?php
                            }
                        ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
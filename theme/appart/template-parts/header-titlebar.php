<?php
$opt = get_option('appart_opt');
$page_metaboxes = get_post_meta(get_the_ID(), 'page_metaboxes', true);

if(is_singular('product')) {
    $product_metaboxes = get_post_meta(get_the_ID(), 'product_metaboxes', true);
    ?>
    <section class="banner-area titlebar">
        <div class="container">
            <div class="banner-content">
                <?php
                if(!empty($product_metaboxes['title'])) {
                    echo '<h1 class="page-cover-tittle">'.esc_html($product_metaboxes['title']).'</h1>';
                }else { ?>
                    <h1 class="page-cover-tittle"> <?php the_title(); ?> </h1>
                    <?php
                }
                if(!empty($product_metaboxes['subtitle'])) {
                    echo '<p>'.esc_html($product_metaboxes['subtitle']).'</p>';
                }else {
                    echo has_excerpt() ? get_the_excerpt() : '';
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}

if(!is_404()) {
    $shop_title = !empty($opt['shop_title']) ? $opt['shop_title'] : '';
    $shop_subtitle = !empty($opt['shop_subtitle']) ? $opt['shop_subtitle'] : '';
    if( function_exists('cs_get_option') ) {
        $is_titlebar = isset($page_metaboxes['is_titlebar']) ? $page_metaboxes['is_titlebar'] : '1';
    } else {
        $is_titlebar = '1';
    }
    if ( $is_titlebar == '1' ) :
        ?>
        <section class="banner-area titlebar <?php echo is_tax('', 'product_cat') ? 'product_cat_archive' : ''; ?>" <?php echo !empty($opt['shop_bg_image']['url']) ? "style='background: url({$opt['shop_bg_image']['url']}) no-repeat scroll center 0/cover;'" : ''; ?>>
            <div class="container">
                <div class="banner-content">
                    <h1 class="page-cover-tittle">
                        <?php
                        if ( is_home() ) {
                            $blog_title = ! empty( $opt['blog_title'] ) ? $opt['blog_title'] : esc_html__('Blog', 'appart');
                            echo esc_html( $blog_title );
                        }
                        elseif ( is_search() ) {
                            echo esc_html__( 'Search result for : ', 'appart' ) . get_search_query();
                        }
                        elseif(function_exists('is_shop')) {
                            if(is_shop()) {
                                echo esc_html($shop_title);
                            } else {
                                the_title();
                            }
                        }
                        elseif(is_archive()) {
                            the_archive_title();
                        } else {
                            the_title();
                        }
                        ?>
                    </h1>
                    <p>
                        <?php
                        if ( is_home() ) {
                            $blog_subtitle = !empty( $opt['blog_subtitle'] ) ? $opt['blog_subtitle'] : '';
                            $blog_subtitle = ! empty( $blog_subtitle ) ? $blog_subtitle : get_bloginfo( 'description' );
                            echo esc_html( $blog_subtitle );
                        }
                        elseif( is_tax('', 'product_cat') ) {
                            woocommerce_result_count();
                        }
                        elseif( function_exists('is_shop') ) {
                            if( is_shop() ) {
                                echo esc_html($shop_subtitle);
                            }
                        }
                        else {
                            echo has_excerpt() ? get_the_excerpt() : '';
                        }
                        ?>
                    </p>
                </div>
            </div>
        </section>
        <?php
    endif;
}
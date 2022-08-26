<div <?php post_class('post-single'); ?> >
    <div class="post-content">
        <h3 class="post-title"><?php esc_html_e( 'Nothing Found', 'acrony' ); ?></h3>
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php esc_html__( 'Ready to publish your first post?', 'acrony' ); ?><a href="<?php esc_url( admin_url( 'post-new.php' ) ) ?>"><?php esc_html__('Get started here','acrony'); ?></a></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'acrony' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'acrony' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
    </div>
</div>
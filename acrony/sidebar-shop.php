<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package Acrony
 */
if ( is_active_sidebar( 'sidebar-shop' )  ) : 
?>
<aside class="sidebar">
   <?php dynamic_sidebar( 'sidebar-shop' ); ?>
</aside>
<?php endif; ?>
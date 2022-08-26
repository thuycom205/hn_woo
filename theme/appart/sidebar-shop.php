<?php
if ( ! is_active_sidebar( 'shop_sidebar' ) ) {
    return;
}
?>
<div class="col-lg-3">
    <div class="shop_sidebar">
        <?php dynamic_sidebar('shop_sidebar') ?>
    </div>
</div>
<?php
    $preloader_switch = get_theme_mod('acrony_preloader');
    if( $preloader_switch == false ): 
?>
<!-- Preloader -->
<div class="preloader">
    <div class="loaders loaders-1">
        <div class="loaders-outter"></div>
        <div class="loaders-inner"></div>
    </div>
</div>
<!-- Preloader / -->
<?php endif; ?>
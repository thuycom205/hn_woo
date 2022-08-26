<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
   <div class="search-box">
       <input type="search" name="s" class="search" placeholder="<?php echo esc_attr__("Search here...","acrony"); ?>" value="<?php echo esc_attr(get_search_query()); ?>">
       <button type="submit" class="search-bttn"><i class="fal fa-search"></i></button>        
   </div>
</form>
<?php
add_filter('get_search_form', function($form) {
    $form = '<form action="'.esc_url(home_url("/")).'" class="search-form input-group">
                <input type="search" name="s" class="form-control" placeholder="'.esc_attr__('Search', 'appart').'">
                <span class="input-group-addon"><button type="submit"><i class="ti-search"></i></button></span>
             </form>';
    return $form;
});
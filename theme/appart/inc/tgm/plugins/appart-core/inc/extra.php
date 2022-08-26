<?php
// Elementor is anchor external target
function appart_is_external($settings_key) {
    if(isset($settings_key['is_external'])) {
        echo $settings_key['is_external'] == true ? 'target="_blank"' : '';
    }
}

// Check if user set nofollow from Elementor settings
function appart_is_nofollow($settings_key) {
    if(isset($settings_key['nofollow'])) {
        echo $settings_key['nofollow'] ? 'rel="nofollow"' : '';
    }
}
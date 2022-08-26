<div class="droit_setting_container">
    <h2 class="droit_title"><?php esc_html_e( 'Time Settings', 'droit-dark-mode' );?></h2>

   
    <div class="droit_setting_wrapper timestart-dark <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'Time Based Dark Mode', 'droit-dark-mode' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-enable_time" data-checker="yes" data-condition=".dt-timebase-enable" name="drdt-setting[enable_time]" <?php echo isset($data['enable_time']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to enable dark mode between a time range.', 'droit-dark-mode' );?></p>
        </div>
    </div>

    <div class="droit_setting_wrapper dt-timebase-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); esc_attr_e( isset($data['enable_time']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( '  Start time ', 'droit-dark-mode' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <?php $start_time = ($data['start_time']) ?? ''; ?>
                <input name="drdt-setting[start_time]" type="text" value="<?php echo esc_attr($start_time);?>" class="dldark-flattimepicker">
            </div>   
            <p class="droit_setting_desc"><?php esc_html_e( 'Set start time of dark mode.', 'droit-dark-mode' );?></p>
        </div>
    </div>
    <div class="droit_setting_wrapper dt-timebase-enable <?php _e(($pro) ? 'drdt-disabled ' : ''); esc_attr_e( isset($data['enable_time']) ? '' : 'dt-display-off');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( '  End time ', 'droit-dark-mode' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <?php $end_time = ($data['end_time']) ?? ''; ?>
                <input name="drdt-setting[end_time]" type="text" value="<?php echo esc_attr($end_time);?>" class="dldark-flattimepicker">
                
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Set end time of dark mode', 'droit-dark-mode' );?></p>
        </div>
    </div>
</div>
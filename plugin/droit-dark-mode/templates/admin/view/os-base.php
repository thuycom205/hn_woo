<div class="droit_setting_container os">
    <h2 class="droit_title"><?php esc_html_e( 'Operating System Base Settings', 'droit-dark-mode' );?></h2>
    <div class="droit_setting_wrapper os-base-dark <?php _e(($pro) ? 'drdt-disabled ' : '');?>">
        <h4 class="droit_setting_title"><?php esc_html_e( 'OS Based Dark Mode', 'droit-dark-mode' );?></h4>
        <div class="droit_setting_switcher">
            <div class="droit_switcher">
                <label class="switch ">
                    <input type="checkbox" class="widget_checkbox _remove_disabled" id="droit-dark-enable_os_base" data-checker="yes" name="drdt-setting[enable_os_base]" <?php echo isset($data['enable_os_base']) ? 'checked' : '';?> data-value="yes" value="yes">
                    <span class="slider"></span>
                </label>
            </div>
            <p class="droit_setting_desc"><?php esc_html_e( 'Turn on to enable/disable dark mode based on the OS of user\'s device (computer/mobile).', 'droit-dark-mode' );?></p>
        </div>
    </div>
</div>
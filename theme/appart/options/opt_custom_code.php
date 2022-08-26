<?php

// Color option
Redux::setSection('appart_opt', array(
    'title'     => esc_html__('Custom Codes', 'appart'),
    'id'        => 'custom_codes',
    'icon'      => 'dashicons dashicons-editor-code',
    'fields'    => array(
        array(
            'id'       => 'custom_css',
            'type'     => 'ace_editor',
            'title'    => esc_html__('Custom CSS Code', 'appart'),
            'subtitle' => esc_html__('Paste/write your custom CSS code here.', 'appart'),
            'mode'     => 'css',
            'theme'    => 'monokai',
        ),
        array(
            'id'       => 'custom_js',
            'type'     => 'ace_editor',
            'title'    => esc_html__('Custom JavaScript Code', 'appart'),
            'subtitle' => esc_html__('Paste/write your custom JavaScript code here.', 'appart'),
            'mode'     => 'javascript',
            'theme'    => 'monokai',
        ),
    )
));
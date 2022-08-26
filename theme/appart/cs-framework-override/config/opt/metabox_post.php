<?php
$options[]    = array(
    'id'        => 'post_metas',
    'title'     => esc_html__('Post configurations', 'appart'),
    'post_type' =>  array('post'),
    'context'   => 'normal',
    'priority'  => 'default',
    'sections'  => array(
        array(
            'name'  => 'video-post',
            'title' => esc_html__('Video post', 'appart'),
            'icon'  => 'dashicons dashicons-minus',
            'fields' => array(
                array(
                    'id'        => 'post_video_url',
                    'type'      => 'textarea',
                    'title'     => esc_html__('Video embed code', 'appart'),
                    'desc'      => esc_html__('Input here the video iFrame code. You can get it from Vimeo, YouTube, Dailymotion', 'appart'),
                    'sanitize' => 'disabled'
                ),
            ),
        ),
        array(
            'name'  => 'audio-post',
            'title' => esc_html__('Audio post', 'appart'),
            'icon'  => 'dashicons dashicons-minus',
            'fields' => array(
                array(
                    'id'        => 'post_audio_url',
                    'type'      => 'textarea',
                    'title'     => esc_html__('Audio embed code', 'appart'),
                    'desc'      => esc_html__('Input here the Audio iFrame code. You can get it from SoundCloud, Gaana.com', 'appart'),
                    'sanitize' => 'disabled'
                ),
            ),
        ),
    ),
);
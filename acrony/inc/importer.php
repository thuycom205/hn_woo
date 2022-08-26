<?php

function acrony_backups_demos( $demos ) {
	
	$demo_content_installer	 = 'https://wp.quomodosoft.com/acrony/content';
	$demos_array			 = array(

		'home_1'			 => array(
			'title'			 => esc_html__( 'Home V1', 'acrony' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/home_1.jpg',
			'preview_link'	 => esc_url( 'https://wp.quomodosoft.com/acrony' ),
		),
		
		'home_2'			 => array(
			'title'			 => esc_html__( 'Home V2', 'acrony' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/home_2.jpg',
			'preview_link'	 => esc_url( 'https://wp.quomodosoft.com/acrony/home2' ),
		),
		
		'home_3'			 => array(
			'title'			 => esc_html__( 'Home V3', 'acrony' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/home_3.jpg',
			'preview_link'	 => esc_url( 'https://wp.quomodosoft.com/acrony/home3' ),
		),
		
		'home_4'			 => array(
			'title'			 => esc_html__( 'Home V4', 'acrony' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/home_4.jpg',
			'preview_link'	 => esc_url( 'https://wp.quomodosoft.com/acrony/home4' ),
		),
	);

	$download_url			 = esc_url( $demo_content_installer ) . '/download.php';
	
	foreach ( $demos_array as $id => $data ) {
		$demo = new FW_Ext_Backups_Demo( $id, 'piecemeal', array(
			'url'		 => $download_url,
			'file_id'	 => $id,
		) );
		$demo->set_title( $data[ 'title' ] );
		$demo->set_screenshot( $data[ 'screenshot' ] );
		$demo->set_preview_link( $data[ 'preview_link' ] );
		$demos[ $demo->get_id() ] = $demo;
		unset( $demo );
	}

	return $demos;
}

add_filter( 'fw:ext:backups-demo:demos', 'acrony_backups_demos' );
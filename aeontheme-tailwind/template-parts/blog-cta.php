<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = aeon_option( 'post_cta_title' );
if ( $title ) {
	get_template_part( 'template-parts/layouts/cta_band', null, array(
		'layout' => array(
			'title'        => $title,
			'text'         => aeon_option( 'post_cta_text' ),
			'button_label' => aeon_option( 'post_cta_button_label' ),
			'button_url'   => aeon_option( 'post_cta_button_url', aeon_option( 'header_cta_url' ) ),
		),
	) );
}

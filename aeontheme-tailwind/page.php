<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
while ( have_posts() ) {
	the_post();
	$rendered = false;
	if ( ! post_password_required() ) {
		foreach ( aeon_get_page_builder() as $layout ) {
			$rendered = aeon_render_layout( $layout ) || $rendered;
		}
	}

	if ( ! $rendered ) {
		get_template_part( 'template-parts/content-page' );
	}
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
}
get_footer();

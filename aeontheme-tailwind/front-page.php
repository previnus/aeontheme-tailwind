<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_page_template( 'template-blog.php' ) ) {
	get_template_part( 'template-blog' );
} elseif ( is_page() ) {
	require __DIR__ . '/page.php';
} else {
	require __DIR__ . '/index.php';
}

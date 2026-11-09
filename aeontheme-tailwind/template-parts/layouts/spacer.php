<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$height = max( 0, min( 1000, (int) ( $layout['height'] ?? 0 ) ) );
if ( $height ) {
	echo '<div style="height:' . esc_attr( $height ) . 'px"></div>';
}

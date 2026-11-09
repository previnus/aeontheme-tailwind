<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$image_id = $layout['image'] ?? 0;
$title = $layout['title'] ?? '';
$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';
?>
<section class="shop-band" data-block="shop-band">
	<?php if ( $image_url ) : ?>
	<div class="shop-band__media" style="background-image:url('<?php echo esc_url( $image_url ); ?>')" role="img" aria-label="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>"></div>
	<?php endif; ?>
	<div class="shop-band__scrim" aria-hidden="true"></div>
	<div class="aeon-container">
		<h2 class="shop-band__title t-display-tight"><?php echo nl2br( esc_html( $title ) ); ?></h2>
	</div>
</section>

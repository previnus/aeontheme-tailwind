<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$text = $layout['text'] ?? '';
$cta_label = $layout['cta_label'] ?? '';
$cta_url = $layout['cta_url'] ?? '';
$image_id = $layout['image'] ?? 0;
?>
<section class="shop-band" data-block="cta-section">
	<?php if ( $image_id ) : ?><div class="shop-band__media" style="background-image:url('<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ); ?>')" role="img" aria-label="<?php echo esc_attr( $title ); ?>"></div><?php endif; ?>
	<div class="shop-band__scrim" aria-hidden="true"></div>
	<div class="aeon-container">
		<?php if ( $title ) : ?><h2 class="shop-band__title t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
		<?php if ( $text ) : ?><p class="shop-band__text"><?php echo esc_html( $text ); ?></p><?php endif; ?>
		<?php if ( $cta_label ) : ?><a class="btn btn--primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a><?php endif; ?>
	</div>
</section>

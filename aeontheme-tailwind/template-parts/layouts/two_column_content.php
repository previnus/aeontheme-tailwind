<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$eyebrow = $layout['eyebrow'] ?? '';
$title = $layout['title'] ?? '';
$content = $layout['content'] ?? '';
$image_id = $layout['image'] ?? 0;
$cta_label = $layout['cta_label'] ?? '';
$cta_url = $layout['cta_url'] ?? '';
?>
<section class="aeon-section" data-block="two-column-content">
	<div class="aeon-container">
		<div class="aeon-grid aeon-grid--split">
			<div class="aeon-grid__item">
				<?php if ( $eyebrow ) : ?><p class="t-eyebrow"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
				<?php if ( $content ) : ?><div class="u-muted"><?php echo wp_kses_post( $content ); ?></div><?php endif; ?>
				<?php if ( $cta_label ) : ?><a class="btn btn--primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a><?php endif; ?>
			</div>
			<div class="aeon-grid__item">
				<?php if ( $image_id ) : echo wp_get_attachment_image( $image_id, 'aeon-card', false, array( 'alt' => $title ) ); endif; ?>
			</div>
		</div>
	</div>
</section>

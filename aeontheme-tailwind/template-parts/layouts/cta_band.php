<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$text = $layout['text'] ?? '';
$button_label = $layout['button_label'] ?? '';
$button_url = $layout['button_url'] ?? '';
?>
<section class="cta-band" data-block="cta-band">
	<div class="aeon-container">
		<div class="cta-band__inner">
			<div>
				<?php if ( $title ) : ?><h2 class="cta-band__title t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
				<?php if ( $text ) : ?><p class="cta-band__text"><?php echo esc_html( $text ); ?></p><?php endif; ?>
			</div>
			<?php if ( $button_label && $button_url ) : ?>
			<a class="btn btn--light btn--wide" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_label ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
			<?php endif; ?>
		</div>
	</div>
</section>

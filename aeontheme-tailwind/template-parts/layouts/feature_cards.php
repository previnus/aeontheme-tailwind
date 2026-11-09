<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$cards = aeon_rows( $layout['cards'] ?? null );
?>
<section class="aeon-section aeon-section--bone-2" data-block="feature-cards">
	<div class="aeon-container">
		<?php if ( $title ) : ?>
		<div class="section-title">
			<div>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<?php endif; ?>
		<div class="feature-cards">
			<?php foreach ( $cards as $card ) : ?>
			<div class="feature-card">
				<span class="feature-card__icon"><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
				<?php if ( ! empty( $card['title'] ) ) : ?><h3 class="feature-card__title t-display-tight"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?>
				<?php if ( ! empty( $card['text'] ) ) : ?><p class="feature-card__text"><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'audience-cards' );
$cards = aeon_rows( $layout['cards'] ?? null );
?>
<section class="aeon-section" data-block="audience-cards" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
		<?php if ( $num ) : ?>		<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="audience-grid">
			<?php foreach ( $cards as $card ) :
				$dark = ! empty( $card['dark'] );
				$image_id = $card['image'] ?? 0;
				$bullets = aeon_rows( $card['bullets'] ?? null );
				?>
			<a class="audience-card<?php echo $dark ? ' audience-card--dark' : ''; ?>" href="<?php echo esc_url( $card['url'] ?? '' ); ?>">
				<div class="audience-card__media">
					<?php if ( $image_id ) : echo wp_get_attachment_image( $image_id, 'aeon-card', false, array( 'alt' => $card['title'] ?? '' ) ); endif; ?>
					<span class="audience-card__tag t-mono"><?php echo esc_html( $card['tag'] ?? '' ); ?></span>
					<span class="audience-card__rule" aria-hidden="true"></span>
				</div>
				<div class="audience-card__body">
					<p class="audience-card__eyebrow t-mono"><?php echo esc_html( $card['eyebrow'] ?? '' ); ?></p>
					<h3 class="audience-card__title t-display-tight"><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
					<p class="audience-card__text"><?php echo esc_html( $card['text'] ?? '' ); ?></p>
					<?php if ( ! empty( $bullets ) ) : ?>
					<ul class="audience-card__list">
						<?php foreach ( $bullets as $bullet ) : ?>
							<li><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><?php echo esc_html( $bullet['text'] ?? '' ); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<div class="audience-card__foot"><span class="audience-card__cta"><?php echo esc_html( $card['cta_label'] ?? '' ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></div>
				</div>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

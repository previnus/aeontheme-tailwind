<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$embed = aeon_render_shortcode( $layout['review_shortcode'] ?? '' );
$stars = max( 0, min( 5, (int) ( $layout['stars'] ?? 5 ) ) );
$items = aeon_rows( $layout['items'] ?? null );
$star_svg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 2l2.9 6.6 7.1.6-5.4 4.8 1.7 7-6.3-3.8L5.7 21l1.7-7L2 9.2l7.1-.6L12 2z"/></svg>';
?>
<section class="aeon-section" data-block="reviews" id="<?php echo esc_attr( aeon_section_id( 'reviews' ) ); ?>">

	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
			<div class="section-title__aside">
				<div class="reviews__summary">
					<p class="reviews__score aeon-mb-0"><?php echo esc_html( $layout['score'] ?? '' ); ?><span> <?php echo esc_html( $layout['score_suffix'] ?? '' ); ?></span><br><span class="t-mono u-muted"><?php echo esc_html( $layout['score_note'] ?? '' ); ?></span></p>
					<p class="reviews__stars aeon-mb-0" aria-label="Rated <?php echo esc_attr( $stars ); ?> out of 5"><?php echo str_repeat( $star_svg, $stars ); ?></p>
				</div>
			</div>
		</div>
		<?php if ( $embed ) : ?>
			<?php echo $embed; ?>
		<?php elseif ( $items ) : ?>
		<div class="reviews__grid">
			<?php foreach ( $items as $item ) : ?>
			<article class="review-card">
				<div class="review-card__top">
					<span class="review-card__tag t-mono"><?php echo esc_html( $item['tag'] ?? '' ); ?></span>

				</div>
				<blockquote class="review-card__quote"><?php echo esc_html( $item['quote'] ?? '' ); ?></blockquote>
				<div class="review-card__person">
					<span class="review-card__avatar" aria-hidden="true"><?php echo esc_html( $item['initials'] ?? '' ); ?></span>
					<span><span class="review-card__name aeon-d-block"><?php echo esc_html( $item['name'] ?? '' ); ?></span><span class="review-card__role t-mono"><?php echo esc_html( $item['role'] ?? '' ); ?></span></span>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>

</section>

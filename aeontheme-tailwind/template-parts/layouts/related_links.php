<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$all_label = $layout['view_all_label'] ?? '';
$all_url = $layout['view_all_url'] ?? '';
$cards = aeon_rows( $layout['cards'] ?? null );
$arrow = '<svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$has_media = false;
foreach ( $cards as $card ) {
	if ( ! empty( $card['image'] ) ) {
		$has_media = true;
	}
}
?>
<section class="aeon-section aeon-section--bone-2" data-block="related-links">
	<div class="aeon-container">
		<?php if ( $title || $num || $label ) : ?>
		<div class="section-title">
			<div>
				<?php if ( $num || $label ) : ?><p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $all_label ) : ?><div class="section-title__aside"><a class="btn-arrow btn-arrow--plain" href="<?php echo esc_url( $all_url ); ?>"><?php echo esc_html( $all_label ); ?><?php echo $arrow; ?></a></div><?php endif; ?>
		</div>
		<?php endif; ?>
		<?php if ( $has_media ) : ?>
		<div class="rel-grid">
			<?php foreach ( $cards as $card ) :
				$url = $card['url'] ?? '';
				$tag = ( $url && '#' !== $url ) ? 'a' : 'div';
				?>
			<<?php echo $tag; ?> class="rel-card<?php echo 'div' === $tag ? ' rel-card--static' : ''; ?>"<?php if ( 'a' === $tag ) : ?> href="<?php echo esc_url( $url ); ?>"<?php endif; ?>>
				<span class="rel-card__media"><?php if ( ! empty( $card['image'] ) ) : echo wp_get_attachment_image( $card['image'], 'aeon-card', false, array( 'alt' => $card['title'] ?? '' ) ); endif; ?></span>
				<span class="rel-card__body">
					<?php if ( ! empty( $card['kicker'] ) ) : ?><span class="rel-card__kicker t-mono"><?php echo esc_html( $card['kicker'] ); ?></span><?php endif; ?>
					<?php if ( ! empty( $card['title'] ) ) : ?><span class="rel-card__name"><?php echo esc_html( $card['title'] ); ?></span><?php endif; ?>
					<?php if ( ! empty( $card['text'] ) ) : ?><span class="rel-card__text"><?php echo esc_html( $card['text'] ); ?></span><?php endif; ?>
				</span>
			</<?php echo $tag; ?>>
			<?php endforeach; ?>
		</div>
		<?php else : ?>
		<div class="related-links">
			<?php foreach ( $cards as $card ) : ?>
			<a class="related-card" href="<?php echo esc_url( $card['url'] ?? '#' ); ?>">
				<?php if ( ! empty( $card['kicker'] ) ) : ?><p class="related-card__kicker t-mono"><?php echo esc_html( $card['kicker'] ); ?></p><?php endif; ?>
				<?php if ( ! empty( $card['title'] ) ) : ?><h3 class="related-card__title t-display-tight"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?>
				<?php if ( ! empty( $card['text'] ) ) : ?><p class="related-card__text"><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
				<span class="btn-arrow btn-arrow--plain"><?php echo esc_html( $card['link_label'] ?? 'Read more' ); ?><?php echo $arrow; ?></span>
			</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$cards = aeon_rows( $layout['cards'] ?? null );
?>
<section class="aeon-section" data-block="why-grid" id="<?php echo esc_attr( aeon_section_id( 'highlights' ) ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="why-grid">
			<?php foreach ( $cards as $card ) :
				$image_id = $card['image'] ?? 0;
				?>
			<article class="why-card">
				<div class="why-card__media"><?php if ( $image_id ) : echo wp_get_attachment_image( $image_id, 'aeon-card', false, array( 'alt' => $card['title'] ?? '' ) ); endif; ?></div>
				<div class="why-card__body">
					<p class="why-card__num t-mono aeon-mb-0"><?php echo esc_html( $card['number'] ?? '' ); ?></p>
					<h3 class="why-card__title"><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
					<p class="why-card__text aeon-mb-0"><?php echo esc_html( $card['text'] ?? '' ); ?></p>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

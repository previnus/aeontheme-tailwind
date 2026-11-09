<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$items = aeon_rows( $layout['items'] ?? null );
?>
<section class="aeon-section aeon-section--dark believe" data-block="believe" id="<?php echo esc_attr( aeon_section_id( 'beliefs' ) ); ?>">
	<div class="aeon-container">
		<div class="section-title section-title--dark">
			<div>
				<?php if ( $num || $label ) : ?><p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="believe__grid">
			<?php foreach ( $items as $i => $item ) : ?>
			<div class="believe__cell">
				<p class="believe__num t-display-tight" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
				<h3 class="believe__title t-display-tight"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
				<p class="believe__text"><?php echo esc_html( $item['text'] ?? '' ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

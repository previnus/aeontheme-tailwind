<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'faqs' );
$items = aeon_rows( $layout['items'] ?? null );
?>
<section class="aeon-section" data-block="faq" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>

				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="faq">
			<?php foreach ( $items as $i => $item ) :
				$panel_id = aeon_section_id( $anchor . '-answer-' . ( $i + 1 ) );
				?>
			<div class="faq__item">
				<h3><button type="button" class="faq__question js-disclosure" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>"><?php echo esc_html( $item['question'] ?? '' ); ?><span class="faq__icon"><svg width="13" height="9" viewBox="0 0 13 9" aria-hidden="true" focusable="false"><path d="M1 1l5.5 5.5L12 1" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></button></h3>
				<div class="faq__answer" id="<?php echo esc_attr( $panel_id ); ?>" inert><div><?php echo wp_kses_post( wpautop( $item['answer'] ?? '' ) ); ?></div></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

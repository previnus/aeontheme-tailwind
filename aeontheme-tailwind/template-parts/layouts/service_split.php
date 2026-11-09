<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'service-split' );
$aside = $layout['aside_text'] ?? '';
$columns = aeon_rows( $layout['columns'] ?? null );
?>
<section class="aeon-section" data-block="service-split" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
			<?php if ( $aside ) : ?><div class="section-title__aside"><p class="aeon-mb-0 t-lead u-muted"><?php echo esc_html( $aside ); ?></p></div><?php endif; ?>
		</div>
		<div class="service-split">
			<?php foreach ( $columns as $col ) :
				$rows = aeon_rows( $col['rows'] ?? null );
				?>
			<div class="service-split__col">
				<p class="service-split__tag t-mono"><?php echo esc_html( $col['tag'] ?? '' ); ?></p>
				<h3 class="service-split__title t-display-tight"><?php echo esc_html( $col['title'] ?? '' ); ?></h3>
				<p class="service-split__text"><?php echo esc_html( $col['text'] ?? '' ); ?></p>
				<?php if ( ! empty( $rows ) ) : ?>
				<ul class="service-split__rows">
					<?php foreach ( $rows as $i => $row ) : ?>
						<li class="service-split__row"><span class="service-split__num"><?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?></span><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span><?php echo esc_html( $row['text'] ?? '' ); ?></span></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
				<?php if ( ! empty( $col['cta_label'] ) ) : ?>
				<div class="service-split__foot"><?php echo aeon_contact_action( $col['cta_label'], $col['cta_context'] ?? '', 'btn btn--outline-dark' ); ?></div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

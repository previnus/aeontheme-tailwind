<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$aside = $layout['aside_text'] ?? '';
$cards = aeon_rows( $layout['cards'] ?? null );
?>
<section class="aeon-section" data-block="spec-grid">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p>
<?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
			<?php if ( $aside ) : ?><div class="section-title__aside"><p class="aeon-mb-0 u-muted"><?php echo esc_html( $aside ); ?></p></div><?php endif; ?>
		</div>
		<div class="aeon-grid aeon-grid--specifications">
			<?php foreach ( $cards as $card ) :
				$specs = aeon_rows( $card['specs'] ?? null );
				?>
			<div class="aeon-grid__item">
				<article class="spec-card">
					<div class="spec-card__head">
						<p class="spec-card__tier t-mono aeon-mb-0"><?php echo esc_html( $card['tier'] ?? '' ); ?></p>
						<h3 class="spec-card__name"><?php echo esc_html( $card['name'] ?? '' ); ?></h3>
						<p class="spec-card__text aeon-mb-0"><?php echo esc_html( $card['text'] ?? '' ); ?></p>
					</div>
					<?php if ( ! empty( $specs ) ) : ?>
					<table class="spec-card__table">
						<caption class="u-visually-hidden"><?php echo esc_html( $card['name'] ?? '' ); ?> specifications</caption>
						<tbody>
							<?php foreach ( $specs as $spec ) : ?>
								<tr><th scope="row"><?php echo esc_html( $spec['label'] ?? '' ); ?></th><td><?php echo esc_html( $spec['value'] ?? '' ); ?></td></tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php endif; ?>
					<div class="spec-card__foot">

						<?php echo aeon_contact_action( __( 'Request a product quote', 'aeon-theme' ), $card['cta_context'] ?? '', 'btn btn--outline-dark', 'product', $card['name'] ?? '' ); ?>

					</div>
				</article>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

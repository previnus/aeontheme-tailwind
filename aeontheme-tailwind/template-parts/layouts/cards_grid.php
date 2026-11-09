<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$eyebrow = $layout['eyebrow'] ?? '';
$title = $layout['title'] ?? '';
$cards = aeon_rows( $layout['cards'] ?? null );
?>
<section class="aeon-section" data-block="cards-grid">
	<div class="aeon-container">
		<?php if ( $eyebrow || $title ) : ?>
			<div class="section-title">
				<div>
					<?php if ( $eyebrow ) : ?><p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><span class="section-title__label"><?php echo esc_html( $eyebrow ); ?></span></p><?php endif; ?>
					<?php if ( $title ) : ?><h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="aeon-grid aeon-grid--cards">
			<?php foreach ( $cards as $card ) : ?>
				<div class="aeon-grid__item">
					<div class="audience-card">
						<?php if ( ! empty( $card['image'] ) ) : ?><div class="audience-card__media"><?php echo wp_get_attachment_image( $card['image'], 'aeon-card', false, array( 'alt' => $card['heading'] ?? '' ) ); ?></div><?php endif; ?>
						<div class="audience-card__body">
							<?php if ( ! empty( $card['heading'] ) ) : ?><h3 class="audience-card__title t-display-tight"><?php echo esc_html( $card['heading'] ); ?></h3><?php endif; ?>
							<?php if ( ! empty( $card['text'] ) ) : ?><p class="audience-card__text"><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
							<?php if ( ! empty( $card['link'] ) ) : ?><a class="audience-card__cta" href="<?php echo esc_url( $card['link'] ); ?>">Learn More</a><?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

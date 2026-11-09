<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$shortcode = $layout['contact_form_shortcode'] ?? '';
$info_cards = aeon_rows( $layout['info_cards'] ?? null );
$form_eyebrow = $layout['form_eyebrow'] ?? '';
$form_title = $layout['form_title'] ?? '';

$icons = array(
	'phone'    => '<svg width="15" height="15" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M3 1.5h2.2l1.1 2.8-1.4 1a7.5 7.5 0 004.8 4.8l1-1.4 2.8 1.1V12a2.5 2.5 0 01-2.7 2.5A11.5 11.5 0 011.5 4.2A2.5 2.5 0 013 1.5z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	'email'    => '<svg width="15" height="15" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><rect x="1.5" y="3" width="13" height="10" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M2 4l6 4.5L14 4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
	'location' => '<svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M7 13s4.5-4.6 4.5-7.6A4.5 4.5 0 002.5 5.4C2.5 8.4 7 13 7 13z" fill="none" stroke="currentColor" stroke-width="1.5"/><circle cx="7" cy="5.4" r="1.6" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>',
	'hours'    => '<svg width="15" height="15" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><circle cx="8" cy="8" r="6.4" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M8 4.4V8l2.6 1.6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
);
$form_html = aeon_render_shortcode( $shortcode );
?>
<section class="final-cta aeon-section" data-block="final-cta" id="<?php echo esc_attr( aeon_section_id( 'contact' ) ); ?>">
	<div class="aeon-container">
		<div class="final-cta__grid final-cta__grid--contact">
			<?php if ( $form_html ) : ?>
				<div class="contact-form"><div class="contact-form__body">
					<?php if ( $form_eyebrow ) : ?><p class="contact-form__eyebrow t-mono"><?php echo esc_html( $form_eyebrow ); ?></p><?php endif; ?>
					<?php if ( $form_title ) : ?><h3 class="contact-form__title t-display-tight"><?php echo esc_html( $form_title ); ?></h3><?php endif; ?>
					<?php echo $form_html; ?>
				</div></div>
			<?php endif; ?>
			<div class="info-grid">
				<?php foreach ( $info_cards as $card ) :
					$icon_type = $card['icon_type'] ?? 'phone';
					$value = $card['value'] ?? '';
					$url = $card['url'] ?? '';
					?>
				<div class="info-card">
					<span class="info-card__icon"><?php echo $icons[ $icon_type ] ?? $icons['phone']; ?></span>
					<?php if ( ! empty( $card['label'] ) ) : ?><p class="info-card__label t-mono"><?php echo esc_html( $card['label'] ); ?></p><?php endif; ?>
					<?php if ( $url ) : ?>
						<a class="info-card__value" href="<?php echo esc_url( $url ); ?>"><?php echo wp_kses_post( nl2br( esc_html( $value ) ) ); ?></a>
					<?php elseif ( $value ) : ?>
						<span class="info-card__value"><?php echo wp_kses_post( nl2br( esc_html( $value ) ) ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $card['note'] ) ) : ?><p class="info-card__note"><?php echo esc_html( $card['note'] ); ?></p><?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

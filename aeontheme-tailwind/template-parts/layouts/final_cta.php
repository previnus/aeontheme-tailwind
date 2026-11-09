<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$text = $layout['text'] ?? '';
$note = $layout['note_text'] ?? '';
$note1 = $layout['note_text_copy'] ?? '';

$form = aeon_render_shortcode( $layout['contact_form_shortcode'] ?? '' );
$phone = aeon_option( 'phone_number' );
$phone_href = preg_replace( '/[^0-9+]/', '', $phone );
?>
<section class="final-cta aeon-section" data-block="final-cta" id="<?php echo esc_attr( aeon_section_id( 'contact' ) ); ?>">
	<div class="aeon-container">
		<div class="final-cta__grid">
			<div>
				<p class="t-eyebrow"><?php echo esc_html( $num ); ?> <?php echo esc_html( $label ); ?></p>
				<h2 class="final-cta__title t-display-tight"><?php echo nl2br( esc_html( $title ) ); ?></h2>
				<p class="final-cta__text"><?php echo esc_html( $text ); ?></p>
				<?php if ( $phone_href ) : ?><a class="final-cta__phone" href="tel:<?php echo esc_attr( $phone_href ); ?>">
					<span class="final-cta__phone-icon"><svg width="15" height="15" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M3 1.5h2.2l1.1 2.8-1.4 1a7.5 7.5 0 004.8 4.8l1-1.4 2.8 1.1V12a2.5 2.5 0 01-2.7 2.5A11.5 11.5 0 011.5 4.2A2.5 2.5 0 013 1.5z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
					<span><span class="final-cta__phone-label t-mono"><?php echo esc_html( $note1 ); ?></span><span class="final-cta__phone-number"><?php echo esc_html( $phone ); ?></span></span>
				</a><?php endif; ?>
				<?php if ( $note ) : ?><p class="final-cta__note"><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M7 13s4.5-4.6 4.5-7.6A4.5 4.5 0 002.5 5.4C2.5 8.4 7 13 7 13z" fill="none" stroke="currentColor" stroke-width="1.5"/><circle cx="7" cy="5.4" r="1.6" fill="none" stroke="currentColor" stroke-width="1.5"/></svg><?php echo esc_html( $note ); ?></p><?php endif; ?>
			</div>
			<?php if ( $form ) : ?>
			<div class="contact-form">
				<div class="contact-form__body">
					<?php if ( ! empty( $layout['form_eyebrow'] ) ) : ?><p class="contact-form__eyebrow t-mono"><?php echo esc_html( $layout['form_eyebrow'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $layout['form_title'] ) ) : ?><h3 class="contact-form__title t-display-tight"><?php echo esc_html( $layout['form_title'] ); ?></h3><?php endif; ?>
					<?php echo $form; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

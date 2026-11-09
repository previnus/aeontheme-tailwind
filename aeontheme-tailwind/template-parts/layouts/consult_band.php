<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$cta_label = $layout['cta_label'] ?? '';
$cta_context = $layout['cta_context'] ?? '';
$cta_url = $layout['cta_url'] ?? '';
$eyebrow = $layout['eyebrow'] ?? '';
$text = $layout['text'] ?? '';
$style = $layout['style'] ?? 'dark';
if ( ! in_array( $style, array( 'dark', 'orange', 'orange_split', 'orange_strip' ), true ) ) {
	$style = 'dark';
}
$is_orange = 'dark' !== $style;
$arrow = '<svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';

ob_start();
if ( $cta_label ) :
	if ( $cta_url ) :
		$btn_class = $is_orange ? 'btn btn--outline-light' : 'btn btn--primary btn--wide';
		?><a class="<?php echo esc_attr( $btn_class ); ?>" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?><?php echo $arrow; ?></a><?php
	else :
		$btn_class = $is_orange ? 'btn btn--light btn--wide' : 'btn btn--primary btn--wide';
		echo aeon_contact_action( $cta_label, $cta_context, $btn_class );
	endif;
endif;
$button = ob_get_clean();

if ( ! $is_orange ) : ?>
<section class="consult-band" data-block="consult-band">
	<div class="consult-band__copy">
		<?php if ( $eyebrow ) : ?><p class="consult-band__eyebrow t-mono"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
		<h2 class="consult-band__title t-display-tight"><?php echo nl2br( esc_html( $title ) ); ?></h2>
		<?php if ( $text ) : ?><p class="consult-band__text"><?php echo esc_html( $text ); ?></p><?php endif; ?>
	</div>
	<?php echo $button; ?>
</section>
<?php else : ?>
<section class="consult-band consult-band--accent consult-band--<?php echo esc_attr( str_replace( 'orange', 'accent', $style ) ); ?>" data-block="consult-band">
	<div class="aeon-container">
		<div class="consult-band__inner">
			<?php if ( 'orange_split' === $style && $eyebrow ) : ?><p class="consult-band__eyebrow t-mono"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
			<div class="consult-band__copy">
				<?php if ( in_array( $style, array( 'orange', 'orange_strip' ), true ) && $eyebrow ) : ?><p class="consult-band__eyebrow t-mono"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
				<h2 class="consult-band__title t-display-tight"><?php echo nl2br( esc_html( $title ) ); ?></h2>
				<?php if ( $text ) : ?><p class="consult-band__text"><?php echo esc_html( $text ); ?></p><?php endif; ?>
			</div>
			<?php echo $button; ?>
		</div>
	</div>
</section>
<?php endif;

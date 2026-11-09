<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$eyebrow = $layout['eyebrow'] ?? '';
$title = $layout['title'] ?? '';
$facts = aeon_rows( $layout['facts'] ?? null );
$intro = $layout['intro'] ?? '';
$reveal = $layout['reveal_content'] ?? '';
$section_id = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'about' );
$reveal_id = aeon_section_id( $section_id . '-reveal' );
?>
<section class="seo-copy aeon-section" data-block="seo-copy" id="<?php echo esc_attr( $section_id ); ?>">
	<div class="aeon-container">
		<div class="seo-copy__head">
			<?php if ( $eyebrow ) : ?><p class="seo-copy__eyebrow t-mono"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
			<?php if ( $title ) : ?><h2 class="seo-copy__title t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
		</div>
		<div class="seo-copy__body">
			<?php if ( ! empty( $facts ) ) : ?>
			<aside aria-label="Key facts">
				<dl class="seo-copy__facts">
					<?php foreach ( $facts as $fact ) : ?>
						<div class="seo-copy__fact"><dt><?php echo esc_html( $fact['label'] ?? '' ); ?></dt><dd><?php echo esc_html( $fact['value'] ?? '' ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
			</aside>
			<?php endif; ?>
			<div class="seo-copy__essay">
				<?php echo wp_kses_post( $intro ); ?>
				<?php if ( $reveal ) : ?>
				<div class="seo-copy__reveal" id="<?php echo esc_attr( $reveal_id ); ?>" inert>
					<div><?php echo wp_kses_post( $reveal ); ?></div>
				</div>
				<button type="button" class="seo-copy__toggle js-disclosure" aria-expanded="false" aria-controls="<?php echo esc_attr( $reveal_id ); ?>" data-label-open="Read Less" data-label-closed="Read More"><span class="js-disclosure-label">Read More</span><svg width="13" height="9" viewBox="0 0 13 9" aria-hidden="true" focusable="false"><path d="M1 1l5.5 5.5L12 1" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

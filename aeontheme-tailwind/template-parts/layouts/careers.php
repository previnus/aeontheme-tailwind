<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$text = $layout['text'] ?? '';
$cta_label = $layout['cta_label'] ?? '';
$cta_url = $layout['cta_url'] ?? '';
$roles = aeon_rows( $layout['roles'] ?? null );
$arrow = '<svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>
<section class="aeon-section careers" data-block="careers" id="<?php echo esc_attr( aeon_section_id( 'careers' ) ); ?>">
	<div class="aeon-container">
		<div class="careers__grid">
			<div class="careers__pitch">
				<div class="section-title">
					<div>
						<?php if ( $num || $label ) : ?><p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
						<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
					</div>
				</div>
				<?php if ( $text ) : ?><p class="careers__text"><?php echo esc_html( $text ); ?></p><?php endif; ?>
				<?php if ( $cta_label ) : ?><a class="btn btn--primary" href="<?php echo esc_url( $cta_url, array( 'http', 'https', 'mailto', 'tel' ) ); ?>"><?php echo esc_html( $cta_label ); ?><?php echo $arrow; ?></a><?php endif; ?>
			</div>
			<div class="careers__list">
				<?php foreach ( $roles as $role ) :
					$url = $role['url'] ?? '';
					$tag = $url ? 'a' : 'div';
					?>
				<<?php echo $tag; ?> class="career-row"<?php if ( $url ) : ?> href="<?php echo esc_url( $url, array( 'http', 'https', 'mailto', 'tel' ) ); ?>"<?php endif; ?>>
					<span>
						<span class="career-row__head"><span class="career-row__title t-display-tight"><?php echo esc_html( $role['title'] ?? '' ); ?></span><?php if ( ! empty( $role['meta'] ) ) : ?><span class="career-row__meta t-mono"><?php echo esc_html( $role['meta'] ); ?></span><?php endif; ?></span>
						<?php if ( ! empty( $role['text'] ) ) : ?><span class="career-row__desc aeon-d-block"><?php echo esc_html( $role['text'] ); ?></span><?php endif; ?>
					</span>
					<span class="career-row__arrow" aria-hidden="true"><?php echo $arrow; ?></span>
				</<?php echo $tag; ?>>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

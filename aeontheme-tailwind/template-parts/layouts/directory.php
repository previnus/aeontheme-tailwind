<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'directory' );
$title = $layout['title'] ?? '';
$count = $layout['count_text'] ?? '';
$source = $layout['source'] ?? 'custom';

$option = array( 'locations' => 'directory_locations', 'trades' => 'directory_trades' );
$groups = isset( $option[ $source ] )
	? aeon_option( $option[ $source ], array() )
	: aeon_rows( $layout['groups'] ?? null );
if ( ! $groups ) {
	return;
}

// Callers that don't set an explicit count_text (e.g. the blog templates,
// which call this part directly instead of through the ACF page builder)
// get one computed from the actual link count, so it can't drift from the
// real data the way a manually typed "29 areas" string could.
if ( ! $count && ( 'locations' === $source || 'trades' === $source ) ) {
	$link_count = 0;
	foreach ( $groups as $group ) {
		$link_count += count( aeon_rows( $group['links'] ?? null ) );
	}
	$count = sprintf( _n( '%s link', '%s links', $link_count, 'aeon-theme' ), number_format_i18n( $link_count ) );
}

$panel_id = aeon_section_id( $anchor . '-panel' );

?>
<section class="directory" data-block="directory" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<button type="button" class="directory__toggle js-disclosure" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>">
			<span class="directory__headline">
				<span class="directory__title"><?php echo esc_html( $title ); ?></span>
				<span class="directory__count t-mono"><?php echo esc_html( $count ); ?></span>
			</span>
			<span class="directory__chevron"><svg width="13" height="9" viewBox="0 0 13 9" aria-hidden="true" focusable="false"><path d="M1 1l5.5 5.5L12 1" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
		</button>
		<div class="directory__panel" id="<?php echo esc_attr( $panel_id ); ?>" inert>
			<div class="directory__grid">
				<?php foreach ( $groups as $group ) :
					$links = aeon_rows( $group['links'] ?? null );
					?>
				<div>
					<p class="directory__group-title t-mono"><?php echo esc_html( $group['group_title'] ?? '' ); ?></p>
					<ul class="directory__list">
						<?php foreach ( $links as $link ) : ?>
							<li><a class="directory__link" href="<?php echo esc_url( $link['url'] ?? '#' ); ?>"><?php echo esc_html( $link['label'] ?? '' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

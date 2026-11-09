<?php
if ( ! defined( 'ABSPATH' ) || post_password_required() ) {
	return;
}
?>
<section id="comments" class="aeon-comments">
	<?php if ( have_comments() ) : ?>
		<h2><?php esc_html_e( 'Comments', 'aeon-theme' ); ?></h2>
		<ol class="aeon-comments__list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>

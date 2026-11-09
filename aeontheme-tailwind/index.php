<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<section class="aeon-archive">
	<div class="aeon-container">
		<?php if ( is_search() ) : ?>
			<h1><?php printf( esc_html__( 'Search results for %s', 'aeon-theme' ), get_search_query() ); ?></h1>
		<?php elseif ( is_archive() ) : ?>
			<?php the_archive_title( '<h1>', '</h1>' ); ?>
		<?php elseif ( is_404() ) : ?>
			<h1><?php esc_html_e( 'Page not found', 'aeon-theme' ); ?></h1>
		<?php else : ?>
			<h1><?php esc_html_e( 'Latest posts', 'aeon-theme' ); ?></h1>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'post-card' ); ?>>
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
							<a class="post-card__media" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'aeon-card' ); ?></a>
						<?php endif; ?>
						<div class="post-card__body">
							<h2 class="post-card__title t-display-tight"><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ?: __( 'Untitled', 'aeon-theme' ) ); ?></a></h2>
							<?php echo wp_kses_post( apply_filters( 'the_excerpt', get_the_excerpt() ) ); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No content found.', 'aeon-theme' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();

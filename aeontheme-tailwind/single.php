<?php
/**
 * Default WordPress single post template — applies automatically to every
 * blog post, no page builder involved. Content comes from the normal post
 * editor (featured image, content, excerpt) and its assigned Category.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$cats = get_the_category();
		$primary_cat = null;
		foreach ( $cats as $cat ) {
			if ( $cat->parent ) {
				$primary_cat = $cat;
				break;
			}
		}
		$blog_url = aeon_blog_url();
		$word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
		$read_min = max( 1, (int) ceil( $word_count / 200 ) );
		?>

<section class="post-header" data-block="post-header" id="top">
	<div class="aeon-container">
		<a class="post-header__back t-mono" href="<?php echo esc_url( $blog_url ); ?>"><svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true" focusable="false"><path d="M11 3.5L5.5 9l5.5 5.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>All posts</a>
		<div class="post-header__meta">
			<?php if ( $primary_cat ) : ?><a class="post-header__tag t-mono" href="<?php echo esc_url( $blog_url ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a><?php endif; ?>
			<span class="post-header__date t-mono"><?php echo esc_html( get_the_date( 'F Y' ) ); ?> &middot; <?php echo (int) $read_min; ?> min read</span>
		</div>
		<h1 class="post-header__title t-display-tight"><?php the_title(); ?></h1>
		<?php $standfirst = get_the_excerpt(); ?>
		<?php if ( $standfirst ) : ?><p class="post-header__standfirst"><?php echo esc_html( $standfirst ); ?></p><?php endif; ?>
	</div>
</section>

<section class="post-body" data-block="post-body">
	<div class="aeon-container">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<figure class="post-body__lead-media"><?php the_post_thumbnail( 'aeon-hero' ); ?></figure>
		<?php endif; ?>
		<div class="post-body__layout">
			<article class="post-body__article">
				<?php
				if ( post_password_required() ) {
					echo get_the_password_form();
				} else {
					the_content();
					wp_link_pages();
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				}
				?>
			</article>
			<aside class="post-body__aside">
				<div class="post-aside__block post-aside__block--lead">
					<p class="post-aside__label t-mono"><?php echo esc_html( aeon_option( 'written_by_text', 'Written by' ) ); ?></p>
					<p class="post-aside__name"><?php echo esc_html( aeon_option( 'post_author_name', get_the_author() ) ); ?></p>
					<p class="post-aside__text"><?php echo esc_html( aeon_option( 'post_author_bio', get_the_author_meta( 'description' ) ) ); ?></p>
				</div>
				<?php if ( $primary_cat ) : ?>
				<div class="post-aside__block">
					<p class="post-aside__label t-mono"><?php echo esc_html( aeon_option( 'filed_under_text_label', 'Filed under' ) ); ?></p>
					<a class="post-aside__tag t-mono" href="<?php echo esc_url( $blog_url ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
				</div>
				<?php endif; ?>
			</aside>
		</div>
	</div>
</section>

<?php
$related_ids = array( get_the_ID() );
$related_posts = array();
if ( $primary_cat ) {
	$same_cat = get_posts( array( 'post_type' => 'post', 'posts_per_page' => 3, 'post__not_in' => $related_ids, 'category' => $primary_cat->term_id, 'orderby' => 'date' ) );
	$related_posts = array_merge( $related_posts, $same_cat );
	$related_ids = array_merge( $related_ids, wp_list_pluck( $same_cat, 'ID' ) );
}
if ( count( $related_posts ) < 3 ) {
	$fill = get_posts( array( 'post_type' => 'post', 'posts_per_page' => 3 - count( $related_posts ), 'post__not_in' => $related_ids, 'orderby' => 'date' ) );
	$related_posts = array_merge( $related_posts, $fill );
}
$related = new WP_Query( array( 'post_type' => 'post', 'post__in' => wp_list_pluck( $related_posts, 'ID' ) ?: array( 0 ), 'orderby' => 'post__in' ) );
if ( $related->have_posts() ) :
	?>
<section class="aeon-section aeon-section--bone-2" data-block="related-posts">
	<div class="aeon-container">
		<div class="section-title">
			<div>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( aeon_option( 'related_posts_heading', 'Keep reading' ) ); ?></h2>
			</div>
			<div class="section-title__aside"><a class="btn-arrow" href="<?php echo esc_url( $blog_url ); ?>">All posts<svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a></div>
		</div>
		<div class="post-grid">
			<?php while ( $related->have_posts() ) : $related->the_post();
				$r_cats = get_the_category();
				$r_tag = '';
				foreach ( $r_cats as $rc ) { if ( $rc->parent ) { $r_tag = $rc->name; break; } }
				$r_words = str_word_count( wp_strip_all_tags( get_the_content() ) );
				$r_min = max( 1, (int) ceil( $r_words / 200 ) );
				?>
				<article class="post-card">
					<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<a class="post-card__media" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'aeon-card' ); ?></a>
					<?php endif; ?>
					<div class="post-card__body">
						<?php if ( $r_tag ) : ?><p class="post-card__tag-static t-mono"><?php echo esc_html( $r_tag ); ?></p><?php endif; ?>
						<h3 class="post-card__title t-display-tight"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="post-card__meta t-mono"><?php echo esc_html( get_the_date( 'F Y' ) ); ?> &middot; <?php echo (int) $r_min; ?> min</p>
					</div>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
		get_template_part( 'template-parts/blog-cta' );
	endwhile;
endif;

get_footer();

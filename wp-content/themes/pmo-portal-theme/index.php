<?php
/**
 * Main template file - Blog/Archive
 *
 * @package PMO_Portal_Theme
 */

get_header(); ?>

<main id="main-content" class="site-content">
	<div class="container">
		<div style="grid-template-columns: 1fr;">
			<header class="page-header">
				<?php
				if ( is_home() ) {
					?>
					<h1 class="page-title"><?php esc_html_e( 'Latest News', 'pmo-portal' ); ?></h1>
					<?php
				} elseif ( is_archive() ) {
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				} elseif ( is_search() ) {
					?>
					<h1 class="page-title">
						<?php
						printf(
							esc_html__( 'Search Results for: %s', 'pmo-portal' ),
							'<span>' . get_search_query() . '</span>'
						);
						?>
					</h1>
					<?php
				}
				?>
			</header>
		</div>

		<div style="grid-template-columns: 1fr;">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
						<h2 class="post-title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						<p class="post-meta">
							<?php
							printf(
								esc_html__( 'By %1$s on %2$s', 'pmo-portal' ),
								get_the_author(),
								get_the_date()
							);
							?>
						</p>
						<div class="entry-content">
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink(); ?>" class="btn btn-primary">
								<?php esc_html_e( 'Read More', 'pmo-portal' ); ?>
							</a>
						</div>
					</article>
					<?php
				}

				// Pagination
				the_posts_pagination( array(
					'prev_text' => esc_html__( '← Previous', 'pmo-portal' ),
					'next_text' => esc_html__( 'Next →', 'pmo-portal' ),
				) );
			} else {
				?>
				<div class="no-results">
					<h2><?php esc_html_e( 'Nothing Found', 'pmo-portal' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'pmo-portal' ); ?></p>
					<?php get_search_form(); ?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</main>

<?php get_footer();

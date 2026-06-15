<?php
/**
 * Template part for displaying posts
 *
 * @package PMO_Portal_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<header class="post-header">
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="post-title">', '</h1>' );
		} else {
			the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
		<div class="post-meta">
			<span class="post-author">
				<?php esc_html_e( 'By ', 'pmo-portal' ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php the_author(); ?>
				</a>
			</span>
			<span class="post-date">
				<?php esc_html_e( ' on ', 'pmo-portal' ); ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</a>
			</span>
		</div>
	</header>

	<?php
	if ( has_post_thumbnail() ) {
		?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
		</div>
		<?php
	}
	?>

	<div class="post-content">
		<?php
		if ( is_singular() ) {
			the_content( sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'pmo-portal' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pmo-portal' ),
				'after'  => '</div>',
			) );
		} else {
			the_excerpt();
		}
		?>
	</div>

	<footer class="post-footer">
		<?php
		$categories = get_the_category();
		if ( $categories ) {
			echo '<div class="post-categories">';
			echo esc_html__( 'Categories: ', 'pmo-portal' );
			foreach ( $categories as $category ) {
				echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a> ';
			}
			echo '</div>';
		}

		$tags = get_the_tags();
		if ( $tags ) {
			echo '<div class="post-tags">';
			echo esc_html__( 'Tags: ', 'pmo-portal' );
			foreach ( $tags as $tag ) {
				echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a> ';
			}
			echo '</div>';
		}
		?>
	</footer>
</article>

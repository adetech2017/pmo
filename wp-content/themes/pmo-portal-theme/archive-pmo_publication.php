<?php
/**
 * Archive template for Publications
 *
 * @package PMO_Portal_Theme
 */

get_header(); ?>

<main id="main-content" class="site-content">
	<div class="container">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Publications', 'pmo-portal' ); ?></h1>
			<p class="archive-description">
				<?php esc_html_e( 'Reports, policies, and official documents.', 'pmo-portal' ); ?>
			</p>
		</header>

		<div class="row">
			<div class="col" style="grid-column: 1 / -2;">
				<?php if ( have_posts() ) : ?>
					<table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
						<thead>
							<tr style="background: var(--primary-color); color: white;">
								<th style="padding: 12px; text-align: left;"><?php esc_html_e( 'Title', 'pmo-portal' ); ?></th>
								<th style="padding: 12px; text-align: left;"><?php esc_html_e( 'Category', 'pmo-portal' ); ?></th>
								<th style="padding: 12px; text-align: center;"><?php esc_html_e( 'Download', 'pmo-portal' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php while ( have_posts() ) : ?>
								<?php the_post(); ?>
								<tr style="border-bottom: 1px solid #ddd;">
									<td style="padding: 12px;">
										<a href="<?php the_permalink(); ?>" style="color: var(--primary-color); font-weight: 600;">
											<?php the_title(); ?>
										</a>
									</td>
									<td style="padding: 12px;">
										<?php
										$terms = get_the_terms( get_the_ID(), 'pmo_publication_category' );
										if ( $terms ) {
											foreach ( $terms as $term ) {
												echo '<span style="background: #f0f0f0; padding: 3px 8px; border-radius: 3px;">' . esc_html( $term->name ) . '</span> ';
											}
										}
										?>
									</td>
									<td style="padding: 12px; text-align: center;">
										<?php
										$doc_id = get_post_meta( get_the_ID(), '_pmo_document_id', true );
										if ( $doc_id ) {
											$doc_url = wp_get_attachment_url( $doc_id );
											echo '<a href="' . esc_url( $doc_url ) . '" target="_blank" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">📥 Download</a>';
										}
										?>
									</td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				<?php else : ?>
					<p><?php esc_html_e( 'No publications found.', 'pmo-portal' ); ?></p>
				<?php endif; ?>
			</div>

			<div class="col">
				<?php get_sidebar(); ?>
			</div>
		</div>

		<?php the_posts_pagination(); ?>
	</div>
</main>

<?php get_footer();

<?php
/**
 * Archive Projects Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <section class="page-header" style="background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light)); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop);">
    <div class="container">
      <h1 style="color: var(--color-white); margin-bottom: var(--space-2);">Programmes & Projects</h1>
      <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 0;">Discover all projects and monitoring programmes</p>
    </div>
  </section>

  <div class="container" style="padding-top: var(--space-16); padding-bottom: var(--space-16);">
    <?php if ( have_posts() ) { ?>
      <div class="grid grid-3">
        <?php while ( have_posts() ) { ?>
          <?php the_post(); ?>
          <div class="card" style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); overflow: hidden; transition: all var(--transition-base);">
            <?php if ( has_post_thumbnail() ) { ?>
              <div style="height: 200px; overflow: hidden; background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light));">
                <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
              </div>
            <?php } ?>
            <div style="padding: var(--space-6);">
              <h3 style="font-size: var(--font-size-h4); margin-bottom: var(--space-3);">
                <a href="<?php the_permalink(); ?>" style="color: var(--color-primary); text-decoration: none;">
                  <?php the_title(); ?>
                </a>
              </h3>
              <p style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4);">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?>
              </p>
              <?php
              $progress = get_post_meta( get_the_ID(), '_pmo_progress_percentage', true );
              if ( $progress ) {
              ?>
              <div style="margin-bottom: var(--space-4);">
                <div style="font-size: var(--font-size-caption); color: var(--color-gray-600); margin-bottom: var(--space-2);">Progress</div>
                <div style="height: 6px; background: var(--color-gray-200); border-radius: var(--radius-full); overflow: hidden;">
                  <div style="background: var(--color-success); height: 100%; width: <?php echo esc_attr( $progress ); ?>%; transition: width 0.3s;"></div>
                </div>
              </div>
              <?php } ?>
              <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="width: 100%; text-align: center;">View Details</a>
            </div>
          </div>
        <?php } ?>
      </div>

      <div style="margin-top: var(--space-12); text-align: center;">
        <?php the_posts_pagination( array(
          'prev_text' => esc_html__( '← Previous', 'pmo-portal' ),
          'next_text' => esc_html__( 'Next →', 'pmo-portal' ),
        ) ); ?>
      </div>
    <?php } else { ?>
      <div style="text-align: center; padding: var(--space-20);">
        <h2 style="color: var(--color-primary); margin-bottom: var(--space-4);">No Projects Found</h2>
        <p style="color: var(--color-gray-600); margin-bottom: var(--space-8);">Check back soon for upcoming projects</p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Back to Home</a>
      </div>
    <?php } ?>
  </div>
</main>

<?php get_footer();
?>

<style>
  .card:hover {
    box-shadow: var(--shadow-lg);
    border-color: var(--color-accent);
    transform: translateY(-4px);
  }
</style>

<?php
// REMOVE BELOW - OLD CODE DEPRECATED
/*
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Our Projects', 'pmo-portal' ); ?></h1>
			<p class="archive-description">
				<?php esc_html_e( 'Browse all ongoing and completed projects across Lagos State.', 'pmo-portal' ); ?>
			</p>
		</header>

		<!-- Filters Section -->
		<div style="background: #f9f9f9; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
			<h3><?php esc_html_e( 'Filter Projects', 'pmo-portal' ); ?></h3>
			<form method="get" action="" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
				<div>
					<label for="filter_category"><?php esc_html_e( 'Category:', 'pmo-portal' ); ?></label>
					<?php
					$categories = get_terms( array(
						'taxonomy'   => 'pmo_project_category',
						'hide_empty' => true,
					) );
					?>
					<select name="category" id="filter_category" style="width: 100%; padding: 8px;">
						<option value=""><?php esc_html_e( 'All Categories', 'pmo-portal' ); ?></option>
						<?php foreach ( $categories as $category ) : ?>
							<option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( get_query_var( 'pmo_project_category' ), $category->slug ); ?>>
								<?php echo esc_html( $category->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div>
					<label for="filter_status"><?php esc_html_e( 'Status:', 'pmo-portal' ); ?></label>
					<?php
					$statuses = get_terms( array(
						'taxonomy'   => 'pmo_project_status',
						'hide_empty' => true,
					) );
					?>
					<select name="status" id="filter_status" style="width: 100%; padding: 8px;">
						<option value=""><?php esc_html_e( 'All Status', 'pmo-portal' ); ?></option>
						<?php foreach ( $statuses as $status ) : ?>
							<option value="<?php echo esc_attr( $status->slug ); ?>" <?php selected( get_query_var( 'pmo_project_status' ), $status->slug ); ?>>
								<?php echo esc_html( $status->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div style="display: flex; align-items: flex-end;">
					<button type="submit" class="btn" style="width: 100%;">
						<?php esc_html_e( 'Filter', 'pmo-portal' ); ?>
					</button>
				</div>
			</form>
		</div>

		<!-- Projects Grid -->
		<div class="row">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="col" style="grid-column: span 1; min-height: 400px;">
						<div class="post" style="height: 100%; display: flex; flex-direction: column;">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="post-thumbnail" style="flex-shrink: 0;">
									<?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
								</div>
							<?php endif; ?>

							<div style="flex: 1; display: flex; flex-direction: column;">
								<h2 class="post-title">
									<a href="<?php the_permalink(); ?>" style="color: var(--primary-color);">
										<?php the_title(); ?>
									</a>
								</h2>

								<?php
								$project_code = get_post_meta( get_the_ID(), '_pmo_project_code', true );
								if ( $project_code ) {
									echo '<p style="color: #7f8c8d; font-size: 12px;"><strong>Code:</strong> ' . esc_html( $project_code ) . '</p>';
								}
								?>

								<div class="post-meta" style="font-size: 12px;">
									<?php
									$terms = get_the_terms( get_the_ID(), 'pmo_project_status' );
									if ( $terms ) {
										foreach ( $terms as $term ) {
											echo '<span style="background: #007cba; color: white; padding: 3px 8px; border-radius: 3px; margin-right: 5px;">' . esc_html( $term->name ) . '</span>';
										}
									}
									?>
								</div>

								<?php
								$progress = get_post_meta( get_the_ID(), '_pmo_progress_percentage', true );
								if ( $progress ) {
									?>
									<div style="margin: 10px 0;">
										<small><?php esc_html_e( 'Progress:', 'pmo-portal' ); ?></small>
										<div style="height: 20px; background: #f0f0f0; border-radius: 3px; overflow: hidden;">
											<div style="background: #27ae60; height: 100%; width: <?php echo esc_attr( $progress ); ?>%; transition: width 0.3s;"></div>
										</div>
										<small><?php echo esc_html( $progress . '%' ); ?></small>
									</div>
									<?php
								}
								?>

								<p class="post-excerpt" style="flex: 1; margin-top: 10px;">
									<?php
									echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 20 );
									?>
								</p>

								<a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="align-self: flex-start; margin-top: auto;">
									<?php esc_html_e( 'View Details', 'pmo-portal' ); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			<?php else : ?>
				<div class="col" style="grid-column: 1 / -1;">
					<p><?php esc_html_e( 'No projects found.', 'pmo-portal' ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<!-- Pagination -->
		<?php the_posts_pagination(); ?>
	</div>
</main>

<?php get_footer();

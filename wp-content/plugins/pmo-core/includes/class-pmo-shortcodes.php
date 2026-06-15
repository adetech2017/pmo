<?php
/**
 * PMO Shortcodes
 *
 * Provides shortcodes for displaying projects, news, events, leadership
 *
 * @package PMO_Core
 */

class PMO_Shortcodes {

	/**
	 * Initialize shortcodes
	 */
	public static function init() {
		add_shortcode( 'pmo_projects', array( __CLASS__, 'shortcode_projects' ) );
		add_shortcode( 'pmo_featured_projects', array( __CLASS__, 'shortcode_projects' ) );
		add_shortcode( 'pmo_news', array( __CLASS__, 'shortcode_news' ) );
		add_shortcode( 'pmo_latest_news', array( __CLASS__, 'shortcode_news' ) );
		add_shortcode( 'pmo_events', array( __CLASS__, 'shortcode_events' ) );
		add_shortcode( 'pmo_upcoming_events', array( __CLASS__, 'shortcode_events' ) );
		add_shortcode( 'pmo_leadership', array( __CLASS__, 'shortcode_leadership' ) );
		add_shortcode( 'pmo_publications', array( __CLASS__, 'shortcode_publications' ) );
		add_shortcode( 'pmo_home_hero', array( __CLASS__, 'shortcode_hero' ) );
		add_shortcode( 'pmo_statistics_dashboard', array( __CLASS__, 'shortcode_statistics' ) );
		add_shortcode( 'pmo_leadership_message', array( __CLASS__, 'shortcode_leadership_message' ) );
		add_shortcode( 'pmo_cta_section', array( __CLASS__, 'shortcode_cta_section' ) );
	}

	/**
	 * Hero section shortcode
	 */
	public static function shortcode_hero( $atts ) {
		$atts = shortcode_atts( array(
			'title'       => 'Transparent Project Delivery',
			'description' => 'Monitor infrastructure projects across Lagos State in real-time',
			'button_text' => 'Explore Projects',
			'button_url'  => '#projects',
		), $atts );

		ob_start();
		?>
		<section class="pmo-hero" style="background: linear-gradient(135deg, #006B3F, #0D8659); color: white; padding: 80px 2rem; text-align: center;">
			<div class="container">
				<h1 style="font-size: 3.5rem; margin-bottom: 1rem; font-weight: 700;">
					<?php echo esc_html( $atts['title'] ); ?>
				</h1>
				<p style="font-size: 1.125rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
					<?php echo esc_html( $atts['description'] ); ?>
				</p>
				<a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn btn-secondary">
					<?php echo esc_html( $atts['button_text'] ); ?>
				</a>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}

	/**
	 * Statistics dashboard shortcode
	 */
	public static function shortcode_statistics( $atts ) {
		ob_start();
		?>
		<section style="padding: 60px 2rem; background: var(--color-gray-50);">
			<div class="container">
				<div class="grid-4">
					<div class="card card-elevated" style="text-align: center; padding: 2rem;">
						<div style="font-size: 2.5rem; font-weight: 700; color: var(--color-primary); margin-bottom: 0.5rem;">324</div>
						<div style="font-size: 1rem; color: var(--color-gray-600);">Total Projects</div>
					</div>
					<div class="card card-elevated" style="text-align: center; padding: 2rem;">
						<div style="font-size: 2.5rem; font-weight: 700; color: var(--color-success); margin-bottom: 0.5rem;">187</div>
						<div style="font-size: 1rem; color: var(--color-gray-600);">Completed</div>
					</div>
					<div class="card card-elevated" style="text-align: center; padding: 2rem;">
						<div style="font-size: 2.5rem; font-weight: 700; color: var(--color-warning); margin-bottom: 0.5rem;">89</div>
						<div style="font-size: 1rem; color: var(--color-gray-600);">In Progress</div>
					</div>
					<div class="card card-elevated" style="text-align: center; padding: 2rem;">
						<div style="font-size: 2.5rem; font-weight: 700; color: var(--color-info); margin-bottom: 0.5rem;">20</div>
						<div style="font-size: 1rem; color: var(--color-gray-600);">LGAs Covered</div>
					</div>
				</div>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}

	/**
	 * Projects shortcode
	 * Usage: [pmo_projects count="6" category="roads" layout="grid"]
	 */
	public static function shortcode_projects( $atts ) {
		$atts = shortcode_atts( array(
			'count'     => 6,
			'category'  => '',
			'status'    => '',
			'layout'    => 'grid',
			'title'     => 'Featured Projects',
		), $atts );

		$args = array(
			'post_type'      => 'pmo_project',
			'posts_per_page' => intval( $atts['count'] ),
			'post_status'    => 'publish',
		);

		if ( ! empty( $atts['category'] ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'pmo_project_category',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $atts['category'] ),
			);
		}

		if ( ! empty( $atts['status'] ) ) {
			if ( empty( $args['tax_query'] ) ) {
				$args['tax_query'] = array();
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'pmo_project_status',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $atts['status'] ),
			);
		}

		$query = new WP_Query( $args );

		ob_start();
		?>
		<section style="padding: 60px 2rem;">
			<div class="container">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h2 style="text-align: center; margin-bottom: 3rem;"><?php echo esc_html( $atts['title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( $query->have_posts() ) : ?>
					<div class="grid-3">
						<?php while ( $query->have_posts() ) : ?>
							<?php $query->the_post(); ?>
							<div class="card" style="display: flex; flex-direction: column; overflow: hidden; transition: all 200ms;">
								<?php if ( has_post_thumbnail() ) : ?>
									<div style="height: 200px; overflow: hidden; background: linear-gradient(135deg, #006B3F, #0D8659);">
										<?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
									</div>
								<?php else : ?>
									<div style="height: 200px; background: linear-gradient(135deg, #006B3F, #0D8659);"></div>
								<?php endif; ?>
								<div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
									<div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase; margin-bottom: 0.5rem;">
										<?php
										$terms = get_the_terms( get_the_ID(), 'pmo_project_category' );
										if ( $terms ) {
											echo esc_html( $terms[0]->name );
										}
										?>
									</div>
									<h3 style="color: var(--color-primary); margin: 0 0 1rem 0; font-size: 1.25rem;">
										<a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
											<?php the_title(); ?>
										</a>
									</h3>
									<?php
									$progress = get_post_meta( get_the_ID(), '_pmo_progress_percentage', true );
									if ( $progress ) {
										?>
										<div style="margin: 1rem 0;">
											<div style="display: flex; justify-content: space-between; font-size: 0.875rem; margin-bottom: 0.5rem;">
												<span>Progress</span>
												<span><?php echo esc_html( $progress ); ?>%</span>
											</div>
											<div class="progress">
												<div class="progress-bar" style="width: <?php echo esc_attr( $progress ); ?>%;"></div>
											</div>
										</div>
										<?php
									}
									?>
									<a href="<?php the_permalink(); ?>" class="btn btn-primary" style="margin-top: auto; width: 100%; text-align: center;">
										View Details
									</a>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="text-center"><?php esc_html_e( 'No projects found.', 'pmo-core' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * News shortcode
	 * Usage: [pmo_news count="5" featured="1"]
	 */
	public static function shortcode_news( $atts ) {
		$atts = shortcode_atts( array(
			'count'    => 5,
			'featured' => 0,
			'title'    => 'Latest News',
		), $atts );

		$args = array(
			'post_type'      => 'pmo_news',
			'posts_per_page' => intval( $atts['count'] ),
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		if ( $atts['featured'] ) {
			$args['meta_query'] = array(
				array(
					'key'   => '_pmo_featured',
					'value' => '1',
				),
			);
		}

		$query = new WP_Query( $args );

		ob_start();
		?>
		<section style="padding: 60px 2rem; background: var(--color-gray-50);">
			<div class="container">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h2 style="text-align: center; margin-bottom: 3rem;"><?php echo esc_html( $atts['title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( $query->have_posts() ) : ?>
					<div class="grid-3">
						<?php while ( $query->have_posts() ) : ?>
							<?php $query->the_post(); ?>
							<div class="card">
								<?php if ( has_post_thumbnail() ) : ?>
									<div style="height: 200px; overflow: hidden; margin: -1.5rem -1.5rem 1.5rem -1.5rem;">
										<?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
									</div>
								<?php endif; ?>
								<h3 style="color: var(--color-primary); margin: 0 0 0.5rem 0; font-size: 1.25rem;">
									<a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
										<?php the_title(); ?>
									</a>
								</h3>
								<p style="font-size: 0.875rem; color: var(--color-gray-500); margin: 0 0 1rem 0;">
									<?php echo esc_html( get_the_date() ); ?>
								</p>
								<p style="color: var(--color-gray-700); margin: 0 0 1rem 0;">
									<?php echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 20 ); ?>
								</p>
								<a href="<?php the_permalink(); ?>" class="btn btn-text">
									Read More →
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="text-center"><?php esc_html_e( 'No news found.', 'pmo-core' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Events shortcode
	 * Usage: [pmo_events count="3"]
	 */
	public static function shortcode_events( $atts ) {
		$atts = shortcode_atts( array(
			'count' => 3,
			'title' => 'Upcoming Events',
		), $atts );

		$args = array(
			'post_type'      => 'pmo_event',
			'posts_per_page' => intval( $atts['count'] ),
			'post_status'    => 'publish',
			'orderby'        => 'meta_value',
			'meta_key'       => '_pmo_event_date',
			'order'          => 'ASC',
		);

		$query = new WP_Query( $args );

		ob_start();
		?>
		<section style="padding: 60px 2rem;">
			<div class="container">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h2 style="text-align: center; margin-bottom: 3rem;"><?php echo esc_html( $atts['title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( $query->have_posts() ) : ?>
					<div class="grid-3">
						<?php while ( $query->have_posts() ) : ?>
							<?php $query->the_post(); ?>
							<div class="card" style="border-left: 4px solid var(--color-secondary);">
								<?php
								$event_date = get_post_meta( get_the_ID(), '_pmo_event_date', true );
								$event_time = get_post_meta( get_the_ID(), '_pmo_event_time', true );
								if ( $event_date ) {
									?>
									<div class="badge badge-warning" style="display: block; text-align: center; margin-bottom: 1rem;">
										<strong><?php echo esc_html( wp_date( 'M j, Y', strtotime( $event_date ) ) ); ?></strong>
										<?php if ( $event_time ) : ?>
											<br><small><?php echo esc_html( $event_time ); ?></small>
										<?php endif; ?>
									</div>
									<?php
								}
								?>
								<h3 style="color: var(--color-primary); margin: 0 0 1rem 0; font-size: 1.25rem;">
									<a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
										<?php the_title(); ?>
									</a>
								</h3>
								<?php
								$venue = get_post_meta( get_the_ID(), '_pmo_venue', true );
								if ( $venue ) {
									echo '<p style="margin: 0 0 1rem 0; font-size: 0.875rem; color: var(--color-gray-600);">📍 ' . esc_html( $venue ) . '</p>';
								}
								?>
								<a href="<?php the_permalink(); ?>" class="btn btn-text">
									Learn More →
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="text-center"><?php esc_html_e( 'No upcoming events found.', 'pmo-core' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Leadership shortcode
	 * Usage: [pmo_leadership count="6" level="management-team"]
	 */
	public static function shortcode_leadership( $atts ) {
		$atts = shortcode_atts( array(
			'count' => 6,
			'level' => '',
			'title' => 'Our Leadership',
		), $atts );

		$args = array(
			'post_type'      => 'pmo_leadership',
			'posts_per_page' => intval( $atts['count'] ),
			'post_status'    => 'publish',
		);

		if ( ! empty( $atts['level'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'pmo_leadership_level',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $atts['level'] ),
				),
			);
		}

		$query = new WP_Query( $args );

		ob_start();
		?>
		<section style="padding: 60px 2rem; background: var(--color-gray-50);">
			<div class="container">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h2 style="text-align: center; margin-bottom: 3rem;"><?php echo esc_html( $atts['title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( $query->have_posts() ) : ?>
					<div class="grid-4">
						<?php while ( $query->have_posts() ) : ?>
							<?php $query->the_post(); ?>
							<div class="card" style="text-align: center;">
								<?php if ( has_post_thumbnail() ) : ?>
									<div style="width: 100%; height: 200px; overflow: hidden; border-radius: var(--radius-lg); margin-bottom: 1rem;">
										<?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
									</div>
								<?php endif; ?>
								<h3 style="color: var(--color-primary); margin: 0 0 0.5rem 0;">
									<?php the_title(); ?>
								</h3>
								<?php
								$job_title = get_post_meta( get_the_ID(), '_pmo_job_title', true );
								if ( $job_title ) {
									echo '<p style="margin: 0 0 1rem 0; color: var(--color-secondary); font-weight: 600;">' . esc_html( $job_title ) . '</p>';
								}
								?>
								<a href="<?php the_permalink(); ?>" class="btn btn-outline" style="width: 100%; text-align: center;">
									View Profile
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="text-center"><?php esc_html_e( 'No team members found.', 'pmo-core' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Publications shortcode
	 * Usage: [pmo_publications count="5" category="annual-reports"]
	 */
	public static function shortcode_publications( $atts ) {
		$atts = shortcode_atts( array(
			'count'    => 5,
			'category' => '',
			'title'    => 'Publications',
		), $atts );

		$args = array(
			'post_type'      => 'pmo_publication',
			'posts_per_page' => intval( $atts['count'] ),
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		if ( ! empty( $atts['category'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'pmo_publication_category',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $atts['category'] ),
				),
			);
		}

		$query = new WP_Query( $args );

		ob_start();
		?>
		<section style="padding: 60px 2rem;">
			<div class="container">
				<?php if ( ! empty( $atts['title'] ) ) : ?>
					<h2 style="text-align: center; margin-bottom: 3rem;"><?php echo esc_html( $atts['title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( $query->have_posts() ) : ?>
					<div class="grid-3">
						<?php while ( $query->have_posts() ) : ?>
							<?php $query->the_post(); ?>
							<div class="card">
								<h4 style="color: var(--color-primary); margin: 0 0 0.5rem 0;">
									<a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
										<?php the_title(); ?>
									</a>
								</h4>
								<?php
								$terms = get_the_terms( get_the_ID(), 'pmo_publication_category' );
								if ( $terms ) {
									echo '<p style="font-size: 0.875rem; color: var(--color-gray-500); margin: 0 0 1rem 0;">';
									foreach ( $terms as $term ) {
										echo '<span class="badge badge-outline">' . esc_html( $term->name ) . '</span> ';
									}
									echo '</p>';
								}
								?>
								<?php
								$doc_id = get_post_meta( get_the_ID(), '_pmo_document_id', true );
								if ( $doc_id ) {
									$doc_url = wp_get_attachment_url( $doc_id );
									echo '<a href="' . esc_url( $doc_url ) . '" target="_blank" class="btn btn-primary" style="display: inline-block; width: 100%; text-align: center;">📥 Download</a>';
								}
								?>
							</div>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="text-center"><?php esc_html_e( 'No publications found.', 'pmo-core' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Leadership message/quote section shortcode
	 * Usage: [pmo_leadership_message title="Message from Leadership" content="..."]
	 */
	public static function shortcode_leadership_message( $atts ) {
		$atts = shortcode_atts( array(
			'title'   => 'A Message from Leadership',
			'content' => 'The Lagos State Project Monitoring Office is committed to delivering transparent, accountable, and timely infrastructure projects that serve all citizens of Lagos State.',
			'author'  => 'Project Monitoring Office',
		), $atts );

		ob_start();
		?>
		<section style="background: linear-gradient(135deg, #006B3F, #0D8659); color: white; padding: 80px 2rem;">
			<div class="container" style="max-width: 800px; text-align: center;">
				<h2 style="color: white; margin-bottom: 2rem;"><?php echo esc_html( $atts['title'] ); ?></h2>
				<blockquote style="font-size: 1.25rem; line-height: 1.8; margin: 2rem 0; border-left: 4px solid var(--color-secondary); padding-left: 2rem; font-style: italic;">
					<?php echo wp_kses_post( $atts['content'] ); ?>
				</blockquote>
				<p style="font-weight: 600; margin: 0;">— <?php echo esc_html( $atts['author'] ); ?></p>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}

	/**
	 * Call-to-action section shortcode
	 * Usage: [pmo_cta_section title="Start Tracking Projects" button_text="Explore Now" button_url="#projects"]
	 */
	public static function shortcode_cta_section( $atts ) {
		$atts = shortcode_atts( array(
			'title'       => 'Ready to Explore Lagos Projects?',
			'description' => 'Access real-time updates, project details, and comprehensive monitoring information.',
			'button_text' => 'Get Started',
			'button_url'  => '#projects',
		), $atts );

		ob_start();
		?>
		<section style="background: var(--color-gray-50); padding: 60px 2rem;">
			<div class="container" style="max-width: 800px; text-align: center;">
				<h2 style="margin-bottom: 1.5rem;"><?php echo esc_html( $atts['title'] ); ?></h2>
				<p style="font-size: 1.125rem; color: var(--color-gray-600); margin-bottom: 2rem;">
					<?php echo esc_html( $atts['description'] ); ?>
				</p>
				<a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn btn-primary btn-lg">
					<?php echo esc_html( $atts['button_text'] ); ?>
				</a>
			</div>
		</section>
		<?php
		return ob_get_clean();
	}
}

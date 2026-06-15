<?php
/**
 * PMO Widgets
 *
 * Custom widgets for displaying dynamic content
 *
 * @package PMO_Core
 */

class PMO_Widgets {

	/**
	 * Initialize widgets
	 */
	public static function init() {
		add_action( 'widgets_init', array( __CLASS__, 'register_widgets' ) );
	}

	/**
	 * Register widgets
	 */
	public static function register_widgets() {
		register_widget( 'PMO_Latest_News_Widget' );
		register_widget( 'PMO_Upcoming_Events_Widget' );
		register_widget( 'PMO_Recent_Projects_Widget' );
	}
}

/**
 * Latest News Widget
 */
class PMO_Latest_News_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'pmo_latest_news',
			__( 'PMO Latest News', 'pmo-core' ),
			array( 'description' => __( 'Display latest news from PMO', 'pmo-core' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] ?? __( 'Latest News', 'pmo-core' ) );
		$count = intval( $instance['count'] ?? 3 );

		echo wp_kses_post( $args['before_widget'] );

		if ( $title ) {
			echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
		}

		$query = new WP_Query( array(
			'post_type'      => 'pmo_news',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
		) );

		if ( $query->have_posts() ) {
			echo '<ul style="list-style: none; padding: 0;">';
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<li style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
					<a href="<?php the_permalink(); ?>" style="color: #007cba; text-decoration: none; font-weight: 600;">
						<?php the_title(); ?>
					</a>
					<br>
					<small style="color: #7f8c8d;"><?php echo esc_html( get_the_date() ); ?></small>
				</li>
				<?php
			}
			echo '</ul>';
		}

		wp_reset_postdata();
		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Latest News', 'pmo-core' );
		$count = intval( $instance['count'] ?? 3 );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'pmo-core' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php esc_html_e( 'Number of items:', 'pmo-core' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>" min="1" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = intval( $new_instance['count'] );
		return $instance;
	}
}

/**
 * Upcoming Events Widget
 */
class PMO_Upcoming_Events_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'pmo_upcoming_events',
			__( 'PMO Upcoming Events', 'pmo-core' ),
			array( 'description' => __( 'Display upcoming events from PMO', 'pmo-core' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] ?? __( 'Upcoming Events', 'pmo-core' ) );
		$count = intval( $instance['count'] ?? 3 );

		echo wp_kses_post( $args['before_widget'] );

		if ( $title ) {
			echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
		}

		$query = new WP_Query( array(
			'post_type'      => 'pmo_event',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
			'orderby'        => 'meta_value',
			'meta_key'       => '_pmo_event_date',
			'order'          => 'ASC',
		) );

		if ( $query->have_posts() ) {
			echo '<ul style="list-style: none; padding: 0;">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$event_date = get_post_meta( get_the_ID(), '_pmo_event_date', true );
				?>
				<li style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
					<?php if ( $event_date ) : ?>
						<small style="background: #f39c12; color: white; padding: 2px 6px; border-radius: 3px; display: inline-block; margin-bottom: 5px;">
							<?php echo esc_html( wp_date( 'M j', strtotime( $event_date ) ) ); ?>
						</small>
						<br>
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>" style="color: #007cba; text-decoration: none; font-weight: 600;">
						<?php the_title(); ?>
					</a>
				</li>
				<?php
			}
			echo '</ul>';
		}

		wp_reset_postdata();
		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Upcoming Events', 'pmo-core' );
		$count = intval( $instance['count'] ?? 3 );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'pmo-core' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php esc_html_e( 'Number of items:', 'pmo-core' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>" min="1" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = intval( $new_instance['count'] );
		return $instance;
	}
}

/**
 * Recent Projects Widget
 */
class PMO_Recent_Projects_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'pmo_recent_projects',
			__( 'PMO Recent Projects', 'pmo-core' ),
			array( 'description' => __( 'Display recent projects from PMO', 'pmo-core' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] ?? __( 'Recent Projects', 'pmo-core' ) );
		$count = intval( $instance['count'] ?? 3 );

		echo wp_kses_post( $args['before_widget'] );

		if ( $title ) {
			echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
		}

		$query = new WP_Query( array(
			'post_type'      => 'pmo_project',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
		) );

		if ( $query->have_posts() ) {
			echo '<ul style="list-style: none; padding: 0;">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$progress = get_post_meta( get_the_ID(), '_pmo_progress_percentage', true );
				?>
				<li style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #ddd;">
					<a href="<?php the_permalink(); ?>" style="color: #007cba; text-decoration: none; font-weight: 600;">
						<?php the_title(); ?>
					</a>
					<?php if ( $progress ) : ?>
						<div style="margin-top: 5px; font-size: 12px;">
							<div style="height: 8px; background: #f0f0f0; border-radius: 3px; overflow: hidden;">
								<div style="background: #27ae60; height: 100%; width: <?php echo esc_attr( $progress ); ?>%;"></div>
							</div>
							<small><?php echo esc_html( $progress . '%' ); ?></small>
						</div>
					<?php endif; ?>
				</li>
				<?php
			}
			echo '</ul>';
		}

		wp_reset_postdata();
		echo wp_kses_post( $args['after_widget'] );
	}

	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Recent Projects', 'pmo-core' );
		$count = intval( $instance['count'] ?? 3 );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'pmo-core' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php esc_html_e( 'Number of items:', 'pmo-core' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>" min="1" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = intval( $new_instance['count'] );
		return $instance;
	}
}

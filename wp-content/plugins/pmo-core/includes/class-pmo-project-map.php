<?php
/**
 * PMO Interactive Project Map
 *
 * Displays projects on an interactive Leaflet map
 *
 * @package PMO_Core
 */

class PMO_Project_Map {

	/**
	 * Initialize the map module
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
		add_shortcode( 'pmo_project_map', array( __CLASS__, 'render_map' ) );
		add_action( 'wp_ajax_pmo_get_projects_data', array( __CLASS__, 'ajax_get_projects_data' ) );
		add_action( 'wp_ajax_nopriv_pmo_get_projects_data', array( __CLASS__, 'ajax_get_projects_data' ) );
	}

	/**
	 * Enqueue Leaflet libraries and custom map scripts
	 */
	public static function enqueue_assets() {
		// Enqueue Leaflet CSS
		wp_enqueue_style(
			'leaflet-css',
			'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css',
			array(),
			'1.9.4'
		);

		// Enqueue Leaflet JS
		wp_enqueue_script(
			'leaflet-js',
			'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js',
			array(),
			'1.9.4',
			true
		);

		// Enqueue custom map script
		wp_enqueue_script(
			'pmo-project-map-js',
			PMO_CORE_URL . 'assets/js/project-map.js',
			array( 'jquery', 'leaflet-js' ),
			PMO_CORE_VERSION,
			true
		);

		// Pass data to JavaScript
		wp_localize_script( 'pmo-project-map-js', 'pmoMap', array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'nonce'       => wp_create_nonce( 'pmo_map_nonce' ),
			'centerLat'   => 6.5244,  // Lagos center
			'centerLng'   => 3.3792,
		) );
	}

	/**
	 * Render map shortcode
	 */
	public static function render_map( $atts ) {
		$atts = shortcode_atts( array(
			'height'  => '600px',
			'class'   => 'pmo-project-map',
			'zoom'    => 11,
		), $atts );

		ob_start();
		?>
		<div id="pmo-map-container" class="<?php echo esc_attr( $atts['class'] ); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: 100%; border-radius: 4px; overflow: hidden; margin: 20px 0;">
			<div id="pmo-map" style="height: 100%; width: 100%;"></div>
		</div>

		<!-- Map Filters -->
		<div style="background: #f9f9f9; padding: 20px; border-radius: 4px; margin-bottom: 20px;">
			<h4 style="margin-top: 0;">Filter Projects</h4>
			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
				<div>
					<label for="pmo-map-filter-category">Category:</label>
					<select id="pmo-map-filter-category" style="width: 100%; padding: 8px;">
						<option value="">All Categories</option>
						<?php
						$categories = get_terms( array(
							'taxonomy'   => 'pmo_project_category',
							'hide_empty' => true,
						) );
						foreach ( $categories as $cat ) {
							echo '<option value="' . esc_attr( $cat->slug ) . '">' . esc_html( $cat->name ) . '</option>';
						}
						?>
					</select>
				</div>

				<div>
					<label for="pmo-map-filter-status">Status:</label>
					<select id="pmo-map-filter-status" style="width: 100%; padding: 8px;">
						<option value="">All Status</option>
						<?php
						$statuses = get_terms( array(
							'taxonomy'   => 'pmo_project_status',
							'hide_empty' => true,
						) );
						foreach ( $statuses as $status ) {
							echo '<option value="' . esc_attr( $status->slug ) . '">' . esc_html( $status->name ) . '</option>';
						}
						?>
					</select>
				</div>

				<div>
					<label for="pmo-map-filter-lga">LGA:</label>
					<select id="pmo-map-filter-lga" style="width: 100%; padding: 8px;">
						<option value="">All LGAs</option>
						<?php
						$lgas = get_terms( array(
							'taxonomy'   => 'pmo_lga',
							'hide_empty' => true,
						) );
						foreach ( $lgas as $lga ) {
							echo '<option value="' . esc_attr( $lga->slug ) . '">' . esc_html( $lga->name ) . '</option>';
						}
						?>
					</select>
				</div>

				<div style="display: flex; align-items: flex-end;">
					<button id="pmo-map-refresh-btn" class="button button-primary" style="width: 100%;">
						Refresh Map
					</button>
				</div>
			</div>
		</div>

		<script>
		jQuery(document).ready(function($) {
			// Initialize map after Leaflet is loaded
			if (typeof L !== 'undefined') {
				PMO_ProjectMap.init(<?php echo (int) $atts['zoom']; ?>);
			} else {
				console.error('Leaflet not loaded');
			}
		});
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * AJAX endpoint to get projects data
	 */
	public static function ajax_get_projects_data() {
		check_ajax_referer( 'pmo_map_nonce', 'nonce' );

		$args = array(
			'post_type'      => 'pmo_project',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		);

		// Filter by category
		if ( ! empty( $_GET['category'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'pmo_project_category',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $_GET['category'] ),
				),
			);
		}

		// Filter by status
		if ( ! empty( $_GET['status'] ) ) {
			if ( empty( $args['tax_query'] ) ) {
				$args['tax_query'] = array();
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'pmo_project_status',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['status'] ),
			);
		}

		// Filter by LGA
		if ( ! empty( $_GET['lga'] ) ) {
			if ( empty( $args['tax_query'] ) ) {
				$args['tax_query'] = array();
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'pmo_lga',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['lga'] ),
			);
		}

		$project_ids = get_posts( $args );
		$projects    = array();

		foreach ( $project_ids as $project_id ) {
			$latitude  = get_post_meta( $project_id, '_pmo_latitude', true );
			$longitude = get_post_meta( $project_id, '_pmo_longitude', true );

			if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
				$status_terms = get_the_terms( $project_id, 'pmo_project_status' );
				$status_text  = $status_terms ? $status_terms[0]->name : 'Unknown';

				$projects[] = array(
					'id'        => $project_id,
					'title'     => get_the_title( $project_id ),
					'lat'       => floatval( $latitude ),
					'lng'       => floatval( $longitude ),
					'link'      => get_permalink( $project_id ),
					'status'    => $status_text,
					'progress'  => intval( get_post_meta( $project_id, '_pmo_progress_percentage', true ) ?? 0 ),
					'image'     => get_the_post_thumbnail_url( $project_id, 'thumbnail' ),
				);
			}
		}

		wp_send_json_success( $projects );
	}
}

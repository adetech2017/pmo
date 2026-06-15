<?php
/**
 * PMO Project Module
 *
 * Handles custom fields, meta boxes, and functionality for projects
 *
 * @package PMO_Core
 */

class PMO_Project_Module {

	/**
	 * Initialize the project module
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_pmo_project', array( __CLASS__, 'save_project_meta' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_fields' ) );
		add_filter( 'manage_pmo_project_posts_columns', array( __CLASS__, 'set_custom_columns' ) );
		add_action( 'manage_pmo_project_posts_custom_column', array( __CLASS__, 'render_custom_columns' ), 10, 2 );
	}

	/**
	 * Register meta boxes for projects
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'pmo_project_details',
			esc_html__( 'Project Details', 'pmo-core' ),
			array( __CLASS__, 'render_project_details_meta_box' ),
			'pmo_project',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_project_location',
			esc_html__( 'Project Location', 'pmo-core' ),
			array( __CLASS__, 'render_project_location_meta_box' ),
			'pmo_project',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_project_dates',
			esc_html__( 'Project Timeline', 'pmo-core' ),
			array( __CLASS__, 'render_project_dates_meta_box' ),
			'pmo_project',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_project_progress',
			esc_html__( 'Project Progress', 'pmo-core' ),
			array( __CLASS__, 'render_project_progress_meta_box' ),
			'pmo_project',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_project_media',
			esc_html__( 'Project Media', 'pmo-core' ),
			array( __CLASS__, 'render_project_media_meta_box' ),
			'pmo_project',
			'normal',
			'high'
		);
	}

	/**
	 * Render project details meta box
	 */
	public static function render_project_details_meta_box( $post ) {
		wp_nonce_field( 'pmo_project_nonce', 'pmo_project_nonce' );

		$project_code = get_post_meta( $post->ID, '_pmo_project_code', true );
		$funding_source = get_post_meta( $post->ID, '_pmo_funding_source', true );
		$contractor = get_post_meta( $post->ID, '_pmo_contractor', true );
		$budget = get_post_meta( $post->ID, '_pmo_budget', true );
		$beneficiaries = get_post_meta( $post->ID, '_pmo_beneficiaries', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
			<div>
				<label for="pmo_project_code">
					<strong><?php esc_html_e( 'Project Code:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_project_code"
					name="pmo_project_code"
					value="<?php echo esc_attr( $project_code ); ?>"
					placeholder="e.g., PROJ-2024-001"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_contractor">
					<strong><?php esc_html_e( 'Contractor Name:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_contractor"
					name="pmo_contractor"
					value="<?php echo esc_attr( $contractor ); ?>"
					placeholder="e.g., ABC Construction Ltd"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_budget">
					<strong><?php esc_html_e( 'Budget (₦):', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="number"
					id="pmo_budget"
					name="pmo_budget"
					value="<?php echo esc_attr( $budget ); ?>"
					placeholder="0.00"
					step="0.01"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_funding_source">
					<strong><?php esc_html_e( 'Funding Source:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_funding_source"
					name="pmo_funding_source"
					value="<?php echo esc_attr( $funding_source ); ?>"
					placeholder="e.g., State Budget, Federal, World Bank"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div style="grid-column: 1 / -1;">
				<label for="pmo_beneficiaries">
					<strong><?php esc_html_e( 'Number of Beneficiaries:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="number"
					id="pmo_beneficiaries"
					name="pmo_beneficiaries"
					value="<?php echo esc_attr( $beneficiaries ); ?>"
					placeholder="0"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>
		</div>
		<?php
	}

	/**
	 * Render project location meta box
	 */
	public static function render_project_location_meta_box( $post ) {
		$location = get_post_meta( $post->ID, '_pmo_location', true );
		$latitude = get_post_meta( $post->ID, '_pmo_latitude', true );
		$longitude = get_post_meta( $post->ID, '_pmo_longitude', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
			<div style="grid-column: 1 / -1;">
				<label for="pmo_location">
					<strong><?php esc_html_e( 'Location Address:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_location"
					name="pmo_location"
					value="<?php echo esc_attr( $location ); ?>"
					placeholder="Street address, area, or district"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_latitude">
					<strong><?php esc_html_e( 'Latitude:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_latitude"
					name="pmo_latitude"
					value="<?php echo esc_attr( $latitude ); ?>"
					placeholder="e.g., 6.5244"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_longitude">
					<strong><?php esc_html_e( 'Longitude:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_longitude"
					name="pmo_longitude"
					value="<?php echo esc_attr( $longitude ); ?>"
					placeholder="e.g., 3.3792"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>
		</div>
		<p style="color: #666; font-size: 12px; margin-top: 10px;">
			<?php esc_html_e( 'Use decimal format (e.g., 6.5244, 3.3792) for map coordinates.', 'pmo-core' ); ?>
		</p>
		<?php
	}

	/**
	 * Render project dates meta box
	 */
	public static function render_project_dates_meta_box( $post ) {
		$start_date = get_post_meta( $post->ID, '_pmo_start_date', true );
		$expected_completion = get_post_meta( $post->ID, '_pmo_expected_completion', true );
		$actual_completion = get_post_meta( $post->ID, '_pmo_actual_completion', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
			<div>
				<label for="pmo_start_date">
					<strong><?php esc_html_e( 'Start Date:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="date"
					id="pmo_start_date"
					name="pmo_start_date"
					value="<?php echo esc_attr( $start_date ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_expected_completion">
					<strong><?php esc_html_e( 'Expected Completion:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="date"
					id="pmo_expected_completion"
					name="pmo_expected_completion"
					value="<?php echo esc_attr( $expected_completion ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_actual_completion">
					<strong><?php esc_html_e( 'Actual Completion:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="date"
					id="pmo_actual_completion"
					name="pmo_actual_completion"
					value="<?php echo esc_attr( $actual_completion ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>
		</div>
		<?php
	}

	/**
	 * Render project progress meta box
	 */
	public static function render_project_progress_meta_box( $post ) {
		$progress = get_post_meta( $post->ID, '_pmo_progress_percentage', true );
		if ( '' === $progress ) {
			$progress = 0;
		}
		?>
		<div>
			<label for="pmo_progress_percentage">
				<strong><?php esc_html_e( 'Progress Percentage (0-100):', 'pmo-core' ); ?></strong>
			</label>
			<div style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
				<input
					type="range"
					id="pmo_progress_percentage"
					name="pmo_progress_percentage"
					min="0"
					max="100"
					value="<?php echo esc_attr( $progress ); ?>"
					style="flex: 1;"
					oninput="document.getElementById('progress_value').innerText = this.value + '%';"
				/>
				<span id="progress_value" style="min-width: 50px; font-weight: bold;">
					<?php echo esc_html( $progress . '%' ); ?>
				</span>
			</div>
			<div style="margin-top: 10px; background: #f0f0f0; height: 30px; border-radius: 4px; overflow: hidden;">
				<div style="background: #27ae60; height: 100%; width: <?php echo esc_attr( $progress ); ?>%; transition: width 0.3s;"></div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render project media meta box
	 */
	public static function render_project_media_meta_box( $post ) {
		$videos = get_post_meta( $post->ID, '_pmo_videos', true );
		$documents = get_post_meta( $post->ID, '_pmo_documents', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
			<div>
				<label for="pmo_videos">
					<strong><?php esc_html_e( 'Video URLs:', 'pmo-core' ); ?></strong>
				</label>
				<textarea
					id="pmo_videos"
					name="pmo_videos"
					placeholder="<?php esc_attr_e( 'Enter video URLs (one per line). Support: YouTube, Vimeo, etc.', 'pmo-core' ); ?>"
					style="width: 100%; height: 150px; padding: 8px; margin-top: 5px; font-family: monospace;"
				><?php echo esc_textarea( $videos ); ?></textarea>
			</div>

			<div>
				<label for="pmo_documents">
					<strong><?php esc_html_e( 'Document URLs:', 'pmo-core' ); ?></strong>
				</label>
				<textarea
					id="pmo_documents"
					name="pmo_documents"
					placeholder="<?php esc_attr_e( 'Enter document URLs (one per line). PDF, DOC, etc.', 'pmo-core' ); ?>"
					style="width: 100%; height: 150px; padding: 8px; margin-top: 5px; font-family: monospace;"
				><?php echo esc_textarea( $documents ); ?></textarea>
			</div>
		</div>
		<p style="color: #666; font-size: 12px; margin-top: 10px;">
			<?php esc_html_e( 'Use the featured image for the main project image. Upload media via the media library.', 'pmo-core' ); ?>
		</p>
		<?php
	}

	/**
	 * Save project meta
	 */
	public static function save_project_meta( $post_id ) {
		// Check nonce
		if ( ! isset( $_POST['pmo_project_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_project_nonce'], 'pmo_project_nonce' ) ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Define fields to save
		$fields = array(
			'pmo_project_code',
			'pmo_contractor',
			'pmo_budget',
			'pmo_funding_source',
			'pmo_beneficiaries',
			'pmo_location',
			'pmo_latitude',
			'pmo_longitude',
			'pmo_start_date',
			'pmo_expected_completion',
			'pmo_actual_completion',
			'pmo_progress_percentage',
			'pmo_videos',
			'pmo_documents',
		);

		foreach ( $fields as $field ) {
			$key = '_' . $field;
			if ( isset( $_POST[ $field ] ) ) {
				$value = sanitize_text_field( $_POST[ $field ] );
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	/**
	 * Register REST API fields
	 */
	public static function register_rest_fields() {
		$fields = array(
			'project_code',
			'contractor',
			'budget',
			'funding_source',
			'beneficiaries',
			'location',
			'latitude',
			'longitude',
			'start_date',
			'expected_completion',
			'actual_completion',
			'progress_percentage',
			'videos',
			'documents',
		);

		foreach ( $fields as $field ) {
			register_rest_field( 'pmo_project', $field, array(
				'get_callback'    => function( $post ) use ( $field ) {
					return get_post_meta( $post['id'], '_pmo_' . $field, true );
				},
				'update_callback' => function( $value, $post ) use ( $field ) {
					if ( current_user_can( 'edit_post', $post->ID ) ) {
						update_post_meta( $post->ID, '_pmo_' . $field, sanitize_text_field( $value ) );
					}
				},
				'schema'          => array(
					'type'        => 'string',
					'description' => ucfirst( str_replace( '_', ' ', $field ) ),
				),
			) );
		}
	}

	/**
	 * Set custom admin columns
	 */
	public static function set_custom_columns( $columns ) {
		$columns = array_slice( $columns, 0, 2, true ) +
			array(
				'project_code'   => esc_html__( 'Project Code', 'pmo-core' ),
				'status'         => esc_html__( 'Status', 'pmo-core' ),
				'progress'       => esc_html__( 'Progress', 'pmo-core' ),
				'budget'         => esc_html__( 'Budget', 'pmo-core' ),
			) +
			array_slice( $columns, 2, null, true );

		return $columns;
	}

	/**
	 * Render custom admin columns
	 */
	public static function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'project_code':
				$code = get_post_meta( $post_id, '_pmo_project_code', true );
				echo esc_html( $code ?: '-' );
				break;

			case 'status':
				$terms = get_the_terms( $post_id, 'pmo_project_status' );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						echo '<span style="background: #007cba; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">' . esc_html( $term->name ) . '</span>';
					}
				} else {
					echo '-';
				}
				break;

			case 'progress':
				$progress = get_post_meta( $post_id, '_pmo_progress_percentage', true );
				if ( $progress ) {
					echo '<div style="width: 100px; height: 20px; background: #f0f0f0; border-radius: 3px; overflow: hidden;">';
					echo '<div style="background: #27ae60; height: 100%; width: ' . esc_attr( $progress ) . '%; transition: width 0.3s;"></div>';
					echo '</div>';
					echo esc_html( $progress ) . '%';
				} else {
					echo '0%';
				}
				break;

			case 'budget':
				$budget = get_post_meta( $post_id, '_pmo_budget', true );
				echo $budget ? '₦' . esc_html( number_format( $budget, 0 ) ) : '-';
				break;
		}
	}
}

<?php
/**
 * PMO Tenders Module
 *
 * Handles tender/procurement management
 *
 * @package PMO_Core
 */

class PMO_Tenders_Module {

	/**
	 * Initialize the tenders module
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_pmo_tender', array( __CLASS__, 'save_tender_meta' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_fields' ) );
		add_filter( 'manage_pmo_tender_posts_columns', array( __CLASS__, 'set_custom_columns' ) );
		add_action( 'manage_pmo_tender_posts_custom_column', array( __CLASS__, 'render_custom_columns' ), 10, 2 );
	}

	/**
	 * Register meta boxes for tenders
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'pmo_tender_details',
			esc_html__( 'Tender Details', 'pmo-core' ),
			array( __CLASS__, 'render_tender_details_meta_box' ),
			'pmo_tender',
			'normal',
			'high'
		);
	}

	/**
	 * Render tender details meta box
	 */
	public static function render_tender_details_meta_box( $post ) {
		wp_nonce_field( 'pmo_tender_nonce', 'pmo_tender_nonce' );

		$reference_number = get_post_meta( $post->ID, '_pmo_reference_number', true );
		$opening_date = get_post_meta( $post->ID, '_pmo_opening_date', true );
		$closing_date = get_post_meta( $post->ID, '_pmo_closing_date', true );
		$tender_status = get_post_meta( $post->ID, '_pmo_tender_status', true );
		$tender_value = get_post_meta( $post->ID, '_pmo_tender_value', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
			<div>
				<label for="pmo_reference_number">
					<strong><?php esc_html_e( 'Reference Number:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_reference_number"
					name="pmo_reference_number"
					value="<?php echo esc_attr( $reference_number ); ?>"
					placeholder="e.g., TEND-2024-001"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_tender_status">
					<strong><?php esc_html_e( 'Tender Status:', 'pmo-core' ); ?></strong>
				</label>
				<select id="pmo_tender_status" name="pmo_tender_status" style="width: 100%; padding: 8px; margin-top: 5px;">
					<option value="Open" <?php selected( $tender_status, 'Open' ); ?>>Open</option>
					<option value="Closed" <?php selected( $tender_status, 'Closed' ); ?>>Closed</option>
					<option value="Awarded" <?php selected( $tender_status, 'Awarded' ); ?>>Awarded</option>
					<option value="Cancelled" <?php selected( $tender_status, 'Cancelled' ); ?>>Cancelled</option>
				</select>
			</div>

			<div>
				<label for="pmo_opening_date">
					<strong><?php esc_html_e( 'Opening Date:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="date"
					id="pmo_opening_date"
					name="pmo_opening_date"
					value="<?php echo esc_attr( $opening_date ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_closing_date">
					<strong><?php esc_html_e( 'Closing Date:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="date"
					id="pmo_closing_date"
					name="pmo_closing_date"
					value="<?php echo esc_attr( $closing_date ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div style="grid-column: 1 / -1;">
				<label for="pmo_tender_value">
					<strong><?php esc_html_e( 'Estimated Tender Value (₦):', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="number"
					id="pmo_tender_value"
					name="pmo_tender_value"
					value="<?php echo esc_attr( $tender_value ); ?>"
					placeholder="0.00"
					step="0.01"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>
		</div>
		<?php
	}

	/**
	 * Save tender meta
	 */
	public static function save_tender_meta( $post_id ) {
		// Check nonce
		if ( ! isset( $_POST['pmo_tender_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_tender_nonce'], 'pmo_tender_nonce' ) ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Define fields to save
		$fields = array(
			'pmo_reference_number',
			'pmo_opening_date',
			'pmo_closing_date',
			'pmo_tender_status',
			'pmo_tender_value',
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
			'reference_number',
			'opening_date',
			'closing_date',
			'tender_status',
			'tender_value',
		);

		foreach ( $fields as $field ) {
			register_rest_field( 'pmo_tender', $field, array(
				'get_callback'    => function( $post ) use ( $field ) {
					return get_post_meta( $post['id'], '_pmo_' . $field, true );
				},
				'update_callback' => function( $value, $post ) use ( $field ) {
					if ( current_user_can( 'edit_post', $post->ID ) ) {
						update_post_meta( $post->ID, '_pmo_' . $field, sanitize_text_field( $value ) );
					}
				},
				'schema'          => array(
					'type' => 'string',
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
				'reference'     => esc_html__( 'Reference #', 'pmo-core' ),
				'closing_date'  => esc_html__( 'Closing Date', 'pmo-core' ),
				'status'        => esc_html__( 'Status', 'pmo-core' ),
			) +
			array_slice( $columns, 2, null, true );

		return $columns;
	}

	/**
	 * Render custom admin columns
	 */
	public static function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'reference':
				$ref = get_post_meta( $post_id, '_pmo_reference_number', true );
				echo esc_html( $ref ?: '-' );
				break;

			case 'closing_date':
				$date = get_post_meta( $post_id, '_pmo_closing_date', true );
				echo $date ? esc_html( wp_date( 'M d, Y', strtotime( $date ) ) ) : '-';
				break;

			case 'status':
				$status = get_post_meta( $post_id, '_pmo_tender_status', true );
				$colors = array(
					'Open'      => '#27ae60',
					'Closed'    => '#e74c3c',
					'Awarded'   => '#3498db',
					'Cancelled' => '#95a5a6',
				);
				$color = $colors[ $status ] ?? '#34495e';
				echo '<span style="background: ' . esc_attr( $color ) . '; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">' . esc_html( $status ?: '-' ) . '</span>';
				break;
		}
	}
}

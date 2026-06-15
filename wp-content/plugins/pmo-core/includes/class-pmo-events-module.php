<?php
/**
 * PMO Events Module
 *
 * Handles custom fields and functionality for events
 *
 * @package PMO_Core
 */

class PMO_Events_Module {

	/**
	 * Initialize the events module
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_pmo_event', array( __CLASS__, 'save_event_meta' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_fields' ) );
		add_filter( 'manage_pmo_event_posts_columns', array( __CLASS__, 'set_custom_columns' ) );
		add_action( 'manage_pmo_event_posts_custom_column', array( __CLASS__, 'render_custom_columns' ), 10, 2 );
	}

	/**
	 * Register meta boxes for events
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'pmo_event_details',
			esc_html__( 'Event Details', 'pmo-core' ),
			array( __CLASS__, 'render_event_details_meta_box' ),
			'pmo_event',
			'normal',
			'high'
		);
	}

	/**
	 * Render event details meta box
	 */
	public static function render_event_details_meta_box( $post ) {
		wp_nonce_field( 'pmo_event_nonce', 'pmo_event_nonce' );

		$event_date = get_post_meta( $post->ID, '_pmo_event_date', true );
		$event_time = get_post_meta( $post->ID, '_pmo_event_time', true );
		$venue = get_post_meta( $post->ID, '_pmo_venue', true );
		$registration_link = get_post_meta( $post->ID, '_pmo_registration_link', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
			<div>
				<label for="pmo_event_date">
					<strong><?php esc_html_e( 'Event Date:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="date"
					id="pmo_event_date"
					name="pmo_event_date"
					value="<?php echo esc_attr( $event_date ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_event_time">
					<strong><?php esc_html_e( 'Event Time:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="time"
					id="pmo_event_time"
					name="pmo_event_time"
					value="<?php echo esc_attr( $event_time ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div style="grid-column: 1 / -1;">
				<label for="pmo_venue">
					<strong><?php esc_html_e( 'Venue / Location:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_venue"
					name="pmo_venue"
					value="<?php echo esc_attr( $venue ); ?>"
					placeholder="e.g., Alausa, Ikeja or Online"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div style="grid-column: 1 / -1;">
				<label for="pmo_registration_link">
					<strong><?php esc_html_e( 'Registration Link (Optional):', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="url"
					id="pmo_registration_link"
					name="pmo_registration_link"
					value="<?php echo esc_attr( $registration_link ); ?>"
					placeholder="https://example.com/register"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>
		</div>
		<?php
	}

	/**
	 * Save event meta
	 */
	public static function save_event_meta( $post_id ) {
		// Check nonce
		if ( ! isset( $_POST['pmo_event_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_event_nonce'], 'pmo_event_nonce' ) ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Define fields to save
		$fields = array(
			'pmo_event_date',
			'pmo_event_time',
			'pmo_venue',
			'pmo_registration_link',
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
			'event_date',
			'event_time',
			'venue',
			'registration_link',
		);

		foreach ( $fields as $field ) {
			register_rest_field( 'pmo_event', $field, array(
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
				'date'   => esc_html__( 'Date', 'pmo-core' ),
				'time'   => esc_html__( 'Time', 'pmo-core' ),
				'venue'  => esc_html__( 'Venue', 'pmo-core' ),
			) +
			array_slice( $columns, 2, null, true );

		return $columns;
	}

	/**
	 * Render custom admin columns
	 */
	public static function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'date':
				$date = get_post_meta( $post_id, '_pmo_event_date', true );
				echo $date ? esc_html( wp_date( 'M d, Y', strtotime( $date ) ) ) : '-';
				break;

			case 'time':
				$time = get_post_meta( $post_id, '_pmo_event_time', true );
				echo $time ? esc_html( $time ) : '-';
				break;

			case 'venue':
				$venue = get_post_meta( $post_id, '_pmo_venue', true );
				echo esc_html( $venue ?: '-' );
				break;
		}
	}
}

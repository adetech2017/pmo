<?php
/**
 * PMO Leadership Module
 *
 * Handles custom fields and functionality for leadership/team members
 *
 * @package PMO_Core
 */

class PMO_Leadership_Module {

	/**
	 * Initialize the leadership module
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_pmo_leadership', array( __CLASS__, 'save_leadership_meta' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_fields' ) );
		add_filter( 'manage_pmo_leadership_posts_columns', array( __CLASS__, 'set_custom_columns' ) );
		add_action( 'manage_pmo_leadership_posts_custom_column', array( __CLASS__, 'render_custom_columns' ), 10, 2 );
	}

	/**
	 * Register meta boxes for leadership
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'pmo_leadership_details',
			esc_html__( 'Leadership Profile', 'pmo-core' ),
			array( __CLASS__, 'render_leadership_details_meta_box' ),
			'pmo_leadership',
			'normal',
			'high'
		);
	}

	/**
	 * Render leadership details meta box
	 */
	public static function render_leadership_details_meta_box( $post ) {
		wp_nonce_field( 'pmo_leadership_nonce', 'pmo_leadership_nonce' );

		$job_title = get_post_meta( $post->ID, '_pmo_job_title', true );
		$department = get_post_meta( $post->ID, '_pmo_department', true );
		$email = get_post_meta( $post->ID, '_pmo_email', true );
		$phone = get_post_meta( $post->ID, '_pmo_phone', true );
		$office_address = get_post_meta( $post->ID, '_pmo_office_address', true );
		$social_linkedin = get_post_meta( $post->ID, '_pmo_social_linkedin', true );
		$social_twitter = get_post_meta( $post->ID, '_pmo_social_twitter', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
			<div>
				<label for="pmo_job_title">
					<strong><?php esc_html_e( 'Job Title:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_job_title"
					name="pmo_job_title"
					value="<?php echo esc_attr( $job_title ); ?>"
					placeholder="e.g., Director, Project Manager"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_department">
					<strong><?php esc_html_e( 'Department:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_department"
					name="pmo_department"
					value="<?php echo esc_attr( $department ); ?>"
					placeholder="e.g., Operations, Planning"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_email">
					<strong><?php esc_html_e( 'Email Address:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="email"
					id="pmo_email"
					name="pmo_email"
					value="<?php echo esc_attr( $email ); ?>"
					placeholder="name@pmo.gov.ng"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_phone">
					<strong><?php esc_html_e( 'Phone Number:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="tel"
					id="pmo_phone"
					name="pmo_phone"
					value="<?php echo esc_attr( $phone ); ?>"
					placeholder="+234 (0) xxx xxx xxxx"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div style="grid-column: 1 / -1;">
				<label for="pmo_office_address">
					<strong><?php esc_html_e( 'Office Address:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_office_address"
					name="pmo_office_address"
					value="<?php echo esc_attr( $office_address ); ?>"
					placeholder="Alausa, Ikeja, Lagos"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_social_linkedin">
					<strong><?php esc_html_e( 'LinkedIn Profile:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="url"
					id="pmo_social_linkedin"
					name="pmo_social_linkedin"
					value="<?php echo esc_attr( $social_linkedin ); ?>"
					placeholder="https://linkedin.com/in/username"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_social_twitter">
					<strong><?php esc_html_e( 'Twitter Handle:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_social_twitter"
					name="pmo_social_twitter"
					value="<?php echo esc_attr( $social_twitter ); ?>"
					placeholder="@username"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>
		</div>
		<?php
	}

	/**
	 * Save leadership meta
	 */
	public static function save_leadership_meta( $post_id ) {
		// Check nonce
		if ( ! isset( $_POST['pmo_leadership_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_leadership_nonce'], 'pmo_leadership_nonce' ) ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Define fields to save
		$fields = array(
			'pmo_job_title',
			'pmo_department',
			'pmo_email',
			'pmo_phone',
			'pmo_office_address',
			'pmo_social_linkedin',
			'pmo_social_twitter',
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
			'job_title',
			'department',
			'email',
			'phone',
			'office_address',
			'social_linkedin',
			'social_twitter',
		);

		foreach ( $fields as $field ) {
			register_rest_field( 'pmo_leadership', $field, array(
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
				'job_title'   => esc_html__( 'Job Title', 'pmo-core' ),
				'department'  => esc_html__( 'Department', 'pmo-core' ),
				'level'       => esc_html__( 'Level', 'pmo-core' ),
			) +
			array_slice( $columns, 2, null, true );

		return $columns;
	}

	/**
	 * Render custom admin columns
	 */
	public static function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'job_title':
				$title = get_post_meta( $post_id, '_pmo_job_title', true );
				echo esc_html( $title ?: '-' );
				break;

			case 'department':
				$dept = get_post_meta( $post_id, '_pmo_department', true );
				echo esc_html( $dept ?: '-' );
				break;

			case 'level':
				$terms = get_the_terms( $post_id, 'pmo_leadership_level' );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						echo '<span style="background: #f39c12; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">' . esc_html( $term->name ) . '</span>';
					}
				} else {
					echo '-';
				}
				break;
		}
	}
}

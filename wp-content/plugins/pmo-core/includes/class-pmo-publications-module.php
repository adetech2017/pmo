<?php
/**
 * PMO Publications Module
 *
 * Handles document uploads and publication management
 *
 * @package PMO_Core
 */

class PMO_Publications_Module {

	/**
	 * Initialize the publications module
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_pmo_publication', array( __CLASS__, 'save_publication_meta' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_fields' ) );
		add_filter( 'manage_pmo_publication_posts_columns', array( __CLASS__, 'set_custom_columns' ) );
		add_action( 'manage_pmo_publication_posts_custom_column', array( __CLASS__, 'render_custom_columns' ), 10, 2 );
	}

	/**
	 * Register meta boxes for publications
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'pmo_publication_document',
			esc_html__( 'Document Upload', 'pmo-core' ),
			array( __CLASS__, 'render_publication_document_meta_box' ),
			'pmo_publication',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_publication_details',
			esc_html__( 'Publication Details', 'pmo-core' ),
			array( __CLASS__, 'render_publication_details_meta_box' ),
			'pmo_publication',
			'normal',
			'high'
		);
	}

	/**
	 * Render publication document meta box
	 */
	public static function render_publication_document_meta_box( $post ) {
		wp_nonce_field( 'pmo_publication_nonce', 'pmo_publication_nonce' );

		$document_id = get_post_meta( $post->ID, '_pmo_document_id', true );
		?>
		<div>
			<p>
				<button type="button" class="button" id="pmo_document_button">
					<?php esc_html_e( 'Upload/Select Document', 'pmo-core' ); ?>
				</button>
			</p>
			<input
				type="hidden"
				id="pmo_document_id"
				name="pmo_document_id"
				value="<?php echo esc_attr( $document_id ); ?>"
			/>
			<div id="pmo_document_preview" style="margin-top: 15px;">
				<?php
				if ( $document_id ) {
					$title = get_the_title( $document_id );
					$url = wp_get_attachment_url( $document_id );
					echo '<p><strong>' . esc_html__( 'Current Document:', 'pmo-core' ) . '</strong></p>';
					echo '<p><a href="' . esc_url( $url ) . '" target="_blank">' . esc_html( $title ) . '</a></p>';
					echo '<p><small>' . esc_html( wp_get_attachment_url( $document_id ) ) . '</small></p>';
				}
				?>
			</div>
		</div>
		<script>
		jQuery(document).ready(function($) {
			let mediaFrame;

			$('#pmo_document_button').on('click', function(e) {
				e.preventDefault();

				if (mediaFrame) {
					mediaFrame.open();
					return;
				}

				mediaFrame = wp.media({
					title: '<?php esc_html_e( 'Select Document', 'pmo-core' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use Document', 'pmo-core' ); ?>'
					},
					library: {
						type: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
					},
					multiple: false
				});

				mediaFrame.on('select', function() {
					const attachment = mediaFrame.state().get('selection').first().toJSON();
					$('#pmo_document_id').val(attachment.id);
					location.reload();
				});

				mediaFrame.open();
			});
		});
		</script>
		<?php
	}

	/**
	 * Render publication details meta box
	 */
	public static function render_publication_details_meta_box( $post ) {
		$publish_date = get_post_meta( $post->ID, '_pmo_publish_date', true );
		$version = get_post_meta( $post->ID, '_pmo_version', true );
		?>
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
			<div>
				<label for="pmo_publish_date">
					<strong><?php esc_html_e( 'Publication Date:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="date"
					id="pmo_publish_date"
					name="pmo_publish_date"
					value="<?php echo esc_attr( $publish_date ); ?>"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>

			<div>
				<label for="pmo_version">
					<strong><?php esc_html_e( 'Document Version:', 'pmo-core' ); ?></strong>
				</label>
				<input
					type="text"
					id="pmo_version"
					name="pmo_version"
					value="<?php echo esc_attr( $version ); ?>"
					placeholder="e.g., 1.0"
					style="width: 100%; padding: 8px; margin-top: 5px;"
				/>
			</div>
		</div>
		<?php
	}

	/**
	 * Save publication meta
	 */
	public static function save_publication_meta( $post_id ) {
		// Check nonce
		if ( ! isset( $_POST['pmo_publication_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_publication_nonce'], 'pmo_publication_nonce' ) ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Define fields to save
		$fields = array(
			'pmo_document_id',
			'pmo_publish_date',
			'pmo_version',
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
			'document_id',
			'publish_date',
			'version',
		);

		foreach ( $fields as $field ) {
			register_rest_field( 'pmo_publication', $field, array(
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
				'category' => esc_html__( 'Category', 'pmo-core' ),
				'document' => esc_html__( 'Document', 'pmo-core' ),
			) +
			array_slice( $columns, 2, null, true );

		return $columns;
	}

	/**
	 * Render custom admin columns
	 */
	public static function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'category':
				$terms = get_the_terms( $post_id, 'pmo_publication_category' );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						echo '<a href="' . esc_url( get_edit_term_link( $term->term_id, 'pmo_publication_category' ) ) . '">' . esc_html( $term->name ) . '</a><br>';
					}
				} else {
					echo '-';
				}
				break;

			case 'document':
				$doc_id = get_post_meta( $post_id, '_pmo_document_id', true );
				if ( $doc_id ) {
					$doc_url = wp_get_attachment_url( $doc_id );
					$doc_title = get_the_title( $doc_id );
					echo '<a href="' . esc_url( $doc_url ) . '" target="_blank">📄 ' . esc_html( $doc_title ) . '</a>';
				} else {
					echo '-';
				}
				break;
		}
	}
}

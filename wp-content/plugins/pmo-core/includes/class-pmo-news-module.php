<?php
/**
 * PMO News Module
 *
 * Handles custom fields and functionality for news
 *
 * @package PMO_Core
 */

class PMO_News_Module {

	/**
	 * Initialize the news module
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_pmo_news', array( __CLASS__, 'save_news_meta' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_rest_fields' ) );
		add_filter( 'manage_pmo_news_posts_columns', array( __CLASS__, 'set_custom_columns' ) );
		add_action( 'manage_pmo_news_posts_custom_column', array( __CLASS__, 'render_custom_columns' ), 10, 2 );
	}

	/**
	 * Register meta boxes for news
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'pmo_news_details',
			esc_html__( 'News Details', 'pmo-core' ),
			array( __CLASS__, 'render_news_details_meta_box' ),
			'pmo_news',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_news_gallery',
			esc_html__( 'News Gallery', 'pmo-core' ),
			array( __CLASS__, 'render_news_gallery_meta_box' ),
			'pmo_news',
			'normal',
			'high'
		);
	}

	/**
	 * Render news details meta box
	 */
	public static function render_news_details_meta_box( $post ) {
		wp_nonce_field( 'pmo_news_nonce', 'pmo_news_nonce' );

		$featured = get_post_meta( $post->ID, '_pmo_featured', true );
		?>
		<div>
			<label for="pmo_featured">
				<input
					type="checkbox"
					id="pmo_featured"
					name="pmo_featured"
					value="1"
					<?php checked( $featured, '1' ); ?>
				/>
				<strong><?php esc_html_e( 'Feature this news on homepage', 'pmo-core' ); ?></strong>
			</label>
			<p style="color: #666; font-size: 12px;">
				<?php esc_html_e( 'Featured news will appear in the latest news section on the homepage.', 'pmo-core' ); ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Render news gallery meta box
	 */
	public static function render_news_gallery_meta_box( $post ) {
		$gallery_ids = get_post_meta( $post->ID, '_pmo_gallery_ids', true );
		?>
		<div>
			<p>
				<button type="button" class="button" id="pmo_gallery_button">
					<?php esc_html_e( 'Add/Edit Gallery', 'pmo-core' ); ?>
				</button>
			</p>
			<input
				type="hidden"
				id="pmo_gallery_ids"
				name="pmo_gallery_ids"
				value="<?php echo esc_attr( $gallery_ids ); ?>"
			/>
			<div id="pmo_gallery_preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 10px;">
				<?php
				if ( $gallery_ids ) {
					$ids = explode( ',', $gallery_ids );
					foreach ( $ids as $id ) {
						$image = wp_get_attachment_image( $id, 'thumbnail', false, array( 'style' => 'width: 100%; height: auto;' ) );
						if ( $image ) {
							echo '<div data-id="' . esc_attr( $id ) . '">' . $image . '</div>';
						}
					}
				}
				?>
			</div>
		</div>
		<script>
		jQuery(document).ready(function($) {
			let mediaFrame;

			$('#pmo_gallery_button').on('click', function(e) {
				e.preventDefault();

				if (mediaFrame) {
					mediaFrame.open();
					return;
				}

				mediaFrame = wp.media({
					title: '<?php esc_html_e( 'Select News Gallery Images', 'pmo-core' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use Selected Images', 'pmo-core' ); ?>'
					},
					multiple: true
				});

				mediaFrame.on('select', function() {
					const attachments = mediaFrame.state().get('selection');
					const ids = [];

					attachments.forEach(function(attachment) {
						ids.push(attachment.id);
					});

					$('#pmo_gallery_ids').val(ids.join(','));

					// Refresh preview
					location.reload();
				});

				mediaFrame.open();
			});
		});
		</script>
		<?php
	}

	/**
	 * Save news meta
	 */
	public static function save_news_meta( $post_id ) {
		// Check nonce
		if ( ! isset( $_POST['pmo_news_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_news_nonce'], 'pmo_news_nonce' ) ) {
			return;
		}

		// Check permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save featured flag
		if ( isset( $_POST['pmo_featured'] ) ) {
			update_post_meta( $post_id, '_pmo_featured', '1' );
		} else {
			update_post_meta( $post_id, '_pmo_featured', '0' );
		}

		// Save gallery IDs
		if ( isset( $_POST['pmo_gallery_ids'] ) ) {
			update_post_meta( $post_id, '_pmo_gallery_ids', sanitize_text_field( $_POST['pmo_gallery_ids'] ) );
		}
	}

	/**
	 * Register REST API fields
	 */
	public static function register_rest_fields() {
		register_rest_field( 'pmo_news', 'featured', array(
			'get_callback'    => function( $post ) {
				return get_post_meta( $post['id'], '_pmo_featured', true );
			},
			'update_callback' => function( $value, $post ) {
				if ( current_user_can( 'edit_post', $post->ID ) ) {
					update_post_meta( $post->ID, '_pmo_featured', sanitize_text_field( $value ) );
				}
			},
			'schema'          => array(
				'type' => 'boolean',
			),
		) );

		register_rest_field( 'pmo_news', 'gallery_ids', array(
			'get_callback'    => function( $post ) {
				return get_post_meta( $post['id'], '_pmo_gallery_ids', true );
			},
			'update_callback' => function( $value, $post ) {
				if ( current_user_can( 'edit_post', $post->ID ) ) {
					update_post_meta( $post->ID, '_pmo_gallery_ids', sanitize_text_field( $value ) );
				}
			},
			'schema'          => array(
				'type' => 'string',
			),
		) );
	}

	/**
	 * Set custom admin columns
	 */
	public static function set_custom_columns( $columns ) {
		$columns = array_slice( $columns, 0, 2, true ) +
			array(
				'category' => esc_html__( 'Category', 'pmo-core' ),
				'featured' => esc_html__( 'Featured', 'pmo-core' ),
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
				$terms = get_the_terms( $post_id, 'pmo_news_category' );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						echo '<a href="' . esc_url( get_edit_term_link( $term->term_id, 'pmo_news_category' ) ) . '">' . esc_html( $term->name ) . '</a><br>';
					}
				} else {
					echo '-';
				}
				break;

			case 'featured':
				$featured = get_post_meta( $post_id, '_pmo_featured', true );
				echo $featured ? '⭐ <strong>Yes</strong>' : 'No';
				break;
		}
	}
}

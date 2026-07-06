<?php
/**
 * PMO Content Types
 *
 * Registers the content types that were previously defined in the theme
 * (galleries, programmes, carousel slides, directorate members) together
 * with their meta boxes and save handlers, so all content survives a
 * theme switch.
 *
 * @package PMO_Core
 */

class PMO_Content_Types {

	/**
	 * Register admin hooks. Post type registration happens separately via
	 * register_post_types(), called from PMO_Core::init() during `init`.
	 */
	public static function init_hooks() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_meta_boxes' ) );
		add_action( 'save_post_pmo_gallery', array( __CLASS__, 'save_gallery_meta' ) );
		add_action( 'save_post_pmo_programme', array( __CLASS__, 'save_programme_meta' ) );
		add_action( 'save_post_pmo_carousel', array( __CLASS__, 'save_carousel_meta' ) );
		add_action( 'save_post_pmo_directorate', array( __CLASS__, 'save_directorate_meta' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_gallery_scripts' ) );
		add_action( 'wp_ajax_pmo_get_gallery_preview', array( __CLASS__, 'ajax_gallery_preview' ) );
	}

	/**
	 * Register post types and taxonomies
	 */
	public static function register_post_types() {
		register_post_type( 'pmo_gallery', array(
			'labels' => array(
				'name'          => __( 'Galleries', 'pmo-core' ),
				'singular_name' => __( 'Gallery', 'pmo-core' ),
				'menu_name'     => __( 'Galleries', 'pmo-core' ),
				'all_items'     => __( 'All Galleries', 'pmo-core' ),
				'add_new_item'  => __( 'Add New Gallery', 'pmo-core' ),
				'edit_item'     => __( 'Edit Gallery', 'pmo-core' ),
			),
			'public'          => true,
			'show_in_menu'    => true,
			'show_in_rest'    => true,
			'has_archive'     => false,
			'rewrite'         => array( 'slug' => 'gallery' ),
			'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'capability_type' => 'post',
			'menu_icon'       => 'dashicons-format-gallery',
		) );

		register_taxonomy( 'gallery_category', 'pmo_gallery', array(
			'label'        => __( 'Gallery Category', 'pmo-core' ),
			'public'       => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'gallery-category' ),
			'hierarchical' => true,
		) );

		register_post_type( 'pmo_programme', array(
			'labels' => array(
				'name'          => __( 'Programmes', 'pmo-core' ),
				'singular_name' => __( 'Programme', 'pmo-core' ),
				'menu_name'     => __( 'Programmes', 'pmo-core' ),
				'all_items'     => __( 'All Programmes', 'pmo-core' ),
				'add_new_item'  => __( 'Add New Programme', 'pmo-core' ),
				'edit_item'     => __( 'Edit Programme', 'pmo-core' ),
			),
			'public'          => true,
			'show_in_menu'    => true,
			'show_in_rest'    => true,
			// The "Our Mandate" page owns /programmes/; singles still live at /programmes/{slug}/
			'has_archive'     => false,
			'rewrite'         => array( 'slug' => 'programmes' ),
			'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'capability_type' => 'post',
			'menu_icon'       => 'dashicons-chart-bar',
		) );

		register_taxonomy( 'programme_category', 'pmo_programme', array(
			'label'        => __( 'Programme Categories', 'pmo-core' ),
			'public'       => true,
			'show_in_rest' => true,
		) );

		register_post_type( 'pmo_carousel', array(
			'label'             => __( 'Carousel Slides', 'pmo-core' ),
			'description'       => __( 'Hero carousel slides with text overlay', 'pmo-core' ),
			'public'            => true,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_nav_menus' => false,
			'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'       => false,
			'rewrite'           => array( 'slug' => 'carousel' ),
			'menu_icon'         => 'dashicons-images-alt2',
			'menu_position'     => 5,
		) );

		register_post_type( 'pmo_directorate', array(
			'label'             => __( 'Directorate', 'pmo-core' ),
			'description'       => __( 'Directorate members and executives', 'pmo-core' ),
			'public'            => true,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_nav_menus' => false,
			'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'       => false,
			'rewrite'           => array( 'slug' => 'directorate' ),
			'menu_icon'         => 'dashicons-groups',
			'menu_position'     => 6,
		) );
	}

	/**
	 * Register all meta boxes
	 */
	public static function register_meta_boxes() {
		add_meta_box(
			'gallery_images',
			__( 'Gallery Images', 'pmo-core' ),
			array( __CLASS__, 'render_gallery_meta_box' ),
			'pmo_gallery',
			'normal',
			'high'
		);

		add_meta_box(
			'programme_details',
			__( 'Programme Details', 'pmo-core' ),
			array( __CLASS__, 'render_programme_meta_box' ),
			'pmo_programme',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_carousel_meta',
			__( 'Slide Content', 'pmo-core' ),
			array( __CLASS__, 'render_carousel_meta_box' ),
			'pmo_carousel',
			'normal',
			'high'
		);

		add_meta_box(
			'pmo_directorate_meta',
			__( 'Directorate Information', 'pmo-core' ),
			array( __CLASS__, 'render_directorate_meta_box' ),
			'pmo_directorate',
			'normal',
			'high'
		);
	}

	/* ---------------------------------------------------------------------
	 * Gallery
	 * ------------------------------------------------------------------ */

	/**
	 * Render gallery meta box
	 */
	public static function render_gallery_meta_box( $post ) {
		wp_nonce_field( 'pmo_gallery_nonce', 'pmo_gallery_nonce' );

		$gallery_ids = get_post_meta( $post->ID, '_gallery_images', true );
		$ids_array = $gallery_ids ? array_filter( array_map( 'intval', explode( ',', $gallery_ids ) ) ) : array();
		?>

		<div style="padding: 10px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px;">
			<p><strong><?php esc_html_e( 'Instructions:', 'pmo-core' ); ?></strong> <?php esc_html_e( 'Click the button below to select images from your media library. Selected images will be added to this gallery.', 'pmo-core' ); ?></p>
		</div>

		<div style="margin-bottom: 20px;">
			<button type="button" class="button button-primary button-large" id="pmo_gallery_upload_button">
				<?php esc_html_e( 'Select Gallery Images', 'pmo-core' ); ?>
			</button>
		</div>

		<input type="hidden" id="pmo_gallery_image_ids" name="pmo_gallery_images" value="<?php echo esc_attr( $gallery_ids ); ?>">

		<div id="pmo_gallery_images_container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 15px; margin-top: 20px; padding-top: 20px; border-top: 2px solid #ddd;">
			<?php if ( ! empty( $ids_array ) ) { ?>
				<?php foreach ( $ids_array as $image_id ) { ?>
					<div class="pmo-gallery-image-item" data-image-id="<?php echo intval( $image_id ); ?>" style="position: relative; border: 2px solid #ddd; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
						<?php echo wp_get_attachment_image( $image_id, array( 130, 130 ), false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover; display: block;' ) ); ?>
						<button type="button" class="pmo-remove-gallery-image" data-image-id="<?php echo intval( $image_id ); ?>" style="position: absolute; top: 5px; right: 5px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 32px; height: 32px; padding: 0; cursor: pointer; font-size: 18px; line-height: 1; display: flex; align-items: center; justify-content: center;">
							<span>&times;</span>
						</button>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div style="grid-column: 1 / -1; padding: 40px 20px; text-align: center; color: #999;">
					<p style="font-size: 14px;"><?php esc_html_e( 'No images selected yet. Click "Select Gallery Images" to add photos.', 'pmo-core' ); ?></p>
				</div>
			<?php } ?>
		</div>

		<script>
		(function($) {
			'use strict';

			function refreshGalleryPreview(ids) {
				if (!ids || ids.length === 0) {
					$('#pmo_gallery_images_container').html('<div style="grid-column: 1 / -1; padding: 40px 20px; text-align: center; color: #999;"><p style="font-size: 14px;">No images selected yet. Click "Select Gallery Images" to add photos.</p></div>');
					return;
				}

				wp.ajax.post('pmo_get_gallery_preview', {
					ids: ids.join(',')
				}).done(function(response) {
					$('#pmo_gallery_images_container').html(response);
					attachRemoveHandlers();
				}).fail(function(error) {
					console.error('Error fetching preview:', error);
				});
			}

			function attachRemoveHandlers() {
				$(document).off('click', '.pmo-remove-gallery-image').on('click', '.pmo-remove-gallery-image', function(e) {
					e.preventDefault();
					$(this).closest('.pmo-gallery-image-item').fadeOut(200, function() {
						$(this).remove();
						const ids = [];
						$('.pmo-gallery-image-item').each(function() {
							ids.push($(this).data('image-id'));
						});
						$('#pmo_gallery_image_ids').val(ids.join(','));
					});
				});
			}

			$(document).ready(function() {
				let mediaFrame;

				$('#pmo_gallery_upload_button').on('click', function(e) {
					e.preventDefault();

					if ( mediaFrame ) {
						mediaFrame.open();
						return;
					}

					mediaFrame = wp.media({
						title: 'Select Gallery Images',
						button: { text: 'Add to Gallery' },
						multiple: true,
						library: { type: 'image' }
					});

					mediaFrame.on('select', function() {
						const selection = mediaFrame.state().get('selection');
						const currentIds = $('#pmo_gallery_image_ids').val() ? $('#pmo_gallery_image_ids').val().split(',').map(id => parseInt(id)) : [];
						const newIds = [];

						selection.each(function(attachment) {
							const id = parseInt(attachment.id);
							if (!currentIds.includes(id)) {
								newIds.push(id);
							}
						});

						const allIds = currentIds.concat(newIds);
						if (allIds.length > 0) {
							$('#pmo_gallery_image_ids').val(allIds.join(','));
							refreshGalleryPreview(allIds);
						}
					});

					mediaFrame.open();
				});

				attachRemoveHandlers();
			});
		})(jQuery);
		</script>
		<?php
	}

	/**
	 * Enqueue media library scripts on gallery edit screens
	 */
	public static function enqueue_gallery_scripts( $hook ) {
		if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
			return;
		}

		global $post;
		if ( ! $post || 'pmo_gallery' !== $post->post_type ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * Save gallery meta data
	 */
	public static function save_gallery_meta( $post_id ) {
		if ( ! isset( $_POST['pmo_gallery_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_gallery_nonce'], 'pmo_gallery_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['pmo_gallery_images'] ) && ! empty( $_POST['pmo_gallery_images'] ) ) {
			$ids = array_filter( array_map( 'intval', explode( ',', sanitize_text_field( $_POST['pmo_gallery_images'] ) ) ) );
			update_post_meta( $post_id, '_gallery_images', implode( ',', $ids ) );
		} else {
			delete_post_meta( $post_id, '_gallery_images' );
		}
	}

	/**
	 * AJAX: rebuild the admin gallery preview grid
	 */
	public static function ajax_gallery_preview() {
		if ( ! is_user_logged_in() || ! current_user_can( 'edit_pages' ) ) {
			wp_send_json_error( 'Insufficient permissions' );
		}

		if ( ! isset( $_POST['ids'] ) ) {
			wp_send_json_error( 'No image IDs provided' );
		}

		$ids = array_map( 'intval', explode( ',', sanitize_text_field( $_POST['ids'] ) ) );
		$ids = array_filter( $ids );

		if ( empty( $ids ) ) {
			wp_send_json_success( '<div style="grid-column: 1/-1; padding: 30px; text-align: center; color: #999; background: #fafafa; border-radius: 4px; font-size: 13px;">No images selected yet</div>' );
		}

		$html = '';
		foreach ( $ids as $id ) {
			$image = wp_get_attachment_image( $id, array( 100, 100 ), false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover; display: block;' ) );
			$html .= '<div class="pmo-img" data-img="' . intval( $id ) . '" style="position: relative; border-radius: 4px; overflow: hidden; border: 1px solid #ddd; background: #f5f5f5;">
				' . $image . '
				<button type="button" class="pmo-remove" style="position: absolute; top: 2px; right: 2px; background: #dc3545; color: white; border: none; width: 20px; height: 20px; border-radius: 50%; cursor: pointer; padding: 0; font-size: 12px; line-height: 1; display: flex; align-items: center; justify-content: center;">&times;</button>
			</div>';
		}

		wp_send_json_success( $html );
	}

	/* ---------------------------------------------------------------------
	 * Programme
	 * ------------------------------------------------------------------ */

	/**
	 * Render programme meta box
	 */
	public static function render_programme_meta_box( $post ) {
		wp_nonce_field( 'programme_details_nonce', 'programme_details_nonce' );

		$status = get_post_meta( $post->ID, '_programme_status', true );
		$budget = get_post_meta( $post->ID, '_programme_budget', true );
		$start_date = get_post_meta( $post->ID, '_programme_start_date', true );
		$end_date = get_post_meta( $post->ID, '_programme_end_date', true );
		$completion = get_post_meta( $post->ID, '_programme_completion', true );
		?>
		<div style="margin-bottom: 15px;">
			<label for="programme_status"><strong><?php esc_html_e( 'Status:', 'pmo-core' ); ?></strong></label>
			<select id="programme_status" name="programme_status" style="width: 100%; padding: 8px;">
				<option value="">-- Select Status --</option>
				<option value="Planned" <?php selected( $status, 'Planned' ); ?>>Planned</option>
				<option value="In Progress" <?php selected( $status, 'In Progress' ); ?>>In Progress</option>
				<option value="Active" <?php selected( $status, 'Active' ); ?>>Active</option>
				<option value="Completed" <?php selected( $status, 'Completed' ); ?>>Completed</option>
			</select>
		</div>

		<div style="margin-bottom: 15px;">
			<label for="programme_budget"><strong><?php esc_html_e( 'Budget:', 'pmo-core' ); ?></strong></label>
			<input type="text" id="programme_budget" name="programme_budget" value="<?php echo esc_attr( $budget ); ?>" placeholder="e.g., ₦2.5 Billion" style="width: 100%; padding: 8px;">
		</div>

		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
			<div>
				<label for="programme_start_date"><strong><?php esc_html_e( 'Start Date:', 'pmo-core' ); ?></strong></label>
				<input type="date" id="programme_start_date" name="programme_start_date" value="<?php echo esc_attr( $start_date ); ?>" style="width: 100%; padding: 8px;">
			</div>
			<div>
				<label for="programme_end_date"><strong><?php esc_html_e( 'End Date:', 'pmo-core' ); ?></strong></label>
				<input type="date" id="programme_end_date" name="programme_end_date" value="<?php echo esc_attr( $end_date ); ?>" style="width: 100%; padding: 8px;">
			</div>
		</div>

		<div style="margin-top: 15px;">
			<label for="programme_completion"><strong><?php esc_html_e( 'Completion (%):', 'pmo-core' ); ?></strong></label>
			<input type="number" id="programme_completion" name="programme_completion" value="<?php echo esc_attr( $completion ); ?>" min="0" max="100" style="width: 100%; padding: 8px;">
		</div>
		<?php
	}

	/**
	 * Save programme meta data
	 */
	public static function save_programme_meta( $post_id ) {
		if ( ! isset( $_POST['programme_details_nonce'] ) || ! wp_verify_nonce( $_POST['programme_details_nonce'], 'programme_details_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['programme_status'] ) ) {
			update_post_meta( $post_id, '_programme_status', sanitize_text_field( $_POST['programme_status'] ) );
		}

		if ( isset( $_POST['programme_budget'] ) ) {
			update_post_meta( $post_id, '_programme_budget', sanitize_text_field( $_POST['programme_budget'] ) );
		}

		if ( isset( $_POST['programme_start_date'] ) ) {
			update_post_meta( $post_id, '_programme_start_date', sanitize_text_field( $_POST['programme_start_date'] ) );
		}

		if ( isset( $_POST['programme_end_date'] ) ) {
			update_post_meta( $post_id, '_programme_end_date', sanitize_text_field( $_POST['programme_end_date'] ) );
		}

		if ( isset( $_POST['programme_completion'] ) ) {
			update_post_meta( $post_id, '_programme_completion', min( 100, max( 0, intval( $_POST['programme_completion'] ) ) ) );
		}
	}

	/* ---------------------------------------------------------------------
	 * Carousel
	 * ------------------------------------------------------------------ */

	/**
	 * Render carousel meta box
	 */
	public static function render_carousel_meta_box( $post ) {
		wp_nonce_field( 'pmo_carousel_nonce', 'pmo_carousel_nonce' );
		$subtitle = get_post_meta( $post->ID, '_carousel_subtitle', true );
		$button_text = get_post_meta( $post->ID, '_carousel_button_text', true );
		$button_link = get_post_meta( $post->ID, '_carousel_button_link', true );
		?>
		<div style="padding: 20px 0;">
			<div style="margin-bottom: 20px;">
				<label for="carousel_subtitle"><strong><?php esc_html_e( 'Subtitle (Secondary Text)', 'pmo-core' ); ?></strong></label>
				<input
					type="text"
					id="carousel_subtitle"
					name="carousel_subtitle"
					value="<?php echo esc_attr( $subtitle ); ?>"
					placeholder="e.g., Driving Accountability and Excellence"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="carousel_button_text"><strong><?php esc_html_e( 'Button Text', 'pmo-core' ); ?></strong></label>
				<input
					type="text"
					id="carousel_button_text"
					name="carousel_button_text"
					value="<?php echo esc_attr( $button_text ); ?>"
					placeholder="e.g., Learn More"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
			</div>

			<div>
				<label for="carousel_button_link"><strong><?php esc_html_e( 'Button Link (URL)', 'pmo-core' ); ?></strong></label>
				<input
					type="url"
					id="carousel_button_link"
					name="carousel_button_link"
					value="<?php echo esc_url( $button_link ); ?>"
					placeholder="https://example.com"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
			</div>
		</div>
		<?php
	}

	/**
	 * Save carousel meta data
	 */
	public static function save_carousel_meta( $post_id ) {
		if ( ! isset( $_POST['pmo_carousel_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_carousel_nonce'], 'pmo_carousel_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['carousel_subtitle'] ) ) {
			update_post_meta( $post_id, '_carousel_subtitle', sanitize_text_field( $_POST['carousel_subtitle'] ) );
		}

		if ( isset( $_POST['carousel_button_text'] ) ) {
			update_post_meta( $post_id, '_carousel_button_text', sanitize_text_field( $_POST['carousel_button_text'] ) );
		}

		if ( isset( $_POST['carousel_button_link'] ) ) {
			update_post_meta( $post_id, '_carousel_button_link', esc_url_raw( $_POST['carousel_button_link'] ) );
		}
	}

	/* ---------------------------------------------------------------------
	 * Directorate
	 * ------------------------------------------------------------------ */

	/**
	 * Render directorate meta box
	 */
	public static function render_directorate_meta_box( $post ) {
		wp_nonce_field( 'pmo_directorate_nonce', 'pmo_directorate_nonce' );

		$position_level = get_post_meta( $post->ID, '_position_level', true );
		$staff_role = get_post_meta( $post->ID, '_staff_role', true );
		$department = get_post_meta( $post->ID, '_department', true );
		$department_color = get_post_meta( $post->ID, '_department_color', true );
		$email = get_post_meta( $post->ID, '_email', true );
		$phone = get_post_meta( $post->ID, '_phone', true );
		$display_order = get_post_meta( $post->ID, '_display_order', true );

		if ( ! $department_color ) {
			$department_color = '#3b82f6';
		}
		?>
		<div style="padding: 20px 0;">
			<div style="margin-bottom: 20px;">
				<label for="position_level"><strong><?php esc_html_e( 'Position Level', 'pmo-core' ); ?></strong></label>
				<select id="position_level" name="position_level" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
					<option value="executive" <?php selected( $position_level, 'executive' ); ?>>Executive Leadership</option>
					<option value="director" <?php selected( $position_level, 'director' ); ?>>Department Staff</option>
				</select>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="staff_role"><strong><?php esc_html_e( 'Job Title/Role', 'pmo-core' ); ?></strong></label>
				<input
					type="text"
					id="staff_role"
					name="staff_role"
					value="<?php echo esc_attr( $staff_role ); ?>"
					placeholder="e.g., Special Adviser, Parastatals Monitoring"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="department"><strong><?php esc_html_e( 'Department', 'pmo-core' ); ?></strong></label>
				<input
					type="text"
					id="department"
					name="department"
					value="<?php echo esc_attr( $department ); ?>"
					placeholder="e.g., Admin & HR, Inspectorate"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="department_color"><strong><?php esc_html_e( 'Department Color', 'pmo-core' ); ?></strong></label>
				<input
					type="color"
					id="department_color"
					name="department_color"
					value="<?php echo esc_attr( $department_color ); ?>"
					style="width: 100%; height: 50px; padding: 5px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;"
				/>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="email"><strong><?php esc_html_e( 'Email Address', 'pmo-core' ); ?></strong></label>
				<input
					type="email"
					id="email"
					name="email"
					value="<?php echo esc_attr( $email ); ?>"
					placeholder="staff@lagosstate.gov.ng"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
			</div>

			<div style="margin-bottom: 20px;">
				<label for="phone"><strong><?php esc_html_e( 'Phone Number', 'pmo-core' ); ?></strong></label>
				<input
					type="tel"
					id="phone"
					name="phone"
					value="<?php echo esc_attr( $phone ); ?>"
					placeholder="+234 (0) 1 XXX XXXX"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
			</div>

			<div>
				<label for="display_order"><strong><?php esc_html_e( 'Display Order', 'pmo-core' ); ?></strong></label>
				<input
					type="number"
					id="display_order"
					name="display_order"
					value="<?php echo esc_attr( $display_order ); ?>"
					placeholder="1"
					min="1"
					style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
				/>
				<p style="font-size: 12px; color: #666; margin-top: 5px;"><?php esc_html_e( 'Lower numbers appear first', 'pmo-core' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Save directorate meta data
	 */
	public static function save_directorate_meta( $post_id ) {
		if ( ! isset( $_POST['pmo_directorate_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_directorate_nonce'], 'pmo_directorate_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['staff_role'] ) ) {
			update_post_meta( $post_id, '_staff_role', sanitize_text_field( $_POST['staff_role'] ) );
		}

		if ( isset( $_POST['department'] ) ) {
			update_post_meta( $post_id, '_department', sanitize_text_field( $_POST['department'] ) );
		}

		if ( isset( $_POST['department_color'] ) ) {
			update_post_meta( $post_id, '_department_color', sanitize_hex_color( $_POST['department_color'] ) );
		}

		if ( isset( $_POST['email'] ) ) {
			update_post_meta( $post_id, '_email', sanitize_email( $_POST['email'] ) );
		}

		if ( isset( $_POST['phone'] ) ) {
			update_post_meta( $post_id, '_phone', sanitize_text_field( $_POST['phone'] ) );
		}

		if ( isset( $_POST['position_level'] ) ) {
			update_post_meta( $post_id, '_position_level', sanitize_text_field( $_POST['position_level'] ) );
		}

		if ( isset( $_POST['display_order'] ) ) {
			update_post_meta( $post_id, '_display_order', absint( $_POST['display_order'] ) );
		}
	}
}

<?php
/**
 * PMO Portal Theme Functions
 *
 * @package PMO_Portal_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PMO_THEME_VERSION', '1.0.0' );
define( 'PMO_THEME_PATH', get_template_directory() );
define( 'PMO_THEME_URL', get_template_directory_uri() );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function pmo_theme_setup() {
	// Add theme support
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Register menus
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'pmo-portal' ),
		'footer'    => esc_html__( 'Footer Menu', 'pmo-portal' ),
	) );

	// Set content width
	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}

	// Load text domain
	load_theme_textdomain( 'pmo-portal', PMO_THEME_PATH . '/languages' );
}
add_action( 'after_setup_theme', 'pmo_theme_setup' );

/**
 * Enqueue styles and scripts
 */
function pmo_theme_enqueue_assets() {
	// Dequeue WordPress default styles to avoid conflicts
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );

	// Enqueue Font Awesome icons
	wp_enqueue_style( 'pmo-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

	// Enqueue Google Fonts - Inter, Manrope
	wp_enqueue_style( 'pmo-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap', array(), '1.0.0' );

	// Enqueue premium design system
	wp_enqueue_style( 'pmo-design-system', PMO_THEME_URL . '/../../../styles/pmo-design-system.css', array(), '4.0.0' );

	// Enqueue theme stylesheet
	wp_enqueue_style( 'pmo-theme-style', PMO_THEME_URL . '/style.css', array( 'pmo-design-system' ), '4.0.0' );

	// Enqueue responsive styles
	wp_enqueue_style( 'pmo-responsive', PMO_THEME_URL . '/responsive.css', array( 'pmo-theme-style' ), '1.0.0' );

	// Enqueue homepage styles
	wp_enqueue_style( 'pmo-homepage', PMO_THEME_URL . '/assets/css/homepage.css', array( 'pmo-theme-style' ), '1.0.0' );

	// Enqueue carousel script
	wp_enqueue_script( 'pmo-carousel', PMO_THEME_URL . '/assets/js/carousel.js', array(), '1.0.0', true );

	// Enqueue mobile menu script
	wp_enqueue_script( 'pmo-mobile-menu', PMO_THEME_URL . '/assets/js/mobile-menu.js', array(), '1.0.0', true );

	// Enqueue theme script if it exists
	if ( file_exists( PMO_THEME_PATH . '/assets/js/theme.js' ) ) {
		wp_enqueue_script( 'pmo-theme-script', PMO_THEME_URL . '/assets/js/theme.js', array(), '4.0.0', true );

		// Pass variables to JavaScript
		wp_localize_script( 'pmo-theme-script', 'pmoTheme', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'pmo_theme_nonce' ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'pmo_theme_enqueue_assets', 999 );

/**
 * Register widget areas
 */
function pmo_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'pmo-portal' ),
		'id'            => 'primary-sidebar',
		'description'   => esc_html__( 'Main sidebar for pages and posts', 'pmo-portal' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'pmo-portal' ),
		'id'            => 'footer-widgets',
		'description'   => esc_html__( 'Widgets in footer', 'pmo-portal' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'pmo_theme_widgets_init' );

/**
 * Add active class to menu items based on current page
 */
function pmo_nav_menu_css_class( $classes, $item ) {
	// If WordPress already marked it as current, add active class
	if ( in_array( 'current-menu-item', $classes ) || in_array( 'current_page_item', $classes ) ) {
		if ( ! in_array( 'active', $classes ) ) {
			$classes[] = 'active';
		}
		return $classes;
	}

	// Get current request
	$current = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';

	// Extract path from item URL
	$item_path = str_replace( home_url(), '', untrailingslashit( $item->url ) );
	$current_path = untrailingslashit( $current );

	// Direct URL match
	if ( $current_path === $item_path || rtrim( $current_path, '/' ) === rtrim( $item_path, '/' ) ) {
		if ( ! in_array( 'active', $classes ) ) {
			$classes[] = 'active';
			$classes[] = 'current-menu-item';
		}
	}

	// For post type archives - check if on archive and menu item links to that archive
	if ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		if ( is_array( $post_type ) ) {
			$post_type = reset( $post_type );
		}

		if ( 'pmo_programme' === $post_type && false !== strpos( $item->url, '/programmes' ) ) {
			$classes[] = 'active';
			if ( ! in_array( 'current-menu-item', $classes ) ) {
				$classes[] = 'current-menu-item';
			}
		} elseif ( 'pmo_news' === $post_type && false !== strpos( $item->url, '/news' ) ) {
			$classes[] = 'active';
			if ( ! in_array( 'current-menu-item', $classes ) ) {
				$classes[] = 'current-menu-item';
			}
		} elseif ( 'pmo_event' === $post_type && false !== strpos( $item->url, '/events' ) ) {
			$classes[] = 'active';
			if ( ! in_array( 'current-menu-item', $classes ) ) {
				$classes[] = 'current-menu-item';
			}
		}
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'pmo_nav_menu_css_class', 10, 2 );

/**
 * Custom Menu Walker for Active Link Detection
 */
class PMO_Menu_Walker extends Walker_Nav_Menu {}


/**
 * Custom excerpt length
 */
function pmo_theme_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'pmo_theme_excerpt_length' );

/**
 * Custom excerpt more text
 */
function pmo_theme_excerpt_more( $more ) {
	return ' ... <a href="' . get_permalink() . '">Read More</a>';
}
add_filter( 'excerpt_more', 'pmo_theme_excerpt_more' );

/**
 * Add custom classes to the body tag
 */
function pmo_theme_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	if ( is_home() || is_front_page() ) {
		$classes[] = 'home-page';
	}

	return $classes;
}
add_filter( 'body_class', 'pmo_theme_body_classes' );

/**
 * Register Gallery Post Type
 */
function pmo_register_gallery_post_type() {
	register_post_type( 'pmo_gallery', array(
		'labels' => array(
			'name'         => 'Galleries',
			'singular_name' => 'Gallery',
			'menu_name'    => 'Galleries',
			'all_items'    => 'All Galleries',
			'add_new_item' => 'Add New Gallery',
			'edit_item'    => 'Edit Gallery',
		),
		'public'        => true,
		'show_in_menu'  => true,
		'show_in_rest'  => true,
		'has_archive'   => false,
		'rewrite'       => array( 'slug' => 'gallery' ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'capability_type' => 'post',
		'menu_icon'     => 'dashicons-format-gallery',
	) );

	register_taxonomy( 'gallery_category', 'pmo_gallery', array(
		'label'        => 'Gallery Category',
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'gallery-category' ),
		'hierarchical' => true,
	) );
}
add_action( 'init', 'pmo_register_gallery_post_type', 0 );

/**
 * Add Gallery Meta Boxes
 */
function pmo_add_gallery_meta_boxes() {
	add_meta_box(
		'gallery_images',
		'📸 Gallery Images',
		'pmo_render_gallery_meta_box',
		'pmo_gallery',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'pmo_add_gallery_meta_boxes' );

/**
 * Render Gallery Meta Box
 */
function pmo_render_gallery_meta_box( $post ) {
	wp_nonce_field( 'pmo_gallery_nonce', 'pmo_gallery_nonce' );

	$gallery_ids = get_post_meta( $post->ID, '_gallery_images', true );
	$ids_array = $gallery_ids ? array_filter( array_map( 'intval', explode( ',', $gallery_ids ) ) ) : array();
	?>

	<div style="padding: 10px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px;">
		<p><strong>Instructions:</strong> Click the button below to select images from your media library. Selected images will be added to this gallery.</p>
	</div>

	<div style="margin-bottom: 20px;">
		<button type="button" class="button button-primary button-large" id="pmo_gallery_upload_button">
			<span style="font-size: 16px;">📸</span> Select Gallery Images
		</button>
	</div>

	<input type="hidden" id="pmo_gallery_image_ids" name="pmo_gallery_images" value="<?php echo esc_attr( $gallery_ids ); ?>">

	<div id="pmo_gallery_images_container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 15px; margin-top: 20px; padding-top: 20px; border-top: 2px solid #ddd;">
		<?php if ( ! empty( $ids_array ) ) { ?>
			<?php foreach ( $ids_array as $image_id ) { ?>
				<div class="pmo-gallery-image-item" data-image-id="<?php echo intval( $image_id ); ?>" style="position: relative; border: 2px solid #ddd; border-radius: 8px; overflow: hidden; background: #f5f5f5;">
					<?php echo wp_get_attachment_image( $image_id, array( 130, 130 ), false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover; display: block;' ) ); ?>
					<button type="button" class="pmo-remove-gallery-image" data-image-id="<?php echo intval( $image_id ); ?>" style="position: absolute; top: 5px; right: 5px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 32px; height: 32px; padding: 0; cursor: pointer; font-size: 18px; line-height: 1; display: flex; align-items: center; justify-content: center;">
						<span>×</span>
					</button>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div style="grid-column: 1 / -1; padding: 40px 20px; text-align: center; color: #999;">
				<p style="font-size: 14px;">No images selected yet. Click "Select Gallery Images" to add photos.</p>
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
 * Enqueue Media Library Scripts
 */
function pmo_enqueue_gallery_scripts( $hook ) {
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
add_action( 'admin_enqueue_scripts', 'pmo_enqueue_gallery_scripts' );

/**
 * Save Gallery Meta Data
 */
function pmo_save_gallery_meta( $post_id ) {
	// Don't save if nonce not set
	if ( ! isset( $_POST['pmo_gallery_nonce'] ) ) {
		return;
	}

	// Verify nonce
	if ( ! wp_verify_nonce( $_POST['pmo_gallery_nonce'], 'pmo_gallery_nonce' ) ) {
		return;
	}

	// Skip autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save gallery images
	if ( isset( $_POST['pmo_gallery_images'] ) && ! empty( $_POST['pmo_gallery_images'] ) ) {
		$gallery_images = sanitize_text_field( $_POST['pmo_gallery_images'] );
		update_post_meta( $post_id, '_gallery_images', $gallery_images );
	} else {
		delete_post_meta( $post_id, '_gallery_images' );
	}
}
add_action( 'save_post_pmo_gallery', 'pmo_save_gallery_meta', 10, 1 );

/**
 * Register Programmes Post Type
 */
function pmo_register_programmes_post_type() {
	register_post_type( 'pmo_programme', array(
		'labels' => array(
			'name'         => 'Programmes',
			'singular_name' => 'Programme',
			'menu_name'    => 'Programmes',
			'all_items'    => 'All Programmes',
			'add_new_item' => 'Add New Programme',
			'edit_item'    => 'Edit Programme',
		),
		'public'        => true,
		'show_in_menu'  => true,
		'show_in_rest'  => true,
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'programmes' ),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'capability_type' => 'post',
		'menu_icon'     => 'dashicons-chart-bar',
	) );

	register_taxonomy( 'programme_category', 'pmo_programme', array(
		'label'        => 'Programme Categories',
		'public'       => true,
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'pmo_register_programmes_post_type' );

/**
 * Add Programme Meta Boxes
 */
function pmo_add_programme_meta_boxes() {
	add_meta_box(
		'programme_details',
		'Programme Details',
		function( $post ) {
			wp_nonce_field( 'programme_details_nonce', 'programme_details_nonce' );

			$status = get_post_meta( $post->ID, '_programme_status', true );
			$budget = get_post_meta( $post->ID, '_programme_budget', true );
			$start_date = get_post_meta( $post->ID, '_programme_start_date', true );
			$end_date = get_post_meta( $post->ID, '_programme_end_date', true );
			$completion = get_post_meta( $post->ID, '_programme_completion', true );
			?>
			<div style="margin-bottom: 15px;">
				<label for="programme_status"><strong>Status:</strong></label>
				<select id="programme_status" name="programme_status" style="width: 100%; padding: 8px;">
					<option value="">-- Select Status --</option>
					<option value="Planned" <?php selected( $status, 'Planned' ); ?>>Planned</option>
					<option value="In Progress" <?php selected( $status, 'In Progress' ); ?>>In Progress</option>
					<option value="Active" <?php selected( $status, 'Active' ); ?>>Active</option>
					<option value="Completed" <?php selected( $status, 'Completed' ); ?>>Completed</option>
				</select>
			</div>

			<div style="margin-bottom: 15px;">
				<label for="programme_budget"><strong>Budget:</strong></label>
				<input type="text" id="programme_budget" name="programme_budget" value="<?php echo esc_attr( $budget ); ?>" placeholder="e.g., ₦2.5 Billion" style="width: 100%; padding: 8px;">
			</div>

			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
				<div>
					<label for="programme_start_date"><strong>Start Date:</strong></label>
					<input type="date" id="programme_start_date" name="programme_start_date" value="<?php echo esc_attr( $start_date ); ?>" style="width: 100%; padding: 8px;">
				</div>
				<div>
					<label for="programme_end_date"><strong>End Date:</strong></label>
					<input type="date" id="programme_end_date" name="programme_end_date" value="<?php echo esc_attr( $end_date ); ?>" style="width: 100%; padding: 8px;">
				</div>
			</div>

			<div style="margin-top: 15px;">
				<label for="programme_completion"><strong>Completion (%):</strong></label>
				<input type="number" id="programme_completion" name="programme_completion" value="<?php echo esc_attr( $completion ); ?>" min="0" max="100" style="width: 100%; padding: 8px;">
			</div>
			<?php
		},
		'pmo_programme',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'pmo_add_programme_meta_boxes' );

/**
 * Save Programme Meta Data
 */
function pmo_save_programme_meta( $post_id ) {
	if ( ! isset( $_POST['programme_details_nonce'] ) || ! wp_verify_nonce( $_POST['programme_details_nonce'], 'programme_details_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
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
		update_post_meta( $post_id, '_programme_completion', intval( $_POST['programme_completion'] ) );
	}
}
add_action( 'save_post_pmo_programme', 'pmo_save_programme_meta' );

/**
 * Accessibility: Add skip links
 */
function pmo_theme_skip_links() {
	?>
	<a href="#main-content" class="skip-link screen-reader-text">
		<?php esc_html_e( 'Skip to main content', 'pmo-portal' ); ?>
	</a>
	<?php
}
add_action( 'wp_body_open', 'pmo_theme_skip_links' );

/**
 * Highlight current menu item for custom post type archives and pages
 */
function pmo_theme_highlight_current_menu_item( $classes, $item ) {
	// Get the site URL
	$home_url = home_url();
	$item_url = $item->url;

	// Get current URL
	$current_url = home_url( $_SERVER['REQUEST_URI'] ?? '' );

	// Normalize URLs for comparison (remove trailing slashes)
	$current_url = rtrim( $current_url, '/' );
	$item_url = rtrim( $item_url, '/' );

	// Check for exact match
	if ( $current_url === $item_url ) {
		$classes[] = 'current-menu-item';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'pmo_theme_highlight_current_menu_item', 10, 2 );

/**
 * Register custom post type for carousel slides
 */
function pmo_register_carousel_post_type() {
	$args = array(
		'label'               => 'Carousel Slides',
		'description'         => 'Hero carousel slides with text overlay',
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'         => false,
		'rewrite'             => array( 'slug' => 'carousel' ),
		'menu_icon'           => 'dashicons-images-alt2',
		'menu_position'       => 5,
	);

	register_post_type( 'pmo_carousel', $args );
}
add_action( 'init', 'pmo_register_carousel_post_type' );

/**
 * Add meta boxes for carousel slides
 */
function pmo_carousel_meta_boxes() {
	add_meta_box(
		'pmo_carousel_meta',
		'Slide Content',
		'pmo_carousel_meta_callback',
		'pmo_carousel',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'pmo_carousel_meta_boxes' );

/**
 * Carousel meta box callback
 */
function pmo_carousel_meta_callback( $post ) {
	wp_nonce_field( 'pmo_carousel_nonce', 'pmo_carousel_nonce' );
	$subtitle = get_post_meta( $post->ID, '_carousel_subtitle', true );
	$button_text = get_post_meta( $post->ID, '_carousel_button_text', true );
	$button_link = get_post_meta( $post->ID, '_carousel_button_link', true );
	?>
	<div style="padding: 20px 0;">
		<div style="margin-bottom: 20px;">
			<label for="carousel_subtitle"><strong>Subtitle (Secondary Text)</strong></label>
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
			<label for="carousel_button_text"><strong>Button Text</strong></label>
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
			<label for="carousel_button_link"><strong>Button Link (URL)</strong></label>
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
function pmo_save_carousel_meta( $post_id ) {
	if ( ! isset( $_POST['pmo_carousel_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_carousel_nonce'], 'pmo_carousel_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
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
add_action( 'save_post_pmo_carousel', 'pmo_save_carousel_meta' );

/**
 * Register custom post type for directorate members
 */
function pmo_register_directorate_post_type() {
	$args = array(
		'label'               => 'Directorate',
		'description'         => 'Directorate members and executives',
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'         => false,
		'rewrite'             => array( 'slug' => 'directorate' ),
		'menu_icon'           => 'dashicons-groups',
		'menu_position'       => 6,
	);

	register_post_type( 'pmo_directorate', $args );
}
add_action( 'init', 'pmo_register_directorate_post_type' );

/**
 * Add meta boxes for directorate
 */
function pmo_directorate_meta_boxes() {
	add_meta_box(
		'pmo_directorate_meta',
		'Directorate Information',
		'pmo_directorate_meta_callback',
		'pmo_directorate',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'pmo_directorate_meta_boxes' );

/**
 * Directorate meta box callback
 */
function pmo_directorate_meta_callback( $post ) {
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
			<label for="position_level"><strong>Position Level</strong></label>
			<select id="position_level" name="position_level" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
				<option value="executive" <?php selected( $position_level, 'executive' ); ?>>Executive Leadership</option>
				<option value="director" <?php selected( $position_level, 'director' ); ?>>Department Staff</option>
			</select>
		</div>

		<div style="margin-bottom: 20px;">
			<label for="staff_role"><strong>Job Title/Role</strong></label>
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
			<label for="department"><strong>Department</strong></label>
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
			<label for="department_color"><strong>Department Color</strong></label>
			<input
				type="color"
				id="department_color"
				name="department_color"
				value="<?php echo esc_attr( $department_color ); ?>"
				style="width: 100%; height: 50px; padding: 5px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;"
			/>
		</div>

		<div style="margin-bottom: 20px;">
			<label for="email"><strong>Email Address</strong></label>
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
			<label for="phone"><strong>Phone Number</strong></label>
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
			<label for="display_order"><strong>Display Order</strong></label>
			<input
				type="number"
				id="display_order"
				name="display_order"
				value="<?php echo esc_attr( $display_order ); ?>"
				placeholder="1"
				min="1"
				style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
			/>
			<p style="font-size: 12px; color: #666; margin-top: 5px;">Lower numbers appear first</p>
		</div>
	</div>
	<?php
}

/**
 * Save directorate meta data
 */
function pmo_save_directorate_meta( $post_id ) {
	if ( ! isset( $_POST['pmo_directorate_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_directorate_nonce'], 'pmo_directorate_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
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
add_action( 'save_post_pmo_directorate', 'pmo_save_directorate_meta' );

/**
 * Register custom post type for events
 */
function pmo_register_event_post_type() {
	$args = array(
		'label'               => 'Events',
		'description'         => 'Events and programmes',
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'events' ),
		'menu_icon'           => 'dashicons-calendar-alt',
		'menu_position'       => 7,
	);

	register_post_type( 'pmo_event', $args );
}
add_action( 'init', 'pmo_register_event_post_type' );

/**
 * Add meta boxes for events
 */
function pmo_event_meta_boxes() {
	add_meta_box(
		'pmo_event_meta',
		'Event Information',
		'pmo_event_meta_callback',
		'pmo_event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'pmo_event_meta_boxes' );

/**
 * Event meta box callback
 */
function pmo_event_meta_callback( $post ) {
	wp_nonce_field( 'pmo_event_nonce', 'pmo_event_nonce' );

	$event_date = get_post_meta( $post->ID, '_event_date', true );
	$event_time = get_post_meta( $post->ID, '_event_time', true );
	$event_venue = get_post_meta( $post->ID, '_event_venue', true );
	$event_contact = get_post_meta( $post->ID, '_event_contact', true );
	?>
	<div style="padding: 20px 0;">
		<div style="margin-bottom: 20px;">
			<label for="event_date"><strong>Event Date</strong></label>
			<input
				type="date"
				id="event_date"
				name="event_date"
				value="<?php echo esc_attr( $event_date ); ?>"
				style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
			/>
		</div>

		<div style="margin-bottom: 20px;">
			<label for="event_time"><strong>Event Time</strong></label>
			<input
				type="text"
				id="event_time"
				name="event_time"
				value="<?php echo esc_attr( $event_time ); ?>"
				placeholder="e.g., 10:00 AM"
				style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
			/>
		</div>

		<div style="margin-bottom: 20px;">
			<label for="event_venue"><strong>Event Venue</strong></label>
			<input
				type="text"
				id="event_venue"
				name="event_venue"
				value="<?php echo esc_attr( $event_venue ); ?>"
				placeholder="e.g., PMO Conference Center, Ikeja"
				style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
			/>
		</div>

		<div style="margin-bottom: 20px;">
			<label for="event_contact"><strong>Contact Information</strong></label>
			<input
				type="text"
				id="event_contact"
				name="event_contact"
				value="<?php echo esc_attr( $event_contact ); ?>"
				placeholder="e.g., +234 (0) 1 XXX XXXX"
				style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;"
			/>
		</div>
	</div>
	<?php
}

/**
 * Save event meta data
 */
function pmo_save_event_meta( $post_id ) {
	if ( ! isset( $_POST['pmo_event_nonce'] ) || ! wp_verify_nonce( $_POST['pmo_event_nonce'], 'pmo_event_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['event_date'] ) ) {
		update_post_meta( $post_id, '_event_date', sanitize_text_field( $_POST['event_date'] ) );
	}

	if ( isset( $_POST['event_time'] ) ) {
		update_post_meta( $post_id, '_event_time', sanitize_text_field( $_POST['event_time'] ) );
	}

	if ( isset( $_POST['event_venue'] ) ) {
		update_post_meta( $post_id, '_event_venue', sanitize_text_field( $_POST['event_venue'] ) );
	}

	if ( isset( $_POST['event_contact'] ) ) {
		update_post_meta( $post_id, '_event_contact', sanitize_text_field( $_POST['event_contact'] ) );
	}
}
add_action( 'save_post_pmo_event', 'pmo_save_event_meta' );

/**
 * AJAX Handler for Gallery Preview
 */
function pmo_get_gallery_preview() {
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
			<button type="button" class="pmo-remove" style="position: absolute; top: 2px; right: 2px; background: #dc3545; color: white; border: none; width: 20px; height: 20px; border-radius: 50%; cursor: pointer; padding: 0; font-size: 12px; line-height: 1; display: flex; align-items: center; justify-content: center;">×</button>
		</div>';
	}

	wp_send_json_success( $html );
}
add_action( 'wp_ajax_pmo_get_gallery_preview', 'pmo_get_gallery_preview' );

/**
 * Register template parts
 */
require_once PMO_THEME_PATH . '/inc/template-functions.php';

/**
 * Customizer integration
 */
require_once PMO_THEME_PATH . '/inc/customizer.php';

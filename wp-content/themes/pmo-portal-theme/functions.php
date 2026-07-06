<?php
/**
 * PMO Portal Theme Functions
 *
 * Content types (galleries, programmes, carousel, directorate, events, …)
 * are registered by the PMO Core plugin so content survives a theme switch.
 * This file only handles presentation concerns.
 *
 * @package PMO_Portal_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PMO_THEME_VERSION', '1.1.0' );
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
 * Asset version helper — uses the file's modification time so browsers
 * re-download only when a file actually changes.
 */
function pmo_theme_asset_version( $relative_path ) {
	$file = PMO_THEME_PATH . $relative_path;
	return file_exists( $file ) ? (string) filemtime( $file ) : PMO_THEME_VERSION;
}

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

	// Enqueue Google Fonts - Inter, Manrope with font-display swap
	wp_enqueue_style( 'pmo-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap', array(), '1.0.0' );

	// Enqueue premium design system
	wp_enqueue_style( 'pmo-design-system', PMO_THEME_URL . '/assets/css/pmo-design-system.css', array(), pmo_theme_asset_version( '/assets/css/pmo-design-system.css' ) );

	// Enqueue theme stylesheet
	wp_enqueue_style( 'pmo-theme-style', PMO_THEME_URL . '/style.css', array( 'pmo-design-system' ), pmo_theme_asset_version( '/style.css' ) );

	// Enqueue responsive styles
	wp_enqueue_style( 'pmo-responsive', PMO_THEME_URL . '/responsive.css', array( 'pmo-theme-style' ), pmo_theme_asset_version( '/responsive.css' ) );

	// Enqueue homepage styles
	wp_enqueue_style( 'pmo-homepage', PMO_THEME_URL . '/assets/css/homepage.css', array( 'pmo-theme-style' ), pmo_theme_asset_version( '/assets/css/homepage.css' ) );

	// Enqueue carousel script
	wp_enqueue_script( 'pmo-carousel', PMO_THEME_URL . '/assets/js/carousel.js', array(), pmo_theme_asset_version( '/assets/js/carousel.js' ), true );

	// Enqueue header enhancement script (sticky header, mobile menu)
	wp_enqueue_script( 'pmo-header-enhance', PMO_THEME_URL . '/assets/js/header-search.js', array(), pmo_theme_asset_version( '/assets/js/header-search.js' ), true );

	// Pass variables to JavaScript (used by the AJAX search endpoint)
	wp_localize_script( 'pmo-header-enhance', 'pmoTheme', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'pmo_theme_nonce' ),
	) );

	// Enqueue animations script
	wp_enqueue_script( 'pmo-animations', PMO_THEME_URL . '/assets/js/animations.js', array(), pmo_theme_asset_version( '/assets/js/animations.js' ), true );
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
 * Add active class to menu items based on current page.
 *
 * Handles the cases WordPress misses: custom post type archives and
 * plain path matches for custom menu links.
 */
function pmo_nav_menu_css_class( $classes, $item ) {
	// If WordPress already marked it as current, add active class
	if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true ) ) {
		if ( ! in_array( 'active', $classes, true ) ) {
			$classes[] = 'active';
		}
		return $classes;
	}

	$mark_active = false;

	// Direct path match against the current request
	$current_path = untrailingslashit( wp_parse_url( home_url( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ) ?? '' );
	$item_path    = untrailingslashit( wp_parse_url( $item->url, PHP_URL_PATH ) ?? '' );

	if ( '' !== $item_path && $current_path === $item_path ) {
		$mark_active = true;
	}

	// Custom post type archives: match the menu item that links to the archive
	if ( ! $mark_active && is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		if ( is_array( $post_type ) ) {
			$post_type = reset( $post_type );
		}

		$archive_link = $post_type ? get_post_type_archive_link( $post_type ) : false;
		if ( $archive_link ) {
			$archive_path = untrailingslashit( wp_parse_url( $archive_link, PHP_URL_PATH ) ?? '' );
			if ( '' !== $archive_path && $archive_path === $item_path ) {
				$mark_active = true;
			}
		}
	}

	if ( $mark_active ) {
		$classes[] = 'active';
		if ( ! in_array( 'current-menu-item', $classes, true ) ) {
			$classes[] = 'current-menu-item';
		}
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'pmo_nav_menu_css_class', 10, 2 );

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
	return ' ... <a href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'pmo-portal' ) . '</a>';
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
 * Output a per-page meta description.
 */
function pmo_theme_meta_description() {
	$description = '';

	if ( is_singular() ) {
		$description = get_the_excerpt();
	}

	if ( ! $description ) {
		$description = get_bloginfo( 'description', 'display' );
	}

	if ( ! $description ) {
		$description = 'Lagos State Parastatals Monitoring Office - Government Digital Platform';
	}

	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( wp_trim_words( $description, 30, '' ) ) );
}
add_action( 'wp_head', 'pmo_theme_meta_description', 1 );

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
 * Enable Native Lazy Loading for Images
 */
function pmo_theme_add_lazy_loading_to_images( $image, $context ) {
	if ( 'the_content' === $context && false === strpos( $image, 'loading=' ) ) {
		$image = str_replace( '<img ', '<img loading="lazy" ', $image );
	}
	return $image;
}
add_filter( 'wp_content_img_tag', 'pmo_theme_add_lazy_loading_to_images', 10, 2 );

/**
 * Remove emoji scripts for performance
 */
function pmo_theme_remove_emoji_script() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'pmo_theme_remove_emoji_script' );

/**
 * Disable XML-RPC for Security & Performance
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * AJAX Handler for Site Search
 */
function pmo_search() {
	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'pmo_theme_nonce' ) ) {
		wp_send_json_error( 'Security check failed' );
	}

	// Get search query
	$query = isset( $_POST['query'] ) ? sanitize_text_field( $_POST['query'] ) : '';

	if ( strlen( $query ) < 2 ) {
		wp_send_json_error( 'Query too short' );
	}

	// Search posts, pages, and custom post types
	$args = array(
		's'              => $query,
		'posts_per_page' => 8,
		'post_type'      => array( 'post', 'page', 'pmo_news', 'pmo_programme', 'pmo_event', 'pmo_gallery' ),
	);

	$search_query = new WP_Query( $args );
	$results = array();

	if ( $search_query->have_posts() ) {
		while ( $search_query->have_posts() ) {
			$search_query->the_post();

			// Determine post type label
			$post_type = get_post_type();
			$type_labels = array(
				'post'          => 'Blog Post',
				'page'          => 'Page',
				'pmo_news'      => 'News',
				'pmo_programme' => 'Programme',
				'pmo_event'     => 'Event',
				'pmo_gallery'   => 'Gallery',
			);
			$type_label = $type_labels[ $post_type ] ?? 'Post';

			$results[] = array(
				'title' => get_the_title(),
				'url'   => get_permalink(),
				'type'  => $type_label,
			);
		}
		wp_reset_postdata();
	}

	wp_send_json_success( array( 'results' => $results ) );
}
add_action( 'wp_ajax_pmo_search', 'pmo_search' );
add_action( 'wp_ajax_nopriv_pmo_search', 'pmo_search' );

/**
 * Register template parts
 */
require_once PMO_THEME_PATH . '/inc/template-functions.php';

/**
 * Customizer integration
 */
require_once PMO_THEME_PATH . '/inc/customizer.php';

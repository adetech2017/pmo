<?php
/**
 * Plugin Name: PMO Core - Project Monitoring Office
 * Description: Core plugin for Lagos State PMO Digital Portal with projects, news, events, and more.
 * Version: 1.0.0
 * Author: PMO Development Team
 * Text Domain: pmo-core
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'PMO_CORE_VERSION', '1.0.0' );
define( 'PMO_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'PMO_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'PMO_CORE_BASENAME', plugin_basename( __FILE__ ) );

// Include core files
require_once PMO_CORE_PATH . 'includes/class-pmo-core.php';

// Load translations
add_action( 'init', function() {
	load_plugin_textdomain( 'pmo-core', false, dirname( PMO_CORE_BASENAME ) . '/languages' );
}, 0 );

// Initialize the plugin on init hook (after rewrite rules are set up)
add_action( 'init', function() {
	try {
		// Load dependencies first
		require_once PMO_CORE_PATH . 'includes/class-pmo-post-types.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-taxonomies.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-user-roles.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-project-module.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-news-module.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-events-module.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-leadership-module.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-publications-module.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-project-map.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-shortcodes.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-widgets.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-tenders-module.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-contact-form.php';
		require_once PMO_CORE_PATH . 'includes/class-pmo-search.php';

		// Initialize the plugin
		$pmo_core = new PMO_Core();
		$pmo_core->init();
	} catch ( Exception $e ) {
		error_log( 'PMO Core Error: ' . $e->getMessage() );
	}
}, 10 );

// Create pages and menus on first init after activation
add_action( 'init', function() {
	if ( get_transient( 'pmo_create_pages' ) ) {
		delete_transient( 'pmo_create_pages' );
		try {
			require_once PMO_CORE_PATH . 'includes/class-pmo-pages.php';
			PMO_Pages::create_pages();
			PMO_Pages::create_menus();
		} catch ( Exception $e ) {
			error_log( 'PMO Pages Creation Error: ' . $e->getMessage() );
		}
	}
}, 20 );

// Activation hook
register_activation_hook( __FILE__, function() {
	require_once PMO_CORE_PATH . 'includes/class-pmo-activator.php';
	PMO_Activator::activate();

	// Set transient to create pages on next init
	set_transient( 'pmo_create_pages', true, 30 );
} );

// Deactivation hook
register_deactivation_hook( __FILE__, function() {
	require_once PMO_CORE_PATH . 'includes/class-pmo-deactivator.php';
	PMO_Deactivator::deactivate();
} );

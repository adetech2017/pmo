<?php
/**
 * Main PMO Core Class
 *
 * @package PMO_Core
 */

class PMO_Core {

	/**
	 * Initialize the plugin
	 */
	public function init() {
		$this->register_hooks();
		$this->register_post_types();
		$this->register_taxonomies();
	}

	/**
	 * Register WordPress hooks
	 */
	private function register_hooks() {
		add_action( 'init', array( $this, 'on_init' ), 5 );
		add_action( 'init', array( $this, 'initialize_modules' ), 15 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Initialize modules
	 */
	public function initialize_modules() {
		try {
			PMO_Project_Module::init();
			PMO_News_Module::init();
			PMO_Events_Module::init();
			PMO_Leadership_Module::init();
			PMO_Publications_Module::init();
			PMO_Tenders_Module::init();
			PMO_Project_Map::init();
			PMO_Shortcodes::init();
			PMO_Widgets::init();
			PMO_Contact_Form::init();
			PMO_Search::init();
		} catch ( Exception $e ) {
			error_log( 'PMO Modules Error: ' . $e->getMessage() );
		}
	}

	/**
	 * On init action
	 */
	public function on_init() {
		try {
			$this->register_post_types();
			$this->register_taxonomies();
		} catch ( Exception $e ) {
			error_log( 'PMO Init Error: ' . $e->getMessage() );
		}
	}

	/**
	 * Register custom post types
	 */
	private function register_post_types() {
		$post_types = new PMO_Post_Types();
		$post_types->register_all();
	}

	/**
	 * Register custom taxonomies
	 */
	private function register_taxonomies() {
		$taxonomies = new PMO_Taxonomies();
		$taxonomies->register_all();
	}

	/**
	 * Enqueue admin assets
	 */
	public function enqueue_admin_assets() {
		wp_enqueue_style( 'pmo-admin-css', PMO_CORE_URL . 'assets/css/admin.css', array(), PMO_CORE_VERSION );
		wp_enqueue_script( 'pmo-admin-js', PMO_CORE_URL . 'assets/js/admin.js', array( 'jquery' ), PMO_CORE_VERSION, true );
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_frontend_assets() {
		wp_enqueue_style( 'pmo-frontend-css', PMO_CORE_URL . 'assets/css/frontend.css', array(), PMO_CORE_VERSION );
		wp_enqueue_script( 'pmo-frontend-js', PMO_CORE_URL . 'assets/js/frontend.js', array( 'jquery' ), PMO_CORE_VERSION, true );
	}
}

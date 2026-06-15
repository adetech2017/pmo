<?php
/**
 * PMO Post Types
 *
 * @package PMO_Core
 */

class PMO_Post_Types {

	/**
	 * Register all custom post types
	 */
	public function register_all() {
		$this->register_projects();
		$this->register_news();
		$this->register_events();
		$this->register_progress_updates();
		$this->register_publications();
		$this->register_tenders();
		$this->register_leadership();
	}

	/**
	 * Register Projects post type
	 */
	private function register_projects() {
		register_post_type( 'pmo_project', array(
			'labels' => array(
				'name'               => _x( 'Projects', 'Post Type General Name', 'pmo-core' ),
				'singular_name'      => _x( 'Project', 'Post Type Singular Name', 'pmo-core' ),
				'menu_name'          => __( 'Projects', 'pmo-core' ),
				'all_items'          => __( 'All Projects', 'pmo-core' ),
				'add_new_item'       => __( 'Add New Project', 'pmo-core' ),
				'edit_item'          => __( 'Edit Project', 'pmo-core' ),
				'new_item'           => __( 'New Project', 'pmo-core' ),
				'view_item'          => __( 'View Project', 'pmo-core' ),
			),
			'public'             => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'projects' ),
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
			'menu_icon'          => 'dashicons-location-alt',
		) );
	}

	/**
	 * Register News post type
	 */
	private function register_news() {
		register_post_type( 'pmo_news', array(
			'labels' => array(
				'name'               => _x( 'News', 'Post Type General Name', 'pmo-core' ),
				'singular_name'      => _x( 'News', 'Post Type Singular Name', 'pmo-core' ),
				'menu_name'          => __( 'News', 'pmo-core' ),
				'all_items'          => __( 'All News', 'pmo-core' ),
				'add_new_item'       => __( 'Add News Article', 'pmo-core' ),
				'edit_item'          => __( 'Edit News', 'pmo-core' ),
			),
			'public'             => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'news' ),
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
			'menu_icon'          => 'dashicons-newspaper',
		) );
	}

	/**
	 * Register Events post type
	 */
	private function register_events() {
		register_post_type( 'pmo_event', array(
			'labels' => array(
				'name'               => _x( 'Events', 'Post Type General Name', 'pmo-core' ),
				'singular_name'      => _x( 'Event', 'Post Type Singular Name', 'pmo-core' ),
				'menu_name'          => __( 'Events', 'pmo-core' ),
				'all_items'          => __( 'All Events', 'pmo-core' ),
				'add_new_item'       => __( 'Add Event', 'pmo-core' ),
			),
			'public'             => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'events' ),
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'menu_icon'          => 'dashicons-calendar-alt',
		) );
	}

	/**
	 * Register Progress Updates post type
	 */
	private function register_progress_updates() {
		register_post_type( 'pmo_progress', array(
			'labels' => array(
				'name'               => _x( 'Progress Updates', 'Post Type General Name', 'pmo-core' ),
				'singular_name'      => _x( 'Progress Update', 'Post Type Singular Name', 'pmo-core' ),
				'menu_name'          => __( 'Progress Updates', 'pmo-core' ),
			),
			'public'             => false,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'menu_icon'          => 'dashicons-chart-line',
		) );
	}

	/**
	 * Register Publications post type
	 */
	private function register_publications() {
		register_post_type( 'pmo_publication', array(
			'labels' => array(
				'name'               => _x( 'Publications', 'Post Type General Name', 'pmo-core' ),
				'singular_name'      => _x( 'Publication', 'Post Type Singular Name', 'pmo-core' ),
				'menu_name'          => __( 'Publications', 'pmo-core' ),
				'all_items'          => __( 'All Publications', 'pmo-core' ),
				'add_new_item'       => __( 'Add Publication', 'pmo-core' ),
			),
			'public'             => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'publications' ),
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'menu_icon'          => 'dashicons-media-document',
		) );
	}

	/**
	 * Register Tenders post type
	 */
	private function register_tenders() {
		register_post_type( 'pmo_tender', array(
			'labels' => array(
				'name'               => _x( 'Tenders', 'Post Type General Name', 'pmo-core' ),
				'singular_name'      => _x( 'Tender', 'Post Type Singular Name', 'pmo-core' ),
				'menu_name'          => __( 'Tenders', 'pmo-core' ),
				'all_items'          => __( 'All Tenders', 'pmo-core' ),
				'add_new_item'       => __( 'Add Tender', 'pmo-core' ),
			),
			'public'             => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'tenders' ),
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'editor', 'custom-fields' ),
			'menu_icon'          => 'dashicons-portfolio',
		) );
	}

	/**
	 * Register Leadership post type
	 */
	private function register_leadership() {
		register_post_type( 'pmo_leadership', array(
			'labels' => array(
				'name'               => _x( 'Leadership', 'Post Type General Name', 'pmo-core' ),
				'singular_name'      => _x( 'Team Member', 'Post Type Singular Name', 'pmo-core' ),
				'menu_name'          => __( 'Leadership', 'pmo-core' ),
				'all_items'          => __( 'All Team Members', 'pmo-core' ),
				'add_new_item'       => __( 'Add Team Member', 'pmo-core' ),
			),
			'public'             => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'rewrite'            => array( 'slug' => 'leadership' ),
			'capability_type'    => 'post',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'menu_icon'          => 'dashicons-groups',
		) );
	}
}

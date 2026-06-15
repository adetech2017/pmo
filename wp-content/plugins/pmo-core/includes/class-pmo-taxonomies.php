<?php
/**
 * PMO Taxonomies
 *
 * @package PMO_Core
 */

class PMO_Taxonomies {

	/**
	 * Register all custom taxonomies
	 */
	public function register_all() {
		$this->register_project_category();
		$this->register_project_status();
		$this->register_lga();
		$this->register_news_category();
		$this->register_event_category();
		$this->register_publication_category();
		$this->register_leadership_level();
	}

	/**
	 * Register Project Category taxonomy
	 */
	private function register_project_category() {
		register_taxonomy( 'pmo_project_category', array( 'pmo_project' ), array(
			'labels' => array(
				'name'              => _x( 'Project Categories', 'Taxonomy General Name', 'pmo-core' ),
				'singular_name'     => _x( 'Project Category', 'Taxonomy Singular Name', 'pmo-core' ),
				'search_items'      => __( 'Search Project Categories', 'pmo-core' ),
				'all_items'         => __( 'All Project Categories', 'pmo-core' ),
				'edit_item'         => __( 'Edit Project Category', 'pmo-core' ),
				'update_item'       => __( 'Update Project Category', 'pmo-core' ),
				'add_new_item'      => __( 'Add New Project Category', 'pmo-core' ),
				'new_item_name'     => __( 'New Project Category Name', 'pmo-core' ),
				'menu_name'         => __( 'Project Categories', 'pmo-core' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'project-category' ),
		) );

		// Add default project categories
		$categories = array(
			'Roads', 'Bridges', 'Drainage', 'Schools', 'Healthcare',
			'Water', 'Housing', 'Markets', 'ICT', 'Security', 'Environment', 'Transportation'
		);

		foreach ( $categories as $category ) {
			if ( ! term_exists( $category, 'pmo_project_category' ) ) {
				wp_insert_term( $category, 'pmo_project_category' );
			}
		}
	}

	/**
	 * Register Project Status taxonomy
	 */
	private function register_project_status() {
		register_taxonomy( 'pmo_project_status', array( 'pmo_project' ), array(
			'labels' => array(
				'name'              => _x( 'Project Status', 'Taxonomy General Name', 'pmo-core' ),
				'singular_name'     => _x( 'Project Status', 'Taxonomy Singular Name', 'pmo-core' ),
				'search_items'      => __( 'Search Project Status', 'pmo-core' ),
				'all_items'         => __( 'All Project Status', 'pmo-core' ),
				'edit_item'         => __( 'Edit Project Status', 'pmo-core' ),
				'menu_name'         => __( 'Project Status', 'pmo-core' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'project-status' ),
		) );

		// Add default project statuses
		$statuses = array(
			'Planned', 'Approved', 'Procurement', 'Mobilized', 'In Progress',
			'Near Completion', 'Completed', 'Suspended', 'Cancelled'
		);

		foreach ( $statuses as $status ) {
			if ( ! term_exists( $status, 'pmo_project_status' ) ) {
				wp_insert_term( $status, 'pmo_project_status' );
			}
		}
	}

	/**
	 * Register LGA taxonomy
	 */
	private function register_lga() {
		register_taxonomy( 'pmo_lga', array( 'pmo_project' ), array(
			'labels' => array(
				'name'              => _x( 'LGAs', 'Taxonomy General Name', 'pmo-core' ),
				'singular_name'     => _x( 'LGA', 'Taxonomy Singular Name', 'pmo-core' ),
				'search_items'      => __( 'Search LGAs', 'pmo-core' ),
				'all_items'         => __( 'All LGAs', 'pmo-core' ),
				'edit_item'         => __( 'Edit LGA', 'pmo-core' ),
				'add_new_item'      => __( 'Add New LGA', 'pmo-core' ),
				'menu_name'         => __( 'LGAs', 'pmo-core' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'lga' ),
		) );
	}

	/**
	 * Register News Category taxonomy
	 */
	private function register_news_category() {
		register_taxonomy( 'pmo_news_category', array( 'pmo_news' ), array(
			'labels' => array(
				'name'              => _x( 'News Categories', 'Taxonomy General Name', 'pmo-core' ),
				'singular_name'     => _x( 'News Category', 'Taxonomy Singular Name', 'pmo-core' ),
				'search_items'      => __( 'Search News Categories', 'pmo-core' ),
				'all_items'         => __( 'All News Categories', 'pmo-core' ),
				'edit_item'         => __( 'Edit News Category', 'pmo-core' ),
				'add_new_item'      => __( 'Add New News Category', 'pmo-core' ),
				'menu_name'         => __( 'News Categories', 'pmo-core' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'news-category' ),
		) );
	}

	/**
	 * Register Event Category taxonomy
	 */
	private function register_event_category() {
		register_taxonomy( 'pmo_event_category', array( 'pmo_event' ), array(
			'labels' => array(
				'name'              => _x( 'Event Categories', 'Taxonomy General Name', 'pmo-core' ),
				'singular_name'     => _x( 'Event Category', 'Taxonomy Singular Name', 'pmo-core' ),
				'search_items'      => __( 'Search Event Categories', 'pmo-core' ),
				'all_items'         => __( 'All Event Categories', 'pmo-core' ),
				'add_new_item'      => __( 'Add New Event Category', 'pmo-core' ),
				'menu_name'         => __( 'Event Categories', 'pmo-core' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'event-category' ),
		) );
	}

	/**
	 * Register Publication Category taxonomy
	 */
	private function register_publication_category() {
		register_taxonomy( 'pmo_publication_category', array( 'pmo_publication' ), array(
			'labels' => array(
				'name'              => _x( 'Publication Categories', 'Taxonomy General Name', 'pmo-core' ),
				'singular_name'     => _x( 'Publication Category', 'Taxonomy Singular Name', 'pmo-core' ),
				'search_items'      => __( 'Search Publication Categories', 'pmo-core' ),
				'all_items'         => __( 'All Publication Categories', 'pmo-core' ),
				'add_new_item'      => __( 'Add New Publication Category', 'pmo-core' ),
				'menu_name'         => __( 'Publication Categories', 'pmo-core' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'publication-category' ),
		) );

		// Add default publication categories
		$categories = array(
			'Annual Reports', 'Project Reports', 'Policy Documents',
			'Guidelines', 'Press Releases', 'Tenders', 'Procurement Notices'
		);

		foreach ( $categories as $category ) {
			if ( ! term_exists( $category, 'pmo_publication_category' ) ) {
				wp_insert_term( $category, 'pmo_publication_category' );
			}
		}
	}

	/**
	 * Register Leadership Level taxonomy
	 */
	private function register_leadership_level() {
		register_taxonomy( 'pmo_leadership_level', array( 'pmo_leadership' ), array(
			'labels' => array(
				'name'              => _x( 'Leadership Levels', 'Taxonomy General Name', 'pmo-core' ),
				'singular_name'     => _x( 'Leadership Level', 'Taxonomy Singular Name', 'pmo-core' ),
				'search_items'      => __( 'Search Leadership Levels', 'pmo-core' ),
				'all_items'         => __( 'All Leadership Levels', 'pmo-core' ),
				'add_new_item'      => __( 'Add New Leadership Level', 'pmo-core' ),
				'menu_name'         => __( 'Leadership Levels', 'pmo-core' ),
			),
			'hierarchical'      => false,
			'public'            => false,
			'show_in_rest'      => true,
		) );

		// Add default leadership levels
		$levels = array( 'Director', 'Management Team', 'Board Members' );

		foreach ( $levels as $level ) {
			if ( ! term_exists( $level, 'pmo_leadership_level' ) ) {
				wp_insert_term( $level, 'pmo_leadership_level' );
			}
		}
	}
}

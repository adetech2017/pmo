<?php
/**
 * PMO Pages Setup
 *
 * @package PMO_Core
 */

class PMO_Pages {

	/**
	 * Create core pages
	 */
	public static function create_pages() {
		$pages = array(
			array(
				'post_title'    => __( 'Home', 'pmo-core' ),
				'post_name'     => 'home',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_home_hero][pmo_statistics_dashboard][pmo_featured_projects count="6" title="Featured Projects"][pmo_latest_news count="3" title="Latest News"][pmo_upcoming_events count="3" title="Upcoming Events"][pmo_leadership_message][pmo_cta_section]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'About PMO', 'pmo-core' ),
				'post_name'     => 'about-pmo',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Projects', 'pmo-core' ),
				'post_name'     => 'projects-main',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_project_listing]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Project Map', 'pmo-core' ),
				'post_name'     => 'project-map',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_project_map]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'News', 'pmo-core' ),
				'post_name'     => 'news',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_news_listing]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Events', 'pmo-core' ),
				'post_name'     => 'events',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_events_listing]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Media Centre', 'pmo-core' ),
				'post_name'     => 'media-centre',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Publications', 'pmo-core' ),
				'post_name'     => 'publications',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_publications_listing]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Tenders', 'pmo-core' ),
				'post_name'     => 'tenders',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_tenders_listing]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Leadership', 'pmo-core' ),
				'post_name'     => 'leadership',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_leadership_listing]',
				'post_parent'   => 0,
			),
			array(
				'post_title'    => __( 'Contact Us', 'pmo-core' ),
				'post_name'     => 'contact-us',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_content'  => '[pmo_contact_form]',
				'post_parent'   => 0,
			),
		);

		foreach ( $pages as $page_data ) {
			// Check if page already exists
			$existing = get_page_by_path( $page_data['post_name'], OBJECT, 'page' );
			if ( ! $existing ) {
				wp_insert_post( $page_data );
			}
		}
	}

	/**
	 * Create navigation menus
	 */
	public static function create_menus() {
		// Create Primary Menu
		$primary_menu_id = wp_create_nav_menu( __( 'Primary Menu', 'pmo-core' ), array( 'slug' => 'primary-menu' ) );

		if ( ! is_wp_error( $primary_menu_id ) ) {
			// Add menu items
			$menu_items = array(
				array(
					'title' => __( 'Home', 'pmo-core' ),
					'url'   => home_url( '/' ),
				),
				array(
					'title' => __( 'About PMO', 'pmo-core' ),
					'url'   => home_url( '/about-pmo/' ),
				),
				array(
					'title' => __( 'Projects', 'pmo-core' ),
					'url'   => home_url( '/projects-main/' ),
				),
				array(
					'title' => __( 'News', 'pmo-core' ),
					'url'   => home_url( '/news/' ),
				),
				array(
					'title' => __( 'Events', 'pmo-core' ),
					'url'   => home_url( '/events/' ),
				),
				array(
					'title' => __( 'Publications', 'pmo-core' ),
					'url'   => home_url( '/publications/' ),
				),
				array(
					'title' => __( 'Contact', 'pmo-core' ),
					'url'   => home_url( '/contact-us/' ),
				),
			);

			foreach ( $menu_items as $item ) {
				wp_update_nav_menu_item( $primary_menu_id, 0, array(
					'menu-item-title'  => $item['title'],
					'menu-item-url'    => $item['url'],
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
				) );
			}

			// Assign menu to Primary Menu location
			$locations = get_theme_mod( 'nav_menu_locations' );
			$locations['primary'] = $primary_menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		// Create Footer Menu
		$footer_menu_id = wp_create_nav_menu( __( 'Footer Menu', 'pmo-core' ), array( 'slug' => 'footer-menu' ) );

		if ( ! is_wp_error( $footer_menu_id ) ) {
			$footer_items = array(
				array(
					'title' => __( 'Privacy Policy', 'pmo-core' ),
					'url'   => home_url( '/privacy-policy/' ),
				),
				array(
					'title' => __( 'Terms & Conditions', 'pmo-core' ),
					'url'   => home_url( '/terms-and-conditions/' ),
				),
				array(
					'title' => __( 'Site Map', 'pmo-core' ),
					'url'   => home_url( '/sitemap/' ),
				),
			);

			foreach ( $footer_items as $item ) {
				wp_update_nav_menu_item( $footer_menu_id, 0, array(
					'menu-item-title'  => $item['title'],
					'menu-item-url'    => $item['url'],
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
				) );
			}

			// Assign menu to Footer Menu location
			$locations = get_theme_mod( 'nav_menu_locations' );
			$locations['footer'] = $footer_menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}
}

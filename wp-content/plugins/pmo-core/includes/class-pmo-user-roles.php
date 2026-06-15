<?php
/**
 * PMO User Roles and Capabilities
 *
 * @package PMO_Core
 */

class PMO_User_Roles {

	/**
	 * Create all PMO user roles
	 */
	public static function create_roles() {
		// PMO Administrator
		add_role( 'pmo_admin', __( 'PMO Administrator', 'pmo-core' ), array(
			'read'                  => true,
			'edit_posts'            => true,
			'edit_published_posts'  => true,
			'publish_posts'         => true,
			'delete_posts'          => true,
			'manage_categories'     => true,
			'upload_files'          => true,
			'edit_pmo_projects'     => true,
			'edit_published_pmo_projects' => true,
			'publish_pmo_projects'  => true,
			'delete_pmo_projects'   => true,
			'edit_pmo_news'         => true,
			'edit_published_pmo_news' => true,
			'publish_pmo_news'      => true,
			'delete_pmo_news'       => true,
			'edit_pmo_events'       => true,
			'edit_published_pmo_events' => true,
			'publish_pmo_events'    => true,
			'delete_pmo_events'     => true,
			'edit_pmo_publications' => true,
			'publish_pmo_publications' => true,
			'delete_pmo_publications' => true,
		) );

		// Content Editor
		add_role( 'pmo_editor', __( 'Content Editor', 'pmo-core' ), array(
			'read'                  => true,
			'edit_posts'            => true,
			'edit_published_posts'  => true,
			'publish_posts'         => true,
			'upload_files'          => true,
			'edit_pmo_news'         => true,
			'edit_published_pmo_news' => true,
			'publish_pmo_news'      => true,
			'edit_pmo_events'       => true,
			'edit_published_pmo_events' => true,
			'publish_pmo_events'    => true,
			'edit_pmo_publications' => true,
			'publish_pmo_publications' => true,
		) );

		// Project Officer
		add_role( 'pmo_officer', __( 'Project Officer', 'pmo-core' ), array(
			'read'                  => true,
			'edit_pmo_projects'     => true,
			'edit_published_pmo_projects' => true,
			'upload_files'          => true,
			'edit_pmo_progress'     => true,
			'publish_pmo_progress'  => true,
		) );
	}

	/**
	 * Remove all PMO user roles
	 */
	public static function remove_roles() {
		remove_role( 'pmo_admin' );
		remove_role( 'pmo_editor' );
		remove_role( 'pmo_officer' );
	}
}

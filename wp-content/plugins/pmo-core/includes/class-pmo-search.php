<?php
/**
 * PMO Search Enhancement
 *
 * Enhances WordPress search to include custom post types
 *
 * @package PMO_Core
 */

class PMO_Search {

	/**
	 * Initialize search enhancement
	 */
	public static function init() {
		add_filter( 'pre_get_posts', array( __CLASS__, 'extend_search' ) );
	}

	/**
	 * Extend search to include custom post types
	 */
	public static function extend_search( $query ) {
		// Only modify the main search query on the front-end
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
			return $query;
		}

		// Include custom post types in search
		$post_types = array(
			'post',
			'pmo_project',
			'pmo_news',
			'pmo_event',
			'pmo_publication',
			'pmo_leadership',
			'pmo_tender',
		);

		$query->set( 'post_type', $post_types );

		return $query;
	}
}

<?php
/**
 * Template functions
 *
 * @package PMO_Portal_Theme
 */

/**
 * Get excerpt
 */
function pmo_theme_get_excerpt( $post_id = null ) {
	$post_id = $post_id ?? get_the_ID();
	$post = get_post( $post_id );

	if ( $post->post_excerpt ) {
		return $post->post_excerpt;
	}

	$excerpt = wp_strip_all_tags( $post->post_content );
	$excerpt = substr( $excerpt, 0, 150 );

	return $excerpt . '...';
}

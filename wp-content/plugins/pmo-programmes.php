<?php
/**
 * Plugin Name: PMO Programmes Manager
 * Description: Register and manage Programmes (Projects) for PMO
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Flush rewrite rules on activation
register_activation_hook( __FILE__, function() {
	flush_rewrite_rules();
} );

// Register Programmes Post Type
add_action( 'init', function() {
	register_post_type( 'pmo_programme', array(
		'labels' => array(
			'name'               => 'Programmes',
			'singular_name'      => 'Programme',
			'menu_name'          => 'Programmes',
			'all_items'          => 'All Programmes',
			'add_new_item'       => 'Add New Programme',
			'edit_item'          => 'Edit Programme',
			'view_item'          => 'View Programme',
			'search_items'       => 'Search Programmes',
		),
		'public'             => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'programmes' ),
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-chart-bar',
		'taxonomies'         => array( 'category' ),
	) );

	register_taxonomy( 'programme_category', 'pmo_programme', array(
		'label'         => 'Programme Categories',
		'public'        => true,
		'show_in_rest'  => true,
		'rewrite'       => array( 'slug' => 'programme-category' ),
	) );
}, 0 );

// Add Meta Boxes for Programme Details
add_action( 'add_meta_boxes', function() {
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
				<label for="programme_status" style="display: block; margin-bottom: 5px;"><strong>Status:</strong></label>
				<select id="programme_status" name="programme_status" style="width: 100%; padding: 8px;">
					<option value="">-- Select Status --</option>
					<option value="Planned" <?php selected( $status, 'Planned' ); ?>>Planned</option>
					<option value="In Progress" <?php selected( $status, 'In Progress' ); ?>>In Progress</option>
					<option value="Active" <?php selected( $status, 'Active' ); ?>>Active</option>
					<option value="Completed" <?php selected( $status, 'Completed' ); ?>>Completed</option>
					<option value="On Hold" <?php selected( $status, 'On Hold' ); ?>>On Hold</option>
				</select>
			</div>

			<div style="margin-bottom: 15px;">
				<label for="programme_budget" style="display: block; margin-bottom: 5px;"><strong>Budget:</strong></label>
				<input type="text" id="programme_budget" name="programme_budget" value="<?php echo esc_attr( $budget ); ?>" placeholder="e.g., ₦2.5 Billion" style="width: 100%; padding: 8px;">
			</div>

			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
				<div>
					<label for="programme_start_date" style="display: block; margin-bottom: 5px;"><strong>Start Date:</strong></label>
					<input type="date" id="programme_start_date" name="programme_start_date" value="<?php echo esc_attr( $start_date ); ?>" style="width: 100%; padding: 8px;">
				</div>
				<div>
					<label for="programme_end_date" style="display: block; margin-bottom: 5px;"><strong>End Date:</strong></label>
					<input type="date" id="programme_end_date" name="programme_end_date" value="<?php echo esc_attr( $end_date ); ?>" style="width: 100%; padding: 8px;">
				</div>
			</div>

			<div style="margin-bottom: 15px;">
				<label for="programme_completion" style="display: block; margin-bottom: 5px;"><strong>Completion (%):</strong></label>
				<input type="number" id="programme_completion" name="programme_completion" value="<?php echo esc_attr( $completion ); ?>" min="0" max="100" placeholder="0-100" style="width: 100%; padding: 8px;">
			</div>
			<?php
		},
		'pmo_programme',
		'normal',
		'high'
	);
} );

// Save Meta Box Data
add_action( 'save_post_pmo_programme', function( $post_id ) {
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
} );

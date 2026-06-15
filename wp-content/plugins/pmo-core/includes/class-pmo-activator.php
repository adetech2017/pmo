<?php
/**
 * PMO Plugin Activator
 *
 * @package PMO_Core
 */

class PMO_Activator {

	/**
	 * Activate the plugin
	 */
	public static function activate() {
		// Create user roles
		require_once PMO_CORE_PATH . 'includes/class-pmo-user-roles.php';
		PMO_User_Roles::create_roles();

		// Flush rewrite rules
		flush_rewrite_rules();
	}
}

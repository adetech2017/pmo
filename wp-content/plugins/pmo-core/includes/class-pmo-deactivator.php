<?php
/**
 * PMO Plugin Deactivator
 *
 * @package PMO_Core
 */

class PMO_Deactivator {

	/**
	 * Deactivate the plugin
	 */
	public static function deactivate() {
		// Optional: Keep roles for data integrity, or remove them
		// require_once PMO_CORE_PATH . 'includes/class-pmo-user-roles.php';
		// PMO_User_Roles::remove_roles();

		// Flush rewrite rules
		flush_rewrite_rules();
	}
}

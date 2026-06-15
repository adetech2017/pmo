<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pmo_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pmo_auth_key_12345_change_in_production' );
define( 'SECURE_AUTH_KEY',  'pmo_secure_auth_key_12345_change_in_production' );
define( 'LOGGED_IN_KEY',    'pmo_logged_in_key_12345_change_in_production' );
define( 'NONCE_KEY',        'pmo_nonce_key_12345_change_in_production' );
define( 'AUTH_SALT',        'pmo_auth_salt_12345_change_in_production' );
define( 'SECURE_AUTH_SALT', 'pmo_secure_auth_salt_12345_change_in_production' );
define( 'LOGGED_IN_SALT',   'pmo_logged_in_salt_12345_change_in_production' );
define( 'NONCE_SALT',       'pmo_nonce_salt_12345_change_in_production' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SCRIPT_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */

// PMO Portal Custom Constants
define( 'PMO_THEME_NAME', 'pmo-portal-theme' );
define( 'PMO_PLUGIN_NAME', 'pmo-core' );

// Environment-specific URL Configuration
if ( strpos( $_SERVER['HTTP_HOST'], 'rescuepharm.ng' ) !== false ) {
    define( 'WP_HOME', 'http://rescuepharm.ng/pmo' );
    define( 'WP_SITEURL', 'http://rescuepharm.ng/pmo' );
} else {
    define( 'WP_HOME', 'http://localhost:8080/pmo' );
    define( 'WP_SITEURL', 'http://localhost:8080/pmo' );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

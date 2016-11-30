<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '6975094db17');

/** MySQL database username */
define('DB_USER', 'sql6975094');

/** MySQL database password */
define('DB_PASSWORD', '7amw6ie');

/** MySQL hostname */
define('DB_HOST', 'mysqlsvr45.world4you.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+0zC6gX 9mVXlZ8l.B?u-{.dKoEYla),H+AXG_T20uhw}`Z)v3![?%ZW=@t?@GlP');
define('SECURE_AUTH_KEY',  '@& Kl%3oC(/2*`tuVHb2Kl,!t@)0(e@1x~O1x,#woGJ72uEAW(~OGt@Mu%E5)&gJ');
define('LOGGED_IN_KEY',    'CK(a|AqFuIq*yA3Vkqv]Wf 0B{QSovyHfh,^?)wKoW{8J~F{,$m #|nw[A[_yHnt');
define('NONCE_KEY',        'w3kd.%m-2@^1hVwOMh:>j<@uY,!sQ/3jO;!<@pM-d.faul70ERVT81s$V*#6,S-N');
define('AUTH_SALT',        'JNi<(Rmj(be8::#%X-Sg2:6,X(Q~K}A#C)|cd&a;<n7xhx8pq9kBp>v?){<7%f0T');
define('SECURE_AUTH_SALT', 'u2^:Lhiq*QFH</.K=4`!H*@4X!-r#G%0X9jd`dwX~_UU8{-:y<.U2q-Bx@S7kk>j');
define('LOGGED_IN_SALT',   'mg/8Ln?JKDYH<zM:7{8xx-|3yuXT~6;3GDeFD)/G&B&GDdEE_=L6{RAwGbqWfTA0');
define('NONCE_SALT',       'Q/]XM24q^YJR6GVnk/tb{V3/9<6bSt)}|L|8TcxC<XA0/O&f_=;.bLju{QF|fV3H');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
 // Enable WP_DEBUG mode
define( 'WP_DEBUG', FALSE );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings 
define( 'WP_DEBUG_DISPLAY', FALSE );
//@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', FALSE );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

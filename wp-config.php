<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'T8Rbn8fOBwrJ4uuCUUJP=P8)jMO$TOCD/=m2yH&5/5cV:rJ.,o{a6E~/,-f~dh@K' );
define( 'SECURE_AUTH_KEY',   'kNwhqV^(zt]`X{<4Zj[Q$5xi[_f1P!1,g8NF;LaMes_Apa/lYnFBtNn.P8.W{h*t' );
define( 'LOGGED_IN_KEY',     '3PxqGq%I5B}?*E+q$H3mcg.uv70wcA(_:MduYOFFffx2 vxUm[sv(!Y2gG-y3AYR' );
define( 'NONCE_KEY',         'czY7&?Ph|i^q7#;6vx:L/%Xpg{df99t:99_cV:+Rs9t&>u_M+-jw@lJ%jFU4W]ed' );
define( 'AUTH_SALT',         'yZspKVH}*U.-Zpg M_b!4~S%=8IT<U_A1Z<+jwm{UA:}4KFCsapbUsM[ludf|Wy@' );
define( 'SECURE_AUTH_SALT',  '$/v|XtVQZRp|b/5(}#Tk(z:(i*J,_u&[>6q4i}-U-y:MGVbl4C%E9dXLk+:yauE#' );
define( 'LOGGED_IN_SALT',    'uYryD5.3j1@IBt6YB&fUVf>cL1E`1-wBO/[1Y9DS0{8<4joO*`*a`Yxq+`$^1c3M' );
define( 'NONCE_SALT',        'G$vbth9zwCU#k7xgmCHZrHeU]G!R-9nN[jA!)5!VOx+S$Z9<`dI6~A(f3()FmOj$' );
define( 'WP_CACHE_KEY_SALT', 'YQPfy}f+gJngOAG5<EsXFJx?/AiAon-8&UHc]#)LrHb GX.VAlj7R;}-M(fs]*vS' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

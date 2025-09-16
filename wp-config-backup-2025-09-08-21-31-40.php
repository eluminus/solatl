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
define( 'AUTH_KEY',          '&:O3T7u/_wxas#2&7Ju>#hw:I =-cTX8p{6eL%f:nf_mZTpQ QB ~f0u?]/goWoi' );
define( 'SECURE_AUTH_KEY',   'b-/VuO2@(,X@e+u#/-g/FH3rBslj4;bRtXshj9xwv.z&t1<~iAnE=M,1pOBNoW,E' );
define( 'LOGGED_IN_KEY',     'k ;hCggzxDq[Utf@p3`RWt5qp.ILZuFd9_k^0xpF%_llFp(=xh*xmLD#y@wL .+?' );
define( 'NONCE_KEY',         'Wd/f7HByjTFAzIic![2[Nkm13HO?3w^v!,@/qPQ6-JzUnzew?Xv1NaO{|2X;3^`)' );
define( 'AUTH_SALT',         'pz3VZd_n? 4Pk,3%gP`|g=]yo-zQA8|i-8q?0ie<Bu2+&:0QU.=e,a^DabaFN(Zi' );
define( 'SECURE_AUTH_SALT',  'BmpxG=#lA}`maJk%(vS$^^C^d^}s@?ljA.:hHhNxaD _ev~V]A,z2.Z2WWcmNuK2' );
define( 'LOGGED_IN_SALT',    '|YMCk&<c`gIggtY6fQ_u-QiJm aK[@&M>}kUCrn{6i=1sw8P5WL1cKBk .ii1e&W' );
define( 'NONCE_SALT',        'MDKwVXak S@MWn=hZG>WP1dW_QIwO7w?Z~[>i,8vRV8xWlLge|)Hk5>|/07V^3AY' );
define( 'WP_CACHE_KEY_SALT', 'CkdN,}r&4Krf!Yd^LKY*_/}vB6{bJ~{$O#B2`t2vz4=Ro<$#eo7Oz?`y$maPR>Hf' );


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
	define( 'WP_DEBUG', true );
}
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

define( 'WP_ENVIRONMENT_TYPE', 'local' );

// Increase upload limits
ini_set('upload_max_filesize', '2048M');
ini_set('post_max_size', '2048M');
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);
ini_set('max_input_time', 300);






}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

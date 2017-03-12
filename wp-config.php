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
define( 'DB_NAME', 'ezap' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         '~u_|[){Cjuy~6H 8#?yWt_rBz@NRN;yzj}}DLHh?5e`S3CE(bX=E`&-ae;GRX(v[');
define('SECURE_AUTH_KEY',  'CY!Nl;U`Y,=4x|,0$sH]w>Zpu?=+X{)j{8C_>_.mLdNb`GG@3WAWVD/0@N%(?4{e');
define('LOGGED_IN_KEY',    'tcfFb!Z/z-~A{{~$mYn^.c8n:!T#0Kx;sPHp#8y#<&E`Y|9*p*E:DDX>JsMC:m{s');
define('NONCE_KEY',        'u$/. P><s:@F`pOz|oB#6gYuG:E+q@%KDzS,GZ6G<0TL>gKK-t5Axe8[YI=6$c4F');
define('AUTH_SALT',        'pdZekSx0n,2v}ZY:qmI3eVdIUhF$T7VRcWdfithM.jogzv(t|4B,o;Wg1YKw[8T+');
define('SECURE_AUTH_SALT', '$= YyTkxCWL}E=yEcDbE2AVPC5N9k~KC@N^=D|pCN3@%>**6SdBYH{G)VZE;=kPq');
define('LOGGED_IN_SALT',   'dF+3:MJ25p.zu+RoWjZ]%<m#K. tib`(C;4/Gv%:YDg*>8gr=7Pa*4x-CUE*`}6M');
define('NONCE_SALT',       '4m^Xg$b0&jY3wA_f#L(v fM-Inq=v41S7r[p&O7hRU*7/Y+zEv/?{NUck;5EL10N');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

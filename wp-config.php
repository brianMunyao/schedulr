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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'schedulr');

/** Database username */
define('DB_USER', 'admin');

/** Database password */
define('DB_PASSWORD', 'admin');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         '?d9Zhy=brEY6|9`xaAH8<=3b<*sl/5H|h%>*1TvSTq{c#[A.b$LB zgO9jy~05]F');
define('SECURE_AUTH_KEY',  'Bwk]S4DQ17R=w=GMTkF/]#{}M?{np)%DoEcgb])i&S6+,t4lhQi7K7F;E(-RoKa8');
define('LOGGED_IN_KEY',    '9c&uYZb>pHm.f>R#q5;kN Y;vJL@L4p-xu5jP-$B!7!37QH9Da~uukE$pl;o,T8T');
define('NONCE_KEY',        'sC~0dOcFsui-.v,I;*`7PWz*w=~zj:[2[<@[UQz1Y~q60j{J+}.A(A[<@L+y!ZH`');
define('AUTH_SALT',        'JCR^V[c$g~j .[)BID!7tAazx8A2r2pj5F;H:X1,-7C+0?H|PSG3Wm69n>&=o4*Y');
define('SECURE_AUTH_SALT', 'F,i0wp4g>m85qvvoxVZ/hzr[O{#.EoRc__2>&.57+LHLY%KIAWE<c^USV(nd*dCt');
define('LOGGED_IN_SALT',   'a}~DWKuHNG+D[-&Ad!*U9V!906%8U9(m1^9!F51rbob(5HIb#&1Va>%gc<@![5XW');
define('NONCE_SALT',       't:3VEtvmvrePSwfj9F8Q|Hd2[Z4> o{Wks>poVDo;=HZoOXTjZTBY_Gmp00:OvDE');

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
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */
define('JWT_AUTH_SECRET_KEY', 'djkashkjfhkjhjnfhjhfjkvjhccnajhkdfhjk');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

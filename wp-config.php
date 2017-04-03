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
define('DB_NAME', 'couresacademy');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '|Xm,2noKIv6vBzr,H`ip=0)x1??r*M$<-_(wV?phG(vTM;W/7svfvH9n6bfRgJ$+');
define('SECURE_AUTH_KEY',  'qpqkgXdJ{gwE=<hJ2G]!Kna,fX2;4^WS7`2SCrR*}144e>K5%0@`zjL+@VW85u.j');
define('LOGGED_IN_KEY',    '3#DZKz>TvWUR4pt|I&#FQZ*DZg^yL_!F3kCJ%v*)WA3:r,d#aB4rEQ*@O2=z I9T');
define('NONCE_KEY',        'c-h}7G,OKFSYT^h~|Gt~:f<u]=XoE ]APB4W%|Z9F8Ci@^u,9u mg0]uLY`7J;`?');
define('AUTH_SALT',        '1Q:FB^i|a4:$Ipq3/Ra}3DSYNw,t6(atdGSMu;ZJu9J*0}_vGJu~t4T<kqCX<6?a');
define('SECURE_AUTH_SALT', 'zOt_XuA)hIZFscHTGpHM8hU#`rN1[v`+34^UA/|x_k+,w/MDQB24hn4=p M{;n,E');
define('LOGGED_IN_SALT',   'd]~MZ#X?9sZ1G4G/oI=SBW!fW5XV<FOV<;4~&=}9Gx*):e|:zvS`bnO$qJH_~)z=');
define('NONCE_SALT',       'fs}rrKU)OnP#{g)sH(ziAQG#g#7EB5e]mi`f!)f>r9#:iJ>@k*`YKyls=Dtpr%LZ');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

<?php



/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'webguruzdb');

/** MySQL database username */
define('DB_USER', 'webguruzuser');

/** MySQL database password */
define('DB_PASSWORD', 'AO(Xu;bOe_PK');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '93Mm+wX`8|IIQ%ZF b&2m^0tX]}~=ka)6!o}Ap*#~R!b(Q?,2R;(t:cV(02:7!Ll');
define('SECURE_AUTH_KEY',  '+>SK#:.ckOR?>UU9r2<mYsXEM9.wkrbN@wCnoA|fZc4WI,%iWiKxmy(s[jjeO;{3');
define('LOGGED_IN_KEY',    'tnEEAP{J?gs4=4vR:IU1vA&zlZU:y>~sQohNS4~)QLzAw}@j:eKh5f&3{8v0voGE');
define('NONCE_KEY',        'v.xZ?n(0[&XY,ME(o3EF~/tF:D>1=6~M)cPmLBvyx9YYzhR9DON1ZFZF8i@KP({l');
define('AUTH_SALT',        'Vze>*Ern,JR*(W&b0r0K1p_8lCoCUCx2j(f,I.2#6}mp,:nH ;$L9LsH6WkxJoAZ');
define('SECURE_AUTH_SALT', 'LmXTxelIcZh-H=5-]IYB/Vx;77u(rP&jsOMq)Cap%:ur6A2Cm9h7JBR=3(Tp=nm-');
define('LOGGED_IN_SALT',   '1-~TvMc(;c/^`LHQPWsx_| u0<Y0<6b11C=f<(N3 *D|_mMn<34;#Xp4Ji%E{}ai');
define('NONCE_SALT',       '*N8$L^f##:5)&W+5(t9%30=ZkmhnG1:{d0 4$rsC6sJyt]36R/-n`~PYj-*P)4-q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wgttgw';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define( 'WPCF7_VALIDATE_CONFIGURATION', false );
define( 'WP_AUTO_UPDATE_CORE', false );
define('wp_memory_limit', '1124M');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

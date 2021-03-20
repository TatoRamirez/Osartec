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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'osartec_bd18012021' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Rhddw^hnK5`5FPQO[fEfT.75s1z~~;fl-#-1M_mKdIRhVKra{p^C0JQ/und:} Sf' );
define( 'SECURE_AUTH_KEY',  '0. {;Yk1GqJvsBEGyNYmN.MR:?$/PKFPumfkdLutE<Kh>/-sK72e`@Mrr.Yf$Zc~' );
define( 'LOGGED_IN_KEY',    '8]V/mjDw82{D#7!.ux[,@WOU0e|O#}x<%@Op[}c$7ofxtc:b^sCB%!:sQy09(iWj' );
define( 'NONCE_KEY',        '%6r@ni6( nyztn7Oju<:|jWb}*j6@2rG^4knETG]] RVC-t9OwP16o1S|_u`8S8N' );
define( 'AUTH_SALT',        '=@(%#l#.nl.8N5@;$nVRsa7B_efe)J,RVR[3X5iQ=Kx=)P]RL%_z-YG=.TV%-FQG' );
define( 'SECURE_AUTH_SALT', '*3mo+Iy=`nd=N$`mte7)g$szQspl_Pl/P*,uYA.Lo%LVRdw-sYf=Rh.35>GAx6z<' );
define( 'LOGGED_IN_SALT',   'cSB c8e$Qw$dv,?;TlQjg)u!.o-?0nO%i[Y@rIYK)Ka4}U]N]?y*ZB)7!bZ3:bEc' );
define( 'NONCE_SALT',       'W-BfVCac0_#u&HqRI?`SJEm|~3EDfr0f6GBH#.R*~ASm 6huwh}7H3jgolJcd8fM' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'osartec_';

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
define( 'WP_DEBUG', false);
/*define( 'WP_DEBUG_LOG', false);*/

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

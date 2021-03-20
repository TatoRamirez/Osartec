<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 * ************************************************************ */


if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	global $wpdb;
	$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '\_sitetree\_%'" );

    delete_option( 'sitetree' );
	delete_transient( 'sitetree_sitemap' );
    delete_transient( 'sitetree_site_tree' );
}
?>
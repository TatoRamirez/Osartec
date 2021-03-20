<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 * ************************************************************ */

if (! defined( 'ABSPATH' ) ) {
    exit;
}

// Collection of messages used more than once.
$common_l10n = array(
	'exclude' => __( 'Comma-separated list of IDs.', 'sitetree' )
);

// --- Common values.

$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

unset( $taxonomies['post_format'] );

/* ************************************************************ */

$sections[] = $advanced_section = new SiteTreeSection();

if (! $this->plugin->isServerLocal() ) {
    $advanced_section->addField(
        new SiteTreeField( 'automatic_pinging_on', 'SiteTreeCheckbox', 'bool', __( 'Automatic pinging', 'sitetree' ),
                           __( 'Automatically ping Google, Bing and Yahoo! when the permalink of a new post or page is added to the Sitemap.', 'sitetree' ) )
    );
}

$advanced_section->addField(
    new SiteTreeFieldset( __( 'Add to the robots.txt file', 'sitetree' ), '', false, array(
        new SiteTreeField( 'generate_disallow_rules', 'SiteTreeCheckbox', 'bool', '',
                           sprintf( __( 'A %s rule for each permalink excluded from the Sitemap.', 'sitetree' ), 
                                    '<code>Disallow</code>' ) ),
        new SiteTreeField( 'add_sitemap_url_to_robots', 'SiteTreeCheckbox', 'bool', '',
                           __( 'The permalink of the Sitemap.', 'sitetree' ) )
    ))
);

foreach ( $taxonomies as $taxonomy ) {
	if ( $this->db->getOption( $taxonomy->name, false, 'sitemap_content_types' ) ) {
	    $sections[] = new SiteTreeSection( '', $taxonomy->name, array(
	        new SiteTreeField( 'exclude', 'SiteTreeTextField', 'list_of_ids', 
	        	               sprintf( __( 'Exclude %s', 'sitetree' ), strtolower( $taxonomy->label ) ) , 
	        	               $common_l10n['exclude'], '' )
	    ));
	}
}
?>
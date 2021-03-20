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
// The elements of type Array contain the title of the field at index 0 and its description/tooltip at index 1.
$common_l10n = array(
	'title'		 => __( 'List title', 'sitetree' ),
    'position'   => __( 'List position', 'sitetree' ),
	'show_count' => __( 'Posts count', 'sitetree' ),
	'exclude'	 => array( __( 'Exclude', 'sitetree' ), __( 'Comma-separated list of IDs.', 'sitetree' ) ),
	'order_by'	 => __( 'Order by', 'sitetree' ),
    'limit'      => array( __( 'Max. number of items', 'sitetree' ), __( 'Set to -1 to list all the items.', 'sitetree' ) )
);

// --- Common values.

$list_style_options = array(
	'1' => __( 'Hierarchical', 'sitetree' ),
	'0' => __( 'Flat', 'sitetree' )
);

$orderby_options = array(
	'name'	=> __( 'Name', 'sitetree' ),
	'count' => __( 'Most used', 'sitetree' )
);

$post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
$taxonomies = get_taxonomies( array( 'public' => true, '_builtin' => false ), 'objects' );

// The list of authors' pages is at position 1.
$position         = 2;
$position_options = array();
$num_of_lists     = 5 + count( $post_types ) + count( $taxonomies );

for ( $i = 1; $i <= $num_of_lists; $i++ ) {
    $position_options[$i] = $i;
}

/* ************************************************************ */

if ( $this->db->getOption( 'page', true, 'site_tree_content_types' ) ) {
	$sections[] = new SiteTreeSection( __( 'Pages', 'sitetree' ), 'page', array(
	    new SiteTreeField( 'position', 'SiteTreeDropdown', 'choice', $common_l10n['position'], '', $position++, $position_options ),
	    new SiteTreeField( 'title', 'SiteTreeTextField', 'inline_html', $common_l10n['title'], '', __( 'Pages', 'sitetree' ) ),
	    new SiteTreeField( 'show_home', 'SiteTreeCheckbox', 'bool', __( 'Home page', 'sitetree' ), 
	        __( 'Show a &lsquo;Home&rsquo; link on top of the list.', 'sitetree' )
	    ),
	    new SiteTreeField( 'exclude_childs', 'SiteTreeCheckbox', 'bool', __( 'Only primary pages', 'sitetree' ), 
	        __( 'Exclude all the child pages.', 'sitetree' )
	    ),
	    new SiteTreeField( 'hierarchical', 'SiteTreeDropdown', 'choice', __( 'List style', 'sitetree' ), '', '1', $list_style_options )
	));
}

if ( $this->db->getOption( 'post', true, 'site_tree_content_types' ) ) {
	$sections[] = new SiteTreeSection( __( 'Posts', 'sitetree' ), 'post', array(
	    new SiteTreeField( 'position', 'SiteTreeDropdown', 'choice', $common_l10n['position'], '', $position++, $position_options ),
	    new SiteTreeField( 'title', 'SiteTreeTextField', 'inline_html', $common_l10n['title'], '', __( 'Posts', 'sitetree' ) ),
	    new SiteTreeField( 'group_by', 'SiteTreeDropdown', 'choice', __( 'Group by', 'sitetree' ), '', 'none', array(
	        'none'      => '-', 
	        'date'      => __( 'Date', 'sitetree' ),
	        'category'  => __( 'Category', 'sitetree' ),
	        'author'    => __( 'Author', 'sitetree' )
	    )),
	    new SiteTreeField( 'order_by', 'SiteTreeDropdown', 'choice', $common_l10n['order_by'], '', 'post_date', array(
	        'post_date'     => __( 'Most recent', 'sitetree' ),
	        'comment_count' => __( 'Most popular', 'sitetree' ),
	        'post_title'    => __( 'Title', 'sitetree' ),
	        'post_date_asc' => __( 'Older', 'sitetree' )
	    )),
	    new SiteTreeField( 'pop_stickies', 'SiteTreeCheckbox', 'bool', __( 'Sticky posts', 'sitetree' ), 
	        __( 'Stick featured posts to the top of the list.', 'sitetree' )
	    ),
	    new SiteTreeFieldset( __( 'Show excerpt', 'sitetree' ), '', true, array(
	    	new SiteTreeField( 'show_excerpt', 'SiteTreeCheckbox', 'bool', '', 
	    		__( 'Show for each post a short excerpt of', 'sitetree' )
	    	),
	    	new SiteTreeField( 'excerpt_length', 'SiteTreeNumberField', 'positive_number', '', 
	    		__( 'characters.', 'sitetree' ), 100, array( 'min_value' => 50, 'max_value' => 300 )
	    	),
	    )),
	    new SiteTreeField( 'show_comments_count', 'SiteTreeCheckbox', 'bool', __( 'Comments count', 'sitetree' ), 
	        __( 'Show for each post the number of comments received.', 'sitetree' )
	    ),
	    new SiteTreeField( 'show_date', 'SiteTreeCheckbox', 'bool', __( 'Publication date', 'sitetree' ), 
	        __('Show for each post the date of publication.', 'sitetree' )
	    ),
	    new SiteTreeField( 'limit', 'SiteTreeNumberField', 'positive_number', $common_l10n['limit'][0], 
                           $common_l10n['limit'][1], -1, array( 'min_value' => -1, 'max_value' => 500 )
        )      
	));
}

foreach ( $post_types as $post_type ) {
	if ( $this->db->getOption( $post_type->name, false, 'site_tree_content_types' ) ) {
	    $fields = array(
	        new SiteTreeField( 'position', 'SiteTreeDropdown', 'choice', $common_l10n['position'], '', $position++, $position_options ),
	        new SiteTreeField( 'title', 'SiteTreeTextField', 'inline_html', $common_l10n['title'], '', $post_type->label ),
	        new SiteTreeField( 'order_by', 'SiteTreeDropdown', 'choice', $common_l10n['order_by'], '', 'post_title', array(
	            'post_title'    => __( 'Title', 'sitetree' ),
	            'post_date'     => __( 'Most recent', 'sitetree' ),
	            'post_date_asc' => __( 'Older', 'sitetree' )
	        ))      
	    );

	    if ( $post_type->hierarchical ) {
	        $fields[] = new SiteTreeField( 'hierarchical', 'SiteTreeDropdown', 'choice', 
                                           __( 'List style', 'sitetree' ), '', '1', $list_style_options );
	    }

	    $fields[] = new SiteTreeField( 'limit', 'SiteTreeNumberField', 'positive_number', $common_l10n['limit'][0], 
                                       $common_l10n['limit'][1], -1, array( 'min_value' => -1, 'max_value' => 500 )
        );

	    $sections[] = new SiteTreeSection( $post_type->label, $post_type->name, $fields );
	}
}

if ( $this->db->getOption( 'category', false, 'site_tree_content_types' ) ) {
	$sections[] = new SiteTreeSection( __( 'Categories', 'sitetree' ), 'category', array(
	    new SiteTreeField( 'position', 'SiteTreeDropdown', 'choice', $common_l10n['position'], '', $position++, $position_options ),
	    new SiteTreeField( 'title', 'SiteTreeTextField', 'inline_html', $common_l10n['title'], '', __( 'Categories', 'sitetree' ) ),
	    new SiteTreeField( 'exclude', 'SiteTreeTextField', 'list_of_ids', $common_l10n['exclude'][0], $common_l10n['exclude'][1], '' ),
	    new SiteTreeField( 'show_count', 'SiteTreeCheckbox', 'bool', $common_l10n['show_count'], 
	        __( 'Show for each category the number of published posts.', 'sitetree' ), true
	    ),
	    new SiteTreeField( 'feed_text', 'SiteTreeTextField', 'plain_text', __("Text of the link to each category's RSS feed", 'sitetree' ), 
	        __( 'Leave empty to hide the link.', 'sitetree' ), '', 'small-text'
	    ),
	    new SiteTreeField( 'hierarchical', 'SiteTreeDropdown', 'choice', __( 'List style', 'sitetree' ), '', '1', $list_style_options ),
	    new SiteTreeField( 'order_by', 'SiteTreeDropdown', 'choice', $common_l10n['order_by'], '', 'name', $orderby_options ),
	));
}

if ( $this->db->getOption( 'post_tag', false, 'site_tree_content_types' ) ) {
	$sections[] = new SiteTreeSection( __( 'Tags', 'sitetree' ), 'post_tag', array(
	    new SiteTreeField( 'position', 'SiteTreeDropdown', 'choice', $common_l10n['position'], '', $position++, $position_options ),
	    new SiteTreeField( 'title', 'SiteTreeTextField', 'inline_html', $common_l10n['title'], '', __( 'Tags', 'sitetree' ) ),
	    new SiteTreeField( 'exclude', 'SiteTreeTextField', 'list_of_ids', $common_l10n['exclude'][0], $common_l10n['exclude'][1], '' ),
	    new SiteTreeField( 'show_count', 'SiteTreeCheckbox', 'bool', $common_l10n['show_count'],
	        __( 'Show the number of posts published under each tag.', 'sitetree' )
	    ),
	    new SiteTreeField( 'order_by', 'SiteTreeDropdown', 'choice', $common_l10n['order_by'], '', 'name', $orderby_options ),
	));
}

foreach ( $taxonomies as $taxonomy ) {
	if ( $this->db->getOption( $taxonomy->name, false, 'site_tree_content_types' ) ) {
	    $fields = array(
	        new SiteTreeField( 'position', 'SiteTreeDropdown', 'choice', $common_l10n['position'], '', $position++, $position_options ),
	        new SiteTreeField( 'title', 'SiteTreeTextField', 'inline_html', $common_l10n['title'], '', $taxonomy->label ),
	        new SiteTreeField( 'exclude', 'SiteTreeTextField', 'list_of_ids', $common_l10n['exclude'][0], $common_l10n['exclude'][1], '' ),
	        new SiteTreeField( 'order_by', 'SiteTreeDropdown', 'choice', $common_l10n['order_by'], '', 'name', $orderby_options ),
	    );

	    if ( $taxonomy->hierarchical ) {
	        $fields[] = new SiteTreeField( 'hierarchical', 'SiteTreeDropdown', 'choice', __( 'List style', 'sitetree' ), '', '1', 
	            $list_style_options );
	    }

	    $sections[] = new SiteTreeSection( $taxonomy->label, $taxonomy->name, $fields );
	}
}

if ( $this->db->getOption( 'authors', false, 'site_tree_content_types' ) ) {
	$sections[] = new SiteTreeSection( __( "Authors' Pages", 'sitetree' ), 'authors', array(
	    new SiteTreeField( 'position', 'SiteTreeDropdown', 'choice', $common_l10n['position'], '', 1, $position_options ),
	    new SiteTreeField( 'title', 'SiteTreeTextField', 'inline_html', $common_l10n['title'], '', __( 'Authors', 'sitetree' ) ),
	    new SiteTreeField( 'show_count', 'SiteTreeCheckbox', 'bool', $common_l10n['show_count'],
	        __( 'Show the number of posts published by each author.', 'sitetree' ), true
	    ),
	    new SiteTreeField( 'show_avatar', 'SiteTreeCheckbox', 'bool', __( 'Avatar', 'sitetree' ), __("Show the author's avatar.", 'sitetree' ) ),
	    new SiteTreeField( 'avatar_size', 'SiteTreeNumberField', 'positive_number', __( 'Avatar size', 'sitetree' ), 
	        __( 'Choose a value between 20px and 512px.', 'sitetree' ), 60, array( 'min_value' => 20, 'max_value' => 512 )
	    ),
	    new SiteTreeField( 'show_bio', 'SiteTreeCheckbox', 'bool', __( 'Biographical info', 'sitetree' ), 
	        sprintf( __('Show the biographical information set in the author&apos;s %1$sprofile page%2$s.', 'sitetree' ), 
	                 '<a href="' . admin_url( 'users.php' ) . '">', '</a>' )
	    ),
	    new SiteTreeField( 'exclude', 'SiteTreeTextField', 'list_of_nicknames', $common_l10n['exclude'][0], 
	        __( 'Comma-separated list of nicknames.', 'sitetree' ), ''
	    ),
	    new SiteTreeField( 'order_by', 'SiteTreeDropdown', 'choice', $common_l10n['order_by'], '', 'display_name', array(
	        'display_name'  => __( 'Name', 'sitetree' ),
	        'posts_count'   => __( 'Published posts', 'sitetree' )
	    )),
	));
}
?>
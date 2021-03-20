<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 2.0
 */
final class SiteTreeBuilder
    extends SiteTreeBuilderCore
 implements SiteTreeBuilderInterface {
    /**
     * @since 4.0
     */
    const SITEMAP_ID = 'site_tree';

    /**
     * @since 2.0
     * @var array
     */
    private $options;

    /**
     * @since 2.0
     * @var array
     */
    private $listOptions;

    /**
     * @since 2.0
     * @var string
     */
    private $listID = '';

    /**
     * @since 2.0
     * @var array
     */
    private $queriedAuthors;

    /**
     * @since 2.0
     * @var array
     */
    private $queriedPosts;

    /**
     * @since 2.0
     * @var array
     */
    private $methodsDictionary = array(
        'post'       => 'buildPostsList',
        'page'       => 'buildPagesList',
        'category'   => 'buildCustomTaxonomiesList',
        'post_tag'   => 'buildTagsList',
        'authors'    => 'buildAuthorsList'
    );

    /**
     * @see parent::__construct()
     * @since 2.0
     */
    public function __construct( $plugin ) {
        parent::__construct( $plugin );

        $this->options = (array) $this->db->getOption( self::SITEMAP_ID );
    }

    /**
     * {@inheritdoc}
     */
    public function listID() {
    	return $this->listID;
    }

    /**
     * {@inheritdoc}
     */
    public function addContent( $string ) {
    	$this->output .= $string;
    }

    /**
     * @see parent::runBuildingProcess()
     * @since 2.0
     */
    protected function runBuildingProcess() {
        $post_types        = get_post_types( array( 'public' => true, '_builtin' => false ) );
        $taxonomies        = get_taxonomies( array( 'public' => true, '_builtin' => false ) );
        $content_types_key = self::SITEMAP_ID . '_content_types';

        /**
	     * @since 2.1
	     */
        do_action( 'sitetree_will_build_lists', $this );

        foreach ( $post_types as $post_type ) {
            $this->methodsDictionary[$post_type] = 'buildCustomPostsList';
        }

        foreach ( $taxonomies as $taxonomy ) {
            $this->methodsDictionary[$taxonomy] = 'buildCustomTaxonomiesList';
        }

        foreach ( $this->options as $this->listID => &$this->listOptions ) {
        	if (! $this->db->getOption( $this->listID, false, $content_types_key ) ) {
                continue;
            }

            if (! isset( $this->methodsDictionary[$this->listID] ) ) {
                continue;
            }

            $title       = $this->getListOption( 'title' );
            $method_name = $this->methodsDictionary[$this->listID];

            $this->output .= '<div class="site-tree-list-container">' . "\n";

            if ( $title ) {
                $this->output .= '<h3 id="site-tree-' . $this->listID 
                			   . '-list-title" class="site-tree-list-title">' . $title . "</h3>\n";
            }

            /**
		     * @since 2.1
		     */
            do_action( 'sitetree_will_build_single_list', $this );

            $this->output .= '<ul id="site-tree-' . $this->listID . '-list" class="site-tree-list">' . "\n";
            
            $this->{$method_name}();
            
            $this->output .= "</ul>\n";

            /**
		     * @since 2.1
		     */
            do_action( 'sitetree_did_build_single_list', $this );

            $this->output .= "</div>\n";
        }

        /**
	     * @since 2.1
	     */
        do_action( 'sitetree_did_build_lists', $this );
    }

    /**
     * @since 2.0
     * @return mixed
     */
    private function getListOption( $key, $default = false ) {
        if ( isset( $this->listOptions[$key] ) ) {
            return $this->listOptions[$key];
        }

        return $default;
    }

    /**
     * @since 2.0
     */
    private function buildPagesList() {
        if ( $this->getListOption( 'show_home' ) && !get_option( 'page_on_front' ) ) {
            $this->incrementItemsCounter();

            $this->output .= '<li><a href="' . home_url( '/' )
            			   . '">' . __( 'Home', 'sitetree-pro' ) . '</a></li>';
        }
        
        $fields     = 'p.ID, p.post_title, p.post_name';
        $where      = "p.post_type = 'page' AND p.post_status = 'publish' AND
                       p.post_password = '' AND pm.post_id IS NULL";
       
        $list_depth = -1;
        $meta_keys  = $this->db->prepareMetaKey( 'exclude_from_site_tree' );
        $meta_keys .= ',';
        $meta_keys .= $this->db->prepareMetaKey( 'is_ghost_page' );

        if ( $this->getListOption( 'exclude_childs' ) ) {
            $where .= " AND p.post_parent = 0";
        }
        else {
            $fields .= ', p.post_parent, p.post_type';

            if ( $this->getListOption( 'hierarchical', true ) ) {
                $list_depth = 0;
            }
        }

        // We retrieve only the data needed by the builder, because those needed by wordpress to generate
        // the permalinks or by other plugins to do their businesses are already in the cache.
        $pages = $this->wpdb->get_results(
            "SELECT {$fields}
             FROM {$this->wpdb->posts} AS p
             LEFT OUTER JOIN {$this->wpdb->postmeta} AS pm
                ON p.ID = pm.post_id AND pm.meta_key IN ({$meta_keys})
             WHERE {$where}
             ORDER BY p.menu_order, p.post_title ASC"
        );

        if ( $pages ) {
            $walker        = new SiteTreeCustomPostWalker( $this );
            $this->output .= $walker->walk( $pages, $list_depth );
        }
    }

    /**
     * @since 3.0
     */
    private function buildCustomPostsList() {
        $list_depth    = -1;
        $fields        = 'p.ID, p.post_title, p.post_name';
        $limit         = '';
        $orderby       = $this->getListOption( 'order_by', 'post_title' );
        $max_num_items = (int) $this->getListOption( 'limit', 100 );
        $meta_key      = $this->db->metaKeyPrefix() . 'exclude_from_site_tree';
        
        if ( $max_num_items > 0 ) {
            $limit = 'LIMIT ' . $max_num_items;
        }
        
        if ( (bool) $this->getListOption( 'hierarchical', false ) ) {
            $list_depth = 0;
            $fields    .= ', p.post_parent';
        }

        switch ( $orderby ) {
            case 'post_date':
                $orderby = 'p.post_date DESC';
                break;
            case 'post_date_asc':
                $orderby = 'p.post_date ASC';
                break;
            default:
                $orderby = 'p.post_title ASC';
                break;
        }

        // We retrieve only the data needed by the factory, because those needed by wordpress to generate
        // the permalinks or by other plugins to do their businesses are already in the cache.
        // Consider further reduce the data retrieved from the database using the data in the cache.
        $posts = $this->wpdb->get_results(
            "SELECT {$fields}
             FROM {$this->wpdb->posts} AS p
             LEFT OUTER JOIN {$this->wpdb->postmeta} AS pm
                ON p.ID = pm.post_id AND pm.meta_key = '{$meta_key}'
             WHERE p.post_type = '{$this->listID}' AND p.post_status = 'publish' AND 
                   p.post_password = '' AND pm.post_id IS NULL
             ORDER BY {$orderby}
             {$limit}"
        );

        if ( $posts ) {
            $walker         = new SiteTreeCustomPostWalker( $this );
            $this->output .= $walker->walk( $posts, $list_depth );
        }
    }

    /**
     * @since 3.0
     */
    private function buildCustomTaxonomiesList() {
    	$arguments = array(
            'depth'         => -1,
            'exclude'       => $this->getListOption( 'exclude', '' ),
            'feed'          => '',
            'hide_empty'    => true,
            'hierarchical'  => (bool) $this->getListOption( 'hierarchical', true ),
            'orderby'       => $this->getListOption( 'order_by', 'name' ),
            'show_count'    => false
		);

		if ( $arguments['orderby'] == 'count' ) {
            $arguments['order'] = 'DESC';
        }
        
        if ( $arguments['hierarchical'] ) {
            $arguments['depth']        = 0;
            $arguments['exclude_tree'] = $arguments['exclude'];
            $arguments['exclude']      = '';
        }

        if ( $this->listID == 'category' ) {
            $arguments['feed']       = $this->getListOption( 'feed_text', 'RSS' );
            $arguments['show_count'] = (bool) $this->getListOption( 'posts_count', true );
        }
        
        $taxonomies = get_terms( $this->listID, $arguments );

        if ( $taxonomies ) {
            $walker         = new SiteTreeTaxonomyWalker( $this );
            $this->output .= $walker->walk( $taxonomies, $arguments['depth'], $arguments );
        }
    }
    
    /**
     * @since 2.0
     */
    private function buildTagsList() {
        $arguments = array(
            'exclude' => $this->getListOption( 'exclude', array() )
        );
        
        if ( $this->getListOption( 'order_by', 'name' ) != 'name' ) {
            $arguments['order']   = 'DESC';
            $arguments['orderby'] = $this->getListOption( 'order_by' );
        }

        $tags       = get_terms( 'post_tag', $arguments );
        $show_count = $this->getListOption( 'show_count' );
        
        if (! $tags )
            return null;

        foreach ( $tags as $tag ) {
            $this->incrementItemsCounter();

            $stripped_tag_name = esc_attr( strip_tags( $tag->name ) );
            $link_title_format = __( 'View all posts tagged %s', 'sitetree' );

            $this->output .= '<li><a href="' . get_term_link( $tag ) . '" title="';
            $this->output .= sprintf( $link_title_format, $stripped_tag_name );
            $this->output .= '">' . esc_attr( $tag->name ) . '</a>';
            
            if ( $show_count && $tag->count > 1 ) {
                $this->output .= ' <span class="site-tree-posts-count">(';
                $this->output .= (int) $tag->count;
                $this->output .= ')</span>';
            }
            
            $this->output .= "</li>\n";
        }
    }
    
    /**
     * @since 2.0
     */
    private function buildAuthorsList() {
        $this->queryAuthors();

        if (! $this->queriedAuthors ) {
            return false;
        }

        $show_bio         = $this->getListOption( 'show_bio' );
        $show_count       = $this->getListOption( 'show_count' );
        $show_avatar      = $this->getListOption( 'show_avatar' );
        $avatar_size      = (int) $this->getListOption( 'avatar_size', 60 );

        foreach ( $this->queriedAuthors as $author ) {
            $this->incrementItemsCounter();

            $link_title_text      = __( 'View all posts by %s', 'sitetree-pro' );
            $stripped_author_name = esc_attr( strip_tags( $author->display_name ) );
            
            $item  = '<a href="';
            $item .= get_author_posts_url( $author->ID, $author->user_nicename );
            $item .= '" class="p-name" title="';
            $item .= sprintf( $link_title_text, $stripped_author_name );
            $item .= '">' . esc_attr( $author->display_name ) . '</a>';
            
            if ( $show_count ) {
                $item .= ' <span class="site-tree-posts-count">(';
                $item .= (int) $author->posts_count;
                $item .= ')</span>';
            }
            
            if ( $show_bio && $author->bio_info ) {
               $item .= '<p class="p-note">' . $author->bio_info . '</p>';
            }
            
            if ( $show_avatar ) {
                $avatar = get_avatar( 
                    $author->user_email, 
                    $avatar_size, 
                    '',
                    $author->display_name,
                    array( 'class' => 'u-photo' )
                );
                $item = $avatar . $item;
            }

            $this->output .= '<li class="h-card">' . $item . "</li>\n";
        }

        unset( $this->queriedAuthors );
    }

    /**
     * @since 2.0
     */
    private function queryAuthors() {
        $fields = 'u.ID, COUNT(u.ID) AS posts_count, u.user_nicename, u.display_name';
        $join   = "INNER JOIN {$this->wpdb->posts} AS p ON p.post_author = u.ID";
        $where  = "p.post_type = 'post' AND p.post_status = 'publish'";
        
        $excluded_authors = $this->getListOption( 'exclude' );

        if ( $excluded_authors ) {
            $excluded_authors_list = '';
            $excluded_authors      = explode( ',', $excluded_authors );

            foreach ( $excluded_authors as $author_nickname ) {
                $excluded_authors_list .= "'" . sanitize_text_field( $author_nickname ) . "',";
            }

            // Removes the trailing comma from the string.
            $excluded_authors_list = substr( $excluded_authors_list, 0, -1);
            $where                 = "u.user_nicename NOT IN ({$excluded_authors_list}) AND {$where}";
        }

        if ( $this->getListOption( 'show_avatar' ) )
            $fields .= ', u.user_email';
            
        if ( $this->getListOption( 'show_bio' ) ) {
            $fields .= ', um.meta_value AS bio_info';
            $where  .= " AND um.meta_key = 'description'";
            $join   .= " LEFT JOIN {$this->wpdb->usermeta} AS um ON um.user_id = u.ID";
        }
        
        if ( $this->getListOption( 'order_by' ) == 'posts_count' )
            $orderby = 'posts_count DESC';
        else
            $orderby = 'u.display_name ASC';
        
        $this->queriedAuthors = $this->wpdb->get_results(
            "SELECT {$fields}
             FROM {$this->wpdb->users} AS u {$join}
             WHERE {$where}
             GROUP BY u.ID
             ORDER BY {$orderby}"
        );
    }
    
    /**
     * @since 2.0
     * @return bool
     */
    private function buildPostsList() {
        $this->queryPosts();
        
        if (! $this->queriedPosts ) {
            return false;
        }

        if ( $this->getListOption( 'pop_stickies' ) ) {
            $this->popStickyPosts();
        }

        $current_value = $date = $day = '';
        
        $hierarchical        = true;
        $property            = 'ID';
        $date_format         = get_option( 'date_format' );
        $groupby             = $this->getListOption( 'group_by' );
        $show_date           = $this->getListOption( 'show_date' );
        $show_excerpt        = $this->getListOption( 'show_excerpt' );
        $excerpt_length      = ( $show_excerpt ? $this->getListOption( 'excerpt_length', 100 ) : 0 );
        $show_comments_count = $this->getListOption( 'show_comments_count' );

        switch ( $groupby ) {
            case 'date':
                $property = 'post_month';
                break;
            case 'category':
                $property = 'term_id';
                break;
            case 'author':
                $property = 'post_author';
                break;
            default:
                $hierarchical = false;
                break;
        }

        foreach ( $this->queriedPosts as $post ) {
            if ( $hierarchical && ( $post->{$property} != $current_value ) ) {
                $current_value = $post->{$property};
                $method_name   = 'orderby_' . $groupby;

                $this->output .= "</ul>\n<h4>";
                $this->output .= $this->{$method_name}( $post );
                $this->output .= "</a></h4>\n<ul class=\"site-tree-list\">\n";
            }
            
            if ( $show_date ) {
                if ( $groupby == 'date' ) {
                    $day  = '<time datetime="';
                    $day .= mysql2date( 'Y-m-d', $post->post_date ) . '">';
                    $day .= mysql2date( 'd:', $post->post_date ) . '</time> ';
                }
                else {
                    $date  = ' <time datetime="';
                    $date .= mysql2date( 'Y-m-d', $post->post_date ) . '">';
                    $date .= mysql2date( $date_format, $post->post_date ) . '</time>';
                }
            }
            
            $this->output .= '<li>' . $day . '<a href="';
            $this->output .= get_permalink( $post ) . '">';
            $this->output .= apply_filters( 'the_title', $post->post_title, $post->ID );
            $this->output .= '</a>';
                    
            if ( $show_comments_count && $post->comment_count > 0 ) {
                $this->output .= ' <span class="site-tree-comments-number">(';
                $this->output .= (int) $post->comment_count;
                $this->output .= ')</span>';
            }
                
            $this->output .= $date;

            if ( $show_excerpt ) {
            	$excerpt = ( $post->post_excerpt ? $post->post_excerpt : $post->post_extract );
            	$excerpt = strip_tags( $excerpt );

            	if ( $excerpt ){
            		$this->output .= '<p>';
	            	$this->output .= sitetree_fn\truncate_sentence( $excerpt, $excerpt_length );
	            	$this->output .= '</p>';
            	}
            }

            $this->output .= "</li>\n";
            
            $this->incrementItemsCounter();
        }

        unset( $this->queriedPosts );

        return true;
    }

    /**
     * @since 2.0
     */
    private function queryPosts() {
        $joins   = $where = $groupby = '';
        $orderby = $this->getListOption( 'order_by', 'post_date' );

        switch ( $orderby ) {
            case 'post_title':
                $orderby = 'p.post_title ASC';
                break;
            case 'post_date_asc':
                $orderby = 'p.post_date ASC';
                break;
            default:
                $orderby = 'p.post_date DESC';
                break;
        }
        
        $limit         = '';    
        $fields        = 'p.ID, p.post_date, p.post_title, p.post_status, p.post_name, p.post_type';
        $max_num_items = (int) $this->getListOption( 'limit', 100 );
        $meta_key      = $this->db->metaKeyPrefix() . 'exclude_from_site_tree';

        if ( $max_num_items > 0 ) {
            $limit = 'LIMIT ' . $max_num_items;
        }
        
        if ( $this->getListOption( 'show_excerpt' ) ) {
        	$extract_length = 3 * $this->getListOption( 'excerpt_length', 100 );
			$fields        .= ", p.post_excerpt, LEFT( p.post_content, {$extract_length} ) AS post_extract";
        }
           
        if ( $this->getListOption( 'show_comments_count' ) ) {
            $fields .= ', p.comment_count';
        }
        
        switch ( $this->getListOption( 'group_by' ) ) {
            case 'date':
                $fields  .= ', MONTH(p.post_date) AS post_month';
                $orderby  = 'p.post_date';
                break;
            case 'category':
                $fields  .= ', t.term_id, t.slug AS category_slug, t.name AS category';
                $joins   .= "INNER JOIN {$this->wpdb->term_relationships} AS tr
                                ON tr.object_id = p.ID
                             CROSS JOIN {$this->wpdb->term_taxonomy} AS tt
                                USING( term_taxonomy_id )
                             CROSS JOIN {$this->wpdb->terms} AS t USING( term_id )";
                $where   .= " AND tt.taxonomy = 'category'";
                $groupby  = 'GROUP BY p.ID';
                $orderby  = 'category, ' . $orderby;
                break;
            case 'author':
                $fields  .= ', p.post_author, u.user_nicename AS author_nicename, 
                             u.display_name AS author_name';
                $joins   .= "INNER JOIN {$this->wpdb->users} AS u 
                                ON p.post_author = u.ID";
                $orderby  = 'u.display_name, ' . $orderby;
                break;
        }
        
        $this->queriedPosts = $this->wpdb->get_results(
            "SELECT {$fields}
             FROM {$this->wpdb->posts} AS p
             LEFT OUTER JOIN {$this->wpdb->postmeta} AS pm
                ON p.ID = pm.post_id AND pm.meta_key = '{$meta_key}'
             {$joins}
             WHERE p.post_type = 'post' AND p.post_status = 'publish' AND 
                   p.post_password = '' AND pm.post_id IS NULL {$where}
             {$groupby}
             ORDER BY {$orderby}
             {$limit}"
        );
    }

    /**
     * @since 2.0
     * @return bool
     */
    private function popStickyPosts() {
        $stickies_IDs = get_option( 'sticky_posts' );

        if (! is_array( $stickies_IDs ) ) {
            return false;
        }

        $is_sticky_flags = $stickies = array();

        foreach ( $stickies_IDs as $id ) {
            $id = (int) $id;

            if ( $id > 0 ) {
                $is_sticky_flags[$id] = true;
            }
        }

        foreach ( $this->queriedPosts as $index => $post ) {
            if ( isset( $is_sticky_flags[$post->ID] ) ) {
                $stickies[] = $post;

                unset( $this->queriedPosts[$index] );
            }
        }

        $this->queriedPosts = array_merge( $stickies, $this->queriedPosts );
    }
    
    /**
     * @since 2.0
     *
     * @param $post object
     * @return string
     */
    private function orderby_date( $post ) {
        $year  = mysql2date( 'Y', $post->post_date );
        $month = mysql2date( 'm', $post->post_date );
        $date  = mysql2date( 'F Y', $post->post_date );
        $link  = get_month_link( $year, $month );

        $link_title_format = __( 'View all posts published on %s', 'sitetree' );
        $link_title        = sprintf( $link_title_format, $date );

        return '<a href="' . $link . '" title="' . $link_title . '">' . $date;
    }
    
    /**
     * @since 2.0
     *
     * @param $post object
     * @return string
     */
    private function orderby_category( $post ) {
        $term           = new stdClass();
        $term->term_id  = $post->term_id;
        $term->name     = $post->category;
        $term->slug     = $post->category_slug;
        $term->taxonomy = 'category';
        
        wp_cache_add( $term->term_id, $term, 'category' );

        $title_format  = __( 'View all posts filed under %s', 'sitetree' );
        $stripped_name = esc_attr( strip_tags( $term->name ) );
        
        $output  = '<a href="' . get_term_link( $term ) . '" title="';
        $output .= sprintf( $title_format, $stripped_name ) . '">';
        $output .= esc_attr( $term->name );
        
        return $output;
    }
    
    /**
     * @since 2.0
     *
     * @param $post object
     * @return string
     */
    private function orderby_author( $post ) {
        $title_format  = __( 'View all posts by %s', 'sitetree' );
        $stripped_name = esc_attr( strip_tags( $post->author_name ) );

        $output  = '<a href="';
        $output .= get_author_posts_url( $post->post_author, $post->author_nicename );
        $output .= '" title="';
        $output .= sprintf( $title_format, $stripped_name ) . '">';
        $output .= esc_attr( $post->author_name );
        
        return $output;
    }
}


/**
 * @since 2.0
 */
class SiteTreeWalker extends Walker {
    /**
     * @since 2.0
     * @var object
     */
    private $builder;

    /**
     * @see parent::$tree_type
     * @since 2.0
     *
     * @var string
     */
    public $tree_type;

    /**
     * @since 2.0
     * @param object $builder
     */
    public function __construct( $builder ) {
        $this->builder   = $builder;
        $this->tree_type = $builder->listID();
    }

    /**
     * @see parent::start_lvl()
     * @since 2.0
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // 'children' is a standard class used by WordPress.
        $output .= "\n<ul class=\"children\">\n";
    }

    /**
     * @see parent::end_lvl()
     * @since 2.0
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "</ul>\n";
    }

    /**
     * @see parent::end_el()
     * @since 2.0
     */
    public function end_el( &$output, $object, $depth = 0, $args = array() ) {
        $output .= "</li>\n";

        $this->builder->incrementItemsCounter();
    }
}


/**
 * @since 3.0
 */
final class SiteTreeCustomPostWalker extends SiteTreeWalker {
    /**
     * @see Walker::$db_fields
     * @since 3.0
     *
     * @var array
     */
    public $db_fields = array(
        'id'     => 'ID',
        'parent' => 'post_parent'
    );

    /**
     * @see Walker::start_el()
     * @since 3.0
     */
    public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $output .= '<li><a href="' . get_permalink( $object ) . '">';
        $output .= apply_filters( 'the_title', $object->post_title, $object->ID );
        $output .= '</a>';
    }

    
}


/**
 * @since 3.0
 */
final class SiteTreeTaxonomyWalker extends SiteTreeWalker {
    /**
     * @see Walker::$db_fields
     * @since 3.0
     *
     * @var array
     */
    public $db_fields = array(
        'id'     => 'term_id',
        'parent' => 'parent'
    );

    /**
     * @see Walker::start_el()
     * @since 3.0
     */
    public function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        if ( $object->description )
            $link_title = $object->description;
        else
            $link_title = sprintf( __( 'View all posts filed under %s', 'sitetree-pro' ), $object->name );
        
        $output .= '<li><a href="' . get_term_link( $object ) . '" title="';
        $output .= esc_attr( strip_tags( $link_title ) );
        $output .= '">' . esc_attr( $object->name ) . '</a>';
        
        if ( $args['feed'] ) {
            $output .= ' (<a href="';
            $output .= get_term_feed_link( $object->term_id );
            $output .= '">' . esc_attr( $args['feed'] ) . '</a>)';
        }
            
        if ( $args['show_count'] )
            $output .= ' <span class="site-tree-posts-count">(' . (int) $object->count . ')</span>';
    }
}
?>
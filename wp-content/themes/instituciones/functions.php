<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Consultas reutilizables
 */

// require get_template_directory().'/inc/queries.php';

/**
 * Menus de instituciones
 * 
 */
 
 /* Paginacion numérica */
function wp_numeric_posts_nav() {
 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<div class="navigation"><ul class="pagination-noticias">' . "\n";
 	
	$atras = '<span class="fas fa-chevron-left icon-md-cat icon-white"></span>';
	 if ( $paged != 1 ){
		echo '<li class="left-option pagi-icon-left">' , previous_posts_link( $atras );'</li>'. "\n";
	 }
	
    /** Previous Post Link */
   /** if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() ); */
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    /** if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() ); */
 	
	$siguiente = '<span class="fas fa-chevron-right icon-md-cat icon-white "></span>';
	
	echo '<li class="right-option pagi-icon-right">' , next_posts_link( $siguiente );'</li>'. "\n";
	echo '</ul> </div>' . "\n";
 
}
 function instituciones_menu(){
     register_nav_menus( array(
        'menu-principal' => __( 'Menú Principal',"Instituciones" )
	 ));
	 
	 register_nav_menus( array(
        'menu-movil' => __( 'Menú Móvil',"Instituciones" )
     ));
 }

 add_action( 'init', 'instituciones_menu' );

 class Child_Wrap extends Walker_Nav_Menu{
	 
    function start_lvl(&$output, $depth = 0, $args = array()){
		$indent = str_repeat("\t", $depth);		
        $output .= "<div class='dropdown btn-dropdown'><a href='#' class='dropdown-toggle nav-link' data-toggle='dropdown' aria-expanded='false'>$indent</a><ul class=\"dropdown-menu\" role=\"menu\">";
    }

    function end_lvl(&$output, $depth = 0, $args = array()){
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>";
    }
}

/** Botones categorias principales para el index */
function CreateCategory(){
	$avisos = array('cat_name' => 'Avisos', 
		'category_description' => '—',
		 'category_nicename' => 'avisos',
		  'category_parent' => '');

	$noticias = array('cat_name' => 'Noticias', 
		'category_description' => '—',
		 'category_nicename' => 'noticias',
		  'category_parent' => '');		  

	$carrusel = array('cat_name' => 'Carrusel Principal', 
		  'category_description' => 'Contiene entradas de el carrusel superio',
		   'category_nicename' => 'carrusel-principal',
			'category_parent' => '');		  					
	// Creando categorias para entradas 
	wp_insert_category($avisos);
	wp_insert_category($noticias);
	wp_insert_category($carrusel);	
}
	add_action('admin_init','CreateCategory');


/** Botones paginación */

function instituciones_botones_paginador(){
	return 'class="ltc-isabelline"';	
}
add_filter( 'next_posts_link_attributes', 'instituciones_botones_paginador' );
add_filter( 'previous_posts_link_attributes', 'instituciones_botones_paginador' );


/** Deficicion de extracto  */
/*
function wpdocs_excerpt_more( $more ) {
    if ( ! is_single() ) {
        $more = sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
            get_permalink( get_the_ID() ),
            __( 'Leer más...', 'textdomain' )
        );
    }
 
    return $more;
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

*/

add_action('the_excerpt','add_class_to_excerpt');
function add_class_to_excerpt( $excerpt ){
    return '<div class="parrafos-blancos-letranegra">'.$excerpt.'</div>';
}

/**
 * 
 * Scripts y Styles
 *
 */

function instituciones_scripts_styles(){

	
	//Dependencias estilos
	wp_enqueue_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css?6593', array(), '4.2.1');
	wp_enqueue_style('animate', get_template_directory_uri().'/css/animate.css?438', array(), '3.7.0');
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/font-awesome.min.css', array(), '4.7.0');
	wp_enqueue_style('feather', get_template_directory_uri().'/css/feather.min.css', array(), '1.0.0');
	wp_enqueue_style('ionicons', get_template_directory_uri().'/css/ionicons.min.css', array(), '2.0.0');
	
	// Hoja de estilos principal
	wp_enqueue_style( 'style', get_stylesheet_uri().'?4511', array('bootstrap','animate','font-awesome','feather','ionicons'), '1.0.0');
	
	// Scripts
}

add_action( 'wp_enqueue_scripts', 'instituciones_scripts_styles');


add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size();


/*Sidebar*/

add_action( 'widgets_init', 'my_register_sidebars' );
function my_register_sidebars() {
    /* Register the 'primary' sidebar. */
    register_sidebar(
        array(
            'id'            => 'sidebarprincipal',
            'name'          => __( 'Sidebar principal' ),
            'description'   => __( 'Sidebar para los contenidos.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
}



/**
 * Create A Simple Theme Options Panel
 *
 */

/** DATOS DE LA INSTITUCION */
add_action("nuevo", "setup_theme_admin_menus");

function createShortcuts() {
	$videos = myprefix_get_theme_option('videos');
	$calendario = myprefix_get_theme_option('calendario');
	$descargas = myprefix_get_theme_option('descargas');
	$preguntas = myprefix_get_theme_option('preguntas');
	$programas = myprefix_get_theme_option('programas');
	$avisos= myprefix_get_theme_option('avisos');
?>
<div class="container enlaces-bk">
	<div class="row shortcuts-bloc shortcut-caption ml-5 mr-5">
	<?php
		if($calendario != ''){
	?>					
		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item">
				<a href="<?php echo $calendario;?>" >
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/calendario.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="icono%20calendario" data-appear-anim-style="fadeInUp" />
					   <figcaption><h5 class="text-center">Calendario de Actividades</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>
	<?php 
		}
	?>	

	<!-- Datos quemados para los iconos de abajo -->

		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo get_site_url(); ?>/codex-alimentarius/"> <!-- Introducir link del icono-->
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/Logo_Codex.png" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="codex" data-appear-anim-style="fadeInUp" />
					 	<figcaption><h5 class="text-center">Codex Alimentarius</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>

		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo get_site_url(); ?>/preguntas-frecuentes/"> <!-- Introducir link del icono-->
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/preguntas.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="preguntas" data-appear-anim-style="fadeInUp" />
					 	<figcaption><h5 class="text-center">Preguntas Frecuentes</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>

		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo get_site_url(); ?>/planes/"> <!-- Introducir link del icono-->
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/noticias.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="planes" data-appear-anim-style="fadeInUp" />
					 	<figcaption><h5 class="text-center">Planes</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>

		<!--<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo get_site_url();?>/eliminacion-de-incongruencias-entre-normativas/">
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/Programa.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="avisos" data-appear-anim-style="fadeInUp" />
						<figcaption><h5 class="text-center">Eliminación de Incongruencias Entre Normativas</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>-->	

	<!-- Datos quemados para los iconos de abajo END -->

	<?php
		if($descargas != ''){
	?>					
		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo $descargas;?>">	
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/Descargas.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="descarp" data-appear-anim-style="fadeInUp" />
					 	<figcaption><h5 class="text-center">Descargas</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>
	<?php 
		}
	?>				
	<?php
		if($programas != ''){
	?>					
		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo $programas;?>">
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/programa.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="programas" data-appear-anim-style="fadeInUp" />
						<figcaption><h5 class="text-center">Programas</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>
	<?php 
		}
	?>				
	<?php
		if($videos != ''){
	?>					
		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo $videos;?>" >
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/videos.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="icono%20videos" data-appear-anim-style="fadeInUp" />
						<figcaption><h5 class="text-center">Vídeos</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>
	<?php 
		}
	?>				
	<?php
		if($avisos!= ''){
	?>					
		<div class="col-xs-12 col-sm my-auto">
			<div class="shortcut-item ">
				<a href="<?php echo $avisos;?>">
					<figure class="figure">
						<img src="<?php bloginfo('stylesheet_directory'); ?>/img/lazyload-ph.png" data-src="<?php bloginfo('stylesheet_directory'); ?>/img/avisos.svg" class="img-fluid mx-auto d-block animated pulse-hvr fadeInUp lazyload" alt="avisos" data-appear-anim-style="fadeInUp" />
						<figcaption><h5 class="text-center">Avisos</h5></figcaption>
					</figure>
				</a>
			</div>
		</div>
	<?php 
		}
	?>
	</div>
</div>
<?php
}
add_action( 'wpmu_create_shortcuts', 'createShortcuts' );


function get_hansel_and_gretel_breadcrumbs()
{
    // Set variables for later use
    $here_text        = __( '' );
    $home_link        = home_url('/');
    $home_text        = __( 'Inicio' );
    $link_before      = '';//<span typeof="v:Breadcrumb">
    $link_after       = '';//</span>
    $link_attr        = ' ';// rel="v:url" property="v:title"
    $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $delimiter        = ' &gt; ';              // Delimiter between crumbs
    $before           = '<span class="current">'; // Tag before the current crumb
    $after            = '</span>';                // Tag after the current crumb
    $page_addon       = '';                       // Adds the page number if the query is paged
    $breadcrumb_trail = '';
    $category_links   = '';
    
   
    $wp_the_query   = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    
    if ( is_singular() ) 
    {
       
        $post_object = sanitize_post( $queried_object );

       
        $title          = apply_filters( 'the_title', $post_object->post_title );
        $parent         = $post_object->post_parent;
        $post_type      = $post_object->post_type;
        $post_id        = $post_object->ID;
        $post_link      = $before . $title . $after;
        $parent_string  = '';
        $post_type_link = '';
		

		

        if ( 'post' === $post_type ) 
        {
          
            $categories = get_the_category( $post_id );
            if ( $categories ) {
                
                $category  = $categories[0];

                $category_links = get_category_parents( $category, true, $delimiter );
				
                $category_links = str_replace( '<a',   $link_before . '<a' . $link_attr, $category_links );
                $category_links = str_replace( '</a>', '</a>' . $link_after,             $category_links );
            }
        }

        if ( !in_array( $post_type, ['post', 'page', 'attachment'] ) )
        {
            $post_type_object = get_post_type_object( $post_type );
            $archive_link     = esc_url( get_post_type_archive_link( $post_type ) );

            $post_type_link   = sprintf( $link, $archive_link, $post_type_object->labels->name );//singular_name
        }

        
        if ( 0 !== $parent ) 
        {
            $parent_links = [];
            while ( $parent ) {
                $post_parent = get_post( $parent );

                $parent_links[] = sprintf( $link, esc_url( get_permalink( $post_parent->ID ) ), get_the_title( $post_parent->ID ) );

                $parent = $post_parent->post_parent;
            }

            $parent_links = array_reverse( $parent_links );

            $parent_string = implode( $delimiter, $parent_links );
        }

        
        if ( $parent_string ) {
            $breadcrumb_trail = $parent_string . $delimiter . $post_link;
        } else {
            $breadcrumb_trail = $post_link;
        }

        if ( $post_type_link )
            $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

        if ( $category_links )
            $breadcrumb_trail = $category_links . $breadcrumb_trail;
    }

    
    if( is_archive() )
    {
        if (    is_category()
             || is_tag()
             || is_tax()
        ) {
            
            $term_object        = get_term( $queried_object );
            $taxonomy           = $term_object->taxonomy;
            $term_id            = $term_object->term_id;
            $term_name          = $term_object->name;
            $term_parent        = $term_object->parent;
            $taxonomy_object    = get_taxonomy( $taxonomy );
            $current_term_link  = $before . $taxonomy_object->labels->name . ': ' . $term_name . $after;
            $parent_term_string = '';

            if ( 0 !== $term_parent )
            {
               
                $parent_term_links = [];
                while ( $term_parent ) {
                    $term = get_term( $term_parent, $taxonomy );

                    $parent_term_links[] = sprintf( $link, esc_url( get_term_link( $term ) ), $term->name );

                    $term_parent = $term->parent;
                }

                $parent_term_links  = array_reverse( $parent_term_links );
                $parent_term_string = implode( $delimiter, $parent_term_links );
            }

            if ( $parent_term_string ) {
                $breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
            } else {
                $breadcrumb_trail = $current_term_link;
            }

        } elseif ( is_author() ) {

            $breadcrumb_trail = __( 'Author archive for ') .  $before . $queried_object->data->display_name . $after;

        } elseif ( is_date() ) {
            
            $year     = $wp_the_query->query_vars['year'];
            $monthnum = $wp_the_query->query_vars['monthnum'];
            $day      = $wp_the_query->query_vars['day'];

            
            if ( $monthnum ) {
                $date_time  = DateTime::createFromFormat( '!m', $monthnum );
                $month_name = $date_time->format( 'F' );
            }

            if ( is_year() ) {

                $breadcrumb_trail = $before . $year . $after;

            } elseif( is_month() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), $year );

                $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

            } elseif( is_day() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ),             $year       );
                $month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), $month_name );

                $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
            }

        } elseif ( is_post_type_archive() ) {

            $post_type        = $wp_the_query->query_vars['post_type'];
            $post_type_object = get_post_type_object( $post_type );

            $breadcrumb_trail = $before . $post_type_object->labels->name . $after;

        }
    }   

    
    if ( is_search() ) {
        $breadcrumb_trail = __( 'Search query for: ' ) . $before . get_search_query() . $after;
    }

    
    if ( is_404() ) {
        $breadcrumb_trail = $before . __( 'Error 404' ) . $after;
    }

    if ( is_paged() ) {
        $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
        $page_addon   = $before . sprintf( __( ' ( Page %s )' ), number_format_i18n( $current_page ) ) . $after;
    }

    $breadcrumb_output_link  = '';
    $breadcrumb_output_link .= '<p id="breadcrumb">';
    if (    is_home()
         || is_front_page()
    ) {
        
        if ( is_paged() ) {
            $breadcrumb_output_link .= $here_text;// . $delimiter
            $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
            $breadcrumb_output_link .= $page_addon;
        }
    } else {
        $breadcrumb_output_link .= $here_text;// . $delimiter
        $breadcrumb_output_link .= '<a href="' . $home_link . '" >' . $home_text . '</a>';//rel="v:url" property="v:title"
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
    $breadcrumb_output_link .= '</p><!-- .breadcrumbs -->';
    $breadcrumb_output_link = str_replace("/servicios/","/guia-de-servicios/",$breadcrumb_output_link);
	$breadcrumb_output_link = str_replace("/programas/","/guia-de-programas/",$breadcrumb_output_link);
    return $breadcrumb_output_link;
}

// Start Class
if ( ! class_exists( 'WPEX_Theme_Options' ) ) {

	class WPEX_Theme_Options {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// We only need to register the admin panel on the back-end
			if ( is_admin() ) {
				add_action( 'admin_menu', array( 'WPEX_Theme_Options', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'WPEX_Theme_Options', 'register_settings' ) );
			}

		}

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_options() {
			return get_option( 'theme_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_option( $id ) {
			$options = self::get_theme_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */
		public static function add_admin_menu() {
			add_menu_page(
				esc_html__( 'Datos de la Institución', 'text-domain' ),
				esc_html__( 'Datos de la Institución', 'text-domain' ),
				'manage_options',
				'theme-settings',
				array( 'WPEX_Theme_Options', 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function register_settings() {
			register_setting( 'theme_options', 'theme_options', array( 'WPEX_Theme_Options', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				// Checkbox
				if ( ! empty( $options['checkbox_example'] ) ) {
					$options['checkbox_example'] = 'on';
				} else {
					unset( $options['checkbox_example'] ); // Remove from options if not checked
				}

				// Input
				if ( ! empty( $options['input_example'] ) ) {
					$options['input_example'] = sanitize_text_field( $options['input_example'] );
				} else {
					unset( $options['input_example'] ); // Remove from options if empty
				}

				// Select
				if ( ! empty( $options['select_example'] ) ) {
					$options['select_example'] = sanitize_text_field( $options['select_example'] );
				}

			}

			// Return sanitized options
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>

			<div class="wrap">

				<h1><?php esc_html_e( 'Datos generales de la Institución', 'text-domain' ); ?></h1>

				<form method="post" action="options.php">

					<?php settings_fields( 'theme_options' ); ?>

					<table class="form-table wpex-custom-admin-login-table">

						
						<?php // Text input example ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Logo de la instituci&oacute;n', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'input_logo' ); ?>
								<input type="text" name="theme_options[input_logo]" value="<?php echo esc_attr( $value ); ?>" size='70'>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Sección principal de portada', 'text-domain' ); ?></th>
							<td>
								<?php
								$value = self::get_theme_option( 'seccion_especial' );
								
								?>
								<select name="theme_options[seccion_especial]">
								<option>Seleccione una categoría</option>
								<?php
								$categories = get_categories( array(
									'orderby' => 'name',
									'order'   => 'ASC'
								) );
								
								foreach( $categories as $category ) {
									$selslug="";
									if($category->slug==$value){
										$selslug=" selected";
									}
									?>
									<option value='<?php echo $category->slug;?>' <?php echo $selslug;?>><?php echo $category->name;?> (<?php echo $category->count;?>)</option><?php

								} 
								?>
								</select>
								<?php
								/*
								?>
								
								<input type="text" name="theme_options[seccion_especial]" value="<?php echo esc_attr( $value ); ?>" size='70'>
								<?php
								*/?>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'URL Portal de Transparencia', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'input_portal' ); ?>
								<input type="text" name="theme_options[input_portal]" value="<?php echo esc_attr( $value ); ?>" size='70'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'URL Instituciones', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'input_instituciones' ); ?>
								<input type="text" name="theme_options[input_instituciones]" value="<?php echo esc_attr( $value ); ?>" size='70'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Longitud del título de artículos de portada', 'text-domain' ); ?></th>
							<td>
								<?php 
								$value = self::get_theme_option( 'input_title_len' ); 
								if($value==0){$value=85;}
								?>
								<input type="text" name="theme_options[input_title_len]" value="<?php echo esc_attr( $value ); ?>" size='70'>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Google Analytics - ID de la medición', 'text-domain' ); ?></th>
							<td>
								<?php 
								$value = self::get_theme_option( 'input_google_medicion_id' ); 								
								?>
								<input type="text" name="theme_options[input_google_medicion_id]" value="<?php echo esc_attr( $value ); ?>" size='70'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'URL Buscador', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'input_buscador' ); ?>
								<input type="text" name="theme_options[input_buscador]" value="<?php echo esc_attr( $value ); ?>" size='70'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Nombre de la instituci&oacute;n', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'input_example' ); ?>
								<input type="text" name="theme_options[input_example]" value="<?php echo esc_attr( $value ); ?>" size='70'>
							</td>
						</tr>
                                                
                         <tr valign="top">
							<th scope="row"><?php esc_html_e( 'Direcci&oacute;n de la instituci&oacute;n', 'text-domain' ); ?></th>
							<td>     
								<?php $value = self::get_theme_option( 'introtext' ); ?>
								<textarea id="theme_options[introtext]"
								class="large-text" cols="50" rows="10" name="theme_options[introtext]"><?php echo esc_attr( $value); ?></textarea>
							</td>
						</tr>
                                                                                                                                                
                        <tr valign="top">
							<th scope="row"><?php esc_html_e( 'Tel&eacute;fono de contacto', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'phone_number' ); ?>
								<input type="text" name="theme_options[phone_number]" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>
                                                                                                
                        <tr valign="top">
							<th scope="row"><?php esc_html_e( 'Correo electr&oacute;nico', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'inst_email' ); ?>
								<input type="text" name="theme_options[inst_email]" value="<?php echo esc_attr( $value ); ?>" size='35'>
							</td>
						</tr>                                                                                                                                             

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'URL de Twitter', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'tw_url' ); ?>
								<input type="text" name="theme_options[tw_url]" value="<?php echo esc_attr( $value ); ?>" size='50'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'URL de Facebook', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'fb_url' ); ?>
								<input type="text" name="theme_options[fb_url]" value="<?php echo esc_attr( $value ); ?>" size='50'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'URL de Instagram', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'ig_url' ); ?>
								<input type="text" name="theme_options[ig_url]" value="<?php echo esc_attr( $value ); ?>" size='50'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'URL de YouTube', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'yt_url' ); ?>
								<input type="text" name="theme_options[yt_url]" value="<?php echo esc_attr( $value ); ?>" size='50'>
							</td>
						</tr>

						
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Videos', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'videos' ); ?>
								<input type="text" name="theme_options[videos]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Avisos', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'avisos' ); ?>
								<input type="text" name="theme_options[avisos]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Programas', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'programas' ); ?>
								<input type="text" name="theme_options[programas]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Calendario', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'calendario' ); ?>
								<input type="text" name="theme_options[calendario]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Descargas', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'descargas' ); ?>
								<input type="text" name="theme_options[descargas]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Mapa del Sitio', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'mapasitio' ); ?>
								<input type="text" name="theme_options[mapasitio]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Politica Web', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'politicaweb' ); ?>
								<input type="text" name="theme_options[politicaweb]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Preguntas Frecuentres', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'preguntas' ); ?>
								<input type="text" name="theme_options[preguntas]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Carta de Derecho', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'cartaderecho' ); ?>
								<input type="text" name="theme_options[cartaderecho]" value="<?php echo esc_attr( $value ); ?>" size='75'>
							</td>
						</tr>

						<?php // Select example ?>
						<!-- <tr valign="top" class="wpex-custom-admin-screen-background-section">
							<th scope="row"><?php esc_html_e( 'Select Example', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'select_example' ); ?>
								<select name="theme_options[select_example]">
									<?php
									$options = array(
										'1' => esc_html__( 'Option 1', 'text-domain' ),
										'2' => esc_html__( 'Option 2', 'text-domain' ),
										'3' => esc_html__( 'Option 3', 'text-domain' ),
									);
									foreach ( $options as $id => $label ) { ?>
										<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
											<?php echo strip_tags( $label ); ?>
										</option>
									<?php } ?>
								</select>
							</td>
						</tr> -->
					</table>
					<?php submit_button(); ?>

				</form>

			</div><!-- .wrap -->
		<?php }

	}
}
new WPEX_Theme_Options();

// Helper function to use in your theme to return a theme option value
function myprefix_get_theme_option( $id = '' ) {
	return WPEX_Theme_Options::get_theme_option( $id );
}



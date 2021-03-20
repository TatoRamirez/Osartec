<?php
/**
 * Plugin Name: Galería Institucional - Gobierno de  El Salvador
 * Plugin Uri:
 * Description: Añade la galería de la Institución con este plugin.
 * Version: 1.0.0
 * Author: Secretaría de Innovación de la Presidencia de la República, Desarrollado en la Unidad de Tecnologías de la Información UTIP por Karla Marenco Aguirre, kmarenco@presidencia.gob.sv
 * Author Uri: 
 * Text Domain: Instituciones
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 // Register Custom Post Type
function Galeria() {

	$labels = array(
		'name'                  => _x( 'Galería', 'Post Type General Name', 'Instituciones' ),
		'singular_name'         => _x( 'Galería', 'Post Type Singular Name', 'Instituciones' ),
		'menu_name'             => __( 'Galería Institucional', 'Instituciones' ),
		'name_admin_bar'        => __( 'Galería Institucional', 'Instituciones' ),
		'archives'              => __( 'Lista de Galerías', 'Instituciones' ),
		'attributes'            => __( 'Item Attributes', 'Instituciones' ),
		'parent_item_colon'     => __( 'Galería Padre:', 'Instituciones' ),
		'all_items'             => __( 'Todas las Galería', 'Instituciones' ),
		'add_new_item'          => __( 'Añadir Galería', 'Instituciones' ),
		'add_new'               => __( 'Añadir Galería', 'Instituciones' ),
		'new_item'              => __( 'Nueva Galería', 'Instituciones' ),
		'edit_item'             => __( 'Editar Galería', 'Instituciones' ),
		'update_item'           => __( 'Actualizar Galería', 'Instituciones' ),
		'view_item'             => __( 'Ver Galería', 'Instituciones' ),
		'view_items'            => __( 'Ver Galería', 'Instituciones' ),
		'search_items'          => __( 'Buscar Galería', 'Instituciones' ),
		'not_found'             => __( 'No encontrado', 'Instituciones' ),
		'not_found_in_trash'    => __( 'No encontrado en la papelera', 'Instituciones' ),
		'featured_image'        => __( 'Imagen destacada', 'Instituciones' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'Instituciones' ),
		'remove_featured_image' => __( 'Eliminar imagen destacada', 'Instituciones' ),
		'use_featured_image'    => __( 'Usar como imagen destacada', 'Instituciones' ),
		'insert_into_item'      => __( 'Agregar elemento', 'Instituciones' ),
		'uploaded_to_this_item' => __( 'Subido a este Galería', 'Instituciones' ),
		'items_list'            => __( 'Lista de Galería', 'Instituciones' ),
		'items_list_navigation' => __( 'Lista de navegación de Galería', 'Instituciones' ),
		'filter_items_list'     => __( 'Filtrar lista de Galería', 'Instituciones' ),
	);
	$args = array(
		'label'                 => __( 'Galería', 'Instituciones' ),
		'description'           => __( 'Descripción de la Galería', 'Instituciones' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
		'taxonomies'            => array( 'grupo', 'etiqueta_galeria' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-gallery',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',		
	);
	register_post_type( 'galeria', $args );

}
add_action( 'init', 'Galeria', 0 );

// Función para crear una taxonomía jerarquica para las Galerías
function crear_taxonomia_albumes_galeria() {

	$categorias = array(
	  'name' => __( 'Álbumes' ),
	  'singular_name' => __( 'Álbum' ),
	  'search_items' =>  __( 'Buscar álbum' ),
	  'all_items' => __( 'Todos los álbumes' ),
	  'parent_item' => __( 'Álbum padre' ),
	  'parent_item_colon' => __( 'Álbum padre:' ),
	  'edit_item' => __( 'Editar álbum' ), 
	  'update_item' => __( 'Actualizar álbum' ),
	  'add_new_item' => __( 'Agregar un nuevo álbum' ),
	  'menu_name' => __( 'Álbumes' ),
  ); 	
  
  
  register_taxonomy(
	  'album',
	  array('galeria'), // Tipos de Post a los que asociaremos la taxonomía
	  array(
		  'hierarchical' => true, 
		  'labels' => $categorias, 
		  'show_ui' => true,
		  'show_admin_column' => true,
		  'query_var' => true,
		  'rewrite' => array( 'slug' => 'album' ),
		  'show_in_rest' => true,
	  )
  );
  
}
  add_action( 'init', 'crear_taxonomia_albumes_galeria', 0 );

// Función para crear una taxonomía no jerarquica para los servicios
function crear_taxonomia_etiqueta_galeria() {

	$etiquetas = array(
	  'name' => __( 'Etiqueta Galería' ),
	  'singular_name' => __( 'Etiqueta Galería' ),
	  'search_items' =>  __( 'Buscar etiqueta' ),
	  'all_items' => __( 'Todos los etiquetas' ),
	  'parent_item' => __( 'Grupo padre' ),
	  'parent_item_colon' => __( 'Grupo padre:' ),
	  'edit_item' => __( 'Editar etiqueta' ), 
	  'update_item' => __( 'Actualizar etiqueta' ),
	  'add_new_item' => __( 'Agregar una nueva etiqueta' ),
	  'menu_name' => __( 'Etiqueta Galería' ),
  ); 	
  
  
  register_taxonomy(
	  'etiqueta_galeria',
	  array('galeria'), // Tipos de Post a los que asociaremos la taxonomía
	  array(
		  'hierarchical' => false, 
		  'labels' => $etiquetas, 
		  'show_ui' => true,
		  'show_admin_column' => true,
		  'query_var' => true,
		  'rewrite' => array( 'slug' => 'etiqueta_galeria' ),
		  'show_in_rest' => true,
	  )
  );
  
  }
  add_action( 'init', 'crear_taxonomia_etiqueta_galeria', 0 );

//Función para añadir campos personalizados al formulario de Añadir nueva galería
function album_addform_termmeta() {
	wp_nonce_field( 'album_termmeta', 'album_termmeta_nonce' );?>
   
	<div class="form-field category-image-wrap">
	  <label for="category-image">Imagen destacada</label>
	  <div class="custom_media_item">
		<a href="#" class="button button-primary custom_media_item_upload">Subir imagen</a>
		<input type="hidden" id="category-image" name="category-image" value="" />
		<img src="" style="max-width:150px;display:none;" />
		<a href="#" class="button button-primary custom_media_item_delete" style="display:none;">Eliminar</a>
	  </div>
	</div>   
  <?php
}
add_action( 'album_add_form_fields', 'album_addform_termmeta' );

//Función para añadir campos personalizados al formulario de Editar álbum
function album_editform_termmeta( $term ) {
	$category_image = get_term_meta( $term->term_id, 'category-image', true );
	
	wp_nonce_field( 'my_category_termmeta', 'my_category_termmeta_nonce' );?>
   
	<tr class="form-field category-image-wrap">
	  <th scope="row"><label for="category-image">Imagen destacada</label></th>
	  <td>
		<div class="custom_media_item">
		  <?php
		  $display = "";
		  if (empty($category_image) || $category_image == "") { $display = 'display:none';}
		  $media_item_src = wp_get_attachment_url( $category_image );?>
   
		  <a href="#" class="button button-primary custom_media_item_upload">Subir imagen</a>
		  <input type="hidden" id="category-image" name="category-image" value="<?php echo $category_image;?>" />
		  <img src="<?php echo $media_item_src;?>" style="max-width:150px;<?php echo $display;?>" />
		  <a href="#" class="button button-primary custom_media_item_delete" style="<?php echo $display;?>">Eliminar</a>
		</div>
	  </td>
	</tr>
   	
  <?php }
  add_action( 'album_edit_form_fields', 'album_editform_termmeta' );

  function album_admin_scripts(){
	//Agregamos nuestro JS
	wp_enqueue_script( 'my_custom_fields_js', plugin_dir_url(__FILE__) . '/js/custom-fields.js', array('jquery'), '1.0' );
   
	//Añadimos la librería multimedia
	wp_enqueue_media();
  }
  add_action('admin_print_scripts', 'album_admin_scripts');

  function album_fields_save_data( $term_id ) {
	// Comprobamos si se ha definido el nonce.
	if ( ! isset( $_POST['my_category_termmeta_nonce'] ) ) {
	  return $term_id;
	}
	$nonce = $_POST['my_category_termmeta_nonce'];
		
	// Verificamos que el nonce es válido.
	if ( !wp_verify_nonce( $nonce, 'my_category_termmeta' ) ) {
	  return $term_id;
	}
   
	// Si existen entradas antiguas las recuperamos
	#$old_category_image = get_term_meta( $term_id, 'category-image', true );
	
   
	// Saneamos lo introducido por el usuario.
	$category_image = sanitize_text_field( $_POST['category-image'] );
	
   
// Actualizamos el campo meta en la base de datos.
	update_term_meta( $term_id, 'category-image', $category_image, $old_category_image );
  }

  add_action( 'edit_album', 'album_fields_save_data' );
  add_action( 'create_album', 'album_fields_save_data' );

  function album_columns( $columns ) {
	$columns['featured_image'] = "Imagen";
   
	return $columns;
  }
  add_filter( 'manage_edit-album_columns', 'album_columns' );
   
  function album_image_column( $out, $column, $term_id ) {
	if ( $column === 'featured_image' ) {
	  $category_image = get_term_meta( $term_id, 'category-image', true );
		if (!empty($category_image)) {
		  $media_item_src = wp_get_attachment_image_src( $category_image, "thumbnail" );
		  $return = sprintf( '<img src="%s" width="64">', $media_item_src[0] );
		}
	  }
   
	return $return;
  }
  add_filter( 'manage_album_custom_column', 'album_image_column', 10, 3 );


?>
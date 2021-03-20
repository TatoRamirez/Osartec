<?php
/**
 * Plugin Name: Programas Institucionales - Gobierno de  El Salvador
 * Plugin Uri:
 * Description: Añade los Programas de la Institución con este plugin, deberás agregar una página con la Plantilla "Contenido para Programas".
 * Version: 1.0.0
 * Author: Secretaría de Innovación de la Presidencia de la República, Desarrollado en la Unidad de Tecnologías de la Información UTIP por Karla Marenco Aguirre, kmarenco@presidencia.gob.sv
 * Author Uri: 
 * Text Domain: Programas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 // Register Custom Post Type
function Programas() {

	$labels = array(
		'name'                  => _x( 'Programas', 'Post Type General Name', 'Instituciones' ),
		'singular_name'         => _x( 'Programa', 'Post Type Singular Name', 'Instituciones' ),
		'menu_name'             => __( 'Programas Institucionales', 'Instituciones' ),
		'name_admin_bar'        => __( 'Programas Institucionales', 'Instituciones' ),
		'archives'              => __( 'Lista de Programas', 'Instituciones' ),
		'attributes'            => __( 'Item Attributes', 'Instituciones' ),
		'parent_item_colon'     => __( 'Programa Padre:', 'Instituciones' ),
		'all_items'             => __( 'Todos los Programas', 'Instituciones' ),
		'add_new_item'          => __( 'Añadir Programa', 'Instituciones' ),
		'add_new'               => __( 'Añadir Programa', 'Instituciones' ),
		'new_item'              => __( 'Nuevo Programa', 'Instituciones' ),
		'edit_item'             => __( 'Editar Programa', 'Instituciones' ),
		'update_item'           => __( 'Actualizar Programa', 'Instituciones' ),
		'view_item'             => __( 'Ver Programa', 'Instituciones' ),
		'view_items'            => __( 'Ver Programas', 'Instituciones' ),
		'search_items'          => __( 'Buscar Programa', 'Instituciones' ),
		'not_found'             => __( 'No encontrado', 'Instituciones' ),
		'not_found_in_trash'    => __( 'No encontrado en la papelera', 'Instituciones' ),
		'featured_image'        => __( 'Imagen destacada', 'Instituciones' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'Instituciones' ),
		'remove_featured_image' => __( 'Eliminar imagen destacada', 'Instituciones' ),
		'use_featured_image'    => __( 'Usar como imagen destacada', 'Instituciones' ),
		'insert_into_item'      => __( 'Agregar elemento', 'Instituciones' ),
		'uploaded_to_this_item' => __( 'Subido a este Programa', 'Instituciones' ),
		'items_list'            => __( 'Lista de Programas', 'Instituciones' ),
		'items_list_navigation' => __( 'Lista de navegación de Programas', 'Instituciones' ),
		'filter_items_list'     => __( 'Filtrar lista de Programas', 'Instituciones' )
	);
	$args = array(
		'label'                 => __( 'Programa', 'Instituciones' ),
		'description'           => __( 'Descripción del Programa', 'Instituciones' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes'),
		'taxonomies'            => array( 'grupo_programa', 'etiqueta_programa' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-tablet',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true
	);
	register_post_type( 'programas', $args );

}
add_action( 'init', 'Programas', 100 );
/*		'has_archive'           => 'programas',*/

// Función para crear una taxonomía jerarquica para los programas
function crear_taxonomia_programas_grupo() {

	$categorias = array(
	  'name' => __( 'Grupos Programas' ),
	  'singular_name' => __( 'Grupo Programa' ),
	  'search_items' =>  __( 'Buscar grupo' ),
	  'all_items' => __( 'Todos los grupos' ),
	  'parent_item' => __( 'Grupo padre' ),
	  'parent_item_colon' => __( 'Grupo padre:' ),
	  'edit_item' => __( 'Editar grupo' ), 
	  'update_item' => __( 'Actualizar grupo' ),
	  'add_new_item' => __( 'Agregar un nuevo grupo' ),
	  'menu_name' => __( 'Grupo Programa' ),
  ); 	
  
  
  register_taxonomy(
	  'grupo_programa',
	  array('programas'), // Tipos de Post a los que asociaremos la taxonomía
	  array(
		  'hierarchical' => true, 
		  'labels' => $categorias, 
		  'show_ui' => true,
		  'show_admin_column' => true,
		  'query_var' => true,
		  'rewrite' => array( 'slug' => 'grupo_programa' ),
		  'show_in_rest' => true		  
	  )
  );
  
  }
  add_action( 'init', 'crear_taxonomia_programas_grupo', 200 );

// Función para crear una taxonomía no jerarquica para los programas
function crear_taxonomia_programas_etiqueta() {

	$etiquetas = array(
	  'name' => __( 'Etiqueta Programas' ),
	  'singular_name' => __( 'Etiqueta Programa' ),
	  'search_items' =>  __( 'Buscar etiqueta' ),
	  'all_items' => __( 'Todos los etiquetas' ),
	  'parent_item' => __( 'Grupo padre' ),
	  'parent_item_colon' => __( 'Grupo padre:' ),
	  'edit_item' => __( 'Editar etiqueta' ), 
	  'update_item' => __( 'Actualizar etiqueta' ),
	  'add_new_item' => __( 'Agregar una nueva etiqueta' ),
	  'menu_name' => __( 'Etiqueta Programa' )
  ); 	
  
  
  register_taxonomy(
	  'etiqueta_programa',
	  array('programas'), // Tipos de Post a los que asociaremos la taxonomía
	  array(
		  'hierarchical' => false, 
		  'labels' => $etiquetas, 
		  'show_ui' => true,
		  'show_admin_column' => true,
		  'query_var' => true,
		  'rewrite' => array( 'slug' => 'etiqueta_programa' ),
		  'show_in_rest' => true
	  )
  );
  
}
add_action( 'init', 'crear_taxonomia_programas_etiqueta', 300 );

//Función para añadir campos personalizados al formulario de Añadir nuevo grupo
function grupo_programa_addform_termmeta() {
	wp_nonce_field( 'programa_category_termmeta', 'programa_category_termmeta_nonce' );?>
   
	<div class="form-field grupo-programa-image-wrap">
	  <label for="grupo-programa-image">Imagen destacada</label>
	  <div class="custom_media_item">
		<a href="#" class="button button-primary custom_media_item_upload">Subir imagen</a>
		<input type="hidden" id="grupo-programa-image" name="grupo-programa-image" value="" />
		<img src="" style="max-width:150px;display:none;" />
		<a href="#" class="button button-primary custom_media_item_delete" style="display:none;">Eliminar</a>
	  </div>
	</div> 

	<div class="form-field grupo-programa-order-wrap">
		<label for="grupo-programa-order">Orden del Grupo</label>
		<input type="number" min="0" id="grupo-programa-order" name="grupo-programa-order" value="" />
	</div>	
  <?php
}
add_action( 'grupo_programa_add_form_fields', 'grupo_programa_addform_termmeta' );
  
//Función para añadir campos personalizados al formulario de Editar grupo
function grupo_programa_editform_termmeta( $term ) {
	$category_image = get_term_meta( $term->term_id, 'grupo-programa-image', true );
	$grupo_programa_order = get_term_meta( $term->term_id, 'grupo-programa-order', true );
	
	wp_nonce_field( 'programa_category_termmeta', 'programa_category_termmeta_nonce' );?>
   
	<tr class="form-field grupo-programa-image-wrap">
	  <th scope="row"><label for="grupo-programa-image">Imagen destacada</label></th>
	  <td>
		<div class="custom_media_item">
		  <?php
		  $display = "";
		  if (empty($category_image) || $category_image == "") { $display = 'display:none';}
		  $media_item_src = wp_get_attachment_url( $category_image );?>
   
		  <a href="#" class="button button-primary custom_media_item_upload">Subir imagen</a>
		  <input type="hidden" id="grupo-programa-image" name="grupo-programa-image" value="<?php echo $category_image;?>" />
		  <img src="<?php echo $media_item_src;?>" style="max-width:150px;<?php echo $display;?>" />
		  <a href="#" class="button button-primary custom_media_item_delete" style="<?php echo $display;?>">Eliminar</a>
		</div>
	  </td>
	</tr>
   	<tr class="form-field grupo-programa-order-wrap">
		<th scope="row"><label for="grupo-programa-order">Orden del Grupo</label></th>
		<td>
		<input type="number" min="0" id="grupo-programa-order" name="grupo-programa-order" value="<?php echo $grupo_programa_order;?>" />
		</td>
	</tr>
  <?php 
}
add_action( 'grupo_programa_edit_form_fields', 'grupo_programa_editform_termmeta' );

function grupo_programa_admin_scripts(){
	//Agregamos nuestro JS
	wp_enqueue_script( 'grupo_programa_custom_fields_js', plugin_dir_url(__FILE__) . '/js/custom-fields.js', array('jquery'), '1.0' );
   
	//Añadimos la librería multimedia
	wp_enqueue_media();
}
add_action('admin_print_scripts', 'grupo_programa_admin_scripts');

function grupo_programa_fields_save_data( $term_id ) {
	// Comprobamos si se ha definido el nonce.
	if ( ! isset( $_POST['programa_category_termmeta_nonce'] ) ) {
	  return $term_id;
	}
	$nonce = $_POST['programa_category_termmeta_nonce'];
		
	// Verificamos que el nonce es válido.
	if ( !wp_verify_nonce( $nonce, 'programa_category_termmeta' ) ) {
	  return $term_id;
	}
   
	// Si existen entradas antiguas las recuperamos
	$old_category_image = get_term_meta( $term_id, 'grupo-programa-image', true );
    $old_grupo_programa_order = get_term_meta( $term_id, 'grupo-programa-order', true );

	
   
	// Saneamos lo introducido por el usuario.
	$category_image = sanitize_text_field( $_POST['grupo-programa-image'] );
	$grupo_programa_order = sanitize_text_field( $_POST['grupo-programa-order'] );

   
	// Actualizamos el campo meta en la base de datos.
	update_term_meta( $term_id, 'grupo-programa-image', $category_image, $old_category_image);
	update_term_meta( $term_id, 'grupo-programa-order', $grupo_programa_order ,$old_grupo_programa_order);
  }

  add_action( 'edit_grupo_programa', 'grupo_programa_fields_save_data' );
  add_action( 'create_grupo_programa', 'grupo_programa_fields_save_data' );

function grupo_programa_custom_columns( $columns ) {
	$columns['featured_image'] = "Imagen";
	$columns['order'] = "Orden";
   
	return $columns;
}
add_filter( 'manage_edit-grupo_programa_columns', 'grupo_programa_custom_columns' );
   
function grupo_programa_manage_custom_columns( $out, $column, $term_id ) {
	if ( $column === 'featured_image' ) {
	  $category_image = get_term_meta( $term_id, 'grupo-programa-image', true );
		if (!empty($category_image)) {
		  $media_item_src = wp_get_attachment_image_src( $category_image, "thumbnail" );
		  $return = sprintf( '<img src="%s" width="64"/>', $media_item_src[0] );
		}
	} else if ( $column === 'order' ) {
	  $order = get_term_meta( $term_id, 'grupo-programa-order', true );
		if (!empty($order)) {
		  $return = sprintf( '%s', $order );
		}
	  }   
	return $return;
}
add_filter( 'manage_grupo_programa_custom_column', 'grupo_programa_manage_custom_columns', 400, 3 );
?>
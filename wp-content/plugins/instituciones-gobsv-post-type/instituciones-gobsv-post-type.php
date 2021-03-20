<?php
/**
 * Plugin Name: Servicios Institucionales - Gobierno de  El Salvador
 * Plugin Uri:
 * Description: Añade los Servicios de la Institución con este plugin, deberás agregar una página con la Plantilla "Contenido para Servicios".
 * Version: 1.0.0
 * Author: Secretaría de Innovación de la Presidencia de la República, Desarrollado en la Unidad de Tecnologías de la Información UTIP por Karla Marenco Aguirre, kmarenco@presidencia.gob.sv
 * Author Uri: 
 * Text Domain: Instituciones
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 // Register Custom Post Type
function Servicios() {

	$labels = array(
		'name'                  => _x( 'Servicios', 'Post Type General Name', 'Instituciones' ),
		'singular_name'         => _x( 'Servicio', 'Post Type Singular Name', 'Instituciones' ),
		'menu_name'             => __( 'Servicios Institucionales', 'Instituciones' ),
		'name_admin_bar'        => __( 'Servicios Institucionales', 'Instituciones' ),
		'archives'              => __( 'Lista de Servicion', 'Instituciones' ),
		'attributes'            => __( 'Item Attributes', 'Instituciones' ),
		'parent_item_colon'     => __( 'Servicio Padre:', 'Instituciones' ),
		'all_items'             => __( 'Todos los Servicios', 'Instituciones' ),
		'add_new_item'          => __( 'Añadir Servicio', 'Instituciones' ),
		'add_new'               => __( 'Añadir Servicio', 'Instituciones' ),
		'new_item'              => __( 'Nuevo Servicio', 'Instituciones' ),
		'edit_item'             => __( 'Editar Servicio', 'Instituciones' ),
		'update_item'           => __( 'Actualizar Servicio', 'Instituciones' ),
		'view_item'             => __( 'Ver Servicio', 'Instituciones' ),
		'view_items'            => __( 'Ver Servicios', 'Instituciones' ),
		'search_items'          => __( 'Buscar Servicio', 'Instituciones' ),
		'not_found'             => __( 'No encontrado', 'Instituciones' ),
		'not_found_in_trash'    => __( 'No encontrado en la papelera', 'Instituciones' ),
		'featured_image'        => __( 'Imagen destacada', 'Instituciones' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'Instituciones' ),
		'remove_featured_image' => __( 'Eliminar imagen destacada', 'Instituciones' ),
		'use_featured_image'    => __( 'Usar como imagen destacada', 'Instituciones' ),
		'insert_into_item'      => __( 'Agregar elemento', 'Instituciones' ),
		'uploaded_to_this_item' => __( 'Subido a este Servicio', 'Instituciones' ),
		'items_list'            => __( 'Lista de Servicios', 'Instituciones' ),
		'items_list_navigation' => __( 'Lista de navegación de Servicios', 'Instituciones' ),
		'filter_items_list'     => __( 'Filtrar lista de Servicios', 'Instituciones' ),
	);
	$args = array(
		'label'                 => __( 'Servicio', 'Instituciones' ),
		'description'           => __( 'Descripción del Servicio', 'Instituciones' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
		'taxonomies'            => array( 'grupo', 'etiqueta_servicio' ),
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
		'show_in_rest'          => true,
	);
	register_post_type( 'Servicios', $args );

}
add_action( 'init', 'Servicios', 0 );


// Función para crear una taxonomía jerarquica para los servicios
function crear_taxonomia_servicios_grupo() {

	$categorias = array(
	  'name' => __( 'Grupos Servicios' ),
	  'singular_name' => __( 'Grupo Servicio' ),
	  'search_items' =>  __( 'Buscar grupo' ),
	  'all_items' => __( 'Todos los grupos' ),
	  'parent_item' => __( 'Grupo padre' ),
	  'parent_item_colon' => __( 'Grupo padre:' ),
	  'edit_item' => __( 'Editar grupo' ), 
	  'update_item' => __( 'Actualizar grupo' ),
	  'add_new_item' => __( 'Agregar un nuevo grupo' ),
	  'menu_name' => __( 'Grupo Servicio' ),
  ); 	
  
  
  register_taxonomy(
	  'grupo',
	  array('servicios'), // Tipos de Post a los que asociaremos la taxonomía
	  array(
		  'hierarchical' => true, 
		  'labels' => $categorias, 
		  'show_ui' => true,
		  'show_admin_column' => true,
		  'query_var' => true,
		  'rewrite' => array( 'slug' => 'grupo' ),
		  'show_in_rest' => true,
	  )
  );
  
  }
  add_action( 'init', 'crear_taxonomia_servicios_grupo', 0 );

// Función para crear una taxonomía no jerarquica para los servicios
function crear_taxonomia_servicios_etiqueta() {

	$etiquetas = array(
	  'name' => __( 'Etiqueta Servicios' ),
	  'singular_name' => __( 'Etiqueta Servicio' ),
	  'search_items' =>  __( 'Buscar etiqueta' ),
	  'all_items' => __( 'Todos los etiquetas' ),
	  'parent_item' => __( 'Grupo padre' ),
	  'parent_item_colon' => __( 'Grupo padre:' ),
	  'edit_item' => __( 'Editar etiqueta' ), 
	  'update_item' => __( 'Actualizar etiqueta' ),
	  'add_new_item' => __( 'Agregar una nueva etiqueta' ),
	  'menu_name' => __( 'Etiqueta Servicio' ),
  ); 	
  
  
  register_taxonomy(
	  'etiqueta_servicio',
	  array('servicios'), // Tipos de Post a los que asociaremos la taxonomía
	  array(
		  'hierarchical' => false, 
		  'labels' => $etiquetas, 
		  'show_ui' => true,
		  'show_admin_column' => true,
		  'query_var' => true,
		  'rewrite' => array( 'slug' => 'etiqueta_servicio' ),
		  'show_in_rest' => true,
	  )
  );
  
  }
  add_action( 'init', 'crear_taxonomia_servicios_etiqueta', 0 );

//Función para añadir campos personalizados al formulario de Añadir nuevo grupo
function my_category_addform_termmeta() {
	wp_nonce_field( 'my_category_termmeta', 'my_category_termmeta_nonce' );?>
   
	<div class="form-field category-image-wrap">
	  <label for="category-image">Imagen destacada</label>
	  <div class="custom_media_item">
		<a href="#" class="button button-primary custom_media_item_upload">Subir imagen</a>
		<input type="hidden" id="category-image" name="category-image" value="" />
		<img src="" style="max-width:150px;display:none;" />
		<a href="#" class="button button-primary custom_media_item_delete" style="display:none;">Eliminar</a>
	  </div>
	</div> 

	<div class="form-field grupo-servicio-order-wrap">
		<label for="grupo-servicio-order">Orden del Grupo</label>
		<input type="number" min="0" id="grupo-servicio-order" name="grupo-servicio-order" value="" />
	</div>	
  <?php
}
add_action( 'grupo_add_form_fields', 'my_category_addform_termmeta' );
  
//Función para añadir campos personalizados al formulario de Editar grupo
function my_category_editform_termmeta( $term ) {
	$category_image = get_term_meta( $term->term_id, 'category-image', true );
	$grupo_servicio_order = get_term_meta( $term->term_id, 'grupo-servicio-order', true );
	
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
	<tr class="form-field grupo-servicio-order-wrap">
		<th scope="row"><label for="grupo-servicio-order">Orden del Grupo</label></th>
		<td>
		<input type="number" min="0" id="grupo-servicio-order" name="grupo-servicio-order" value="<?php echo $grupo_servicio_order;?>" />
		</td>
	</tr>  	
  <?php }
  add_action( 'grupo_edit_form_fields', 'my_category_editform_termmeta' );

  function my_admin_scripts(){
	//Agregamos nuestro JS
	wp_enqueue_script( 'my_custom_fields_js', plugin_dir_url(__FILE__) . '/js/custom-fields.js', array('jquery'), '1.0' );
   
	//Añadimos la librería multimedia
	wp_enqueue_media();
  }
  add_action('admin_print_scripts', 'my_admin_scripts');

  function my_category_fields_save_data( $term_id ) {
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
	$old_category_image = get_term_meta( $term_id, 'category-image', true );
	$old_grupo_servicio_order = get_term_meta( $term_id, 'grupo-servicio-order', true );
	
   
	// Saneamos lo introducido por el usuario.
	$category_image = sanitize_text_field( $_POST['category-image'] );
	$grupo_servicio_order = sanitize_text_field( $_POST['grupo-servicio-order'] );
	
   
// Actualizamos el campo meta en la base de datos.
	update_term_meta( $term_id, 'category-image', $category_image, $old_category_image );
	update_term_meta( $term_id, 'grupo-servicio-order', $grupo_servicio_order ,$old_grupo_servicio_order);
  }

  add_action( 'edit_grupo', 'my_category_fields_save_data' );
  add_action( 'create_grupo', 'my_category_fields_save_data' );



  function my_custom_category_columns( $columns ) {
	$columns['featured_image'] = "Imagen";
	$columns['order'] = "Orden";
   
	return $columns;
  }
  add_filter( 'manage_edit-grupo_columns', 'my_custom_category_columns' );
   
  function my_category_image_column( $out, $column, $term_id ) {
	if ( $column === 'featured_image' ) {
	  $category_image = get_term_meta( $term_id, 'category-image', true );
		if (!empty($category_image)) {
		  $media_item_src = wp_get_attachment_image_src( $category_image, "thumbnail" );
		  $return = sprintf( '<img src="%s" width="64">', $media_item_src[0] );
		}
	} else if ( $column === 'order' ) {
	  $order = get_term_meta( $term_id, 'grupo-servicio-order', true );
		if (!empty($order)) {
		  $return = sprintf( '%s', $order );
		}
	  }   
	return $return;
  }
  add_filter( 'manage_grupo_custom_column', 'my_category_image_column', 10, 3 );
  
?>
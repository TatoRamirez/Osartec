<?php 
/**
 * Template Name: Contenido para Servicios
 */
get_header();
while ( have_posts() ): the_post();

#LISTANDO BOTONES GRUPO DE SERVICIOS
$taxonomy = 'grupo';
$args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'number'            => '', 
    'fields'            => 'all', 
    'slug'              => '',
    'parent'            => '',
    'hierarchical'      => true, 
 ); 
$i=0; 
$tax_terms = get_terms($taxonomy, $args);
$preguntas = myprefix_get_theme_option('preguntas');
?>
<div class="bloc d-flex bgc-white l-bloc" id="iconos-2">
	<div class="container none bloc-sm">
		<div class="row">
			<div class="col-12">
				<h1 class="servicios-title">
					<?php the_title();?>
				</h1>
			</div>
		</div>
		<div class="row"><!-- mt-2 mb-5-->
			<div class="col-12">
				<h3 class="servicios-title text-uppercase">
					Servicios Destacados
				</h3>
			</div>
		</div>
		<!--div class="row">			
			<?php
			foreach($tax_terms as $tax_term){         
				$grupo = $tax_term->term_id;
				$nombre_grupo = $tax_term->name;
				$slug_grupo=$tax_term->slug;
				$id_imagen_grupo = get_term_meta( $grupo, 'category-image', true);
				$img_grupo_thumbnail = wp_get_attachment_url($id_imagen_grupo);
				$i++;
				$args1 = array(
					'posts_per_page'   => -1,
					'post_type' => 'servicios',
					'orderby'    => 'ID',
					'tax_query' => array( 
						array(
							'taxonomy'  => 'grupo',
							'field' => 'slug',
							'terms' => $slug_grupo,
						),
					),
					'post_status' => 'publish',
					'order'    => 'ASC'
				);
				$result = new WP_Query( $args1 );
				if ( $result-> have_posts() ){

					while ( $result->have_posts() ) : $result->the_post();   						
						$id_post = get_the_ID();        						
						$id_class.= $id_post.'-'.$i.',';         
					endwhile;	
				}

			?>
			<iconos-2>
			<div class="col-md-4 col-4">
				<a href="#" data-toggle-visibility="<?php echo $grupo;?>-img,<?php echo $id_class;?>">
				<img src="<?php echo $img_grupo_thumbnail;?>" data-src="<?php echo $img_grupo_thumbnail;?>" class="img-fluid img-116-style mx-auto d-block lazyload" alt="servicio5p" id="icon1" /></a>
				<h4 class="text-center h4-bloc-11-style mx-auto d-block text-lg-center mg-sm tc-black text-md-center text-sm-center" id="titulo-icon1">
					<?php echo $nombre_grupo;?>
				</h4>

				<img src="<?php bloginfo('template_directory');?>/img/lazyload-ph.png" data-src="<?php bloginfo('template_directory');?>/img/sep1p.png" class="img-fluid mx-auto object-hidden animated fadeIn animDelay02 mg-md lazyload" alt="sep1p" id="<?php echo $grupo;?>-img" data-appear-anim-style="fadeIn" />				
				<?php
				$args2 = array(
					'post_type' => 'servicios',
					'orderby'    => 'ID',
					'tax_query' => array( 
						array(
							'taxonomy'  => 'grupo',
							'field' => 'slug',
							'terms' => $slug_grupo,
						),
					),
					'post_status' => 'publish',
					'order'    => 'ASC'
				);
				$result = new WP_Query( $args2 );
				if ( $result-> have_posts() ){

					while ( $result->have_posts() ) : $result->the_post();   
						$id_post = get_the_ID();        
						$id_link =  $id_post.'-'.$i;                        
				?>
				<div class="row">
					<div class="col">
						<div class="text-center">
						<a href="<?php the_permalink();?>" class="a-btn object-hidden text-lg-center ltc-black" id="<?php echo $id_link;?>"><?php the_title();?></a>
						</div>
					</div>
				</div>
				<?php
					endwhile;
				}
				?>	
				<br/>
			</div>												
			<?php		
			$id_class='';		
			}
			?>	
		</div-->
		<div class="row servicios-destacados"><!-- ml-5 mr-5 -->
			<div class="col d-flex flex-column align-content-stretch">
				<div class="d-flex col">
					<div class="container my-auto">
						<div class="row">
							<?php
								foreach($tax_terms as $tax_term){         
									$grupo = $tax_term->term_id;
									$nombre_grupo = $tax_term->name;
									$slug_grupo=$tax_term->slug;
									$id_imagen_grupo = get_term_meta( $grupo, 'category-image', true);
									$img_grupo_thumbnail = wp_get_attachment_url($id_imagen_grupo);
									$i++;
									$args1 = array(
										'posts_per_page'   => -1,							
										'post_type' => 'servicios',
										'orderby'    => 'ID',
										'tax_query' => array( 
											array(
												'taxonomy'  => 'grupo',
												'field' => 'slug',
												'terms' => $slug_grupo,
											),
										),
										'post_status' => 'publish',
										'order'    => 'ASC'
									);
									$result = new WP_Query( $args1 );
									if ( $result-> have_posts() ){
										while ( $result->have_posts() ) : 
											$result->the_post();   						
											$id_post = get_the_ID();        						
											$id_class.= $id_post.'-'.$i.',';         
										endwhile;	
									}
							?>
							<div class="col-xs col-sm col-md col-lg mt-3 mb-3">			
								<div class="a-btn text-lg-center ltc-black servicios-link" id="<?php echo $id_link;?>">
									<img src="<?php echo $img_grupo_thumbnail;?>" data-src="<?php echo $img_grupo_thumbnail;?>" class="img-fluid img-116-style mx-auto d-block lazyload" alt="servicio5p" id="icon<?php echo $i;?>" />
								</div>
								<h4 class="text-center h4-bloc-11-style mx-auto d-block text-lg-center mg-sm tc-black text-md-center text-sm-center" id="titulo-icon-<?php echo $i;?>">
									&nbsp;<!--<?php echo $nombre_grupo;?>--> 
								</h4>
									<?php									
									$args2 = array(
										'posts_per_page'   => -1,							
										'post_type' => 'servicios',
										'orderby'    => 'ID',
										'tax_query' => array( 
											array(
												'taxonomy'  => 'grupo',
												'field' => 'slug',
												'terms' => $slug_grupo,
											),
										),
										'post_status' => 'publish',
										'order'    => 'ASC',
									);
									$result = new WP_Query( $args2 );
									if ( $result-> have_posts() ){
										while ( $result->have_posts() ) : 
											$result->the_post();   
											$id_post = get_the_ID();        
											$id_link =  $id_post.'-'.$i;
											$tags = the_tags();
										    $isBookMarked =  FALSE;
											$terms = get_the_terms($id_post, 'etiqueta_servicio' );
                         					if ( $terms && ! is_wp_error( $terms ) ) : 
     											foreach ( $terms as $term ) {
        											if(trim(strtoupper($term->name)) == "DESTACADO"){
														$isBookMarked = TRUE;
														break;
													} 
												}
											endif;								
											if($isBookMarked == true){
									?>
									<div class="row">
										<div class="col">
											<div class="text-center">
												
												<h6 class="servicios-destacados-title"> 
												<a href="<?php the_permalink();?>" id="<?php echo $id_link;?>"><!-- class="servicios-link font-weight-bold"  a-btn text-lg-center ltc-black -->
												<?php the_title();?>
												</a>
												</h6>
												<?php 
												/*
												<h6 class="servicios-destacados-title">									
												<?php 
													remove_filter( 'the_excerpt', 'wpautop' );
													echo get_the_excerpt();
												?>
												</h6>
												*/
												?>
													
											</div>
										</div>
									</div>
									<?php
											}
										endwhile;
									}
									?>	
							</div>												
							<?php		
									$id_class='';		
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="row ml-5 mr-5 mt-4">
			<div class="container-fluid">	
			<?php
				$i=0;
				$terms_id = array();
				$terms_order = array();
				$k = 0;
				foreach($tax_terms as $term) {
					$grupo_id = $term->term_id;
					$terms_id[$k] = $term->term_id;
				    $grupo_servicio_order = get_term_meta($grupo_id, 'grupo-servicio-order', true);
					$terms_order[$k] = intval($grupo_servicio_order);
					$k = $k+1;
				}
				array_multisort($terms_order, $terms_id);
				$newterms = array(); 
			 	$preorder = 1;
				$k=0;
				foreach($terms_id as $id) {
					foreach($tax_terms as $term) {
						$grupo_id = $term->term_id;
						if($id==$grupo_id){
							$grupo_servicio_order = get_term_meta($grupo_id, 'grupo-servicio-order', true);
							$newterms[$k] = $term;
						}
					}
					$k = $k + 1;
				}
				ksort( $newterms, SORT_NUMERIC );
				foreach($newterms as $tax_term){         
					$grupo = $tax_term->term_id;
					$nombre_grupo = $tax_term->name;
					$slug_grupo=$tax_term->slug;
					$id_imagen_grupo = get_term_meta( $grupo, 'category-image', true);
					$img_grupo_thumbnail = wp_get_attachment_url($id_imagen_grupo);
					$i++;
					$args1 = array(
						'posts_per_page'   => -1,
						'post_type' => 'servicios',
						'orderby'    => 'ID',
						'tax_query' => array( 
								array(
									'taxonomy'  => 'grupo',
									'field' => 'slug',
									'terms' => $slug_grupo,
								),
							),
							'post_status' => 'publish',
							'order'    => 'ASC'
						);
					$result = new WP_Query( $args1 );
					if ( $result-> have_posts() ){
						while ( $result->have_posts() ) : 
							$result->the_post();   						
							$id_post = get_the_ID();        						
							$id_class.= $id_post.'-'.$i.',';         
							endwhile;	
					}
			?>
				<div class="row-fluid">
        			<div class="row mt-4 mb-2">
            			<div class="col">
                			<h3 class="servicios-group text-center text-sm-center text-md-left text-lg-left text-xl-left"><?php echo $nombre_grupo;?></h3>
            			</div>
        			</div>
        			<div class="row justify-content-center">
					<?php
						$args2 = array(
							'posts_per_page'   => -1,
							'post_type' => 'servicios',
							'orderby'    => 'ID',
							'tax_query' => array( 
									array(
										'taxonomy'  => 'grupo',
										'field' => 'slug',
										'terms' => $slug_grupo,
									),
								),
							'post_status' => 'publish',
							'order'    => 'ASC'
						);
						$result = new WP_Query( $args2 );
						if ( $result-> have_posts() ){
							while ( $result->have_posts() ) : 
								$result->the_post();   
								$id_post = get_the_ID();        
								$id_link =  $id_post.'-'.$i;                        
					?>
            			<div class="col-sm-4 pt-4 pb-4 mt-2 mb-2">
							
                        		<h6 class="servicios-name text-center">
									<a href="<?php the_permalink();?>" class="text-lg-center" id="<?php echo $id_link;?>"><!-- class="a-btn  ltc-black"-->
									<?php the_title();?>
									</a>
								</h6>
								<?php
								/*
								<h6 class="servicios-name text-center">									
									<?php 
										remove_filter( 'the_excerpt', 'wpautop' );
										echo get_the_excerpt();
									?>
								</h6>
								*/
								?>
							
            			</div>
						<?php endwhile;	}?>							
        			</div>
    			</div>
				<?php $id_class='';}?>
			</div>
		</div>
		<div class="row mt-4 mb-4">
		</div>
		<div class="row mt-4 mb-2">
			<div class="col-12">
				<h4 class="servicios-title">
					¿Tiene dudas?
				</h4>
			</div>
		</div>
		<div class="row mt-2 mb-4">
			<div class="col-12">
				<h6 class="servicios-title">
					Visita nuestras <a href="<?php echo $preguntas; ?>" class="servicios-title">preguntas frecuentes aquí</a>
				</h6>
			</div>
		</div>		
	</div>
</div>
<?php
endwhile;
get_footer();
?>
<?php 
/**
 * Template Name: Contenido para Programas
 */
get_header();
while ( have_posts() ): the_post();

#LISTANDO BOTONES GRUPO DE SERVICIOS
$taxonomy = 'grupo_programa';
$args = array(
    'orderby'           => 'ID', 
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
		<div class="row mt-4 mb-2">
			<div class="col-12">
				<h1 class="servicios-title">
					<?php the_title();?>
				</h1>
			</div>
		</div>
		<div class="row mt-4 mb-2">
			<div class="col-12">
				<h3 class="servicios-title">
					Programas Destacados
				</h3>
			</div>
		</div>
		<div class="row ml-5 mr-5 justify-content-center servicios-destacados">
		<?php									
			$args2 = array(
				'posts_per_page'   => -1,							
					'post_type' => 'programas',
					'orderby'    => 'ID',										
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
				    $isBookMarked =  false;
					$terms = get_the_terms($id_post, 'etiqueta_programa' );
        			if ( $terms && ! is_wp_error( $terms ) ) : 
     					foreach ( $terms as $term ) {
        					if(trim(strtoupper($term->name)) == "DESTACADO"){
								$isBookMarked = TRUE;
								break;
							} 
						}
					endif;	               							
					if($isBookMarked){
		?>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mt-4 mb-2">
			<div class="container-fluid justify-content-center">
				<div class="row justify-content-center">
				<?php 
						if ( has_post_thumbnail() ) {
    						the_post_thumbnail('thumbnail', array( 'class' => 'circle-image mb-3'));
						} 
				?>
				</div>
				<div class="row justify-content-center">
					
						<h6 class="servicios-destacados-title">
							<a href="<?php the_permalink();?>" id="<?php echo $id_link;?>"> <!--class="a-btn text-center text-lg-center ltc-black" -->
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
	<div class="row ml-5 mr-5 mt-4 mb-2">
		<div class="container-fluid">	
			<?php
				$i=0; 
				$terms_id = array();
				$terms_order = array();
				$k = 0;
				foreach($tax_terms as $term) {
					$grupo_id = $term->term_id;
					$terms_id[$k] = $term->term_id;
				    $grupo_programa_order = get_term_meta($grupo_id, 'grupo-programa-order', true);
					$terms_order[$k] = intval($grupo_programa_order);
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
							$grupo_programa_order = get_term_meta($grupo_id, 'grupo-programa-order', true);
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
					$id_imagen_grupo = get_term_meta( $grupo, 'grupo-programa-image', true);
					$img_grupo_thumbnail = wp_get_attachment_url($id_imagen_grupo);
					$i++;
					$args1 = array(
						'posts_per_page'   => -1,
						'post_type' => 'programas',
						'orderby'    => 'ID',
						'tax_query' => array( 
								array(
									'taxonomy'  => 'grupo_programa',
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
			<div class="row mt-2"><a name="<?php echo $slug_grupo;?>"></a></div>
				<div class="row-fluid">
        			<div class="row mb-2">
            			<div class="col">
                			<h3 class="servicios-group text-center text-xs-center text-sm-center text-md-left text-lg-left">
								<?php echo $nombre_grupo;?>
							</h3>
            			</div>
        			</div>
        			<div class="row">
					<?php
						$args2 = array(
							'posts_per_page'   => -1,
							'post_type' => 'programas',
							'orderby'    => 'ID',
							'tax_query' => array( 
									array(
										'taxonomy'  => 'grupo_programa',
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
						if(trim(strtoupper($slug_grupo))=="NUESTRAS-ALIANZAS"){
							?>
							<div class="col-12 mt-4"></div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 my-auto text-center text-xs-center text-sm-center text-md-left text-lg-left">
									<a href="<?php the_permalink();?>" class="servicio-name text-xs-center text-sm-center text-md-left text-lg-left" id="link-icon-alianza-<?php echo $id_link;?>">
									<?php 
										if ( has_post_thumbnail() ) {
											the_post_thumbnail('thumbnail', array( 'class' => 'rounded-corners-image'));
									} ?>
									</a>
								</div>						
								<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 alianza-name-box text-xs-center text-sm-center text-md-left text-lg-left">							
									
										<h4 class="ml-2 servicios-name  text-center text-xs-center text-sm-center text-md-left text-lg-left">
											<a href="<?php the_permalink();?>" id="link-title-alianza-<?php echo $id_link;?>">
											<?php the_title();?>
											</a>
										</h4>
										
										<h6 class="ml-2 servicios-name-nohover text-justify"> 
										<?php 
											remove_filter( 'the_excerpt', 'wpautop' );
											echo get_the_excerpt();
										?>
										</h6>
									
									
								</div>
							<div class="col-12 mt-4"></div>
						<?php
						}else{
						?>				
							<div class="col-sm-4 pt-4 pb-4 mt-4 mb-4 ">
								
									<h6 class="servicios-name text-center">
										<a href="<?php the_permalink();?>" class="text-center" id="link-title-<?php echo $id_link;?>">
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
						<?php }
						   endwhile;	
						}?>
						<div class="col-12 mt-0"></div>
        			</div>
    			</div>
				<div class="row mt-0"></div>
				<?php 
					$id_class='';
				}?>
			</div>
		</div>
	</div>
</div>
<?php
endwhile;
get_footer();
?>
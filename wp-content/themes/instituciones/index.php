<?php get_header();?>

<?php // bloginfo('rss_url'); ?>
<!-- bloc-1 -->
<div class="bloc full-width-bloc l-bloc" id="bloc-1">
	<div class="container ">
		<div class="row voffset-clear-xs no-gutters">
			<div class="col-12 l-bloc">
				<div class="text-center">
					<div id="carrusel-principal" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carrusel-principal" data-slide-to="0" class="active">
							</li>
							<li data-target="#carrusel-principal" data-slide-to="1">
							</li>
							<li data-target="#carrusel-principal" data-slide-to="2">
							</li>
						</ol>
						<div class="carousel-inner" role="listbox">
						<?php
							$args = array(
								'post_type'=> 'post',
								'orderby'    => 'date',
								'category_name'    => 'Carrusel Principal',
								'post_status' => 'publish',
								'order'    => 'DESC',
								'posts_per_page' => 3 
							);
							$result = new WP_Query( $args );
							if ( $result-> have_posts() ){
								$i = 0;								
								$class = '';
								while ( $result->have_posts() ) : $result->the_post();
								
									$image_carrusel = wp_get_attachment_image_src( get_post_thumbnail_id( $result->ID ), array( 1200, 400 ) )[0];									
									if ($i == 0)
									{
										$class = 'active';
									}
									else
									{
										$class = '';
									}
							?>

							<div class="carousel-item gradiente <?php echo $class;?>"  ><!-- style="background: transparent url("<?php echo $image_carrusel;?>") no-repeat top center fixed;"-->
								<!--<img class="d-inline-block w-100 carusel-cover" style="background: transparent url("<?php echo $image_carrusel;?>") no-repeat top center fixed;" alt="slide 1" src="<?php echo $image_carrusel;?>"/>-->
								<img class="d-inline-block w-100" alt="slide 1" src="<?php echo $image_carrusel;?>"/>
								
								<!--<div class="carousel-caption d-none d-md-block">
									<h1 class="titleh1gobsv "><?php echo get_the_title();?></h1>
									<p class="titleh1gobsv"><?php echo get_the_date().". ".get_the_excerpt();;?></p> 
								</div>-->
								
							</div>							
							<?php
								$i++;
								endwhile;
							}
							?>
						</div>
						<a class="carousel-nav-controls carousel-control-prev" href="#carrusel-principal" role="button" data-slide="prev">
						<span class="fa fa-chevron-left"></span><span class="sr-only">Anterior</span></a>
						<a class="carousel-nav-controls carousel-control-next" href="#carrusel-principal" role="button" data-slide="next">
						<span class="fa fa-chevron-right"></span><span class="sr-only">Siguiente</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- bloc-1 END -->

<!-- ScrollToTop Button -->
<a class="bloc-button btn btn-d scrollToTop" onclick="scrollToTarget('1',this)"><span class="fa fa-chevron-up"></span></a>
<!-- ScrollToTop Button END-->

<!-- avisos-panel -->

<!-- bloc-noticias -->
<?php
$titulo_longitud = myprefix_get_theme_option( 'input_title_len' );
$slug = myprefix_get_theme_option( 'seccion_especial' );
if($slug<>""){
	$cat = get_category_by_slug($slug); 
	$category_id = $cat->term_id;


	$category_link = get_category_link( $category_id );
	?> 
	<div class="bloc none full-width-bloc l-bloc" id="bloc-2">
		<div class="container shadow-index bloc-sm shortcut-caption">
			<a href="<?php echo get_category_link($category_id);?>" class="row justify-content-center pulse-hvr lazyloaded animated">
			<div>
				<div class="row">
					<div class="col mt-2 mb-2">
						<img src="<?php echo get_site_url();?>/wp-content/themes/instituciones/img/Servicios.svg" data-src="<?php echo get_site_url();?>/wp-content/themes/instituciones/img/Servicios.svg" alt="Nombre de la Sección" id="NombreSeccion" data-appear-anim-style="puffIn" class="img-fluid mx-auto d-block img-icono-avisos-style pulse-hvr lazyloaded animated  float-md-right" style="visibility: visible;">
					</div>
					<div class="col my-auto">
						<h4 class="text-white text-center text-nowrap section-title"><?php echo mb_strtoupper (get_cat_name($category_id));?></h4> 
					</div>
				</div>
			</div>
			</a>
		</div>
	</div>
	<!-- bloc-4 END -->
	<?php 
	$cat_special=get_cat_name($category_id);
	?>	
	<div class="container-fluidsv">
		<?php
		$args = array(
		'post_type'=> 'post',
		'orderby'    => 'date',
		'category_name'    => $slug,
		'post_status' => 'publish',
		'order'    => 'DESC',
		'posts_per_page' => 3,				
		);
		$result = new WP_Query( $args );
	 
		if ( $result-> have_posts() ){
			$i = 0;
			$class = '';
			?>
			<div class="card-group vertical-gobsvpostinfo-style">
			<?php
				$i=0;
					while ( $result->have_posts() ) : $result->the_post();
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $result->ID ), 'single-post-thumbnail' );
						$thumbnail_details = get_posts(array('p' => get_post_thumbnail_id( $result->ID ), 'post_type' => 'attachment'));
						//$titulo =  $thumbnail_details[0]->post_title;
						$leyenda = $thumbnail_details[0]->post_excerpt;
						$titulo=get_the_title();//echo $titulo;
			
						if(strlen($titulo)>$titulo_longitud){
							$titulo=substr($titulo,0,$titulo_longitud)."...";
						} 
						?>
						
						<div class="card text-white post-thumbnail">
							
							<div class="gobsvpostinfo-date">
								<a title="<?php echo get_the_time( 'g:i a' );?>" href="<?php the_permalink();?>" rel="nofollow">
								<span class="entry-month"><?php echo get_the_date( 'M' );?></span>
								<span class="entry-date updated"><?php echo get_the_date( 'd' );?></span>
								<span class="entry-year"><?php echo get_the_date( 'Y' );?></span>
								</a>
							</div> 

							<a href="<?php the_permalink();?>">
							<figure>
								<img class="card-img card-imgsv" src="<?php echo $image[0]; ?>" alt="Card image cap">
							</figure>
							
							<div class="card-img-overlaysv">
							  <h5 class="card-title text-center text-white">
							  <?php //the_title();
							  $titulo=get_the_title();//echo $titulo;
							  if(strlen($titulo)>$titulo_longitud){
								  $titulo=substr($titulo,0,$titulo_longitud)."...";
							  }
							  echo $titulo;
							  ?>
							  
							  </h5>
							  <!--<p class="card-text"></p>-->
							</div>
							<!--<div class="card-footer">
							  <small class="text-muted"></small>
							</div>-->
							</a>
							
							
						</div>
						
					
						<?php
						$i++;
						if($i == 3){
						?>
						</div>
						<div class="card-group">
						<?php
						   $i=0;			
						}
					endwhile;
		}
		?>
	</div>
	</div>
	 
<?php
}
?>

<!-- bloc-reglamentos -->
<?php
$slug = 'reglamentos';
$cat = get_category_by_slug($slug); 
$category_id = $cat->term_id;
// Get the ID of a given category
//$category_id = get_cat_ID( 'Noticias' );
 
// Get the URL of this category
$category_link = get_category_link( $category_id );
?> 
<div class="bloc none full-width-bloc l-bloc" id="bloc-3">
	<div class="container shadow-index bloc-sm shortcut-caption">
				<a href="<?php echo get_category_link($category_id);?>" class="row justify-content-center pulse-hvr lazyloaded animated">
    					<div>
    <div class="row">
<div class="col mt-2 mb-2">
							<img src="<?php echo get_site_url();?>/wp-content/themes/instituciones/img/Noticias.svg" data-src="<?php echo get_site_url();?>/wp-content/themes/instituciones/img/Noticias.svg" alt="Noticias" id="Sección" data-appear-anim-style="puffIn" class="img-fluid mx-auto d-block img-icono-noticias-style pulse-hvr lazyloaded animated" style="visibility: visible;">
						</div>
						 <div class="col my-auto">
							 <h4 class="text-white text-center text-nowrap section-title"><?php echo mb_strtoupper (get_cat_name($category_id));?></h4> 
						</div>
    </div>
                  </div>
				</a>
	</div>
</div>
<!-- bloc-4 END -->

<div class="container-fluidsv">
	<?php
	$args = array(
	'post_type'=> 'post',
	'orderby'    => 'date',
	'category_name'    => get_cat_name($category_id),
	'post_status' => 'publish',
	'order'    => 'DESC',
	'posts_per_page' => 3,				
	);
	$result = new WP_Query( $args );
	if ( $result-> have_posts() ){
		$i = 0;
		$class = '';
?>
<div class="card-group vertical-gobsvpostinfo-style">
<?php
	$i=0;
	$l1=0;
		while ( $result->have_posts() ) : $result->the_post();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $result->ID ), 'single-post-thumbnail' );
			$thumbnail_details = get_posts(array('p' => get_post_thumbnail_id( $result->ID ), 'post_type' => 'attachment'));
			//$titulo =  $thumbnail_details[0]->post_title;
			$leyenda = $thumbnail_details[0]->post_excerpt;
			$titulo=get_the_title();//echo $titulo;
			
			if(strlen($titulo)>$titulo_longitud){
				$titulo=substr($titulo,0,$titulo_longitud)."...";
			} 
			

			?>
			
			<div class="card text-white post-thumbnail">
				<div class="gobsvpostinfo-date">
					<a title="<?php echo get_the_time( 'g:i a' );?>" href="<?php the_permalink();?>" rel="nofollow">
					<span class="entry-month"><?php echo get_the_date( 'M' );?></span>
					<span class="entry-date updated"><?php echo get_the_date( 'd' );?></span>
					<span class="entry-year"><?php echo get_the_date( 'Y' );?></span>
					</a>
				</div> 
				<?php 
				/*
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
				?>
				<span class="gobsvpostinfo-categories">
					<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) );?>" rel="category tag"><?php echo esc_html( $categories[0]->name );?></a>
				</span> 
				<?php
				}
				*/
				?>
				<a href="<?php the_permalink();?>">
				<figure>
					<img class="card-img card-imgsv" src="<?php echo $image[0]; ?>" alt="Card image cap">
				</figure>
				
				<div class="card-img-overlaysv">
				  <h5 class="card-title text-center text-white"><?php 
				  
				  echo $titulo;
				  ?>
				  </h5>
				  <!--<p class="card-text"></p>-->
				</div>
				<!--<div class="card-footer">
				  <small class="text-muted"></small>
				</div>-->
				</a>
			</div>
			
		
			<?php
			$i++;
			if($i == 3){
			?>
			</div>
			<div class="card-group vertical-gobsvpostinfo-style">
			<?php
               $i=0;			
			}
		endwhile;
	}
	
	?>
</div>
</div>

<!-- bloc-noticias -->
<?php
$slug = 'noticias';
$cat = get_category_by_slug($slug); 
$category_id = $cat->term_id;
// Get the ID of a given category
//$category_id = get_cat_ID( 'Noticias' );
 
// Get the URL of this category
$category_link = get_category_link( $category_id );
?> 
<div class="bloc none full-width-bloc l-bloc" id="bloc-3">
	<div class="container shadow-index bloc-sm shortcut-caption">
				<a href="<?php echo get_category_link($category_id);?>" class="row justify-content-center pulse-hvr lazyloaded animated">
    					<div>
    <div class="row">
<div class="col mt-2 mb-2">
							<img src="<?php echo get_site_url();?>/wp-content/themes/instituciones/img/Noticias.svg" data-src="<?php echo get_site_url();?>/wp-content/themes/instituciones/img/Noticias.svg" alt="Noticias" id="Sección" data-appear-anim-style="puffIn" class="img-fluid mx-auto d-block img-icono-noticias-style pulse-hvr lazyloaded animated" style="visibility: visible;">
						</div>
						 <div class="col my-auto">
							 <h4 class="text-white text-center text-nowrap section-title"><?php echo mb_strtoupper (get_cat_name($category_id));?></h4> 
						</div>
    </div>
                  </div>
				</a>
	</div>
</div>
<!-- bloc-4 END -->

<div class="container-fluidsv">
	<?php
	$args = array(
	'post_type'=> 'post',
	'orderby'    => 'date',
	'category_name'    => get_cat_name($category_id),
	'post_status' => 'publish',
	'order'    => 'DESC',
	'posts_per_page' => 3,				
	);
	$result = new WP_Query( $args );
	if ( $result-> have_posts() ){
		$i = 0;
		$class = '';
?>
<div class="card-group vertical-gobsvpostinfo-style">
<?php
	$i=0;
	$l1=0;
		while ( $result->have_posts() ) : $result->the_post();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $result->ID ), 'single-post-thumbnail' );
			$thumbnail_details = get_posts(array('p' => get_post_thumbnail_id( $result->ID ), 'post_type' => 'attachment'));
			//$titulo =  $thumbnail_details[0]->post_title;
			$leyenda = $thumbnail_details[0]->post_excerpt;
			$titulo=get_the_title();//echo $titulo;
			
			if(strlen($titulo)>$titulo_longitud){
				$titulo=substr($titulo,0,$titulo_longitud)."...";
			} 
			

			?>
			
			<div class="card text-white post-thumbnail">
				<div class="gobsvpostinfo-date">
					<a title="<?php echo get_the_time( 'g:i a' );?>" href="<?php the_permalink();?>" rel="nofollow">
					<span class="entry-month"><?php echo get_the_date( 'M' );?></span>
					<span class="entry-date updated"><?php echo get_the_date( 'd' );?></span>
					<span class="entry-year"><?php echo get_the_date( 'Y' );?></span>
					</a>
				</div> 
				<?php 
				/*
				$categories = get_the_category();
				if ( ! empty( $categories ) ) {
				?>
				<span class="gobsvpostinfo-categories">
					<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) );?>" rel="category tag"><?php echo esc_html( $categories[0]->name );?></a>
				</span> 
				<?php
				}
				*/
				?>
				<a href="<?php the_permalink();?>">
				<figure>
					<img class="card-img card-imgsv" src="<?php echo $image[0]; ?>" alt="Card image cap">
				</figure>
				
				<div class="card-img-overlaysv">
				  <h5 class="card-title text-center text-white"><?php 
				  
				  echo $titulo;
				  ?>
				  </h5>
				  <!--<p class="card-text"></p>-->
				</div>
				<!--<div class="card-footer">
				  <small class="text-muted"></small>
				</div>-->
				</a>
			</div>
			
		
			<?php
			$i++;
			if($i == 3){
			?>
			</div>
			<div class="card-group vertical-gobsvpostinfo-style">
			<?php
               $i=0;			
			}
		endwhile;
	}
	
	?>
</div>
</div>


<?php
    createShortcuts();
	get_footer();
?>
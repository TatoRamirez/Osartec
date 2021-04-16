<?php get_header();?>

<?php while ( have_posts() ): the_post();?>
<div class="bloc full-width-bloc bgc-white d-flex l-bloc" id="bloc-15">
	<div class="container none">
		<div class="row no-gutters">
			<div class="col-12">
				<div id="carousel-49426" class="carousel slide" data-ride="carousel" data-interval="false">
					<ol class="carousel-indicators hide-indicators">
						<li data-target="#carousel-49426" data-slide-to="0" class="active">
						</li>
					</ol>
					<div class="carousel-inner" role="listbox">
						<div class="carousel-item active">
						<?php
							
							if( class_exists('Dynamic_Featured_Image') ) {
								global $dynamic_featured_image;
								$featured_images = $dynamic_featured_image->get_featured_images( get_the_ID() );
							}
							
							if($featured_images[0]['full'] == ''){
								if( has_post_thumbnail()){
									the_post_thumbnail('post-thumbnail', ['class' => 'd-inline-block w-100']);
									$class="tab-mg-md";
								}
								else{
									$class="tab-none";
									?>
									<style type="text/css">
									/*.navbar{
										position: relative;
										display: -ms-flexbox;
										display: flex;
										-ms-flex-wrap: wrap;
										flex-wrap: wrap;
										-ms-flex-align: center;
										align-items: center;
										-ms-flex-pack: justify;
										justify-content: space-between;
										padding: 0.5rem 1rem;
										margin-top: 6px !important;
									}*/
									</style>
									<?php
								}
							}
							else{
								$image_post=$featured_images[0]['full'];
								$class="tab-mg-md";
								?>
								<img class="d-inline-block w-100 " alt="slide 1" src="<?php echo $image_post; ?>" />
							<?php	
							}
						?>
							<div class="carousel-caption">
							</div>
						</div>
					</div>
					<?php
					
					?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="bloc bgc-white-2 tc-black" id="bloc-17">
	<div class="container none bloc-sm margen-single">
		<div class="row">
			<div class="col">
			<?php
			
			if(function_exists('get_hansel_and_gretel_breadcrumbs')): 
				  echo get_hansel_and_gretel_breadcrumbs();
			endif;
			
			?>
			
             
			<h1 class="title-noti">
            <?php
			/** Titulo  */
				the_title();			
				
			?>			
			</h1>
			<?php
            the_content();  
			?>
			</div>
		</div>
		<div class="row">
			<div class="col text-center mt-4">
			Publicado el <?php the_time('d-m-Y'); ?>.
			<p class="text-center"><?php the_tags(); ?></p>
			</div>
		</div>
		<div class="row">
<?php
/*$cat = get_the_category($post->ID);
echo "Categoria: ". $cat [0]->cat_name ;*/
$bool_next_prev=true;
if ( get_post_type( get_the_ID() ) == 'servicios' || get_post_type( get_the_ID() ) == 'programas') {
    //if is true
	$bool_next_prev=false;
}
?>

<div class="col-sm">
<?php

previous_post_link('&laquo;&laquo; %link', '%title', $bool_next_prev);

//previous_post('&laquo; &laquo; %', 'Anterior: ', 'yes'); 
?>
</div>

<div class="col-sm text-center">
<?php
$the_cat = get_the_category();

$category_name = $the_cat[0]->cat_name;

$category_link = get_category_link( $the_cat[0]->cat_ID );

if ( get_post_type( get_the_ID() ) == 'servicios' ) {
	$category_name="Servicios";
	$category_link=get_site_url()."/guia-de-servicios/";
}else if(get_post_type( get_the_ID() ) == 'programas'){
	$category_name="Programas";
	$category_link=get_site_url()."/guia-de-programas/";
}	

?>
 

<a href="<?php echo $category_link ?>" title="Regresar a la categor&iacute;a <?php echo $category_name ?>" class="btn btn-d-noticia float-center">Ir a <?php echo $category_name ?></a>

</div>

<div class="col-sm text-right">

<?php 
next_post_link('%link &raquo;&raquo;', '%title', $bool_next_prev);
//next_post('% &raquo; &raquo; ', 'Siguiente: ', 'yes'); 
?>


</div> <!-- end navigation -->





		</div>
	</div>
</div>

<?php
endwhile;
?>

<?php
	createShortcuts();
	get_footer();
?>

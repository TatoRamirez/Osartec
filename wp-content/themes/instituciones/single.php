<?php get_header();?>

<?php while ( have_posts() ): the_post();?>
<div class="bloc full-width-bloc bgc-charcoal d-flex l-bloc" id="bloc-15">
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
					/*<a class="carousel-nav-controls carousel-control-prev object-hidden" href="#carousel-49426" role="button" data-slide="prev">
					<span class="fa fa-chevron-left"></span><span class="sr-only">Previous</span></a>
					<a class="carousel-nav-controls carousel-control-next object-hidden" href="#carousel-49426" role="button" data-slide="next">
					<span class="fa fa-chevron-right"></span><span class="sr-only">Next</span></a>
					*/
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--
<div class="bloc bgc-charcoal d-bloc" id="bloc-16">
	<div class="container none">
		<div class="row">
			<div class="col-12">
				<h4 class="<?php echo $class;?>" id="tab-text" >
					<?php
					/** Titulo  */
					if($class=="tab-mg-md"){
						the_title();
					}
					?>
				</h4>
			</div>
		</div>
	</div>
</div>
-->

<div class="bloc bgc-white-2 tc-black" id="bloc-17">
	<div class="container none bloc-sm margen-single">
		<div class="row">
			<div class="col">
			<?php
			if ( function_exists('yoast_breadcrumb') ) {
			  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
			}
			?>
			<?php
			/*if($class=="tab-none"){
				?>	
			<div class="tab-margin">				
				
			</div>
			<br>
			<?php
			}*/
			/**Contenido */
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
	</div>
</div>

<?php
endwhile;
?>

<?php
	createShortcuts();
	get_footer();
?>

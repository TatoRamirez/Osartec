<?php get_header();?>

<?php while ( have_posts() ): the_post();?>

<?php
/** Imagen descatada */
if( has_post_thumbnail()){
?>
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
						<div class="carousel-item-content active">

            <?php
                /** Imagen descatada */
                if( has_post_thumbnail()){
					the_post_thumbnail('post-thumbnail', ['class' => 'd-inline-block w-100']);
					$class="tab-mg-md";
				}
				else{
					$class="tab-none";
				
				}

				
            ?>
<div class="carousel-caption">
							</div>
						</div>
					</div><a class="carousel-nav-controls carousel-control-prev object-hidden" href="#carousel-49426" role="button" data-slide="prev"><span class="fa fa-chevron-left"></span><span class="sr-only">Previous</span></a><a class="carousel-nav-controls carousel-control-next object-hidden" href="#carousel-49426" role="button" data-slide="next"><span class="fa fa-chevron-right"></span><span class="sr-only">Next</span></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>


<div class="bloc bgc-white-2 tc-black" id="bloc-17">
	<div class="container none bloc-sm margen-single">
		<div class="row">
			<div class="col">				
			<?php
			if(function_exists('get_hansel_and_gretel_breadcrumbs')): 
				  echo get_hansel_and_gretel_breadcrumbs();
			endif;
			?>
			<h1 class="text-center"><?php the_title();?></h1>
			<?php			
            /**Contenido */
            the_content();  
			?>
			</div>
		</div>
	</div>
</div>

<?php
endwhile;
	createShortcuts();
 	get_footer();
?>

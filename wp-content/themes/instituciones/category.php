<?php get_header();
$categoria = get_queried_object();



?>
<div class="bloc none full-width-bloc tc-black" id="bloc-112">
	<div class="container bloc-sm">
		<div class="row align-items-end no-gutters">
			<div class="col-md-1">
			</div>
			<div class="col-md-11">
				<div class="col align-self-start">
					<h1 class=" text-white" data-appear-anim-style="fadeInUp">
						<?php echo $categoria->name;?>
					</h1>
				</div>
			</div>
		</div>
	</div>
</div>




<div class="container">
    
	<div class="row">
        <div class="gap-3"></div>
			<div class="col-md-1">
			</div>
			<div class="col-md-10 col-xs-12 col-lg-10">
				<?php 
				while(have_posts()): the_post();
				?>
    			<article class="card card-full hover-a mb-module seccion-noticias">
				<div class="row">
					<!--thumbnail-->
					<div class="col-md-5 col-xs-10 col-lg-5 col-sm-10 pr-2 pr-md-0">
						<!--thumbnail-->
						<div class="ratio_180-123 image-wrapper ">
						
							<a href="<?php the_permalink();?>">
							<figure>
							<!--<img width="180" height="123" src="./index_files/pexels-photo-2118049-180x123.jpeg" class="img-fluid lazy wp-post-image loaded" alt="Dior Celebrates its Iconic Red Lipstick with New Rouge Dior Collection" data-src="https://demo.bootstrap.news/dark/wp-content/uploads/2019/09/pexels-photo-2118049-180x123.jpeg" srcset="https://demo.bootstrap.news/dark/wp-content/uploads/2019/09/pexels-photo-2118049-180x123.jpeg 180w, https://demo.bootstrap.news/dark/wp-content/uploads/2019/09/pexels-photo-2118049-99x68.jpeg 99w, https://demo.bootstrap.news/dark/wp-content/uploads/2019/09/pexels-photo-2118049-115x80.jpeg 115w" sizes="(max-width: 180px) 100vw, 180px" data-was-processed="true">-->
							<?php the_post_thumbnail('full', array('class'=>'img-fluid lazy wp-post-image loaded height-image'));?>
							</figure> 
							</a>
						</div>
					</div>
					<div class="col-md-7 col-xs-10 col-lg-7 col-sm-10 seccion-noticias align-top">
						<div class="card-body pt-0">
							<!--title-->
							<h2 class="card-title "><!--h5 h4-sm h3-lg-->
								<a href="<?php the_permalink();?>" ><h4 class="title-color-h4"><?php the_title();?></h4><!--class="mg-md tc-black a-categoria"-->
								</a>
							</h2>
							<div class="card-text text-muted small">
								<time class="news-date" datetime="11-09-2019">Última modificación: <?php the_modified_time('d/m/Y'); ?></time>
								<p><?php the_tags(); ?></p>
							</div>
							<!--content text-->
							<p class="card-text d-md-block">
							<?php echo get_the_excerpt();?>
							</p>
							<a href="<?php the_permalink();?>" class="btn btn-d-noticia float-left">Leer</a>
							
						</div>
					</div>
				</div>
				</article>
				<?php 
				endwhile;
				?>						
				
			</div>	
			<div class="col-md-1">
			</div>			
			<!-- left sidebar check -->
						
			<!-- right sidebar check -->
    	</div>
		<div class="clearfix my-4 text-center">
			<nav class="float-center" aria-label="Posts navigation">
				<?php
				wp_numeric_posts_nav();/*Para paginación numérica*/
				?>
			</nav>
			<span class="py-2 float-right"></span>
		</div>
		
		
</div>





<!-- bloc-9 -->
<!-- <div class="bloc l-bloc" id="bloc-9">
	<div class="container bloc-sm">
		<div class="row">
			<div class="col-md-6 col-6 category-previous-btn-correction">
				<h3 class="mg-md h3-anterior-style">
					<?php previous_posts_link('<span class="feather-icon icon-arrow-left icon-md-cat icon-white"></span>');?><?php previous_posts_link('Anterior');?><br>
				</h3>
			</div>
			<div class="col-md-6 col-6 category-next-btn-correction">
				<h3 class="mg-sm text-lg-right mx-auto d-block h3-siguiente-style text-sm-right">
					<?php next_posts_link('<span class="feather-icon icon-arrow-right float-lg-right icon-md-cat icon-white float-right"></span>');?><?php next_posts_link('Siguiente');?>
				</h3>
			</div>
		</div>
	</div>
</div>
<!-- bloc-9 END -->

<!-- Sidebar contenido 
<div id="primary" class="sidebar">
    <?php do_action( 'before_sidebar' ); ?>
    <?php if ( ! dynamic_sidebar( 'sidebar-primary' ) ) : ?>
        <aside id="search" class="widget widget_search">
           <?php get_search_form(); ?>
        </aside>
        <aside id="archives" class"widget">
            <h3 class="widget-title"><?php _e( 'Archives', 'shape' ); ?></h3>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </aside>
        <aside id="meta" class="widget">
            <h3 class="widget-title"><?php _e( 'Meta', 'shape' ); ?></h3>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </aside>
   <?php endif; ?>
</div>
<!-- fin sidebar -->

<?php
	createShortcuts();
 	get_footer();
?>
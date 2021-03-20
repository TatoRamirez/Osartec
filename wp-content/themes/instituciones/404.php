<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>
<div class="bloc d-flex bgc-white l-bloc" id="iconos-2">
	<div class="container none bloc-sm">
		<div class="row mt-4 mb-2">
			<div class="col-12">
				<h1 class="servicios-title">
					Error 404
					
				</h1>
			</div>
		</div>
		<div class="row mt-4 mb-2">
			<div class="col-12">
				<h3 class="servicios-title">
					<?php _e( '¡Lo sentimos! La página no fue encontrada.', 'instituciones' ); ?>
				</h3>
				
					
			</div>
		</div>
		<div class="row mt-4 mb-2 center-block">
		<h4 class="text-center text-lg-center ltc-black"><?php _e( 'Al parece la página que buscas ya no existe, o se movió a otro lugar. Por favor utiliza nuestro buscador ubicado en la parte superior derecha de la pantalla.', 'instituciones' ); ?></h4>

						

		</div>


	</div>
</div>


<?php
get_footer();

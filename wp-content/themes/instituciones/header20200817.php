<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="shortcut icon" type="image/png" href="favicon.png">
	<?php 
		$logo_institucion_msj="";
		wp_head(); 
		$logo_institucion = myprefix_get_theme_option( 'input_logo' );
		if($logo_institucion == ''){
			$logo_institucion_msj="Colocar link del logo en los datos de la institución!..";
		}
		$portal_transparencia = myprefix_get_theme_option( 'input_portal' );
		$buscador = myprefix_get_theme_option( 'input_buscador' );
		

	?>
	<style>
	.navbar-default {
background-color: #3c4457;
border-color: #3c4457;
}
.navbar-default .navbar-brand {
color: #ffffff;
}
.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
color: #ffffff;
}
.navbar-default .navbar-text {
color: #ffffff;
}
.navbar-default .navbar-nav > li > a {
color: #ffffff;
text-align: center;
}
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
color: #ffffff;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
color: #ffffff;
background-color: #4e5669;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
color: #ffffff;
background-color: #4e5669;
}
.navbar-default .navbar-toggle {
border-color: #3c4457;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
background-color: #4e5669;
}
.navbar-default .navbar-toggle .icon-bar {
background-color: #ffffff;
}
.navbar-default .navbar-collapse,.navbar-default .navbar-form {
border-color: #ffffff;
}
.navbar-default .navbar-link {
color: #ffffff;
}
.navbar-default .navbar-link:hover {
color: #ffffff;
}

@media (max-width: 767px) {
	.navbar-default .navbar-nav .open .dropdown-menu > li > a {
		color: #ffffff;
	}
	.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
		color: #ffffff;
	}
	.navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
	color: #ffffff;
	background-color: #4e5669;
	}
}
	</style>
    <title><?php get_bloginfo('name');?></title>
    
<!-- Analytics -->
 
<!-- Analytics END -->
    
</head>
<body>
<header>
<!-- Main container -->
<div class="page-container">

<?php /*

if ( wp_is_mobile() ) {?>
	<div class="bloc none full-width-bloc l-bloc " id="bloc-head">
	<div class="container head-conf bloc-sm">
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			<div class="img-fluid mg-sm float-lg-none pad-icons-head">
				<?php  #echo do_shortcode('[gtranslate]'); ?>
			</div>
				<!-- <img src="img/bandp.png" class="img-fluid img-1-style mg-sm float-lg-none pad-icons-head" alt="1" /> -->				
				<!--<img src="<?php bloginfo('stylesheet_directory'); ?>/img/xl.png" class="img-fluid img-bloc-head-style float-lg-none d-block mg-sm" alt="transp large" /><a href="https://www.transparencia.gob.sv" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/png4xportalp.png" class="img-fluid img-recurso-2-style float-lg-none pad-icons-head" alt="Recurso%202" /></a><img src="<?php bloginfo('stylesheet_directory'); ?>/img/xl.png" class="img-fluid mx-auto img-transp-lar-style d-block mg-sm" alt="transp large" /><a href="http://instituciones.gob.sv/" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/minis.svg" class="img-fluid img-3-style float-lg-none mg-md pad-icons-head" alt="Recurso%201" /></a> -->
			</div>
			<div class="col-sm-8 col-lg-8 logo-separador">
				<a href="<?php echo get_site_url(); ?>"><img src="<?php echo $logo_institucion; ?>" class="img-fluid mx-auto d-block img-logo-mag-style animated fadeIn" alt="LOGO INSTITUCIONAL" id="logo-institucion" data-appear-anim-style="fadeIn" /><?php echo $logo_institucion_msj;?></a>
			</div>						
			<div class="buscador"><a href="<?php echo $buscador;?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/lupa.png" class="img-fluid img-recurso-2-style float-lg-none pad-icons-head" alt="Recurso%202" /> </a></div>			
		</div>
	</div>
</div>




			<?php
			//}else{ 
			/*wp_footer();
			$nombre_institucion = myprefix_get_theme_option( 'input_example' );
    $direccion_institucion = myprefix_get_theme_option( 'introtext' );
    $numero_telefonico = myprefix_get_theme_option('phone_number');
    $correo_institucion = myprefix_get_theme_option('inst_email');
    $facebook_url = myprefix_get_theme_option('fb_url');
    $twitter_url = myprefix_get_theme_option('tw_url');
    $ig_url = myprefix_get_theme_option('ig_url');
    $yt_url = myprefix_get_theme_option('yt_url');

	$mapasitio = myprefix_get_theme_option('mapasitio');
	$politicaweb = myprefix_get_theme_option('politicaweb');
	$preguntas = myprefix_get_theme_option('preguntas');
	$cartaderecho = myprefix_get_theme_option('cartaderecho');
			*/
			?>	
<!-- bloc-head -->
<div class="container-fluid  head-conf bloc-sm">
	<div class="row">
		<div class="col-md-3">
			<div class="instituciones">
				<a href="#" class="follow-icon-item" target="_blank">
				<!--<svg id="Capa_1" width="22" height="22" fill="#FEFFFF" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
					<g><path d="m502 292h-70v-36c0-4.62-3.166-8.64-7.657-9.722l-39.78-9.585c-8.864-59.485-57.868-105.659-118.563-110.304v-26.389h110c4.044 0 7.691-2.437 9.239-6.173 1.548-3.737.692-8.038-2.167-10.898l-32.93-32.929 32.929-32.929c2.86-2.86 3.715-7.161 2.167-10.898-1.547-3.736-5.194-6.173-9.238-6.173h-120c-5.523 0-10 4.478-10 10v116.389c-60.69 4.645-109.698 50.814-118.563 110.304l-39.78 9.585c-4.491 1.082-7.657 5.102-7.657 9.722v36h-70c-5.523 0-10 4.478-10 10v200c0 5.522 4.477 10 10 10h201c5.523 0 10-4.478 10-10s-4.477-10-10-10c-19.559 0-98.244 0-111 0v-20h312v20h-111c-5.523 0-10 4.478-10 10s4.477 10 10 10h201c5.523 0 10-4.478 10-10v-200c0-5.522-4.477-10-10-10zm-236-272h85.858l-22.929 22.929c-3.905 3.905-3.905 10.237 0 14.143l22.929 22.928h-85.858zm-10 126c52.325 0 96.191 35.906 107.292 85.567l-104.95-25.289c-1.54-.371-3.146-.371-4.686 0l-104.95 25.289c11.103-49.661 54.969-85.567 107.294-85.567zm-156 117.877c20.761-5.003 142.372-34.307 156-37.591l156 37.591v28.123h-312zm60 48.123v140h-20v-140zm20 0h46v140h-46zm66 0h20v140h-20zm40 0h46v140h-46zm66 0h20v140h-20zm-332 180v-180h100v140h-20v-30c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10v40c0 5.522 4.477 10 10 10h30v20zm60-40h-20v-20h20zm412 40h-60v-20h30c5.523 0 10-4.478 10-10v-40c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10v30h-20v-140h100zm-60-40v-20h20v20z"/><path d="m412 342v40c0 5.522 4.477 10 10 10h40c5.523 0 10-4.478 10-10v-40c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10zm20 10h20v20h-20z"/><path d="m50 392h40c5.523 0 10-4.478 10-10v-40c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10v40c0 5.522 4.477 10 10 10zm10-40h20v20h-20z"/><circle cx="256" cy="502" r="10"/></g>					
				</svg>
				<span style="padding-left: 10px; display: inline-block;margin-top: 5px;font-family: 'MuseoSans-500';font-size: 12px;line-height : 14px;color: #FEFFFF!important;">
				INSTITUCIONES
				</span>-->
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 211.32 37.319">
				  <g id="Instituciones_ON" transform="translate(-65.68 -41.718)">
					<text id="Instituciones" transform="translate(126 73)" fill="#fff" font-size="20" font-family="MuseoSans-500, Museo Sans" font-weight="500"><tspan x="0" y="0">INSTITUCIONES</tspan></text>
					<g id="Capa_2" data-name="Capa 2" transform="translate(65.679 41.718)">
					  <g id="Capa_1" data-name="Capa 1">
						<path id="Trazado_206" data-name="Trazado 206" d="M38.973,24.2H35.167V18.3A1.311,1.311,0,0,0,34.6,17.06L20.654,8.138,20.6,8.109V6.089h6.135a.658.658,0,0,0,.652-.658V.658A.652.652,0,0,0,26.738,0H19.944a.658.658,0,0,0-.658.658V8.1h-.04L5.076,17.054A1.3,1.3,0,0,0,4.5,18.308a.853.853,0,0,0,0,.12V24.2H.658A.652.652,0,0,0,0,24.855V36.667a.652.652,0,0,0,.658.652H38.973a.652.652,0,0,0,.652-.652V24.855A.652.652,0,0,0,38.973,24.2ZM26.079,2.072V4.006H20.6V2.072ZM19.939,10.8l9.849,6.3H9.9ZM1.311,25.513H4.464V34.7H1.311ZM16.024,34.7H11.812V26.56a2.1,2.1,0,0,1,4.195,0Zm11.286,0H23.092V26.56a2.1,2.1,0,1,1,4.2,0Zm5.248,0H28.615V26.56a3.434,3.434,0,0,0-6.822,0V34.7h-4.47V26.56a3.434,3.434,0,0,0-6.827,0V34.7H7.062V19.738H32.541Zm5.774,0H35.185V25.513h3.159Z" fill="#fff"/>
					  </g>
					</g>
				  </g>
				</svg>
				</a>
			</div>
			
			
			<div class="transparencia">
				
				<a href="#https://www.transparencia.gob.sv" class="follow-icon-item" target="_blank">
				<!--<svg id="Capa_2" width="22" height="22" fill="#FEFFFF" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><path d="M505.749,475.587l-145.6-145.6c28.203-34.837,45.184-79.104,45.184-127.317c0-111.744-90.923-202.667-202.667-202.667 S0,90.925,0,202.669s90.923,202.667,202.667,202.667c48.213,0,92.48-16.981,127.317-45.184l145.6,145.6 c4.16,4.16,9.621,6.251,15.083,6.251s10.923-2.091,15.083-6.251C514.091,497.411,514.091,483.928,505.749,475.587z M202.667,362.669c-88.235,0-160-71.765-160-160s71.765-160,160-160s160,71.765,160,160S290.901,362.669,202.667,362.669z"/></g>
				</svg>
				
				<p style="padding-top:15px;padding-left: 5px; display: inline-block;font-family: 'MuseoSans-500';font-size: 11px;line-height : 12px;color: #FEFFFF!important;">
				Portal de<BR/><span style="font-family: 'MuseoSans-700';font-size: 13px;">
				Transparencia</p>-->
				<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 197 42">
				  <g id="Transparencia_ON" transform="translate(-63 -108)">
					<g id="Elipse_1" data-name="Elipse 1" transform="translate(63 108)" fill="none" stroke="#fff" stroke-width="4">
					  <circle cx="15" cy="15" r="15" stroke="none"/>
					  <circle cx="15" cy="15" r="13" fill="none"/>
					</g>
					<line id="Línea_1" data-name="Línea 1" x2="12" y2="12" transform="translate(87.5 132.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="5"/>
					<text id="Portal_de" data-name="Portal de" transform="translate(115 124)" fill="#fff" font-size="15" font-family="MuseoSans-700, Museo Sans" font-weight="700"><tspan x="0" y="0">Portal de</tspan></text>
					<text id="Transparencia" transform="translate(115 144)" fill="#fff" font-size="22" font-family="MuseoSans-700, Museo Sans" font-weight="700"><tspan x="0" y="0">Transparencia</tspan></text>
				  </g>
				</svg>
				</a>
				
				
			</div>
		</div>
		<div class="col-md-6">
			<a href="<?php echo get_site_url(); ?>"><img src="<?php echo $logo_institucion; ?>" class="img-fluid mx-auto d-block img-logo-mag-style animated fadeIn" alt="LOGO INSTITUCIONAL" id="logo-institucion" data-appear-anim-style="fadeIn" /><?php echo $logo_institucion_msj;?></a>
		</div>
		<div class="col-md-3">
		
			<div class="row">
				<div class="buscador"><?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?></div>
			</div>
			<div class="row">
				<div class="traductor"><p class="text-right"><?php echo do_shortcode('[gtranslate]'); ?></p></div>
			</div>
		</div>
	</div>
</div>
<?php
/*
<div class="bloc none full-width-bloc l-bloc " id="bloc-head">
	<div class="container head-conf bloc-sm">
		<div class="row">
			<div class="col">
			<div class="instituciones">
				<a href="#" class="follow-icon-item" target="_blank">
				<svg id="Capa_1" width="25" height="25" fill="#FEFFFF" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m502 292h-70v-36c0-4.62-3.166-8.64-7.657-9.722l-39.78-9.585c-8.864-59.485-57.868-105.659-118.563-110.304v-26.389h110c4.044 0 7.691-2.437 9.239-6.173 1.548-3.737.692-8.038-2.167-10.898l-32.93-32.929 32.929-32.929c2.86-2.86 3.715-7.161 2.167-10.898-1.547-3.736-5.194-6.173-9.238-6.173h-120c-5.523 0-10 4.478-10 10v116.389c-60.69 4.645-109.698 50.814-118.563 110.304l-39.78 9.585c-4.491 1.082-7.657 5.102-7.657 9.722v36h-70c-5.523 0-10 4.478-10 10v200c0 5.522 4.477 10 10 10h201c5.523 0 10-4.478 10-10s-4.477-10-10-10c-19.559 0-98.244 0-111 0v-20h312v20h-111c-5.523 0-10 4.478-10 10s4.477 10 10 10h201c5.523 0 10-4.478 10-10v-200c0-5.522-4.477-10-10-10zm-236-272h85.858l-22.929 22.929c-3.905 3.905-3.905 10.237 0 14.143l22.929 22.928h-85.858zm-10 126c52.325 0 96.191 35.906 107.292 85.567l-104.95-25.289c-1.54-.371-3.146-.371-4.686 0l-104.95 25.289c11.103-49.661 54.969-85.567 107.294-85.567zm-156 117.877c20.761-5.003 142.372-34.307 156-37.591l156 37.591v28.123h-312zm60 48.123v140h-20v-140zm20 0h46v140h-46zm66 0h20v140h-20zm40 0h46v140h-46zm66 0h20v140h-20zm-332 180v-180h100v140h-20v-30c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10v40c0 5.522 4.477 10 10 10h30v20zm60-40h-20v-20h20zm412 40h-60v-20h30c5.523 0 10-4.478 10-10v-40c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10v30h-20v-140h100zm-60-40v-20h20v20z"/><path d="m412 342v40c0 5.522 4.477 10 10 10h40c5.523 0 10-4.478 10-10v-40c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10zm20 10h20v20h-20z"/><path d="m50 392h40c5.523 0 10-4.478 10-10v-40c0-5.522-4.477-10-10-10h-40c-5.523 0-10 4.478-10 10v40c0 5.522 4.477 10 10 10zm10-40h20v20h-20z"/><circle cx="256" cy="502" r="10"/></g>
				</svg>
				
				
				<span style="padding-left: 10px; display: inline-block;margin-top: 5px;font-family: 'MuseoSans-500';font-size: 14px;color: #FEFFFF!important;">INSTITUCIONES</span>
				</a>
			</div>
			
			
			<div class="transparencia">
				
				<a href="#https://www.transparencia.gob.sv" class="follow-icon-item" target="_blank">
				<svg id="Capa_2" width="25" height="25" fill="#FEFFFF" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><path d="M505.749,475.587l-145.6-145.6c28.203-34.837,45.184-79.104,45.184-127.317c0-111.744-90.923-202.667-202.667-202.667 S0,90.925,0,202.669s90.923,202.667,202.667,202.667c48.213,0,92.48-16.981,127.317-45.184l145.6,145.6 c4.16,4.16,9.621,6.251,15.083,6.251s10.923-2.091,15.083-6.251C514.091,497.411,514.091,483.928,505.749,475.587z M202.667,362.669c-88.235,0-160-71.765-160-160s71.765-160,160-160s160,71.765,160,160S290.901,362.669,202.667,362.669z"/></g>
				</svg>
				
				<p style="padding-top:15px;padding-left: 10px; display: inline-block;font-family: 'MuseoSans-500';font-size: 14px;line-height : 16px;color: #FEFFFF!important;">Portal de<BR/><span style="font-family: 'MuseoSans-700';font-size: 16px;">Transparencia</p>
				</a>
				
				
			</div>
			
			<!--col-lg-4 col-md-4 col-sm-4-->
			    
				<!-- <img src="img/bandp.png" class="img-fluid img-1-style mg-sm float-lg-none pad-icons-head" alt="1" /> -->				
				<!--<img src="<?php bloginfo('stylesheet_directory'); ?>/img/xl.png" class="img-fluid img-bloc-head-style float-lg-none d-block mg-sm" alt="transp large" /><a href="https://www.transparencia.gob.sv" target="_blank">Portal de <br>Transparencia</a><img src="<?php bloginfo('stylesheet_directory'); ?>/img/xl.png" class="img-fluid mx-auto img-transp-lar-style d-block mg-sm" alt="transp large" /><a href="<?php echo bloginfo('template_directory'); ?>/ministerios.php" target="_blank">MINISTERIOS</a> -->
				
				
				<!--<img src="<?php bloginfo('stylesheet_directory'); ?>/img/xl.png" class="img-fluid img-bloc-head-style float-lg-none d-block mg-sm" alt="transp large" />
				<a href="<?php echo $portal_transparencia;?>" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/lupa.png" class="img-fluid img-recurso-2-style float-lg-none pad-icons-head" alt="Recurso%202" />Portal de <br>Transparencia</a>
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/xl.png" class="img-fluid mx-auto img-transp-lar-style d-block mg-sm" alt="transp large" />-->
				
				<!-- <a href="<?php echo bloginfo('template_directory'); ?>/ministerios.php" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/img/Instituciones.svg" class="img-fluid img-3-style float-lg-none pad-icons-head img-inst" alt="Recurso%201" /> INSTITUCIONES</a> --> 				
				
			</div>			
			<div class="col-sm-6 col-lg-6 logo-separador">
				<a href="<?php echo get_site_url(); ?>"><img src="<?php echo $logo_institucion; ?>" class="img-fluid mx-auto d-block img-logo-mag-style animated fadeIn" alt="LOGO INSTITUCIONAL" id="logo-institucion" data-appear-anim-style="fadeIn" /><?php echo $logo_institucion_msj;?></a>								
			</div>			
			<div class="col">	<!--col-lg-4 col-md-4 col-sm-4-->
				<div class="row">
					
						<div class="buscador"><?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?></div>
					
					
						<div class="traductor"><?php echo do_shortcode('[gtranslate]'); ?></div>
					
				</div>
				<div class="row">
				
					<div class="follow-icon"> 
						<!--<div class="social-link-bric text-center" bloc-name="follow-icons" id="follow-icons">-->
						<?php if($twitter_url !=''){?>
						<a href="<?php echo $twitter_url;?>" class="follow-icon-item" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"  fill="#FEFFFF" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"></path></svg></a>
						<?php }
						if($facebook_url !=''){?>
						<a href="<?php echo $facebook_url;?>" class="follow-icon-item" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#FEFFFF" viewBox="0 0 24 24" ><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"></path></svg></a>
						<?php }
						if($ig_url !=''){?>
						<a href="<?php echo $ig_url;?>" class="follow-icon-item" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#FEFFFF" viewBox="0 0 24 24" ><path d="M14.829 6.302c-.738-.034-.96-.04-2.829-.04s-2.09.007-2.828.04c-1.899.087-2.783.986-2.87 2.87-.033.738-.041.959-.041 2.828s.008 2.09.041 2.829c.087 1.879.967 2.783 2.87 2.87.737.033.959.041 2.828.041 1.87 0 2.091-.007 2.829-.041 1.899-.086 2.782-.988 2.87-2.87.033-.738.04-.96.04-2.829s-.007-2.09-.04-2.828c-.088-1.883-.973-2.783-2.87-2.87zm-2.829 9.293c-1.985 0-3.595-1.609-3.595-3.595 0-1.985 1.61-3.594 3.595-3.594s3.595 1.609 3.595 3.594c0 1.985-1.61 3.595-3.595 3.595zm3.737-6.491c-.464 0-.84-.376-.84-.84 0-.464.376-.84.84-.84.464 0 .84.376.84.84 0 .463-.376.84-.84.84zm-1.404 2.896c0 1.289-1.045 2.333-2.333 2.333s-2.333-1.044-2.333-2.333c0-1.289 1.045-2.333 2.333-2.333s2.333 1.044 2.333 2.333zm-2.333-12c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.958 14.886c-.115 2.545-1.532 3.955-4.071 4.072-.747.034-.986.042-2.887.042s-2.139-.008-2.886-.042c-2.544-.117-3.955-1.529-4.072-4.072-.034-.746-.042-.985-.042-2.886 0-1.901.008-2.139.042-2.886.117-2.544 1.529-3.955 4.072-4.071.747-.035.985-.043 2.886-.043s2.14.008 2.887.043c2.545.117 3.957 1.532 4.071 4.071.034.747.042.985.042 2.886 0 1.901-.008 2.14-.042 2.886z"></path></svg></a>
						<?php }
						if($yt_url !=''){?>
						<a href="<?php echo $yt_url;?>" class="follow-icon-item" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#FEFFFF" viewBox="0 0 24 24" ><path d="M10.918 13.933h.706v3.795h-.706v-.419c-.13.154-.266.272-.405.353-.381.218-.902.213-.902-.557v-3.172h.705v2.909c0 .153.037.256.188.256.138 0 .329-.176.415-.284v-2.881zm.642-4.181c.2 0 .311-.16.311-.377v-1.854c0-.223-.098-.38-.324-.38-.208 0-.309.161-.309.38v1.854c-.001.21.117.377.322.377zm-1.941 2.831h-2.439v.747h.823v4.398h.795v-4.398h.821v-.747zm4.721 2.253v2.105c0 .47-.176.834-.645.834-.259 0-.474-.094-.671-.34v.292h-.712v-5.145h.712v1.656c.16-.194.375-.354.628-.354.517.001.688.437.688.952zm-.727.043c0-.128-.024-.225-.075-.292-.086-.113-.244-.125-.367-.062l-.146.116v2.365l.167.134c.115.058.283.062.361-.039.04-.054.061-.141.061-.262v-1.96zm10.387-2.879c0 6.627-5.373 12-12 12s-12-5.373-12-12 5.373-12 12-12 12 5.373 12 12zm-10.746-2.251c0 .394.12.712.519.712.224 0 .534-.117.855-.498v.44h.741v-3.986h-.741v3.025c-.09.113-.291.299-.436.299-.159 0-.197-.108-.197-.269v-3.055h-.741v3.332zm-2.779-2.294v1.954c0 .703.367 1.068 1.085 1.068.597 0 1.065-.399 1.065-1.068v-1.954c0-.624-.465-1.071-1.065-1.071-.652 0-1.085.432-1.085 1.071zm-2.761-2.455l.993 3.211v2.191h.835v-2.191l.971-3.211h-.848l-.535 2.16-.575-2.16h-.841zm10.119 10.208c-.013-2.605-.204-3.602-1.848-3.714-1.518-.104-6.455-.103-7.971 0-1.642.112-1.835 1.104-1.848 3.714.013 2.606.204 3.602 1.848 3.715 1.516.103 6.453.103 7.971 0 1.643-.113 1.835-1.104 1.848-3.715zm-.885-.255v.966h-1.35v.716c0 .285.024.531.308.531.298 0 .315-.2.315-.531v-.264h.727v.285c0 .731-.313 1.174-1.057 1.174-.676 0-1.019-.491-1.019-1.174v-1.704c0-.659.435-1.116 1.071-1.116.678.001 1.005.431 1.005 1.117zm-.726-.007c0-.256-.054-.445-.309-.445-.261 0-.314.184-.314.445v.385h.623v-.385z"></path></svg></a>
						<?php }?>
						<!--<a href="https://vimeo.com/" class="vimeo-link d-none " target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#00adef" viewBox="0 0 24 24" style="margin-left: 2px; margin-right: 2px;"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.82 11.419c-1.306 2.792-4.463 6.595-6.458 6.595-1.966 0-2.25-4.192-3.324-6.983-.527-1.372-.868-1.058-1.858-.364l-.604-.779c1.444-1.27 2.889-2.745 3.778-2.826.998-.096 1.615.587 1.845 2.051.305 1.924.729 4.91 1.472 4.91.577 0 2.003-2.369 2.076-3.215.13-1.24-.912-1.277-1.815-.89 1.43-4.689 7.383-3.825 4.888 1.501z"></path></svg></a>

						<a href="https://linkedin.com/in/" class="linkedin-link d-none " target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#0177b5" viewBox="0 0 24 24" style="margin-left: 2px; margin-right: 2px;"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"></path></svg></a>
						-->
						<!--</div>-->
					</div>
				
				</div>
			</div>
		</div>
		<div class="row">
			<!--<div class="col-md-4 align-self-start offset-lg-0 col-lg-4 col-sm-4 footer-unete">-->
				
				
			<!--</div>-->
		</div>
	</div>
</div>
*/
?>
<!-- bloc-head END -->
<?php
//}?>


<!-- bloc-1 -->
<div class="bloc full-width-bloc l-bloc" id="bloc-1">
	<div class="container bloc-sm row-blocs">
		<div class="row">
			<div class="col p-0">
				<nav class="navbar row navbar-expand-md flex-column navbar-dark" role="navigation">
					<button id="nav-toggle" type="button" class="ui-navbar-toggler navbar-toggler border-0 p-0 toggle-ub-config" data-toggle="collapse" data-target=".navbar-43351" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					
					<?php
						/*if ( wp_is_mobile() ) {
							wp_nav_menu (array(
								'theme_location' => 'menu-movil',
								'container' => 'div',
								'container_class' => 'collapse navbar-collapse navbar-43351  sidebar-nav nav-item nav-separador',
								'menu_class' => 'site-navigation nav navbar-nav mx-auto justify-content-center ',
								'walker' 
								=> new Child_Wrap()														
							));
							
						}else{*/
						
							wp_nav_menu (array(
								'theme_location' => 'menu-principal',
								'container' => 'div',
								'container_class' => 'collapse navbar-collapse navbar-43351  sidebar-nav nav-item nav-separador navbar-gobsv',
								'menu_class' => 'site-navigation nav navbar-nav mx-auto justify-content-center ',
								'walker'								
								=> new Child_Wrap()														
							));
						
						/*}*/
                    ?>					
				</nav>
			</div>
		</div>
	</div>
</div>


<!-- bloc-1 END -->
</header>
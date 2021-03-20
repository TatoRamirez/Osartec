<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    
	<?php 
		$logo_institucion_msj="";
		wp_head(); 
		$logo_institucion = myprefix_get_theme_option( 'input_logo' );
		if($logo_institucion == ''){
			$logo_institucion_msj="Colocar link del logo en los datos de la institución!..";
		}
		$portal_transparencia = myprefix_get_theme_option( 'input_portal' );
		$buscador = myprefix_get_theme_option( 'input_buscador' );
		$titulo_sitio_web = myprefix_get_theme_option( 'input_example' );

	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-1230687-45"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-1230687-45');
	</script>

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
    <title><?php echo myprefix_get_theme_option( 'input_example' );?></title>
    
<!-- Analytics -->
 
<!-- Analytics END -->
    
</head>
<body>
<header>
	<!-- Main container -->
	<div class="page-container">

		<?php ?>	
		<!-- bloc-head -->
		<div class="container-fluid  head-conf bloc-sm">
			<div class="row">
				<div class="col-md-3">
					<div class="instituciones">
						<a href="<?php echo get_site_url(); ?>/otras-instituciones/" class="follow-icon-item" target="_blank">
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
						
						<a href="<?php echo $portal_transparencia; ?>" class="follow-icon-item" target="_blank">
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
					<a href="<?php echo get_site_url(); ?>"><img src="<?php bloginfo('stylesheet_directory'); echo $logo_institucion; ?>" class="img-fluid mx-auto d-block img-logo-mag-style animated fadeIn" alt="LOGO INSTITUCIONAL" id="logo-institucion" data-appear-anim-style="fadeIn" /><?php echo $logo_institucion_msj;?></a>
				</div>
				<div class="col-md-3">
				
					<div class="row">
						<div class="buscador"><?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?></div>
					</div>
					<div class="row">
						<div class="traductor"><?php echo do_shortcode('[gtranslate]'); ?></div>
					</div>
				</div>
			</div>
		</div>


		<!-- bloc-nav -->
		<div class="bloc full-width-bloc l-bloc" id="bloc-nav">
			<div class="container bloc-sm row-blocs">
				<div class="row">
					<div class="col p-0">
						<nav class="navbar row navbar-expand-md flex-column navbar-dark"><!-- role="navigation"-->
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
									
								}else{
								*/
									wp_nav_menu (array(
										'theme_location' => 'menu-principal',
										'container' => 'div',
										'container_class' => 'collapse navbar-collapse navbar-43351  sidebar-nav nav-item nav-separador navbar-gobsv',
										'menu_class' => 'site-navigation nav navbar-nav mx-auto justify-content-center ',
										'walker'								
										=> new Child_Wrap()														
									));
							?>
							
							
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- bloc-1 END -->
</header>
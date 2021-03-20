<?php
    wp_footer();

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
?>


<style>


.w3eden .card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: transparent;
    background-clip: border-box;
    border: 1px solid rgba(78,86,105,0.5);
    border-radius: .25rem;
}

.w3eden .table {
    width: 100%;
    margin-bottom: 1rem;
    border: 0;
    color: #fff;
}

.w3eden a {
    color: #fff;
    text-decoration: underline;
    background-color: transparent;
}

table.dataTable tbody tr {
    background-color: transparent;
}



.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #fff;
	font-family: "MuseoSans-300";
}
.w3eden b, .w3eden strong {
    font-weight: normal;
}

.w3eden a {
    color: #fff;
    text-decoration: underline;
    background-color: transparent;
}
.w3eden a {
    color: #fff;
    text-decoration: none;
}

table.dataTable thead th, table.dataTable tfoot th {
    font-weight: normal;
    font-family: "MuseoSans-700";
    color: #fff;
	font-size: 18px; 
}

#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_length label, #wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_filter label {
    font-weight: normal;
    font-family: "MuseoSans-500";
}

#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_length select {
    display: inline-block;
    width: 60px;
    color: #fff;
	border-radius: 0px;
    border: 2px solid #3f485b;
	font-size:12px;
	text-align:center;
    font-family: "MuseoSans-300";
}
#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_filter input[type=search]{
    padding: 5px !important;
    border-radius: 25px;
    border: 2px solid #3f485b;
    background-color: transparent;
}
#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_filter input[type=search], #wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_length select {
    padding: 5px !important;
    border-radius: 25px !important;
    border: 1px solid #3f485b !important;
}
#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_filter input[type=search]:focus {
    padding: 5px !important;
    border-radius: 25px !important;
    border: 1px solid #3f485b !important;
}
#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_length select {
    padding: 5px !important;
    border-radius: 3px !important;
    border: 1px solid #dddddd !important;
    background-color: transparent;
}
#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e_length option {
    
    color: #000;
	background-color: #fff;
	font-size:12px;
	text-align:center;
    font-family: "MuseoSans-300";
}

#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e .package-title {
    color: #fff;
    font-size: 11pt;
    font-weight: normal;
	font-family: "MuseoSans-500";
	text-decoration: none;
} 
#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e td.__dt_col_download_link .btn {
    display: block;
    width: 100%;
    font-family: "MuseoSans-700";
    font-size: 12px;
}

.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: transparent;
    border-color: transparent;
}

.page-item.disabled .page-link {
    color: #fff;
    pointer-events: none;
    cursor: auto;
    background-color: transparent;
    border-color: transparent;
}



.w3eden .page-link:focus{
	z-index:2;outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,0.25)
}

.w3eden .page-link {
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: var(--color-primary);
    background-color: transparent;
    border: 0px solid #dee2e6;
	text-decoration: none; 
	font-size: 17px;
    font-family: "MuseoSans-300";
    font-weight: bold;
}

.w3eden .page-link:hover{
	
	
}

.w3eden .table-striped>tbody>tr:nth-of-type(odd) {
    background-color: transparent;
}

#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e th {
    background-color: rgba(0,0,0,0.04);
    border-bottom: 1px solid #4e5669;
    text-align: center;
    vertical-align: middle;
}
.table.table-striped tr:hover{
    background: transparent;
}
table.dataTable.display tbody tr:hover.selected{background-color:transparent}

.w3eden .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: transparent;
    background-clip: padding-box;
    border-radius: 25px;
    border: 2px solid #3f485b;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	font-family: "MuseoSans-300";
}


.w3eden .pagination li a, .w3eden .pagination li span{
    padding: 0 15px;
    margin: 2px;
    min-width: 40px;
    line-height: 32px;
    text-align: center;
    border-radius: 3px;
    display: block;
}
.w3eden .pagination li span{
    background: transparent;
    border-color: transparent;
    color: #fff;

}

.w3eden .pagination li a.disabled,
.w3eden .pagination li a.current{
    font-weight: 900;
    border: 0px solid rgba(61, 115, 207, 0.47);
    color: #fff;
}
.w3eden .pagination li a:not(.disabled):not(.current):hover{
    border: 0px solid var(--color-primary);
    text-decoration: none;
}



#wpdmmydls-f17f2f16717aa376c41aef034fe2bc0e {
    border-bottom: 1px solid #4e5669;
    border-top: 1px solid #4e5669;
    font-size: 12pt;
	font-family: "MuseoSans-500";
	font-weight: normal;
    min-width: 100%;
}

@media(prefers-reduced-motion:reduce){
	.w3eden .form-control{transition:none}
}
	.w3eden .form-control::-ms-expand{background-color:transparent;border:0}
	.w3eden .form-control:focus{
		color:#fff;background-color:transparent;border-radius: 25px;border: 2px solid #3f485b;
		font-family: "MuseoSans-300";
	}
	.w3eden .form-control::-webkit-input-placeholder{color:transparent;opacity:0}
	.w3eden .form-control::-moz-placeholder{color:transparent;opacity:0}
	.w3eden .form-control:-ms-input-placeholder{color:transparent;opacity:0}
	.w3eden .form-control::-ms-input-placeholder{color:transparent;opacity:0}
	.w3eden .form-control::placeholder{color:transparent;opacity:0}
	.w3eden .form-control:disabled,.w3eden .form-control[readonly]{background-color:transparent;opacity:0}
	.w3eden select.form-control:focus::-ms-value{color:#495057;background-color:transparent;opacity:0}
	.w3eden .form-control-lg{height:calc(1.5em + 1rem + 2px);padding:.5rem 1rem;font-size:1.25rem;line-height:1.5;border-radius:.3rem;opacity:0}
	.w3eden select.form-control[size],.w3eden select.form-control[multiple]{height:auto;opacity:0}
	.w3eden textarea.form-control{height:auto; opacity:0}

.table-striped tbody tr:nth-of-type(2n+1){
    background-color: rgba(0,0,0,.02);
}
.card-width-table .card-footer,
.table tr td{
    border-top: 1px solid #4e5669 !important;
}
.table.table-striped tr:hover{
    background: #4E5669 !important;
}
.table thead th {
    border: 0 !important;
    background: #d4dbe3;
    border-bottom: 1px solid #4e5669 !important;
}

.table tr:first-child td{
    border-top: 0 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button{
	box-sizing:border-box;
	display:inline-block;min-width:1.5em;
	padding:.5em 1em;margin-left:2px;
	text-align:center;text-decoration:none!important;
	cursor:pointer;	*cursor:hand;color:#fff!important;border:0px solid transparent
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current,.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
	color:#fff!important;border:0px solid #cacaca;background-color:transparent;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active{
	cursor:default;color:#fff!important;border:0px solid transparent;background:transparent;box-shadow:none
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
	box-sizing:border-box;
	display:inline-block;min-width:1.5em;
	padding:.5em 1em;margin-left:2px;
	text-align:center;text-decoration:none!important;
	cursor:pointer;	*cursor:hand;color:#fff!important;border:0px solid transparent
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current{
	box-sizing:border-box;
	display:inline-block;min-width:1.5em;
	padding:.5em 1em;margin-left:2px;
	text-align:center;text-decoration:none!important;
	cursor:pointer;	*cursor:hand;color:#000!important;border:0px solid transparent
}
.dataTables_wrapper .dataTables_paginate .paginate_button:active{
	outline:0;background-color:transparent;
}




.page-link {
  position: relative;
  display: block;
  padding: 0.5rem 0.75rem;
  margin-left: -1px;
  line-height: 1.25;
  color: #000;
  background-color: transparent;
  border: 1px solid transparent;
}
 
.page-link:hover {
  z-index: 2;
  color: #000;
  text-decoration: none;
  background-color: transparent;
  border-color: transparent;
}

.page-link:focus {
  z-index: 2;
  outline: 0;
  box-shadow: none;
}

.page-link:not(:disabled):not(.disabled) {
  cursor: pointer;
}
 
 



/* Calendario */

.tribe-common .tribe-common-c-btn, .tribe-common a.tribe-common-c-btn {
    color: #141827;
    font-family: "MuseoSans-500";
    font-size: 14px;
    line-height: 1.62;
    font-weight: 400;
    font-weight: 700;
    border: 0;
    cursor: pointer;
    display: inline-block;
    height: auto;
    padding: 0;
    text-decoration: none;
    width: auto;
    border-radius: 4px;
    color: #fff;
    text-align: center;
    transition: background-color .2s ease;
    background-color: #4375D9;
    padding: 11px 20px;
    width: 100%;
}

</style>

<!-- bloc-5 nueva plantilla BEGIN-->
<div class="container-fluid footer-bk bloc none bgc-footer d-bloc footer-bloc pt-5 pb-5" id="bloc-5"><!-- pt-5 pb-5-->
	<div class="row justify-content-around align-items-stretch footer-row ml-4 mr-4 mx-auto">
		<div class="col-sm d-flex flex-column justify-content-between order-sm-3 order-md-3 order-lg-3 mb-4 mb-sm-0 mb-md-0 mb-lg-0 mb-xl-0">						
			 <div class="row mb-2">
				<div class="col-sm">
					<div class="col-follow-icons">
					<h6 class="mg-md text-lg-center text-md-center text-sm-center text-center mg-sm-xs footer-correction footer-text" id="label-comunidad">
						&Uacute;nete a nuestra comunidad<span class="text-span-color"><span class="special-tag-for-editing-text-with-html"></span></span>
					</h6>
					<div class="follow-icon">
						<div class="social-link-bric text-center" id="follow-icons">
							<?php if($facebook_url !=''){?>
								<a href="<?php echo $facebook_url;?>" class="facebook-link" target="_blank">
									<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Facebook.svg" data-appear-anim-style="fadeInUp" alt="" class="img-fluid img-follow-icon-style float-lg-none pad-icons-head animated fadeInUp pulse-hvr"  />
								</a>
							<?php } if($ig_url !=''){?>
								<a href="<?php echo $ig_url;?>" class="instagram-link" target="_blank">
									<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Instagram.svg" data-appear-anim-style="fadeInUp" alt="" class="img-fluid img-follow-icon-style float-lg-none pad-icons-head animated fadeInUp pulse-hvr"  />
								</a>
							<?php } if($twitter_url !=''){?>
								<a href="<?php echo $twitter_url;?>" class="twitter-link" target="_blank">
									<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Twitter.svg" data-appear-anim-style="fadeInUp" alt="" class="img-fluid img-follow-icon-style float-lg-none pad-icons-head animated fadeInUp pulse-hvr"  />
								</a>
							<?php } if($yt_url !=''){?>
								<a href="<?php echo $yt_url;?>" class="youtube-link" target="_blank">
									<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Youtube.svg" data-appear-anim-style="fadeInUp" alt="" class="img-fluid img-follow-icon-style float-lg-none pad-icons-head animated fadeInUp pulse-hvr"  />
								</a>
							<?php }?>
						</div>
					</div>
					</div>
				 </div>	
			</div>
			<div class="row justify-content-end mt-2">
				<div class="col-sm justify-content-end">
					<div class="col-links"> 
						<?php if($mapasitio !=''){?>
						<h6 class="footer-text">
						<a href="<?php echo $mapasitio; ?>" class="a-btn a-block ltc-white text-center link-font text-lg-right text-md-right text-sm-right" id="link1">Mapa del Sitio</a>
						</h6>
						<?php } if($politicaweb !=''){?>
						<h6 class="footer-text">
						<a href="<?php echo $politicaweb; ?>" class="a-btn a-block ltc-white text-center link-font text-lg-right text-md-right text-sm-right" id="link2">Politica Web</a>
						</h6>
						<?php } if($preguntas !=''){?>
						<h6 class="footer-text">
						<a href="<?php echo $preguntas; ?>" class="a-btn a-block ltc-white text-center link-font text-lg-right text-md-right text-sm-right" id="link3">Preguntas Frecuentes</a>
						</h6>
						<?php } if($cartaderecho !=''){?>
						<h6 class="footer-text">
						<a href="<?php echo $cartaderecho; ?>" class="a-btn a-block ltc-white text-center link-font link1 text-lg-right text-md-right text-sm-right" id="link4">Carta de Derecho</a>
						</h6>
					   <?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm d-flex flex-column justify-content-between mb-4 mb-sm-0 mb-md-0 mb-lg-0 mb-xl-0">
			<div class="row">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center mb-2 my-sm-auto my-md-auto my-lg-auto my-xl-auto text-center d-sm-none d-md-none d-lg-block">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Ubicacion.svg" alt="" class="img-fluid img-ubicacion-style float-lg-none"  />
				</div>
				<div class="col-xs-12 col-sm-11 col-md-10 col-lg-10  col-title-institucion">
					<h6 class="footer-text text-center text-sm-left text-md-left text-lg-left text-xl-left" id="title-institucion">
						<span class="text-capitalize"><?php echo $nombre_institucion;?></span><BR/>
						<?php echo $direccion_institucion;?>
					</h6>
					
				</div>
			</div>	
			<div class="row align-items-center">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center mt-2  mb-2 my-sm-auto my-md-auto my-lg-auto my-xl-auto text-center d-sm-none d-md-none d-lg-block">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Telefono.svg" data-appear-anim-style="fadeInUp" alt="" class="img-fluid img-telefono-style float-lg-none pad-icons-head animated fadeInUp"  />
				</div>
				<div class="col-xs-12 col-sm-11 col-md-10 col-lg-10  col-telefono-institucion">
					<h6 class="text-center text-lg-left text-sm-left mg-md h6.footer-text" id="tel-institucion">
						<a href="tel:+503<?php echo $numero_telefonico;?>" ><?php echo $numero_telefonico;?></a>
					</h6>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center mt-2 mb-2 my-sm-auto my-md-auto my-lg-auto my-xl-auto text-center d-sm-none d-md-none d-lg-block">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Correo.svg" data-appear-anim-style="fadeInUp" class="img-fluid img-correo-style float-lg-none pad-icons-head animated fadeInUp" alt="" />
				</div>
				<div class="col-xs-12 col-sm-11 col-md-10 col-lg-10  col-email-institucion">
					<h6 class="mg-md text-center text-lg-left text-sm-left text-md-left h6.footer-text" id="mail-institucion">
						<a href="mailto:<?php echo $correo_institucion;?>" title="Correo electrónico de contacto"><?php echo $correo_institucion;?></a>
					</h6>
				</div>
			</div>
		</div>
		<div class="col-sm my-auto mt-4 mb-4"> 
			<div  class="d-none d-sm-block d-md-block d-lg-block d-xl-block">			
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Logo_Gobierno.svg" data-appear-anim-style="fadeInUp" class="img-fluid mx-auto d-block lazyloaded animated fadeInUp img-logo-gobierno-style" alt="Logo del Gobierno de El Salvador" />
			</div>
			<div  class="d-sm-none d-md-none d-lg-none d-xl-none">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/Logo_GOES_horizontal.svg" data-appear-anim-style="fadeInUp" class="img-fluid mx-auto d-block lazyloaded" alt="Logo del Gobierno de El Salvador" />
			</div>
		</div>
	</div>
</div>				
<!-- bloc-5 nueva plantilla END-->

<!-- GoBack Button -->
<a class="bloc-button btn btn-d scrollGoBack" onclick="history.back()"><span class="fa fa-chevron-left"></span></a>
<!-- GoBack Button END-->

<!-- ScrollToTop Button -->
<a class="bloc-button btn btn-d scrollToTop" onclick="scrollToTarget('1',this)"><span class="fa fa-chevron-up"></span></a>
<!-- ScrollToTop Button END-->

<script>
    function getResolution() {
        alert("Your screen resolution is: " + screen.width + "x" + screen.height);
    }
    </script>
     
    <!--button type="button" onclick="getResolution();">Get Resolution</button-->

<!-- Main container END --> 

<script src="<?php echo bloginfo('template_directory'); ?>/js/jquery-3.3.1.js?2644"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/bootstrap.bundle.js?8747"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/blocs.js?1340"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/jqBootstrapValidation.js"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/formHandler.js?7891"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/lazysizes.min.js" defer></script>
<script>

$(".menu-item").hover(function() {
  	var dropdown = $(this).find(".dropdown:first");
  	dropdown.addClass("show");
	dropdown.addClass("open");
  	dropdown.find("a:first").attr("aria-expanded",true);
	var dropdown_menu = dropdown.find(".dropdown-menu:first");
	dropdown_menu.addClass("show");
  	dropdown_menu.addClass("open");	
  	var parent_id = dropdown.closest("ul").attr("id");
  	if(parent_id != "menu-principal"){
		dropdown_menu.attr("style","top: 0px; left: 200px;");
  	}
});

$(".menu-item").mouseleave(function() {
  	var dropdown = $(this).find(".dropdown:first");
  	dropdown.removeClass("show");
  	dropdown.removeClass("open");
  	dropdown.find("a:first").attr("aria-expanded",false);
	var dropdown_menu = dropdown.find(".dropdown-menu:first");
  	dropdown_menu.removeClass("show");
  	dropdown_menu.removeClass("open");
  	var parent_id = dropdown.closest("ul").attr("id");
  	if(parent_id != "menu-principal"){
		dropdown_menu.removeAttr("style");
  	}
});
</script>
<!-- Additional JS END -->

<!-- Preloader -->
<div id="page-loading-blocs-notifaction" class="page-preloader"></div>
<!-- Preloader END -->

</body>
</html>
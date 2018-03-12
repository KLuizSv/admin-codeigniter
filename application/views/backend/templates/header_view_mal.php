<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" /> <meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta http-equiv="Cache-Control" content="no-store" /><meta http-equiv="Cache-Control" content="no-cache" /><meta http-equiv="Pragma" content="no-cache" /><meta http-equiv="expires" content="Fri, 18 Jul 2014 1:00:00 GMT" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php if(!isset($seo)): ?>
<title><?php echo $this->configuracion['titulo']; ?></title>
<meta name="keywords" content="<?php echo $this->configuracion['keywords']; ?>" />
<meta name="description" content="<?php echo $this->configuracion['description']; ?>" />
<?php else: ?>
<title><?php echo $seo['titulo']; ?></title>
<meta name="keywords" content="<?php echo $seo['keywords']; ?>" />
<meta name="description" content="<?php echo $seo['description']; ?>" />
<?php endif; ?>
<meta name="viewport" content="width=device-width, maximum-scale=1"/>
<meta name="language" content="es" />
<meta name="robots" content="index,follow"/>
<meta name="locality" content="Lima, Peru" />
<link rel="shortcut icon" href="<?php echo base_view(); ?>favicon.ico" />
<link rel="stylesheet" href="<?php echo base_view(); ?>css/style.css" />
<link href="<?php echo backend_view(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_view(); ?>css/media-queries.css" rel="stylesheet">
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script src="<?php echo base_view(); ?>js/script.js"></script>
<script src="<?php echo base_view(); ?>js/jquery-1.7.1.min.js"></script>
<?php // Colores activados desde el Panel de Administración ?>
<style type="text/css">
	.titulo_header{color:<?php echo $this->configuracion['color_texto_cabecera']; ?> !important;}
	body{
		background:<?php echo $this->configuracion['color_fondo']; ?><?php if($this->configuracion['imagen_fondo'] != ''): ?> url("<?php echo base_url(); ?>uploads/<?php echo $this->configuracion['imagen_fondo']; ?>") fixed<?php endif; ?><?php if($this->configuracion['tipo_fondo'] == '0'): ?> repeat center top<?php else: ?> center center no-repeat<?php endif; ?>;
		<?php if($this->configuracion['tipo_fondo'] == '1'): ?>
			background-size: cover;
		<?php endif; ?>
	}
	#menu{background-color:<?php echo $this->configuracion['color_fondo_menu']; ?> !important;}
	#megamenu{border-color:<?php echo $this->configuracion['color_fondo_menu_hover']; ?> !important;}
	#megamenu .col h3{color:<?php echo $this->configuracion['color_texto_cabecera']; ?> !important;}
	#navbar li a:hover, #navbar li a.open{background-color:<?php echo $this->configuracion['color_fondo_menu_hover']; ?> !important;}
</style>
<!-- Tab-->
<script type="text/javascript"> 
	$(document).ready(function(){

		$(".oculto").hide();
		$("#div1").show();
		         
		$(".mo").click(function(){

			var nodo = $(this).attr("href"); 
		
			if ($(nodo).is(":visible")){
			<!--$(nodo).hide();-->
				return false;
		 	}
		 	else
		 	{
				$(".oculto").hide();  
				$(nodo).fadeToggle( "slow" );
				return false;
			}
		});
	});
 </script>
 <!-- FIN Tab--> 
 
<!--Carousel--> 
<script type="text/javascript" src="<?php echo base_view(); ?>js/jquery.flexisel.js"></script>
<script type="text/javascript">
$(document).ready(function() {   
	// Slider Primero..
	$("#flexiselDemo1").flexisel({ visibleItems: 8, autoPlay: false });

	// Slider Tercero..
    $("#flexiselDemo3").flexisel({
        visibleItems: 5,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 3000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });
});
</script>
<!--FIN Carousel--> 
		
<!--Eventos slider-->
<link type="text/css" rel="stylesheet" href="<?php echo base_view(); ?>css/rhinoslider-1.05.css" />  
<script type="text/javascript" src="<?php echo base_view(); ?>js/rhinoslider-1.05.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#slider_interes1').rhinoslider({
			showTime: 7000,
			easing: 'linear',
			controlsMousewheel: false,
			controlsKeyboard: false,
			controlsPrevNext: false,
			controlsPlayPause: false,
			autoPlay: true,
			pauseOnHover: false,
			showBullets: 'ever',
			changeBullets: 'before',
			showControls: 'always',
			slidePrevDirection: 'toRight',
			slideNextDirection: 'toLeft',
			callBackInit: function() {
				setTimeout(function() {
					$('#slider_interes2').rhinoslider({
						showTime: 7000,
						easing: 'linear',
						controlsMousewheel: false,
						controlsKeyboard: false,
						controlsPrevNext: false,
						controlsPlayPause: false,
						autoPlay: true,
						pauseOnHover: false,
						showBullets: 'ever',
						changeBullets: 'before',
						showControls: 'always',
						slidePrevDirection: 'toRight',
						slideNextDirection: 'toLeft',
						callBackInit: function() {
							setTimeout(function() {
								$('#slider_interes3').rhinoslider({
									showTime: 7000,
									partDelay: 15000,
									easing: 'linear',
									controlsMousewheel: false,
									controlsKeyboard: false,
									controlsPrevNext: false,
									controlsPlayPause: false,
									autoPlay: true,
									pauseOnHover: false,
									showBullets: 'ever',
									changeBullets: 'before',
									showControls: 'always',
									slidePrevDirection: 'toRight',
									slideNextDirection: 'toLeft'
								});
							}, 1300);
						}
					});
				}, 1500);
			}
		});

		$('#slider_videos').rhinoslider({
			showTime: 7000,
			easing: 'linear',
			controlsMousewheel: false,
			controlsKeyboard: false,
			controlsPrevNext: false,
			controlsPlayPause: false,
			autoPlay: true,
			pauseOnHover: true,
			showBullets: 'ever',
			changeBullets: 'before',
			showControls: 'always',
			slidePrevDirection: 'toRight',
			slideNextDirection: 'toLeft'
		});
	});
</script>
<!--Fin Eventos slider-->    

<!--fancybox-->
	<!--script type="text/javascript" src="<?php echo base_view(); ?>http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script-->
	<script type="text/javascript" src="<?php echo base_view(); ?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_view(); ?>fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript" src="<?php echo base_view(); ?>fancybox/video.js"></script>
    
	<script type="text/javascript">
		$(document).ready(function() {
			/*  Examples - images  */
			$("a#example1").fancybox();
					
			$("a#example7").fancybox({
				'titlePosition'	: 'inside'
			});

			$("a#example8").fancybox({
				'titlePosition'	: 'inside'
			});
			
			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over" style="float:right;">Imagen ' +  (currentIndex + 1) + ' de ' + currentArray.length + '</span><span id="fancybox-title-over" style="float:left;">' + (title.length ? ' ' + title : '') + '</span>';
				}
			});
			/*  Examples - various */

			$("#various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
		});
	</script>
<!--Fin fancybox-->

 <script type="text/javascript" src="<?php echo base_view(); ?>js/megamenu.js"></script>
    <!-- slider Home--> 
<link rel="stylesheet" type="text/css" href="<?php echo base_view(); ?>js_slider/style2.css">
<script language="javascript" type="text/javascript" src="<?php echo base_view(); ?>js_slider/jquery.easing.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_view(); ?>js_slider/script.js"></script>
<script type="text/javascript">

$(document).ready( function() {
	var buttons = { previous:$('#jslidernews2 .button-previous') , next:$('#jslidernews2 .button-next') };

	$('#jslidernews2').lofJSidernews({
		interval:5000,
		easing:'easeInOutQuad',
		duration:1200,
		auto:true,
		mainWidth:614,
		mainHeight:300,
		navigatorHeight:75,
		navigatorWidth:350,
		maxItemDisplay:4,
		buttons:buttons
	});

	$('.ico_up').click(function(){
		$('body,html').animate({scrollTop : 0}, 500); return false;
	});
});

</script>
<!-- Fin slider Home-->

</head>
<body>
	<?php if(current_url() != base_url().'intranet'): ?>
	<header>
		<ul class="top">
			<li>
				<form action="<?php echo base_url(); ?>busqueda" method="GET">
					<?php if(!isset($_REQUEST['url'])): ?>
						<?php if(strpos(current_url(), 'transparencia') == FALSE): ?>
							<input type="hidden" value="portal" name="url" />
						<?php else: ?>
							<input type="hidden" value="transparencia" name="url" />
						<?php endif; ?>
					<?php else: ?>
						<input type="hidden" value="<?php echo $_REQUEST['url']; ?>" name="url" />
					<?php endif; ?>
					<input name="busqueda" style="padding:4px 15px;width: 190px;margin:0px 10px;border: solid 1px #6b646c;background: #d6cad4;font-size: 12px;" type="search" width="150" placeholder="Buscar..."<?php if(isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] != ''): ?> value="<?php echo $_REQUEST['busqueda']; ?>"<?php endif; ?>>
					<input type="submit" style="display:none;">
				</form>
			</li>
			<?php if(strpos(current_url(), 'transparencia') == FALSE): ?>
				<li><a href="<?php echo base_url(); ?>contactenos"><i class="fa fa-group"></i> Portal de Transparencia Estándar</a></li>
				<li><span>|</span></li>
				<li><a href="<?php echo base_url(); ?>contactenos"><i class="fa fa-group"></i> Contáctenos</a></li>
				<li><span>|</span></li>
				<li><a href="<?php echo base_url(); ?>intranet" id="example7"><i class="fa fa-laptop"></i> Intranet</a></li>
			<?php endif; ?>
		</ul>
        
        <?php if(isset($miniweb['tipo'])): ?>
	        <div style="overflow:hidden;width:100%;<?php if($miniweb['imagen_fondo'] != ''): ?>background:url('<?php echo base_url(); ?>uploads/<?php echo $miniweb['imagen_fondo']; ?>') no-repeat;<?php endif; ?>">
	            <div class="cont_header">
	            	<?php if($miniweb['imagen_fondo'] == ''): ?>
	                	<a href="" title="" class="logo_minsa" >
	                		<img src="<?php echo base_url(); ?>uploads/<?php echo $this->configuracion['logo_minsa']; ?>" alt="Logo Ministerio">
	                	</a>
					<?php else: ?>
						<div style="display:block;float:left;width:200px;height:1px;"></div>
					<?php endif; ?>
					<div class="titulo_header"><?php echo $miniweb['titulo']; ?><br />
						<small style="font-size:13px; color:#355550; font-family:Helvetica;"><?php echo $this->configuracion['titulo']; ?></small>
					</div>
					<?php $url = (strpos(current_url(), 'transparencia') == FALSE) ? base_url() : base_url().'transparencia'; ?>
					<a href="<?php echo $url; ?>" title="<?php echo $this->configuracion['titulo']; ?>" class="logo_materno">
						<img src="<?php echo base_url(); ?>uploads/<?php echo $this->configuracion['logo']; ?>" alt="Logo">
					</a>
	            </div>
	        </div>
	    <?php else: ?>
	    	<div style="overflow:hidden;width:100%;">
	            <div class="cont_header">
	                <a href="" title="" class="logo_minsa"><img src="<?php echo base_url(); ?>uploads/<?php echo $this->configuracion['logo_minsa']; ?>" alt="Logo Ministerio"></a>
	                <div class="titulo_header"><?php echo $this->configuracion['titulo']; ?><br/>
	                    <span><?php echo $this->configuracion['subtitulo']; ?></span>
	                </div>
	                <a href="<?php echo base_url(); ?>" title="<?php echo $this->configuracion['titulo']; ?>" class="logo_materno"><img src="<?php echo base_url(); ?>uploads/<?php echo $this->configuracion['logo']; ?>" alt="Logo"></a>
	            </div>
	        </div>
    	<?php endif; ?>
        
        <?php if((!isset($miniweb) || count($miniweb) == 0) || (count($miniweb) > 0 && $miniweb['tipo'] == 0 && $miniweb['mostrar_menu'] != 1)): ?>
			<nav id="menu">
			    <div class="wrap">
			      <div class="clearfix">
			      	<a href="javascript:void(0);" class="icon-menu"><span></span></a>
			      </div>
			      <ul id="navbar" class="clearfix">
			        <li class="first"><a href="<?php echo base_url(); ?>">INICIO</a></li>
			        <li><a href="javascript:;">INSTITUCIONAL</a>
			          <div class="megacontent">
			          	<?php $item = 0; ?>
			          	<?php foreach($this->menu_institucional as $key => $value): ?>
			          		<?php if($item % 5 == 0 && $item > 0): ?><div class="col" style="display:block;width:98% !important;"></div><?php endif; ?>
			          		<div class="col">
				          		<?php if(isset($value['id']) && $value['tipo_padre'] == 1): ?>
				          			<?php // $value['titulo'] = ($value['id_padre'] == 0) ? ($value['titulo']) : $value['titulo']; ?>
				          			<?php if($value['tipo'] != 0): ?>
				          				<a<?php if($v['tipo'] == 2): ?> target="<?php echo $v['destino']; ?>"<?php endif; ?> href="<?php echo base_url(); ?>institucional/<?php echo $value['alias']; ?>/<?php echo $value['id']; ?>"><h3><?php echo $value['titulo']; ?></h3></a>
				          			<?php else: ?>
										<h3><?php echo ($value['titulo']); ?></h3>
									<?php endif; ?>
									<ul class="navlist">
										<?php foreach($this->menu_institucional[$value['id']] as $k => $v): ?>
											<li><a<?php if($v['tipo'] == 2): ?> target="<?php echo $v['destino']; ?>"<?php endif; ?> href="<?php echo base_url(); ?>institucional/<?php echo $v['alias']; ?>/<?php echo $v['id']; ?>"><?php echo $v['titulo']; ?></a></li>
										<?php endforeach; ?>
									</ul>
									<?php $item++; ?>
						        <?php endif; ?>
							</div>
			        	<?php endforeach; ?>
			            
			          </div><!-- @end .megacontent -->
			        </li>
			        <li>
			          <a href="javascript:;">SERVICIOS</a>
			          <div class="megacontent">
			          	<?php $item = 0; ?>
			          	<?php foreach($this->menu_institucional as $key => $value): ?>
			          		<?php if($item % 5 == 0 && $item > 0): ?><div class="col" style="display:block;width:98% !important;"></div><?php endif; ?>
			          		<div class="col">
			            		<?php if(isset($value['id']) && $value['tipo_padre'] == 3): ?>
			            			<?php // $value['titulo'] = ($value['id_padre'] == 0) ? mb_strtoupper($value['titulo']) : $value['titulo']; ?>
									<?php if($value['tipo'] != 0): ?>
				          				<a<?php if($v['tipo'] == 2): ?> target="<?php echo $v['destino']; ?>"<?php endif; ?> href="<?php echo base_url(); ?>servicios/<?php echo $value['alias']; ?>/<?php echo $value['id']; ?>"><h3><?php echo $value['titulo']; ?></h3></a>
				          			<?php else: ?>
										<h3><?php echo ($value['titulo']); ?></h3>
									<?php endif; ?>
									<ul class="navlist">
										<?php foreach($this->menu_institucional[$value['id']] as $k => $v): ?>
											<li><a<?php if($v['tipo'] == 2): ?> target="<?php echo $v['destino']; ?>"<?php endif; ?> href="<?php echo base_url(); ?>servicios/<?php echo $v['alias']; ?>/<?php echo $v['id']; ?>"><?php echo $v['titulo']; ?></a></li>
										<?php endforeach; ?>
									</ul>
									<?php $item++; ?>
						        <?php endif; ?>
					        </div>
			        	<?php endforeach; ?>
			          </div><!-- @end .megacontent -->
			        </li>
			        <li>
			          <a href="javascript:;">PADRES</a>
			          <div class="megacontent">
			          	<?php $item = 0; ?>
			          	<?php foreach($this->menu_institucional as $key => $value): ?>
			          		<?php if($item % 5 == 0 && $item > 0): ?><div class="col" style="display:block;width:98% !important;"></div><?php endif; ?>
			          		<div class="col">
			            		<?php if(isset($value['id']) && $value['tipo_padre'] == 2): ?>
			            			<?php // $value['titulo'] = ($value['id_padre'] == 0) ? mb_strtoupper($value['titulo']) : $value['titulo']; ?>
									<?php if($value['tipo'] != 0): ?>
				          				<a<?php if($v['tipo'] == 2): ?> target="<?php echo $v['destino']; ?>"<?php endif; ?> href="<?php echo base_url(); ?>padres/<?php echo $value['alias']; ?>/<?php echo $value['id']; ?>"><h3><?php echo $value['titulo']; ?></h3></a>
				          			<?php else: ?>
										<h3><?php echo ($value['titulo']); ?></h3>
									<?php endif; ?>
									<ul class="navlist">
										<?php foreach($this->menu_institucional[$value['id']] as $k => $v): ?>
											<li><a<?php if($v['tipo'] == 2): ?> target="<?php echo $v['destino']; ?>"<?php endif; ?> href="<?php echo base_url(); ?>padres/<?php echo $v['alias']; ?>/<?php echo $v['id']; ?>"><?php echo $v['titulo']; ?></a></li>
										<?php endforeach; ?>
									</ul>
									<?php $item++; ?>
						        <?php endif; ?>
					        </div>
			        	<?php endforeach; ?>
			          </div><!-- @end .megacontent -->
			        </li>

			        <li><a href="<?php echo $this->configuracion['transparencia']; ?>" target="_blank"><i class="fa fa-search"></i> Portal de Transparencia</a></li>
			      </ul>
			      <div id="megamenu" class="clearfix"></div>
			    </div>
			</nav>
		<?php endif; ?>
	</header>
<?php endif; ?>
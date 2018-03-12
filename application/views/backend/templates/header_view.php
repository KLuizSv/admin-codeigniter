<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="expires" content="Fri, 18 Jul 2014 1:00:00 GMT" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Jockerds">
    <link rel="shortcut icon" href="<?php echo backend_view(); ?>images/favicon.png">
    <title>Administraci&oacute;n - <?php echo $this->configuracion['titulo']; ?></title>
    <link href="<?php echo backend_view(); ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/select2.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/alerts.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>assets/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>assets/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/clndr.css" rel="stylesheet">
    <!--clock css-->
    <link href="<?php echo backend_view(); ?>assets/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link href="<?php echo backend_view(); ?>assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="<?php echo backend_view(); ?>assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo backend_view(); ?>assets/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" href="<?php echo backend_view(); ?>assets/morris-chart/morris.css">
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo backend_view(); ?>assets/bootstrap-switch-master/build/css/bootstrap3/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/jquery-multi-select/css/multi-select.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/jquery-tags-input/jquery.tagsinput.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo backend_view(); ?>assets/nestable/jquery.nestable.css" />

    <!-- Custom styles for this template -->
    <link href="<?php echo backend_view(); ?>css/validationEngine.jquery.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/style-responsive.css" rel="stylesheet"/>
    <link href="<?php echo backend_view(); ?>assets/iCheck-master/skins/square/square.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- script src="<?php echo backend_view(); ?>fckeditor/fckeditor.js"></script -->
</head>
<body>
<iframe name="oculto" style="display:none;"></iframe>
<section id="container">
<!--header start-->
<header class="header clearfix">
<!--logo start-->
<div class="brand" style="padding-right:0px !important;padding-left:50px !important;padding-top:5px !important;padding-bottom:5px !important;">
    <a href="<?php echo backend_url(); ?>">
        <img src="<?php echo base_url(); ?>uploads/<?php echo $this->configuracion['logo']; ?>" alt="Logo" />
    </a>
    <?php /*
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
    */ ?>
</div>
<!--logo end-->

<div class="nav notify-row" id="top_menu">
    <ul class="nav top-menu">
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">

                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">0</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <li>
                    <p><strong>Notificaciones</strong></p>
                </li>
                <!--li>
                    <div class="alert alert-info clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #1 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-danger clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #2 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-success clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #3 overloaded.</a>
                        </div>
                    </div>
                </li-->

            </ul>
        </li>
        <?php if(MY_Controller::mostrar_session('nivel') != 0): ?>
            <li class="tooltips" data-title="<?php echo $this->lang->line('inicio'); ?>" data-placement="bottom">
                <a href="<?php echo base_url(); ?>" target="_home">
                    <i class="fa fa-home"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<div class="top-nav clearfix">
    <ul class="nav pull-right top-menu">
        <?php /*
        <li class="dropdown language">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <?php if(isset($_SESSION['language'])): ?>
                    <?php if($this->session->userdata('language') == 'espanol'): ?>
                        <img alt="" src="<?php echo backend_view(); ?>images/flags/es.png">
                        <span class="username">ES</span>
                        <b class="caret"></b>
                    <?php elseif($this->session->userdata('language') == 'english'): ?>
                        <img alt="" src="<?php echo backend_view(); ?>images/flags/us.png">
                        <span class="username">US</span>
                        <b class="caret"></b>
                    <?php endif; ?>
                <?php else: ?>
                <img alt="" src="<?php echo backend_view(); ?>images/flags/es.png">
                <span class="username">ES</span>
                <b class="caret"></b>
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu">
                <li><a href="javascript:;" onclick="javascript:idioma('espanol');"><img alt="" src="<?php echo backend_view(); ?>images/flags/es.png"> <?php echo $this->lang->line('idioma_espanol'); ?></a></li>
                <li><a href="javascript:;" onclick="javascript:idioma('english');"><img alt="" src="<?php echo backend_view(); ?>images/flags/us.png"> <?php echo $this->lang->line('idioma_ingles'); ?></a></li>
                <li><a href="javascript:;" onclick="javascript:idioma('aleman');"><img alt="" src="<?php echo backend_view(); ?>images/flags/de.png"> German</a></li>
                <li><a href="javascript:;" onclick="javascript:idioma('ruso')"><img alt="" src="<?php echo backend_view(); ?>images/flags/ru.png"> Russian</a></li>
                <li><a href="javascript:;" onclick="javascript:idiomta('frances');"><img alt="" src="<?php echo backend_view(); ?>images/flags/fr.png"> French</a></li>
            </ul>
        </li>
        */ ?>

        <li class="dropdown tooltips" data-title="<?php echo MY_Controller::mostrar_session('nombres').' '.MY_Controller::mostrar_session('apellidos'); ?>" data-placement="left">
            <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                <?php if(isset($_SESSION[$this->session_name])): ?>
                    <img alt="<?php echo MY_Controller::mostrar_session('imagen'); ?>" style="max-height:33px;" src="<?php echo base_url(); ?>uploads/33x33/<?php echo MY_Controller::mostrar_session('imagen'); ?>">
                <?php endif; ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="javascript:;" onclick="javascript:abrir_pestania('perfil', this);" data-title="<?php echo $this->lang->line('usuario'); ?>" data-icon="fa-user"><i class="fa fa-user"></i> <?php echo $this->lang->line('usuario'); ?></a></li>
                <li><a href="javascript:;" onclick="javascript:abrir_pestania('contrasenia', this);" data-title="<?php echo $this->lang->line('contrasenia'); ?>" data-icon="fa-lock"><i class="fa fa-lock"></i> <?php echo $this->lang->line('contrasenia'); ?></a></li>
            </ul>
        </li>

        <li data-title="<?php echo $this->lang->line('salir'); ?>" class="tooltips" data-placement="bottom">
            <div class="toggle-left-box" onclick="javascript:cerrar_sesion();">
                <div class="fa fa-power-off"></div>
            </div>
        </li>
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<?php /*
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li><a href="<?php echo backend_url(); ?>"><i class="fa fa-home"></i><span> <?php echo $this->configuracion['titulo']; ?></span></a></li>
                <?php if(MY_Controller::mostrar_session('nivel') == 0): ?>
                    <li><a href="javascript:;" onclick="javascript:abrir('backend_menu');"><i class="fa fa-th-list"></i><span> <?php echo $this->lang->line('backend_menu'); ?></span></a></li>
                <?php endif; ?>
                <?php if(MY_Controller::mostrar_session('nivel') == 0 || MY_Controller::mostrar_session('nivel') == 1): ?>                    
                    <li><a href="javascript:;" onclick="javascript:abrir_pestania('configuracion');"><i class="fa fa-cogs"></i><span> <?php echo $this->lang->line('configuracion'); ?></span></a></li>
                <?php endif; ?>
                <?php foreach(MY_Controller::mostrar_menu() as $key => $value): ?>
                    <?php if(isset($this->permisos[$key]) || MY_Controller::mostrar_session('nivel') == 0 || MY_Controller::mostrar_session('nivel') == 1): ?>
                        <li><a href="javascript:;" onclick="javascript:abrir('<?php echo $value['url'] ?>');"><i class="fa <?php echo $value['icono']; ?>"></i><span> <?php echo $this->lang->line($value['url']); ?></span></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>        
<!-- sidebar menu end-->
    </div>
</aside>
*/ ?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content" style="margin-left:0px;display:none;">
    <section class="wrapper content" style="margin-top:0px;">
        <div class="col-md-12" id="message">
            <div class="alert alert-warning message" style="display:none;"></div>
        </div>

        <?php $tipo_usuario = array('Administrador General', 'Usuario Administrador', 'Usuario General', 'Usuario Administrador', 'Usuario General'); ?>

<div class="col-md-12" style="margin-bottom:10px;">
    <div class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo backend_url(); ?>">INICIO</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <?php if(MY_Controller::mostrar_session('nivel') == 0): ?>
                    <li><a href="javascript:;" onclick="javascript:abrir('backend_menu', this);" data-title="<?php echo $this->lang->line('backend_menu'); ?>" data-icon="fa-th-list"><i class="fa fa-th-list"></i> Menú Principal</a></li>
                <?php endif; ?>
                <?php if(MY_Controller::mostrar_session('nivel') == 0 || MY_Controller::mostrar_session('nivel') == 1 || MY_Controller::mostrar_session('nivel') == 3): ?>
                    <li><a href="javascript:;" onclick="javascript:abrir_pestania('configuracion', this);" data-title="<?php echo $this->lang->line('configuracion'); ?>" data-icon="fa-cogs"><i class="fa fa-cogs"></i> Configuración</a></li>
                    <li><a href="javascript:;" onclick="javascript:abrir('usuarios', this);" data-title="<?php echo $this->lang->line('usuarios'); ?>" data-icon="fa-group"><i class="fa fa-group"></i> <?php echo $this->lang->line('usuarios'); ?></a></li>
                <?php endif; ?>
                <?php $menu = MY_Controller::mostrar_menu(); ?>
                <?php if(count($menu) > 0): ?>
                    <?php foreach($menu as $k => $v): ?>
                        <?php if(count($v) == 1): ?>
                            <?php foreach($v as $key => $value): ?>
                                <?php if(!isset($this->items_unlocked[$value['url']])): ?>
                                    <?php if(isset($this->permisos[$value['url']]) || MY_Controller::mostrar_session('nivel') == 0 || MY_Controller::mostrar_session('nivel') == 1): ?>
                                        <li><a href="javascript:;" onclick="javascript:<?php echo $value['metodo']; ?>('<?php echo $value['url']; ?>', this);" data-title="<?php echo $this->lang->line($value['url']); ?>" data-icon="<?php echo $value['icono']; ?>"><i class="fa <?php echo $value['icono']; ?>"></i> <?php echo $this->lang->line($value['url']); ?></a></li>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php foreach($this->items_unlocked[$value['url']] as $a => $b): ?>
                                        <?php $item = $this->module_model->buscar($value['url'], $b); ?>
                                        <?php if(count($item) > 0): ?>
                                            <li><a href="javascript:;" onclick="javascript:actualizar_item('<?php echo $value['url']; ?>', <?php echo $b; ?>);" data-title="<?php echo $item['titulo']; ?>" data-icon="<?php echo $value['icono']; ?>"><i class="fa <?php echo $value['icono']; ?>"></i> <?php echo $item['titulo']; ?></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> <?php echo $k; ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                <?php foreach($v as $key => $value): ?>
                                    <?php if(!isset($items_unlocked[$value['url']])): ?>
                                        <?php if(isset($this->permisos[$value['url']]) || MY_Controller::mostrar_session('nivel') == 0 || MY_Controller::mostrar_session('nivel') == 1): ?>
                                            <li><a href="javascript:;" onclick="javascript:<?php echo $value['metodo']; ?>('<?php echo $value['url']; ?>', this);" data-title="<?php echo $this->lang->line($value['url']); ?>" data-icon="<?php echo $value['icono']; ?>"><i class="fa <?php echo $value['icono']; ?>"></i> <?php echo $this->lang->line($value['url']); ?></a></li>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php foreach($this->items_unlocked[$value['url']] as $a => $b): ?>
                                            <?php $item = $this->module_model->buscar($value['url'], $b); ?>
                                            <li><a href="javascript:;" onclick="javascript:actualizar_item('<?php echo $value['url']; ?>', <?php echo $b; ?>);" data-title="<?php echo $item['titulo']; ?>" data-icon="<?php echo $value['icono']; ?>"><i class="fa <?php echo $value['icono']; ?>"></i> <?php echo $item['titulo']; ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if(MY_Controller::mostrar_session('nivel') == 0 || MY_Controller::mostrar_session('nivel') == 3): ?>
                    <!-- li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Transparencia <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" onclick="javascript:abrir('transparencia_general', this);" data-title="Datos Generales" data-icon="fa-th-list"><i class="fa fa-th-list"></i> Datos Generales</a></li>
                            <li><a href="javascript:;" onclick="javascript:abrir('transparencia_presupuesto', this);" data-title="Presupuesto" data-icon="fa-th-list"><i class="fa fa-th-list"></i> Presupuesto</a></li>
                            <li><a href="javascript:;" onclick="javascript:abrir('transparencia_proyectos', this);" data-title="Proyectos de Inversión " data-icon="fa-th-list"><i class="fa fa-th-list"></i> Proyectos de Inversión</a></li>
                            <li><a href="javascript:;" onclick="javascript:abrir('transparencia_informacion', this);" data-title="Información de Personal" data-icon="fa-th-list"><i class="fa fa-th-list"></i> Información de Personal</a></li>
                            <li><a href="javascript:;" onclick="javascript:abrir('transparencia_adquisiciones_contrataciones', this);" data-title="Adquisiciones y Contrataciones" data-icon="fa-th-list"><i class="fa fa-th-list"></i> Aquisiciones y Contrataciones</a></li>
                            <li><a href="javascript:;" onclick="javascript:abrir('transparencia_indicadores', this);" data-title="Indicadores de Desempeño" data-icon="fa-th-list"><i class="fa fa-th-list"></i> Indicadores de Desempeño</a></li>
                            <li><a href="javascript:;" onclick="javascript:abrir('transparencia_actividades', this);" data-title="Actividades Oficiales" data-icon="fa-th-list"><i class="fa fa-th-list"></i> Actividades Oficiales</a></li>
                        </ul>
                    </li -->
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php /* ?>
<div class="col-md-3">

    <aside class="profile-nav alt">
        <section class="panel">
            <div class="user-heading alt gray-bg">
                <a href="javascript:;" onclick="javascript:abrir_pestania('perfil', this);" data-title="<?php echo $this->lang->line('usuario'); ?>" data-icon="fa-user">
                    <img alt="<?php echo MY_Controller::mostrar_session('imagen'); ?>" src="<?php echo base_url(); ?>uploads/100x100/<?php echo MY_Controller::mostrar_session('imagen'); ?>">
                </a>
                <h4><?php echo MY_Controller::mostrar_session('nombres'); ?> <?php echo MY_Controller::mostrar_session('apellidos'); ?></h4>
                <p style="font-style:italic;font-size:12px;"><?php echo $tipo_usuario[MY_Controller::mostrar_session('nivel')]; ?></p>
            </div>
            <ul class="nav nav-pills nav-stacked">
                <li><a href="javascript:;" onclick="javascript:abrir_pestania('perfil', this);" data-title="<?php echo $this->lang->line('usuario'); ?>" data-icon="fa-user"> <i class="fa fa-user"></i> <?php echo $this->lang->line('usuario'); ?> <span class="badge label-primary pull-right r-activity"><i class="fa fa-edit"></i></span></a></li>
                <li><a href="javascript:;" onclick="javascript:abrir_pestania('contrasenia', this);" data-title="<?php echo $this->lang->line('contrasenia'); ?>" data-icon="fa-lock"> <i class="fa fa-lock"></i> <?php echo $this->lang->line('contrasenia'); ?> <span class="badge label-primary pull-right r-activity"><i class="fa fa-edit"></i></span></a></li>
                <!-- li><a href="javascript:;" onclick="javascript:sincronizar(this);"> <i class="fa fa-bell-o"></i> Sincronizar Base de Datos</a></li -->
            </ul>
        </section>
    </aside>
</div>
<?php */ ?>

<section style="background:transparent;" class="col-md-12" id="content-main">
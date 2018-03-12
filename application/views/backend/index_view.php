<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="<?php echo backend_view(); ?>favicon.png">
    <title>Administraci&oacute;n - <?php echo $this->configuracion['titulo']; ?></title>
    <link href="<?php echo backend_view(); ?>bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>assets/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>assets/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/clndr.css" rel="stylesheet">
    <!--clock css-->
    <link href="<?php echo backend_view(); ?>assets/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="assets/morris-chart/morris.css">
    <!-- Custom styles for this template -->
    <link href="<?php echo backend_view(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/style-responsive.css" rel="stylesheet"/>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="<?php echo backend_view(); ?>js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo backend_view(); ?>https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="<?php echo backend_view(); ?>https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
  <body class="login-body">
    <div class="container">
      <form class="form-signin" method="POST" action="<?php echo current_url(); ?>" autocomplete="off">
        <!-- h2 class="form-signin-heading"><?php echo ($this->configuracion['titulo'] != '') ? $this->configuracion['titulo'] : 'Ingresar al Sistema'; ?></h2 -->
        <div class="login-wrap" style="padding-bottom:10px;">
            <?php if($this->configuracion['logo'] != ''): ?>
                <img src="<?php echo base_url(); ?>uploads/<?php echo $this->configuracion['logo']; ?>" style="max-width:100%;max-height:100px;margin:0 auto;display:block;" />
            <?php endif; ?>
        </div>
        <?php if(isset($message)): ?>
        <div class="alert alert-danger fade in" style="margin:20px;margin-top:0px;margin-bottom:0px;">
          <button data-dismiss="alert" class="close close-sm" pxe="button">
              <i class="fa fa-times"></i>
          </button>
          <strong>Ocurrió un Error!</strong> <?php echo $message; ?>
        </div>
        <?php endif; ?>
        <div class="login-wrap" style="padding-top:10px;">
            <p> Ingrese los detalles de su cuenta.</p>
            <input type="hidden" name="token" value="<?php echo MY_Controller::mostrar_session('token'); ?>" />
            <input class="form-control" placeholder="Correo Electrónico" required <?php if(isset($correo_electronico) && $correo_electronico === ""){ ?> autofocus=""<?php } ?> name="correo_electronico" type="text"<?php if(isset($correo_electronico)){ ?> value="<?php echo $correo_electronico ?>"<?php } ?>>
            <input class="form-control" placeholder="Contrase&ntilde;a" required <?php if(isset($correo_electronico) && $correo_electronico !== NULL){ ?> autofocus=""<?php } ?> type="password" name="contrasenia">
            <button class="btn btn-lg btn-danger btn-block" type="submit">INGRESAR</button>         
            <br />
            <a class="" href="<?php echo base_url(); ?>"><i class="fa fa-long-arrow-left"></i> Regresar a <?php echo $this->configuracion['titulo']; ?></a>
        </div>
      </form>
    </div>
    <!-- Placed js at the end of the document so the pages load faster -->
    <!--Core js-->
    <script src="<?php echo backend_view(); ?>js/lib/jquery.js"></script>
    <script src="<?php echo backend_view(); ?>assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="<?php echo backend_view(); ?>bs3/js/bootstrap.min.js"></script>
  </body>
</html>
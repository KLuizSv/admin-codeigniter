<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo backend_view(); ?>img/favicon.png">

    <title>Pantalla Bloqueada | Área de Administración</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo backend_view(); ?>bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo backend_view(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo backend_view(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo backend_view(); ?>css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo backend_view(); ?>html5shiv.js"></script>
    <script src="<?php echo backend_view(); ?>respond.min.js"></script>
    <![endif]-->
</head>

<body class="lock-screen" onload="startTime()">

    <div class="lock-wrapper">

        <div id="time"></div>


        <div class="lock-box text-center">
            <div class="lock-name"><?php echo $usuario; ?></div>
            <img src="<?php echo base_url(); ?>uploads/167x158/<?php echo $imagen; ?>" alt="<?php echo $usuario; ?>"/>
            <div class="lock-pwd">
                <form role="form" class="form-inline" action="<?php echo current_url(); ?>" method="post">
                    <div class="form-group">
                        <input type="password" placeholder="Contraseña" id="contrasenia" class="form-control lock-input" name="contrasenia">
                        <button class="btn btn-lock" type="submit">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        function startTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('time').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){startTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }
    </script>
</body>
</html>
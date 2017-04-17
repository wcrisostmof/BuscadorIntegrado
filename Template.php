<!DOCTYPE html>
<html>
    <head>
            <meta charset="UTF-8">
        <title></title>
<!--        <link href="CSS/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-1.10.2.min.js" ></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--        <link href="../CSS/Custom.css" rel="stylesheet" type="text/css"/>-->
        <link href="CSS/Custom.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <style>
            body{
        background: #F2F0F0;
        }
       </style>
    <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php" title="Buscador Integrado">
                        <img src="Images/SoportePlaco.png" width="116" height="43" style="max-width:100px; margin-top: -11px;" align="right"/>
                        </a>
                    </div>
                    <div class="navbar-collapse collapse in container" id="bs-example-navbar-collapse-1" aria-expanded="true">
                        <ul class="nav nav-pills">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">BUSCAR POR<b class="caret"></b></a>
                                <ul class="dropdown-menu multi-level">
                                    <li class="nav-item" ><a href="Rsocial.php">Buscador por Razón Social<span class="sr-only"></span></a></li>
                                    <li class="divider"></li>
                                    <li class="nav-item"><a href="PorRuc.php">Buscador por RUC<span class="sr-only"></span></a></li>
                                    <li class="divider"></li>
                                    <li class="nav-item"><a href="PorIDWEB.php">Buscador por ID WEB<span class="sr-only"></span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">INFORMACIÓN RELEVANTE<b class="caret"></b></a>
                                <ul class="dropdown-menu multi-level">
                                   <li class="nav-item"><a href="P_rutas.php">Principales rutas<span class="sr-only"></span></a></li>
                                   <li class="divider"></li>
                                   <li class="nav-item"><a href="Infrelevante.php">Documentos<span class="sr-only"></span></a></li>
                                   <li class="divider"></li>
                                   <li class="nav-item"><a href="CanalAtencion.php">Canal de atención<span class="sr-only"></span></a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a href="Stock_Equipos.php">STOCK EQUIPOS<span class="sr-only"></span></a></li>
                            <li class="nav-item"><a href="FormPlaco/Config_Login.php" target="_blank">Uso Interno<span class="sr-only"></span></a></li>
                            <li class='navbar-right'><FORM><INPUT Type="button" VALUE="Atrás" style="width:90px;height:32px; margin-top: 10px;" class="btn-primary" onClick="history.go(-1);return true;"></FORM></li>
                        </ul>                    
                        
                    </div>
                </div>
                </nav>
    </div>
        
    </body>
</html>

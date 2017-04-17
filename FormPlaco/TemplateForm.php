<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="../CSS/Custom.css" rel="stylesheet" type="text/css"/>
  
        
    </head>
    <body>
        
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
                        <a class="navbar-brand" href="#" title="Buscador Integrado">
                            
                        <img class="hidden-xs" style="max-width:100px; margin-top: -7px;" src="../Images/SoportePlaco.png">
                        <img class="visible-xs" style="max-width:100px; margin-top: -7px;" src="../Images/SoportePlaco.png">
                        </a>
                    </div>
                    <div class="navbar-collapse collapse in container" id="bs-example-navbar-collapse-1" aria-expanded="true">
                        <ul class="nav nav-pills">
                            <li class="dropdown navbar-right">
                                <a class="dropdown-toggle" data-toggle="dropdown"> <strong>Bienvenido <?php 
                               require_once '../MasterPage.php';
                                $queryNombre = "SELECT (Nombre + ' ' + Apellidos) AS usuario FROM placo WHERE UserName='" . $_SESSION["user_name"]."'";
                                $resultUS =sqlsrv_query($connect,$queryNombre);
                                $rowUser  = sqlsrv_fetch_array($resultUS);
                                 echo $rowUser['usuario'];
                                    echo $_SESSION["user_name"]; 
                               ?> </strong><span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-lr" role="menu">
                                    <li class="nav-item">
                                                <a href="Logout.php" tite="Logout">Cerrar sesión</a>
                                     </li>
                                </ul> 
                                
                            </li>
                            <li class="nav-item"><a href="#">PENALIDADES<span class="sr-only"></span></a></li>
                            
                        </ul>                    
                    </div>
                </div>
            </nav>
    </div>
    </body>
</html>

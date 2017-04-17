<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sugerencias</title>
        <link href="CSS/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-1.10.2.min.js" ></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="../CSS/Custom.css" rel="stylesheet" type="text/css"/>
        <link href="CSS/Custom.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <style>
            body{
        background: #F2F0F0;
        }
       </style>
    <body>
        <?php
        
        require_once 'MasterPage.php';
        
//aqui los contactos autorizados del cliente        
        if(isset($_REQUEST['llave'])){
            $TipoGama=$_REQUEST['llave'];
            
        
            
            if($TipoGama=='Todas las Gamas'){
                $llave="select Codigo_Bodega,Nombre_de_la_Bodega,Marca,Modelo_Nombre_Comercial,Color,Tipo_de_Gama,stock from stock_equipos";
            }else{
                $llave="select Codigo_Bodega,Nombre_de_la_Bodega,Marca,Modelo_Nombre_Comercial,Color,Tipo_de_Gama,stock from stock_equipos where tipo_de_gama = '".$TipoGama."' order by stock desc";
                
            }
            $rsSgStock = sqlsrv_query($connect,$llave);
//           echo $llave;
        echo'<table class="table-bordered table-condensed" style="width:1000px; height:1px;">
                <thead>
                        <th>CODIGO DE BODEGA</th>
                        <th>NOMBRE DE LA BODEGA</th>
                        <th>MARCA</th>
                        <th>MODELO NOMBRE COMERCIAL</th>
                        <th>COLOR</th>
                        <th>TIPO DE GAMA</th>
                        <th>STOCK</th>
                </thead>';
                while($rowSStock = sqlsrv_fetch_array($rsSgStock)){
                    echo'<tr>';
                    echo '<td style="width:11%;">'.$rowSStock['Codigo_Bodega'].'</td>';
                    echo '<td style="width:;">'.$rowSStock['Nombre_de_la_Bodega'].'</td>';
                    echo '<td>'.$rowSStock['Marca'].'</td>';
                    echo '<td>'.$rowSStock['Modelo_Nombre_Comercial'].'</td>';
                    echo '<td>'.$rowSStock['Color'].'</td>';
                    echo '<td>'.$rowSStock['Tipo_de_Gama'].'</td>';
                    echo '<td>'.$rowSStock['stock'].'</td>';
                    echo'</tr>';
                }
                echo '</table>';
            }
        ?>
    </body>
</html>

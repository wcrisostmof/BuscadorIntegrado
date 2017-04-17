<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>ID WEB</title>
        <link href="CSS/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/Reader.js"></script>
        <script src="js/auto.js" ></script>
        <script src="js/jquery-1.10.2.min.js" ></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="../CSS/Custom.css" rel="stylesheet" type="text/css"/>
        <link href="CSS/Custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <style>
            .right{
                position: relative;
                left: 50px;
                top: auto;
                right: auto;
                width: 600px;
                
                
            }
            .left{
                position: relative;
                left:auto;
                top:auto;
                right: 50px;
                width: 930px;
                padding-right: 100px;
                padding-left: auto;
                margin-right: 200px;
                margin-left: 50px;
                height: 10px;
                
            }
            
        </style>  
        
        
        <div class="container">
        <?php 
       
        
//        require_once ("buscador.php");
        require_once 'MasterPage.php';
        
        
//aqui los contactos autorizados del cliente        
        if(isset($_GET['llave'])){
             $web=$_REQUEST['llave'];
            $llave = "SELECT TOP 1 LLAVE,SEGMENTO,TIPO_OPERACION_COMERCIAL,GRUPO_ESTADO,PRODUCTO,MODALIDAD_PRODUCTO,OPORTUNIDAD_PROYECTO,VENDEDOR_GRUPO_MAESTRA,VENDEDOR_NOMBRE,FEC_INSERCION_WS,FECHA_RECIBIDO_WS,FEC_EMISION_PEDIDO,SUB_ESTADO_CM,SUB_SITUACION,SISEGO_PRIORIZADO,CODIGO_SISEGO,ESTADO_SISEGO,ETAPA_SISEGO,ESTADO_WEB_SISEGOS,DIRECCION_CLIENTE,GESTOR_ASEGURAMIENTO,FEC_ULTIMA_GESTION_BACK,PREVISION_CIERRE, ULTIMO_COMENTARIO_SEGUIMIENTO FROM AVANZADOS WHERE LLAVE = '" . $web ."' order by FEC_ULTIMA_GESTION_BACK desc";
//            $llave = "SELECT TOP 1 LLAVE,DNI_RUC,NOMBRE_CLIENTE,SEGMENTO,TIPO_OPERACION_COMERCIAL,GRUPO_ESTADO,PRODUCTO,MODALIDAD_PRODUCTO,OPORTUNIDAD_PROYECTO,VENDEDOR_GRUPO_MAESTRA,VENDEDOR_NOMBRE,FEC_INSERCION_WS,FECHA_RECIBIDO_WS,FEC_EMISION_PEDIDO,SUB_ESTADO_CM,SUB_SITUACION,SISEGO_PRIORIZADO,CODIGO_SISEGO,ESTADO_SISEGO,ETAPA_SISEGO,ESTADO_WEB_SISEGOS,DIRECCION_CLIENTE,GESTOR_ASEGURAMIENTO,FEC_ULTIMA_GESTION_BACK,PREVISION_CIERRE, ULTIMO_COMENTARIO_SEGUIMIENTO FROM AVANZADOS WHERE LLAVE = '" . $web ."' order by FEC_ULTIMA_GESTION_BACK desc";
            $Resultadoweb =sqlsrv_query($connect,$llave);
            ?>
                        <div class="left">
                        
                        <?php
            echo '<h4> DETALLE DEL IDWEB: </h4>';
               while ($row4 = sqlsrv_fetch_array($Resultadoweb)){
                   
                   echo '<div style="width:60%">';
                   echo "<table  align='left' class='table-bordered table-condensed' style='text-align:center; width:40%; height:10%;'>";
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ID WEB</td>';
                            echo '<td>'.$row4['LLAVE'].'</td>';  
                            echo'</tr>';
                            
                                 
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">SEGMENTO</td>';
                            echo '<td>'.$row4['SEGMENTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">TIPO OPERACION COMERCIAL</td>';
                            echo '<td>'.$row4['TIPO_OPERACION_COMERCIAL'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ESTADO</td>';
                            echo '<td>'.$row4['GRUPO_ESTADO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">PRODUCTO</td>';
                            echo '<td>'.$row4['PRODUCTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">MODALIDAD PRODUCTO </td>';
                            echo '<td>'.$row4['MODALIDAD_PRODUCTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">OPORTUNIDAD PROYECTO</td>';
                            echo '<td>'.$row4['OPORTUNIDAD_PROYECTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">GRUPO VENDEDOR</td>';
                            echo '<td>'.$row4['VENDEDOR_GRUPO_MAESTRA'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">NOMBRE VENDEDOR</td>';
                            echo '<td>'.$row4['VENDEDOR_NOMBRE'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA DE INSERCIÓN</td>';
                                    $FechaInser= $row4['FEC_INSERCION_WS'];
                                    if($FechaInser==NULL){
                                        echo '<td>-</td>';
                                    }else{
                                        echo '<td>'.$FechaInser->format("Y-m-d H:i:s").'</td>';
                                        
                                    }
//                            echo '<td>'.$row4['FEC_INSERCION_WS']->format("Y-m-d H:i:s").'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA RECIBIDO</td>';
                                $FechaRecibido = $row4['FECHA_RECIBIDO_WS'];
                                if($FechaRecibido==NULL){
                                        echo '<td>-</td>';
                            
                                }else{
                                    echo '<td>'.$FechaRecibido->format("Y-m-d").'</td>';
                                }
//                            echo '<td>'.$row4['FECHA_RECIBIDO_WS']->format("Y-m-d H:i:s").'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';                            
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA EMISIÓN</td>';
                                $FechaPedido=  $row4['FEC_EMISION_PEDIDO'];
                               if($FechaPedido==NULL){
                                   echo '<td>-</td>';
                               }else{
                                   echo '<td>'.$FechaPedido->format("Y-m-d").'</td>';
                               }
//                            echo '<td>'.$row4['FEC_EMISION_PEDIDO']->format("Y-m-d H:i:s").'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">SITUACIÓN ACTUAL</td>';
                            echo '<td>'.$row4['SUB_ESTADO_CM'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">DETALLE DE LA SITUACIÓN</td>';
                            echo '<td>'.$row4['SUB_SITUACION'].'</td>';
                            echo'</tr>';
                            echo'</tr>';
                            echo '</table>';
                            ?>
                            </div>
                        <div class="right">
                            <?php
                            
                            //comienzo de la segunta parte del detalle
                            echo "<table align='right' class='table-bordered table-condensed' style='text-align:center; width:50%; height:10%;' >";
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">SISEGO PRIORIZADO</td>';
                            echo '<td>'.$row4['SISEGO_PRIORIZADO'].'</td>';
                            
                            
                            
                            
                           
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">CODIGO SISEGO</td>';
                            echo '<td>'.$row4['CODIGO_SISEGO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ESTADO WEB SISEGO</td>';
                            echo '<td>'.$row4['ESTADO_SISEGO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ETAPA SISEGO</td>';
                            echo '<td>'.$row4['ETAPA_SISEGO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ESTADO WEB SISEGOS</td>';
                            echo '<td>'.$row4['ESTADO_WEB_SISEGOS'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">DIRECCION CLIENTE</td>';
                            echo '<td>'.$row4['DIRECCION_CLIENTE'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">GESTOR ASEGURAMIENTO</td>';
                            echo '<td>'.$row4['GESTOR_ASEGURAMIENTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ULTIMA FECHA GESTION DEL BACK</td>';
                            $FechUltGestback=  $row4['FEC_ULTIMA_GESTION_BACK'];
                               if($FechUltGestback==NULL){
                                   echo '<td>-</td>';
                               }else{
                                echo '<td>'.$FechUltGestback->format("Y-m-d").'</td>';
                               }
//                            echo '<td>'.$row4['FEC_ULTIMA_GESTION_BACK'].'</td>';
                            
                            echo'</tr>';
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">PREVISION DE INSTALACIÓN</td>';
                            $FechPrevCierre=  $row4['PREVISION_CIERRE'];
                               if($FechPrevCierre==NULL){
                                   echo '<td>-</td>';
                               }else{
                                echo '<td>'.$FechPrevCierre->format("Y-m-d").'</td>';
                               }
//                            echo '<td>'.$row4['PREVISION_CIERRE']->format("Y-m-d H:i:s").'</td>';
                               
                            echo '</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ULTIMO COMENTARIO DEL BACK</td>';
                            echo '<td>'.$row4['ULTIMO_COMENTARIO_SEGUIMIENTO'].'</td>';
                            echo '</tr>';
                    echo '</table>';
                    }
                    echo '</div>';
                    echo '<br>';
                    echo '<br>';
        }
        ?>
                        </div>
    </div>
     </body>    
</html>
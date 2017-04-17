<html>
    <head>
        <meta charset="UTF-8">
        <title>Contacto Autorizado</title>
    </head>
    <body>
        
            <style>
                .right{
                    position: absolute;
                    top: 95px;
                    right: 60px;
                    width: 500px;
                }
                .container2{
                    padding-right: 13px;
                    padding-left: 15px;
                    margin-right: auto;
                    margin-left: auto;
                  }
            
            </style>
            <div class="container2">
        <?php 
        include 'Template.php';
        $rucc= $_REQUEST["ruc"];
        echo '<form method="POST" action="contacto.php" id="searchform" autocomplete="on" action>';
        echo '</form>';
// Aqui el detalle del cliente
        require_once 'MasterPage.php';
        if(!empty($rucc)){
            $cliente = "SELECT 
                            CASE
                              WHEN EXISTS (SELECT *
                                           FROM   exclusivo
                                           WHERE  exclusivo.RUC = CLIENTE.RUC) THEN 'SI'
                              ELSE 'NO'
                            END AS EXCLUSIVO,
                            CASE
                            WHEN EXISTS(SELECT * FROM  Factura
			                            WHERE Factura.[RUC (cliente)]= CLIENTE.RUC) THEN 'SI'
							ELSE 'NO'
							END AS [FACTURA ELECTRONICA]
                     FROM   CLIENTE  where RUC = " . $rucc ." order by RUC";
                $resultado2 =sqlsrv_query($connect,$cliente);
            while ($rowCb = sqlsrv_fetch_array($resultado2)){
                echo '<div style="top: 0;">';
                echo "<table  style='width:64%; height:1%;' >";
                echo '<tr>';
                    echo '<td>';
                            echo '<h4>RESUMEN DE CLIENTE:</h4>';
                    echo '</td>';
                    echo '<td>';
                            echo '<h5>'.$rowCb['EXCLUSIVO']. '  es Exclusivo  '."   -   ".'  ' .$rowCb['FACTURA ELECTRONICA']. ' tiene Facturas electronicas </h5>';
                    echo '</td>';
                            echo '</tr>';
                echo '</table>';                
                echo '</div>';
            }
        }
        if(!empty($rucc)){
            $cliente = "SELECT RUC, RAZON_SOCIAL,SUB_SEGMENTO,EJECUTIVO_COMERCIAL,JEFE
                     FROM   CLIENTE  where RUC = " . $rucc ." order by RUC";
                $resultado2 =sqlsrv_query($connect,$cliente);
                        echo "<table  class='table-bordered table-condensed' style='text-align:center; width:52%; height:5%';>";

                        echo '<th bgcolor="#DBD4D4" style="text-align:center">RUC</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">RAZÓN SOCIAL</th>';
//                        echo '<th bgcolor="#DBD4D4" style="text-align:center">GIRO DEL NEGOCIO</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">SUB SEGMENTO</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">EJECUTIVO COMERCIAL</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">JEFE</th>';
            while ($row = sqlsrv_fetch_array($resultado2)){
                                $RSC= $row['RAZON_SOCIAL'];
                                    global $RSC;
                            $RC = $row['RUC'];
                            global $RC;
                            echo '<tr>';
                            echo '<td>'.$row['RUC'].'</a></td>';  
                            echo '<td>'.$row['RAZON_SOCIAL'].'</td>';  
//                            echo '<td>'.$row['GIRO_NEGOCIO'].'</td>';  
                            echo '<td>'.$row['SUB_SEGMENTO'].'</td>';  
                            echo '<td>'.$row['EJECUTIVO_COMERCIAL'].'</td>';       
                            echo '<td>'.$row['JEFE'].'</td>';
                            echo '</tr>';
            }
                echo '</table>';
                
        }
          ?>
            <div class="right">
                <table>
                <tr>
                    <td>
                        <a target="_blank" class="btn btn-primary"  href="download.php?RucCliente=<?php echo $RC ?>"> Penalidades Q15 - Q20 <br></a><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br
                    </td>
                </tr>
                 <tr>
                    <td>
                        <a class="btn btn-primary" href="consultornegocios.php?RConsultor=<?php echo $RC?>"> Consultor Negocios</a>
                        
                    </td>
             </tr>
                </table>
            </div>
        <?php
        if(!empty($rucc)){
            $queryRCN="select round([Facturación ATIS],0) as facturacion,round([Facturacion movil],0) as f_movil,[Facturación isis] as fisis from clientes_negocios where RUC ='".$rucc."';";
            $queryTot= "select round(sum(isnull([Facturación ISIS],0)) + sum(isnull([Facturación ATIS],0))+ SUM(isnull([Facturacion movil],0)),0) as total from clientes_negocios where RUC='".$rucc."';";
            $resultadoFMFA=sqlsrv_query($connect,$queryRCN);
            $resultadoFT=sqlsrv_query($connect,$queryTot);
            
            echo '<h4>FACTURACIÓN:</h4>';
            
            echo '<table style="text-align:left; border:0px;">';
              echo'</thead>';
              while ($rowFMFA = sqlsrv_fetch_array($resultadoFMFA)){
                echo '<tr>';
                    echo '<td> Facturación Fija:</td>';
                    $FFacturaion=$rowFMFA['facturacion'];
                    if($FFacturaion==NULL || $FFacturaion = 0){
                                    echo '<td>-</td>';
                            }else{
                            echo '<td> S/.'.$rowFMFA['facturacion'].'</td>';
                    }
                echo '</tr>';    
                echo'<tr>';
                    echo '<td> Facturación Móvil:</td>';
                    $Fmovil=$rowFMFA['f_movil'];
                    if($Fmovil==NULL || $Fmovil = 0){
                                    echo '<td>-</td>';
                            }else{
                            echo '<td> S/.'.$rowFMFA['f_movil'].'</td>';
                    }
                        
                echo '</tr>';
                
                echo'<tr>';
                    echo '<td> Facturación ISIS:</td>';
                    $Fisis=$rowFMFA['fisis'];
                    if($Fisis==NULL || $Fisis = 0){
                                    echo '<td>S/.0</td>';
                            }else{
                            echo '<td> S/.'.$rowFMFA['fisis'].'</td>';
                    }
                echo '</tr>';
                
              } 
              while ($rowFT = sqlsrv_fetch_array($resultadoFT)){
              echo '<tr>';
                    echo '<td>Facturación Total:</td>';
                    $FFM=$rowFT['total'];
//                    echo $FFM;
                    if($FFM==NULL || $FFM = 0){
                                    echo '<td>-</td>';
                            }else{
                            echo '<td> S/.'.$rowFT['total'].'</td>';
                    }
                  echo '</tr>';
              }
              
              echo'</table>';
        }
        if(!empty($rucc)){
            $contacto = "SELECT RUC,RAZON_SOCIAL, (NOMBRES + ', ' + APELLIDOS) AS CONTACTO,TIPO_DOC + ' - '+ 
                        CASE
                               WHEN TIPO_DOC = 'DNI' THEN   RIGHT('000'+ISNULL(NUMERO_DOC,''),8) 
                               WHEN TIPO_DOC= 'PAS' THEN NUMERO_DOC
                               WHEN TIPO_DOC= 'VAR' THEN NUMERO_DOC
                               WHEN TIPO_DOC= 'OTROS' THEN NUMERO_DOC
                               WHEN TIPO_DOC= 'CE' THEN NUMERO_DOC END AS DOCUMENTO,CORREO, 
                       (CEL_MOVISTAR + ' - '+ CEL_OTRO) as CELULAR  from Contacto where RUC = '" . $rucc ."'";
            
            
             $resultado = sqlsrv_query($connect, $contacto, array(), array( "Scrollable" => 'static' ));
            if(sqlsrv_num_rows($resultado)>0){
                ?>
                <h4> LISTA DE CONTACTOS AUTORIZADOS: </h4>
                        <table  class="table-bordered table-condensed" style="text-align:center; width:52%; height:1%;">
                        <th bgcolor="#DBD4D4" style="text-align:center">CONTACTO</th>
                        <th bgcolor="#DBD4D4" style="text-align:center">DOCUMENTO</th>
                        <th bgcolor="#DBD4D4" style="text-align:center">CORREO</th>
                        <th bgcolor="#DBD4D4" style="text-align:center">CEL. MOVISTAR - OTRO</th>

                <?php
                 while ($row2 = sqlsrv_fetch_array($resultado)){
                        
                        echo '<tr>';

                                        echo '<td>'.$row2['CONTACTO'].'</td>';  
                                        echo '<td>'.$row2['DOCUMENTO'].'</td>';
                                        echo '<td>'.$row2['CORREO'].'</td>';
                                        echo '<td>'.$row2['CELULAR'].'</td>'; 
                                echo '</tr>';
                        
                    }
                    echo '</table>';
                    echo '<br>';
                     echo '<br>';
                    
            }else{
                ?>
                <br>
                <div class="alert alert-info" style="text-align:center; margin:0 auto; width:370px; height:65px;">
                    <strong>El cliente no tiene contacto autorizados. Para descargar el formato <a href="http://www.movistar.com.pe/atencion-al-cliente/tramites/contactos-autorizados#_tabsnestedportlet_WAR_tabsnestedportlet_INSTANCE_R71pwXA7izLA_tab-3" target="_blank">has click aqui</a></strong>
                </div>
                
                <?php
            }        
        }
        
        //aqui los contactos autorizados .END
        
        echo '<div style="width:90%;>';
        echo '<div id="bloc1" style="width:90%;>';
        if(!empty($rucc)){
            $LISTAIDWEB = "SELECT LLAVE, FAMILIA+ ' - '+ PRODUCTO+ ' - '+ MODALIDAD_PRODUCTO  as PRODUCTO, CASE
WHEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE()) = 0 THEN NULL
WHEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE()) > 0 THEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE())
END AS DIAS_TRANSCURRIDOS,GRUPO_ESTADO,SUB_ESTADO_CM,PREVISION_CIERRE FROM AVANZADOS WHERE DNI_RUC = '" . $rucc ."'";
            
                $resultado3 =sqlsrv_query($connect,$LISTAIDWEB);
                        echo '<div style="width:60%">';
                        echo '<h4> LISTA DE PEDIDOS AVANZADOS: </h4>';
                        echo "<table class='table-bordered table-condensed' style='text-align:center ; width:58%; height:10%;'>";
                        echo '<tr>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">ID WEB</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">PRODUCTO</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">DIAS TRANSCURRIDOS*</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">ESTADO</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">SITUACIÓN ACTUAL</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">PREVISION DE INSTALACIÓN	</th>';
                        echo '</tr>';
                 while ($row3 = sqlsrv_fetch_array($resultado3)){
                        $IDWEB= $row3['LLAVE'];
                        global $IDWEB;
                            echo '<tr>';
                            echo '<td>';
                             ?>

            <a href='javascript:void(window.open("Idweb.php?llave=<?php echo $IDWEB ?>","mypopuptitle","width=400","height=700"));'> <?php echo $IDWEB ?></a>
            <?php
                            echo '</td>';
                            echo '<td>'.$row3['PRODUCTO'].'</td>';
                            echo '<td>'.$row3['DIAS_TRANSCURRIDOS'].'</td>';
                            echo '<td>'.$row3['GRUPO_ESTADO'].'</td>';
                            echo '<td>'.$row3['SUB_ESTADO_CM'].'</td>';
                            $FechaEstado2= $row3['PREVISION_CIERRE'];
                            if($FechaEstado2==NULL){
                                    echo '<td>-</td>';
                                }else{
                                    
                                echo '<td>'.$FechaEstado2->format("Y-m-d").'</td>';
                                }
                        echo '</tr>';
                    }
                    echo '</table>'; 
                    echo '*DIAS TRANSCURRIDOS: desde la fecha de emisión ';
                    echo '<div>';  
                    echo '<br>';
        }
        echo '</div>';
        echo '<div id="bloc2">';
        if (!empty($_REQUEST['iweb'])){
             $web=$_REQUEST['iweb'];
            $llave = "SELECT TOP 1 LLAVE,DNI_RUC,NOMBRE_CLIENTE,SEGMENTO,TIPO_OPERACION_COMERCIAL,GRUPO_ESTADO,PRODUCTO,MODALIDAD_PRODUCTO,OPORTUNIDAD_PROYECTO,VENDEDOR_GRUPO_MAESTRA,VENDEDOR_NOMBRE,FEC_INSERCION_WS,FECHA_RECIBIDO_WS,FEC_EMISION_PEDIDO,SUB_ESTADO_CM,SUB_SITUACION,SISEGO_PRIORIZADO,CODIGO_SISEGO,ESTADO_SISEGO,ETAPA_SISEGO,ESTADO_WEB_SISEGOS,DIRECCION_CLIENTE,GESTOR_ASEGURAMIENTO,FEC_ULTIMA_GESTION_BACK,PREVISION_CIERRE, ULTIMO_COMENTARIO_SEGUIMIENTO FROM AVANZADOS WHERE LLAVE = '" . $web ."' order by FEC_ULTIMA_GESTION_BACK desc";
            $Resultadoweb =sqlsrv_query($connect,$llave);
               while ($row4 = sqlsrv_fetch_array($Resultadoweb)){
                   echo '<div style="width:70%; align="right";>';
                   echo '<h4> DETALLE DEL IDWEB: </h4>';
                   echo "<table  align='left' class='table-bordered table-condensed' style='text-align:center; width:70%; height:10%;'>";
                            
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
                                        echo '<td>'.$FechaInser->format("Y-m-d").'</td>';
                                        
                                    }
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA RECIBIDO</td>';
                                $FechaRecibido = $row4['FECHA_RECIBIDO_WS'];
                                if($FechaRecibido==NULL){
                                        echo '<td>-</td>';
                            
                                }else{
                                    echo '<td>'.$FechaRecibido->format("Y-m-d").'</td>';
                                }

                            echo'</tr>';
                            
                            echo '<tr>';                            
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA EMISIÓN</td>';
                                $FechaPedido=  $row4['FEC_EMISION_PEDIDO'];
                               if($FechaPedido==NULL){
                                   echo '<td>-</td>';
                               }else{
                                   echo '<td>'.$FechaPedido->format("Y-m-d").'</td>';
                               }

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
                            echo'</tr>';
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">PREVISION DE INSTALACIÓN</td>';
                            $FechPrevCierre=  $row4['PREVISION_CIERRE'];
                               if($FechPrevCierre==NULL){
                                   echo '<td>-</td>';
                               }else{
                                echo '<td>'.$FechPrevCierre->format("Y-m-d").'</td>';
                               }
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
        echo '</div>';
        echo '</div>'; 
        if(sqlsrv_close($connect)==TRUE){
//          echo 'esta cerrado';
        }else{
//            echo'falta cerrar';
            }
        ?>
        </div>
     </body>    
</html>
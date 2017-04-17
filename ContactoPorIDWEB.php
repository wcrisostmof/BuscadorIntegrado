<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <style>
                .right {
                    position: absolute;
                    top: 95px;
                    right: 50px;
                    width: 500px;
                }
                .container2 {
                    padding-right: 13px;
                    padding-left: 15px;
                    margin-right: auto;
                    margin-left: auto;
                  }
            </style>
        <div class="container2">
        <?php
        include 'Template.php';
       require_once 'MasterPage.php';
        
        
        if(!empty($_REQUEST['porWEB'])){
            $PorWEB= $_REQUEST["porWEB"];
           $clienteWEB = "SELECT 
                            CASE
                              WHEN EXISTS (SELECT *
                                           FROM   exclusivo
                                           WHERE  exclusivo.RUC = C.RUC) THEN 'SI'
                              ELSE 'NO'
                            END AS EXCLUSIVO,
                            CASE
                            WHEN EXISTS(SELECT * FROM  Factura
			                            WHERE Factura.[RUC (cliente)]= C.RUC) THEN 'SI'
							ELSE 'NO'
							END AS [FACTURA ELECTRONICA]
                     FROM   CLIENTE C, AVANZADOS A  where  C.RUC =A.DNI_RUC AND A.LLAVE = " . $PorWEB ."";
                $resultadoex=sqlsrv_query($connect,$clienteWEB);
                $found = 0;
            while ($rowCb = sqlsrv_fetch_array($resultadoex)){
                $found = 1;
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
                if($found==0){
                   echo '<script>window.location.href = "/ProyectoBuscador/Message.php";</script>';
                }      
        }
        
       if (!empty($_REQUEST['porWEB'])) {
            $cliente = "SELECT RUC, RAZON_SOCIAL,C.SUB_SEGMENTO,C.EJECUTIVO_COMERCIAL,C.JEFE  FROM CLIENTE C, AVANZADOS A where C.RUC =A.DNI_RUC AND A.LLAVE= " . $PorWEB ."";
                $resultadoS =sqlsrv_query($connect,$cliente);
              echo "<table class='table-bordered table-condensed' style='text-align:center; width:54%; height:1%;'>";
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">RUC</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">RAZÓN SOCIAL</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">SUB SEGMENTO</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">EJECUTIVO COMERCIAL</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">JEFE</th>';
            while ($rowWEB = sqlsrv_fetch_array($resultadoS)){
                $RUCpW = $rowWEB['RUC'];
                global $RUCpW;
                echo '<tr>';
                            echo '<td>'.$rowWEB['RUC'].'</a></td>';  
                            echo '<td>' .$rowWEB['RAZON_SOCIAL'].'</td>';
                            echo '<td>'.$rowWEB['SUB_SEGMENTO'].'</td>';  
                            echo '<td>'.$rowWEB['EJECUTIVO_COMERCIAL'].'</td>';       
                            echo '<td>'.$rowWEB['JEFE'].'</td>';
                            echo '</tr>';
            }
                echo '</table>';
            }
             ?>
            <div class="right">
                <table>
                <tr>
                    <td>
                        <a target="_blank" class="btn btn-primary"  href="download.php?RucCliente=<?php echo $RUCpW ?>"> Penalidades Q15 - Q20 <br></a><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br
                    </td>
                </tr>
                
                
                <tr>
                    <td>
                        <a class="btn btn-primary" href="consultornegocios.php?RConsultor=<?php echo $RUCpW?>"> Consultor Negocios</a>
                        
                    </td>
                </tr>
                </table>
            </div>
            <?php
         if (!empty($_REQUEST['porWEB'])) {
            $queryRCN="select round([Facturación ATIS],0) as facturacion,round([Facturacion movil],0) as f_movil,[Facturación isis] as fisis from clientes_negocios where RUC ='".$RUCpW."';";
            $queryTot= "select round(sum(isnull([Facturación ISIS],0)) + sum(isnull([Facturación ATIS],0))+ SUM(isnull([Facturacion movil],0)),0) as total from clientes_negocios where RUC='".$RUCpW."';";
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
                                    echo '<td>S/.0</td>';
                            }else{
                            echo '<td> S/.'.$rowFMFA['facturacion'].'</td>';
                    }
                echo '</tr>';    
                echo'<tr>';
                    echo '<td> Facturación Móvil:</td>';
                    $Fmovil=$rowFMFA['f_movil'];
                    if($Fmovil==NULL || $Fmovil = 0){
                                    echo '<td>S/.0</td>';
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
                    if($FFM==NULL || $FFM = 0){
                                    echo '<td>S/.0</td>';
                            }else{
                            echo '<td> S/.'.$rowFT['total'].'</td>';
                    }
                  echo '</tr>';
              }
              
              echo'</table>';
        }   
            
            
        if (!empty($_REQUEST['porWEB'])){
             $web=$_REQUEST['porWEB'];
            $llave = "SELECT TOP 1 DNI_RUC,NOMBRE_CLIENTE,SEGMENTO,TIPO_OPERACION_COMERCIAL,GRUPO_ESTADO,PRODUCTO,MODALIDAD_PRODUCTO,OPORTUNIDAD_PROYECTO,VENDEDOR_GRUPO_MAESTRA,VENDEDOR_NOMBRE,FEC_INSERCION_WS,FECHA_RECIBIDO_WS,FEC_EMISION_PEDIDO,SUB_ESTADO_CM,SUB_SITUACION, case WHEN ESTADO_QUIEBRE = '    '  THEN 'N/A' WHEN ESTADO_QUIEBRE = 'POTENCIAL QUIEBRE'  THEN 'POTENCIAL QUIEBRE' end as ESTADO_QUIEBRE,SISEGO_PRIORIZADO,CODIGO_SISEGO,ESTADO_SISEGO,ETAPA_SISEGO,ESTADO_WEB_SISEGOS,DIRECCION_CLIENTE,GESTOR_ASEGURAMIENTO,FEC_ULTIMA_GESTION_BACK,PREVISION_CIERRE, ULTIMO_COMENTARIO_SEGUIMIENTO FROM AVANZADOS WHERE LLAVE = '" . $web ."' order by FEC_ULTIMA_GESTION_BACK desc";
            $Resultadoweb =sqlsrv_query($connect,$llave);
            echo '<h4> Resumen del IDWEB: '.$web.'</h4>';
               while ($rowRsWEB = sqlsrv_fetch_array($Resultadoweb)){
                   
                   echo '<div style="padding-right: 10px; width: 900px; position:absolute;">';
                   echo "<table  align='left' class='table-bordered table-condensed' style='text-align:center; width:40%; height:10%;'>";
                            
                                 
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">SEGMENTO</td>';
                            echo '<td>'.$rowRsWEB['SEGMENTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">TIPO OPERACION COMERCIAL</td>';
                            echo '<td>'.$rowRsWEB['TIPO_OPERACION_COMERCIAL'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ESTADO</td>';
                            echo '<td>'.$rowRsWEB['GRUPO_ESTADO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">PRODUCTO</td>';
                            echo '<td>'.$rowRsWEB['PRODUCTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">MODALIDAD PRODUCTO </td>';
                            echo '<td>'.$rowRsWEB['MODALIDAD_PRODUCTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">OPORTUNIDAD PROYECTO</td>';
                            echo '<td>'.$rowRsWEB['OPORTUNIDAD_PROYECTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">GRUPO VENDEDOR</td>';
                            echo '<td>'.$rowRsWEB['VENDEDOR_GRUPO_MAESTRA'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">NOMBRE VENDEDOR</td>';
                            echo '<td>'.$rowRsWEB['VENDEDOR_NOMBRE'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA DE INSERCIÓN</td>';
                                    $FechaInser= $rowRsWEB['FEC_INSERCION_WS'];
                                    if($FechaInser==NULL){
                                        echo '<td>-</td>';
                                    }else{
                                        echo '<td>'.$FechaInser->format("Y-m-d").'</td>';
                                        
                                    }
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA RECIBIDO</td>';
                                $FechaRecibido = $rowRsWEB['FECHA_RECIBIDO_WS'];
                                if($FechaRecibido==NULL){
                                        echo '<td>-</td>';
                            
                                }else{
                                    echo '<td>'.$FechaRecibido->format("Y-m-d").'</td>';
                                }
//                            echo '<td>'.$row4['FECHA_RECIBIDO_WS']->format("Y-m-d H:i:s").'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';                            
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">FECHA EMISIÓN</td>';
                                $FechaPedido=  $rowRsWEB['FEC_EMISION_PEDIDO'];
                               if($FechaPedido==NULL){
                                   echo '<td>-</td>';
                               }else{
                                   echo '<td>'.$FechaPedido->format("Y-m-d").'</td>';
                               }
//                            echo '<td>'.$row4['FEC_EMISION_PEDIDO']->format("Y-m-d H:i:s").'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">SITUACIÓN ACTUAL</td>';
                            echo '<td>'.$rowRsWEB['SUB_ESTADO_CM'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">DETALLE DE LA SITUACIÓN</td>';
                            echo '<td>'.$rowRsWEB['SUB_SITUACION'].'</td>';
                            echo'</tr>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center"><strong>ESTADO QUIEBRE</strong></td>';
                            echo '<td>'.$rowRsWEB['ESTADO_QUIEBRE'].'</td>';
                            echo'</tr>';
                            echo'</tr>';
                            
                            echo '</table>';
                            
                            echo "<table align='right' class='table-bordered table-condensed' style='text-align:center; width:50%; height:10%;' >";
                            
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">SISEGO PRIORIZADO</td>';
                            echo '<td>'.$rowRsWEB['SISEGO_PRIORIZADO'].'</td>';
                            echo'</tr>';
                           
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">CODIGO SISEGO</td>';
                            echo '<td>'.$rowRsWEB['CODIGO_SISEGO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ESTADO WEB SISEGO</td>';
                            echo '<td>'.$rowRsWEB['ESTADO_SISEGO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ETAPA SISEGO</td>';
                            echo '<td>'.$rowRsWEB['ETAPA_SISEGO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ESTADO WEB SISEGOS</td>';
                            echo '<td>'.$rowRsWEB['ESTADO_WEB_SISEGOS'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">DIRECCION CLIENTE</td>';
                            echo '<td>'.$rowRsWEB['DIRECCION_CLIENTE'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">GESTOR ASEGURAMIENTO</td>';
                            echo '<td>'.$rowRsWEB['GESTOR_ASEGURAMIENTO'].'</td>';
                            echo'</tr>';
                            
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ULTIMA FECHA GESTION DEL BACK</td>';
                            $FechUltGestback=  $rowRsWEB['FEC_ULTIMA_GESTION_BACK'];
                               if($FechUltGestback==NULL){
                                   echo '<td>-</td>';
                               }else{
                                echo '<td>'.$FechUltGestback->format("Y-m-d").'</td>';
                               }
//                            echo '<td>'.$row4['FEC_ULTIMA_GESTION_BACK'].'</td>';
                            
                            echo'</tr>';
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">PREVISION DE INSTALACIÓN</td>';
                            $FechPrevCierre=  $rowRsWEB['PREVISION_CIERRE'];
                               if($FechPrevCierre==NULL){
                                   echo '<td>-</td>';
                               }else{
                                echo '<td>'.$FechPrevCierre->format("Y-m-d").'</td>';
                               }
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td bgcolor="#DBD4D4" style="text-align:center">ULTIMO COMENTARIO DEL BACK</td>';
                            echo '<td>'.$rowRsWEB['ULTIMO_COMENTARIO_SEGUIMIENTO'].'</td>';
                            echo '</tr>';
                    echo '</table>';
                    echo '</div>';
                    }
                    
        }
        
        echo '<div style="top: 650px; width: 900px; position:relative;">';
        if(!empty($_REQUEST['porWEB'])){
            $contacto = "SELECT RUC,RAZON_SOCIAL, (NOMBRES + ', ' + APELLIDOS) AS CONTACTO,TIPO_DOC + ' - '+ 
                        CASE
                               WHEN TIPO_DOC = 'DNI' THEN   RIGHT('000'+ISNULL(NUMERO_DOC,''),8) 
                               WHEN TIPO_DOC= 'PAS' THEN NUMERO_DOC
                               WHEN TIPO_DOC= 'VAR' THEN NUMERO_DOC
                               WHEN TIPO_DOC= 'OTROS' THEN NUMERO_DOC
                               WHEN TIPO_DOC= 'CE' THEN NUMERO_DOC END AS DOCUMENTO,CORREO, 
                       (CEL_MOVISTAR + ' - '+ CEL_OTRO) as CELULAR  from Contacto where RUC = '" . $RUCpW ."'";
                          
            
                $resultado =sqlsrv_query($connect,$contacto,array(),array( "Scrollable" => 'static' ));
                if(sqlsrv_num_rows($resultado)>0){
                    ?>
                <h4> LISTA DE CONTACTOS AUTORIZADOS: </h4>
                        <table  class='table-bordered table-condensed' style='text-align:center; width:75%; height:1%;'>
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
                    
            }else{
                ?>
                <br>
                <div class="alert alert-info" style="text-align:center; margin:0 auto; width:370px; height:65px;">
                    <strong>El cliente no tiene contacto autorizados. Para descargar el formato <a href="http://www.movistar.com.pe/atencion-al-cliente/tramites/contactos-autorizados#_tabsnestedportlet_WAR_tabsnestedportlet_INSTANCE_R71pwXA7izLA_tab-3" target="_blank">has click aqui</a></strong>
                </div>
                
                <?php
            }
        }
        //aqui los contactos autorizados del cliente . END
        
        echo '</div>';
       echo '<div style="top: 650px; width: 900px; position:relative;">';
    if(!empty($_REQUEST['porWEB'])){
//        $PorWEB= $_REQUEST["porWEB"];
            $LISTAIDWEB = "SELECT LLAVE, FAMILIA+ ' - '+ PRODUCTO+ ' - '+ MODALIDAD_PRODUCTO  as PRODUCTO, CASE
WHEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE()) = 0 THEN NULL
WHEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE()) > 0 THEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE())
END AS DIAS_TRANSCURRIDOS,GRUPO_ESTADO,SUB_ESTADO_CM,PREVISION_CIERRE FROM AVANZADOS WHERE DNI_RUC = '" . $RUCpW ."' AND  LLAVE <> '" . $PorWEB ."'";
                $resultado3 =sqlsrv_query($connect,$LISTAIDWEB);
                        
                        echo '<h4> ID WEB DEL CLIENTE: </h4>';
                        echo "<table class='table-bordered table-condensed' style='text-align:center ; width:75%; height:10%;'>";
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

            <a href='javascript:void(window.open("Idweb.php?llave=<?php echo $IDWEB ?>","mypopuptitle","width=800","height=600"));'> <?php echo $IDWEB ?></a>
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
                    echo '<br>';
        }
        echo '</div>';
        ?>
    </div>
    </body>
</html>

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
                    right: 60px;
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
        echo '<div align="left">';
       if (!empty($_REQUEST['porRUC'])) {
            $PorRuc= $_REQUEST["porRUC"];
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
                     FROM   CLIENTE  where RUC = " . $PorRuc ." ";
                $resultado2 =sqlsrv_query($connect,$cliente);
                $found = 0;
            while ($rowCb = sqlsrv_fetch_array($resultado2)){
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
       echo '</div>';
        if (!empty($PorRuc)) {
             $query = "SELECT RUC, RAZON_SOCIAL,SUB_SEGMENTO,EJECUTIVO_COMERCIAL,JEFE
                     FROM   CLIENTE  where RUC = " . $PorRuc ." order by RUC";
            
            $result=sqlsrv_query($connect,$query);
            echo "<table class='table-bordered table-condensed' style='text-align:center; width:52%; height:5%;'>";
//            echo "<table class='table'>";
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">RUC</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">RAZÓN SOCIAL</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">SUB SEGMENTO</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">EJECUTIVO COMERCIAL</th>';
                        echo '<th bgcolor="#DBD4D4" style="text-align:center">JEFE</th>';
            
            while ($row = sqlsrv_fetch_array($result)){
                            $RC = $row['RUC'];
                            global $RC;
//                          
                            echo '<tr>';
                            echo '<td>'.$row['RUC'].'</a></td>';  
//                          echo '<td> <a href="contacto.php?code='.$row["RUC"].'"> ' .$row['RUC'].'</a></td>';  
                            echo '<td>' .$row['RAZON_SOCIAL'].'</td>';
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
                        <a class="btn btn-primary" href="consultornegocios.php?RConsultor=<?php echo $RC?>">Consultor Negocios</a>
                        
                    </td></tr>
                </table>
            </div>
        <?php
           
        if(!empty($PorRuc)){
            $queryRCN="select round([Facturación ATIS],0) as facturacion,round([Facturacion movil],0) as f_movil,[Facturación isis] as fisis from clientes_negocios where RUC ='".$PorRuc."';";
            $queryTot= "select round(sum(isnull([Facturación ISIS],0)) + sum(isnull([Facturación ATIS],0))+ SUM(isnull([Facturacion movil],0)),0) as total from clientes_negocios where RUC='".$PorRuc."';";
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
                    echo $FFM;
                    if($FFM==NULL || $FFM = 0){
                                    echo '<td>S/.0</td>';
                            }else{
                            echo '<td> S/.'.$rowFT['total'].'</td>';
                    }
                  echo '</tr>';
              }
              
              echo'</table>';
        }
        
        
            
        
//aqui los contactos autorizados del cliente        
        if(!empty($PorRuc)){
            $contacto = "SELECT RUC,RAZON_SOCIAL, (NOMBRES + ', ' + APELLIDOS) AS CONTACTO,TIPO_DOC + ' - '+ 
 CASE
	WHEN TIPO_DOC = 'DNI' THEN   RIGHT('000'+ISNULL(NUMERO_DOC,''),8) 
	WHEN TIPO_DOC= 'PAS' THEN NUMERO_DOC
	WHEN TIPO_DOC= 'VAR' THEN NUMERO_DOC
	WHEN TIPO_DOC= 'OTROS' THEN NUMERO_DOC
	WHEN TIPO_DOC= 'CE' THEN NUMERO_DOC END AS DOCUMENTO,CORREO, 
(CEL_MOVISTAR + ' - '+ CEL_OTRO) as CELULAR  from Contacto where RUC = '" . $PorRuc ."'";
            
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
//aqui los contactos autorizados del cliente
        
        if(!empty($PorRuc)){
            $LISTAIDWEB = "SELECT LLAVE, FAMILIA+ ' - '+ PRODUCTO+ ' - '+ MODALIDAD_PRODUCTO  as PRODUCTO, CASE
WHEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE()) = 0 THEN NULL
WHEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE()) > 0 THEN dbo.GetDiasLaborales(FEC_EMISION_PEDIDO,GETDATE())
END AS DIAS_TRANSCURRIDOS,GRUPO_ESTADO,SUB_ESTADO_CM,PREVISION_CIERRE FROM AVANZADOS WHERE DNI_RUC = '" . $PorRuc ."'";
            echo '<h4> LISTA DE PEDIDOS AVANZADOS: </h4>';
                $resultado3 =sqlsrv_query($connect,$LISTAIDWEB);
                        echo '<div style="width:90%">';
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
                    echo '</div>';
        }
        
        if(sqlsrv_close($connect)==TRUE){
//          echo 'esta cerrado';
            
        }else{
//            echo'falta cerrar';
            }
        ?>
        </div>
     </body>    
</html>
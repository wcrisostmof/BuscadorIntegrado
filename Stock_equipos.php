<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
            <title>Stock</title>
        </head>
        <body>
            <style>
                    .container2 {
                       position: absolute;
                       padding-right: 15px;
                       padding-left: 15px;
                       margin-right: auto;
                       margin-left: auto;
                      }
                </style>


            <?php
            session_start();
            include 'Template.php';
            require_once 'MasterPage.php';
            ?>
            <div class="container2">
                <?php 
                $tabla_COD_BODEGA='select distinct Codigo_Bodega from STOCK_EQUIPOS order by Codigo_Bodega';
                $tabla_stock2='select distinct LTRIM(RTRIM(Tipo_de_Gama)) as Tipo_de_Gama from STOCK_EQUIPOS';
                $Tabla_Fecha_stock='select distinct convert(varchar,fec_inf)as fec_inf from stock_equipos order by Fec_inf desc';
                $rsTS=sqlsrv_query($connect,$tabla_COD_BODEGA);
                $rsTS2=sqlsrv_query($connect,$tabla_stock2);
                $rsTS3=sqlsrv_query($connect,$Tabla_Fecha_stock);
               ?>
                <style>
                    a.con_imagen {
                      position: relative;
                    }

                a.con_imagen img {
                  position: absolute;
                  top: 100%;
                  left: 100%;
                  display: none;
                }

                a.con_imagen:hover img {
                  display: block;
                }
                div.center{
                   text-align: left;
                   width: 300px;
                   display: block;
                   margin-left: auto;
                   margin-right: auto;
                }
                
            </style>
            

            <form method="post" action="">
                <label>Buscar por Bodega:</label>&nbsp<select id="busquedaBodega" name="selectCodBodega" style="width: 15px; min-width:150px; max-width: 350px;height: 31px;">
                    <option>Todas las Bodegas</option>
                <?php while($rowTS = sqlsrv_fetch_array($rsTS)){ ?>
                <option value="<?php echo $rowTS['Codigo_Bodega'] ?>">
                <?php echo $rowTS['Codigo_Bodega'] ?>
                </option>
                <?php } ?>
                </select>
                 <label>Buscar por Fecha:</label>&nbsp<select id="busquedaFecha" name="selectFecha" style="width: 15px; min-width:150px; max-width: 350px;height: 31px;">
                <?php while($rowFR = sqlsrv_fetch_array($rsTS3)){ ?>
                <option value="<?php echo $rowFR['fec_inf'] ?>">
                <?php echo $rowFR['fec_inf'] ?>
                </option>
                <?php } ?>
                </select>
                &nbsp &nbsp<label>Buscar por Gama:</label>&nbsp<select id="busquedaGama" name="selectGama" style="width: 105px; min-width: 120px; max-width: 350px; height: 31px;">
                <option>Todas las Gamas</option>
                <?php while($rowTG = sqlsrv_fetch_array($rsTS2)){ ?>
                <option value="<?php echo $rowTG['Tipo_de_Gama'] ?>">
                <?php echo $rowTG['Tipo_de_Gama'] ?>
                </option>
                <?php } ?>
            </select>
                &nbsp &nbsp<label>Buscar por modelo:</label>&nbsp<input type="text" placeholder="Buscar por modelo" id="modelo" name="modelo" style="text-transform:uppercase" >
            
            
            &nbsp <input type="submit" name="buscar" value="buscar" class="btn btn-primary">
            </form>
           <?php

 if(isset($_POST['buscar'])){
            $Codbodega=$_POST['selectCodBodega'];
            $Tipgama=$_POST['selectGama'];
            $modelo=$_POST['modelo'];
            $fecha_stock=$_POST['selectFecha'];
     

        if($Codbodega<>'Todas las Bodegas' and $Tipgama<>'Todas las Gamas' and $modelo<>''){
            $sql = "SELECT * FROM STOCK_EQUIPOS WHERE Codigo_bodega = '".$Codbodega."' AND Tipo_de_Gama = '".$Tipgama."' AND (Modelo_Nombre_Comercial like '%".$modelo."%' or Marca like '%".$modelo."%') and Fec_inf='$fecha_stock' order by marca";
                
                
        }else if($Codbodega<>'Todas las Bodegas' and $Tipgama<>'Todas las Gamas'){
            $sql= "SELECT * FROM STOCK_EQUIPOS WHERE Codigo_bodega = '".$Codbodega."' AND Tipo_de_Gama = '".$Tipgama."' and Fec_inf='$fecha_stock' order by marca";
            
        }else if($Codbodega<>'Todas las Bodegas' and $modelo<>''){
            $sql= "SELECT * FROM STOCK_EQUIPOS WHERE Codigo_bodega = '".$Codbodega."' AND (Modelo_Nombre_Comercial like '%".$modelo."%' or marca like '%".$modelo."%') and Fec_inf='$fecha_stock' order by marca";
            
        }else if($Tipgama<>'Todas las Gamas' and $modelo<>''){
                $sql= "SELECT * FROM STOCK_EQUIPOS WHERE Tipo_de_Gama = '".$Tipgama."' AND (Modelo_Nombre_Comercial like '%".$modelo."%' or marca like '%".$modelo."%') and Fec_inf='$fecha_stock' order by marca";
            
        }else if($modelo<>''){
                $sql= "SELECT * FROM STOCK_EQUIPOS WHERE (Modelo_Nombre_Comercial like '%".$modelo."%' or marca like '%".$modelo."%') and Fec_inf='$fecha_stock' order by marca";
            
        }else if($Codbodega<>'Todas las Bodegas'){
                $sql= "SELECT * FROM STOCK_EQUIPOS WHERE Codigo_Bodega='".$Codbodega."' and Fec_inf='$fecha_stock'order by marca";
            
        }else if($Tipgama<>'Todas las Gamas'){
            $sql= "SELECT * FROM STOCK_EQUIPOS WHERE Tipo_de_Gama='".$Tipgama." ' and Fec_inf='$fecha_stock' order by marca";
            
        }else{
            $sql = "SELECT * FROM STOCK_EQUIPOS WHERE id>0 and Fec_inf='$fecha_stock' order by marca";
        
        }
        echo '<br>';
        
//        $resultado=sqlsrv_query($connect,$sql);
        
       
       
           echo '<br>';
        $resultado = sqlsrv_query($connect, $sql, array(), array( "Scrollable" => 'static' ));

        

        $sqlMarca = "SELECT distinct marca FROM STOCK_EQUIPOS WHERE Tipo_de_Gama='".$Tipgama."' and Modelo_Nombre_Comercial like '%".$modelo."%'";
        $rs2 = sqlsrv_query($connect, $sqlMarca);
        $NBodega='';
        if($Codbodega <> 'Todas las Bodegas'){
        $sqlNombreBodega= "SELECT distinct Nombre_de_la_Bodega,convert(varchar,fec_inf)as fec_inf FROM STOCK_EQUIPOS WHERE Codigo_Bodega='".$Codbodega."'";
        
        $rsNombreBodega = sqlsrv_query($connect,$sqlNombreBodega);
        
        while($rowSTNB = sqlsrv_fetch_array($rsNombreBodega)){
            $NBodega=$rowSTNB["Nombre_de_la_Bodega"];
            $FStock=$rowSTNB["fec_inf"];
            
        }
        echo '<strong>SELECCIONO LA BODEGA : '.$Codbodega.' - '.$NBodega.'<br> FECHA DE STOCK: '.$FStock.'</strong>';
           
       }else{
           echo'<strong>SELECCIONO: TODAS LAS BODEGA <br><br> FECHA DE STOCK : '.$fecha_stock.'<BR></strong>';
           echo $modelo;
       }
        
        
        echo '<br>';
        
        echo '<strong>Las Marcas de la Gama seleccionada son :</strong><br>';
        echo '<table>';
        while($rows2 = sqlsrv_fetch_array($rs2)){
            echo '<tr>';
            
            echo $rows2["marca"];
            
            echo'&nbsp </tr>';
            
        }
        ?>
            
       
        </table>
        <br>
        <div class="center">
        <table class ='table-bordered table-condensed' style='width:640px; height:1px;'>

         <?php
//            $found = 0;
            $GAMA='';
            if(sqlsrv_num_rows($resultado)>0){
                ?>
            <table class ='table-bordered table-condensed' style='width:640px; height:1px;'>
                <th style="text-align:center">MARCA</th>
                <th style="text-align:center">MODELO</th>
                <th style="text-align:center">GAMA</th>
                <th style="text-align:center">STOCK</th>
                <th style="text-align:center">COLOR</th>
            
            <?php
            while($row = sqlsrv_fetch_array($resultado)){
                
                
//                $found = 1;
                $GAMA=$row["Tipo_de_Gama"];
                $MARCA=$row["Marca"];
                    
                
                echo '<tr>';
                echo '<td align="left">'.$row["Marca"].'</td>';
                echo '<td align="left"  style="width:59%;">'.$row["Modelo_Nombre_Comercial"].'</td>';
                echo '<td align="center" style="width:20%;">'.$row["Tipo_de_Gama"].'</td>';
                echo '<td align="center" >'.$row["Stock"].'</td>';
                echo '<td align="center" style="width:25%;">'.$row["Color"].'</td>';
                echo '</tr>';
                }
                echo '</table>';
            }else{
            
//            if($found==0){
                  echo '<br>';
                  echo'<div class="alert alert-info" style="text-align:center; margin:0 auto; width:300px; height:50px;">';
                  echo '<strong>No hay resultados para la busqueda realizada</strong>';
                  echo '</div>';
            }
            if($sql=="SELECT * FROM STOCK_EQUIPOS WHERE id>0 order by stock desc"){
            }else if($Tipgama=='Todas las Gamas' and $modelo <> ''){
                ?>
                <br>
                <a class=" btn btn-primary" href='javascript:void(window.open("Sugerencias.php?llave=<?php echo $Tipgama?>","mypopuptitle","width=710","height=675"));'>MODELOS SIMILARES</a>
                    <!--<input type="submit" class="btn btn-primary" name="sugerencia" value="sugerencia">-->
                
                

                <?PHP
                
            }else if($Tipgama<>'Todas las Gamas' and $modelo == ''){
                ?>
                <br>
                <a class="btn btn-primary" href='javascript:void(window.open("Sugerencias.php?llave=<?php echo $Tipgama?>","mypopuptitle","width=710","height=675"));'>MODELOS SIMILARES</a>
                    <!--<input type="submit" class="btn btn-primary" name="sugerencia" value="sugerencia">-->
                
                        <?PHP
            }else if($Tipgama<>'Todas las Gamas' and $modelo <> ''){
                ?>
                <br>
                <a class="btn btn-primary" href='javascript:void(window.open("Sugerencias.php?llave=<?php echo $Tipgama?>","mypopuptitle","width=710","height=675"));'>MODELOS SIMILARES</a>
                    <!--<input type="submit" class="btn btn-primary" name="sugerencia" value="sugerencia">-->
                <?PHP
            }
        }
    ?>
        </div>
    </div> 
    </body>
</html>

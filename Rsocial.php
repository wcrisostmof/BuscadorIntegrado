<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cliente</title>
    </head>
    <body>
        <?php include 'Template.php';?>
        
        <div class="container">
        <form method="post"  action="Rsocial.php" id="searchform" autocomplete="on">
            <input type="text" placeholder="Buscar razón social" id="rc" name="cliente" style="text-transform:uppercase" >
            <input type="submit" value="buscar" name="buscar" class="btn-primary">
        </form>  
        <?php
        require_once 'MasterPage.php';
            if (!empty($_REQUEST['cliente'])) {
             $rsocial=$_REQUEST['cliente'];
            $query= "SELECT TOP 10 RUC, RAZON_SOCIAL,SUB_SEGMENTO,EJECUTIVO_COMERCIAL,JEFE FROM   cliente_segmentacion  where RAZON_SOCIAL LIKE '%" . $rsocial ."%' order by SUB_SEGMENTO DESC";
            $result=sqlsrv_query($connect,$query);
            $found = 0;
                echo "<table class='table-bordered table-condensed' style='text-align:center; width:80%; height:5%;'>";
                echo '<th bgcolor="#DBD4D4" style="text-align:center">RUC</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">RAZÓN SOCIAL</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">SUB SEGMENTO</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">EJECUTIVO COMERCIAL</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">JEFE</th>';
            while ($row = sqlsrv_fetch_array($result)){
                    $found = 1;
                    $ruc= $row['RUC'];
                    GLOBAL $ruc;
                            echo '<tr>';
                            echo '<td> <a href="contacto.php?ruc='.$ruc.'"> ' .$row['RUC'].'</a></td>';  
                            echo '<td>' .$row['RAZON_SOCIAL'].'</td>';
                            echo '<td>'.$row['SUB_SEGMENTO'].'</td>'; 
                            echo '<td>'.$row['EJECUTIVO_COMERCIAL'].'</td>';
                            echo '<td>'.$row['JEFE'].'</td>';
                            echo '</tr>';
            }
                echo '</table>';
                if($found==0){
//                   header('Location: /ProyectoBuscador/Message.php');
                    echo '<script>location = "/ProyectoBuscador/Message.php";</script>';
                }        
            }
        if(sqlsrv_close($connect)==TRUE){
        }else{
            }
        ?>    
        </div>
    </body>
</html>

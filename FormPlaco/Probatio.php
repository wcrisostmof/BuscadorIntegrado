<?php
session_start();
?>
<html>
    <head>
    <title>User Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="../CSS/Custom.css" rel="stylesheet" type="text/css"/>
  
    </head>
    
<body>
        <?php
        include 'TemplateForm.php';
        
        ?>
        <div class="container">
        
        <h4>Modelo de Escalamiento - Matriz de Contactos :</h4>
        <?php 
        $tablatipo='select distinct tipo from contactosplaco order by tipo';
        $rsTp=sqlsrv_query($connect,$tablatipo);
        echo '<form method="post" action="">';
        echo'<select  id="tipo_busqueda" name="selectedValue" style="width: 350px !important; min-width: 150px; max-width: 350px; height: 31px;">';
        echo "<option value='NA'>-Seleccionar-</option>";
        while($rowTipo = sqlsrv_fetch_array($rsTp)){
            echo "<option value='".$rowTipo['tipo']."'>".$rowTipo['tipo']."</option>";
        }
       echo'</select>';
       echo '&nbsp <input type="submit" name="buscar" value="buscar" class="btn btn-primary">';
       echo '</form>';								
    
    ECHO '</br>';

if(isset($_POST['buscar'])){
    $selectOption = $_POST['selectedValue'];
    
    
echo'MATRIZ DE CONTACTOS : '.$selectOption;

          $consContacto = "select [Escenarios Relevantes],[SLA Proceso],Producto, [Focal Point - Contacto], Area, Anexo,Celular, Sede, Correo, Observaciones from contactosplaco where tipo= '" . $selectOption ."';";
             $resultado=sqlsrv_query($connect,$consContacto);
                echo "<table class='table-bordered table-condensed' style='text-align:center; width:100%; height:1%;'>";
                echo '<th bgcolor="#DBD4D4" style="text-align:center">ESCENARIOS RELEVANTES</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">SLA Proceso</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">Producto</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">FOCAL POINT - CONTACTO</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">AREA</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">ANEXO</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">CELULAR</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">SEDE</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">CORREO</th>';
                echo '<th bgcolor="#DBD4D4" style="text-align:center">OBSERVACIONES</th>';
            while ($row = sqlsrv_fetch_array($resultado)){
                            echo '<tr>';
                            echo '<td>' .$row['Escenarios Relevantes'].'</td>';
                            echo '<td>' .$row['SLA Proceso'].'</td>';
                            echo '<td>' .$row['Producto'].'</td>';
                            echo '<td>' .$row['Focal Point - Contacto'].'</td>';
                            echo '<td>' .$row['Area'].'</td>';
                            echo '<td>'.$row['Anexo'].'</td>'; 
                            echo '<td>'.$row['Celular'].'</td>';
                            echo '<td>'.$row['Sede'].'</td>';
                            echo '<td>'.$row['Correo'].'</td>';
                            echo '<td>'.$row['Observaciones'].'</td>';
                            echo '</tr>';
            }
     
    
}

?>
        </div>
</body>
</html>


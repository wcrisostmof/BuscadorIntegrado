<?php 
include 'MasterPage.php';
$PorRuc= $_REQUEST["RucCliente"];
error_reporting(E_ALL);
ini_set('display_errors','On');
$queryPenalidades = 'SELECT  * from nb_rc_penalidades where RUC = '. $PorRuc.'';
//1era forma


//$resExport = sqlsrv_query($connect, $queryPenalidades);
//$columnHeader ='';
//$columnHeader = "CODIGOCLIENTE" . "\t" . "RUC" . "\t" . "NOMBRECLIENTE" . "\t" . "ANEXO" . "\t" . "TELEFONO" . "\t" . "NUMERORPM" . "\t" . "CUENTACORPORATIVA" . "\t" . "FECHA_TRX" . "\t" . "PENA_SERVICIO" . "\t" . "PENA_EQUIPO" . "\t" . "PENALIDAD_MAS_EQUIPO" . "\t". "PRODUCTO" . "\t" . "DEPARTAMENTO" . "\t". "SUB_SEGMENTO" . "\t" . "GRUPO_SUB_SEGMENTO" . "\t". "CARTERA" . "\t" . "CANAL" . "\t". "EJECUTIVO" . "\t" . "FECHAALTA" . "\t". "DESCRIPCIONPRODUCTO" . "\t" . "CARGOFIJOPLAN" . "\t". "CARGOMONEDA" . "\t" . "DESCRIPCIONPLAN" . "\t". "MINUTOSLIBRESPLANTM" . "\t" ."FECHAULTIMOCAMBIOEQUIPO" . "\t". "DESCRIPCIONMODELOEQUIPO" . "\t" ."SERIEELECTRICA" . "\t". "TIPOINVENTARIO" . "\t" ."ESTADOACTUAL" . "\t". "MARCA" . "\t" . "BLCOBL" . "\t". "BLDEBL" . "\t". "BLVALO" . "\t". "BLVALL" . "\t". "BLMILI" . "\t". "TR_FECHA" . "\t". "TR_MIN" . "\t". "TCSECN" . "\t". "E_SUBSIDIO" . "\t". "E_PRECIO_LISTA" . "\t". "E_PRECIO_COMPRA" . "\t". "E_DIAS_PEND" . "\t". "E_MESES_CONTRATO" . "\t". "CF_BOLSA" . "\t". "MESES_PEN_TRX" . "\t". "TCCPRO" . "\t". "activo_sn" . "\t";  
//
//$setData= '';
//
//while ($rec = sqlsrv_fetch_array($resExport)) {  
//    $rowData = '';
//    foreach ($rec as $value) {  
//        $value = '"' . $value . '"' . "\t";  
//        $rowData .= $value;  
//    }  
//    $setData .= trim($rowData) . "\n";  
//} 
//header("Content-type: application/octet-stream");  
//header("Content-Disposition: attachment; filename=Penalidades-$PorRuc.csv");  
//header("Pragma: no-cache");  
//header("Expires: 0");  
//  
//echo ucwords($columnHeader) . "\n" . $setData . "\n";  


//otra forma
session_start();
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Transfer-Encoding: binary");
header("Content-Type: application/csv");

$query = 'SELECT  * from nb_rc_penalidades where RUC = '. $PorRuc.'';

$filename = "penalidades-$PorRuc.csv";

  
  header("Content-Disposition: attachment; filename=$filename");
  header("Content-Type: text/csv; charset=UTF-8");

  $out = fopen("php://output", 'w');

  $flag = false;

  $result = sqlsrv_query($connect, $query) or die('Query failed!');
  $found = 0;
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
      $found = 1;
    if(!$flag) {
      // display field/column names as first row
        
      fputcsv($out, array_keys($row), ',', '"');
      
      $flag = true;
    }

    foreach ($row as $key => $value){
      if ($value instanceof DateTime){
        $row[$key] = date_format($value, 'd/m/y');
      }if($value === NULL){
          $row[$key] = '-';
          
      }
    }
    
    fputcsv($out, array_values($row));
  }
  if($found==0){
        header('Location: /BuscadorIntegrado/Message.php');
//    echo '<script>location = "/BuscadorIntegrado/Message.php";</script>';
        
        
                    
                }   
  exit;
?>
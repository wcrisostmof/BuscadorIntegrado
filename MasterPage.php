        <?php 
        $servername= 'GPPESVLCLI2244';
        $myUser = 'wcrisostomof';
        $mypass = 'wcrisostomof09';
        $DB1 = 'DB_PLACO';
        $connectionOptions = array("Database" => $DB1 , "UID"=>$myUser, "PWD"=>$mypass, "CharacterSet" =>"UTF-8"); 
        $connect = sqlsrv_connect($servername, $connectionOptions);        
//        
        GLOBAL $connect;
        if($connect){
            
        }else{
            echo "Conexion no se pudo establecer.<br/>";
            die(print_r(sqlsrv_errors(),TRUE));
        }
       ?>
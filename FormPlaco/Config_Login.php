<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="../CSS/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery-1.10.2.min.js" ></script>
        <script src="../js/jquery-ui-1.10.3.custom.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
<style>
            body{
  background: #F2F0F0;
}

div.well{
  height: 250px;
} 

.Absolute-Center {
  margin: auto;
  position: absolute;
  top: 0; left: 0; bottom: 0; right: 0;
}

.Absolute-Center.is-Responsive {
  width: 50%; 
  height: 50%;
  min-width: 200px;
  max-width: 400px;
  padding: 40px;
}

#logo-container{
  margin-top: 80px;
  margin: auto;
  margin-bottom: 100px;
  width:15px;
  height:10px;
  background-image:url('../Images/SoportePlaco.png');
}
            
        </style>    
        
    <?php
            require_once '../MasterPage.php';
            session_start();
           $message= "";
            if(count($_POST)>0) {
            $queryUSER = "SELECT * FROM placo WHERE UserName='" . $_POST["user_name"] . "' and PassWord = '". $_POST["password"]."'";
            $result =sqlsrv_query($connect,$queryUSER);
            
            $row  = sqlsrv_fetch_array($result);
            if(is_array($row)) {
            $_SESSION["user_name"] = $row[UserName];
            $_SESSION["password"] = $row[PassWord];
            } 
            else {
                echo '<div class="alert alert-danger alert-dismissable fade in">';
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                echo'<strong>Usuario o contraseña incorrecta.</strong>';
//                $message = "Usuario o contraseña incorrecta.";
                echo'';
                echo '</div>';
                
            
                }
            }
            if(isset($_SESSION["user_name"])) {
            header('Location: /ProyectoBuscador/FormPlaco/Probatio.php');  
            }
    ?>
        
        <form name="frmUser" method="post">
            <div class="container">
        <div class="message"><?php if($message!=""){ 
                                echo $message; 
                                } 
                                ?>
        </div>
            
                <div class="row">
                  <div class="Absolute-Center is-Responsive" style="border: 1px solid #000000;">
                      <div id="logo-container">
                          <img class="hidden-xs" style="max-width:180px; margin-top: auto; margin-left: -80px;" src="../Images/SoportePlaco.png">
                          
                        <img class="visible-xs" style="max-width:100px; margin-top: auto; margin-left: -150px;" src="../Images/SoportePlaco.png">
                          
                      </div>
                    <div class="col-sm-12 col-md-10 col-md-offset-1">
                      <form action="" id="loginForm">
                        <div class="form-group input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                          <input class="form-control" type="text" name='user_name' placeholder="usuario"/>          
                        </div>
                        <div class="form-group input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                          <input class="form-control" type="password" name='password' placeholder="contraseña"/>     
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Login" class="btn btn-def btn-block">
                        </div>
                      </form>        
                    </div>  
                  </div>    
                </div>
              </div>
            </form>
    </body>
</html>

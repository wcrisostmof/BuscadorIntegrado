<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cliente</title>
    </head>
    <link href="CSS/InputType.css" rel="stylesheet" type="text/css"/>
    <body>
        
        <?php include 'Template.php';?>
        <div class="container">
        <form method="post" name="fvalida" action="ContactoPorIDWEB.php" id="searchform" autocomplete="on" onsubmit="return validacionWEB() ">
            <input name="porWEB"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                min="0"
                type = "number"
                maxlength = "6"
                placeholder="BUSCAR POR ID WEB"
             />
            <input type="submit" value="buscar" name="buscar" class="btn-primary">
        </form>
            <script>
            function validacionWEB() {
                web = document.fvalida.porWEB.value;
                if (web===null || web.length <6) {
                  alert("El campo debe contener 6 digitos.");
                  
                  return false;
                }
            }
        </script>
            
            
            
        </div>
    </body>
</html>
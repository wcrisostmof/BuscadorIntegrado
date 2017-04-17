<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cliente</title>
    </head>
    <link href="CSS/InputType.css" rel="stylesheet" type="text/css"/>
    <body>
        
        <?php include 'Template.php';?>
        <div class="container">
        <form method="post" name ="fvalida" action="ContactoPorRuc.php" id="searchform" autocomplete="on" onsubmit="return validacion() ">
            <input name="porRUC"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                min="0"
                type = "number"
                maxlength = "11"
                placeholder="BUSCAR POR RUC"
             />
            <input type="submit" value="buscar" name="buscar" class="btn-primary">
        </form>
        <script>
            function validacion() {
                ruc = document.fvalida.porRUC.value;
                if (ruc===null || ruc.length <11) {
                  alert("El campo debe contener 11 digitos.");
                  
                  return false;
                }
            }
        </script>
        </div>
    </body>
</html>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
        <style>
        .abajo{
                    position: absolute;
                    left: 125px;
                    font-size: 20px;
                }
         .leftCont{
            float:left;
            width:400px;
            position: absolute;
        }
        .CenterCont{
             width: 600px;
            position: absolute;
            top:100px;
            bottom: 0;
            left: 0;
            right: 0;

            margin: auto;
        }
        .RightCont{
           float:right;
           width:200px;
           position: absolute;  
           left: 990px;
        }
        table.cellspace2{
            border-collapse: separate;
            border-spacing: 10px;
            
        }
        .contenedor{
            padding-right: 20px;
            padding-left: 20px;
            margin-right: auto;
            margin-left: auto;
        }
.tooltipclient {
	margin-top: 20px;
    position: relative;
    display: block;
	width: 250px;
	height:35px;
	border:1px solid #003245;
	background-color:#d2e0e3;
}
.tooltipclient > a{
	line-height:2.75em;
	color:#005c84
}
.tooltipclient .tooltiptextclient {
    visibility: hidden;
    width: 550px;
    background-color: #FFF;
    color: #005c84;
    text-align: left;
    border-radius: 6px;
    padding: 5px 15px 5px 0px;
    position: absolute;
    z-index: 1;
    bottom: -900%;
    left: 50%;
    margin-left: -275px;
    opacity: 0;
    transition: opacity 0.5s;
}

.tooltipclient .tooltiptextclient::after {
    content: "";
    position: absolute;
    top: -10px;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent #FFF transparent;
	z-index:99999999999;
}

.tooltipclient:hover .tooltiptextclient	{
    visibility: visible;
    opacity: 1;
}
        </style>
    <body>
    <?php
             include 'Template.php';
             require_once 'MasterPage.php';
        ?>

           <div align="center" class="container">
		   <fieldset style="border:1px solid #003245;width:50%;float:left;padding: 0px 0px 20px;">
			<legend style="width:initial;">FORMATOS MOVILES VIGENTES ABRIL 2017</legend>
				<div class="tooltipclient">
					<a  href="resources/include/zip/Contratos_Digitales.zip" download="Contratos_Digitales.zip"><img src="Images/rar.png">&nbsp;&nbsp;&nbsp;ZIP CONTRATO DIGITAL</a>
					<div class="tooltiptextclient">
					<ul>
						<li>Se ha modificado la ubicación del recuadro para la firma de aceptación del cliente, a fin de evitar confusiones con el ítem de Protección de Datos.</li>
						<li>Se ha agregado la columna “Cantidad de Líneas” donde deberán completar el total de las líneas con equipos solicitados por el cliente, no será necesario llenar la columna de “Teléfono” ni  “IMEI”, el resto de columnas deberán ser completadas de acuerdo al modelo actual.</li>
						<li>Se ha agregado la columna “Cantidad de Líneas” donde deberán completar el total de las líneas solicitadas por el cliente, sólo para ventas de portabilidad será necesario llenar la columna de N° de Teléfono.</li>
						<li>Se ha simplificado el formato de Bolsa de Minutos, con los costos pre-impresos de tarifas adicionales evitando el llenado manual.</li>
					</ul>
					</div>
					</div>
					<div class="tooltipclient">
					<a href="resources/include/zip/Contratos_Fisicos.zip" download="Contratos_Fisicos.zip"><img src="Images/rar.png">&nbsp;&nbsp;&nbsp;ZIP CONTRATO FISICO</a>
					<div class="tooltiptextclient">
					<ul>
						<li>Se ha modificado la ubicación del recuadro para la firma de aceptación del cliente, a fin de evitar confusiones con el ítem de Protección de Datos.</li>
						<li>Se ha agregado la columna “Cantidad de Líneas” donde deberán completar el total de las líneas con equipos solicitados por el cliente, no será necesario llenar la columna de “Teléfono” ni  “IMEI”, el resto de columnas deberán ser completadas de acuerdo al modelo actual.</li>
						<li>Se ha agregado la columna “Cantidad de Líneas” donde deberán completar el total de las líneas solicitadas por el cliente, sólo para ventas de portabilidad será necesario llenar la columna de N° de Teléfono.</li>
						<li>Se ha simplificado el formato de Bolsa de Minutos, con los costos pre-impresos de tarifas adicionales evitando el llenado manual.</li>
					</ul>
					</div>
					</div>
		   </fieldset>
             <h4 align="center"></h4>
			 
					
                </div>
            
    </body>
</html>
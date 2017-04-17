<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Información</title>
    </head>
        <style>
        .abajo{
                    margin: 0px auto;
                    width: 89%;
                    font-size: 20px;
                }
        #contenedor{
            width:1020px;
            text-align:center;
            display: block;
			overflow:hidden;
        }
        #leftCont{
            float:left;
            display: inline-block;
        }
        #CenterCont{
            float:left;
            display: inline-block;
            width:650px;
			margin-left: 20px;
            
        }
        #RightCont{
           float:left;
           display: inline-block;
        }
        #RightContactoAutorizados{
           float:left;
           display: inline-block;
           margin-top: 3%;
		   padding: 1%;
		   width:205px;
		   background-color:#d2e0e3;
		   border:1px solid #003245;
        }
        table.cellspace{
            border-collapse: collapse;
            border-spacing: 0px;
        }
		table.cellspace td{
		line-height: 1.75em;
		}
		@media only screen and (max-width: 800px){
			#contenedor{
				width:100%;
			}
		}
        </style>
    <body>
    <?php
             include 'Template.php';
             require_once 'MasterPage.php';
        ?>


         <div class="container">
            <div class="abajo">
               <h4 style="width:100%;text-align:center">CANALES DE ATENCIÓN PARA LOS CLIENTES</h4>
                    <img src="Images/Canales de atencionbk2.png"/>
                <!--AQUI ROAMING-->
                <div style="border:3px solid rgb(0,176,240);background-color:rgb(20,219,255);width:50%; margin: 10px auto;border-radius:5px;height: 40px;line-height:35px;text-align:center;color:#FFF;font-weight:bold;font-size:16px">
				CANALES DE ATENCI&Oacute;N PARA LOS EECC
				</div>
                <div id="contenedor">
                    <div id="leftCont">
                    <table class="cellspace">
                        <tr><td><img src="Images/roaming.png" /></td></tr>
                    </table>    
                    </div>
                    
                    <div id="CenterCont">
                        <table class="cellspace">
                            <thead>
                            <th>DATOS QUE TE PEDIRÁN EN ROAMING:</th>
                            
                            </thead>
                            <tbody>
                            <tr>
                                <td align="left" style="width:70%;">&#10004; País de destino</td>
								<td align="left" style="width:30%;">&#10004;RUC</td>
                            </tr>

                            <tr>
                                <td align="left">&#10004; Vigencia de activación de servicio de Roaming</td>
								<td align="left">&#10004;Nombre de la empresa</td>
                            </tr>
                            <tr>
                                <td  align="left">&#10004; Producto a solicitar: tarifa default, paquete de datos (abierto o controlado), planes</td>
								<td align="left" style="vertical-align:top" >&#10004;Nombre del ejecutivo</td>
                            </tr>
                            <tr>
                                <td  align="left">&#10004; Línea a activar.</td>
								<td align="left">&#10004;DNI del ejecutivo</td>
                            </tr>
                            
                            </tbody>
                        </table>
                        
                    </div>
             </div>
            <!--SEPARADOR                -->
                
            <br />

            
            
<!--                AQUI CONTACTOS AUTORIZADOS-->

            <div id="contenedor">
                    <div id="leftCont">
                    <table class="cellspace">
                        <tr><td><img src="Images/contactos.png" alt=""/></td></tr>
                    </table>    
                    </div>
                    <div id="CenterCont" style="width:450px;">
                        <table class="cellspace">
                            <thead>
                            <th>DATOS QUE TE PEDIRÁN EN CONTACTOS AUTORIZADOS:</th>
                            
                            </thead>
                            <tbody>
                            <tr>
                                <td align="left" style="width:60%;">&#10004;Formato de Contactos Autorizados con firma y huella del representante legal</td>
                            </tr>

                            <tr>
                                <td align="left" style="width:60%;">&#10004;Copia del DNI del representante legal</td>
                            </tr>
                            <tr>
                                <td  align="left" style="width:60%;">&#10004;Vigencia de Poderes no mayor a 90 días.</td>
                            </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <div id="RightContactoAutorizados">
                        <a href="resources/include/excel/Formato Contactos Autorizados.xlsx" download="Formato Contactos Autorizados.xlsx"><img src="Images/download.png" style="max-width:20px; margin-top: -4px;">Formato contacto autorizados</a>
                    </div>
            </div>
			<br />
			
			 <div id="contenedor">
                    <div id="leftCont">
                    <table class="cellspace">
                        <tr><td><img src="Images/medicion.png" alt=""/></td></tr>
                    </table>    
                    </div>
                    <div id="CenterCont" style="width:450px;">
                        <table class="cellspace">
                            <thead>
                            <th>TENER EN CUENTA:</th>
                            
                            </thead>
                            <tbody>
                            <tr>
                                <td align="left" style="width:60%;">&#10004;SLA 5 d&iacute;as en LIMA</td>
                            </tr>
                            <tr>
                                <td  align="left" style="width:60%;">&#10004;SLA 7 d&iacute;as en PROVINCIAS.</td>
                            </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <div id="RightContactoAutorizados">
                        <a href="resources/include/excel/FORMATO FICHA MEDICION DE SENAL.xlsx" download="Formato solicitud.xlsx"><img src="Images/download.png" style="max-width:20px; margin-top: -4px;">Formato de solcitiud</a>
                    </div>
            </div>
                
                
                
          </div>
        </div>
        
    </body>
</html>

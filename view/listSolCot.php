<?php session_start();//función de inicio de sesión?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//función para convertir la table
				"sScrollY":"250px",//scroll horizontarl
				"bPaginate":true,//habilitala paginación
				"oLanguage":{//url para la traducción al castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>

<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/reveal.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	try{
		$user=$_SESSION["username"];
	require_once("../db/connect.php");//llama a la conexión a base de datos
?>
      <h2><legend>Solicitudes de cotización</legend></h2>
        <img src="../images/cotizador.jpg" width="40" height="40" /><br>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button"><br>
        <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="30" width="30" title="Presionar sobre la imagen PDF para imprimir detalles de solicitud de cotización">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha de solicitud</label></th>
                    <th width="80"><label>Número de solicitud</label></th>
                    <th><label>Proveedor</label></th>
                    <th></th>
                </tr>
       </thead>
           <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
		    #button{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#F00;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
			</style>
<?php
#consulta de la solicitudes de cotización a proveedores
	$sql=$dbh->prepare("SELECT fecha, nro_solicitud, empProveedora
                        FROM solicitud_cotizacion, proveedor
                        WHERE solicitud_cotizacion.IDproveedor = proveedor.IDproveedor");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td align="center"><?php echo $row[0]//campo fecha;?></td>
     <td align="Center"><?php echo $row[1]//campo nro de solicitud;?></td>
     <td align="center"><?php echo $row[2]//campo proveedor;?></td>
     <td align="center">
<a href="<?php echo "../reportes/compraAlquiler/solCotizacion.php?nro=$row[1]&proveedor=$row[2]&user=$user";?>" target="_blank"><img src="../images/pdf_1.jpg" height="30" width="50" title="Imprimir solicitud en PDF"></a></td></tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una excepción en caso de que la conexión falle
		}
?>	
<?php
}
else
{ header("location: ../index.php");
	}
?>
</body>
</html>
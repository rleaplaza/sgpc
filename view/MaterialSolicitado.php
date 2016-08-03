<?php 
session_start();
?>
<html>
<head><title>Registro de materiales solicitados</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type"text/javascript">
//Activar permiso
		var fun = function (param,param2) {//función que ejecutará la ventana
			//var idPerm = $(this).attr("tipoPerm");
			var idparam = param;//captura el parámetro almacenado en la función del botón
			var idparam2=param2;//captura el segundo parámetro
			ajaxFace = new LightFace.Request({//instancia a la clase lightface
				url: 'registros/updateCantidadMaterial.php',//url de envío
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { //Datos solicitados para el programa
						IDmaterial: idparam || 'Id de parámetro no ingresado',
						IDsolicitud:idparam2 || 'Id de segundo parámetro no ingresado',
						Cantidad:document.id('cantidad').value || 'Cantidad no encontrada'
					},
					method: 'post'//métdo post
				},
				title: 'Actualización de cantidad de materiales'
			}).open();//abra la ventana
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
	</script>
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	try{
	//llamada a los archivos de conexión global a la base de datos y al log de auditoría
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
$fec1=$_POST["fec1"];
$fec2=$_POST["fec2"];
#consulta que indica el nombre del programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_GET["idopcion"];
		$row=$consulta->fetch();
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
	
		}
		else{
			header("location: ../index.php");
			}
	}
?>

      <h2><legend>MATERIALES SOLICITADOS</legend></h2>
      <label>Fecha de inicio </label><?php echo $fec1;?><br>
<label>Fecha límite </label><?php echo $fec2;?><br>
        <img src="../images/almacen.jpg" width="30" height="30" /><br>
        <input type="submit" id="button" value="VOLVER AL FORMULARIO" onclick="history.back();"><br>
        <a href="<?php echo "../reportes/compraalquiler/repSolicitud.php?fec1=$fec1&fec2=$fec2"?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en PDF"></a>
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                 <th><label>Nro de solicitud</label></th>
                   <th><label>Actividad</label></th>
                    <th><label>Material</label></th>
                    <th><label>Cantidad solicitada</label></th>
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
			color:#00C;
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

	$sql=$dbh->prepare("SELECT Nro_solicitud,material.IDmaterial,nombreActividad,descripcion, material.unidad, cantidad_sol
                        FROM material, solicitud_material, empleado, usuario,actividad
                        WHERE material.IDmaterial = solicitud_material.IDmaterial
						and solicitud_material.IDactividad=actividad.IDactividad
                        AND solicitud_material.IDempleado = empleado.IDempleado
						and empleado.CI=usuario.CI
						and FechaSolicitud=? 
						and FechaFinal=?
						and username=?");
	$sql->bindParam(1,$fec1);
	$sql->bindParam(2,$fec2);
	$sql->bindParam(3,$_SESSION["username"]);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
      <td align="center" width="400"><?php echo $row[0];?></td>
     <td width="300"><?php echo $row[2];?></td>
     <td width="300"><?php echo $row[3];?></td>
     <td width="80"><?php echo $row[5]." ".$row[4];?></td>
     <input type="hidden" value="<?php echo $row[5]?>" id="cantidad">
      <td width="80"><input type="button" onclick="fun('<?php echo $row[1];?>','<?php echo $row[0];?>'); return false;" class="submit classPermisos" value="Actualizar cantidad" id="button"></td></tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
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
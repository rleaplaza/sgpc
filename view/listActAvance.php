<?php session_start();//función de inicio de sesión?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/ajaxgr.js"></script>
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
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>

<script type"text/javascript">
//Activar permiso
		var fun = function (param,idfase) {
			//var idPerm = $(this).attr("tipoPerm");
			var idparam = param;
			ajaxFace = new LightFace.Request({
				url: 'registros/finAvance.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						IDactividad: idparam || 'Id de parámetro no ingresado',
						IDproyecto:document.id('idproyecto').value || 'ID de proyecto no almacenado',
						IDfase:idfase || 'ID de fase no encontrado'
					},
					method: 'post'
				},
				title: 'Fin de actividad'
			}).open();
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
<link href="../css/botones.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
require_once("../db/connect.php");
require_once("updateAct.php");//archivo que ejecuta estado de actividades que no han comenzado
	updateAct();//función de la actualización
//consulta de la fecha actual
$fecha=$dbh->prepare("select curdate()");
if($fecha->execute()){
	$resultado=$fecha->fetch();
	$fechaActual=$resultado[0];
	}
if(isset($_SESSION["username"])){
	try{
	$user=$_SESSION["username"];
	require_once("registros/regAuditoria.php");
	$idproyecto=$_GET["proyecto"];
	$consulta=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
	$consulta->bindParam(1,$idproyecto);
	$consulta->execute();
	$dato=$consulta->fetch();
	$proyecto=$dato[0];
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
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
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
<form method="post">
<label>Proyecto: </label><?php echo $proyecto;?><br>

<label>Seleccione una fase</label><select name="fase">
<?php 
$query=$dbh->prepare("select IDfase, nombre,concat(fecRegistro,' ',hraRegistro) as fecha from fase where IDproyecto=? order by fecha asc");
$query->bindParam(1,$idproyecto);
$query->execute();
if($query->rowCount()>0){
	foreach($query->fetchAll() as $fila){
	?>
    <option value="<?php echo $fila["IDfase"];?>"><?php echo $fila["nombre"];?>
    <?php
	}
}
?>
</select><br>
<input type="hidden" name="proyecto" value="<?php echo $proyecto;?>">
  <input type="hidden" value="<?php echo $user;?>" name="user">
<input type="image" height="40" width="40" title="Imprimir en PDF" src="../images/pdf_1.jpg" onClick="this.form.action='../reportes/proyectos/repgenAvance.php'" formtarget="_blank">
</form>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fase</label></th> 
                    <th><label>Actividad</label></th>
                    <th><label>Cantidad programada</label></th>
                    <th><label>Avance informado</label></th>
                    <th><label>Desde - Hasta</label></th>
                    <th><label>Duración</label></th>
                    <th><label>Estado</label></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
       </thead>
           <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  text-align:center;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
			 activo{
				 color:#093;
				 }
			 demorado{
				 color:#F00;
				 } 
			</style>
            
<?php
	$sql=$dbh->prepare("SELECT IDactividad, fase.nombre, nombreActividad, unidades, cantidad, fechaRealizacion,                         fechaFin, duracion_dias, total_avance,finalizado, fase.IDfase
                        FROM actividad, subfase, fase, proyecto
                        WHERE actividad.IDsubfase = subfase.IDsubfase
                        AND subfase.IDfase = fase.IDfase
                        AND fase.IDproyecto = proyecto.IDproyecto
						and proyecto.IDproyecto=?
						order by actividad.hraRegistro");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	$dbh->query("SET NAMES UTF8");
	foreach($sql->fetchAll() as $row){
		$idfase=$row[10];
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td align="center"><?php echo $row[4]." ".$row[3];?></td>
      <td><?php echo $row[8]. " ".$row[3];?></td>
     <td><?php if($fechaActual<$row[6] || $row[9]=="finalizada")
	           echo "<activo>".$row[5]."-".$row[6]."</activo>";
			   else 
			   echo "<demorado>".$row[5]."-".$row[6]."</demorado>";
			   ?></td>
     <td align="center"><?php echo $row[7]." días";?></td>
     <td><?php if($row[9]=="En ejecución" || $row[9]=="sin comenzar" || $row[9]=="finalizada" || $row["9"]=="reprogramada")
	           echo "<activo>".$row[9]."</activo>";
			   else
			   echo "<demorado>".$row[9]."</demorado>"?></td>
     <td width="80" align="center">
     <input type="hidden" value="<?php echo $idproyecto;?>" id="idproyecto">
     <input type="button" onclick="fun('<?php echo $row[0];?>','<?php echo $row[10];?>'); return false;" class="submit classPermisos" value="Finalizar" id="button"></td>
    <form method="get">
     <td width="100" align="center"> <input type="hidden" value="<?php echo $row[0];?>" name="idactividad">
     <input type="hidden" value="<?php echo $idproyecto;?>" name="idproyecto">
     <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
     <input type="submit" value="Mano de obra"  onClick="this.form.action='acmanoobra.php'" id="button"></td>
     <td align=="center"> <input type="submit" value="Materiales" onClick="this.form.action='acmaterial.php'" id="button1"></td>
     <td align="center"><input type="submit" value="Equipamiento" onClick="this.form.action='acmaquinaria.php'"  width="80" id="button2"></td></form>
     </tr>
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
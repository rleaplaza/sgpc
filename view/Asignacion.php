<?php
session_start();
?>
<html>
<head><title>Ejecución de actividades</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
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
        <script type="text/javascript" src="../js/ajaxgr.js"></script>
    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
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
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	$idproyecto=$_POST["proyecto"];
    $query=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
    $query->bindParam(1,$idproyecto);
    $query->execute();
    $fila=$query->fetch();
	$proyecto=$fila[0];
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_POST["idopcion"];
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
        <img src="../images/tareas.jpg" width="45" height="45" /><br>
        <label>Proyecto: </label><?php echo $proyecto;?><br>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fase</label></th> 
                    <th><label>Actividad</label></th>
                    <th><label>Cantidad</label></th>
                    <th><label>Desde - Hasta</label></th>
                    <th><label>Duración programada</label></th>
                    <th><label>Estado</label></th>
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
			</style>
<?php

#consulta de planificación
$query=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=? and fecFin is NULL");
$query->bindParam(1,$idproyecto);
$query->execute();
$result=$query->fetch();
$idplan=$result[0];
#consulta de la actividad
	$sql=$dbh->prepare("SELECT IDactividad, fase.nombre, nombreActividad, unidades, cantidad,fechaRealizacion, fechaFin, duracion_dias, actividad.finalizado, concat(fase.fecRegistro,' ',fase.hraRegistro) as fecha
                        FROM actividad, subfase, fase, proyecto
                        WHERE actividad.IDsubfase = subfase.IDsubfase
                        AND subfase.IDfase = fase.IDfase
                        AND fase.IDproyecto = proyecto.IDproyecto
						and proyecto.IDproyecto=?
						order by fecha asc");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	$dbh->query("SET NAMES UTF8");
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td width="180"><?php echo $row[1];?></td>
     <td width="120"><?php echo $row[2];?></td>
     <td width="50"><?php echo $row[4]." ".$row[3];?></td>
     <td width="120"><?php echo $row[5]."-".$row[6];?></td>
     <td width="50"><?php echo $row[7]." dias";?></td>
     <td width="80"><?php echo $row[8];?></td>
     <td align="center"><button onClick="asignar('<?php echo $row[0];?>',
                                  '<?php echo $row[1];?>',
                                  '<?php echo $row[2];?>',
                                  '<?php echo $idplan;?>',
                                  '<?php echo $idopcion;?>',
                                  '<?php echo $idproyecto;?>')" id="button">MANO DE OBRA</button></td>
     <td align="center"><button onClick="asignarM('<?php echo $row[0];?>',
                                   '<?php echo $row[1];?>',
                                   '<?php echo $row[2];?>',
                                   '<?php echo $idplan;?>',
                                   '<?php echo $idopcion;?>',
                                   '<?php echo $idproyecto;?>')" id="button1">MATERIALES</button></td>
     <td align="center"><button onClick="asignarMq('<?php echo $row[0];?>',
                                    '<?php echo $row[1];?>',
                                    '<?php echo $row[2];?>',
                                    '<?php echo $idplan;?>',
                                    '<?php echo $idopcion;?>',
                                    '<?php echo $idproyecto;?>')" id="button2">EQUIPAMIENTO</button></td></tr>
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
<?php
session_start();//función de inicio de sesión
?>
<html>
<head><title>Ejecución de actividades</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {//función para convertir la tabla de la página
            $("#tableParam").dataTable({//llama a la función para convertir la tabla
				"sScrollY":"250px",//activa el scroll vertical
				"bPaginate":true,//mantiene la paginación
				"oLanguage":{//url que llama al archivo para traducir las operaciones de la tabla el idioma castellano
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
</head>
<body>
<?php
if(isset($_SESSION["username"])){//valida la existencia del usuario en sesión 
	try{
	require_once("../db/connect.php");//llamada al archivo de conexión
	require_once("registros/regAuditoria.php");//archivo log de auditorlia
	#consulta del programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);//enlaza al ID de la opción
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_POST["idopcion"];
		$row=$consulta->fetch();//luego de ejecutar la instrucción los campos se muestran en un arreglo
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		}
		else{
			header("location: ../index.php");
			}
	}
?>
      <h2><legend>LISTADO DE ACTIVIDADES CON MATERIAL PRESUPUESTADO</legend></h2>
        <img src="../images/almacen.jpg" width="45" height="45" /><br>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fase</label></th> 
                    <th><label>Actividad</label></th>
                    <th><label>Cantidad programada</label></th>
                    <th><label>Inicio</label></th>
                    <th><label>Fin</label></th>
                    <th><label>Duración programada</label></th>
                    <th><label>Estado</label></th>
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
		    #button{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00C;
			border-radius:8px 8px 8px 8px;
			}
			#button:hover{
					background:#666;
					}
			 #button1{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#093;
			border-radius:8px 8px 8px 8px;
			}
			#button1:hover{
					background:#666;
					}
			</style>
<?php
#captura de variables usando el método POST
$idproyecto=$_POST["proyecto"];
$idopcion=$_POST["idopcion"];
#consulta de planificación
$query=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=? and fecFin is NULL");
$query->bindParam(1,$idproyecto);
$query->execute();
$result=$query->fetch();
$idplan=$result[0];
#consulta de la actividad con materiales presupestados
	$sql=$dbh->prepare("SELECT actividad.IDactividad, fase.nombre, nombreActividad, unidades, cantidad,                        fechaRealizacion, fechaFin, duracion_dias, actividad.finalizado, material.descripcion,                        material.unidad, cantidad_programada, cant_solicitada,material.IDmaterial
                        FROM actividad, subfase, fase, proyecto, actividad_material, material
                        WHERE actividad_material.IDmaterial = material.IDmaterial
                        AND actividad_material.IDactividad = actividad.IDactividad
                        AND actividad.IDsubfase = subfase.IDsubfase
                        AND subfase.IDfase = fase.IDfase
                        AND fase.IDproyecto = proyecto.IDproyecto
						and proyecto.IDproyecto=?
						order by actividad.hraRegistro");
	$sql->bindParam(1,$idproyecto);//enlaza al ID del proyecto
	$sql->execute();//ejecuta la consulta
	$dbh->query("SET NAMES UTF8");//formato de codificación UTF8
	foreach($sql->fetchAll() as $row){//arreglo que desplegará todas las filas de la consulta
	#asignación de variables
	$idmaterial=$row[13];
	$fechas=$row[5]."-".$row[6];
	switch($row[8]){
		case 'finalizada':
		$color="color:green;";
		break;
		
		case 'demorada':
		$color="color:red";
		break;
		
		case 'en ejecución':
		$color="color:gold";
		break;
		}
	#el resultado se desplegará en el siguiente arreglo de la tabla
	#El campo button almacena una función javascript almacenando los parámetros que serán enviados
	#a una función javascript para cargar el programa de solicitud en una ventana modal
		   ?>
     <tr>
     <td width="200"><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td width="50" ><?php echo $row[4]." ".$row[3];?></td>
     <td width="80" align="center"><?php echo $row[5];?></td>
     <td width="80" align="center"><?php echo $row[6];?></td>
     <td width="50"><?php echo $row[7]." dias";?></td>
     <td width="80" style="<?=$color;?>"><?php echo $row[8];?></td>
     <td align="center"><button onClick="solicitarMat('<?php echo $row[0];?>',
                                   '<?php echo $row[1];?>',
                                   '<?php echo $row[2];?>',
                                   '<?php echo $idplan;?>',
                                   '<?php echo $idopcion;?>',
                                   '<?php echo $idproyecto;?>',
                                   '<?php echo $idmaterial;?>',
                                   '<?php echo $fechas;?>')" id="button1">Solicitar material</button></td>
      <td align="center"><button onClick="consultaMat('<?php echo $row[0];?>',
                                   '<?php echo $row[2];?>',
                                   '<?php echo $idopcion;?>')" id="button">Materiales entregados</button></td>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){//genera una excepción en caso de existir un error inesperado
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
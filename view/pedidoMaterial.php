<?php
session_start();
?>
<html>
<head><title>Ejecución de actividades</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//función del datatable
				"sScrollY":"250px",//scroll vertical para la tabla
				"bPaginate":true,//paginación
				"oLanguage":{//traducción al idioma castellano
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
if(isset($_SESSION["username"])){//valida la existencia de sesión
	try{
		#llamada a los archivo de conexión global
	require_once("../db/connect.php");
	#consulta PDO para control del programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);//enlaza al ID de opción
	$consulta->execute();//ejecuta la instrucción
	if($consulta->rowCount()>0){
		$idopcion=$_POST["idopcion"];
		$row=$consulta->fetch();//desplegará los resultados en el arreglo $row
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
                    <th><label>Nro de pedido</label></th> 
                    <th><label>Fecha</label></th> 
                    <th><label>Estado de pedido</label></th> 
                    <th><label>Fase</label></th> 
                    <th><label>Actividad</label></th>
                    <th><label>Cantidad programada</label></th>
                    <th><label>Desde - Hasta</label></th>
                    <th><label>Duración</label></th>
                    <th><label>Estado de actividad</label></th>
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
			color:#00F;
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
#consulta para recuperar el identificador de empleado 
$query=$dbh->prepare("select IDempleado from usuario, empleado
                     where usuario.CI=empleado.CI
					 and username=?");
$query->bindParam(1,$_SESSION["username"]);//enlaza al nombre de usuario
$query->execute();//ejecuta la instrucción
$result=$query->fetch();//devuelve el resultado en un arreglo
$idempleado=$result[0];//asigna el campo
$idproyecto=$_POST["proyecto"];
#consulta de planificación
$query=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=? and fecFin is NULL");
$query->bindParam(1,$idproyecto);
$query->execute();
$result=$query->fetch();
$idplan=$result[0];
#consulta de la actividad asociada a materiales presupuestados y asignados al encargado de almacén específico
$sql=$dbh->prepare("SELECT Nro_pedido, fecha, pa.estado,f.nombre, nombreActividad, unidades, cantidad,                   fechaRealizacion, fechaFin, duracion_dias, finalizado,a.IDactividad
                    FROM proyecto as p,fase AS f, subfase AS s, actividad AS a, pedido_almacen AS pa, empleado AS e
                    WHERE p.IDproyecto=f.IDproyecto 
					and f.IDfase = s.IDfase
                    AND s.IDsubfase = a.IDsubfase
                    AND a.IDactividad = pa.IDactividad
                    AND pa.IDempleado = e.IDempleado
					and p.IDproyecto=?
					and e.IDempleado=?
					order by a.hraRegistro");
	$sql->bindParam(1,$idproyecto);//enlaza a los parámetros ID de proyecto e ID de empleado
	$sql->bindParam(2,$idempleado);
	$sql->execute();//ejecuta la instrucción
	$dbh->query("SET NAMES UTF8");//formato de codificación UTF8
	foreach($sql->fetchAll() as $row){//arreglo que desplegará todas las filas de la consulta
	//$idmaterial=$row[15];
	$idactividad=$row[11];
	$fechas=$row[7]."-".$row[8];
	$estado=$row[2];
		   ?>
     <tr>
     <td width="200"><?php echo $row[0];?></td>
     <td width="200"><?php echo $row[1];?></td>
     <td width="200"><?php echo $row[2];?></td>
     <td width="200"><?php echo $row[3];?></td>
     <td width="200"><?php echo $row[4];?></td>
     <td width="200"><?php echo $row[6].$row[5];?></td>
     <td width="200"><?php echo $row[7]." ".$row[8];?></td>
     <td width="200"><?php echo $row[9]." dias";?></td>
     <td width="200"><?php echo $row[10];?></td>
      <td align="center"><button id="button" onclick="consultaPedido('<?php echo $row[0];?>','<?php echo $idopcion;?>','<?php echo $idactividad;?>','<?php echo $idempleado;?>','<?php echo $idproyecto;?>','<?php echo $idplan;?>','<?php echo $estado;?>')">Consultar Pedido</button></td>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){//excepción que se generará en caso de errores inesperados
		echo "Error inesperado ".$e->getMessage();
		}
?>	
<?php
}
else{ header("location: ../index.php");
	}
?>
</body>
</html>
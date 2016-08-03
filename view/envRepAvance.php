<?php
session_start();//función de inicio de sesion
?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
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
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
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
		echo("<label>".$row["nombremenu"]."</label> ");
		echo("<label>". $row["nombresubmenu"]."</label> ");
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
      <h2><legend>LISTADO DE AVANCE DE ACTIVIDADES</legend></h2>
        <img src="../images/tareas.jpg" width="30" height="30" /><br>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fase</label></th> 
                    <th><label>Actividad</label></th>
                    <th><label>Unidad</label></th>
                    <th><label>Avance programado</label></th>
                    <th><label>Avance Real</label></th>
                    <th><label>Desde - Hasta</label></th>
                    <th><label>Duración</label></th>
                    <th><label>Estado</label></th>
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
$idproyecto=$_POST["proyecto"];
	$sql=$dbh->prepare("SELECT IDactividad, fase.nombre, nombreActividad, unidades, cantidad,total_avance,fechaRealizacion, fechaFin, duracion_dias, finalizado
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
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td><?php echo $row[5];?></td>
     <td><?php echo $row[6]." ".$row[7];?></td>
     <td><?php echo $row[8];?></td>
     <td><?php echo $row[9];?></td>
     <td><a href="<?php echo "../reportes/proyectos/repAvance.php?idactividad=$row[0]";?>" target="_blank"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir avances en pdf"></a></td>
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
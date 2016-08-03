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
        <img src="../images/tareas.jpg" width="30" height="30" /><br>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fase</label></th> 
                    <th><label>Actividad</label></th>
                    <th><label>Cantidad</label></th>
                    <th><label>Total avanzado</label></th>
                    <th><label>Comienzo</label></th>
                    <th><label>Fin</label></th>
                    <th><label>Duración</label></th>
                    <th><label>Estado</label></th>
                    <th><label>Fecha de registro</label></th>
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
					background:#0CC;
					}
			activo{
				color:#0C3;
				}
			inactivo{
				color:#F00;
				}
			</style>
<?php
$idproyecto=$_POST["proyecto"];
	$sql=$dbh->prepare("SELECT IDactividad, fase.nombre, nombreActividad, unidades,                        cantidad,total_avance,fechaRealizacion, fechaFin, duracion_dias, finalizado, aprobado,                         actividad.fecRegistro, actividad.hraRegistro
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
		$estado=$row[9];
		$total_avance=$row[5];
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[4]." ".$row[3];?></td>
     <td><?php echo $row[5]." ".$row[3];?></td>
     <td><?php echo $row[6];?></td>
     <td><?php if($row[9]=="En ejecución" || $row[9]=="finalizada" || $row[9]=="sin comenzar")
	            echo "<activo>".$row[7]."</activo>";
				else 
				 echo "<inactivo>".$row[7]."</inactivo>";?></td>
     <td><?php echo $row[8]." días";?></td>
     <td><?php if ($row[9]=="En ejecución" || $row[9]=="finalizada" || $row[9]=="sin comenzar")
	               echo "<activo>".$row[9]."</activo>";
				   else 
				  echo "<inactivo>".$row[9]."</inactivo>";?></td>
     <td><?php echo $row[11];?></td>
     <td><button id="button" onClick="editActividad('<?php echo $row[0];?>',
                                                    '<?php echo $estado;?>',
                                                    '<?php echo $total_avance;?>')">Editar</button></td></tr>
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
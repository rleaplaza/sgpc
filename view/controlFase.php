<?php
#Este programa se encarga de listar el control de las actividades para realizar seguimientos de avances
session_start();
?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//captura el id de la tabla
				"sScrollY":"250px",//habilita el scroll vertical
				"bPaginate":true,//habilita la pagianción
				"oLanguage":{//traduce el idioma de la funcionalidad del datatable al castellano
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
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){//validación de las sesión para permitir el ingreso
	try{
	require_once("../db/connect.php");//llamada a la conexión de base de datos
	if(isset($_POST["proyecto"])){
$idproyecto=$_POST["proyecto"];//captura del UID del proyecto
$consulta=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
$consulta->bindParam(1,$idproyecto);
$consulta->execute();
$result=$consulta->fetch();
$proyecto=$result[0];
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
		#despliega el nombre del programa donde se está navegando
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
        <img src="../images/seguimiento.jpg" width="40" height="40" /><br>
         <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button"><br>
        <label>Proyecto: </label><?php echo $proyecto;?>
       
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fase</label></th> 
                    <th><label>Estado</label></th>
                    <th><label>Actividades programadas</label></th>
                    <th><label>Actividades concluidas</label></th>
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
			color:#00F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00F;
			border-radius:8px 8px 8px 8px;
			color:#FFF;
			}
				#button:hover{
					background:#09F;
					}
			</style>
<?php

#consulta PDO para devolver los precios unitarios de actividades para seguimientos
$sql=$dbh->prepare("SELECT IDfase,nombre, estado, act_programadas,act_concluidas,concat(fecRegistro,' ',hraRegistro) as fecha from fase where IDproyecto=? order by fecha asc");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	$dbh->query("SET NAMES UTF8");
	foreach($sql->fetchAll() as $row){
		$fase=$row["nombre"];
		$estado=$row["estado"];
		$actProgramadas=$row["act_programadas"];
		$actConcluidas=$row["act_concluidas"];
		$fecha=$row["fecha"];
		   ?>
     <tr>
   <td><?php echo $fase;?></td>
   <td><?php echo $estado;?></td> 
   <td><?php echo $actProgramadas;?></td>
   <td><?php echo $actConcluidas;?></td> 
   <td><?php echo $fecha;?></td> 
   <td align="center"><form method="post">
   <input type="hidden" value="<?php echo $proyecto;?>" name="nombreproyecto">
   <input type="hidden" value="<?php echo $row[0];?>" name="idfase">
   <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
   <input type="hidden" value="<?php echo $idproyecto;?>" name="proyecto">
   <input type="submit" value="Información de la fase" onClick="this.form.action='infoFase.php'" id="button">
   </form></td> 
     </tr>
		<?php
		}
}else{
	echo "Ningún proyecto existente";
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
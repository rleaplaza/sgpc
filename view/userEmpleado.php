<?php session_start(); //función de inicio de sesión?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"><title>Registro de Empleados</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableEmployee").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
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
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();

	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		//consulta de la cedula para direccionar a informacion de empleado
		$sql=$dbh->prepare("select empleado.CI from empleado,usuario 
		                    where empleado.CI=usuario.CI 
							and username=?");
		$sql->bindParam(1,$_SESSION["username"]);
		$sql->execute();
		$fila=$sql->fetch();
		?>
        <a href="<?php echo("verInfoEmpleado.php?cedula=$fila[0]");?>"><label>Ver su información personal</label></a>
        <a href="<?php echo("verInfoLaboral.php?cedula=$fila[0]");?>"><label>Ver su información laboral</label></a>
        <?php	
		}
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
		else{
		header("location: ../index.php");
		}
	?>
  <div class="tabber" id="tab2">
  <div class="tabbertab">
  <h2><legend>INFORMACIÓN PERSONAL DE EMPLEADOS</legend></h2>
  <img src="../images/empleado.jpg" width="30" height="30" />
  <table id="tableEmployee" width="1200" align="left">
    <thead>
           	  <tr><th width="188"><label>Nombre</label></th>
                  <th width="185"><label>Ap. Paterno</label></th>
                  <th width="185"><label>Ap. Materno</label></th>
                  <th width="185"><label>Cédula</label></th>
                  <th width="185"><label>Teléfono</label></th>
                  <th width="185"><label>Dirección</label></th>
                  <th width="185"><label>Fecha de nacimiento</label></th>
                  <th width="185"><label>Estado civil</label></th>
                  <th width="185"><label>Fecha de registro</label></th>
                  <th width="185"><label>Hora de registro</label></th>
                  <th width="185"><label></label></th>
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
			</style>
<?php

 $sql=$dbh->prepare("select nombres, app, apm, CI, telefonos, direccion, fecNacimiento, estadoCivil, fechaRegistro, hraRegistro from empleado");
 //$sql->bindParam(1,$fila[0]);
 $sql->execute();
					
	//$sql->bindParam(1,$_SESSION["username"]);
	//$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
    <tr>
     <td><?php echo $row[0];?></td>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td><?php echo $row[5];?></td>
     <td><?php echo $row[6];?></td>
     <td><?php echo $row[7];?></td>
     <td><?php echo $row[8];?></td>
     <td><?php echo $row[9];?></td>
      
     <td><a href="<?php echo("nuevoUsuarioEmpleado.php?cedula=$row[3]");?>">Registrar como nuevo usuario</a></td>    
    </tr>
	<?php
		}
		?>
</table>
</div>  
<?php 
$query=$dbh->prepare("SELECT pagina_opcion.nombre, pagina_opcion.url
                     FROM opcion, pagina_opcion, permiso_pagina, usuario
                     WHERE opcion.IDopcion = pagina_opcion.IDopcion
                      AND pagina_opcion.IDpagina = permiso_pagina.IDpagina
                      AND permiso_pagina.USR_UID = usuario.USR_UID
                      AND username=?
                      AND opcion.IDopcion=?
                      and permiso_pagina.estado='activo'
					  order by pagina_opcion.nombre ASC");
	$query->bindParam(1,$_SESSION["username"]);
	$query->bindParam(2,$_GET["idopcion"]);
	$query->execute();
	if($query->rowCount()>0){
		foreach($query->fetchAll() as $row){
?>
    <div class="tabbertab">
       <h2><legend><?php echo($row[0]);?></legend></h2>
       <?php require_once($row[1]);?>
    </div>
<?php
	}
}
?>
        
</div>
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
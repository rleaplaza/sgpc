<!doctype html>
<?php
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<title>Subpermisos asignados</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablesubpermiso").dataTable();
        });
		</script>
        <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			#sub{
				
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
				}
				#sub:hover{
					background:#ddd;
					}
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
<img src="../images/permisos.jpg" width="50" height="50" /><br>
<?php
if(isset($_SESSION["username"])){ 
try{ 
include("../db/connect.php");
if(isset($_GET["iduser"]) && isset($_GET["idopcion"])){
$iduser=$_GET["iduser"];
$query=$dbh->prepare("select *from usuario where USR_UID=?");
$query->bindParam(1,$iduser);
$query->execute();
$row=$query->fetch();
?>
<label>SubPermisos del usuario: </label><?php echo"<b>". $row["USR_UID"]." ".$row["username"]."</b>";?><br>
<input type="submit" value="Volver a permisos" onClick='history.back();' id="sub"><br>

<fieldset id="content">
<legend>Listado de subpermisos asignados</legend>
       <table id="tablesubpermiso" width="514" align="left">
      <thead>
            	<tr>
                    <th width="185"><label>Codigo de pagina</label></th>
                    <th width="185"><label>Nombre de pagina</label></th>
                    <th width="185"><label>Estado</label></th>
                    <th width="185"><label>Fecha de asignación</label></th>
                    <th width="185"><label>Hora de asignación</label></th>
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

$sql=$dbh->prepare("select *from usuario where USR_UID=?");
$sql->bindParam(1,$iduser);
$sql->execute();
$row=$sql->fetch();
$sql=$dbh->prepare("SELECT pagina_opcion.IDpagina, pagina_opcion.nombre, permiso_pagina.estado, fecAssignacion,        hra_Asignacion
                    FROM usuario, permiso_pagina, pagina_opcion, opcion
                    WHERE usuario.USR_UID = permiso_pagina.USR_UID
                    AND permiso_pagina.IDpagina = pagina_opcion.IDpagina
                    AND pagina_opcion.IDopcion = opcion.IDopcion
                    AND username = ?
                    AND permiso_pagina.estado = 'activo'
                    AND opcion.IDopcion =?");
		$sql->bindParam(1,$row["username"]);
		$sql->bindParam(2,$_GET["idopcion"]);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchall() as $row){
				?>
                <tr>
     <td><?php echo ($row[0]);?></td>
     <td><?php echo ($row[1]);?></td>
     <td><?php echo ($row[2]);?></td>
     <td><?php echo ($row[3]);?></td>
     <td><?php echo ($row[4]);?></td>
     </tr>
                <?php
				}
				?>
                </table>
               </fieldset>
                <?php
			}	
}
else
{header("location: ../index.php");
	}
	}catch(PDOException $e){
	echo("Error".$e->getMessage());
	}
}
else{
	header("location: ../index.php");
	}
 ?>
</body>
</html>
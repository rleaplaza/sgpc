<html>
<?php
session_start();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestión de permisos</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablepermiso").dataTable();
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
					#submit{
				
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
				}
				#submit:hover{
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
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
</head>
<body>

<img src="../images/permisos.jpg" width="50" height="50" /><br>
<?php
if(isset($_SESSION["username"])){ 
try{ 
include("../db/connect.php");
$idrol=$_GET["idrol"];
$query=$dbh->prepare("select *from rol where IDrol=?");
$query->bindParam(1,$idrol);
$query->execute();
$row=$query->fetch();
?>
<label>Permisos del rol: </label><?php echo"<b>". $row["IDrol"]."</b>";?><br>
<input type="submit" value="Volver a role list" onClick='history.back();' id="submit"><br>

<fieldset id="content">
<legend>Listado de permisos asignados</legend>
       <table id="tablepermiso" width="800" align="left">
      <thead>
            	<tr>
                    <th width="188"><label>Codigo de opcion</label></th>
                    <th width="185"><label>Nombre de opcion del permiso</label></th>
                    <th width="185"><label>Estado del permiso</label></th>
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

$sql=$dbh->prepare("select *from rol where IDrol=?");
$sql->bindParam(1,$idrol);
$sql->execute();
$row=$sql->fetch();
$sql=$dbh->prepare("SELECT opcion.IDopcion, nombreopcion, rol_opcion.estado, fecAsignacion, hraAsignacion
                    FROM opcion, rol_opcion, rol
                    WHERE opcion.IDopcion = rol_opcion.IDopcion
                    AND rol_opcion.IDrol = rol.IDrol
                    AND rol.IDrol = ?
                    AND rol_opcion.estado = 'activo'");
		$sql->bindParam(1,$row["IDrol"]);
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
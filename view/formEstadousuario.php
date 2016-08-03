<?php session_start();?>
<!DOCTYPE HTML>
<html
<head>
<meta charset="utf-8">
    <title>Formulario de Usuario</title>
  <script type="text/javascript" src="../js/jquery.min.js"></script>

<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<?php 
#Este programa corresponde al formulario de registro de nuevos usuarios dentro del sistema
if(isset($_SESSION["username"])){//verifia la existencia de la sesión
?>

</head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<style>
text{
	font:Verdana, Geneva, sans-serif;
    color:#00C;
    font-size:18px;
	}
label{ font:Verdana, Geneva, sans-serif;
	color:#00C;
	         }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
				 }
</style>

<body>
<?php
try{
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/regAuditoria.php");//llama al archivo log de auditoría
	require_once("consultas/mensajeAyuda.php");
	$user=$_SESSION["username"];
	#consulta el programa donde se está navegando
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
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función log de auditoría
                $mensaje=consultaMensaje($_GET["idopcion"]);
		}
                ?>
<label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>"><br>
                <?php
		}
	else{
		header("location: ../index.php");//redirige al login
		}
?>
<img src="../images/activo.png" width="30" height="30" /> <img src="../images/inactivo.png" width="30" height="30" />

<fieldset>
<legend>Formulario de impresión de estado de usuarios</legend>
<form method="post" class="usuario" id="formulario" name="form1">
<table align="left">
<div><tr><td><label>Seleccione un estado</label></td><td><select name="estado" id="estado" class="select" required>
<option value="">_Seleccione una opción
<option value="activo">Activo
<option value="inactivo">Inactivo
</select></div>
  <input type="hidden" value="<?php echo $user;?>" name="user">
  <tr><td><input type="submit" value="EXPORTAR A PDF"  onClick="this.form.action='../reportes/administracion/repEstado.php'"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
 
  </table>
          </form>
          </fieldset>
<script src="../js/functions.js"></script>
<?php

}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
}
else{
header("location: ../index.php");	
	}
?>
</body>
</html>
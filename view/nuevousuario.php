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
<script type="text/javascript">
//Este programa javascript se encarga de enviar consulta de disponibilidad de usuario usando ajax de este forma se determina si el usuario existe o no en el sistema
$(document).ready(function() {	
	$('#username').blur(function(){//evento blur que se ejecuta después de mover el cursor de el campo nombre de usuario
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);//captura la imagen de carga

		var username = $(this).val();	//captura el valor del campo usuario	
		var dataString = 'username='+username;//concatena el campo para enviarlo a la url
		
		$.ajax({
            type: "POST",//método post
            url: "consultas/userdisponible.php",
            data: dataString,//envía la variable datastring
            success: function(data) {//si la función logra enviar la variable se ejecuta la instrucción
				$('#Info').fadeIn(1000).html(data);//captura la información
            }
        });
    });              
});    
</script>
<body>
<?php
try{
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/regAuditoria.php");//llama al archivo log de auditoría
	require_once("consultas/mensajeAyuda.php");
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
		?>
        <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>"><br>
        <?php
		}
		}else{
		header("location: ../index.php");//redirige al login
		}
?>
<img src="../images/adduser.png" width="30" height="30" />

<fieldset>
<legend>Formulario de usuario</legend>
<form method="post" class="usuario" id="formulario" name="form1">
<table align="left">
<div><tr><td><label>Usuario:</label></td><td><input type="text" id="username" class="username" name="username" maxlength="25" autofocus required placeholder="nombre de usuario"><img src="../images/ayuda.jpg" height="30" width="30" title="nombre de usuario"></td></div><div id="Info"></div>
<div><tr><td> <label>Email:</label></td><td><input type="email" class="email" name="email" maxlength="40" required placeholder="nombre@dominio.com"></td></tr></div>
<div><tr><td><label>Password:</label></td><td><input type="password" class="password" name="password" placeholder="******" maxlength="15" required/><img src="../images/ayuda.jpg" height="20" width="20" title="El password debe ser entre 8 y 10 caracteres, por lo menos un digito y un alfanumérico, y no puede contener espacios"></td></tr></div>
  <div> <tr><td><label>Confirmar password:</label></td><td><input type="password" class="confpassword" name="confpassword" placeholder="******" maxlength="15" required/></td></tr></div>  
  <input type="hidden" class="cedula" name="cedula" value="<?php if(isset($_GET["cedula"])){$ci=$_GET["cedula"];}else{$ci="";}?>">
  <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
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
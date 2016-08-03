<?php session_start();?>
<!DOCTYPE HTML>
<html
<head>
<meta charset="utf-8">
    <title>Formulario de Usuario Empleado</title>
   
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">

<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<input type="submit" value="Volver a listado de empleados" onClick='history.back();' id="sub"><br>
<?php 
if(isset($_SESSION["username"])){
require_once("../db/connect.php");
$sql=$dbh->prepare("select nombres, app, apm from empleado where CI=?");
$sql->bindParam(1,$_GET["cedula"]);
$sql->execute();
$fila=$sql->fetch();
?>
<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
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

</head>
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {	
	$('#username').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var username = $(this).val();		
		var dataString = 'username='+username;
		
		$.ajax({
            type: "POST",
            url: "consultas/userdisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
});    
</script>
<body>
<img src="../images/adduser.png" width="30" height="30" />
<?php 
$consulta=$dbh->prepare("select *from usuario, empleado
                         Where usuario.CI=empleado.CI
						 and usuario.CI=?");
$consulta->bindParam(1,$_GET["cedula"]);
$consulta->execute();
if($consulta->rowCount()==0){
?>
<fieldset>
<legend>Formulario de usuario</legend>
<form method="post" class="usuario" id="formulario" name="form1">
<table align="left">
<div><tr><td><label>Username:</label></td><td><input type="text" id="username" class="username" name="username" placeholder="username" maxlength="25"/></td></div><div id="Info"></div>
<div><tr><td> <label>Cedula</label></td><td><input type="text" class="cedula" name="cedula"  value="<?php if(isset($_GET["cedula"])){echo $_GET["cedula"];}?>" disabled="disabled"></td></tr></div>
<div><tr><td> <label>Email:</label></td><td><input type="text" class="email" name="email" placeholder="example@gmail.com" maxlength="80"></td></tr></div>
<div><tr><td><label>Password:</label></td><td><input type="password" class="password" name="password" placeholder="******" maxlength="20"/></td></tr></div>
  <div> <tr><td><label>Confirmar password:</label></td><td><input type="password" class="confpassword" name="confpassword" placeholder="******" maxlength="20"/></td></tr></div>  
  <input type="hidden" class="cedula" name="cedula" value="<?php if(isset($_GET["cedula"])){$ci=$_GET["cedula"];}else{$ci="";}?>">
  <input type="hidden" name="nombre" value="<?php echo $fila["nombres"];?>">
  <input type="hidden" name="app" value="<?php echo $fila["app"];?>">
  <input type="hidden" name="apm" value="<?php echo $fila["apm"];?>">
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
}
else{
	echo "<label>El empledo ya se encuentra como usuario en el sistema</label>";
	}
}
else{
header("location: ../index.php");	
	}
?>
</body>
</html>
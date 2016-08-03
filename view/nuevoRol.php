<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos roles</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/example.css" rel="stylesheet" type="text/css">
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
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
    <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#idrol').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var idrol = $(this).val();		
		var dataString = 'idrol='+idrol;
		
		$.ajax({
            type: "POST",
            url: "consultas/roldisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
</script>   
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
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
		}
	}
		?>
    <fieldset>
   
    <legend>FORMULARIO DE NUEVO ROL</legend>
   <img src="../images/rol de usuario.gif" width="40" height="40" /><br>
    <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" width="20" height="20" title="<?php echo $mensaje;?>">
  
    <form method="post" class="usuario" id="form" name="formRol">
    <table align="left">
    <div><tr><td><label>CODIGO DE ROL</label></td><td><input type="text" id="idrol" class="idrol" name="idrol" maxlength="20"></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Nombre de Rol</label></td><td><input type="text"  class="rol" name="rol"></td></tr></div>
    <div><tr><td><label>Descripcion de Rol</label></td><td><textarea class="desc" name="desc" rows="6" cols="30"></textarea></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoRol.js"></script>
    <?php
	}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
		}
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
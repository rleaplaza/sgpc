<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
	   </style>
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	require_once("consultas/mensajeAyuda.php");
	$user=$_SESSION["username"];
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
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
<img src="../images/pedido.jpg" height="40" width="40"><br>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
<fieldset>
    <legend>FORMULARIO DE INFORMES DE PEDIDOS</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <tr><td><label>Estado</label></td><td><select name="estado" class="select">
                                          <option value="Atendido">Atendido
                                          <option value="Pendiente">Pendiente
                                          <option value="Cancelado">Cancelado
                                          </select></td></tr>
    <tr><td><label>Desde</label></td><td><input type="text" id="fecha1" class="fecha1" name="fecha1" contenteditable="false"></td></tr>
     <tr><td><label>Hasta</label></td><td><input type="text" id="fecha2" class="fecha2" name="fecha2" contenteditable="false"></td></tr>
     <input type="hidden" value="<?php echo $user;?>" name="user">
  <tr><td><input type="submit" class="boton_envio" id="sub" value="IMPRIMIR" onClick="this.form.action='../reportes/compraAlquiler/infPedido.php'"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO" onFocus="limpiar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
<script type="text/javascript">
$(function() {
	$( "#fecha1" ).datepicker();
	$( "#fecha1" ).datepicker('option',{dateFormat:'yy-mm-dd'});//define el formato yyyy-mm-dd 
	$( "#fecha2" ).datepicker();
	$( "#fecha2" ).datepicker('option',{dateFormat:'yy-mm-dd'});//define el formato yyyy-mm-dd 
});
    </script>
</body>
</html>
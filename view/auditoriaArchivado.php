<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de archivado de auditoría</title>
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
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.3.custom.min.js"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/fechaCastellano.js"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/archivarAuditoria.php',
					buttons: [
						{ title: 'Cerrar', 
						  event: function() {
							 this.close(); 
							 },
					      color:'blue'
						 }
					],
					request: { 
						data: { 
						    Fecha1:document.id('fecha1').value || 'fecha no ingresada',
							Fecha2:document.id('fecha2').value || 'fecha no ingresada'
						},
						method: 'post'
					},
					title: 'Archivado de auditoría'
				}).open();
				limpiar();
			});
			
		});    
		function limpiar(){
			document.getElementById("fecha1").value="";
			document.getElementById("fecha2").value="";
		    document.getElementById("fecha1").focus();
			}
		
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	require_once("consultas/mensajeAyuda.php");
		if(isset($_GET["idopcion"])){
			$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"] ."</label><br>");
		echo("<label>" . $row["nombresubmenu"] . "</label><br>");
		echo("<label>" .$row["nombreopcion"] . "</label></p>");
		regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);
		}
			
	?>
<label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="Para realizar el archivado de datos de auditoría, ingresar el rango de fechas para realizar el registro histórico"/>
<fieldset>
    <legend>FORMULARIO DE ARCHIVADO DE DATOS DE AUDITORÍA</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Desde</label></td><td><input type="text" id="fecha1" class="fecha"></td></tr></div>
    <div><tr><td><label>Hasta</label></td><td><input type="text" id="fecha2" class="fecha"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="ARCHIVAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO" onFocus="limpiar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
		}else{
			header("location: ../index.php");
			}
	}else{
		header("location: ../index.php");
		}
?>
<script type="text/javascript">
$(function() {
	$( ".fecha" ).datepicker({changeMonth:true,
	                           changeYear:true,
							   dateFormat:'MM yy'});
	$( ".fecha" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
    </script>
</body>
</html>
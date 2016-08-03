<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de control de feriados</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   #sub{ font-wight:bold;
			   cursor:pointer;
			   padd ing:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#eee;
			   border-razdius:8px 8px 8px 8px;
		      }
		 #sub:hover{
				background:#ddd;
			}
	   </style>
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
 <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/fechaCastellano.js"></script>  
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					draggable:true,
					url: 'registros/addFeriado.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    Nombre:document.id('nombre').value || 'nombre no agregado',
							Desc:document.id('desc').value || 'no existe la descripcion',
							Fec1:document.id('fec1').value || 'Fecha no capturada',
							Fec2:document.id('fec2').value || 'Fecha no capturada'
						},
						method: 'post'
					},
					title: 'Registro de feriados',
					
				}).open();
				limpiar();
				
			});
			
		});    
		function limpiar(){
			document.getElementById("nombre").value="";
			document.getElementById("desc").value="";
			document.getElementById("fec1").value="";
			document.getElementById("fec2").value="";
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
       <img src="../images/calendario.jpg" width="40" height="40"><br> 
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
       <form method="post">
       <input type="submit" id="sub" name="consulta" value="CONSULTAR FERIADO" onClick="this.form.action='listFeriado.php'">
       </form>
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}else{
		header("location: ../index.php");
		}
	}
	if(isset($_GET["idopcion"])){
	?>
<fieldset>
    <legend><label>FORMULARIO DE REGISTRO DE FERIADOS</label></legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Nombre</label></td><td><input type="text"  class="nombre" name="nombre" id="nombre" maxlength="80" ></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Descripción</label></td><td><textarea name="desc" class="desc" id="desc" rows="5" cols="30"></textarea></td></tr></div>
    <div><tr><td><label>Fecha de inicio</label></td><td><input type="text" name="fecInicio" id="fec1" contenteditable="false"><img src="../images/ayuda.jpg" height="20" width="20" title="Escriba una fecha ej. 2014-09-14"></td></tr></div>
    <div><tr><td><label>Fecha de finalización</label></td><td><input type="text" name="fecFin" id="fec2" contenteditable="false"><img src="../images/ayuda.jpg" height="20" width="20" title="Escriba una fecha ej. 2014-09-14, la fecha no puede ser mayor a la de inicio"></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><input type="button" class="boton_envio" id="sub1" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
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
	$( "#fec1" ).datepicker(); //functión datepicker
	$( "#fec1" ).datepicker('option',{dateFormat:'yy-mm-dd'});//define el formato yyyy-mm-dd
	$( "#fec2" ).datepicker();
	$( "#fec2" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
</script>
</body>
</html>
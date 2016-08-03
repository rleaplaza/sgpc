<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="../../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="../registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
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
          <script src="../../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="../registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="../registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="../registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="../registros/lightface/Source/LightFace.Request.js"></script>
<script src="../../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: '../registros/updateFeriado.php',//url para procesar el programa
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //requerimiento de los datos a procesar
						    IDferiado:document.id('idferiado').value || 'ID no encontrado',
						    Nombre:document.id('nombre').value || 'nombre no agregada',
							Desc:document.id('desc').value || 'No existe la descripcion',
							Fec1:document.id('fec1').value || 'Fecha no capturada',
							Fec2:document.id('fec2').value || 'Fecha no capturada'
						},
						method: 'post'
					},
					title: 'Edicion de feriados'
				}).open();
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//valida la sesión
	require_once("../../db/connect.php");#llama a la conexión
		if(isset($_GET["idferiado"])){//si existe la variable id del feriado se podrá proceder con la edición
	?>
    <?php
    $sql=$dbh->prepare("select *from calendario_feriado where IDferiado=?");
	$sql->bindParam(1,$_GET["idferiado"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$res=$sql->fetch();
	?>
    <fieldset>
    <label>Para obtener ayuda, coloque el mouse sobre la imagen</label><img src="../../images/ayuda.jpg" height="25" width="25" title="Para editar el feriado seleccione un campo y cambie el contenido"><br>
    <legend>FORMULARIO DE EDICIÓN DE FERIADOS</legend>
   <img src="../../images/calendario.jpg" width="56" height="50" />
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Nombre</label></td><td><input type="text" class="nombre" name="nombre" id="nombre" value="<?php echo $res["nombre"];?>" maxlength="80"></td><div id="Info"></div></tr></div>
    <input type="hidden" name="feriado" value="<?php echo $res["IDferiado"];?>" id="idferiado">
    <div><tr><td><label>Descripción</label></td><td><textarea name="desc" class="desc" id="desc" rows="5" cols="30"><?php echo $res["descripcion"];?></textarea></td></tr></div>
    <div><tr><td><label>Fecha de inicio</label></td><td><input type="text" name="fecInicio" id="fec1" value="<?php echo $res["Inicio_feriado"];?>" readonly></td></tr></div>
    <div><tr><td><label>Fecha de finalización</label></td><td><input type="text" name="fecFin" id="fec2" value="<?php echo $res["Fin_feriado"];?>"><img src="../../images/ayuda.jpg" height="20" width="20" title="Fecha almacenada <?php echo $res["Fin_feriado"]?>"></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><input type="button" class="boton_envio" id="sub1" value="EDITAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		echo "<label>Registro no existente en sistema</label>";
		
		}
	}else{
		header("location: ../../index.php");
		}
	}else{
		header("location: ../../index.php");
		}
?>
<script type="text/javascript">
$(function() {
	$( "#fec2" ).datepicker();
	$( "#fec2" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
</script>
</body>
</html>
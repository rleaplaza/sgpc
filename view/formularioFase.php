<?php session_start();?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro de fases</title>
<style>
  label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
   legend{font:Verdana, Geneva, sans-serif;
	      color:#009;
	      size:auto;
		}
 #button{ font-wight:bold;
			   cursor:pointer;
			   padd ing:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#eee;
			   border-razdius:8px 8px 8px 8px;
		      }
		 #button:hover{
				background:#ddd;
				cursor:pointer;
			}
	
	</style>
    <link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
     <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
     <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>

    <script type="text/javascript">
$(document).ready(function() {	
	$('#fase').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var fase = $(this).val();		
		var dataString = 'fase='+fase;
		
		$.ajax({
            type: "POST",
            url: "consultas/fasedisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
</script> 
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addFase.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDproyecto:document.id('idproyecto').value || 'nombre no agregado',
							IDplan:document.id('idplan').value || 'cargo no ingresado',
							Long:document.id('longitud').value || 'Valor no almacenado',
							Fase:document.id('fase').value || 'Dato no almacenado'
						},
						method: 'post'
					},
					title: 'Registro de parámetros'
				}).open();
				limpiar();
				
			});
			
		}); 
		function limpiar(){
			document.getElementById("fase").value="";
			document.getElementById("longitud").value="";
			}   
</script>
</head>
<body>
<img src="../images/gant.jpg" height="30" width="30"/><br>
<?php 
if(isset($_SESSION["username"])){
	require_once("registros/regAuditoria.php");
	require_once("consultas/mensajeAyuda.php");
	?>
    <input type="submit" value='Volver a formulario de proyectos' onClick='history.back();' id="button"><br>
<label>Ayuda del sistema</label>
<img src="../images/ayuda.jpg" height="30" width="30" title="llenar el formulario de la siguiente forma"/><br>
 
<?php
try{
require_once("../db/connect.php");
if(isset($_POST["proyecto"])){
	$idproyecto=$_POST["proyecto"];
	$sql=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	$res=$sql->fetch();
	$nombreProyecto=$res["nombre"];
	
	$consulta=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=?");
	$consulta->bindParam(1,$idproyecto);
	$consulta->execute();
	$row=$consulta->fetch();
	$idplanificacion=$row[0];
	?>
     
<fieldset>
     <legend>Formulario de registro de fases por proyecto</legend>
     <form method="post" class="usuario" id="formulario" name="form" >
     <table>
<div><tr><td><label>Nombre del proyecto</label></td><td><textarea name="proy" cols="40" rows="3" readonly class="proy"><?php echo $nombreProyecto;?></textarea>
<input type="hidden" value="<?php echo $idproyecto;?>" name="idproyecto" class="idproyecto" id="idproyecto">
<input type="hidden" value="<?php echo $idplanificacion;?>" id="idplan"></td></tr></div>
<div><tr><td><label>Nombre de la fase:</label></td><td><input type="text" id="fase" name="fase" class="fase" maxlength="110" required></td><div id="Info"></div></tr></div>
<div><tr><td><label>Longitud en Kilómetros:</label></td><td><input type="text" name="longitud" class="longitud" maxlength="9" placeholder="245.00" id="longitud" required></td></tr></div>
  <tr><td align="left"><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div>
 </table>
   </form>
   </fieldset>
        <?php
}else{
	header("location: ../index.php");
	}
	 }catch(PDOException $e){
		echo("Error inesperado");
		}
		?>
<?php
}
else{
	header("location: ../index.php");
}
?>
</body>
</html>
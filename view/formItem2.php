<?php session_start();?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro de materiales</title>
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
			}
	
	</style>
    <link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
    <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
    <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
      <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addItem2.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							IDmaterial: document.id('idmaterial').value || 'ID no capturado',
						    DescItem:document.id('descItem').value || 'Cédula no agregada',
							Estado:document.id('estado').value || 'cargo no ingresado'
						},
						method: 'post'
					},
					title: 'Registro de items de maquinaria'
				}).open();
				
			});
			
		});    
</script>  

</head>
<body>
<img src="../images/maquinaria1.jpg" height="50" width="50"/><br>
<?php 
if(isset($_SESSION["username"])){
	try{
	require_once("registros/regAuditoria.php");
	require_once("consultas/mensajeAyuda.php");
	if(isset($_GET["idmat"])){
		$idmaterial=$_GET["idmat"];
	?>
<label>Ayuda del sistema</label>
<img src="../images/ayuda.jpg" height="30" width="30" title="Llenar el formulario con la correspodiente información de la subfase y la descripción"/><br>
     <input type="submit" value='Volver a listado de maquinaria' onClick='history.back();' id="button"><br>
  <?php
  $sql=$dbh->prepare("SELECT descripcion from material where IDmaterial= ?");
  $sql->bindParam(1,$idmaterial);
  $sql->execute();
  $res=$sql->fetch();
  ?>
<fieldset>
     <legend>Formulario de registro de items de material</legend>
     <form method="post" class="usuario" id="formulario" name="form" >
     <table>
     <div><tr><td><label>Descripción de material</label></td><td><input type="text" name="desc" class="desc" disabled="disabled" value="<?php echo $res["descripcion"];?>"></td>
       <input type="hidden" value="<?php echo $idmaterial;?>" name="idmaterial" class="matarial" id="idmaterial"></tr></div>
<div><tr><td><label>Descripción de item</label></td><td><textarea name="desc" class="descItem" id="descItem" rows="2" cols="15"></textarea></td></tr></div>
<div><tr><td><label>Estado:</label></td><td><input type="text" id="estado" name="estado" class="estado" value="Pendiente de solicitud" disabled="disabled"></td></tr></div>
<div><tr><td align="left"><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input type="reset" value="VACIAR FORMULARIO"></td></tr>
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
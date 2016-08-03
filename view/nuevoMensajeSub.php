<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de mensajes de ayuda</title>

<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addMensajeSub.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							codSubpermiso: document.id('idsubpermiso').value || 'ID de opción no agregado',
						    Descripcion:document.id('desc').value
						},
						method: 'post'
					},
					title: 'Registro de mensajes de ayuda'
				}).open();
				
			});
			
		});
</script>

<style>
label{ font:Verdana, Geneva, sans-serif;
		     color:#00C;
	        }
	  legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	         color:#009;
	         size:auto;
			}
#button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
</style>
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	if(isset($_GET["idpagina"])){
		$idpagina=$_GET["idpagina"];
		$sql=$dbh->prepare("select nombre from pagina_opcion where IDpagina=?");
		$sql->bindParam(1,$idpagina);
		$sql->execute();
		$fila=$sql->fetch();
	?>
    <input type=submit value='Volver a listado de subpermisos' onClick='history.back();' id="button">
    <fieldset>
    <img src="../images/ayuda.jpg" height="50" width="50">
    <legend>Formulario de Mensajes de ayuda para subpermisos</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>Nombre de subpermiso:</label></td><td><input type="text" id="nombre" class="nombre" name="nombre" value="<?php echo $fila["nombre"]?>" disabled="disabled">
    <input type="hidden" id="idsubpermiso" name="idsubpermiso" value="<?php echo $idpagina;?>"></td></tr></div>
    <div><tr><td><label>Descripción:</label></td><td><textarea id="desc" name="desc" class="desc" rows="6" cols="30" max="200"></textarea></td></tr></div>
  <tr><td><input id="sub" type="button" class="boton_envio" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
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

</body>
</html>
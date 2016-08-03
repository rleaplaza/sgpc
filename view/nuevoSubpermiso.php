<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de opciones</title>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function() {	
	$('#subpermiso').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var subpermiso = $(this).val();		
		var dataString = 'subpermiso='+subpermiso;
		
		$.ajax({
            type: "POST",
            url: "consultas/subpermisodisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
$(document).ready(function() {	
	$('#direccion').blur(function(){
		
		$('#Info1').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var direccion = $(this).val();		
		var dataString = 'direccion='+direccion;
		
		$.ajax({
            type: "POST",
            url: "consultas/direcciondisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info1').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
</script>
 <style>
       label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	   legend{font:Verdana, Geneva, sans-serif;
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
	     #button:hover{
			background:#ddd;
			}
	    </style> 
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	if(isset($_GET["idopcion"])){
		$idopcion=$_GET["idopcion"];
		$nombreopcion=$_GET["nombreopcion"];
	?>
    <input type="submit" value='Volver a listado de submenús' onClick='history.back();' id="button">
    <fieldset>
    <legend>Formulario de opciones del sistema</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>Codigo de Opción:</label></td><td><input type="text" id="idopcion" class="idopcion" name="idopcion" disabled="disabled" value="<?php echo $idopcion;?>"/></td></tr></div>
    <div><tr><td><label>Nombre de opción:</label></td><td><input type="text" id="nombreopcion" class="nombreopcion" name="nombreSuembnu" disabled="disabled" value="<?php echo $nombreopcion;?>"/></td></tr></div>
    <div><tr><td><label>Nombre de subpermiso:</label></td><td><input type="text" id="subpermiso" class="subpermiso" name="subpermiso" placeholder="FORMULARIO DE PROYECTO" maxlength="40" /></td><div id="Info"></div></tr></div>
        <div><tr><td><label>Descripcion:</label></td><td><textarea id="desc" class="desc" name="desc" placeholder="Formulario de registro de proyectos" rows="6" cols="30" ></textarea></td><div id="Info1"></div></tr></div>
    <div><tr><td><label>Dirección de acceso:</label></td><td><input type="text" id="direccion" class="direccion" name="direccion" placeholder="example.php" maxlength="30" /></td><div id="Info1"></div></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoSubpermiso.js"></script>
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
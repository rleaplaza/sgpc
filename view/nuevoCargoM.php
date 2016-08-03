<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de cargos de mano de obra</title>
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {	
	$('#nombre').blur(function(){
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);
		var nombre = $(this).val();		
		var dataString = 'nombre='+nombre;
		$.ajax({
            type: "POST",
            url: "consultas/cmanoobraDisponible.php",
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
				
	?>
    <fieldset>
    <legend>Formulario de Cargos de mano de obra</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
     <div><tr><td><label>Nombre:</label></td><td><input type="text" id="nombre" class="nombre" name="nombre"  maxlength="80" /></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Descripción:</label></td><td><textarea name="desc" class="desc" cols="40" rows="6" ></textarea></td></tr></div>
    <div><tr><td><label>Unidad de trabajo:</label></td><td><input type="text" class="unidad" name="unidad" value="HH" readonly></td></tr></div>
    <div class="ultimo">
     <div><tr><td><label>Precio Unitario BS:</label></td><td><input type="text" class="precio" name="precio"></td></tr></div>
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoCargoM.js"></script>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
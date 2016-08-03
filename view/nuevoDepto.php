<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de cargos</title>

<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {	
	$('#depto').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var depto = $(this).val();		
		var dataString = 'depto='+depto;
		
		$.ajax({
            type: "POST",
            url: "consultas/deptodisponible.php",
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
    <legend>Formulario de Registro de Departamentos</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>Nombre de Departamento:</label></td><td><input type="text" id="depto" class="depto" name="depto" placeholder="administrador" maxlength="40" /></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Descripción de Departamento:</label></td><td><textarea name="descdepto" class="descdepto" rows="6" cols="30" max="150" placeholder="admnistración de la empresa"></textarea></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button id="button" class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoDepto.js"></script>
    <?php
	}else{
		header("location: ../index.php");
		}
?>

</body>
</html>
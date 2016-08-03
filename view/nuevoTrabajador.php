<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de empleados de mano de obra</title>

<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />

<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/fechaCastellano.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#ci').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var ci = $(this).val();		
		var dataString = 'ci='+ci;
		
		$.ajax({
            type: "POST",
            url: "consultas/cedulaDisponible.php",
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
	require_once("../../db/connect.php");
	$sql=$dbh->prepare("select e.CI,username from encargadomanoobra as e, usuario as u 
	                    where e.USR_UID=u.USR_UID
						and username=?");
	$sql->bindParam(1,$_SESSION["username"]);
	$sql->execute();
	$fila=$sql->fetch();
	$cedula=$fila[0];			
	?>
    <fieldset>
    <legend>Formulario de Trabajadores de mano de obra</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>Seleccionar cargo de trabajador</label></td><td><select name="cargomanoobra" class="cargomanoobra">
    <?php
    $query=$dbh->prepare("select *from cargomanodeobra order by nombre");
	$query->execute();
	$dbh->exec("SET NAMES 'utf8'");
	foreach($query->fetchAll() as $fila){
	echo "<option value=".$fila[0].">".$fila[1]."</option>";
	}
	?>
    </select></td><td><label>Experiencia:</label></td><td><input type="text" class="experiencia" name="experiencia"></td></tr>
    <div><tr><td><label>Cédula de Identidad:</label></td><td><input type="text" id="ci" class="ci" name="ci"  maxlength="80" placeholder="5588443 Exp La Paz" /></td><div id="Info"></div><td><label>Teléfono:</label></td><td><input type="text" class="tel" name="tel" placeholder="2405544 - 72548994"></td></td></tr></div>
     <div><tr><td><label>Cédula de Encargado:</label></td><td><input type="text" id="ciencargado" class="ciencargado" name="ciencargado" maxlength="80" value="<?php echo $cedula;?>" disabled="disabled" /></td><td><label>Dirección:</label></td><td><input type="text" class="dir" name="dir"></td></tr></div>
     <div><tr><td><label>Nombres:</label></td><td><input type="text" id="nombre" class="nombre" name="nombre" maxlength="80" /></td><td><label>Fecha de nacimiento</label></td><td><input type="text" id="Datepicker1" name="fecn" class="fecn" placeholder="1970-10-15"><img src="../images/ayuda.jpg" height="30" width="30" title="Ej. 1970-03-01"></td></tr></div>
    <div><tr><td><label>Apellido Paterno:</label></td><td><input type="text" id="app" class="app" name="app" maxlength="80" /></td></tr></div>
     <div><tr><td><label>Apellido Materno:</label></td><td><input type="text" id="apm" class="apm" name="apm" maxlength="80" /></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoTrajador.js"></script>
    <?php
	}else{
		header("location: ../index.php");
		}
?>

<script type="text/javascript">
$(function() {
	$( "#Datepicker1" ).datepicker(); 
	$( "#Datepicker1" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
    </script>
</body>
</html>
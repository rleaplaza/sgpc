<?php session_start();?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de Empleados</title>
<style>
  label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
   legend{font:Verdana, Geneva, sans-serif;
	      color:#009;
	      size:auto;
		}
   #sub{ font-wight:bold;
	     cursor:pointer;
		 padding:5px;
		 margin: 0 10px 20 px 0;
		 border: 1px solid #ccc;
		 background:#eee;
		 border-radius:8px 8px 8px 8px;
		}
	#sub:hover{background:#ddd;
			}
	</style>
    <link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
    <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
    <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
    <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
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
<img src="../images/empleado.jpg" height="30" width="30"/>
<?php 
if(isset($_SESSION["username"])){
	require_once("registros/regAuditoria.php");
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
		}
	}
	else{
		header("location: ../index.php");
		}
?>
<?php
try{
require_once("../db/connect.php");
	?>
     
<fieldset>
     <legend>Formulario de nuevo Empleado</legend>
     <form method="post" class="usuario" id="formulario" name="form" >
     <table>
<div><tr><td><label>Nombre del empleado</label></td><td><input type="text" id="nombre" class="nombre" name="nombre" placeholder="Rodrigo Ivan" ></td> <td><label>Estado civil</label></td><td><select id="estadocivil" class="estadocivil" name="estadocivil">
<option value="soltero/a">Soltero/a
<option value="casado/a">Casado/a
</select></td></tr></div>
<div><tr><td><label>Apellido Paterno</label></td><td><input type="text" id="app" class="app" name="app" placeholder="Lea Plaza"></td><td><label>Fecha de ingreso:</label></td><td><input type="text" id="Datepicker2" class="fecIngreso" name="fecIngreso" contenteditable="false" placeholder="2014-01-01"></td></tr></div>
<div><tr><td><label>Apellido Materno</label></td><td><input type="text" id="apm" class="apm" name="apm" placeholder="Chavez"></td><td><label>Profesión:</label></td><td><select name="profesion" id="profesion" class="profesion">
<?php
$profesion=$dbh->prepare("select *from profesion order by nombre");
$profesion->execute();
foreach($profesion->fetchAll() as $reg){
	echo "<option value=".$reg[0].">".$reg[1]."</option>";
	}
?>
</select></td></tr></div>
<div><tr><td><label>Cédula de identidad</label></td><td><input type="text" id="ci" class="ci" name="ci" placeholder="4899335"></td><div id="Info"></div><td><label>Cargo:</label></td><td><select name="cargo" id="cargo" class="cargo">
<?php 
$selectCargo=$dbh->prepare("select * from cargo order by nombre");
$selectCargo->execute();
foreach($selectCargo->fetchAll() as $fila){
echo "<option value=".$fila[0].">".$fila[1]."</option>";
}
?>
</select></td></tr></div>
<div><tr><td><label>Teléfonos</label></td><td><input type="text" id="tel" class="tel" name="tel" placeholder="24478553-72044343"></td><td><label>Departamento:</label></td><td><select name="depto" id="depto" class="depto">
<?php 
$selectDepto=$dbh->prepare("select *from departamento order by nombre");
$selectDepto->execute();
foreach($selectDepto->fetchAll() as $row){
echo "<option value=$row[0]>".$row[1]."</option>";
}
?>
</select></td></tr></div>
<div><tr><td><label>Dirección</label></td><td><input type="text" id="dir" class="dir" name="dir" placeholder="Miraflores"></td><td><label>Haber básico en Bs:</label></td><td><input type="text" name="salario" class="salario" id="salario" placeholder="3000:00" ></td></tr></div>  
  <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <div><tr><td><label>Fecha de nacimiento:</label></td><td><input type="text" id="Datepicker1"  class="fecn" name="fecn" contenteditable="false" placeholder="2014-09-12"></td></tr></div>
  <tr><td><button id="button" class="boton_envio">REGISTRAR</button></td><td><input type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div>
 </table>
   </form>
   </fieldset>
         <script type="text/javascript" src="../js/nuevoempleado.js"></script>
        <?php
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
	

<script type="text/javascript">
$(function() {
	$( "#Datepicker1" ).datepicker(); 
	$( "#Datepicker1" ).datepicker('option',{dateFormat:'yy-mm-dd'});
	$("#Datepicker2").datepicker();
	$("#Datepicker2").datepicker('option',{dateFormat:'yy-mm-dd'});
});
</script>
</body>
</html>
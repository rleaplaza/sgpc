<?php session_start();//función de inicio de sesión?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro de maqteriales</title>
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
    <link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
    <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
    <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
$(document).ready(function() {	
	$('#desc').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var desc = $(this).val();	
		var dataString = 'desc='+desc;
		
		$.ajax({
            type: "POST",
            url: "consultas/descMaterial.php",
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
<img src="../images/materiales.jpg" height="50" width="50"/><br>
<?php 
if(isset($_SESSION["username"])){
	try{
	require_once("registros/regAuditoria.php");
	require_once("consultas/mensajeAyuda.php");
	require_once("../db/connect.php");
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
		$mensaje=consultaMensaje($_GET["idopcion"]);
		}
		else{
			header("location: ../index.php");
			}
	?>
<label>Ayuda del sistema</label>
<img src="../images/ayuda.jpg" height="30" width="30" title="<?php echo $mensaje;?>"/><br>
<fieldset>
     <legend>Formulario de registro</legend>
     <form method="post" class="usuario" id="formulario" name="form" >
     <table>
     <div><tr><td><label>Proveedor</label></td><td><select id="idproveedor" name="idproveedor" class="idproveedor">
     <?php
     $sql=$dbh->prepare("select *from proveedor");
	 $sql->execute();
	 if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $row){
			echo "<option value=".$row["IDproveedor"].">".$row["empProveedora"];
			}
		 }
	 ?>
     
     </select></td></tr></div>
<div><tr><td><label>Descripción</label></td><td><textarea name="desc" class="desc" id="desc" rows="2" cols="15"></textarea></td><div id="Info"></div></tr></div>
<div><tr><td><label>Unidad de medida:</label></td><td><select name="unidad" id="unidad" class="unidad">
<option value="KG">KG
<option value="PZA">PZA
<option value="M3">M3
<option value="LT">LT
<option value="MI">MI</select></td></tr></div>
<div><tr><td><label>Precio unitario elemental en Bs:</label></td><td><input name="precio" type="text" required class="precio" id="precio"></td></div>
<div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td align="left"><button class="boton_envio" >REGISTRAR</button></td><td><input type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div>
 </table>
   </form>
</fieldset>
<script type="text/javascript" src="../js/formMaterial.js"></script>
        <?php
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
<?php session_start();//función de inicio de sesión?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro de maquinaria</title>
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
    <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
$(document).ready(function() {	
//programa que llama a la consulta de disponibilidad de registro de equipamiento
	$('#desc').blur(function(){//captura la descripción del equipamiento
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);//imagen de carga para enviar a la url

		var desc = $(this).val();		//almacena el valor del campo descripción
		var dataString = 'desc='+desc;//almacena al campo descripción
		
		$.ajax({
            type: "POST",
            url: "consultas/descMaquinaria.php",//url destino
            data: dataString,//captura el campo descripción
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
<img src="../images/maquinaria1.jpg" height="50" width="50"/><br>
<?php 
if(isset($_SESSION["username"])){//verifica si existe la sesión
	try{
	require_once("registros/regAuditoria.php");//archivo log de auditoría
	require_once("consultas/mensajeAyuda.php");//archivo mensaje de ayuda
	require_once("../db/connect.php");//llamada a la conexión a base de datos
	#consulta del programa donde se está navegando
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al id de opción
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
		$mensaje=consultaMensaje($_GET["idopcion"]);//variable mensaje
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función log de auditoría
		}
		else{
			header("location: ../index.php");
			}
	?>
<label>Ayuda del sistema</label>
<img src="../images/ayuda.jpg" height="30" width="30" title="<?php echo $mensaje;//muestra el mensaje de ayuda?>"/><br>
<fieldset>
     <legend>Formulario de registro</legend>
     <form method="post" class="usuario" id="formulario" name="form" >
     <table>
     <div><tr><td><label>Proveedor</label></td><td><select name="idproveedor" class="idproveedor">
     <?php
     $sql=$dbh->prepare("select *from proveedor");//consulta del proveedor
	 $sql->execute();
	 if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $row){//el arreglo desplegará el listado con todos los proveedores
			echo "<option value=".$row["IDproveedor"].">".$row["empProveedora"];
			}
		 }
	 ?>
     
     </select></td>
      
     <td><label>Modelo:</label></td><td><input type="text" id="modelo" name="modelo" class="modelo" style="text-transform:uppercase;"></td></tr></div>
<div><tr><td><label>Descripción</label></td><td><textarea name="desc" class="desc" id="desc" rows="2" cols="15" style="text-transform:uppercase;"></textarea></td><div id="Info"></div><td><label>Nro de placa:</label></td><td><input type="text" id="placa" name="placa" class="placa"></td></tr></div>
<div><tr><td><label>Unidad de medida:</label></td><td><input type="text" id="unidad" name="unidad" class="unidad" maxlength="110" placeholder="Ej. HM" style="text-transform:uppercase;"></td><td><label>Potencia:</label></td><td><input type="text" id="potencia" name="potencia" class="potencia" placeholder="Ej. 5 HP"></td></tr></div>
<div><tr><td><label>Marca:</label></td><td><input type="text" id="marca" name="marca" class="marca" maxlength="110" style="text-transform:uppercase;"></td><td><label>Precio unitario elemental en Bs:</label></td><td><input name="precio" type="text" required class="precio" id="precio" placeholder="Ej. 55.00"></td></div>
<div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td align="left"><button class="boton_envio" >REGISTRAR</button></td><td><input type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div>
 </table>
   </form>
</fieldset>
<script type="text/javascript" src="../js/formMaquinaria.js"></script>
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
<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario registro de planificación de compras</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
 <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addPlanCompra.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
					        IDproyecto:document.id('idproyecto').value || 'Proyecto no encontrado',
						    Desc:document.id('desc').value || 'Descripción no almacenada',
							Item:document.id('item').value || 'Item no almacenado',
							Cantidad:document.id('cantidad').value || 'Cantidad no alamcenada',
							Fec1:document.id('fec1').value || 'Fecha de inicio no almacenada',
						},
						method: 'post'
					},
					title: 'Registro de parámetros'
				}).open();
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
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
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		require_once("consultas/mensajeAyuda.php");
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
        <img src="../images/cotizador.jpg" height="40" width="40"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php
    $desc=$_GET["desc"];
	$cantidad=$_GET["cantidad"];
	?>
<fieldset>
    <legend>FORMULARIO DE PLANIFICACIÓN DE COMPRAS</legend>
    <form method="post" class="usuario" id="form" name="formPlan">
    <table align="left">
    <div><tr><td><label>Proyecto</label></td><td><select name="proyecto" id="idproyecto" class="proyecto">
    <?php
    $sql=$dbh->prepare("select IDproyecto, nombre from proyecto");
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $row){
			?>
          <option value="<?php echo $row[0];?>"><?php echo $row[1];?>
            <?php
			}
		}
	?>
    </select></td></div>
    <div><tr><td><label>Descripción</label></td><td><textarea name="desc" id="desc" class="desc" rows="6" cols="30"></textarea></td></tr></div>
    <div><tr><td><label>Item</label></td><td><input type="text" name="item" id="item" class="item" value="<?php echo $desc;?>" readonly></td></tr></div>
  <div><tr><td><label>Cantidad</label></td><td><input type="text" name="cantidad" id="cantidad" class="cantidad" value="<?php echo $cantidad;?>" readonly></td></tr></div>
    <div><tr><td><label>Fecha de inicio</label></td><td><input type="text" id="fec1"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
<script type="text/javascript">
$(document).ready(function() {
	$( "#fec1" ).datepicker(); 
	$( "#fec1" ).datepicker('option',{dateFormat:'yy-mm-dd'});
	$( "#fec2" ).datepicker(); 
	$( "#fec2" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
    </script>
</body>
</html>
<?php session_start();?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de solicitud de mano de obra</title>
<style>
  label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
   legend{font:Verdana, Geneva, sans-serif;
	      color:#009;
	      size:auto;
		}
 
	
	</style>
    <link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
  <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addSolicitudM.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							codproyecto: document.id('idproyecto').value || 'ID de proyecto no agregado',
						    cedula:document.id('ci').value || 'Cédula no agregada',
							Cmanoobra:document.id('cargo').value || 'cargo no ingresado',
							Cant:document.id('cantidad').value || 'cantidad no agregada'
						},
						method: 'post'
					},
					title: 'Registro de solicitud de mano de obra'
				}).open();
				limpiar();
				
			});
			
		});    
		function limpiar(){
			document.getElementById("cantidad").value="";
						}
</script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaSolicitud.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							codproyecto: document.id('idproyecto').value || 'ID de proyecto no agregado',
						},
						method: 'post'
					},
					title: 'Consultar solicitud por proyecto'
				}).open();
				
			});
			
		});    
</script>
</head>
<body>
<img src="../images/cargoManoobra.jpg" height="50" width="50"/><br>
<?php 
if(isset($_SESSION["username"])){
	try{
    require_once("../db/connect.php");//conexión a la base de datos
	require_once("registros/regAuditoria.php");//archivo log de auditoría
	require_once("consultas/mensajeAyuda.php");//archivo para despliegue de mensajes de ayuda
	$mensaje=consultaMensaje($_GET["idopcion"]);//envía la opción para capturar el mensaje
	#consulta para el programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al ID de opción
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
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función para registrar el log de auditoría
		}
	}
	else{
		header("location: ../index.php");//dirige al usuario al login en caso de no existe la opción
		}
?>
     <label>Ayuda del sistema</label>
<img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>"/><br>
<fieldset>
     <legend>Formulario de solicitud de mano de obra</legend>
     <form method="post" class="usuario" id="formulario" name="form" >
     <table>
<div><tr><td><label>Seleccionar proyecto</label></td><td><select name="idproyecto" class="idproyecto" id="idproyecto">
<?php
$profesion=$dbh->prepare("select *from proyecto order by nombre");//consulta para el proyecto
$profesion->execute();
foreach($profesion->fetchAll() as $reg){//devuelve el arreglo con el registro del proyecto
	echo "<option value=".$reg["IDproyecto"].">".$reg["nombre"]."</option>";
	}
?>
</select></td></tr></div>
<?php $ci=$dbh->prepare("SELECT u.CI FROM usuario AS u, empleado AS e
                                WHERE e.CI = u.CI
                                AND u.username = ?");//consulta para recuperar la cédula del contratista
	$ci->bindParam(1,$_SESSION["username"]);//enlaza al nombre de usuario
	$ci->execute();//ejecuta la instrucción
	$fila=$ci->fetch();//devuelve el resultado
?>
<div><tr><td><label>Cédula de identidad del solicitante:</label></td><td><input type="text" id="ci" nombre="ci" class="ci" value="<?php echo $fila[0];?>" disabled="disabled"></td></tr></div>
<div><tr><td><label>Cargo de mano de obra solicitado:</label></td><td><select name="cargo" id="cargo" class="cargo">
<?php 
$selectCargo=$dbh->prepare("select * from cargomanodeobra order by nombre");
$selectCargo->execute();
foreach($selectCargo->fetchAll() as $fila){
echo "<option value=".$fila[0].">".$fila[1]."</option>";
}
?>
</select></td></tr></div>
<div><tr><td><label>Cantidad solicitada:</label></td><td><input name="cantidad" type="text" required class="cantidad" id="cantidad" maxlength="3" placeholder="100"><img src="../images/ayuda.jpg" height="30" width="30" title="Ingrese un número, ej, 2"></td></tr></div>
  <tr><td align="left"><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input type="reset" value="VACIAR FORMULARIO"><input class="boton_envio" type="button" id="sub1" value="CONSULTAR SOLICITUD"></td></tr>
 </div>
 </table>
   </form>
   </fieldset>
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
</body>
</html>
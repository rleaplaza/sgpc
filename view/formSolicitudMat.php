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
  #button{
	font-wight:bold;
	cursor:pointer;
	padding:5px;
	color:#093;
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
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					draggable:true,
					url: 'registros/addSolicitudMat.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							codproyecto: document.id('idproyecto').value || 'ID de proyecto no agregado',
						    cedula:document.id('ci').value || 'Cédula no agregada',
							Material:document.id('material').value || 'cargo no ingresado',
							Cant:document.id('cantidad').value || 'cantidad no agregada'
						},
						method: 'post'
					},
					title: 'Registro de solicitud de mano de obra'
				}).open();
				
			});
			
		});    
</script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaSolMat.php',
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
<img src="../images/materiales.jpg" height="50" width="50"/><br>
<input type="submit" value="Volver al formulario principal" onClick="history.back();" id="button"><br>
<?php 
if(isset($_SESSION["username"])){
	require_once("registros/regAuditoria.php");
	require_once("consultas/mensajeAyuda.php");
	?>
<label>Ayuda del sistema</label>
<img src="../images/ayuda.jpg" height="30" width="30" title="Depliegue el dropdown referente al material a solicitar y agregue la cantidad en el campo correspondiente para consultar su solicitud presione el botón del formulario, esta solicitud se realiza por proyecto"/><br>
<?php
try{
require_once("../db/connect.php");
$proy=$_POST["proyecto"];
$sql=$dbh->prepare("select *from proyecto where IDproyecto=?");
$sql->bindParam(1,$proy);
$sql->execute();
$res=$sql->fetch();
	?>
     
<fieldset>
     <legend>Formulario de solicitud de materiales de trabajo</legend>
     <form method="post" class="usuario" id="formulario" name="form" >
     <table>
<div><tr><td><label>Proyecto</label></td><td><textarea name="proyecto" class="proyecto" rows="6" cols="30" disabled="disabled"><?php echo $res["nombre"];?></textarea></td></tr></div>
<input type="hidden" name="idproyecto" id="idproyecto" value="<?php echo $res["IDproyecto"];?>">
<?php $ci=$dbh->prepare("SELECT pt.CI FROM personaltecnico AS pt, usuario AS u, empleado AS e
                                WHERE pt.IDempleado = e.IDempleado
                                AND e.CI = u.CI
                                AND username = ?");
	$ci->bindParam(1,$_SESSION["username"]);
	$ci->execute();
	$fila=$ci->fetch();
?>
<div><tr><td><label>Cédula de identidad del solicitante:</label></td><td><input type="text" id="ci" nombre="ci" class="ci" value="<?php echo $fila[0];?>" disabled="disabled"></td></tr></div>
<div><tr><td><label>Material a solicitar:</label></td><td><select name="material" id="material" class="material">
<?php 
$selectCargo=$dbh->prepare("select * from material where cant_disponible>0 order by descripcion");
$selectCargo->execute();
foreach($selectCargo->fetchAll() as $fila){
echo "<option value=".$fila[0].">".$fila[2]."</option>";
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
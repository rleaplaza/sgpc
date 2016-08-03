<?php session_start();?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro de subfases</title>
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
    <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
    <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/fechaCastellano.js"></script>
    <script type="text/javascript" src="../js/poblarSubfase.js"></script>

    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
    <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
    <script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
    <script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
    <script type="text/javascript">
	window.addEvent('domready',function(){//función para iniciar el evento DOM para la ventana modal
			
			document.id('sub').addEvent('click',function(){//evento click para abrir la ventana
				
				ajaxFace = new LightFace.Request({//instancia a la clase lightface
					url: 'registros/addActividad.php',//url de envío para registrar los datos
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //datos capturados del formulario en base al ID del campo y valor correspondiente
						IDfase:document.id('fase').value || 'Fase no almacenada',
						IDsubfase:document.id('subfase').value || 'subfase no almacenada',
						IDpersonalTecnico:document.id('idpersonaltecnico').value || 'ID no almacenado',
						IDplan:document.id('idplan').value || 'ID de plan no almacenado',
						IDproy:document.id('idproy').value || 'ID de proyecto no almacenado',
						Actividad:document.id('actividad').value || 'Actividad no almacenada',
						Unidad:document.id('unidad').value || 'Unidad no almacenada',
						Cantidad:document.id('cantidad').value || 'Cantidad no almacenada',
						Fec1:document.id('fec1').value || 'Fecha de inicio no almacenada',
						Fec2:document.id('fec2').value || 'Fecha de fin no almacenada',
						CostoProg:document.id('costo').value || 'Costo no almacenado' ,
						IDcostofijo:document.id('costofijo').value || 'Costo Fijo no almacenado'
						},
						method: 'post'//método post
					},
					title: 'Registro de actividades'//titulo de la ventana
				}).open();//abre la ventana
				limpiar();
			});
			
		});
		function limpiar() {//limpiado del formulario
document.getElementById("actividad").value="";
document.getElementById("fec1").value="";
document.getElementById("fec2").value="";
document.getElementById("unidad").value="";
document.getElementById("costo").value="";
document.getElementById("cantidad").value="";
}    
</script>
</head>
<body>
<img src="../images/gant.jpg" height="30" width="30"/><br>
<?php 
#Este programa se encarga de mostrar el formulario de registro de actividades correspondientes a un proyecto
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");//llama al log de auditoría
	$idproy=$_POST["proyecto"];
	#consulta del responsable del proyecto
	$consulta=$dbh->prepare("SELECT nombres, app, apm,IDpersonalTecnico
                             FROM personaltecnico AS pt, proyecto AS p, empleado AS e, usuario AS u
                             WHERE u.CI = e.CI
                             AND e.IDempleado = pt.IDempleado
                             AND pt.IDproyecto = p.IDproyecto
                             AND u.username =?
							 and p.IDproyecto=?");
	$consulta->bindParam(1,$_SESSION["username"]);//enlaza el nombre de usuario
	$consulta->bindParam(2,$idproy);//enlaza al ID del proyecto
	$consulta->execute();
	$res=$consulta->fetch();//devuelve el resultado en un arreglo
	$nombre=$res[0]." ".$res[1]." ".$res[2];//las variables del arreglo se concatenan formando el nombre completo
	$idpersonaltecnico=$res[3];//captura el identificador del participante
	#consulta la planificación en base al ID del proyecto
	$query=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=? and fecFin is NULL");
	$query->bindParam(1,$idproy);
	$query->execute();
	$result=$query->fetch();
	$idplan=$result[0];//almacena el índica del arreglo
	?>
<input type="submit" value='Volver al formulario principal' onClick='history.back();' id="button"><br>
<label>Ayuda del sistema</label>
<img src="../images/ayuda.jpg" height="30" width="30" title="Llenar el formulario con la correspodiente información de la subfase y la descripción"/><br>
 
<?php
try{//genera una excepción
#llama al archivo global de conexión

	?> 
<fieldset>
     <legend>Formulario de registro de actividades</legend><label></label>
     <form method="post" class="usuario" id="formulario" name="form">
     <table>
     <tr><td><label>Costo fijo a utilizar</label></td><td><select id="costofijo" class="costofijo">
     <?php
     $consulta=$dbh->prepare("select *from costofijo order by descripcion");
	 $consulta->execute();
	 foreach($consulta->fetchall() as $fila){
		 ?>
         <option value="<?php echo $fila[0];?>"><?php echo $fila[1].", valor: ". $fila[2]." BS";?>
         <?php
		 }
	 ?>
     </select></td></tr>
     <tr><td><label>Fase</label></td><td><select id="fase" class="fase" onChange="Subfase(this.value)">
         <?php
         $sql=$dbh->prepare("select IDfase, nombre, concat(fecRegistro,' ',hraRegistro) as fecha from fase where IDproyecto=? order by fecha asc");
		 $sql->bindParam(1,$idproy);
		 $sql->execute();
		 if($sql->rowCount()>0){
			 foreach($sql->fetchAll() as $row){
				 ?>
                 <option value="<?php echo $row["IDfase"];?>"><?php echo $row["nombre"];?>
                 <?php
				 }
			 }
		 ?>
     </select></td></tr>
   
    <tr><td><label>Subfase</label></td><td>
        <div id="idsubfase">
     <select name="subfase" id="subfase">
     
     </select></div></td><td><label>Cantidad programada:</label></td><td><input type="text" id="cantidad" name="cantidad" class="cantidad" maxlength="10" placeholder="8.4"></td></tr>
     <tr><td><label>Responsable</label></td><td><input type="text" name="contratista" class="contratista" value="<?php echo $nombre;?>" readonly></td><td><label>Fecha de inicio:</label></td><td><input type="text" id="fec1" name="fecInicio" class="fecInicio" placeholder="2014-04-23"></td></tr>
     <input type="hidden" name="idplan" value="<?php echo $idplan;?>" id="idplan">
     <input type="hidden" name="idplan" value="<?php echo $idproy;?>" id="idproy">
     <input type="hidden" name="idpersonaltecnico" class="idpersonaltecnico" value="<?php echo $idpersonaltecnico;?>" id="idpersonaltecnico">
<tr><td><label>Nombre de actividad</label></td><td><textarea name="actividad" class="actividad" rows="2" cols="15" id="actividad"></textarea></td><td><label>Fecha de finalización:</label></td><td><input type="text" id="fec2" name="fecFin" class="fecFin" placeholder="2014-04-23"></td></tr>
<tr><td><label>Unidad de medida:</label></td><td><select id="unidad" class="unidad">
<option value="km">km
<option value="m3">m3
<option value="m3-km">m3-km
<option value="pza">pza
<option value="ml">ml</select></td><td><label>Costo programado Bs:</label></td><td><input type="text" id="costo" name="costo" class="costo" maxlength="10"></td></tr>
<tr></tr>
  <tr><td align="left"><input type="button" value="REGISTRAR" id="sub" class="boton_envio"></td><td><input type="reset" value="VACIAR FORMULARIO"></td></tr>
 </table>
   </form>
</fieldset>
        <?php
	 }catch(PDOException $e){//genera una excepción en caso de errores inesperados
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
	//función datepicker
	$( "#fec1" ).datepicker(); 
	$( "#fec1" ).datepicker('option',{dateFormat:'yy-mm-dd'});//establece el formato de fecha yyyy-mm-dd
	$( "#fec2" ).datepicker();
	$( "#fec2" ).datepicker('option',{dateFormat:'yy-mm-dd'}); 
});
</script>
</body>
</html>
<?php session_start();//función de inicio de sesión?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
          <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){//captura el id del botón
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addAvanceTr.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //captura de los datos del formulario
						    IDactividad:document.id('idactividad').value || 'nombre no agregado',
							CI:document.id('ci').value || 'Cédula no almacenada',
							Horas:document.id('totaltrabajado').value || 'total no ingresado',
							UnidadAvance:document.id('unidad').value || 'Dato no almacenado',
							TotalAvance:document.id('total').value || 'Total avance no almacenado',
							UnidadTrabajo:document.id('unidadTrabajo').value || 'Unidad no almacenada',
							CantProg:document.id('cantidad').value || 'Cantidad no almacenada',
							Desc:document.id('desc').value || 'Descripción no almacenada'
						},
						method: 'post'
					},
					title: 'Registro de avances'//título de la ventana
				}).open();
				limpiar();
				
			});
			
		});    
		function limpiar(){
			document.getElementById("desc").value="";
			document.getElementById("total").value="";
			}
</script>
<script>
function cerrar(){
	ventana=window.close(); //función para cerrar la ventana
	}
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	require_once("registros/convierteHora.php");
	if(isset($_GET["idactividad"])){
	$idactividad=$_GET["idactividad"];
	$ci=$_GET["ci"];
	$nombre=$_GET["nombre"];
	//captura de la unidad de trabajo del trabajador
	$sql=$dbh->prepare("select *from actividad_trabajador where IDactividad=? and CI_trabajador=?");
	$sql->bindParam(1,$idactividad);
	$sql->bindParam(2,$ci);
	$sql->execute();
	$res=$sql->fetch();
	$unidadTrabajo=$res[4];
	//captura del nombre de actividad y la unidad de avance programado
	$consulta=$dbh->prepare("select nombreActividad, unidades,cantidad,total_avance from actividad where IDactividad=?");
	$consulta->bindParam(1,$idactividad);
	$consulta->execute();
	$result=$consulta->fetch();
	$actividad=$result[0];
	$unidad=$result[1];
	$cantidad=$result[2];
	$avance=$result[3];
	$avanceFaltante=$cantidad-$avance;
	$query=$dbh->prepare("SELECT duracion
                          FROM calendario_trabajador AS c, personalmanoobra AS p
                          WHERE c.CI_trabajador = p.CI_trabajador
						  and p.CI_trabajador=?");
	$query->bindParam(1,$ci);
	$query->execute();
	$fila=$query->fetch();
	$horas=round(convierteHora($fila[0]),2);
	?>
    <img src="../images/tareas.jpg" height="40" width="40"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Llenar el formulario correspondiente, los valores referentes a totales son numéricos, ej 14.60">
    <fieldset>
    <legend>FORMULARIO DE CONTROL DE AVANCE DE ACTIVIDADES</legend>
    <label>Fecha: </label><?php
	$time=$dbh->prepare("select curtime()");
	$time->execute();
	$reg=$time->fetch();
	$hora=$reg[0];
    date_default_timezone_set('UTC');
	echo date("Y-m-d");
	echo " ".$hora;
	?>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Actividad</label></td><td><input type="text"  class="actividad" id="actividad" value="<?php echo $actividad;?>" readonly></td></tr></div>
    <input type="hidden" id="idactividad" value="<?php echo $idactividad;?>">
    <input type="hidden"  class="ci" id="ci" value="<?php echo $ci;?>">
    <input type="hidden" class="unidad" id="unidad" value="<?php echo $unidad;?>">
    <input type="hidden" class="totaltrabajado" id="totaltrabajado" value="<?php echo $horas;?>">
    <input type="hidden" class="unidadTrabajo" id="unidadTrabajo" value="<?php echo $unidadTrabajo;?>">
    <input type="hidden" class="cantidad" id="cantidad" value="<?php echo $cantidad;?>">
     <div><tr><td><label>Nombre</label></td><td><input type="text"  class="nombre" id="nombre" value="<?php echo $nombre;?>" readonly></td></tr></div>
     <div><tr><td><label>Descripción</label></td><td><textarea id="desc" class="desc" cols="30" rows="6"></textarea></td></tr></div>
    <input type="hidden" id="horas" class="horas" value="<?php echo $horas." ".$unidadTrabajo;?>">
    <div><tr><td><label>Cantidad por completar</label></td><td><input type="text" id="cant" class="cant" value="<?php echo $avanceFaltante." ".$unidad;?>" readonly></td></tr></div>
    <div><tr><td><label>Avance informado</label></td><td><input type="text" id="total" class="total" maxlength="6" <?php if($avanceFaltante==0){?>disabled<?php }?> ><?php echo $unidad;?></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR" <?php if($avanceFaltante==0){?> disabled <?php } ?> ></td><td><input class="reset" type="reset" value="CERRAR VENTANA" onClick="cerrar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
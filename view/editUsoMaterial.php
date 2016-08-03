<?php session_start();//función de inicio de sesion
#Este programa despliega el formulario de registro de consumo de material?>
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
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({//instancia a la clase lightfase
					url: 'registros/addAvanceMat.php',//url destino
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //captura de los datos del formulario
						    IDactividad:document.id('idactividad').value || 'nombre no agregado',
							IDmaterial:document.id('idmaterial').value || 'Cédula no almacenada',
							CantidadAsignada:document.id('cantidad').value || 'cantidad no almacenada',
							CantidadUsada:document.id('cant').value || 'Dato no almacenado'
						},
						method: 'post'
					},
					title: 'Registro de avances'
				}).open();
				limpiar();
				
			});
			
		});    
		function limpiar(){
			document.getElementById("cant").value="";
			}
</script>
<script>
function cerrar(){
	ventana=window.close(); 
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
    $idmaterial=$_GET["idmaterial"];
	//captura de la unidad de trabajo del trabajador
	$sql=$dbh->prepare("select *from actividad_material where IDactividad=? and IDmaterial=?");
	$sql->bindParam(1,$idactividad);
	$sql->bindParam(2,$idmaterial);
	$sql->execute();
	$res=$sql->fetch();
	$unidadMedida=$res[3];
	$cantidadasignada=$res[5];
	$cantidad_usada=$res[6];
	$cantidad_faltante=$cantidadasignada-$cantidad_usada;
	//captura del nombre de actividad y la unidad de avance programado
	$consulta=$dbh->prepare("select nombreActividad, unidades,cantidad from actividad where IDactividad=?");
	$consulta->bindParam(1,$idactividad);
	$consulta->execute();
	$result=$consulta->fetch();
	$actividad=$result[0];
	$unidad=$result[1];
	$cantidad=$result[2];
	#consulta del material
	$query=$dbh->prepare("select descripcion,unidad from material where IDmaterial=?");
	$query->bindParam(1,$idmaterial);
	$query->execute();
	$row=$query->fetch();
	$material=$row[0];
	$unidad=$row[1];
	
	?>
    <img src="../images/tareas.jpg" height="40" width="40"><img src="../images/materiales.jpg" height="40" width="40"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Llenar el formulario correspondiente, ingrese la cantidad usada real durante la actividad">
    <fieldset>
    <legend>FORMULARIO DE USO DE MATERIALES</legend>
    <label>Fecha: </label><?php
	$time=$dbh->prepare("select curtime()");//consulta de la hora actual
	$time->execute();//ejecuta la instrucción
	$reg=$time->fetch();//devuelve el resultado en un arreglo
	$hora=$reg[0];
    date_default_timezone_set('UTC');
	echo date("Y-m-d");
	echo " ".$hora;
	?>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Actividad</label></td><td><input type="text"  class="actividad" id="actividad" value="<?php echo $actividad;?>" readonly></td></tr></div>
    <input type="hidden" id="idactividad" value="<?php echo $idactividad;?>">
    <input type="hidden"  class="idmaterial" id="idmaterial" value="<?php echo $idmaterial;?>">
    <input type="hidden"  class="cantidad" id="cantidad" value="<?php echo $cantidadasignada;?>">
    <input type="hidden" class="unidad" id="unidad" value="<?php echo $unidad;?>">
    <input type="hidden" class="unidadTrabajo" id="unidadTrabajo" value="<?php echo $unidadMedida;?>">
     <div><tr><td><label>Material</label></td><td><input type="text"  class="idmaterial" id="material" value="<?php echo $material;?>" readonly></td></tr></div>
    <div><tr><td><label>Cantidad disponible</label></td><td><input type="text" id="horas" class="horas" value="<?php echo $cantidad_faltante." ".$unidad;?>" readonly></td></tr></div>
    <div><tr><td><label>Cantidad utilizada</label></td><td><input type="text" id="cant" class="cant" maxlength="5"><?php echo $unidad;?></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="CERRAR VENTANA" onClick="cerrar()"></td></tr>
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
<?php session_start();//función de inicio de sesión
#Este programa despliega al formulario de registro de avances por maquinaria?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de edición de avances por maquinaria</title>
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
			
			document.id('sub').addEvent('click',function(){ //llama al evento de la ventana
				
				ajaxFace = new LightFace.Request({//instancia a la clase
					url: 'registros/addAvanceMaq.php',//define la UR para enviar al programa php
					buttons: [ //Creación del botón de cerrado
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						//captura de varibales del formulario para enviarlos al archivo php de la URL
						    IDactividad:document.id('idactividad').value || 'nombre no agregado',
							IDmaquinaria:document.id('idmaquinaria').value || 'Cédula no almacenada',
							TotalAvance:document.id('total').value || 'Total avance no almacenado',
							Unidad:document.id('unidad').value || 'Unidad no almacenada'
						},
						method: 'post'
					},
					title: 'Registro de avances'//Cabecera de la ventana
				}).open();//abre la ventana
				
			});
			
		});    
</script>
<script>
function cerrar(){
	ventana=window.close(); //función para cerrar la ventana js del formulario
	}
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de nombre de usuario
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/convierteHora.php");//función para convertir el formato de hora a decimal
	if(isset($_GET["idactividad"])){
	$idactividad=$_GET["idactividad"];
	$idmaquinaria=$_GET["idmaquinaria"];
	$desc=$_GET["descripcion"];
	//captura de la unidad de trabajo del trabajador
	$sql=$dbh->prepare("select *from actividad_maquinaria where IDactividad=? and IDmaquinaria=?");
	$sql->bindParam(1,$idactividad);
	$sql->bindParam(2,$idmaquinaria);
	$sql->execute();
	$res=$sql->fetch();
	$unidadTrabajo=$res[4];
	//captura del nombre de actividad y la unidad de avance programado
	$consulta=$dbh->prepare("select nombreActividad, unidades,cantidad from actividad where IDactividad=?");
	$consulta->bindParam(1,$idactividad);
	$consulta->execute();
	$result=$consulta->fetch();
	$actividad=$result[0];
	$unidad=$result[1];
	$cantidad=$result[2];
	?>
    <img src="../images/tareas.jpg" height="40" width="40">
    <img src="../images/maquinaria1.jpg" height="40" width="40">
    <br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Llenar el formulario correspondiente, los valores referentes a totales son numéricos, ej 14.60">
    <fieldset>
    <legend>FORMULARIO DE CONTROL DE AVANCE DE ACTIVIDADES</legend>
    <label>Fecha: </label><?php
	$time=$dbh->prepare("select curtime()");//selecciona la hora actual
	$time->execute();
	$reg=$time->fetch();//devuelve el resutado en un arreglo
	$hora=$reg[0];
    date_default_timezone_set('UTC');
	echo date("Y-m-d");//imprime la fecha
	echo " ".$hora;//imprime la hora
	?>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Actividad</label></td><td><input type="text"  class="actividad" id="actividad" value="<?php echo $actividad;?>" readonly></td></tr></div>
    <input type="hidden" id="idactividad" value="<?php echo $idactividad;?>">
    <input type="hidden"  class="idmaquinaria" id="idmaquinaria" value="<?php echo $idmaquinaria;?>">
     <div><tr><td><label>Cantidad asignada</label></td><td><input type="text"  class="nombre" id="nombre" value="<?php echo $desc;?>" readonly></td></tr></div>
    <div><tr><td><label>Unidad de trabajo</label></td><td><input type="text" id="unidad" class="unidad" value="<?php echo $unidadTrabajo;?>" readonly></td></tr></div>
    <div><tr><td><label>Avance informado</label></td><td><input type="text" id="total" class="total" maxlength="6"></td></tr></div>
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
<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Asignación de actividad a cargo</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
       <script type="text/javascript" src="../js/jquery.min.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
       <script type="text/javascript" src="../js/poblarTrabajador.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
       <script type="text/javascript">
	   $(document).ready(function(){
		   $("#evaluar").change(function(){
			   var evaluacion=$("#evaluar").val();
			   if(evaluacion=='aprobado'){
				   $("#motivo").fadeOut('slow');
				   $("#motivo").removeAttr('required');
				   console.log(evaluacion);
			}else if(evaluacion=='rechazado'){
				   $("#motivo").fadeIn('slow');
				   $("#motivo").attr('required');
				   console.log(evaluacion);
				}
			   });
		   });
       </script>
       <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({//instancia a la clase lightface para llamar a los métidos
					url: 'registros/procesar_aprobacion_actividad.php',//url destino para procesar la asignación
					buttons: [//botón de cerrado
						{ title: 'Cerrar', event: function() { 
						  this.close();
						  recargar();
						 },color:'blue' }
					],
					request: { 
						data: { 
						//datos requreidos para la asignación mediante su identificador y contenido
					        IDactividad:document.id('idactividad').value || 'Actividad no almacenada',
						    Evaluar:document.id('evaluar').value || 'Evaluación no encontrada',
							Motivo:document.id('motivo_evaluacion').value || 'Motivo no almacenado'
						},
						method: 'post'
					},
					title: 'Aprobación de actividad'
				}).open();
				
			});
			
		});    
</script>
<script type="text/javascript">
function recargar(){
			var int=self.setInterval("refresh()",5000);
			location.reload(true);
			}
function cerrar(){
var ventana;
ventana=window.close();
}
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//valida la existencia de sesión
	require_once("../db/connect.php");//llama a los archivos de conexión a base de datos y log de auditoría
	require_once("registros/regAuditoria.php");
	#consulta PDO para identificar al programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza el id de la opción
	$consulta->execute();
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();//devuelve el resultado en un arreglo
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		?>
        <img src="../images/tareas.jpg" height="40" width="40"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Llenar el formulario correspondiente, seleccionar al empleado, se desplegará un mensaje de confirmación"><br>
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php
	//Inicia el registro de la actividad
  $idactividad=$_GET["idactividad"];
  $consulta=$dbh->prepare("select IDactividad, nombreActividad, cantidad, total_avance,unidades ,finalizado as estado from actividad where IDactividad=?");
  $consulta->bindParam(1,$idactividad);
  $consulta->execute();
  $result=$consulta->fetch();
  $actividad=$result['nombreActividad'];
  $cantidad=$result['cantidad'];
  $avance=$result['total_avance'];
  $estado=$result['estado'];
  $unidad=$result['unidades'];
  #cambio de estado a ejecución

  //captura el id de plan, proyecto y la fase respectiva

  if($consulta->rowCount()>0){
	?>
<fieldset>
    <legend>FORMULARIO DE ASIGNACIÓN DE ACTIVIDADES</legend>
    <form method="post" class="usuario" id="form" name="formPlan">
    <table align="left">
    <div><tr><td><label>Actividad</label></td><td><input type="text" id="actividad" value="<?php echo $actividad;?>" readonly></td></tr></div>
    <div><tr><td><label>Cantidad programada</label></td><td><input type="text" id="actividad" value="<?php echo $cantidad;?>" readonly></td></tr></div>
    <div><tr><td><label>Avance real</label></td><td><input type="text" id="actividad" value="<?php echo $avance;?>" readonly></td></tr></div>
     <div><tr><td><label>Unidad de trabajo</label></td><td><input type="text" id="unidad" class="unidad" value="<?php echo $unidad;?>" readonly></td></tr></div>
    <div><tr><td><label>Estado</label></td><td><input type="text" id="actividad" value="<?php echo $estado;?>" readonly></td></tr></div>
      <div id="evaluacion"><tr><td><label>Evaluación</label></td><td>
      <select name="evaluar" id="evaluar" required>
        <option value="">Seleccione
        <option value="aprobado">Aprobado
        <option value="rechazado">Rechazado
      </select></td></tr></div>
      <div><tr id="motivo" style="display:none"><td><label>Motivo del rechazo</label></td><td>
      <textarea name="motivo" id="motivo_evaluacion" rows="6" cols="3" ></textarea></td></tr></div>
    <input type="hidden" id="idactividad" value="<?php echo $idactividad;?>">
 
  <tr><td><input type="button" class="boton_envio" id="sub" value="PROCESAR"></td><td><input class="reset" type="reset" value="CERRAR FORMULARIO" onClick="cerrar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
  }else{
	  echo "<label>No se pudo recuperar la información de la actividad</label>";
	  }
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
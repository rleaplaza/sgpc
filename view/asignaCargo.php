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
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
       <script type="text/javascript" src="../js/poblarTrabajador.js"></script>

       <script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
       <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({//instancia a la clase lightface para llamar a los métidos
					url: 'registros/addAsignacioncargo.php',//url destino para procesar la asignación
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
						    CI:document.id('ci').value || 'Trabajador no encontrado',
							IDplan:document.id('idplan').value || 'Plan no almacenado',
							Unidad:document.id('unidad').value || 'Cantidad no alamcenada'
						},
						method: 'post'
					},
					title: 'Asignación de actividad a trabajador'
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
  $actividad=$_GET["actividad"];
  $idactividad=$_GET["idactividad"];
  $consulta=$dbh->prepare("select finalizado from actividad where IDactividad=?");
  $consulta->bindParam(1,$idactividad);
  $consulta->execute();
  $result=$consulta->fetch();
  $estado=$result[0];
  if($estado=="finalizada"){
  echo "<label>La actividad ya está finalizada</label>";
  }else{
  $status="En ejecución";
  #cambio de estado a ejecución
  $update=$dbh->prepare("update actividad set finalizado=? where IDactividad=?");
  $update->bindParam(1,$status);
  $update->bindParam(2,$idactividad);
  $update->execute();
  //captura el id de plan, proyecto y la fase respectiva
  $idplan=$_GET["idplan"];
  $idproyecto=$_GET["idproyecto"];
  $fase=$_GET["fase"];
  $sql=$dbh->prepare("select *from participa where IDproyecto=?");
  $sql->bindParam(1,$idproyecto);
  $sql->execute();
  if($sql->rowCount()>0){
	?>
<fieldset>
    <legend>FORMULARIO DE ASIGNACIÓN DE ACTIVIDADES</legend>
    <form method="post" class="usuario" id="form" name="formPlan">
    <table align="left">
    <div><tr><td><label>Seleccionar cargo</label></td><td><select name="idcargo" id="idcargo" class="id" onChange="trabajador(this.value,'<?php echo $idproyecto;?>')">
    <?php
	#consulta PDO para desplegar a todos los trabajadores participantes en el proyecto
    $sql=$dbh->prepare("SELECT distinct cm.IDcargoM, cm.nombre, cm.unidadTrabajo
                        FROM cargomanodeobra AS cm, solicita AS s, proyecto AS p
                        WHERE cm.IDcargoM = s.IDcargo_M
                        AND s.IDproyecto = p.IDproyecto
						and p.IDproyecto=?
						order by cm.nombre asc");
	$sql->bindParam(1,$idproyecto);//enlaza al id del proyecto
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
    <div><tr><td><label>Trabajador</label></td><td><div id="trabajador">
    <select name="ci" id="ci" required>
    </select>
    </div></td></tr></div>
    <div><tr><td><label>Fase</label></td><td><input type="text" id="fase" value="<?php echo $fase;?>" readonly></td></tr></div>
    <div><tr><td><label>Actividad</label></td><td><input type="text" id="actividad" value="<?php echo $actividad;?>" readonly></td></tr></div>
    <input type="hidden" id="idactividad" value="<?php echo $idactividad;?>">
    <input type="hidden" id="idplan" value="<?php echo $idplan;?>">
  <div><tr><td><label>Unidad de trabajo</label></td><td><input type="text" id="unidad" class="unidad" value="<?php echo $row[2];?>" readonly></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="CERRAR FORMULARIO" onClick="cerrar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
  }else{
	  echo "<label>Debe solicitar trabajadores para asignar actividades</label>";
	  }
  }
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
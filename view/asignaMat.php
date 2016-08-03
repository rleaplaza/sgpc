<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Asignación de actividad a maquinaria</title>
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
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addAsignacionmat.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
					        IDactividad:document.id('idactividad').value || 'Actividad no almacenada',
						    IDmat:document.id('idmat').value || 'Material no encontrado',
							IDplan:document.id('idplan').value || 'Plan no almacenado',
							Unidad:document.id('unidad').value || 'Unidad no alamcenada',
							Cantidad:document.id('cantidad').value || 'Cantidad no almacenada'
						},
						method: 'post'
					},
					title: 'Asignación a la actividad'
				}).open();
			});
		});    
</script>
<script type="text/javascript">
function cerrar(){
ventana=window.close();	//la variable al macena el cierre de la ventana
}
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
  $actividad=$_GET["actividad"];
  $idactividad=$_GET["idactividad"];
  $idplan=$_GET["idplan"];
  $idproyecto=$_GET["idproyecto"];
  $fase=$_GET["fase"];
  $consulta=$dbh->prepare("select unidades, finalizado from actividad where IDactividad=?");
  $consulta->bindParam(1,$idactividad);
  $consulta->execute();
  $result=$consulta->fetch();
  $estado=$result[1];
  $unidadActividad=$result[0];
  if($estado=="finalizada"){
	  echo "<label>La actividad está finalizada</label>";
	  }else{
	?>
<fieldset>
    <legend>FORMULARIO DE ASIGNACIÓN DE ACTIVIDADES</legend>
    <form method="post" class="usuario" id="form" name="formPlan">
    <table align="left">
    <div><tr><td><label>Seleccionar material</label></td><td><select name="idmat" id="idmat" class="idmat">
    <?php
    $sql=$dbh->prepare("SELECT material.IDmaterial, descripcion, unidad, cant_disponible
                        FROM material where cant_disponible>0
						order by descripcion");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $row){
			?>
          <option value="<?php echo $row[0];?>"><?php echo $row[1]. ", unidad ".$row[2]." ,cantidad ".$row[3];?>
            <?php
			}
		}
	?>
    </select></td></div>
    <div><tr><td><label>Fase</label></td><td><input type="text" id="fase" value="<?php echo $fase;?>" readonly></td></tr></div>
    <div><tr><td><label>Actividad</label></td><td><input type="text" id="actividad" value="<?php echo $actividad;?>" readonly></td></tr></div>
    <input type="hidden" id="idactividad" value="<?php echo $idactividad;?>">
    <input type="hidden" id="idplan" value="<?php echo $idplan;?>">
  <div><tr><td><label>Unidad de trabajo</label></td><td><input type="text" id="unidad" class="unidad" value="<?php echo $unidadActividad;?>" readonly></td></tr></div>
   <div><tr><td><label>Cantidad a asignar</label></td><td><input type="text" id="cantidad" class="cantidad" placeholder="5" maxlength="6"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="CERRAR VENTANA" onClick="cerrar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	  }
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
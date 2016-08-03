<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Solicitud de materiales para ser asignados en actividades</title>
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
 <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript"> 
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){//inicia el evento
	        Nombre=document.id('nombre').value;
				ajaxFace = new LightFace.Request({//instancia a la clase lightface
					url: 'registros/addPedidoAlmacen.php',//url destino
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: {
							//Captura de los datos a ser enviados en la URL
							//Nro del pedido
							Nro:document.id('nro').value || 'Nro no almacenado',
							//Datosde pedido
							IDact:document.id('idactividad').value || 'ID de actividad no encontrado',
                            IDemp:document.id('idemp').value || 'ID de empleado no encontrado',
							IDpt:document.id('idpt').value || 'ID de responsable no encontrado',
							Desc:document.id('desc').value || 'Descripcion no almacenadad',
							//Datos del detalle de pedido
							IDmat:document.id('idmaterial').value || 'ID de material no almacenado',
                            Cantidad:document.id('cantidad').value || 'Cantidad no almacenada',
							//reponsable
							Nombre:document.id('nombre').value || 'Nombre no almacenado',
						},
						method: 'post'
					},
					title: 'Solicitud de Materiales a almacén'
				}).open();
				
			});
			
		});    
</script>
<script type="text/javascript">
function cerrar(){
	window.close();
	}
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	#llama a los archivos de conexión a base de datos, log de auditoría, captura de fecha y hora, generación del número del pedido
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	require_once("hora.php");
	require_once("registros/genNumero.php");
	require("generaPedidoAlmacen.php");
	#consulta para mostrar el programa donde se está navegando
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
        <img src="../images/almacen.jpg" height="40" width="40"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Llenar el formulario correspondiente, seleccionar al empleado, se desplegará un mensaje de confirmación"><br>
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php
	#captura de las fechas enviadas desde la función javascript
  $actividad=$_GET["actividad"];
  $idactividad=$_GET["idactividad"];
  $idplan=$_GET["idplan"];
  $idproyecto=$_GET["idproyecto"];
  $fase=$_GET["fase"];
  $idmaterial=$_GET["idmaterial"];
  $fechas=$_GET["fechas"];//duración de la actividad
     $fechaActual=getFecha();//función que captura la fecha actual del sistema
	 #consulta para recuperar el nombre del responsable de las actividades del proyecto
  $query=$dbh->prepare("SELECT IDpersonalTecnico, nombres, app, apm
                        FROM empleado AS e, personaltecnico AS pt, proyecto AS p, usuario AS u
                        WHERE e.CI = u.CI
                        AND e.IDempleado = pt.IDempleado
                        AND pt.IDproyecto = p.IDproyecto
                        AND username = ?
						and p.IDproyecto=?");
 $query->bindParam(1,$_SESSION["username"]);
 $query->bindParam(2,$idproyecto);
 $query->execute();
 if($query->rowCount()>0){
 $res=$query->fetch();
 $idpt=$res[0];
 $nombre=$res[1]." ".$res[2]." ".$res[3];
 $nro=generaNumero();
 generaPedido($nro,$idactividad,$fechas,$idplan);
 }else{
	 $nombre="No está asignado al proyecto";
	 $idpt=null;
	 $nro="Consulte al responsable de la solicitud";
	 }
 #generar el pedido

	?>
    <label>Nro de Pedido </label><?php echo $nro;?><br>
    <label>Fecha </label><?php echo $fechaActual;?>
<fieldset>
    <legend>FORMULARIO DE SOLICITUD DE MATERIALES PARA ACTIVIDAD</legend>
    <form method="post" class="usuario" id="form" name="formPlan">
    <table align="left">
    <div><tr><td><label>Responsable</label></td><td><input type="text" class="nombre" id="resp" value="<?php echo $nombre;?>" readonly required></td></tr></div>
    <input type="hidden" class="nombre" id="nombre" value="<?php echo $nombre;?>">
    <input type="hidden" id="nro" value="<?php echo $nro;?>">
    <div><tr><td><label>Encargado a solicitar</label></td><td><select id="idemp" class="idemp">
    <?php
    $enc=$dbh->prepare("select IDempleado,nombres, app, apm from empleado, cargo
	                    where empleado.IDcargo=cargo.IDcargo
						and cargo.nombre in ('Encargado de almacen','encargado de compras')");
	$enc->execute();
	if($enc->rowCount()>0){
		foreach($enc->fetchall() as $fila){
			?>
        <option value="<?php echo $fila[0];?>"><?php echo $fila[1]." ".$fila[2]." ".$fila[3];?>
            <?php
			}
		}
	?>
    </select></td></tr></div>
    <input type="hidden" id="idpt" value="<?php echo $idpt;?>">
    <div><tr><td><label>Descripción</label></td><td><textarea class="desc" id="desc"></textarea></td></tr></div>
    <div><tr><td><label>Fase</label></td><td><input type="text" id="fase" value="<?php echo $fase;?>" readonly></td></tr></div>
    <div><tr><td><label>Actividad</label></td><td><input type="text" id="actividad" value="<?php echo $actividad;?>" readonly></td></tr></div>
     <div><tr><td><label>Duración</label></td><td><input type="text" id="fechas" value="<?php echo $fechas;?>" readonly></td></tr></div>
    <input type="hidden" id="idactividad" value="<?php echo $idactividad;?>">
    <input type="hidden" id="idplan" value="<?php echo $idplan;?>">
    <div><tr><td><label>Seleccionar material asignado</label></td><td><select class="idmaterial" id="idmaterial">
    <?php 
	#consulta que devolverá los datos del material correspnodiente a la actividad
	$sql=$dbh->prepare("select descripcion, cant_disponible,material.unidad from material, actividad_material 
	                    where material.IDmaterial=actividad_material.IDmaterial
						and material.IDmaterial=?
						and IDactividad=?");
	$sql->bindParam(1,$idmaterial);
	$sql->bindParam(2,$idactividad);
	$sql->execute();
	if($sql->rowCount()>0){
	  foreach($sql->fetchAll() as $row){
	?>
    <option value="<?php echo $idmaterial;?>"><?php echo $row[0].", cantidad ".$row[1]." ".$row[2];?>
    <?php	  
		  }
	}
	?>
    </select></td></tr></div>
   <div><tr><td><label>Cantidad a solicitar</label></td><td><input type="text" id="cantidad" class="cantidad" placeholder="5" maxlength="5"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR" name="boton"></td><td><input type="button" value="CERRAR VENTANA" onclick="cerrar()"></td></tr>
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
$(function() {
	$( "#fec1" ).datepicker(); 
	$( "#fec1" ).datepicker('option',{dateFormat:'yy-mm-dd'});
	$( "#fec2" ).datepicker(); 
	$( "#fec2" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
    </script>
</body>
</html>
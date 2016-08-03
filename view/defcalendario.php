<?php session_start();//función de inicio de sesión
#Este programa de encarga de definir el horario del trabajador participante en el proyecto?>
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
	window.addEvent('domready',function(){//inicia el evento
			
			document.id('sub').addEvent('click',function(){//captura el id del botón
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addcalendario.php',//url destino
					buttons: [//botón de cerrado
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //captura de campos del formulario
						    Nombre:document.id('nombre').value || 'nombre no almacenado',
							Desc:document.id('desc').value || 'descripción inexistente',
							CI:document.id('ci').value || 'cédula no registrada',
							HraInicio:document.id('hrainicio').value || 'Hora no almacenada',
							HraFin:document.id('hrafin').value || 'Hora no almacenada'
						},
						method: 'post'
					},
					title: 'Registro de horario de trabajo'//título de la ventana
				}).open();
				limpiar();
				
			});
			
		});    
		function limpiar(){
			//document.getElementById("nombre").value="";
			document.getElementById("desc").value="";
			document.getElementById("hrainicio").value="";
			document.getElementById("hrafin").value="";
			}
</script>
<script type="text/javascript">
function cerrar(){
	var ventana;
	ventana=window.close();//función para cerrar la ventana
	}
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de sesión
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/regAuditoria.php");//archivo log de auditoría
	#consulta del programa donde se está navegando
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
        <img src="../images/hras.jpg" height="40" width="40"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Llenar el formulario">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php 
	if(isset($_GET["ci"])){//si existe la cédula del trabajador mostrará el formulario
	$ci=$_GET["ci"];
	$trabajador=$_GET["trabajador"];
	$cargo=$_GET["cargo"];
	?>
    <fieldset>
    <legend>FORMULARIO DE DEFINICIÓN DE CALENDARIO DE HORAS</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Trabajador</label></td><td><input type="text"  class="nombre" name="nombre" id="nombre" value="<?php echo $trabajador;?>" readonly></td></tr></div>
    <div><tr><td><label>Cargo</label></td><td><input type="text"  class="cargo" name="cargo" id="cargo" value="<?php echo $cargo;?>" readonly></td></tr></div>
    <input type="hidden" value="<?php echo $ci;?>" id="ci">
    <div><tr><td><label>Descripción</label></td><td><textarea name="desc" id="desc" rows="6" cols="30"></textarea></td></tr></div>
     <div><tr><td><label>Hora de inicio</label></td><td><input type="text"  class="hrainicio" id="hrainicio" maxlength="8"></td></tr></div>
     <div><tr><td><label>Hora de finalización</label></td><td><input type="text"  class="hrafin" id="hrafin" maxlength="8"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="button" type="button" value="CERRAR VENTANA" onClick="cerrar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../../index.php");
		}
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
    <!--Los estilos para el texto label y el botón sub se utilizan para mejorar la apariencia de la página del formulario, se utilizan font, color, tipo de fuente, ancho, margenes -->
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   #sub{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#F00;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
		#sub:hover{
			background:#ddd;
					}
	   </style>
       <!--Llama a los archivos css para dar el estilo a la página y al calendario -->
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
 <!--Los archivos javascript serán de utilidad para abrir la ventana modal al momento de registrar el formulario -->
 <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){//inicia el evento para la ventana
			
			document.id('boton').addEvent('click',function(){//evento del botón para abrir la ventana
				
				ajaxFace = new LightFace.Request({//instancia a la clase ligthface
					url: 'registros/addPlan.php',//url destino
					buttons: [//arreglo del botón de cerrado
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //el arreglo guarda los datos requeridos
						   IDproyecto:document.id('idproyecto').value || 'nombre no agregado',
						   Desc:document.id('desc').value || 'cargo no ingresado',
						   Fec1:document.id('fec1').value || 'Fecha no almacenada'
						},
						method: 'post'//método post
					},
					title: 'Registro de parámetros'//título de la ventana
				}).open();//abre la ventana
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//varifica la existencia de la sesión
	require_once("../db/connect.php");//llama a la conexión global
	#consulta del programa donde se está navegando
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al ID de la opción
	$consulta->execute();//ejecuta la instrucción
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		require_once("consultas/mensajeAyuda.php");
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		$idproyecto=$_GET["idproy"];
		//consulta para el nombre del proyecto
		$sql=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
		$sql->bindParam(1,$idproyecto);//enlaza al ID del proyecto
		$sql->execute();
		$result=$sql->fetch();
		$proyecto=$result[0];
		?>
        <input type="submit" value="VOLVER AL LISTADO" onClick="history.back();" id="sub"><br>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <fieldset>
    <legend>FORMULARIO DE REGISTRO DE PLANIFICACIÓN	</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Proyecto</label></td><td><textarea  name="proyecto" class="proyecto"  id="proyecto" cols="10" rows="5" readonly><?php echo $proyecto;?></textarea>
    <input type="hidden" value="<?php echo $idproyecto;?>" id="idproyecto"></td></tr></div>
    <div><tr><td><label>Descripción</label></td><td><textarea name="desc" class="desc" id="desc" cols="20" rows="6"></textarea></td></tr></div>
    <div><tr><td><label>Fecha de inicio</label></td><td><input type="text" id="fec1" name="fec1"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="boton" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");//en caso de que la sesión no exista se dirige al usuario al login
		}
?>
<script type="text/javascript">
$(function() {
	$( "#fec1" ).datepicker(); //función para el calendario
	$( "#fec1" ).datepicker('option',{dateFormat:'yy-mm-dd'});//establece el formato yyyy-mm-dd para guardar la fecha
});
    </script>
</body>
</html>
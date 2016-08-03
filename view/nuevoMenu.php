<?php  session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de módulos</title>
 <script type="text/javascript" src="../js/jquery.min.js"></script>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
 <style>
       label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	   legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	          size:auto;
		     }
	    </style>
<script type="text/javascript">
$(document).ready(function() {	
	$('#modulo').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var modulo = $(this).val();		
		var dataString = 'modulo='+modulo;
		
		$.ajax({
            type: "POST",
            url: "consultas/modulodisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
</script> 
  
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/regAuditoria.php");//llama al archivo log de auditoría
	require_once("consultas/mensajeAyuda.php");
	#consulta el programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función log de auditoría
		$mensaje=consultaMensaje($_GET["idopcion"]);
		?>
        <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>"><br>
        <?php
		}
		}else{
		header("location: ../index.php");//redirige al login
		}
	?>
    <fieldset>
    <legend>Formulario de Módulos del sistema</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>Nombre de Menú:</label></td><td><input type="text" id="modulo" class="modulo" name="modulo" placeholder="GESTIÓN DE PROYECTOS" maxlength="30" /></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Descripción:</label></td><td><textarea name="descmodulo" class="descmodulo" rows="6" cols="30" max="150" placeholder="Nuevo módulo del sistema"></textarea></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button id="button" class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoModulo.js"></script>
    <?php
	}catch(PDOExeption $e){
		echo "Error inesperado";
		}
	}else{
		header("location: ../index.php");
		}
?>

</body>
</html>
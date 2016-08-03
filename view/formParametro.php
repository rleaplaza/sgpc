<?php session_start();?>
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
	   legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
	   </style>
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#nombre').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var nombre = $(this).val();		
		var dataString = 'nombre='+nombre;
		
		$.ajax({
            type: "POST",
            url: "consultas/paramDisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
</script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addParametro.php',
					buttons: [
						{ title: 'Cerrar', 
						  event: function() {
							 this.close(); 
							 limpiar();
							 },
					      color:'blue'
						 }
					],
					request: { 
						data: { 
						    Nombre:document.id('nombre').value || 'nombre no agregado',
							Valor:document.id('valor').value || 'valor no ingresado'
						},
						method: 'post'
					},
					title: 'Registro de parámetros'
				}).open();
				limpiar();
			});
			
		});    
		function limpiar(){
			document.getElementById("nombre").value="";
			document.getElementById("valor").value="";
		    document.getElementById("nombre").focus();
			}
		
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	require_once("consultas/mensajeAyuda.php");
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
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
        <img src="../images/param.png" height="40" width="40"><br>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <fieldset>
    <legend>FORMULARIO DE NUEVO PARÁMETROS</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Nombre</label></td><td><input type="text"  class="nombre" name="nombre" id="nombre"  maxlength="80" autofocus></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Valor de porcentaje</label></td><td><input type="text" name="valor" id="valor" class="valor"  maxlength="5"><img src="../images/ayuda.jpg" height="20" width="20" title="Escriba un valor numérico usando dos decimales ej. 14.96,"></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO" onFocus="limpiar()"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
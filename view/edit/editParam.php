<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="../registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
          <script src="../../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="../registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="../registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="../registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#nombre').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var nombre = $(this).val();		
		var dataString = 'nombre='+nombre;
		
		$.ajax({
            type: "POST",
            url: "../consultas/paramDisponible.php",
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
					url: '../registros/updateParametro.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDparam:document.id('idparam').value || 'ID no encontrado',
						    Nombre:document.id('nombre').value || 'nombre no agregada',
							Valor:document.id('valor').value || 'cargo no ingresado'
						},
						method: 'post'
					},
					title: 'Registro de parámetros'
				}).open();
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
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
		echo("<label>".$row["nombreopcion"]."</label</p><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		require_once("../consultas/mensajeAyuda.php");
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../../images/ayuda.jpg" height="20" width="20" title="Para editar simplemente haga click sobre el campo respectivo y cambie el nombre del campo">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php
    $sql=$dbh->prepare("select *from parametro where IDparametro=?");
	$sql->bindParam(1,$_GET["idparam"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$res=$sql->fetch();
	?>
    <fieldset>
    <label>Para obtener ayuda, coloque el mouse sobre la imagen </label><br>
    <legend>FORMULARIO DE EDICIÓN DE PARÁMETROS</legend>
   <img src="../../images/param.png" width="56" height="50" />
 
   
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Nombre</label></td><td><input type="text"  class="nombre" name="nombre" id="nombre" value="<?php echo $res["nombre"];?>" maxlength="80" readonly></td><div id="Info"></div></tr></div>
    <input type="hidden" value="<?php echo $res["IDparametro"];?>" id="idparam">
    <div><tr><td><label>Valor</label></td><td><input type="text" name="valor" id="valor" class="valor" maxlength="6" value="<?php echo $res["valor"];?>"></td></tr></div>
    <div class="ultimo">
  <img src="ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="EDITAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		echo "<label>Registro no existente en sistema</label>";
		}
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
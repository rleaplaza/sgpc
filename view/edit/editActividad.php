<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edición de actividades</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
    <link href="../registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
 <link href="../../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
 <script src="../../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="../registros/lightface/Source/mootools.js"></script><script type="text/javascript" src="../registros/lightface/Source/mootools-more-drag.js"></script>


<script type="text/javascript" src="../registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="../registros/lightface/Source/LightFace.Request.js"></script>
<script src="../../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: '../registros/updateActividad.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDactividad:document.id('idactividad').value || 'ID no encontrado',
							FechaFin:document.id('fecFin').value || 'Fecha no almacenada',
						    FecIni:document.id('fecIni').value || 'Fecha de inicio no almacenada',
							Avance:document.id('avance').value || 'Avance no almacenado',
							FecIniAnt:document.id('fechaInicioAnterior').value || 'Fecha anterior no almacenada'						},
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
	$estado=$_GET["estado"];
	if($estado!="finalizada"){
		$total_avance=$_GET["total_avance"];
	?>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../../images/ayuda.jpg" height="20" width="20" title="Para editar simplemente haga click sobre el campo respectivo y cambie el nombre del campo">
 
    <?php
    $sql=$dbh->prepare("select *from actividad where IDactividad=?");
	$sql->bindParam(1,$_GET["idactividad"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$res=$sql->fetch();
	?>
    <fieldset>
    <label>Para obtener ayuda, coloque el mouse sobre la imagen </label><br>
    <legend>FORMULARIO DE EDICIÓN DE ACTIVIDADES</legend>
   <img src="../../images/tareas.jpg" width="56" height="50" />
 
   
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <input type="hidden" id="idactividad" value="<?php echo $_GET["idactividad"];?>">
    <input type="hidden" id="avance" value="<?php echo $total_avance;?>">
    <input type="hidden" id="fechaInicioAnterior" value="<?php echo $res["fechaRealizacion"];?>">
    <div><tr><td><label>Nombre</label></td><td><input type="text"  class="nombre" id="nombre" value="<?php echo $res["nombreActividad"];?>" maxlength="80" readonly></td></tr></div>
     <div><tr><td><label>Cantidad programada</label></td><td><input type="text"  class="cantidad" id="cantidad" value="<?php echo $res["cantidad"]." ".$res["unidades"];?>" maxlength="80" readonly></td></tr></div>
     <div><tr><td><label>Avance informado</label></td><td><input type="text"  class="avance" id="avance" value="<?php echo $total_avance." ".$res["unidades"];?>" maxlength="80" readonly></td></tr></div>
      <div><tr><td><label>Fecha de Inicio</label></td><td><input type="text"  class="fecIni" id="fecIni" value="<?php  echo $res["fechaRealizacion"];?>" maxlength="80" readonly></td></tr></div>
      <div><tr><td><label>Fecha de conclusion</label></td><td><input type="text"  class="fecFin" id="fecFin" value="<?php echo $res["fechaFin"];?>" maxlength="80"></td></tr></div>
   
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		echo "<label>Registro no existente en sistema</label>";
		}
		}else{
	echo "<label>Actividad finalizada</label>";
	}
	}else{
		header("location: ../index.php");
		}

?>
<script type="text/javascript">
$(function() {
	<?php if($total_avance==0){?>
	$( "#fecIni" ).datepicker(); 
	$( "#fecIni" ).datepicker('option',{dateFormat:'yy-mm-dd'});
	<?php
	}
	?>
	$( "#fecFin" ).datepicker(); 
	$( "#fecFin" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
    </script>
</body>
</html>
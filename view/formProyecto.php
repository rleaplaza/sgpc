<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro de proyectos</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/fechaCastellano.js"></script>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
</head>
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {	
	$('#proyecto').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var proyecto = $(this).val();		
		var dataString = 'proyecto='+proyecto;
		
		$.ajax({
            type: "POST",
            url: "consultas/proyectodisponible.php",
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
$(document).ready(function() {	//funcion para enviar a la consulta de feriado usando ajax
	$('#Datepicker1').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);//imagen de cargo

		var fec1= $(this).val();		
		var dataString = 'fec1='+fec1;//captura la fecha de inicio
		
		$.ajax({
            type: "POST",//metodo post
            url: "consultas/feriados.php",//url de envio
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
            }
        });
    });              
}); 
</script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#Datepicker2').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var fec2= $(this).val();		
		var dataString = 'fec2='+fec2;//captura la fecha de finalizacion
		
		$.ajax({
            type: "POST",
            url: "consultas/feriadofin.php",//url de envio
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
            }
        });
    });              
}); 
</script> 
<style>
 label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	          color:#009;
	           size:auto;
				 }
</style>
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
    $getFecha=$dbh->prepare("select curdate()");
	$getFecha->execute();
	$fila=$getFecha->fetch();
	$fechaActual=$fila[0];
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
		}
	}
	else{
		header("location: ../index.php");
		}
	?>
    <img src="../images/proyecto.jpg" width="30" height="30" />
    <fieldset>
    <legend>Formulario de Registro de proyectos</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>Nombre del proyecto:</label></td><td><textarea id="proyecto" class="proyecto" name="proyecto" rows="3" cols="35" style="text-transform:uppercase;"></textarea></td><div id="Info"></div>
<td><label>Seleccionar un responsable</label></td><td><select name="responsable" class="responsable">
<?php
$sql=$dbh->prepare("SELECT IDempleado,CI, concat( nombres, ',', app, ',', apm ) AS empleado, c.nombre
                    FROM empleado AS e, cargo AS c
                    WHERE e.IDcargo = c.IDcargo
                    AND c.nombre = 'Contratista'");
$sql->execute();
foreach($sql->fetchAll() as $row){
echo "<option value=".$row[0].">".$row[2]."</option>";
	}

?>
</select></td></tr></div>
    <div><tr><td><label>Tipo de convocatoria:</label></td><td><select name="conv" id="conv" class="conv">
    <?php
    $sql=$dbh->prepare("select *from licitacion order by descripcion");
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $res){
			echo "<option value=".$res["IDlicitacion"].">".$res["descripcion"];
			}
		}
	?>
    </select></td></tr></div>
    <div><tr><td><label>Departamento</label></td><td><select name="depa" id="depa" class="depa">
    <?php
    $sqldepa=$dbh->prepare("select IDdepa, nombre from departamentos order by IDdepa");
	$sqldepa->execute();
	if($sqldepa->rowCount()>0){
		foreach($sqldepa->fetchAll() as $filad){
			?>
            <option value="<?php echo $filad["IDdepa"];?>"><?php echo utf8_encode($filad["nombre"]);?>
            <?php
			}
		}
	?>
    </select></td></tr></div>
    <input type="hidden" id="fechaActual" class="fechaActual" name="fechaActual" value="<?php echo $fechaActual;?>">
     <div><tr><td><label>Fecha de inicio del proyecto:</label></td><td><input type="text" id="Datepicker1" class="fecInicio" name="fecInicio" contenteditable="false"></td></tr><div id="Info"></div></div>
     <div><tr><td><label>Fecha de finalización del proyecto:</label></td><td><input type="text" id="Datepicker2" class="fecFin" name="fecFin" contenteditable="false"></td></tr><div id="Info"></div></div>
     <div><tr><td><label>Costo programado Bs:</label></td><td><input type="text" id="monto" class="monto" name="monto" maxlength="20"></td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button class="boton_envio">REGISTRAR</button></td><td><input type="reset" class="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
<script type="text/javascript" src="../js/nuevoProyecto.js"></script>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
<script type="text/javascript">
$(function() {
	$( "#Datepicker1" ).datepicker(); 
	$("#Datepicker1").datepicker('option',{dateFormat:'yy-mm-dd'});
	$( "#Datepicker2" ).datepicker(); 
	$("#Datepicker2").datepicker('option',{dateFormat:'yy-mm-dd'});
});
</script>
</body>
</html>
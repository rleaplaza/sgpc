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
	   #button{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#00F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
	   </style>
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
 <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
 <script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
$idproyecto=$_POST["proyecto"];
$user=$_SESSION["username"];
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);
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
		require_once("consultas/mensajeAyuda.php");
		$idopcion=$_POST["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button"><br>
        <img src="../images/informe.jpg" height="40" width="40">
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <fieldset>
    <legend>INFORME DE ACTIVIDADES SEGÚN CRITERIO DE BÚSQUEDA</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Fase</label></td><td><select name="idfase">
    <?php 
	$sql=$dbh->prepare("select IDfase, nombre from fase where IDproyecto=? order by nombre asc");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $res){
			?>
            <option value="<?php echo $res[0];?>"><?php echo $res[1];?>
            <?php
			}
		}
	?>
    </select></td></tr></div>
    <div><tr><td><label>Actividades</label></td><td><select name="criterio" id="actividad" class="criterio">
    <option value="sin comenzar">Sin comenzar
    <option value="demorada">Demorada
    <option value="En ejecucion">En ejecución
    <option value="finalizada">Finalizada
    </select></td></div>
    <input type="hidden" value="<?php echo $user?>" name="user">
    <div><tr><td><label>Fecha de inicio</label></td><td><input type="text" id="fec1" name="fec1"></td></tr></div>
    <div><tr><td><label>Fecha límite</label></td><td><input type="text" id="fec2" name="fec2"></td></tr></div>
  <tr><td><input type="submit" class="boton_envio" id="sub" value="IMPRIMIR" onclick="this.form.action='../reportes/proyectos/estadoActividad.php'" formtarget="_blank"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
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
<?php session_start();?>
<!DOCTYPE HTML>
<html
<head>
<meta charset="utf-8">
    <title>Formulario de Usuario</title>
  <script type="text/javascript" src="../js/jquery.min.js"></script>

<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/poblarSubfase.js"></script>

<?php 
#Este programa corresponde al formulario de registro de nuevos usuarios dentro del sistema
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
?>

</head>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<style>
text{
	font:Verdana, Geneva, sans-serif;
    color:#00C;
    font-size:18px;
	}
label{ font:Verdana, Geneva, sans-serif;
	color:#00C;
	         }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
				 }
#button{font-wight:bold;
		cursor:pointer;
	    padding:5px;
	    color:#00F;
		margin: 0 10px 20 px 0;
	    border: 1px solid #ccc;
	    background:#00F;
	    border-radius:8px 8px 8px 8px;
		color:#FFF;
			}
#button:hover{
		background:#09F;
			}
</style>

<body>
<?php
try{
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/regAuditoria.php");//llama al archivo log de auditoría
	require_once("consultas/mensajeAyuda.php");
	$user=$_SESSION["username"];
	$idproyecto=$_POST["idproyecto"];
	#consulta el programa donde se está navegando
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
        $mensaje=consultaMensaje($_POST["idopcion"]);
		}
         ?>
<input type="submit" value="SALIR" onClick="history.back();" id="button"><br>
<label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>"><br>
     <?php
		}
	else{
		header("location: ../index.php");//redirige al login
		}
?>
<img src="../images/cargoManoobra.jpg" width="60" height="60" /> 
<fieldset>
<legend>Formulario de actividades sin personal asignado</legend>
<form method="post" class="usuario" id="formulario" name="form1">
<table align="left">
<tr><td><label>Fase</label></td><td><select name="fase" class="fase" onChange="Subfase(this.value)" required>
  <?php
  $consulta=$dbh->prepare("select *from fase where IDproyecto=? order by nombre desc");
  $consulta->bindParam(1,$idproyecto);
  $consulta->execute();
  if($consulta->rowCount()>0){
	  ?>
      <option value="nulo" selected>_Seleccione una fase
      <?php
	  foreach($consulta->fetchAll() as $fila){
		  ?>
          <option value="<?php echo $fila[0];?>"><?php echo $fila[3];?>
          <?php
		  }
	  }
  ?>
</select>
<tr><td><label>Subfase</label></td><td>
<div id="idsubfase">
<select name="subfase" id="subfase" required>
<option value="">_carga de subfase</select>
</div>
</td>
  <input type="hidden" value="<?php echo $user;?>" name="user">
  <tr><td><input type="submit" value="IMPRIMIR" onClick="this.form.action='../reportes/proyectos/Act_Personal.php'"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 
  </table>
          </form>
          </fieldset>
<script src="../js/functions.js"></script>
<?php
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
}
else{
header("location: ../index.php");	
	}
?>
</body>
</html>
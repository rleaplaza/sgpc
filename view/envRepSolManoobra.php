<?php session_start();//función de inicio de sesión
#Este programa se encarga de mostrar un formulario para enviarlo a un reporte de solicitudes de mano de obra en base a rango de fechas o estados?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte de solicitudes de mano de obra</title>

<style type="text/css">
  body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
	     .big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		 
</style>
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
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
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/fechaCastellano.js"></script>

</head>

<body> 
<?php
if(isset($_SESSION["username"])){
	if(isset($_GET["idopcion"])){
		require_once("../db/connect.php");
		require_once("consultas/MensajeAyuda.php");
		require_once("registros/regAuditoria.php");
		$user=$_SESSION["username"];
		    try{
				#consulta para desplegar el programa donde el usuario se encuentra
			 $consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
             $consulta->bindParam(1,$_GET["idopcion"]);#enlaza al id de la opción
	         $consulta->execute();#ejecuta la consulta
			 if($consulta->rowCount()>0){
		      $row=$consulta->fetch();
		      echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
			 regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);
			  $mensaje=consultaMensaje($_GET["idopcion"]);
			  ?>
              <br><label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="25" width="25" title="<?php echo $mensaje;?>">
              <?php
			   }
			   ?><br>
               <img src="../images/pdf.jpg" height="30" width="30">
               <img src="../images/excel.jpg" height="30" width="30"><img src="../images/cargoManoobra.jpg" height="30" width="40"><br>
               <h2><legend>Reporte de solicitudes por fecha y por estado</legend></h2>
              <fieldset> <legend>Seleccione un criterio de fechas</legend>
               <form class="usuario" method="post">
               <table>
               <tr><td><label>Desde:</label></td><td><input type="text" id="Datepicker1" name="fecha1" placeholder="2014-01-01" contenteditable="false"><img src="../images/ayuda.jpg" hight="25" width="25" title="Fecha de inicio para el reporte"></td></tr>
               <tr><td><label>Hasta:</label></td><td><input type="text" id="Datepicker2" name="fecha2" placeholder="2014-12-31"><img src="../images/ayuda.jpg" height="25" width="25" title="Fecha límite para el reporte" contenteditable="false"></td></tr>
      <input type="hidden" value="<?php echo $user;?>" name="user">
  <td><input type="submit" id="sub" value="ENVIAR REPORTE A PDF" formtarget="_blank" onclick="this.form.action='../reportes/proyectos/repSolFecha.php'" ></td>
  <td><input type="submit" id="sub" value="ENVIAR REPORTE A EXCEL" onclick="this.form.action='../reportes/proyectos/excel/repSolFechaXls.php'" formtarget="_blank"></td>
               </tr>
               </table>
               </form>
               </fieldset>
               <fieldset><legend>Seleccione un estado</legend>
               <form class="usuario" method="post">
               <table>
               <tr><td><select name="estado">
               <option value="Pendiente">Pendiente
               <option value="Atendido">Atendido
               </select></td></tr>
               <input type="hidden" value="<?php echo $user;?>" name="user">
               <tr><td><input type="submit" id="sub" value="ENVIAR REPORTE A PDF" formtarget="_blank" onClick="this.form.action='../reportes/proyectos/repSolEstado.php'"></td>
               <td><input type="submit" id="sub" value="ENVIAR REPORTE A EXCEL" formtarget="_blank" onClick="this.form.action='../reportes/proyectos/excel/repSolEstadoXLS.php'"></td></tr>
               </table>
               </form>
               </fieldset>
               <?php
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();#genera una excepción en caso de fallas
				}
		}else{
			header("location:../index.php");#direcciona en caso de que el usuario no tenga el permiso para esta página
			}
	}else{
		header("location: ../index");#direcciona en caso de que la sesión no exista
		}
?>
<script type="text/javascript">
$(function() {
	$( "#Datepicker1" ).datepicker();//llama a la función datepicker
	$("#Datepicker1").datepicker('option',{dateFormat:'yy-mm-dd'});//convierte a formato de fecha YYYY-MM-DD 
	$( "#Datepicker2" ).datepicker(); 
	$("#Datepicker2").datepicker('option',{dateFormat:'yy-mm-dd'});
	$
});

	
</script>
</body>
</html>
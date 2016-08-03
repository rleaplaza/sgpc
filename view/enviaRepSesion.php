<?php
#Este programa se encarga de realizar envío de informes de sesión en rangos de fechas dados
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte de sesiones por fecha</title>

<style type="text/css">
  body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
	     .big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		 #sub{ font-wight:bold;
			   cursor:pointer;
			   padd ing:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#eee;
			   border-razdius:8px 8px 8px 8px;
		      }
		 #sub:hover{
				background:#ddd;
			}
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
<!--Llama a las hojas de estilo css de jquery ui para el control datepicker -->
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/fechaCastellano.js"></script>

</head>

<body>
<?php
if(isset($_SESSION["username"])){//valida si existe la sesión
	if(isset($_GET["idopcion"])){//valida si existe la variable de opción
		require_once("../db/connect.php");//llama a la conexión de base de datos
		require_once("consultas/mensajeAyuda.php");//llama al archivo para mostrar mensajes de ayuda
		$user=$_SESSION["username"];
		    try{//consulta para el programa donde se está navegando
			 $consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
             $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al id de opción
			 $mensaje=consultaMensaje($_GET["idopcion"]);//envía el parámetro a la función del archivo
	         $consulta->execute();//ejecuta la consulta
			 if($consulta->rowCount()>0){
		      $row=$consulta->fetch();//devuelve el resultado en un arreglo
		      echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
			   }
			   ?><br>
               <!-- La página muestra el ícono de reporte para referencias a la página, despliega el formulario donde el usuario deberá ingresar rangos de fechas para imprimir informes de sesión-->
               <img src="../images/reportes.jpg" height="40" width="40"><br>
               <fieldset>
               <legend>Reporte de sesiones de usuarios por fecha</legend></h2>
               <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="30" width="30" title="<?php echo $mensaje;?>"><br><!--Formulario de selección de fechas -->
               <h2><legend>Seleccione un criterio de fechas</legend></h2><br>
               <form class="usuario" method="post">
               <table><!--Fecha inicial y final para imprimir los informes, ambas fechas corresponden a fechas de inicio de sesión -->
               <tr><td><label>Desde:</label></td><td><input type="text" id="Datepicker1" name="fecha1" placeholder="2014-01-01" contenteditable="false" class="fecha" readonly><img src="../images/ayuda.jpg" hight="25" width="25" title="Fecha de inicio para el reporte"></td></tr>
               <tr><td><label>Hasta:</label></td><td><input type="text" id="Datepicker2" name="fecha2" placeholder="2014-12-31" class="fecha" readonly><img src="../images/ayuda.jpg" height="25" width="25" title="Fecha límite para el reporte" contenteditable="false"></td></tr>
               <input type="hidden" value="<?php echo $user;?>" name="user">
  <td><input type="submit" value="EXPORTAR A PDF" onclick="this.form.action='../reportes/administracion/repsesionFecha.php'" ></td>
  <td><input type="submit" value="EXPORTAR A EXCEL" onclick="this.form.action='../reportes/administracion/excel/repSesionFechaXls.php'" formtarget="_blank"></td>
               </tr>
               </table>
               </form>
               </fieldset>
               <?php
		     if(isset($row)){
		      $nombMenu=$row["nombremenu"];
		      $nombSubmenu=$row["nombresubmenu"];
		      $nombOpcion=$row["nombreopcion"];
		    //regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
			 }
			}catch(PDOException $e){//genera una excepción en caso de fallar la conexión
				echo "Error inesperado".$e->getMessage();
				}
		}else{
			header("location:../index.php");//redirige al usuario al login
			}
	}else{
		header("location: ../index");//redirige al usuario al login
		}
?>
<script type="text/javascript">
$(function() {
	$(".fecha").datepicker({changeMonth:true,
	                           changeYear:true,
							   dateFormat:'MM yy'});//función datepicker
	$(".fecha").datepicker('option',{dateFormat:'yy-mm-dd'});//establece el formado yyyy-mm-dd 

});

	
</script>
</body>
</html>
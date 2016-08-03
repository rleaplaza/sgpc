<?php session_start();//función de inicio de sesión
#Este programa se encarga de mostrar un formulario donde se debe ingresar un rango de fechas para desplegar items comprados?>
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
			   padding:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#eee;
			   border-radius:8px 8px 8px 8px;
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
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//verifica la sesión
	if(isset($_GET["idopcion"])){//verifica el id de opción
		require_once("../db/connect.php");//llama a la conexión de base de datos
		require_once("consultas/mensajeAyuda.php");//consulta de mensaje de ayuda
		    try{
				#consulta del programa donde se está navegando
			 $consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
             $consulta->bindParam(1,$_GET["idopcion"]);
			 $mensaje=consultaMensaje($_GET["idopcion"]);
	         $consulta->execute();
			 if($consulta->rowCount()>0){
		      $row=$consulta->fetch();
		      echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
			   }
			   ?><br>
               <img src="../images/reportes.jpg" height="40" width="40"><br>
               <fieldset>
               <legend>Reporte de plan de compras por mes</legend></h2>
               <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="30" width="30" title="<?php echo $mensaje;?>"><br>
               <h2><legend>Seleccione un criterio de fechas</legend></h2><br>
               <form class="usuario" method="post">
               <table>
               <tr><td><label>Desde:</label></td><td><input type="text" id="Datepicker1" name="fecha1" placeholder="2014-01-01" contenteditable="false"><img src="../images/ayuda.jpg" hight="25" width="25" title="Fecha de inicio para el reporte"></td></tr>
               <tr><td><label>Hasta:</label></td><td><input type="text" id="Datepicker2" name="fecha2" placeholder="2014-12-31"><img src="../images/ayuda.jpg" height="25" width="25" title="Fecha límite para el reporte" contenteditable="false"></td></tr>
  <td><input type="submit" value="ENVIAR REPORTE A PDF" formtarget="_blank" onclick="this.form.action='../reportes/administracion/repPlancompra.php'" ></td>
  <td><input type="submit" value="ENVIAR REPORTE A EXCEL" onclick="this.form.action='../reportes/administracion/excel/repPlancompraXls.php'" formtarget="_blank"></td>
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
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();
				}
		}else{
			header("location:../index.php");
			}
	}else{
		header("location: ../index");
		}
?>
<script type="text/javascript">
$(function() {
	$( "#Datepicker1" ).datepicker();//función datepicker
	$("#Datepicker1").datepicker('option',{dateFormat:'yy-mm-dd'});//función para dar el formato yyyy-mm-dd 
	$( "#Datepicker2" ).datepicker(); 
	$("#Datepicker2").datepicker('option',{dateFormat:'yy-mm-dd'});
	$
});

	
</script>
</body>
</html>
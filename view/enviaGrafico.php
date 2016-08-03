<?php
session_start();//función de inicio de sesión
?>
<!doctype html>
<html><head>
<meta charset="utf-8">
<title>Grafico de cantidad de sesiones</title>
<script type="text/javascript" src="../js/ajaxgr.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<style type="text/css">
  body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
	     .big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		 #sub{ font-wight:bold;
			   cursor:pointer;
			   padding:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#00C;
			   border-radius:6px 6px 6px 6px;
			    -webkit-box-shadow:inset 0 0 10px #000000;
				box-shadow:inset 0 0 3px #000000;
			   color:#FFF;
		      }
		 #sub:hover{
				background:#09F;
			}
</style>
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
label{ font:Verdana, Geneva, sans-serif;
	   color:#00C;
	  }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
	   .select{
		    background: #F5F5F5;
    border: 1px solid #E8E8E8;
    color: #6;
    display: block;
    float: left;
    padding: 8px;
    resize: none;
    width: 265px;
    -webkit-transition: all 0.1s linear;
    -moz-transition: all 0.1s linear;
	-moz-box-shadow:inset 0 0 10px #000000;
    -webkit-box-shadow:inset 0 0 10px #000000;	
	border-radius:4px 4px 4px 4px;
		box-shadow:inset 0 0 3px #000000;
		   }
</style>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//verifica que la sesión exista
	if(isset($_GET["idopcion"])){//verifica que el id de opción exista
		require_once("../db/connect.php");
		require_once("registros/regAuditoria.php");
		    try{
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
			  regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);
			   }
			   ?>
               <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Para imprimir reportes gráficos, se debe desplegar las listas de seleccion de mes, año y tipo de gráfico, seguidamente se debe presionar el boton imprimir gráfico, donde le mostrará una ventana con el gráfico estadístico seleccionado"/>
               <h2><label>Reporte gráfico de cantidad de accesos por mes</label></h2>
               <img src="../images/graficos.jpg" height="58" width="58">
               <img src="../images/jpgraph.jpg" height="58" width="58">
               <img src="../images/jpgraph2.jpg" height="58" width="58"><br>
               <h2><label>Seleccione un criterio de Mes y Año</label></h2><br>
               <fieldset>
               <legend>Formulario de informes</legend>
               <table>
               <tr><td>
               <select id="anio" name="anio" class="select">
               <option value="">_Seleccionar año
               <option value="2013">2013
               <option value="2014">2014
               <option value="2015">2015
               <option value="2016">2016
               </select>
               </td></tr>
               <tr><td>
               <select id="mes" name="mes" class="select">
               <option value="">_Seleccionar mes
               <option value="01">Enero
               <option value="02">Febrero
               <option value="03">Marzo
               <option value="04">Abril
               <option value="05">Mayo
               <option value="06">Junio
               <option value="07">Julio
               <option value="08">Agosto
               <option value="09">Septiembre
               <option value="10">Octubre
               <option value="11">Noviembre
               <option value="12">Diciembre
               </select></td></tr>
               <tr><td>
               <select name="tipo" class="select" id="tipo">
               <option value="">_Tipo de gráfico
               <option value="barra">Barra
               <option value="torta">Torta
               </select></td></tr>
               <td><button onClick="mostrar();" id="sub">Imprimir Gráfico</button>
               </td>
               </tr></table>
             
            </fieldset>
               <?php
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
</body>
</html>
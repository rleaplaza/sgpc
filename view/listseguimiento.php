<?php
session_start();//función de inicio de sesión
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Seguimiento del proyecto</title>
<!--Llama a los archivos jquery y jquery ui para mejora de la interfaz -->
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<style type="text/css">
  body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
	     .big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			#sub1{ font-wight:bold;
			   cursor:pointer;
			   padding:5px;
			    color:#FFF;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#00C;
			   border-radius:8px 8px 8px 8px;
		      }
		 #sub1:hover{
				background:#06F;
			}
			#proyecto{
				color:#009;
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
</style>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//valida la existencia de la sesión
	if(isset($_GET["idopcion"])){//valida la existencia de la opción
		require_once("../db/connect.php");//llama a la conexión de la BD
	    require_once("registros/regAuditoria.php");
		require_once("consultas/mensajeAyuda.php");
		    try{//uso de try catch para mejorar la ejecución
			#consulta para el programa
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
			  #asignación de variables para enviar a la función
			  $idopcion=$_GET["idopcion"];
			  $nombMenu=$row["nombremenu"];
			  $nombSubmenu=$row["nombresubmenu"];
			  $nombOpcion=$row["nombreopcion"];
			  $mensaje=consultaMensaje($idopcion);
			   regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función para registrar el log de auditoría
			   }
			   ?>
               <legend>Ayuda del sistema</legend><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>"><br>
               <img src="../images/seguimiento.jpg" height="58" width="58"><br>
               <h2><legend>Seleccione el proyecto para enviar a seguimientos</legend></h2><br>
               <form method="post">
               <table>
               <tr><td><select id="proyecto" name="proyecto">
               <?php
               $sql=$dbh->prepare("select *from proyecto");
			   $sql->execute();//ejecuta la instrucción para el proyecto
			   if($sql->rowCount()>0){
				   foreach($sql->fetchAll() as $row){
					   ?>
                  <option value="<?php echo $row["IDproyecto"]?>"><?php echo $row["nombre"];?>
                       <?php
					   }
				   }
			   ?>
               </select>
               </td>
               <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
               <tr> <td><input type="submit" id="sub1" value="LISTADO DE ACTIVIDADES" onclick="this.form.action='listControl.php'">
               <input type="submit" id="sub1" value="INFORMACIÓN DEL PROYECTO" onclick="this.form.action='infoProyecto.php'">
              <input type="submit" id="sub1" value="SEGUIMIENTO DE ACTIVIDADES" onclick="this.form.action='seguimientoActividades.php'">
               <input type="submit" id="sub1" value="CONTROL DE FASES" onclick="this.form.action='controlFase.php'">
               </td></tr>
               </table>
               </form>
               <?php
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();//genera la excepción en caso de error inesperado
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
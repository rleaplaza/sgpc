<?php session_start();//función de inicio de sesión
#Este programa se encarga de mostrar el formulario del proyecto y enviarlo a la asignación de sus correspondientes actividades?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<!--Llama a los archivo jquery y jquery ui para mejorar la interfaz de usuario -->
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
			   background:#eee;
			   border-radius:8px 8px 8px 8px;
		      }
		 #sub:hover{
				background:#ddd;
			}
			#sub1{ font-wight:bold;
			   cursor:pointer;
			   padding:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#eee;
			   border-radius:8px 8px 8px 8px;
		      }
		 #sub1:hover{
				background:#ddd;
			}
</style>
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style>
label{ font:Verdana, Geneva, sans-serif;
	   color:#00C;
	   size:auto;
	  }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
</style>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	if(isset($_GET["idopcion"])){//verifica la existencia de la opción
		require_once("../db/connect.php");//llama a la conexión
		require_once("registros/regAuditoria.php");//llama al archivo log de auditoría
		    try{
				#consulta del programa donde se está navegando
			 $consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
             $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al id de opción
	         $consulta->execute();
			 if($consulta->rowCount()>0){
		      $row=$consulta->fetch();
		      echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
			  $idopcion=$_GET["idopcion"];
			  regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);
			   }
			   ?>
               <img src="../images/tareas.jpg" height="58" width="58"><br>
               <h2><legend>Seleccione el proyecto para enviar a la lista de actividades</legend></h2><br>
               <form method="post">
               <table>
               <tr><td><select id="proyecto" name="proyecto">
               <?php
               $sql=$dbh->prepare("select *from proyecto");
			   $sql->execute();
			   if($sql->rowCount()>0){
				   foreach($sql->fetchAll() as $row){
					   ?>
                  <option value="<?php echo $row["IDproyecto"]?>"><?php echo $row["nombre"];?>
                       <?php
					   }
				   }
			   ?>
               </select>
               </td></tr>
               <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
               <tr><td><input type="submit" id="sub" value="ASIGNACIÓN A LAS ACTIVIDADES" onclick="this.form.action='Asignacion.php'"></td>
               </tr>
               </table>
               </form>
               <?php
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();
				}
		}else{
			header("location:../index.php");//redirige al login en caso de no existir la opción
			}
	}else{
		header("location: ../index");//redirige al login en caso de no existir la sesión
		}
?>
</body>
</html>
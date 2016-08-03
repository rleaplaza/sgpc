<?php session_start(); //función de inicio de sesión?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>


<style type="text/css">
  body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
	     .big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
	  #sub{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00F;
			border-radius:8px 8px 8px 8px;
			}
				#sub:hover{
					background:#06F;
					color:#FFF;
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
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	if(isset($_GET["idopcion"])){//verifica la existencia de la opición
		require_once("../db/connect.php");//llama a la conexión a base de datos
		require_once("registros/regAuditoria.php");//llama al log de auditoría
		    try{
				#consulta del programa donde se está navegando
			 $consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
             $consulta->bindParam(1,$_GET["idopcion"]);//enlaza el id de opción
	         $consulta->execute();
			 if($consulta->rowCount()>0){
		      $row=$consulta->fetch();
			  #Imprime los nombre del programa
		      echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
			  $idopcion=$_GET["idopcion"];
			   regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);//función log de auditoría
			   }
			   ?>
               <img src="../images/seguimiento.jpg" height="58" width="58"><br>
               <h2><legend>Seleccione el proyecto para enviar al formulario de seguimiento</legend></h2><br>
               <form method="post">
               <table>
               <tr><td><select id="idproyecto" name="idproyecto">
               <?php
               $sql=$dbh->prepare("select *from proyecto");//consulta del proyecto
			   $sql->execute();
			   if($sql->rowCount()>0){
				   foreach($sql->fetchAll() as $row){//el arreglo recorre todas las filas
					   ?>
                  <option value="<?php echo $row["IDproyecto"];//id del proyecto?>"><?php echo $row["nombre"];//nombre del proyecto?>
                       <?php
					   }
				   }
			   ?>
               </select>
               </td></tr>
               <input type="hidden" value="<?php echo $idopcion;//campo oculto id de opción?>" name="idopcion">
               <tr><td><input type="submit" id="sub" value="Consulta" onclick="this.form.action='frmMaterial.php'">
                </td>
               </tr>
               </table>
               </form>
               <?php
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();//genera una exepción en caso de que la conexión falle
				}
		}else{
			header("location:../index.php");//redirige al login
			}
	}else{
		header("location: ../index");//redirige al login
		}
?>
</body>
</html>
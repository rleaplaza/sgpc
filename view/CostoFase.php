<?php
session_start();//función de inicio de la sesion
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js">//llamada al archivo jquery</script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js">//llamada al archivo jquery ui</script>
<script type="text/javascript" src="../js/ajaxgr.js"></script>


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
	if(isset($_POST["idopcion"])){//valida la existencia del id de opción que se envía desde la página principal
		require_once("../db/connect.php");//archivo de conexión a la base de datos
	    $idproyecto=$_POST["proyecto"];//captuar el id del proyecto
		    try{
			 #consulta de la opción para poder ingresar a la página
			 $consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
             $consulta->bindParam(1,$_POST["idopcion"]);
	         $consulta->execute();
			 if($consulta->rowCount()>0){
		      $row=$consulta->fetch();
		      echo("<p align=center><label>".$row["nombremenu"]."-</label><br>");
		      echo("<label>". $row["nombresubmenu"]."-</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
			  $idopcion=$_POST["idopcion"];
			   }
			   ?>
               <h2><legend>CONTROL DE INFORMES DE COSTOS POR FASE</legend></h2>
               <img src="../images/costos_fase.jpg" height="58" width="58"><br>
               <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back()" id="sub1">
               <h2><legend>Seleccione la fase para enviar al reporte de costos para actividades</legend></h2><br>
               <form method="post">
               <table>
               <tr><td><select id="idfase" name="idfase">
               <?php
               $sql=$dbh->prepare("select IDfase, fase.nombre as fase from fase, proyecto 
			                       where fase.IDproyecto=proyecto.IDproyecto
								   and proyecto.IDproyecto=?
								   order by fase.nombre");
			   $sql->bindParam(1,$idproyecto);
			   $sql->execute();
			   if($sql->rowCount()>0){
				   foreach($sql->fetchAll() as $row){
					   ?>
                  <option value="<?php echo $row["IDfase"]?>"><?php echo $row["fase"];?>
                       <?php
					   }
				   }
			   ?>
               </select>
               </td></tr>
               <tr> <td><input type="submit" id="sub1" value="PRESUPUESTOS" onclick="this.form.action='infrCostoFijo.php'" formtarget="_blank">
               <input type="submit" id="sub1" value="ACTIVIDADES CON PRESUPUESTO EXCEDIDO" onclick="this.form.action='sobrePresupuesto.php'" formtarget="_blank">
          </td></tr>
               </table>
               </form>
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
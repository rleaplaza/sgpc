<?php
session_start();
?>
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
if(isset($_SESSION["username"])){
	if(isset($_GET["idopcion"])){
		require_once("../db/connect.php");
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
		      echo("<label>Menu: <b>".$row["nombremenu"]."</b></label> ");
		      echo("<label>Submenu: <b>". $row["nombresubmenu"]."</b></label> ");
		      echo("<label>Opcion: <b>".$row["nombreopcion"]."</b></label><br>");
			   //regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
			   }
			   ?>
               <h2><legend>Solicitud de cargos de mano de obra</legend></h2>
               <img src="../images/cargoManoobra.jpg" height="58" width="58"><br>
               <h2><legend>Seleccione un proyecto para enviar al listado</legend></h2><br>
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
               </td>
               <td><input type="submit" id="sub" value="ENVIAR" onclick="this.form.action='listSolicitud.php'"></td>
               </tr>
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
<?php session_start();?>
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
			#sub1{ font-wight:bold;
			   cursor:pointer;
			   padding:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#00C;
			   border-radius:8px 8px 8px 8px;
			   color:#FFF;
		      }
		 #sub1:hover{
				background:#666;
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
<link href="../css/combo.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	if(isset($_GET["idopcion"])){
		require_once("../db/connect.php");
	    require_once("registros/regAuditoria.php");
		$user=$_SESSION["username"];
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
		      echo("<p align=center><label>".$row["nombremenu"]."</label><br> ");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
			  $idopcion=$_GET["idopcion"];
			   regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);
			   }
			   ?>
               <img src="../images/maquinaria1.jpg" height="58" width="58"><br>
               <h2><legend>Seleccione el proyecto para imprimir la solicitud de equipamiento</legend></h2><br>
               <form method="post" name="usuario">
               <table>
               <tr><td><select id="proyecto" name="idproyecto" class="select">
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
               <input type="hidden" value="<?php echo $user;?>" name="user">
               <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
                <tr><td><input type="submit" id="sub1" value="IMPRIMIR SOLICITUD" onclick="this.form.action='../reportes/compraAlquiler/solicitudEquipamiento.php'" class="botonenvio"></td>
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
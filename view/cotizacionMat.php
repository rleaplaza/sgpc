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
text{font:Verdana, Geneva, sans-serif;
     color:#00C;
	 font-size:18px;
				 }
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
		require_once("consultas/mensajeAyuda.php");
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
				 $mensaje=consultaMensaje($_GET["idopcion"]);
		      $row=$consulta->fetch();
		     echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		     echo("<label>". $row["nombresubmenu"]."</label><br>");
		     echo("<label>".$row["nombreopcion"]."</label></p>");
			
			  $idopcion=$_GET["idopcion"];
			   regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);
			   }
			   ?>
               <h2><legend>Formulario de solicitud de cotizaciones</legend></h2>
               <img src="../images/materiales.jpg" height="58" width="58"><img src="../images/cotizador.jpg" height="58" width="58"><br>
               <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>"/>
               <h2><legend>Seleccione el proveedor para consultar cotizaciones</legend></h2><br>
               <form method="post">
               <table>
               <tr><td><select id="proveedor" name="proveedor">
               <?php
               $sql=$dbh->prepare("select IDproveedor,empProveedora from proveedor");
			   $sql->execute();
			   if($sql->rowCount()>0){
				   foreach($sql->fetchAll() as $row){
					   ?>
                  <option value="<?php echo $row["IDproveedor"]?>"><?php echo $row["empProveedora"];?>
                       <?php
					   }
				   }
			   ?>
               </select>
               <input type="hidden" name="idopcion" value="<?php echo $idopcion;?>">
               </td>
                <td><input type="submit" id="sub1" value="SOLICITAR COTIZACION" onclick="this.form.action='listCotizacion.php'"></td>
                <td><input type="submit" id="sub1" value="IMPRESIÓN DE SOLICITUDES" onclick="this.form.action='listSolCot.php'"></td>
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
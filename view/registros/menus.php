<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
 <script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableMenu").dataTable({
				"sScrollY":"200px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../../traducciones/datatables.spanish.txt"
					}
				});
        });
   </script>
   <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
<link href="../../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../../css/example.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	          color:#009;
	           size:auto;
				 }
				 #button{
				
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
				}
				#button:hover{
					background:#ddd;
					}
				.enlace{
					color:#039;
					text-decoration:none;
					}
				.enlace:hover{
					color:#09C;
					}
			</style>
</head>

<body>

<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	try{ $iduser=$_GET["id"];
	$sql=$dbh->prepare("select *from usuario where USR_UID=?");
    $sql->bindParam(1,$iduser);
	$sql->execute();
	if($sql->rowCount()>0){
	 $row=$sql->fetch();
	 $username=$row[1];
	 echo("<label>USER ID: " .$iduser. " <br> Nombre: ". $row[1] ." ". $row[2]."<br></label><br>");
	 $sql1=$dbh->prepare("SELECT nombreRol, usuario.USR_UID
                          FROM usuario, rol
                          WHERE usuario.IDrol = rol.IDrol
                          AND usuario.USR_UID = ?");
			$sql1->bindParam(1,$iduser);
			$sql1->execute();
			if($sql1->rowCount()>0){
				echo("<label>Rol actual del usuario:"."</label><br>");
		    ?><table align="left">
            <?php
			 foreach($sql1->fetchAll() as $fila){
				 ?>
                 <td border="2"><?php echo "<label>". strtolower($fila["nombreRol"])."</label>";?></td>
                 <?php
				 }
				 ?>
                 </table>
                 <br>
                 <br>
               <?php
			}
			else{
				echo("<label>El usuario no tiene ningun rol asignado</label><br>");
				}
	 echo("<input type=submit value='Volver a listado de usuarios' onClick='history.back();' id=button>");
		 }
		 ?>
         <fieldset id="content">
           <legend>Listado de Permisos de acceso</legend>
          <table width="600" id="tableMenu" align="left">
                <thead>
                <tr>
                <th><label>Nombre de Menu principal</label></th>
                <th><label>Descripción del Menú</label></th>
                <th><label>Acción</label></th>
                </tr>
                </thead>
         <?php
		 $consultaMenu=$dbh->prepare("select *from menu");
		 $consultaMenu->execute();
		   if($consultaMenu->rowCount()>0){
			
			   foreach($consultaMenu->fetchAll() as $row){
				   $menu=$row["IDmenu"];
				   ?>
                   <tr>
                   <td><?php echo($row["nombreMenu"]);?></td>
                   <td><?php echo($row["descripcion"]);?></td>
                   <td><a href="<?php echo "agregapermiso.php?idusuario=$iduser&idmenu=$menu"?>" class="enlace">Asignar opciones</a></td>
                   </tr>
                   <?php
				   }
				   ?>
                   </table>
                   </fieldset>
                   <?php
			   }
		}catch(PDOException $e){
			echo "Ërror inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
?>
</body>
</html>
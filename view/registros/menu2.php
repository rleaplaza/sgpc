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
				"bPaginate":true
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
			</style>
</head>

<body>

<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	try{ $idrol=$_GET["idrol"]; 
	$sql=$dbh->prepare("select *from rol where IDrol=?");
    $sql->bindParam(1,$iddol);
	$sql->execute();
	if($sql->rowCount()>0){
	 $row=$sql->fetch();
	 $username=$row[8];
	 echo("<label>ID de Rol: " .$idrol. "<br>");
		 }
	 echo("<input type=submit value='Volver a listado de usuarios' onClick='history.back();' id=button>");
		 ?>
     
         <fieldset id="content">
         <img src="../../images/permisos.jpg" height="50" width="50">
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
                   <td><a href="<?php echo "agregapermisoRol.php?idrol=$idrol&idmenu=$menu"?>">Asignar opciones</a></td>
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
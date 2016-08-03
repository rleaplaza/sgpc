<?php  session_start();?>
<html>
<head><title>Registro de módulos</title>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableMenu").dataTable({
				"sScrollY":"200px",
				"bpaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
    
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/enlaces.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
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
	if($row){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
	}
	else{
		header("location: ../index.php");
		}
?>
     <h2><legend>MENÚS DEL SISTEMA</legend></h2>
        <img src="../images/main.jpg" width="30" height="30" />
       <table id="tableMenu" width="1200" align="left">
      <thead>
          <tr>
          <th><label>Codigo</label></th>
          <th><label>Nombre</label></th>
          <th><label>Descripcion</label></th>
          <th><label>Fecha de creacion</label></th>
          <th><label>Hora de creacion</label></th>
          <th><label></label></th>
          <th><label></label></th>
          <th><label></label></th>
          </tr>
       </thead>
       <style>
       label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	   legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	          size:auto;
		     }
	    </style>
<?php

	$sql=$dbh->prepare("select *from menu");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td align="center"><?php echo $row["0"];?></td>
     <td ><?php echo $row["1"]?></td>
     <td ><?php echo $row["2"]?></td>
     <td align="center"><?php echo $row["3"];?></td>
     <td align="center"><?php echo $row["4"];?></td>
     <td align="center"><a href="<?php echo "subMenu.php?idmenu=$row[0]"?>" class="enlace">Ver submenus</a></td>
     <td align="center"><a href="<?php echo "edit/editMenu.php?idmenu=$row[0]"?>" class="enlace">Editar</a></td>
     <td align="center"><a href="<?php echo "nuevosubMenu.php?idmenu=$row[0]";?>" class="enlace">Nuevo submenu</a></td></tr>
		<?php
		}
		?>
   
</table>

        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
		}
?>	
<?php
}
else
{ header("location: ../index.php");
	}
?>
</body>
</html>

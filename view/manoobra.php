<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registro de mano de obra</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableCargo").dataTable({
				"sScrollY":"200px",
				"bPaginate":true
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
			
		if(isset($row)){
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
   <div class="tabber" id="tab2">
<div class="tabbertab">
        <h2><legend>REGISTRO DE TRABAJADORES DE MANO DE OBRA</legend></h2>
        <img src="../images/personalproyectos.jpg" width="50" height="50" />
        <table id="tableCargo" width="814" align="left">
      <thead>
            	<tr>
           <th><label>Cédula de trabajador</label></th>
           <th><label>Cédula de encargado</label></th>
           <th><label>Nombres de trabajador</label></th>
           <th><label>Apellidos</label></th>
           <th><label>Experiencia</label></th>
           <th><label>Telefono</label></th>
           <th><label>Direccion</label></th>
           <th><label>Fecha de nacimiento</label></th>
           <th><label>Fecha de creación</label></th>
           <th></th>
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
		$sql=$dbh->prepare("select *from personalmanoobra order by ap_p");
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				?>
                <tr>
                <td><?php echo $row["CI_trabajador"];?></td>
                <td><?php echo $row["CI_encargado"];?></td>
                <td><?php echo $row["nombre"];?></td>
                <td><?php echo $row["ap_p"]." ".$row["ap_m"];?></td>
                <td><?php echo $row["experiencia"];?></td>
                <td><?php echo $row["telefono"];?></td>
                <td><?php echo $row["direccion"];?></td>
                <td><?php echo $row["fecNacimiento"]?></td>
                <td><?php echo $row["fecCreacion"]." ".$row["hraCreacion"];?></td>
                <td><a href="<?php echo "edit/editTrabajador.php?citrab=$row[CI_trabajador]";?>">Editar</a></td></tr>
                <?php
				}
		}
				?>
                </table>
                </div>
    <?php
	$query=$dbh->prepare("CALL sp_permisopagina(?,?)");
	$query->bindParam(1,$_SESSION["username"]);
	$query->bindParam(2,$_GET["idopcion"]);
	$query->execute();
	if($query->rowCount()>0){
		foreach($query->fetchAll() as $row){
			?>
       <div class="tabbertab">
       <h2><legend><?php echo($row[0]);?></legend></h2>
       <?php require_once($row[1]);?>
    </div>
    <?php
			}
	}
	?>
    </div>
    <?php
	}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
		
		}
}else{
	header("location: index.php");
	}
?>
</body>
</html>
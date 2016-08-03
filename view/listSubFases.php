<?php 
session_start();
?>
<html>
<head><title>Listado de fases por proyecto</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableFase").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
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

</head>
<body>

<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	if(isset($_POST["idopcion"])){
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();

	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label></br>");
		echo("<label>". $row["nombresubmenu"]."</label></br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($row["nombremenu"],$row["nombresubmenu"],$row["nombreopcion"]);
		}
	}else{
		header("location: ../index.php");
		}
	}
	?>
    <input type="submit" value='Volver a formulario anterior' onClick='history.back();' id="sub">
    <?php	
		if(isset($_POST["proyecto"])){
			$proyecto=$_POST["proyecto"];
			$proy=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
			$proy->bindParam(1,$proyecto);
			$proy->execute();
			$proy=$proy->fetch();
		}
?>

      <h2><legend>Listado de subfases para el proyecto:</legend><?php echo $proy["nombre"];?></h2>
        <img src="../images/proyecto.jpg" width="40" height="40" /><br>
       <table id="tableFase" width="900" align="left">
      <thead>
            	<tr>
                    <th width="20"><label>Fase</label></th>
                    <th width="20"><label>Subfase</label></th>
                    <th width="10"><label>Descripción</label></th>
                    <th width="10"><label>Fecha de registro</label></th>
                    <th width="20"></th>
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
<?php
	$sql=$dbh->prepare("SELECT fase.nombre, subfase.nombre, subfase.descripcion, subfase.IDsubfase, concat(fase.fecRegistro,' ',fase.hraRegistro) as fecha
FROM subfase, fase, proyecto
WHERE subfase.IDfase = fase.IDfase
AND fase.IDproyecto = proyecto.IDproyecto
and proyecto.IDproyecto=?
order by fecha asc");
$sql->bindParam(1,$proyecto);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$idsubfase=$row[3];
		   ?>
     <tr>
     <td><?php echo $row[0];?></td>
     <td ><?php echo $row[1];?></td>
     <td ><?php echo $row[2];?></td>
     <td ><?php echo $row[4];?></td>
     <td align="center"><a href="<?php echo("edit/editsubFase.php?idsubfase=$row[3]");?>">Editar subfase</a></td></tr>
		<?php
		}
		?>
</table>
        <?php
	
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
		}
}else{
	header("location: ../index.php");
	}

?>
</body>
</html>
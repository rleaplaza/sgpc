<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablaRequerimiento").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	#button{font-wight:bold;
		    cursor:pointer;
			padding:5px;
			color:#00F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00F;
			border-radius:8px 8px 8px 8px;
			color:#FFF;
			}
	#button:hover{
			background:#09F;
			}
</style>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");//llama a la conexión de base de datos
	$user=$_POST["user"];
	$idopcion=$_POST["idopcion"];
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
	$consulta->bindParam(1,$idopcion);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		?>
        <input type="submit" value="SALIR" onClick="history.back();" id="button"><br>
        <?php
$opcion=$_POST["opt"];
switch ($opcion){
	case "material":
	$sql=$dbh->prepare("select p.IDproyecto,p.nombre, r.nro_requerimiento,r.descripcion, fecha, hora 
	                    from proyecto as p, req_material as r
                        where p.IDproyecto=r.IDproyecto");
	$sql->execute();
	if($sql->rowCount()>0){
		?>
        <label>Requerimiento de <?php echo $opcion;?></label>
        <table id="tablaRequerimiento">
        <thead>
            <tr>
               <th><label>Proyecto</label></th>
               <th><label>Número de requerimiento</label></th>
               <th><label>Descripción</label></th>
               <th><label>Fecha</label></th>
               <th></th>
            </tr>
       </thead>
        <?php
		foreach($sql->fetchAll() as $row){
			$nro=$row[2];
			$idproyecto=$row[0];
			?>
            <tr>
            <td><?php echo $row[1];?></td>
            <td align="center"><?php echo $row[2];?></td>
            <td align="center"><?php echo $row[3];?></td>
            <td align="center"><?php echo $row[4]." ".$row[5];?></td>
            <td><a href="<?php echo "../reportes/proyectos/req_material.php?nro=$nro&user=$user&idproyecto=$idproyecto";?>"><img src="../images/pdf_1.jpg" height="30" width="30"></a></td></tr>
            <?php
			}
			?>
            </table>
            <?php
		}
	break;
	
	case "equipamiento":
	$sql=$dbh->prepare("select p.IDproyecto,p.nombre, r.nro_requerimiento,r.descripcion, fecha, hora 
	                    from proyecto as p, req_equipamiento as r
                        where p.IDproyecto=r.IDproyecto");
	$sql->execute();
	if($sql->rowCount()>0){
		?>
        <label>Requerimiento de <?php echo $opcion;?></label>
        <table id="tablaRequerimiento">
        <thead>
            <tr>
               <th><label>Proyecto</label></th>
               <th><label>Número de requerimiento</label></th>
               <th><label>Descripción</label></th>
               <th><label>Fecha</label></th>
               <th></th>
            </tr>
       </thead>
        <?php
		foreach($sql->fetchAll() as $row){
			$nro=$row[2];
			$idproyecto=$row[0];
			?>
            <tr>
            <td align="center"><?php echo $row[1];?></td>
            <td align="center"><?php echo $row[2];?></td>
            <td align="center"><?php echo $row[3];?></td>
            <td align="center"><?php echo $row[4]." ".$row[5];?></td>
            <td><a href="<?php echo "../reportes/proyectos/req_equipamiento.php?nro=$nro&user=$user&idproyecto=$idproyecto";?>"><img src="../images/pdf_1.jpg" height="30" width="30"></a></td></tr>
            <?php
			}
			?>
            </table>
            <?php
		}
	break;
	}
	}else{
		header("location: ../index.php");
		}
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
		}
}else{
	header("location: ../index.php");
	}
?>
</body>
</html>
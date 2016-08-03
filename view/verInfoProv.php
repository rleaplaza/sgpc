<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Información específica de empleados</title>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableInfoProveedor").dataTable({
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
		?>
        <img src="../images/empleado.jpg" width="50" height="50" />
        <table id="tableInfoProveedor" width="1200" align="left">
    <thead>
           	  <tr>
                  <th width="188"><label>Nombres</label></th>
                  <th width="188"><label>Apellidos</label></th>
                  <th width="188"><label>Cédula de identidad</label></th>
                  <th width="185"><label>Empresa proveedora</label></th>
                  <th width="185"><label>Dirección</label></th>
                  <th width="185"><label>Teléfonos</label></th>
                  <th width="185" align="center"><label>Fecha de registro</label></th>
                  <th width="185" align="center"><label></label></th>
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
		$consulta=$dbh->prepare("select *from proveedor order by nombres");
		$consulta->execute();
		foreach($consulta->fetchAll() as $row){
			$IDprov=$row["IDproveedor"];
			?>
            <tr>
     <td><?php echo $row["nombres"];?></td>
     <td><?php echo $row["app"]." ".$row["apm"];?></td>
     <td><?php echo $row["CI"];?></td>
     <td><?php echo $row["empProveedora"];?></td>
     <td><?php echo $row["dirEmpresa"];?></td>
     <td><?php echo $row["telefonos"];?></td>
     <td><?php echo $row["fecRegistro"]." ".$row["hraRegistro"];?></td> 
     <td><a href="<?php echo("editProv.php?idprov=$IDprov");?>">Editar</a></td>     
    </tr>

    <?php		
		}
		?>
        </table>
        <?php
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}
	else{
		header("location: ../index.php");
		}
?>
</body>
</html>
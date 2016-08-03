<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Información específica de empleados</title>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableInfoEmployee").dataTable({
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
        <table id="tableInfoEmployee" width="1200" align="left">
    <thead>
           	  <tr>
                  <th width="188"><label>Nombre de empleado</label></th>
                  <th width="185"><label>Fecha de ingreso a la empresa</label></th>
                  <th width="185"><label>Cargo</label></th>
                  <th width="185"><label>Departamento</label></th>
                  <th width="185"><label>Profesión</label></th>
                  <th width="185" align="center"><label>Salario Básico</label></th>
                  <th width="185" align="center"><label>Años en la empresa</label></th>
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
		$consulta=$dbh->prepare("SELECT empleado.nombres, app, apm, fecIngreso, cargo.nombre AS cargo, departamento.nombre AS                                 departamento, profesion.nombre AS profesion, haberBasico, aniosTrabajo
                                 FROM empleado, cargo, departamento, profesion
                                 WHERE empleado.IDcargo = cargo.IDcargo
                                 AND empleado.IDdepto = departamento.IDdepto
                                 AND empleado.IDprofesion = profesion.IDprofesion");
		$consulta->execute();
		foreach($consulta->fetchAll() as $row){
			?>
            <tr>
     <td><?php echo $row[0]." ".$row[1]." ".$row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td><?php echo $row[5];?></td>
     <td><?php echo $row[6];?></td>
     <td><?php echo $row[7];?></td>
     <td><?php echo $row[8];?></td>      
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
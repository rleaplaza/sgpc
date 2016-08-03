<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	          color:#009;
	           size:auto;
				 }
			</style>
            <script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableControl").dataTable();
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
<link href="../css/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<legend>Control de permisos de empleados</legend>
<table id="tableControl" width="514" align="left">
    <thead>
           	  <tr>
                  <th width="188"><label>Nombre</label></th>
                  <th width="185"><label>Ap. Paterno</label></th>
                  <th width="185"><label>Ap. Materno</label></th>
                  <th width="185"><label>Cargo</label></th>
                  <th width="185"><label>Departamento</label></th>
                  <th width="185"><label>Fecha de registro</label></th>
                  <th width="185"><label>Motivo</label></th>
                  <th width="185"><label>Observaciones</label></th>
                  <th width="185"><label>Desde</label></th>
                  <th width="185"><label>Hasta</label></th>
                  <th width="185"><label>Estado</label></th>
                  <th width="185"><label>Acciones</label></th>
                  
              </tr>
    </thead>
<?php
if(isset($_SESSION["username"])){
	try{
		require_once("../db/connect.php");
		$consulta=$dbh->prepare("SELECT c.IDcontrol, e.IDempleado, u.nombre, app, apm, cg.nombre, d.nombre, fechaPermiso,                                 motivo, observaciones, desde, hasta,c.estado
                                 FROM usuario AS u, empleado AS e, cargo AS cg, departamento AS d, controlpermiso AS c
                                 WHERE u.USR_UID = e.USR_UID
                                 AND e.IDcargo = cg.IDcargo
                                 AND e.IDdepto = d.IDdepto
                                 AND e.IDempleado = c.IDempleado");
		$consulta->execute();
		if($consulta->rowCount()>0){
			foreach($consulta->fetchAll() as $row){
				$idcontrol=$row[0];
				$idemp=$row[1];
				?>
             <tr>
             <td><?php echo $row[2];?></td>
             <td><?php echo $row[3];?></td>
             <td><?php echo $row[4];?></td>
             <td><?php echo $row[5];?></td>
             <td><?php echo $row[6];?></td>
             <td><?php echo $row[7];?></td>
             <td><?php echo $row[8];?></td>
             <td><?php echo $row[9];?></td>
             <td><?php echo $row[10];?></td>
             <td><?php echo $row[11];?></td>
             <td><?php echo $row[12];?></td>
             <td><a href="<?php echo "registros/viewControl.php?idcontrol=$row[0]&idemp=$row[1]"?>">Gestionar control</a></td>
             </tr>
                <?php
				}
			}
			?>
            </table>
            <?php
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
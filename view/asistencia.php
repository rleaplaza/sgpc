<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"><title>Documento sin título</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableAsistencia").dataTable();
        });
   </script>
   <style type="text/css">
		body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
	    .big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
        label{ font:Verdana, Geneva, sans-serif;
		     color:#00C;
	         }
	    legend{font:Verdana, Geneva, sans-serif;
	       color:#009;
	        size:auto;
		 }
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
	if(isset($_GET["idopcion"])){
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
		        echo("<label>Menu: <b>".$row["nombremenu"]."</b></label> ");
				echo("<label>Submenu: <b>". $row["nombresubmenu"]."</b></label> ");
				echo("<label>Opcion: <b>".$row["nombreopcion"]."</b></label>");
			   }
		      if(isset($row)){
		       $nombMenu=$row["nombremenu"];
		       $nombSubmenu=$row["nombresubmenu"];
		       $nombOpcion=$row["nombreopcion"];
		       //regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		       }
			   ?>
                
  <div class="tabber" id="tab2">
  <div class="tabbertab">
  <h2><legend>REGISTRO DE ASISTENCIA</legend></h2>
 <img src="../images/asistencia.jpg" width="50" height="50" />
  <table id="tableAsistencia" width="124" align="left">
  <thead>
        <tr>
                  <th width="188"><label>Nombre</label></th>
                  <th width="185"><label>Apellidos</label></th>
                  <th width="185"><label>Cédula</label></th>
                  <th width="185"><label>Username</label></th>
                  <th width="185"><label>Cargo</label></th>
                  <th width="185"><label>Departamento</label></th>
                  <th width="185"><label>Fecha de registro</label></th>
                  <th width="185"><label>Hora de ingreso</label></th>
                  <th width="185"><label>Hora de salida</label></th>
                  <th width="185"><label>Horas trabajadas</label></th>
                  <th width="185"><label>Acciones</label></th>
        </tr>
  </thead>
  <?php
   $sql=$dbh->prepare("select u.IDempleado,u.nombre, app, apm, CI, username, c.nombre, d.nombre, fecha, hraEntrada, hraSalida,                        tiempo_trabajado_hras, leyenda, turno
                       from usuario as u, empleado as e, cargo as c, departamento as d, asistencia as a
                       where u.USR_UID=e.USR_UID
                       and e.IDcargo=c.IDcargo
                       and e.IDdepto=d.IDdepto
                       and e.IDempleado=a.IDempleado
                       and u.username!=?");
	$sql->bindParam(1,$_SESSION["username"]);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$idempleado=$row[0];
		?>
	 <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td><?php echo $row[5];?></td>
     <td><?php echo $row[6];?></td>
     <td><?php echo $row[7];?></td>
     <td><?php echo $row[8];?></td>
     <td><?php echo $row[9];?></td>
     <td><?php echo $row[10]?></td> 
     <td><a href="<?php echo "regAsistencia.php?idempleado=$row[0]";?>">Actualizar hora de salida</a></td>     
    </tr>	
        <?php
	}
  ?>
  </table>
  </div>
  <?php
  $query=$dbh->prepare("SELECT pagina_opcion.nombre, pagina_opcion.url
                     FROM opcion, pagina_opcion, permiso_pagina, usuario
                     WHERE opcion.IDopcion = pagina_opcion.IDopcion
                      AND pagina_opcion.IDpagina = permiso_pagina.IDpagina
                      AND permiso_pagina.USR_UID = usuario.USR_UID
                      AND username=?
                      AND opcion.IDopcion=?
                      and permiso_pagina.estado='activo'
					  order by pagina_opcion.nombre ASC");
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
               
			}catch(PDOExeption $e){
				echo "Error inesperado".$e->getMessage();
			
			}
		}else{
			header("location:../index.php");
			}
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestión de permisos</title>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" src="../js/js.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablepermiso").dataTable({
				"sScrollY":"200px",
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

</head>
<body>
<img src="../images/permisos.jpg" width="50" height="50" />
       <table id="tablepermiso" width="800" align="left">
      <thead>
            	<tr>
                    <th width="188"><label>Codigo de opcion</label></th>
                    <th width="185"><label>Nombre de opcion del permiso</label></th>
                    <th width="185"><label>Estado del permiso</label></th>
                    <th width="185"><label>Fecha de asignacion</label></th>
                    <th width="185"><label>Hora de asignación</label></th>
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
if(isset($_SESSION["username"])){ 
try{ 
include("../db/connect.php");
$sql=$dbh->prepare("SELECT opcion.IDopcion, nombreopcion, permiso.estado, fecha_asignacion, hraAsignacion
                    FROM opcion, permiso, usuario
                    WHERE opcion.IDopcion = permiso.IDopcion
                    AND permiso.USR_UID = usuario.USR_UID
                    and username=?");
		$sql->bindParam(1,$_SESSION["username"]);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchall() as $row){
				?>
                <tr>
     <td><?php echo ($row[0]);?></td>
     <td><?php echo ($row[1]);?></td>
     <td><?php echo ($row[2]);?></td>
     <td><?php echo ($row[3]);?></td>
     <td><?php echo ($row[4]);?></td>
     </tr>
                <?php
				}
				?>
                </table>
                <?php
			}	
	}catch(PDOException $e){
	echo("Error".$e->getMessage());
	}
}
else{
	header("location: index.php");
	}
 ?>
</body>
</html>
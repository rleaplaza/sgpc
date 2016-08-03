<?php session_start();?>
<html>
<head><meta charset="utf-8"><title>Log de auditoría</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableAuditoria").dataTable({
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
	require_once("../db/connect.php");
	try{ 
	if(isset($_GET["idopcion"])){
		$user=$_SESSION["username"];
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                             from menu, submenu, opcion
							     where menu.IDmenu=submenu.IDmenu
							     and submenu.IDsubmenu=opcion.IDsubmenu
							     and opcion.IDopcion=?");
        $consulta->bindParam(1,$_GET["idopcion"]);
	    $consulta->execute();
	   if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"] ."</label><br>");
		echo("<label>" . $row["nombresubmenu"] . "</label><br>");
		echo("<label>" .$row["nombreopcion"] . "</label></p>");
		}
	?>
<div class="tabber" id="tab2">
<div class="tabbertab">
 <table id="tableAuditoria" width="514" align="left">
    <thead>
           	  <tr>
                  <th width="188"><label>User ID</label></th>
                  <th width="188"><label>Usernane</label></th>
                  <th width="185"><label>Rol de usuario</label></th>
                  <th width="185"><label>Fecha de ingreso</label></th>
                  <th width="185"><label>Hora de ingreso</label></th>
                  <th width="185"><label>IP de acceso</label></th>
                  <th width="185"><label>Menu</label></th>
                  <th width="185"><label>Submenu</label></th>
                  <th width="185"><label>Opción</label></th>
                  <th width="185"><label>Navegador Web</label></th>
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
    <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="Para realizar la búsqueda de log de auditoria, ir a la caja de texto search y escribir la palabra para encontrar el registro específico, la búsqueda se realiza mediante las columnas referenciadas del listado. Para realizar la paginación del listado, presionar el enlace next ubicado en la parte inferior derecha del listado, presionar previous para volver. Para cambiar de página presionar las pestañas debajo de esta imagen.
Para imprimir el log de auditoria en informe presionar las imagenes PDF Y EXCEL"/>
<h2><legend>LOG DE AUDITORIA</legend></h2>
<img src="../images/auditoria.png" width="30" height="30"/>
  <a href="<?php echo "../reportes/administracion/repAuditoria.php?user=$user"?>" target="_blank"><img src="../images/pdf_1.jpg" width="30" height="30" title="Exportar PDF"/></a>
  <a href="../reportes/administracion/excel/repAuditoriaXls.php" target="_blank"><img src="../images/excel2013.png" width="30" height="30" title="Imprimir en Excel"/></a><br>
    <?php
	$sql=$dbh->prepare("select *from auditoria");
	$sql->execute();
		foreach($sql->fetchAll() as $row){
			?>
            <tr>
            <td><?php echo $row["USR_UID"];?></td>
            <td><?php echo $row["username"];?></td>
            <td><?php echo $row["rol_usuario"];?></td>
            <td><?php echo $row["fecha_ingreso"];?></td>
            <td><?php echo $row["hra_ingreso"];?></td>
            <td><?php echo $row["IPterminal"];?></td>
            <td><?php echo $row["Menu"];?></td>
            <td><?php echo $row["Submenu"];?></td>
            <td><?php echo $row["Opcion"];?></td>
            <td><?php echo $row["navegador_web"];?></td>
            </tr>
            <?php
			}
			?>
            </table>
            </div>
            <?php 
	}
	else{
		header("location: ../index.php");
		}
		}catch(PDOException $e){
			echo("Error inesperdo".$e->getMessage());
			}
	}
	else{
		header("location: ../index.php");
		}
?>
</body>
</html>
<?php 
session_start();
?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
        <script type="text/javascript" src="../js/ajaxgr.js"></script>

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
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_POST["idopcion"];
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
		else{
			header("location: ../index.php");
			}
	}
?>
      <h2><legend>TRABAJADORES PARA EL PROYECTO</legend></h2>
       <img src="../images/hras.jpg" width="30" height="30" /><br>
      <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
       
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Cédula</label></th>
                    <th><label>Nombre completo</label></th>
                    <th><label>Cargo</label></th>
                    <th></th>
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
		    #button{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#00F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
					 #button1{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#060;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
			#button1:hover{
					background:#ddd;
					}
			</style>
<?php
$idproyecto=$_POST["proyecto"];
	$sql=$dbh->prepare("SELECT pm.CI_trabajador, pm.nombre, pm.ap_p, pm.ap_m, c.nombre
                        FROM personalmanoobra AS pm, participa AS pt, proyecto AS p, cargomanodeobra AS c
                        WHERE pm.IDcargoM = c.IDcargoM
                        AND pm.CI_trabajador = pt.CI_trabajador
                        AND pt.IDproyecto = p.IDproyecto
						and p.IDproyecto=?
                        ORDER BY c.nombre asc");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$trabajador=$row[1]." ".$row[2]." ".$row[3];//concatenación de nombre completo
		$cargo=$row[4];//almacena el nombre
		   ?>
     <tr>
     <td><?php echo $row[0];?></td>
     <td><?php echo $row[1]." ".$row[2]." ".$row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td align="center"><button id="button" onClick="calendario('<?php echo $row[0];?>','<?php echo $idopcion;?>','<?php echo $trabajador;?>','<?php echo $cargo;?>')">Definir horario</button></td>
     <td align="center"><button id="button1" onClick="consultaCalendario('<?php echo $row[0];?>','<?php echo $idopcion;?>','<?php echo $cargo;?>')">Consultar horario</button></td></tr>
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
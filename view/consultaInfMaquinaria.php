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
	$query=$dbh->prepare("select nombreActividad from actividad where IDactividad=?");
	$query->bindParam(1,$_GET["idactividad"]);
	$query->execute();
	$reg=$query->fetch();
	$actividad=$reg[0];
	$descripcion=$_GET["descripcion"];
?> <img src="../images/tareas.jpg" width="40" height="40" /><img src="../images/maquinaria1.jpg" height="40" width="40">
      <h2><legend>INFORME DE AVANCES MAQUINARIA </legend><?php echo $descripcion;?></h2>
      <label>ACTIVIDAD </label><?php echo $actividad;?>
       
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha de Registro</label></th>
                    <th><label>Avance Informado</label></th>
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
			color:#F00;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
			</style>
<?php
$idmaquinaria=$_GET["idmaquinaria"];//captura el id de maquinaria
#consulta de avance informado, unidad de avance y fecha de registro
	$sql=$dbh->prepare("select im.avance_informado, unidad_avance, im.fecha
FROM actividad AS a, informemaquinaria AS im, maquinaria AS maq
WHERE a.IDactividad = im.IDactividad
AND im.IDmaquinaria = maq.IDmaquinaria
AND maq.IDmaquinaria = ?");
	$sql->bindParam(1,$idmaquinaria);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td align="center"><?php echo $row[2];?></td>
     <td align="center"><?php echo $row[0]." ".$row[1];?></td>
     </tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una excepción en caso de que la conexión falle
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
<?php session_start();///función de inicio de sesión
?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//función de la tabla
				"sScrollY":"250px",//habilita el scroll horizontal
				"bPaginate":true,//habilita la paginación
				"oLanguage":{//archivo de traducción al idioma castellano
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
?>
      <h2><legend>INFORME DE AVANCES DEl TRABAJADOR</legend><?php echo $_GET["nombre"];?></h2>
        <img src="../images/tareas.jpg" width="40" height="40" />
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha de avance</label></th>
                    <th><label>Actividad</label></th>
                    <th><label>Horas trabajadas</label></th>
                    <th><label>Avance informado</label></th>
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
$ci=$_GET["ci"];//captura la cédula del trabajador
#consulta del nombre de actividad, unidad de trabajo, horas trabajadas, unidad de avance
	$sql=$dbh->prepare("select nombreActividad, unidad_trabajo,total_horas,unidad_avance,avance_informado,fechaAvance,i.hraRegistro
                        from actividad as a, informetrabajador as i
                        where a.IDactividad=i.IDactividad
                        and CI_trabajador=?");
	$sql->bindParam(1,$ci);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td align="center"><?php echo $row[5]." ".$row[6];?></td>
     <td align="center"><?php echo $row[0];?></td>
     <td align="center"><?php echo $row[2]." ".$row[1];?></td>
     <td align="center"><?php echo $row[4]." ".$row[3];?></td>
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
{ header("location: ../index.php");//redirige al usuario en caso de que no se cumpla la condición de acceso
	}
?>
</body>
</html>
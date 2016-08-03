<?php 
session_start();
?>
<html>
<!--Este programa se encarga de mostrar la consulta de consumo de materiales -->
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//función para la tabla
				"sScrollY":"250px",//habilita el scroll vertical
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
if(isset($_SESSION["username"])){//verifica que la sesión exista
	try{
	require_once("../db/connect.php");//llama a la conexión de base de datos
	#consulta para recuperar la descripción del material
	$consulta=$dbh->prepare("select descripcion from material where IDmaterial=?");
	$consulta->bindParam(1,$_GET["idmaterial"]);//enlaza el id del material
	$consulta->execute();//ejecuta la consulta
	$res=$consulta->fetch();
	$material=$res[0];
	#consulta para recuperar el nombre de la actividad
	$query=$dbh->prepare("select nombreActividad from actividad where IDactividad=?");
	$query->bindParam(1,$_GET["idactividad"]);
	$query->execute();
	$reg=$query->fetch();
	$actividad=$reg[0];
?> <img src="../images/tareas.jpg" width="40" height="40" /><img src="../images/materiales.jpg" height="40" width="40">
      <h2><legend>INFORME DE USO DEL MATERIAL </legend><?php echo $material;?></h2>
      <label>ACTIVIDAD </label><?php echo $actividad;?>
       
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha de Registro</label></th>
                    <th><label>Cantidad utilizada</label></th>
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
$unidadTrabajo=$_GET["unidadTrabajo"];//captura la unidad de trabajo del material
#consulta para recuperar la cantidad usada y la fecha de registro para l actividad
	$sql=$dbh->prepare("select cantidad_usada,fechaRegistro from actividad,informematerial
	                    where actividad.IDactividad=informematerial.IDactividad
						and actividad.IDactividad=?");
	$sql->bindParam(1,$_GET["idactividad"]);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		//el arreglo despliega los campos cantidad usada y fecha de registro
		   ?>
     <tr>
     <td align="center"><?php echo $row[1];?></td>
     <td align="center"><?php echo $row[0]." ".$unidadTrabajo;//concatena la unidad de trabajo?></td>
     </tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una excepció en caso de que la conexión falle
		}
?>	
<?php
}
else
{ header("location: ../index.php");//redirige al login en caso de no tener el permiso de acceso
	}
?>
</body>
</html>
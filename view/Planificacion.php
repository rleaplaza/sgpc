<?php session_start();?>
<html>
<head><meta charset="utf-8"><title>Registro de usuarios</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/ajaxgr.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableproyecto").dataTable({//función para convertir la tabla html usando el id de la misma
				"sScrollY":"200px",//habilita el scroll vertical
				"bPaginate":true,//habilita la paginación
				"oLanguage":{//dirección que traduce al idioma castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
   </script>
   <!--Los estilos definen mejor apariencia al texto, botones para indicar al usuario cuando selecciona opciones -->
   <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  text-align:center;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	          color:#009;
	           size:auto;
				 }
				 #button{
				
				font-wight:bold;
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
		</style>
        <!--Las hojas de estilo datatables, demo, jquery, example brinda mejor apariencia a las interfaces que las incluyan -->
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");//archivo de conexión a la base de datos
	require_once("registros/regAuditoria.php");//registro del log de auditoría
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");//consulta para el programa donde se está navegando
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al id de opción
	$consulta->execute();//ejecuta la intrucción

	if($consulta->rowCount()>0){
		$idopcion=$_GET["idopcion"];
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]. " </label><br>");
		echo("<label> ".$row["nombreopcion"]. "</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//envía los parámetros del programa para registrar el log de auditoría
		}
	}
	else{
		header("location: ../index.php");
		}
	?>
  <h2><legend>PLANIFICACIÓN DE PROYECTOS</legend></h2>
  <img src="../images/proyecto.jpg" width="30" height="30" />
  <table id="tableproyecto" width="1300" align="left">
    <thead>
           	  <tr>
                  <th width="185"><label>Nombre</label></th>
                  <th width="185"><label>Tipo de convocatoria</label></th>
                  <th width="185"><label>Responsable</label></th>
                  <th width="185"><label>Fecha de Inicio</label></th>
                  <th width="185"><label>Fecha de finalización</label></th>
                  
                  <th width="185"><label>Estado actual</label></th>
                  <th width="185"><label>Costo total BS</label></th>
                  <th width="185"><label>Fecha de registro</label></th>
                  <th width="185"><label>Hora de registro</label></th>
                  <th width="185"></th>
                  <th width="185"></th>
                  
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

	$sql=$dbh->prepare("select IDproyecto, nombre, descripcion, responsable, fecInicio, fecFinal, estado,totalProyecto, fecRegistro, hraRegistro from proyecto, licitacion where proyecto.IDlicitacion=licitacion.IDlicitacion");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$id=$row[0];
		   ?>
           <style type="text/css">
		      p{font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
				  }
		   </style>
    <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php $ci=$row[3];
	           $query=$dbh->prepare("SELECT concat( nombres, ', ', app, ' ,', apm ) AS empleado
                                     FROM empleado
                                     WHERE CI=?");
	           $query->bindParam(1,$ci);
			   $query->execute();
			   $res=$query->fetch();
			   echo $res[0];?></td>
     <td align="center"><?php echo $row[4];?></td>
     <td align="center"><?php echo $row[5];?></td>
     <td align="center"><?php echo $row[6];?></td>
     <td align="center"><?php echo $row[7];?></td> 
     <td align="center"><?php echo $row[8];?></td>
     <td align="center"><?php echo $row[9];?></td>  
     <td><a href="<?php echo "listplan.php?idproy=$row[0]&idopcion=$idopcion"?>">Formulario de planificación</a></td>
     <td><button id="button" onclick="consultaPlan('<?php echo $id;?>','<?php echo $idopcion;?>')">Consultar planificaciones</button>    
    </tr>
	<?php
		}
		?>
</table>

<?php
}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
		}
		?>
        <iframe id="work" width="1333" height="150" frameborder="0"></iframe>
        <?php
}
else
{ header("location: ../index.php");
	}
?>
</body>
</html>
<?php session_start();?>
<html>
<head><meta charset="utf-8"><title>Registro de usuarios</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript" src="../js/fechaCastellano.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableproyecto").dataTable({
				"sScrollY":"200px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
   </script>
   <script type"text/javascript">
		var fun = function (param) {
			var idproy = param;
			ajaxFace = new LightFace.Request({
				url: 'finalizarproyecto.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						IDproyecto: idproy || 'Id de opcion no ingresado',
					},
					method: 'post'
				},
				title: 'Fin del proyecto'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
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


<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
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
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
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
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();

	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
	}
	else{
		header("location: ../index.php");
		}
	?>
<div class="tabber" id="tab2">
<div class="tabbertab">
  <h2><legend>REGISTRO DE PROYECTOS</legend></h2>
  <img src="../images/proyecto.jpg" width="30" height="30" />
  <table id="tableproyecto" width="1300" align="left">
    <thead>
           	  <tr>
                  <th width="185"><label>Nombre</label></th>
                  <th width="185"><label>Tipo de convocatoria</label></th>
                  <th width="185"><label>Departamento</label></th>
                  <th width="185"><label>Responsable</label></th>
                  <th width="185"><label>Desde - Hasta</label></th>
                  <th width="185"><label>Duración en días</label></th>
                  
                  <th width="185"><label>Estado actual</label></th>
                  <th width="185"><label>Costo total BS</label></th>
                  <th width="185"><label>Porcentaje de progreso</label></th>
                  <th width="185"><label>Fecha de registro</label></th>  
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

	$sql=$dbh->prepare("select IDproyecto, 
	                           proyecto.nombre, 
							   licitacion.descripcion, 
							   departamentos.nombre as departamento, 
							   responsable, 
							   fecInicio, 
							   fecFinal,
							   duracion_programada, 
							   estado,
							   totalProyecto,
							   porcentaje_progreso, 
							   fecRegistro, 
							   hraRegistro 
							   from proyecto, 
							   departamentos,
							   licitacion 
							   where proyecto.IDlicitacion=licitacion.IDlicitacion 
							   and departamentos.IDdepa=proyecto.IDdepa ");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$id=$row[0];
		   ?>
           <style type="text/css">
		      p{font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
				  }
		   </style>
    <tr>
     <td><?php echo $row["nombre"];?></td>
     <td><?php echo $row["descripcion"];?></td>
     <td><?php echo $row["departamento"];?></td>
     <td><?php $ci=$row[4];
	           $query=$dbh->prepare("SELECT concat( nombres, ', ', app, ' ,', apm ) AS empleado
                                     FROM empleado
                                     WHERE CI=?");
	           $query->bindParam(1,$ci);
			   $query->execute();
			   $res=$query->fetch();
			   echo $res["empleado"];?></td>
     <td align="center"><?php echo $row["fecInicio"]." ".$row["fecFinal"];?></td>
     <td align="center"><?php echo $row["duracion_programada"];?></td>
     <td align="center"><?php echo $row["estado"];?></td> 
     <td align="center"><?php echo $row["totalProyecto"];?></td>
     <td align="center"><?php echo $row["porcentaje_progreso"];?></td>  
      <td align="center"><?php echo $row["fecRegistro"]." ".$row["hraRegistro"];?></td>  
    </tr>
	<?php
		}
		?>
</table>
</div>  
<?php 
$query=$dbh->prepare("CALL sp_permisopagina(?,?)");
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
?>
        
</div>
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
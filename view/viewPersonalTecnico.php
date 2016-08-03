<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Información específica de empleados</title>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablePersonalTec").dataTable({
				"sScrollY":"200px",
				"bPaginate":true
				});
        });
   </script>
  
<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var ci = param;
			ajaxFace = new LightFace.Request({
				url: 'registros/setResponsable.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						ciEmp: ci || 'cedula no ingresada',
						nombProyecto:document.id('nombreProyecto').value || 'nombre de proyecto no ingresado'
					},
					method: 'post'
				},
				title: 'Asignacion de responsable de proyectos'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
	</script>
   <script type"text/javascript">
//Activar permiso
		var fun1 = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var ci = param;
			ajaxFace = new LightFace.Request({
				url: 'delete/deleteResponsable.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						ciEmp: ci || 'cedula no ingresada',
						nombProyecto:document.id('nombreProyecto').value || 'nombre de proyecto no ingresado'
					},
					method: 'post'
				},
				title: 'Asignacion de responsable de proyectos'
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
                

</head>

<body>
<?php
if(isset($_SESSION["username"])){
	try{
		require_once("../db/connect.php");
		?>
        <img src="../images/personalproyectos.jpg" width="50" height="50" />
        <table id="tablePersonalTec" width="1200" align="left">
    <thead>
           	  <tr>
                  <th width="188"><label>Nombre de empleado</label></th>
                  <th width="188"><label>Cédula de identidad</label></th>
                  <th width="188"><label>Cargo</label></th>
                  <th width="188"><label>Proyecto</label></th>
                  <th width="185"><label>Fecha de designación</label></th>
                  <th width="185"><label>Hora de designación</label></th>
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
				 #button{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#093;
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
			color:#F00;
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
		$consulta=$dbh->prepare("SELECT e.nombres, app, apm, e.CI, c.nombre,p.nombre, fechaDesignacion, hraDesignacion
                                 FROM empleado AS e, personaltecnico AS pt, proyecto AS p, cargo as c
                                 WHERE e.IDempleado = pt.IDempleado
								 and e.IDcargo=c.IDCargo
                                 AND pt.IDproyecto = p.IDproyecto");
		$consulta->execute();
		foreach($consulta->fetchAll() as $row){
			$nombreProyecto=$row[5];
			$ci=$row[3];
			?>
            <tr>
     <td><?php echo $row[0]." ".$row[1]." ".$row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td><?php echo $row[5];?></td>
     <td align="center"><?php echo $row[6];?></td>
     <td align="center"><?php echo $row[7];?></td>  
    </tr>

    <?php		
		}
		?>
        </table>
        <?php
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}
	else{
		header("location: ../index.php");
		}
?>
</body>
</html>
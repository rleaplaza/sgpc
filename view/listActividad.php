<?php 
session_start();
?>
<html>
<head><title>Listado de fases por proyecto</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableFase").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var ci = param;
			ajaxFace = new LightFace.Request({
				url: 'consultas/consultaSolicitante.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						cedula: ci || 'Id de rol no ingresado',
					},
					method: 'post'
				},
				title: 'Consulta de solicitante de mano de obra'
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
<link href="../css/reveal.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
	?>
    <?php	
		if(isset($_GET["idsubfase"])){
			$idsubfase=$_GET["idsubfase"];
			$subfase=$dbh->prepare("select nombre from actividad where IDsubfase=?");
			$subfase->bindParam(1,$idsubfase);
			$subfase->execute();
			
			$res=$subfase->fetch();

?>

      <h2><legend>Listado de actividades para la subfase:</legend><?php echo $res["nombre"];?></h2>
        <img src="../images/gant.jpg" width="60" height="60" /><br>
       <table id="tableFase" width="900" align="left">
      <thead>
            	<tr>
                    <th width="20"><label>Nombre</label></th>
                    <th width="10"><label>Unidad de recorrido</label></th>
                    <th width="5"><label>Cantidad</label></th>
                    <th width="5"><label>Precio unitario</label></th>
                    <th width="5"><label>Costo total</label></th>
                    <th width="5"><label>Fecha de inicio</label></th>
                    <th width="5"><label>Fecha de finalización</label></th>
                    <th width="5"><label>Duración</label></th>
                    <th width="5"><label>Estado</label></th>
                    <th width="5"><label>Aprobado</label></th>
                    <th width="5"><label>Fecha de registro</label></th>
                    <th width="10"></th>
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
			</style>      
<?php
	$sql=$dbh->prepare("select IDactividad, nombreActividad, unidades, cantidad,precioUnitarioBS,costo_total,fechaRealizacion, fechaFin,duracion,estado, aprobado, fecRegistro,hraRegistro from subfase as s, actividad as a
	where s.IDsubfase=a.IDsubfase
	and s.IDsubfase=?");
$sql->bindParam(1,$idsubfase);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$idactividad=$row[0]
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td align="center"><?php echo $row[2];?></td>
     <td align="center"><?php echo $row[3];?></td>
     <td align="center"><?php echo $row[4];?></td>
     <td align="center"><?php echo $row[5];?></td>
     <td align="center"><?php echo $row[6];?></td>
     <td align="center"><?php echo $row[7];?></td>
     <td align="center"><?php echo $row[8];?></td>
     <td align="center"><?php echo $row[9];?></td>
     <td align="center"><?php echo $row[10];?></td>
     <td align="center"><?php echo $row[11]." ". $row[12];?></td>
     <td align="center"><a href="<?php echo("edit/editActividad.php?idactividad=$idactividad");?>" >Editar</a></td></tr>
		<?php
		}
		?>
</table>
        <?php
		}else{
			header("location: ../index.php");
			}
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
		}
}else{
	header("location: ../index.php");
	}

?>
</body>
</html>
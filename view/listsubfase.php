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
    <input type="submit" value='Volver al listado anterior' onClick='history.back();' id="button">
    <?php	
		if(isset($_GET["idfase"])){
			$idfase=$_GET["idfase"];
			$fase=$dbh->prepare("select nombre from subfase where IDfase=?");
			$fase->bindParam(1,$idfase);
			$fase->execute();
			
			$fase=$fase->fetch();

?>

      <h2><legend>Listado de subfases para la fase:</legend><?php echo $fase["nombre"];?></h2>
        <img src="../images/gant.jpg" width="60" height="60" /><br>
       <table id="tableFase" width="900" align="left">
      <thead>
            	<tr>
                    <th width="20"><label>Fase</label></th>
                    <th width="10"><label>Subfase</label></th>
                    <th width="5"><label>Descripción de subfase</label></th>
                    <th width="10"></th>
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
$idproy=$_GET["idproy"];
	$sql=$dbh->prepare("SELECT IDsubfase, f.nombre, sf.nombre, sf.descripcion
                        FROM fase AS f, subfase AS sf
                         WHERE f.IDfase = sf.IDfase
						 and f.IDfase=?");
$sql->bindParam(1,$idfase);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$idsubfase=$row[0]
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td align="center"><?php echo $row[2];?></td>
     <td align="center"><?php echo $row[3];?></td>
     <td align="center"><a href="<?php echo("formActividad.php?idsubfase=$idsubfase&idproy=$idproy");?>" >Nueva actividad</a></td>
     <td align="center"><a href="<?php echo("listActividad.php?idsubfase=$idsubfase");?>">Listado de actividades</a></td></tr>
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
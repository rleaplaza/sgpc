<?php ob_start();?>
<?php
require_once("../../db/connect.php");
require_once("../../view/hora.php");
$user=$_GET["user"];
?>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<h2><legend>INFORMACIÓN DE LA ACTIVIDAD</legend></h2>
 USUARIO: <?php echo strtoupper($user);?><br>
 FECHA: <?php echo $fecha=getFecha();?>
<style>
table{
		border-radius:10px;
		box-shadow:0px 0px 13px  rgba(0,0,0,0.5);
		-web-kit-box-shadow:0px 0px 13px rbga(0,0,0,0.5);
	}
table td{
	    width:100%;
		border:5 px solid rgba(0,0,0,0,5);
		border-radius:5px;
		border:1px;
		}
table th{
	    border-radius:5px;
		border:1px;
		backbround:rgba(156,184,121,0.2);
	}
	legend, label{
		 color:#00C;
		}
</style>
<?php 
$UIDfase=$_GET["idactividad"];
$sql=$dbh->prepare("select *from actividad where IDactividad=?");
	$sql->bindParam(1,$UIDfase);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		$costo_programado=$row["costo_programado"];
		$costo_real=$row["costo_total"];
		#asignación de avances
		$cantidad_programada=$row["cantidad"];
		$avance_real=$row["total_avance"];
		#almacena el porcentaje de progreso de la actividad
		$progreso=($avance_real*100)/$cantidad_programada;
		$progreso=round($progreso,2);
		$variacion=$cantidad_programada-$avance_real;
		$variacion_costo=$costo_programado-$costo_real;
		$unidades=$row["unidades"];
		$actividad=$row["nombreActividad"];
		$estado=$row["finalizado"];
?>
<table align="left" border="2" id="tableProyecto" width="500">
      <tr><td><label>Actividad</label></td><td><?php echo $actividad;?></td></tr>
  	  <tr><td><label>Fecha de inicio</label></td><td><?php echo $row["fechaRealizacion"];?></td></tr>
      <tr><td><label>Fecha de inicio</label></td><td><?php echo $row["fechaFin"];?></td></tr>
      <tr><td><label>Duración programada</label></td><td><?php echo $row["duracion_dias"]." dias";?></td></tr>
      <tr><td><label>Cantidad programada</label></td><td><?php echo $cantidad_programada." ".$unidades;?></td></tr>
      <tr><td><label>Avance real</label></td><td><?php echo $avance_real." ".$unidades;?></td></tr>
      <tr><td><label>Costo programado</label></td><td><?php echo $costo_programado. " Bs";?></td></tr>
      <tr><td><label>Costo real</label></td><td><?php echo $costo_real. " Bs";?></td></tr>
      <tr><td><label>Diferencia de costos</label></td><td><?php echo $variacion_costo." Bs";?></td></tr>
      <tr><td><label>Porcentaje de progreso</label></td><td><?php echo $progreso." %";?></td></tr>
      <tr><td><label>Estado</label></td><td><?php echo $estado;?></td></tr>
      </table>
    <?php
	}
	?>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infActividad".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
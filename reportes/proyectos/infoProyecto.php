<?php ob_start();?>
<?php
require_once("../../db/connect.php");
require_once("../../view/hora.php");
$user=$_GET["user"]; 
?>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<h2><legend>INFORMACIÓN DEL PROYECTO</legend></h2>
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

$UIDproyecto=$_GET["idproyecto"];
$sql=$dbh->prepare("select *from proyecto where IDproyecto=?");
	$sql->bindParam(1,$UIDproyecto);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		$costoProg=$row["totalProyecto"];
		$costoReal=$row["costo_real"];
		$diferencia_costo=$costoProg-$costoReal;
		$estado=$row["estado"];
?>
<table align="left" border="2" id="tableProyecto" width="500">
    
    <tr><td><label>Nombre</label></td><td><?php echo $row["nombre"];?></td></tr>
    <tr><td><label>Fecha de inicio</label></td><td><?php echo $row["fecInicio"];?></td></tr>
    <tr><td><label>Fecha de finalización</label></td><td><?php echo $row["fecFinal"];?></td></tr>
    <tr><td><label>Días programados</label></td><td><?php echo $row["duracion_programada"]." dias";?></td></tr>
    <tr><td><label>Días utilizados</label></td><td><?php echo $row["duracion_real"]. " dias";?></td></tr>
    <tr><td><label>Días faltantes</label></td><td><?php echo $row["duracion_programada"]-$row["duracion_real"]. " dias";?></td></tr>
    <tr><td><label>Costo programado</label></td><td><?php echo $row["totalProyecto"]. " Bs";?></td></tr>
    <tr><td><label>Costo real</label></td><td><?php echo $row["costo_real"]. " Bs";?></td></tr>
    <tr><td><label>Diferencia de costos</label></td><td><?php echo $diferencia_costo." Bs";?></td></tr>
    <tr><td><label>Porcentaje de progreso</label></td><td><?php echo $row["porcentaje_progreso"]." %";?></td></tr>
    <tr><td><label>Estado</label></td><td><?php echo $row["estado"];?></td></tr>
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
$filename = "archivos/infProyecto".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
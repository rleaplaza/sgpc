<?php ob_start();?>
<?php
require_once("../../db/connect.php");
require_once("../../view/hora.php");
?>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
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
$UIDfase=$_GET["idfase"];
$user=$_GET["user"];
$proyecto=$_GET["proyecto"];
$sql=$dbh->prepare("select *from fase where IDfase=?");
	$sql->bindParam(1,$UIDfase);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		//asignación de variables de arreglo
		$fase=$row["nombre"];
		$long=$row["longitudKM"];
		$estado=$row["estado"];
		$actProgramadas=$row["act_programadas"];
		$actConcluidas=$row["act_concluidas"];
		if($actProgramadas>0){
		$progreso=($actConcluidas/$actProgramadas)*100;
		}else{
			$progreso=0;
			}?>
    <h2>INFORMACIÓN DE LA FASE</h2>
     USUARIO:<?php echo $user;?><br>
     FECHA: <?php echo $fecha=getFecha();?>
      <table align="left" border="1" bordercolor="#0066FF" bordercolorlight="#0033FF" width="500">
      <tr><td><label>Proyecto</label></td><td><?php echo $proyecto;?></td></tr>
      <tr><td><label>Fase</label></td><td><?php echo $fase;?></td></tr>
      <tr><td><label>Longitud</label></td><td><?php echo $long." Km";?></td></tr>
      <tr><td><label>Estado</label></td><td><?php echo $estado;?></td></tr>
      <tr><td><label>Actividades programadas</label></td><td><?php echo $actProgramadas;?></td></tr>
      <tr><td><label>Actividades concluidas</label></td><td><?php echo $actConcluidas;?></td></tr>
      <tr><td><label>Progreso</label></td><td><?php echo $progreso=round($progreso,2)." %";?></td></tr>     
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
$filename = "archivos/infFase".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
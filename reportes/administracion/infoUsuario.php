<?php session_start();?>
<?php ob_start();?>
<?php
require_once("../../db/connect.php");
require_once("../../view/hora.php"); 
?>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<img src="../../images/logo.jpg" height="50" width="200">
<h2><legend>INFORMACIÓN DE USUARIO</legend></h2>
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
		background:#06F;
		}
table th{
	    border-radius:5px;
		border:1px;
		backbround:rgba(156,184,121,0.2);
	}
	legend, label{
		 color:#FFF;
		}
.tabla{
	position:relative;
	left:100;
	top:20;
	}
</style>
<?php
$sql=$dbh->prepare("select *from usuario, rol where usuario.IDrol=rol.IDrol and username=?");
	$sql->bindParam(1,$_SESSION["username"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
?>
<table align="left" border="2" width="300" class="tabla">
    
 <tr><td><label>Usuario:</label></td><td><?php echo $row[1];?></td></tr>
 <tr><td> <label>Email:</label></td><td><?php echo $row[3];?></td></tr>
 <tr><td><label>Estado:</label></td><td><?php echo $row[6];?></td></tr>
<tr><td><label>Fecha de creación: </label></td><td><?php echo $row[7];?></td></tr>
<tr><td><label>Hora de creación: </label></td><td><?php echo $row[8];?></td></tr>
<tr><td><label>Rol de usuario: </label></td><td><?php echo $row[9];?></td></tr>
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
$filename = "archivos/infoUsuario".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
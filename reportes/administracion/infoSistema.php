<?php session_start();?>
<?php ob_start();?>
<?php
require_once("../../db/connect.php");
require_once("../../view/hora.php"); 
?>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<img src="../../images/logo.jpg" height="50" width="200">
<h2><legend>INFORMACIÓN DEL SISTEMA</legend></h2>
 FECHA: <?php echo $fecha=getFecha();?><br>
 USUARIO: <?php echo strtoupper($_SESSION["username"]);?>
<?php $sql=$dbh->prepare("show variables like '%version'");
		$sql->execute();
		$query=$dbh->prepare("show databases like 'dbserco'");
		$query->execute();
		$fila=$query->fetch();
		$db=$fila[0];
?><style>
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
		background:#006;
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
<table>
        <tr><td><label>Servidor</label></td><td><label><?php echo $_SERVER["SERVER_NAME"];?></label></td></tr>
        <tr><td><label>Zona horaria</label></td><td><label><?php echo date_default_timezone_get();?></label></td></tr>
        <tr><td><label>Software</label></td><td><label><?php echo $_SERVER["SERVER_SOFTWARE"];?></label></td></tr>
        <tr><td><label>Versión de php</label></td><td><label><?php echo phpversion();?></label></td></tr>
        <tr><td><label>IP de servidor</label></td><td><label><?php echo $_SERVER["SERVER_ADDR"];?></label></td></tr>
        <tr><td><label>Base de datos</label></td><td><label><?php echo $db;?></label></td></tr>
        <tr><td><label>Sistema operativo</label></td><td><label><?php echo php_uname();?></label></td></tr>
        <tr><td><label>Protocolo de servidor</label></td><td><label><?php echo $_SERVER["SERVER_PROTOCOL"];?></label></td></tr>
        <tr><td><label>Puerto de servidor</label></td><td><label><?php echo $_SERVER["SERVER_PORT"];?></label></td></tr>
        <tr><td><label>Navegador de usuario</label></td><td><label><?php echo $_SERVER["HTTP_USER_AGENT"];?></label></td></tr>
        </table>
    
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infoSistema".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
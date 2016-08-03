<?php ob_start()//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a costos fijos por fase
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$consulta=$dbh->prepare("select nombre from proyecto where IDproyecto=?");//consulta de nombre del proyecto
$consulta->bindParam(1,$_GET["idproyecto"]);//enlaza al id del proyecto
$consulta->execute();//ejecuta la consulta
$result=$consulta->fetch();//devuelve el resultado en un arreglo
$proyecto=$result[0];//almacena la fase
$sql=$dbh->prepare("select *from valor_acumulado where IDproyecto=?");
$sql->bindParam(1,$_GET["idproyecto"]);//enlaza al id del proyecto
$sql->execute();
$idproyecto=$_GET["idproyecto"];
$total=0;
	$totalprogreso=0;
?>
<style>
label{ font:Verdana, Geneva, sans-serif;
	   color:#00C;
	  }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
</style>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<img src="../../images/logo.jpg" height="100" width="200">
INFORME DE VALOR ACUMULADO<br>
PROYECTO: <?php echo $proyecto;?><BR>
FECHA: <?php echo $fecha=getFecha();?>
<table width="500px" cellpadding="5px" cellspacing="5px">
    <tr bgcolor="#DDA">
        <td><label>FECHA</label></td>
        <td><label>PROGRESO</label></td>
        <td><label>VALOR ACUMULADO</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$total=$total+$row[3];//acumula el costo real  de la actividad 
		$totalprogreso=$totalprogreso+$row[2];
		?>
    <tr bgcolor="#0099FF">
     <td><?php echo $row[4];?></td>
        <td><?php echo $row[2]." %";?></td>
        <td><?php echo $row[3]." Bs";?></td>
       
    </tr>

<?php
	}
	?>
    <tr bgcolor="#DDA"><td colspan="2">Total valor acumulado</td><td><?php echo $total." Bs";?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/ValorAcumulado".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
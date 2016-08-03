<?php ob_start();//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a costos fijos por fase
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$user=$_GET["user"];
$consulta=$dbh->prepare("select nombre from fase where IDfase=?");
$consulta->bindParam(1,$_GET["idfase"]);
$consulta->execute();
$result=$consulta->fetch();
$fase=$result[0];
$sql=$dbh->prepare("SELECT nombreActividad, costo_prorrateado, costo_total,costo_programado
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					and precioUnitarioBS>0
					ORDER BY actividad.hraRegistro ASC");
$sql->bindParam(1,$_GET["idfase"]);
$sql->execute();
$total=0;
$costofijo=0;
$costoprog=0;
$totalDiferencia=0;
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
INFORME COSTOS FIJOS<br>
FASE: <?php echo $fase;?><BR>
USUARIO: <?php echo $user;?><br>
FECHA: <?php echo $fecha=getFecha();?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center">
    <tr bgcolor="#DDA">
        <td><label>DESCRIPCIÓN</label></td>
        <td><label>COSTO FIJO</label></td>
        <td><label>COSTO TOTAL</label></td>
        <td><label>COSTO PROGRAMADO</label></td>
        <td><label>VARIACIÓN</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$costofijo=$costofijo+$row[1];//acumula el total del costo fijo prorrateado
		$total=$total+$row[2];//acumula el costo real  de la actividad 
		$costoprog=$costoprog+$row[3];//acumula el costo total programado
		$diferencia=$costoprog-$total;//resta los costos real y programado
		$totalDiferencia=$totalDiferencia+$diferencia;//acumula la suma de diferencias
		?>
    <tr bgcolor="#0099FF">
         <td><?php echo $row[0];?></td>
        <td><?php echo $row[1]." Bs";?></td>
        <td><?php echo $row[2]." Bs";?></td>
        <td><?php echo $row[3]." Bs";?></td>
         <td><?php echo $diferencia." Bs";?></td>
    </tr>

<?php
	}
	?>
     <tr bgcolor="#DDA"><td colspan="1" >Cálculos totales</td><td><?php echo $costofijo." Bs";?></td><td colspan="1"><?php echo $total." Bs";?></td><td colspan="1"><?php echo $costoprog." Bs";?></td><td colspan="1"><?php echo $totalDiferencia." Bs";?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infCostofijo".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
<?php ob_start();//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a actividades con presupuesto excedido
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$consulta=$dbh->prepare("select nombre from fase where IDfase=?");
$consulta->bindParam(1,$_GET["idfase"]);
$consulta->execute();
$result=$consulta->fetch();
$fase=$result[0];
$idfase=$_GET["idfase"];
$sql=$dbh->prepare("SELECT nombreActividad, costo_total,costo_programado
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					and costo_total>costo_programado
					ORDER BY actividad.hraRegistro ASC");
$sql->bindParam(1,$idfase);//enlaza al id de la fase
$sql->execute();
$totalcostoreal=0;
	$totalprogramado=0;
	$totaldiferencia=0;
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
ACTIVIDADES CON PRESUPESTO EXCEDICO<br>
FASE: <?php echo $fase;?><BR>
FECHA: <?php echo $fecha=getFecha();?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center">
    <tr bgcolor="#DDA">
        <td><label>DESCRIPCIÓN</label></td>
        <td><label>COSTO REAL</label></td>
        <td><label>COSTO PROGRAMADO</label></td>
        <td><label>MONTO EXCEDIDO</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$totalcostoreal=$totalcostoreal+$row[1];//suma los costos reales
$totalprogramado=$totalprogramado+$row[2];//suma los costos programados
$diferencia=$totalcostoreal-$totalprogramado;//diferencia de monto exceddido
$totaldiferencia=$totaldiferencia+$diferencia;//sumatoria de diferencias
		?>
    <tr bgcolor="#0099FF">
             <td><?php echo $row[0];?></td>
        <td><?php echo $row[1]." Bs";?></td>
        <td><?php echo $row[2]." Bs";?></td>
        <td><?php echo $diferencia." Bs";?></td>
    </tr>

<?php
	}
	?>
          <tr bgcolor="#0099FF"><td colspan="1">Cálculos totales</td><td><?php echo $totalcostoreal;?></td><td><?php echo $totalprogramado;?></td><td><?php echo $totaldiferencia;?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infSobrepresupuesto".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
<?php ob_start()//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a materiales incorporados en el proyecto
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$nombre=$_GET["nombre"];
$user=$_GET["user"];
$sql=$dbh->prepare("SELECT m.descripcion, m.unidad, sum(am.cantidad_programada) as cantidad_programada
FROM material AS m, actividad_material AS am, actividad AS a, subfase AS sf, fase AS f, proyecto AS p
WHERE m.IDmaterial = am.IDmaterial
AND am.IDactividad = a.IDactividad
AND a.IDsubfase = sf.IDsubfase
AND sf.IDfase = f.IDfase
AND f.IDproyecto = p.IDproyecto
AND p.IDproyecto =?
GROUP BY descripcion");
$sql->bindParam(1,$_GET["idproyecto"]);
$sql->execute();
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
PROYECTO: <?php echo strtoupper($nombre);?><br>
INFORME DE MATERIALES PROGRAMADOS<br>
USUARIO: <?php echo strtoupper($user);?><br>
FECHA: <?php echo $fecha=getFecha();?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center">
    <tr bgcolor="#DDA">
        <td><label>DESCRIPCIÓN</label></td>
        <td><label>CANTIDAD PROGRAMADA</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		?>
    <tr bgcolor="#0099FF">
         <td><?php echo $row[0];?></td>
        <td><?php echo $row[2]." ".$row[1];?></td>
    </tr>

<?php
	}
	?>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infMaterial".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
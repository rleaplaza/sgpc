<?php ob_start()//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a cargos de trabajadores
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$nombre=$_GET["nombre"];
$user=$_GET["user"];
$sql=$dbh->prepare("SELECT c.nombre, sum( cantidad_contratada ) AS cantidad
                    FROM cargomanodeobra AS c, solicita AS s, proyecto AS proy
                    WHERE c.IDcargoM = s.IDcargo_M
                    AND s.IDproyecto = proy.IDproyecto
					and proy.IDproyecto=?
                    GROUP BY c.nombre asc");
$sql->bindParam(1,$_GET["idproyecto"]);
$sql->execute();
$cantidad=0;
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
PERSONAL PROGRAMADO<br>
USUARIO: <?php echo strtoupper($user);?><br>
FECHA: <?php echo $fecha=getFecha()//función para recuperar la fecha y hora actual;?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center">
    <tr bgcolor="#DDA">
        <td><label>DESCRIPCIÓN</label></td>
        <td><label>CANTIDAD PROGRAMADA</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$cantidad=$cantidad+$row[1];
		?>
    <tr bgcolor="#0099FF">
         <td><?php echo $row[0];?></td>
        <td><?php echo $row[1];?></td>
    </tr>
<?php
	}
	?>
    <tr bgcolor="#DDA"><td colspan="1">TOTAL DE PERSONAL</td><td><?php echo $cantidad;?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infTrabjador".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
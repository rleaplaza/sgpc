<?php ob_start();?>
<?php
require_once("../../db/connect.php");
$user=$_GET["user"];
$consulta=$dbh->prepare("select nombre from fase where IDfase=?");
$consulta->bindParam(1,$_GET["idfase"]);
$consulta->execute();
$result=$consulta->fetch();
$fase=$result[0];
$sql=$dbh->prepare("SELECT nombreActividad, unidades, cantidad, precioUnitarioBS, costo_total,fase.nombre
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					and precioUnitarioBS>0
					ORDER BY actividad.hraRegistro ASC");
$sql->bindParam(1,$_GET["idfase"]);
$sql->execute();
$total=0;
?>
<style>
label{ font:Verdana, Geneva, sans-serif;
	   color:#00C;
	  }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
	   .table{
		   border-radius:2px 2px 2px 2px;
		   box-shadow:2px 2px 2px 2px;
		   }
</style>
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<img src="../../images/logo.jpg" height="100" width="200">
INFORME DE PRECIOS UNITARIOS DE ACTIVIDADES<br>
USUARIO: <?php echo strtoupper($user);?><br>
FASE: <?php echo $fase;?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center" class="table">
    <tr bgcolor="#DDA">
        <td><label>DESCRIPCIÓN</label></td>
        <td><label>UNIDAD</label></td>
        <td><label>CANTIDAD</label></td>
        <td><label>PRECIO UNITARIO</label></td>
        <td><label>COSTO</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$total=$total+$row[4];
		?>
    <tr bgcolor="#0099FF">
        <td><?php echo $row[0];?></td>
        <td><?php echo $row[1];?></td>
        <td><?php echo $row[2];?></td>
        <td><?php echo $row[3]." Bolivianos";?></td>
        <td><?php echo $row[4]." Bolivianos";?></td>
    </tr>

<?php
	}
	?>
     <tr bgcolor="#0099FF"><td colspan="4">Costo Total:</td><td><?php echo $total." Bolivianos";?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/reportePrecio".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
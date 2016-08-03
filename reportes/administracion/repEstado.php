<?php ob_start();//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a notas de remisión de pedido
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$estado=$_POST["estado"];
$user=$_POST["user"];
#consulta de estado de usuarios
$sql=$dbh->prepare("select *from usuario where estado=? order by username");
	$sql->bindParam(1,$estado);
	$sql->execute();
$total=0;//valor total para sumar las columnas de subtotal
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
<img src="../../images/logo.jpg" height="50" width="200"><br>
INFORME DE ESTADO DE USUARIOS<br>
USUARIO: <?php echo strtoupper($user);?><br>
FECHA: <?php echo $fecha=getFecha();?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center">
    <tr bgcolor="#DDA">
        <td><label>USERNAME</label></td>
        <td><label>EMAIL</label></td>
        <td><label>ESTADO</label></td>
        <td><label>ROL</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$total++;
		?>
    <tr bgcolor="#0099FF">
         <td><?php echo $row[1];?></td>
         <td><?php echo $row[3]?></td>
         <td><?php echo $row[6];?></td>
         <td><?php echo $row[9];?></td>
    </tr>

<?php
	}
	?>
     <tr bgcolor="#0099FF"><td colspan="3">Total usuarios</td><td><?php echo $total." usuarios";?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/estadoUsuario".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
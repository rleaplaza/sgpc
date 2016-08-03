<?php ob_start()//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a costos fijos por fase
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$nrocotizacion=$_GET["nrocot"];//nro de cotización
$proveedor=$_GET["prov"];//proveedor
#consulta del detalle del pedido
$sql=$dbh->prepare("SELECT m.descripcion, d.cantidad, d.unidad, d.precio, d.subtotal
                        FROM material AS m, det_pedido AS d, pedido_material AS p
                        WHERE m.IDmaterial = d.IDmaterial
                        AND d.nro_pedido = p.nro_pedido
                        AND p.nro_cotizacion = ?");
$sql->bindParam(1,$nrocotizacion);//enlaza al nro de cotización
$sql->execute();//ejecuta la instrucción
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
<img src="../../images/logo.jpg" height="100" width="200">
PEDIDO DE MATERIALES<br>
PROVEEDOR: <?php echo $proveedor;?><BR>
FECHA: <?php echo $fecha=getFecha();?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center">
    <tr bgcolor="#DDA">
        <td><label>DESCRIPCIÓN</label></td>
        <td><label>CANTIDAD</label></td>
        <td><label>UNIDAD</label></td>
        <td><label>PRECIO UNITARIO</label></td>
        <td><label>SUBTOTAL</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$total=$total+$row[4];//acumula el subtotal
		?>
    <tr bgcolor="#0099FF">
         <td><?php echo $row[0];?></td>
         <td><?php echo $row[1];?></td>
         <td><?php echo $row[2];?></td>
         <td><?php echo $row[3]." Bs";?></td>
         <td><?php echo $row[4]." Bs";?></td>
    </tr>

<?php
	}
	?>
     <tr bgcolor="#0099FF"><td colspan="4">TOTAL PEDIDO</td><td><?php echo $total." Bs";?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infPedido".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
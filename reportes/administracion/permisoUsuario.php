<?php ob_start()//función para generar el html dentro del pdf, además guarda el archivo generado en la carpeta archivos;?>
<?php
#Este programa generar reportes pdf descargables con relación a notas de remisión de pedido
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
$user=$_GET["user"];
#consulta de estado de usuarios
$sql=$dbh->prepare("SELECT nombreMenu, nombreSubmenu, nombreOpcion, fecha_asignacion, hraAsignacion
                    FROM menu AS m, submenu AS s, opcion AS o, permiso AS p, usuario AS u
                    WHERE m.IDmenu = s.IDmenu
                    AND s.IDsubmenu = o.IDsubmenu
                    AND o.IDopcion = p.IDopcion
                    AND p.USR_UID = u.USR_UID
                    AND username =?
                    ORDER BY nombreMenu ASC  ");
	$sql->bindParam(1,$user);
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
<img src="../../images/logo.jpg" height="100" width="200">
PERMISOS ASIGNADOS<br>
USUARIO: <?php echo strtoupper($user);?><br>
FECHA: <?php echo $fecha=getFecha();?>
<table width="500px" cellpadding="5px" cellspacing="5px" align="center">
    <tr bgcolor="#DDA">
        <td><label>MENÚ</label></td>
        <td><label>SUBMENÚ</label></td>
        <td><label>OPCIÓN ASIGNADA</label></td>
        <td><label>FECHA DE ASIGNACIÓN</label></td>
        <td><label>HORA DE ASIGNACIÓN</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
		$total++;
		?>
    <tr bgcolor="#0099FF">
         <td><?php echo $row[0];?></td>
         <td><?php echo $row[1]?></td>
         <td><?php echo $row[2];?></td>
         <td><?php echo $row[3];?></td>
         <td><?php echo $row[4];?></td>
    </tr>

<?php
	}
	?>
     <tr bgcolor="#0099FF"><td colspan="4">Total permisos</td><td><?php echo $total?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/permisoUsuario".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
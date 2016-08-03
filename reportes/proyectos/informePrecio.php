<?php ob_start();?>
<?php
require_once("../../db/connect.php");//llama a la conexión global de base de datos
require_once("../../view/hora.php");//archivo para mostrar la fecha y hora actual
?>
<meta charset="utf-8">
  
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
 <h2><legend>INFORME ANÁLISIS DE PRECIOS UNITARIOS</legend></h2>
     FECHA: <?php echo $fecha=getFecha();?>
<table width="400" align="left" class="table">
      <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  text-align:center;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
				 td{
					 background:#CCC;
				 }
				 .table{border-radius:2px 2px 2px 2px;
					 box-shadow:2px 2px 2px 2px;
					
					 }
			</style>   
            
<?php

$idactividad=$_GET["idactividad"];
#Consulta para recuperar el detalle del precio unitario de la actividad
	$sql=$dbh->prepare("SELECT IDactividad, nombreActividad, t_actmaterial, t_acmanoobra, t_acmaquinaria, t_gastoadm, t_utilidad, t_impuesto, unidades, cantidad, total_avance, precioUnitarioBS, costo_total
                        FROM actividad
                        WHERE IDactividad=?
						order by hraRegistro");
	$sql->bindParam(1,$idactividad);//enlaza el id de la actividad
	$sql->execute();//ejecuta la instrucción
	$dbh->query("SET NAMES UTF8");//habilita la codificación utf8
	$row=$sql->fetch();
	?>
    
  <tr><td><label>Actividad</label></td><td><?php echo $row[1];?></td></tr>
     <tr><td><label>Total por material</label></td><td><?php echo $row[2]." Bs";?></td></tr>
     <tr><td><label>Total por mano de obra</label></td><td><?php echo $row[3]." Bs";?></td></tr>
     <tr><td><label>Total por maquinaria</label></td><td><?php echo $row[4]." Bs";?></td></tr>
     <tr><td><label>Gasto administrativo</label></td><td><?php echo $row[5]." Bs";?></td></tr>
     <tr><td><label>Utilidad</label></td><td><?php echo $row[6]." Bs";?></td></tr>
     <tr><td><label>Impuesto</label></td><td><?php echo $row[7]." Bs";?></td></tr>
     <tr><td><label>Cantidad</label></td><td><?php echo $row[9]." ".$row[8];?></td></tr>
     <tr><td><label>Precio unitario</label></td><td><?php echo $row[11]." Bs";?></td></tr>
</table>
<?php
require_once("../dompdf/dompdf_config.inc.php");//llama al archivo dompdf
$dompdf = new DOMPDF();//instancia a la clase dompdf
$dompdf->load_html(ob_get_clean());//recupera el buffer actual de salida y borra la salida anterior
$dompdf->render();//renderiza el documento
$pdf = $dompdf->output();//prepara la salida del documento pdf
$filename = "archivos/infprecio".time().'.pdf';//genera el archivo pdf y lo guarda en el directorio
file_put_contents($filename, $pdf);//carga el contenido del archivo
$dompdf->stream($filename);//despliega el archivo
?>
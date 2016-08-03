<?php session_start();//función para el inicio de la sesión?>
<meta charset="utf-8">
<title>Presupuesto execido de actividades</title>
<!--Estilos para el texto que lleve la propiedad label y legend, fuente, color. -->
<style>
label{ font:Verdana, Geneva, sans-serif;
	   color:#00C;
	  }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
</style>
<?php 
#Este programa se encarga de mostrar el informa de costos fijos por fase
if(isset($_SESSION["username"])){//valida la existencia de la sesión
	 if(isset($_POST["idfase"])){//valida la existencia de la fase
require_once("../db/connect.php");//llama a la conexión a la base de datos
$consulta=$dbh->prepare("select nombre from fase where IDfase=?");//consulta de nombre de fase
$consulta->bindParam(1,$_POST["idfase"]);//enlaza a la fase
$consulta->execute();//ejecuta la consulta
$result=$consulta->fetch();//devuelve el resultado en un arreglo
$fase=$result[0];//almacena la fase
$idfase=$_POST["idfase"];//almacena el id de la fase
$sql=$dbh->prepare("SELECT nombreActividad, costo_total,costo_programado
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					and costo_total>costo_programado
					ORDER BY actividad.hraRegistro ASC");
$sql->bindParam(1,$idfase);//enlaza al id de la fase
$sql->execute();
if($sql->rowCount()>0){
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
<link href="../css/css.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<a href="<?php echo "../reportes/proyectos/sobrePresupuesto.php?idfase=$idfase";?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en pdf"></a>
   <legend>ACTIVIDADES CON PRESUPUESTO EXCEDIDO   </legend><label>FASE: <?php echo $fase;?></label>
<table width="500px" cellpadding="5px" cellspacing="5px">
    <tr bgcolor="#DDA">
        <td><label>DESCRIPCIÓN</label></td>
        <td><label>COSTO REAL</label></td>
        <td><label>COSTO PROGRAMADO</label></td>
        <td><label>MONTO EXCEDIDO</label></td>
    </tr>
    <?php foreach($sql->fetchAll() as $row){
$totalcostoreal=$totalcostoreal+$row[1];
$totalprogramado=$totalprogramado+$row[2];
$diferencia=$totalcostoreal-$totalprogramado;
$totaldiferencia=$totaldiferencia+$diferencia;
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
}else{
	echo "<label>No se encontraron resultados</label>";
	}
}else{
	header("location: ../index.php");
	}
}else{
	header("location: ../index.php");
	}
?>
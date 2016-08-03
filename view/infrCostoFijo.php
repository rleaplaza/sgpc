<?php session_start();//función para el inicio de la sesión?>
<meta charset="utf-8">
<title>Costos fijos</title>
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
$user=$_SESSION["username"];
$consulta=$dbh->prepare("select nombre from fase where IDfase=?");//consulta de nombre de fase
$consulta->bindParam(1,$_POST["idfase"]);//enlaza a la fase
$consulta->execute();//ejecuta la consulta
$result=$consulta->fetch();//devuelve el resultado en un arreglo
$fase=$result[0];//almacena la fase
$idfase=$_POST["idfase"];//almacena el id de la fase
$sql=$dbh->prepare("SELECT nombreActividad, costo_prorrateado, costo_total,costo_programado
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					and precioUnitarioBS>0
					ORDER BY actividad.hraRegistro ASC");
$sql->bindParam(1,$idfase);//enlaza al id de la fase
$sql->execute();
if($sql->rowCount()>0){
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
<link href="../css/css.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<a href="<?php echo "../reportes/proyectos/infrCostoFijo.php?idfase=$idfase&user=$user";?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en pdf"></a>
   <legend>INFORME COSTOS FIJOS    </legend><label>FASE: <?php echo $fase;?></label>
<table width="500px" cellpadding="5px" cellspacing="5px">
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
     <tr bgcolor="#0099FF"><td colspan="1">Cálculos totales</td><td><?php echo $costofijo." Bs";?></td><td colspan="1"><?php echo $total." Bs";?></td><td colspan="1"><?php echo $costoprog." Bs";?></td><td colspan="1"><?php echo $totalDiferencia." Bs";?></td></tr>
</table>
    <?php
}else{
	echo "No se encontraron resultados";
	}
}else{
	header("location: ../index.php");
	}
}else{
	header("location: ../index.php");
	}
?>
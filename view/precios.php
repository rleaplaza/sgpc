<?php session_start();?>
<meta charset="utf-8">
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
#Este programa se encarga de mostrar el reporte de precios unitarios de actividades
if(isset($_SESSION["username"])){
	 if(isset($_POST["fase"])){
require_once("../db/connect.php");
$user=$_SESSION["username"];
$consulta=$dbh->prepare("select nombre from fase where IDfase=?");
$consulta->bindParam(1,$_POST["fase"]);
$consulta->execute();
$result=$consulta->fetch();
$fase=$result[0];
$idfase=$_POST["fase"];
$sql=$dbh->prepare("SELECT nombreActividad, unidades, cantidad, precioUnitarioBS, costo_total,fase.nombre
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					and precioUnitarioBS>0
					ORDER BY actividad.hraRegistro ASC");
$sql->bindParam(1,$idfase);
$sql->execute();
if($sql->rowCount()>0){
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
<link href="../css/css.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<a href="<?php echo "../reportes/proyectos/precioActividad.php?idfase=$idfase&user=$user";?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en pdf"></a>
<legend>INFORME PRECIOS UNITARIOS DE ACTIVIDADES</legend><label>FASE: <?php echo $fase;?></label>
<table width="500px" cellpadding="5px" cellspacing="5px" class="table">
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
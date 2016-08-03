<?php session_start();//función para el inicio de la sesión?>
<meta charset="utf-8">
<title>Valor acumulado</title>
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
#Este programa se encarga de mostrar el informe del valor acumulado
if(isset($_SESSION["username"])){//valida la existencia de la sesión
	 if(isset($_POST["idproyecto"])){//valida la existencia de la fase
require_once("../db/connect.php");//llama a la conexión a la base de datos
$idfase=$_POST["idfase"];
$sql=$dbh->prepare("select nombre from fase where IDfase=?");
$sql->bindParam(1,$idfase);
$sql->execute();
$result=$sql->fetch();
$fase=$result["nombre"]
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
<a href="<?php echo "../reportes/proyectos/infrValor.php?idproyecto=$idproyecto";?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en pdf"></a>
   <legend>INFORME DE INGRESOS Y EGRESOS   </legend><label>FASE: <?php echo $proyecto;?></label>
<table width="500px" cellpadding="5px" cellspacing="5px">
    <tr bgcolor="#DDA">
         <td><label>ACTIVIDAD</label></td>
        <td><label>INGRESOS</label></td>
        <td><label>EGRESOS</label></td>
    </tr>
    <?php 
	
	foreach($sql->fetchAll() as $row){
		$total=$total+$row[3];//acumula el costo real  de la actividad 
		$totalprogreso=$totalprogreso+$row[2];
		?>
    <tr bgcolor="#0099FF">
     <td><?php echo $row[4];?></td>
        <td><?php echo $row[2]." %";?></td>
        <td><?php echo $row[3]." Bs";?></td>
       
    </tr>

<?php
	}
	?>
    <tr bgcolor="#DDA"><td colspan="2">Total valor acumulado</td><td><?php echo $total." Bs";?></td></tr>
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
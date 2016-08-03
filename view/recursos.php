<?php session_start();//función para el inicio de la sesión?>
<meta charset="utf-8">
<title>Recursos para el proyecto</title>
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
	 if(isset($_POST["idproyecto"])){//valida la existencia de la fase
require_once("../db/connect.php");//llama a la conexión a la base de datos
$idproyecto=$_POST["idproyecto"];//captura el ID del proyecto
$nombre=$_POST["proyecto"];
$user=$_SESSION["username"];
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
<label>Proyecto: </label><?php echo strtoupper($nombre);?><br>
<img src="../images/cemento.jpg" height="40" width="40">
<a href="<?php echo "../reportes/proyectos/infmaterial.php?idproyecto=$idproyecto&nombre=$nombre&user=$user";?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en pdf"></a>
<legend>INFORME MATERIALES PROGRAMADOS</legend><br>
<img src="../images/maquinaria1.jpg" height="40" width="40">
<a href="<?php echo "../reportes/proyectos/infmaquinaria.php?idproyecto=$idproyecto&nombre=$nombre&user=$user";?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en pdf"></a>
<legend>INFORME DE EQUIPAMIENTO PROGRAMADO</legend>
<img src="../images/cargoManoobra.jpg" height="40" width="40">
<a href="<?php echo "../reportes/proyectos/infTrabajador.php?idproyecto=$idproyecto&nombre=$nombre&user=$user";?>"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en pdf"></a>
<legend>INFORME DE MANO DE OBRA PROGRAMADA</legend>
    <?php
}else{
	header("location: ../index.php");
	}
}else{
	header("location: ../index.php");
	}
?>
<?php
session_start();
?>
<!doctype html>
<html>
<meta charset="utf-8">
<style>
  label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }	
	</style>
<?php
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
	$ci=$_POST["cedula"];
	$sql=$dbh->prepare("SELECT nombres, app, apm, c.nombre
                        FROM empleado AS e, personaltecnico AS pt, solicita AS s, cargomanodeobra AS c
                        WHERE e.IDempleado = pt.IDempleado
                        AND pt.IDpersonalTecnico = s.IDpersonalTecnico
                        AND s.IDcargo_M = c.IDcargoM 
						and e.CI=?");
	$sql->bindParam(1,$ci);
	$sql->execute();
    $fila=$sql->fetch();
	?>
    <label>Solicitante: </label><?php echo $fila[0]." ".$fila[1]." ".$fila[2];?>
    <?php
	}else{
		header("location: ../../index.php");
		}
?>
</html>
<?php
sleep(1);
include("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$cedula=strtolower( $_REQUEST["ci"]);
	$query =$dbh->prepare("select * from empleado where CI = ?");
	$query->bindParam(1,$cedula);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Cedula ya existente</div>';
	else
		echo '<div id="Success">Cedula Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
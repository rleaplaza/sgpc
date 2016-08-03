<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$direccion=trim($_REQUEST["direccion"]);
	$query =$dbh->prepare("select * from opcion where url = ?");
	$query->bindParam(1,$direccion);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Archivo ya existente</div>';
	else
		echo '<div id="Success">Archivo Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
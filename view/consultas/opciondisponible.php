<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$opcion=trim($_REQUEST["opcion"]);
	$query =$dbh->prepare("select * from opcion where nombreOpcion = ?");
	$query->bindParam(1,$opcion);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Opcion ya existente</div>';
	else
		echo '<div id="Success">Opcion Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
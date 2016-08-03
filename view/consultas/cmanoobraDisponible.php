<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$cmanoobra=trim($_REQUEST["nombre"]);
	$query =$dbh->prepare("select * from cargomanodeobra where nombre = ?");
	$query->bindParam(1,$cmanoobre);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Cargo ya existente</div>';
	else
		echo '<div id="Success">Cargo Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
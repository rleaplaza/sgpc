<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$profesion=trim($_REQUEST["profesion"]);
	$query =$dbh->prepare("select * from profesion where nombre = ?");
	$query->bindParam(1,$profesion);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Profesion ya existente</div>';
	else
		echo '<div id="Success">Profesion Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
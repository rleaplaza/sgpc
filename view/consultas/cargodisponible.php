<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$cargo=trim($_REQUEST["cargo"]);
	$query =$dbh->prepare("select * from cargo where nombre = ?");
	$query->bindParam(1,$cargo);
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
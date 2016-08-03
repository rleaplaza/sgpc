<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$subfase=trim($_REQUEST["subfase"]);
	$query =$dbh->prepare("select * from subfase where nombre = ?");
	$query->bindParam(1,$subfase);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Subfase ya existente</div>';
	else
		echo '<div id="Success">subFase Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$fase=trim($_REQUEST["fase"]);
	$query =$dbh->prepare("select * from fase where nombre = ?");
	$query->bindParam(1,$fase);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Fase ya existente</div>';
	else
		echo '<div id="Success">Fase Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
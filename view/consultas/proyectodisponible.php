<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$proyecto=trim($_REQUEST["proyecto"]);
	$query =$dbh->prepare("select * from proyecto where nombre = ?");
	$query->bindParam(1,$proyecto);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Proyecto ya existente</div>';
	else
		echo '<div id="Success">Proyecto Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
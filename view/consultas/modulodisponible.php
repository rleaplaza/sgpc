<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$modulo=trim($_REQUEST["modulo"]);
	$query =$dbh->prepare("select * from menu where nombreMenu = ?");
	$query->bindParam(1,$modulo);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Modulo ya existente</div>';
	else
		echo '<div id="Success">Modulo Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
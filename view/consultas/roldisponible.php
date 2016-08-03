<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$idrol=trim($_REQUEST["idrol"]);
	$query =$dbh->prepare("select * from rol where IDrol = ?");
	$query->bindParam(1,$idrol);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Rol ya existente</div>';
	else
		echo '<div id="Success">Rol Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
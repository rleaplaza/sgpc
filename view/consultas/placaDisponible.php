<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$placa=trim($_REQUEST["placa"]);
	$query =$dbh->prepare("select * from maquinaria where nroplaca = ?");
	$query->bindParam(1,$placa);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Placa ya existente</div>';
	else
		echo '<div id="Success">Placa Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
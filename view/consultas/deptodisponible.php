<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$depto=trim($_REQUEST["depto"]);
	$query =$dbh->prepare("select * from departamento where nombre = ?");
	$query->bindParam(1,$depto);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Departamento ya existente</div>';
	else
		echo '<div id="Success">Departamento Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
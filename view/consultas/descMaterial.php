<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$desc=trim($_REQUEST["desc"]);
	$query =$dbh->prepare("select * from material where descripcion = ?");
	$query->bindParam(1,$desc);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Material ya existente</div>';
	else
		echo '<div id="Success">Material Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>
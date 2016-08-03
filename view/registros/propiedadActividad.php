<?php
require_once("../../db/connect.php");
require_once("generaNumero.php");
try{
function propiedadActividad($IDactividad){
	global $dbh;
	$id=generaNumero();
	$sql=$dbh->prepare("insert into propiedadactividad values(?,?,'no','no','no')");
	$sql->bindParam(1,$id);
	$sql->bindParam(2,$IDactividad);
	$sql->execute();
	
	}
}catch(PDOException $e){
	echo "Error inesperado".$e.getMessage();
	}
?>
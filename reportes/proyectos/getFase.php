<?php
function getFase($idfase){
	global $dbh;
	$sql=$dbh->prepare("select nombre from fase where IDfase=?");
	$sql->bindParam(1,$idfase);
	$sql->execute();
	if($sql->rowCount()>0){
		$fila=$sql->fetch();
		$fase=$fila["nombre"];
		return $fase;
		}
	}
?>
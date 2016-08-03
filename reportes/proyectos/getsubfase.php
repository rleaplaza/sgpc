<?php
function getsubFase($idsubfase){
	global $dbh;
	$sql=$dbh->prepare("select nombre from subfase where IDsubfase=?");
	$sql->bindParam(1,$idsubfase);
	$sql->execute();
	if($sql->rowCount()>0){
		$fila=$sql->fetch();
		$subfase=$fila["nombre"];
		return $subfase;
		}
	}
?>
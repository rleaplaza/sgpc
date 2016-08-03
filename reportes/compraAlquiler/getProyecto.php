<?php
function getProyecto($idproyecto){
	global $dbh;
	$sql=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	if($sql->rowCount()>0){
		$fila=$sql->fetch();
		$proyecto=$fila["nombre"];
		return $proyecto;
		}
	}
?>
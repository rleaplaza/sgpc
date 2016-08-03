<?php
require_once("../../db/connect.php");
function updateDias($idactividad){
	global $dbh;
	$sql=$dbh->prepare("update actividad set dias_usados=dias_usados+1 where IDactividad=?");
	$sql->bindParam(1,$idactividad);
	$sql->execute();
	}
?>
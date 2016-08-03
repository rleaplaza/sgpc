<?php
require_once("../../db/connect.php");
function updateAsignacionTrabajador($IDactividad){
	global $dbh;
	$sql=$dbh->prepare("update propiedadactividad set personal_asignado='si' where IDactividad=?");
	$sql->bindParam(1,$IDactividad);
	$sql->execute();
}

function updateAsignacionEq($IDactividad){
	global $dbh;
	$sql=$dbh->prepare("update propiedadactividad set equipo_asignado='si' where IDactividad=?");
	$sql->bindParam(1,$IDactividad);
	$sql->execute();
	}

function updateAsignacionMat($IDactividad){
	global $dbh;
	$sql=$dbh->prepare("update propiedadactividad set material_asignado='si' where IDactividad=?");
	$sql->bindParam(1,$IDactividad);
	$sql->execute();
	}
?>
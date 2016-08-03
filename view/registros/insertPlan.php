<?php
require_once("../../db/connect.php");
require_once("generaNumero.php"); 
function insertPlan($IDproyecto){
	global $dbh;
	$idplan=generaNumero();
	$desc="plan del proyecto";
	$estado="Pendiente";
	$insertPlan=$dbh->prepare("insert into planificacion values(?,?,?,null,null)");
	$insertPlan->bindParam(1,$idplan);
	$insertPlan->bindParam(2,$IDproyecto);
	$insertPlan->bindParam(3,$desc);
	$insertPlan->execute();
	}

?>
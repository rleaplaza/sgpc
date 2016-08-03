<?php
#Este programa se encarga de registrar entrega de materiales solicitados
require_once("../../db/connect.php");
require_once("generaNumero.php");
function generaEntrega($IDpedido,$IDempleado,$IDactividad){
	global $dbh;
	$nroEntrega=generaNumero();
	$estado="Pendiente";
	$insert=$dbh->prepare("insert into entrega values(?,?,?,?,?,curdate())");
	$insert->bindParam(1,$nroEntrega);
	$insert->bindParam(2,$IDpedido);
	$insert->bindParam(3,$IDempleado);
	$insert->bindParam(4,$IDactividad);
	$insert->bindParam(5,$estado);
	$insert->execute();
	return $nroEntrega;
	}
?>
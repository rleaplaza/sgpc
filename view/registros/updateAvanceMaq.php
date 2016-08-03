<?php
#Este programa se encarga de registrar utilidad de equipamiento
require_once("../../db/connect.php");//llama a la conexion global
require_once("generaNumero.php");
function updateAvance($IDmaquinaria,$IDactividad,$Unidad,$Horas,$cant_usada){
	global $dbh;
	$identificador=generaNumero();//genera el identificador
	#consulta de insercion para el informe diario
	$insert=$dbh->prepare("insert into informemaquinaria values(?,?,?,?,?,?,?,curdate())");
	$total_horas=$Horas*$cant_usada;
	#enlaza a los parametros definidor en la funcion
	$insert->bindParam(1,$identificador);
	$insert->bindParam(2,$IDmaquinaria);
	$insert->bindParam(3,$IDactividad);
	$insert->bindParam(4,$Unidad);
	$insert->bindParam(5,$Horas);
	$insert->bindParam(6,$cant_usada);
	$insert->bindParam(7,$total_horas);
	$insert->execute();//ejecuta la instruccion
	}
?>
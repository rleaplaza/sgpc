<?php
require_once("../../db/connect.php");//llama a la conexion a base de datos
	require_once("generaNumero.php");//genera el identificador del registro
function updateAvanceMat($IDmaterial,$IDactividad,$CantUsada){//función para registrar el informe de material
	global $dbh;
	$identificador=generaNumero();//función para generar el identificador
	#consulta de inserción para el informe de uso de materiales
	$sql=$dbh->prepare("insert into informematerial values(?,?,?,?,curdate())");
	$sql->bindParam(1,$identificador);//enlaza al identificador
	$sql->bindParam(2,$IDmaterial);//enlaza al id de material
	$sql->bindParam(3,$IDactividad);//enlaza al id de actividad
	$sql->bindParam(4,$CantUsada);//enlaza a la cantidad usada
	$sql->execute();//ejecuta la instruccion
}
?>
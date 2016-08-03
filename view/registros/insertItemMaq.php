<?php
require_once("../../db/connect.php");
function insertItemMaq($cantidad,$idmaquinaria){
	global $dbh;
	$desc="Item correspondiente a la maquinaria";
	$estado="Alquilado";
	for($i=0;$i<$cantidad;$i++){
	$insertItem=$dbh->prepare("insert into item_maquinaria values(null, ?,?,?,curdate(),curtime())");
	$insertItem->bindParam(1,$idmaquinaria);
    $insertItem->bindParam(2,$desc);
	$insertItem->bindParam(3,$estado);
	$insertItem->execute();
	}
	}
?>
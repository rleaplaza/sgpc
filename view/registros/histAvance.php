<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	require_once("generaNumero.php");
	function histAvance($cedula,$IDactividad,$UnidadTrabajo,$Totalhras,$Unidadav,$AvanceInf,$Desc){
		global $dbh;
		$identificador=generaNumero();
		$sql=$dbh->prepare("insert into informetrabajador values(?,?,?,?,?,?,?,?,curdate(),curtime())");
		$sql->bindParam(1,$identificador);
		$sql->bindParam(2,$cedula);
		$sql->bindParam(3,$IDactividad);
		$sql->bindParam(4,$UnidadTrabajo);
		$sql->bindParam(5,$Totalhras);
		$sql->bindParam(6,$Unidadav);
		$sql->bindParam(7,$AvanceInf);
		$sql->bindParam(8,$Desc);
		$sql->execute();
		
		}
	}
?>
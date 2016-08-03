<?php
require_once("../db/connect.php");
function generaPedido($Nro,$IDactividad,$Fechas,$IDplan){
	global $dbh;
	$sql=$dbh->prepare("insert into pedido_almacen values(?,null,null,?,?,null,?,'Pendiente',curdate())");
	$sql->bindParam(1,$Nro);
	$sql->bindParam(2,$IDactividad);
	$sql->bindParam(3,$IDplan);
	$sql->bindParam(4,$Fechas);
	if($sql->execute()){
		$consulta=$dbh->prepare("select Nro_pedido from pedido_almacen where IDactividad=?");
		$consulta->bindParam(1,$IDactividad);
		if($consulta->execute()){
			$result=$consulta->fetch();
			$nro=$result[0];
			return $nro;
			}
		}
	}
?>
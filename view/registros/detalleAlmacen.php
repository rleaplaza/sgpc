<?php
require_once("../../db/connect.php");//llama a la conexión a base de datos
function detalleAlmacen($Nro){//función detalle de almacén con el paraámetro nro
	global $dbh;
	$sql=$dbh->prepare("select IDmaterial, descripcion, cant_disponible, unidad from material where cant_disponible>0");
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $row){
			$idmaterial=$row[0];
			$desc=$row[1];
			$cant=$row[2];
			$unidad=$row[3];
			$insert=$dbh->prepare("insert into det_pedido_almacen values(?,?,?,?,?)");
			$insert->bindParam(1,$Nro);
			$insert->bindParam(2,$idmaterial);
			$insert->bindParam(3,$desc);
			$insert->bindParam(4,$cant);
			$insert->bindParam(5,$unidad);
			$insert->execute();
			
			}
		}
	}
?>
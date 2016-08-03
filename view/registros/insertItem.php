<?php
require_once("../../db/connect.php");
function InsertItem($IDmaterial,$cant){
	global $dbh;
	$consultaCantidad=$dbh->prepare("select cant_disponible from material where IDmaterial=?");
					$consultaCantidad->bindParam(1,$IDmaterial);
					$consultaCantidad->execute();
					if($consultaCantidad->rowCount()>0){
						foreach($consultaCantidad ->fetchAll() as $row){
						  $cont=$row[0];
						  for($i=0;$i<$cont;$i++){
							     $desc="Item correspondiente al material";
								 $estado="Almacenado";
			$insertItem=$dbh->prepare("insert into item_material values(null,?,?,?,curdate(),curtime())");
			$insertItem->bindParam(1,$IDmaterial);
			$insertItem->bindParam(2,$desc);
			$insertItem->bindParam(3,$estado);
			$insertItem->execute();
							  }
						
						}
					}
	}
?>
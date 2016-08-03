<?php
try{
function consultaMensaje($optID){
	global $dbh;
	$sql=$dbh->prepare("select Descripcion from ayuda_opcion where IDopcion=?");
	$sql->bindParam(1,$optID);
	$sql->execute();
	$fila=$sql->fetch();
	$desc=$fila["Descripcion"];
	return $desc;
	}
}catch(PDOException $e){
	echo "Error inesperdo";
	}
?>
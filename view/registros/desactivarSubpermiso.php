<?php
try{
require_once("../../db/connect.php");
$pagina=$_POST["codPagina"];
$userId=$_POST["IDusuario"];
$consulta=$dbh->prepare("Select *from permiso_pagina where IDpagina=? and USR_UID=?");
$consulta->bindParam(1,$pagina);
$consulta->bindParam(2,$userId);
$consulta->execute();
if($consulta->rowCount()>0){
	$sql=$dbh->prepare("delete from permiso_pagina where IDpagina=? and USR_UID=?");
	$sql->bindParam(1,$pagina);
	$sql->bindParam(2,$userId);
	$sql->execute();
	if($sql){
		echo("SubPermiso Eliminado");?>
        <img src="no.jpg" width="15" height="15"  alt=""/><br>
        <?php
		}
	}
	else{
		echo("SubPermiso no asignado aun");?>
        <img src="no.jpg" width="15" height="15"  alt=""/><br>
        <?php
		}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}

?>
<?php
#este subprograma se encarga de actualizar la cantidad solicitada y entregada de materiales para correspondientes actividades
require_once("../../db/connect.php");//llama a la conexion a base de datos
function updateCantidadAsignada($idactividad,$idmaterial,$cantidad){//actualiza la cantidad de material
	global $dbh;
	$update=$dbh->prepare("update actividad_material set cant_solicitada=cant_solicitada+? 
	                       where IDmaterial=? and IDactividad=?");//consulta de actualicacion de cantidades solicitadase
	$update->bindParam(1,$cantidad);
	$update->bindParam(2,$idmaterial);
	$update->bindParam(3,$idactividad);
	$update->execute();
	}
?>
<?php
require_once("../db/connect.php");//archivo de conexión a la base de datos
require_once("generaPassword.php");//archivo que genera el password
require_once("../view/registros/generaNumero.php");//archivo que genera el código de la solicitud
function updatePassword($user,$email,$usr_uid){
	global $dbh;
	$idsolicitud=generaNumero();
	$password=generaPassword();//invoca a la función para generar el nuevo password
	$nuevopassword=sha1($password);//encripta el password
	$auxPassword=$password;//variable auxiliar que almacena el password sin encriptar para enviarlo al email del usuario
	$sql=$dbh->prepare("update usuario set password=?, confpwd=? where username=?");//actualiza el password del usuario
	#enlaza el nuevo password encriptado para guardarlo en la base de datos
	$sql->bindParam(1,$nuevopassword);//password encriptado
	$sql->bindParam(2,$nuevopassword);//el mismo valor para el campo de confirmación de password
	$sql->bindParam(3,$user);//nombre de usuario
	$sql->execute();//ejecuta la instrucción

		//registro de la solicitud del password
	$insert=$dbh->prepare("insert into solicitud_password values(?,?,?,curdate(),curtime())");
	$insert->bindParam(1,$idsolicitud);
	$insert->bindParam(2,$usr_uid);
	$insert->bindParam(3,$nuevopassword);
	$insert->execute();
	return $auxPassword;//retorna el nuevo password
	
	}
?>
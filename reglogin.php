<?php
#Este programa registra la información de la sesión
require_once("db/connect.php");//archivo de conexión a base de datos
try{
	function reglogin($sessionID,$usr_uid){//función para el registro de la sesión
		global $dbh;//la variable dbh debe ser global para instanciar a la clase PDO
	$ip=$_SERVER["REMOTE_ADDR"];//captura la IP
	$user=$_SESSION["username"];//captura el nombre de usuario
	#consulta de insersión de la sesión en base a los parámetros usados por el símbolo ?
$sql=$dbh->prepare("insert into sesion(IDsession, USR_UID, username,fecInicio, hraInicio,dirIP)  values(?,?,?,curdate(),curtime(),?)");
$sql->bindParam(1,$sessionID);
$sql->bindParam(2,$usr_uid);
$sql->bindParam(3,$user);
$sql->bindParam(4,$ip);
$sql->execute();
	}
		}catch (PDOException $e){
			echo "Error inesperado".$e->getMessage();//genera una excepción en caso de que la conexión falle
			}
	
?>
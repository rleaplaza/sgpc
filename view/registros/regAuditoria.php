<?php
#Este programa se encarga de guardar registroe en el log de auditoría para controlar los programas a los que se accede
try{
	require_once("genera.php");//archivo para generar el Identificador
	//require_once("../../db/connect.php");//archivo de conexión a la base de datos
	function regAuditoria($menu,$submenu,$opcion){//función para registrar el log de auditoría
		global $dbh;//la variable para llamar a la conexión debe ser global dentro de funciones
		#consulta para recuperar el ID, nombre de usuario y rol respectivos
		$consulta=$dbh->prepare("SELECT usuario.USR_UID, username, nombreRol
                                FROM usuario, rol
                                WHERE usuario.IDrol=rol.IDrol
                                AND username = ?");
		$consulta->bindParam(1,$_SESSION["username"]);//enlaza al nombre de usuario
		$consulta->execute();//ejecuta la instrucción
		$row=$consulta->fetch();//el resultado se devuelve en un arreglo
		$usrUid=$row["USR_UID"];//asigna el id de usuario
		$rol=$row["nombreRol"];//asigna el nombre de rol
		$ident=generaCodigo();//función para generar el identificador
		$ip=$_SERVER["REMOTE_ADDR"];//captura de la dirección ip
		$browser=$_SERVER["HTTP_USER_AGENT"];//captura el navegador web
		//consulta de registro usando los parámetros asignados
		$sql=$dbh->prepare("insert into auditoria values(?,?,?,?,curdate(),curtime(),?,?,?,?,?)");
		#enlaza los parámetros para insertarlos en el registro
		$sql->bindParam(1,$ident);
		$sql->bindParam(2,$usrUid);
		$sql->bindParam(3,$_SESSION["username"]);
		$sql->bindParam(4,$rol);
		$sql->bindParam(5,$ip);
		$sql->bindParam(6,$menu);
		$sql->bindParam(7,$submenu);
		$sql->bindParam(8,$opcion);
		$sql->bindParam(9,$browser);
		$sql->execute();
		$ultimo=$dbh->lastInsertId();
		$query=$dbh->prepare("delete from auditoria where Identificador=?");
		$query->bindParam(1,$ultimo);
		$query->execute();
		return $sql;
		}
}
		catch(PDOException $e){
			echo("Error inesperado".$e->getMessage());
			}

?>
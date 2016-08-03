<?php
#este programa se encarga de actualizar estados de actividades que no se han iniciado en la fecha determinada
#La ejecución se realiza despues de iniciar la sesión, en caso de que no se cumpla la condición, la ejecución no se realiza
function updateAct(){
	global $dbh;//declaración global de la variable
	$sql=$dbh->prepare("select curdate()");//prepara la sentencia sql
	if($sql->execute()){//si ejecuta la instrucción definirá el arreglo
		$result=$sql->fetch();
		$fechaActual=$result[0];//captura la fecha actual para realizar la consulta
#consulta para actualizar al estado sin comenzar en caso de que la fecha de comienzo sea menor a la fecha actual
		$update=$dbh->prepare("update actividad set finalizado='demorada' where fechaFin<? and finalizado!='finalizada'");
		$update->bindParam(1,$fechaActual);//enlaza a la fecha actual
		$update->execute();//ejecuta la instrucción
	}
		}
?>
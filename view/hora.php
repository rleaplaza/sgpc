<?php
#Este subprograma se encarga de recuperar la fecha y hora actual del sistema para ser impreso en todos los programas que requieran saber el momento de haber realizado algún registro de importancia
function getFecha(){
	global $dbh;//define la variable de conexión global a la base de datos
	$sql=$dbh->prepare("select curdate(), curtime()");//consulta para recuperar la fecha y hora actual
	$sql->execute();//ejecuta la instrucción
	$result=$sql->fetch();//devuelve el resultado en un arreglo
	$fecha=$result[0]." ".$result[1];//almacena las variables del arreglo concatenadas como fecha hora
	return $fecha;//retorna el valor de la fecha y hora actual del sistema para ser impreso en otros programas
	}
?>
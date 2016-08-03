<?php
#Este programa se encarga de registrar las cantidades de accesos de un usuario cada vez que realiza el login
require_once("db/connect.php");//archivo de conexión a la BD
require_once("view/registros/genera.php");//genera el identificador
try{
	function regvisitas(){//función para registrar la cantidad de accesos
		global $dbh;//variable global que instancia a la clase PDO
		$num=1;//cantidad por defecto a 1
		#consulta PDO para recuperar el user ID y el nombre de usuario
		$sql1=$dbh->prepare("select USR_UID,username from usuario where username=?");
		$sql1->bindParam(1,$_SESSION["username"]);//enlaza al nombre de usuario
		$sql1->execute();//ejecuta la instrucción
		$fila=$sql1->fetch();//devuelve el resultado en un arreglo
		$userId=$fila["USR_UID"];//almacena el user ID
		$username=$fila["username"];//almacena el nombre de usuario
		#consulta para recuperar la cantidad de accesos en base a la fecha actual y el usuario en sesión
		$query=$dbh->prepare("select num from contadoraccesos where fecha=curdate() and USR_UID=?");
		$query->bindParam(1,$userId);//enlaza el id de usuario
		$query->execute();//ejecuta la instrucción
		$numAcceso=$query->fetch();//recupera el registro en un arreglo
		
		if($query->rowCount()>0 && $numAcceso>=1){//si existe el registro y la cantidad de accesos es mayor o igual a 1 continúa la instrucción
			$numAcceso["num"]++;//aumenta la cantidad de accesos
			#consulta de actualización de la cantidad de accesos
			 $query2=$dbh->prepare("update contadoraccesos set num=? where fecha=curdate() and USR_UID=?");
			 $query2->bindParam(1,$numAcceso["num"]);//enlaza a la cantidad
			 $query2->bindParam(2,$userId);//enlaza el id de usuario
			 $query2->execute();//ejecuta la instrucción
			 }
		else{
			#en caso de no existir el registro procede con la siguiente instrucción
		$ip=$_SERVER["REMOTE_ADDR"];//captura la dirección IP
		$idAcceso=generaCodigo();//genera el identificador
		#consulta de registro del contador de accesos
		$sql=$dbh->prepare("insert into contadoraccesos values(?,?,curdate(),?,?,?)");
		#enlaza los parámetros según el símbolo ? donde cada parámetro debe enlazarse en base a dicho símbolo
		$sql->bindParam(1,$idAcceso);
		$sql->bindParam(2,$ip);
		$sql->bindParam(3,$num);
		$sql->bindParam(4,$userId);
		$sql->bindParam(5,$username);
		$sql->execute();
		}
		}
	}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
	}
?>
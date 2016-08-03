<?php
#Programa realizado por RODRIGO IVÁN LEA PLAZA CHÁVEZ
#Este programa se encarga de realizar la conexión a la base de datos, de este modo se podrá llamar globalmente a esta conexión desde los programas php
#Para este caso las consultas sql son ejecutadas mediante sentencias preparadas, las cuales son diferentes de las funciones propias de la librería mysql
#La extensión PDO brinda mejor seguridad a la aplicación
try{
	#la variable dbh realiza la instancia a la clase PDO para preparar las sentencias SQL que serán ejecutadas en los programas
$dbh=new PDO("mysql:host=localhost;dbname=dbserco","root","root");#llama a la clase PDO indicando la cadena de conexión
}catch(PDOException $e){#si la conexión falla se genera una excepción
	echo "Error de conexion".$e->getMessage();
	}
?>
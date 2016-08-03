<?php
try{
$dbh=new PDO("mysql:hostname=localhost;dbname=hist_dbserco","root","root");
}catch(PDOException $e){
	echo "Error de conexion".$e->getMessage();
	}
?>
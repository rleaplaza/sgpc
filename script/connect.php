<?php
try{
$dbh=new PDO("mysql:hostname=localhost;dbname=serco","root","root");
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>
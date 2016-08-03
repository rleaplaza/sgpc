<?php session_start();?>
<?php
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
	if(isset($_POST["idmaquinaria"])){
		try{
		require_once("../../db/connect.php");
		$idmaquinaria=$_POST["idmaterial"];
		$precio=$_POST["precio"];
		$unidad=$_POST["unidad"];
		$sql=$dbh->prepare("update maquinaria set precio_elemental=? where IDmaquinaria=?");
		$sql->bindParam(1,$precio);
		$sql->bindParam(2,$idmaquinaria);
		$sql->execute();
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
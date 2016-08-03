<?php session_start();?>
<?php
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
	if(isset($_POST["idmaterial"])){
		try{
		require_once("../../db/connect.php");
		$idmaterial=$_POST["idmaterial"];
		$precio=$_POST["precio"];
		$unidad=$_POST["unidad"];
		$sql=$dbh->prepare("update material set precio_bs=?,unidad=? where IDmaterial=?");
		$sql->bindParam(1,$precio);
		$sql->bindParam(2,$unidad);
		$sql->bindParam(3,$idmaterial);
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
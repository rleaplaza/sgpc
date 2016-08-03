<?php session_start();?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDparam"])){
		require_once("../../db/connect.php");
		try{
			$param=$_POST["IDparam"];
			$sql=$dbh->prepare("select *from parametro where IDparametro=?");
			$sql->bindParam(1,$param);
			$sql->execute();
			if($sql->rowCount()>0){
				$delete=$dbh->prepare("delete from parametro where IDparametro=?");
				$delete->bindParam(1,$param);
				if($delete->execute()){
					echo "Parámetro eliminado";
					}else{
					echo "No se pudo eliminar el parámetro";	
						}
				}
			}catch(PDOException $e){
			echo "Error inesperado";
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
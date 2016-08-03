<?php
session_start();
?>
<?php
if(isset($_POST["idmenu"])){
	try{ require_once("../../db/connect.php");
		$idmenu=$_POST["idmenu"];
		//$menu=$_POST["menu"];
		$desc=$_POST["desc"];
		$editMenu=editMenu($idmenu,$desc);
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
function editMenu($IDmenu,$descripcion){
	global $dbh;
	$sql=$dbh->prepare("update menu set descripcion=? where IDmenu=?");
	$sql->bindParam(1,$descripcion);
	$sql->bindParam(2,$IDmenu);
	$sql->execute();
	
	return $sql;
	}
?>
<?php
session_start();
?>
<?php
if(isset($_POST["idsubmenu"])){
	try{ require_once("../../db/connect.php");
		$idsubmenu=$_POST["idsubmenu"];
		$submenu=strtoupper(trim($_POST["submenu"]));
		$editSubMenu=editSubMenu($idsubmenu,$submenu);
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
function editSubMenu($IDsubmenu,$submod){
	global $dbh;
	$sql=$dbh->prepare("update submenu set nombreSubmenu=? where IDsubMenu=?");
	$sql->bindParam(1,$submod);
	$sql->bindParam(2,$IDsubmenu);
	$sql->execute();
	
	return $sql;
	}
?>
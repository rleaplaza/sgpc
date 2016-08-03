<?php
session_start();
?>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	if(isset($_POST["submenu"]) && $_POST["idmenu"]){
	$idmenu=$_POST["idmenu"];
	$submenu=strtoupper(trim($_POST["submenu"]));
	$insertsubMenu=insertasubMenu($idmenu,$submenu);
	}
}
else{
	header("location: ../../index.php");
	}
	
function insertasubMenu($idmodulo,$submodulo){
	global $dbh;
	$sql=$dbh->prepare("insert into submenu values('null',?,?,curdate(),curtime())");
	$sql->bindParam(1,$idmodulo);
	$sql->bindParam(2,$submodulo);
	$sql->execute();
	}
?>
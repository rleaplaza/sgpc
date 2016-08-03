<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
try{
	require_once("../../db/connect.php");
	require_once("userProperties.php");
	function updateCuenta($mail,$pwrd,$cnfpwd,$noti){
			global $dbh;
$sql=$dbh->prepare("update usuario set email=?,password=?,confpwd=?,notificar_sesion=? where username=?");
			$sql->bindParam(1,$mail);
			$sql->bindParam(2,$pwrd);
			$sql->bindParam(3,$cnfpwd);
			$sql->bindParam(4,$noti);
			$sql->bindParam(5,$_SESSION["username"]);
			$sql->execute();
				 header("location: editCuenta.php");
			//return $sql;
			}
	$email=$_POST["email"];
	$pwd=trim(sha1($_POST["password"]));
	$cfpwd=trim(sha1($_POST["confpassword"]));
	$notificacion=$_POST['notificacion'];
	          updateCuenta($email,$pwd,$cfpwd,$notificacion);
			  $sql1=$dbh->prepare("select USR_UID from usuario where username=?");
			  $sql1->bindParam(1,$_SESSION["username"]);
			  $sql1->execute();
			  $row=$sql1->fetch();
			  $userID=$row["USR_UID"];
			  userProperties($userID,$pwd);
		}catch(PDOException $e){
		echo("Error inesperado".$e->getMessage());
		}
		
}
	else{
		header("location: ../../index.php");
		}
?>
</body>
</html>
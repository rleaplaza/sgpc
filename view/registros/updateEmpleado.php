<?php
session_start();
?>
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
		function updateEmpleado($salario,$USR_UID){
			global $dbh;
		 $sql=$dbh->prepare("update empleado set haberBasico=? where USR_UID=?");
		 $sql->bindParam(1,$salario);
		 $sql->bindParam(2,$USR_UID);
		 $sql->execute();
			
			}
		$sueldo=trim($_POST["salario"]);
		$userId=$_POST["userId"];
		$update=updateEmpleado($sueldo,$userId);
		}catch(PDOException $e){
			echo("Error inesperado".$e->getMessage());
			}
	}else{
		header("location: ../../index.php");
		}
?>
</body>
</html>
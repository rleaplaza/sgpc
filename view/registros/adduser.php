<?php
session_start();
?>
<?php
if(isset($_SESSION["username"])){
try{
	require_once("generacodigo.php");
	require_once("../../db/connect.php");
	//captura de variables
	$username=trim(strtolower(str_replace(' ','',$_POST["username"])));
	$email=trim($_POST["email"]);
	$password=sha1($_POST["password"]);
	$confpassword=sha1($_POST["confpassword"]);
	if(isset($_POST["nombre"]) && isset($_POST["app"]) && isset($_POST["apm"])){
	$nombre=trim(ucfirst(strtolower($_POST["nombre"])));
	$app=trim(ucfirst(strtolower($_POST["app"])));
	$apm=trim(ucfirst(strtolower($_POST["apm"])));
	$usruid=generacodigo($nombre,$app,$apm);
	} else{
		$num=rand(100,1000);
		$usruid=$username."2014".$num;
		}
	$ci=trim($_POST["cedula"]);
	echo $ci;
	if($ci==null){
	//guardar registro
	$sql=$dbh->prepare("insert into usuario values(?,?,null,?,?,?,'activo',curdate(),curtime(),null,'no')");
	$sql->bindParam(1,$usruid);
	$sql->bindParam(2,$username);
	$sql->bindParam(3,$email);
	$sql->bindParam(4,$password);
	$sql->bindParam(5,$confpassword);	
	if($sql->execute()){
		echo "Registro realizado"; 
		}  else{
			echo "Hubo un error al registrar al usuario";
			}
	}else{
		$sql=$dbh->prepare("insert into usuario values(?,?,?,?,?,?,'activo',curdate(),curtime(),null,'no')");
	$sql->bindParam(1,$usruid);
	$sql->bindParam(2,$username);
	$sql->bindParam(3,$ci);
	$sql->bindParam(4,$email);
	$sql->bindParam(5,$password);
	$sql->bindParam(6,$confpassword);
	$sql->execute();
		}
	 
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
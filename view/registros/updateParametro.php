<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["Nombre"])){
		require_once("../../db/connect.php");
		try{
			$idparam=$_POST["IDparam"];
			$param=$_POST["Nombre"];
			$valor=$_POST["Valor"];
			if((preg_match('/^[a-zA-Z]/',$param)) && (preg_match('/^[0-9]+(\.[0-9]+)?$/',$valor))){
			$sql=$dbh->prepare("update parametro set nombre=?, valor=? where IDparametro=?");
			$sql->bindParam(1,$param);
			$sql->bindParam(2,$valor);
			$sql->bindParam(3,$idparam);
			if($sql->execute()){
				echo "Registro actualizado";
				}else{
				echo "No se pudo actualizar el registro";	
			}
				}else{
				echo "El tipo de dato no coincide";		
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
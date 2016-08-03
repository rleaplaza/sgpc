<?php session_start();//funcion de inicio de sesion?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){//verifica la existenaia de sesion
	if(isset($_POST["Nombre"])){//verifica la existencia del parametro
		require_once("../../db/connect.php");//llama a la conexion a base de datos
		require_once("genera.php");//genera el identificador
		try{
		$idparam=generaCodigo();//genera el identificador
		$nombre=$_POST["Nombre"];//captura el nombre del parametro
		$valor=$_POST["Valor"];//captura el valor 
		if((preg_match('/^[a-zA-Z]/',$nombre)) && (preg_match('/^[0-9]+(\.[0-9]+)?$/',$valor))){
			#Registro del parametro
			$sql=$dbh->prepare("insert into parametro values(?,?,?,curdate(),curtime())");
			$sql->bindParam(1,$idparam);
			$sql->bindParam(2,$nombre);
			$sql->bindParam(3,$valor);
			if($sql->execute()){
				echo "Parámetro registrado";//mensaje de confirmacion
				?>
              <img src="yes.jpg" height="25" width="25">
                <?php
				}else{
				echo "No se pudo guardar el parámetro";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php	
					}
			}else{
				echo "Al menos un campo es incorrecto";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>
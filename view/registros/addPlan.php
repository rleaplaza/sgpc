<?php session_start();//funcion de inicio de sesion?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesion
	if(isset($_POST["IDproyecto"])){//verifica la existencia del id del proyecto
		require_once("../../db/connect.php");//llama a la conexion
		require_once("generaNumero.php");//llama a la generacion de nro identificador
		try{
			
			}catch(PDOException $e){
				echo "Error inesperado";
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}

?>
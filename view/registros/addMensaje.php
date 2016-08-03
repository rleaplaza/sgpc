<?php session_start();//inicia la sesión?>
<html>
<meta charset="utf-8">
<?php
#Este programa se encarga de realizar registro de mensajes de ayuda
try{
	sleep(1);//función para retardar la ejecución
if(isset($_SESSION["username"])){//valida la existencia de sesión e id de opción
	if(isset($_POST["codOpcion"])){
		require_once("../../db/connect.php");//archivo de conexión a la base de datos
		require_once("genera.php");//archivo para genera el ID aleatorio
		
		$idmensaje=generaCodigo();//genera el ID aleatorio
		$idopcion=$_POST["codOpcion"];//captura de variables de opción y descripción del mensaje
		$desc=$_POST["Descripcion"];
		#consulta para verificar si el mensaje de ayuda ya existe
		$consulta=$dbh->prepare("select *from ayuda_opcion where IDopcion=?");
		$consulta->bindParam(1,$idopcion);
		$consulta->execute();
		if($consulta->rowCount()){//mensaje de confirmación
			echo "Esta opción ya tiene mensaje de ayuda";
			?>
              <img src="no.jpg" height="20" width="20">
            <?php
			}else{
				if($desc==null){//valida que se deba ingresar el ID de opción
					echo "Ingrese la descripción del mensaje";
					?>
                    <img src="no.jpg" height="20" width="20">
                    <?php
					}else{
						#consulta de registro del mensaje de ayuda
		$sql=$dbh->prepare("insert into ayuda_opcion values(?,?,?,curdate(),curtime())");
		#enlaza a los parámetros
		$sql->bindParam(1,$idmensaje);
		$sql->bindParam(2,$idopcion);
		$sql->bindParam(3,$desc);
		if($sql->execute()){//mensaje de confirmación si la instrucción fue ejecutada
			echo "Mensaje de ayuda registrado";
			?><img src="yes.jpg" height="20" width="20">
            <?php
			}else{
			  echo "Error al registrar el mensaje";	
				}		
				}
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
}catch(PDOException $e){
	echo "Error inesperado";
	}
?>
</html>

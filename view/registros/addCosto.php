<?php session_start();//función de inicio de sesión?>
<?php
#Este programa se encarga de registrar costos fijos
if(isset($_SESSION["username"])){//verifia la existencia de la sesión
	if(isset($_POST["Valor"])){//verifica la existencia del valor de costo
		require_once("../../db/connect.php");//llama a la conexión a base de datos
		$desc=$_POST["Desc"];//captura de descripción
		$valor=$_POST["Valor"];//captura de valor de costo
		#consulta de comprobación de registro de costos fijos
		$consulta=$dbh->prepare("select *from costofijo where descripcion=?");
		$consulta->bindParam(1,$desc);//enlaza a la descripción
		$consulta->execute();
		if($consulta->rowCount()>0){
			echo "Costo existente";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				#consulta de inserción de costos fijos
				$insert=$dbh->prepare("insert into costofijo values(null,?,?)");
				$insert->bindParam(1,$desc);//enlaza a la descripción
				$insert->bindParam(2,$valor);//enlaza al valor
				if($insert->execute()){
					echo "Registro guardado";
					?>
                    <img src="yes.jpg" height="20" width="20">
                    <?php
					}else{
						echo "No se pudo guardar el costo";
						?>
                        <?php
						}
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>
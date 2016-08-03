<?php session_start();?>
<?php 
#Este programa se encarga de realizar el cálculo de valores acumulados
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	if(isset($_POST["IDproyecto"])){//verifica la existencia del ID del proyecto
		require_once("../../db/connect.php");//llama a la conexión a base de datos
		#captura de las variables
		$idproyeco=$_POST["IDproyecto"];
		$CostoProg=$_POST["CostoProg"];
		$Progreso=$_POST["Progreso"];
		$consulta=$dbh->prepare("select *from valor_acumulado where progreso=? and IDproyecto=?");
		$consulta->bindParam(1,$Progreso);
		$consulta->bindParam(2,$idproyeco);
		$consulta->execute();
		if($consulta->rowCount()>0){
			echo "El progreso ya está registrado";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				$valorProgreso=$Progreso/100;
				$valorAcumulado=$CostoProg*$valorProgreso;
				$insert=$dbh->prepare("insert into valor_acumulado values(null,?,?,?,curdate())");
				$insert->bindParam(1,$idproyeco);
				$insert->bindParam(2,$Progreso);
				$insert->bindParam(3,$valorAcumulado);
				if($insert->execute()){
					echo "Valor acumulado registrado";
					?>
                    <img src="yes.jpg" height="20" width="20">
                    <?php
					}else{
						echo "No se pudo registrar el valor";
						?>
                        <img src="no.jpg" height="20" width="20">
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
<?php session_start();?>
<meta charset="utf-8">
<?php
#Este programa realiza el registro de horarios de trabajo para los participantes del proyecto
if(isset($_SESSION["username"])){
	if(isset($_POST["Nombre"])){
		#llamada a los archivos de base de datos, generación de nro identificador y diferencia de horas
		require_once("../../db/connect.php");
		require_once("generaNumero.php");
		require_once("restaHoras.php");
		$idcalendario=generaNumero();//llama a la función
		#captura de variables
		$nombre=$_POST["Nombre"];
		$ci=$_POST["CI"];
		$desc=$_POST["Desc"];
		$hrainicio=$_POST["HraInicio"];
		$hrafinal=$_POST["HraFin"];
		#captura de la duración en base a la función diferencia de horas
		$duracion=RestarHoras($hrainicio,$hrafinal);
		if($duracion<="04:00:00"){
			#no se permiten horarios menores a medio tiempo
			echo "No se permite ingresar horarios menores a medio tiempo";
			}else if($duracion>="08:00:00"){
				echo "No se permiten horarios superiores a 8 horas";
				} else{
		$sql=$dbh->prepare("select *from calendario_trabajador where CI_trabajador=?");
		$sql->bindParam(1,$ci);
		$sql->execute();
		if($sql->rowCount()>0){
			#mensaje que indica que el horario del trabajador ya se encuentra en sistema
			echo "Calendario ya registrado<br>";
			#en caso de existencia se realizará la actualización de hroarios
			$update=$dbh->prepare("update calendario_trabajador set descripcion=?, hraInicio=?, horaFin=?, duracion=? where CI_trabajador=?");
			#enlaza a los parámetros requeridos
			$update->bindParam(1,$desc);
			$update->bindParam(2,$hrainicio);
			$update->bindParam(3,$hrafinal);
			$update->bindParam(4,$duracion);
			$update->bindParam(5,$ci);
			if($update->execute()){
				echo "Horario actualizado";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}else{
					echo "No se pudo actualizar el calendario";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
					}
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
		if($hrainicio>$hrafinal){
			echo "La hora de inicio no debe ser mayor";
			?>
            <img src="no.jpg" height="25" width="25">
            <?php
			}else{
				#la expresión regular evaluará el formato de hora para evitar ingreso de tipos de datos incoherentes
if(!(preg_match('/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])[\:]([0-5][0-9])$/',$hrainicio)) || !(preg_match('/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])[\:]([0-5][0-9])$/',$hrafinal))){
					echo "Formato de hora incorrecta";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
					}else{
						#consulta PDO para registrar el horario del trabajador
			        $insert=$dbh->prepare("insert into calendario_trabajador values(?,?,?,?,?,?)");
					#enlaza a los parámetros
					$insert->bindParam(1,$idcalendario);
					$insert->bindParam(2,$ci);
					$insert->bindParam(3,$desc);
					$insert->bindParam(4,$hrainicio);
					$insert->bindParam(5,$hrafinal);
					$insert->bindParam(6,$duracion);
					if($insert->execute()){
						echo "Horario registrado<br>";
						?>
                        <img src="yes.jpg" height="25" width="25">
                        <?php
						}else{
							echo "No se pudo registrar el calendario";
							?>
                            <img src="no.jpg" height="25" width="25">
                            <?php
							}
						}
				}
			}
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
	}
?>

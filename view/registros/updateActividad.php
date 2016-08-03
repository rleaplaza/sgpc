<?php session_start();?>
<?php
require_once("../../db/connect.php");
if(isset($_POST["IDactividad"])){
	try{
		$idactividad=$_POST["IDactividad"];
		$fechaFin=$_POST["FechaFin"];
		$fechaInicio=$_POST["FecIni"];
		$avance=$_POST["Avance"];
		$fecInicioAnterior=$_POST["FecIniAnt"];
		$sql=$dbh->prepare("select curdate()");
		$sql->execute();
		$fila=$sql->fetch();
		$fechaActual=$fila[0];
		if($fechaFin<$fechaInicio){
	          echo "La fecha de inicio no puede ser mayor";
			}else{
				if($fechaFin>$fechaActual || $fechaInicio>$fechaActual){
					if($avance==0){
						$estado="reprogramada";
						$dias=getDias($fechaInicio,$fechaFin);
						$update=$dbh->prepare("update actividad set fechaRealizacion=?, fechaFin=?,
						                       duracion_dias=?,finalizado=?
						                       where IDactividad=?");
					    $update->bindParam(1,$fechaInicio);
						$update->bindParam(2,$fechaFin);
						$update->bindParam(3,$dias);
						$update->bindParam(4,$estado);
						$update->bindParam(5,$idactividad);
						if($update->execute()){
							echo "Actividad actualizada";
							?>
                            <img src="yes.jpg" height="20" width="20">
                            <?php
							}else{
								echo "No se pudo actualizar la actividad";
								?>
                              <img src="no.jpg" height="20" width="20">  
                                <?php
								}
						}else{
							$estado="reprogramada";
							$duracion=getDias($fecInicioAnterior,$fechaFin);
							$update1=$dbh->prepare("update actividad set fechaFin=?, duracion_dias=?,finalizado=?
							                        where IDactividad=?");
						    $update1->bindParam(1,$fechaFin);
							$update1->bindParam(2,$duracion);
							$update1->bindParam(3,$estado);
							$update1->bindParam(3,$idactividad);
							if($update1->execute()){
								echo "Actividad reprogramada";
								?>
                                <img src="yes.jpg" height="20" width="20">
                                <?php
								}else{
									echo "No se pudo reprogramar la actividad";
									?>
                                    <img src="no.jpg" height="20" width="20">  
                                    <?php
									}
							}
					}else{
						echo "Las fechas de inicio y fin no pueden ser menores a la fecha actual";
						?>
                         <img src="no.jpg" height="20" width="20"> 
                        <?php
						}
				}
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
	function getDias($fec1,$fec2){//función para recuperar la cantidad de días del proyecto
	$segundos=strtotime($fec2) - strtotime($fec1);//convierte a segundos para realizar la diferencia
$diferencia_dias=intval($segundos/60/60/24);//convierte a valor entero
$dias=abs($diferencia_dias);//valor absoluto para convertir el valor de días a positivo
return $dias;//devuelve la cantidad de días
	}
?>
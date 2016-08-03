<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de realizar asignaciones de actividades
#a trabajadores participantes en el proyecto
if(isset($_SESSION["username"])){//valida la existencia de sesión
	require_once("../../db/connect.php");//conecta con la base de datos
	require_once("updatePropiedadActividad.php");
	if(isset($_POST["IDactividad"])){//valida si existe la variable actividad
		#captura de variables con el metodo $_POST
		$idactividad=$_POST["IDactividad"];
		$ci=$_POST["CI"];
		$idplan=$_POST["IDplan"];
		$unidad=$_POST["Unidad"];
		#consulta existencia de asignación
		$sql=$dbh->prepare("select *from actividad_trabajador where IDactividad=? and CI_trabajador=?");
		$sql->bindParam(1,$idactividad);
		$sql->bindParam(2,$ci);
		$sql->execute();
		if($sql->rowCount()>0){
			echo "Trabajador ya asignado a la actividad";
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				#calculo del porcentaje de participación según el calendario definido
				$consulta=$dbh->prepare("select duracion from calendario_trabajador where CI_trabajador=?");
				$consulta->bindParam(1,$ci);
				$consulta->execute();
				if($consulta->rowCount()>0){
				$result=$consulta->fetch();
				$duracion=$result[0];
				#En base a normas de trabajo, los horarios son de 4 a 8 horas en adelante, por lo que dentro
				#de este rango se definirán los porcentajes de participación
				if($duracion=="08:00:00"){
					$porc_part=100;
					}else if($duracion>="07:30:00"){
						$porc_part=93.75;
						}else if($duracion<="07:00:00"){
							$porc_part=87.5;
							}else if($duracion<="06:30:00"){
								$porc_part=81.25;
								}else if($duracion<="06:00:00"){
									$porc_part=75;
									}else if($duracion<="05:30:00"){
										$porc_part=68.75;
										}else if($duracion<="05:00:00"){
											$porc_part=62.5;
											} else if($duracion<="04:30:00"){
												$porc_part=56.25;
												} else
												$porc_part=50;
				$query=$dbh->prepare("select precioUnitario from cargomanodeobra as cm, personalmanoobra as pm
				                      where cm.IDcargoM=pm.IDcargoM
									  and pm.CI_trabajador=?");
				$query->bindParam(1,$ci);
				$query->execute();
				$row=$query->fetch();
				$precio=$row[0];
				#registro de la asignación
		 $insert=$dbh->prepare("insert into actividad_trabajador values(?,?,?,?,?,null,null,0.00,?,0.00,null,curdate(),curtime())");
		 #enlaza todos los parámetros requeridos en al consulta
				$insert->bindParam(1,$idactividad);
				$insert->bindParam(2,$ci);
				$insert->bindParam(3,$idplan);
				$insert->bindParam(4,$porc_part);
				$insert->bindParam(5,$unidad);
				$insert->bindParam(6,$precio);
				if($insert->execute()){//ejecuta la instrucción
					echo "Asignación registrada";
				    updateAsignacionTrabajador($idactividad);
					#Todo trabajador que ya esté asignado a una actividad cambiará su estado
					#Esto con el fin de evitar asignaciones a un trabajador a más de una actividad
					#Al mismo tiempo, tomar en cuenta que un trabajador puede realizar varias
					#actividades, pero en diferentes ocasiones
		 $update=$dbh->prepare("update participa set asignado_actividad='si' where CI_trabajador=?");
		 $update->bindParam(1,$ci);
		 $update->execute();
		 
					?>
                    <img src="yes.jpg" height="25" width="25">
                    <?php
					}else{
					echo "No se pudo registrar la asignación";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php	
						}
				}else{
					#para registrar la asignación al trabajdor es requerido el haber definido su horario de trabajo
					#caso contrario aparecerá el siguiente mensaje
					echo "Debe definir el calendario del trabajador";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
					}
					}
		}else{
			header("location: ../../index.php");//La función header se encarga de devolver al usuario a la págian index si intenta un ingreso no autorizado
			}
	}else{
		header("location: ../../index.php");
		}
?>
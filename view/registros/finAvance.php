<?php session_start();?>
<meta charset="utf-8">
<?php 
#Este programa se encarga de realizar la finalización de actividades y el cálculo de costo por actividad
if(isset($_SESSION["username"])){
	if(isset($_POST["IDactividad"])){
		require_once("../../db/connect.php");#llama al archivo de conexión a la BD
		require_once("calculoTotal.php");
		require_once("updateFase.php");
		$idactividad=$_POST["IDactividad"];#captura de id de actividad
		$idproyecto=$_POST["IDproyecto"];#id del proyecto
		$idfase=$_POST["IDfase"];
		#consulta PDO para capturar la cantidad programada y la cantidad acumulada
		$query=$dbh->prepare("select *from actividad where IDactividad=? and finalizado='finalizada'");
		$query->bindParam(1,$idactividad);
		$query->execute();
		if($query->rowCount()>0){
			echo "Esta actividad se ha completado";
			?>
            <img src="yes.jpg" height="20" width="20">
			<?php
			}else{
		$sql=$dbh->prepare("select cantidad, total_avance from actividad where IDactividad=?");
		$sql->bindParam(1,$idactividad);
		$sql->execute();
		if($sql->rowCount()>0){
			$row=$sql->fetch();
			$cantidad=$row[0];//consulta la cantidad programada
			$avance=$row[1];//consulta la cantidad de avance real
			#finaliza el avance de actividad
				$update=$dbh->prepare("update actividad set finalizado='finalizada' where IDactividad=?");
				$update->bindParam(1,$idactividad);
				if($update->execute()){
					updateFase($idfase);
					#consulta la cantidad total de actividades
					$cuenta=$dbh->prepare("select count(*) as actividad from actividad, subfase, fase, proyecto
					                       where actividad.IDsubfase=subfase.IDsubfase
										   and subfase.IDfase=fase.IDfase
										   and fase.IDproyecto=proyecto.IDproyecto
										   and proyecto.IDproyecto=?");
					$cuenta->bindParam(1,$idproyecto);
					$cuenta->execute();
					$result=$cuenta->fetch();
					$cantidad=$result[0];
					#consulta la cantidad total de actividades finalizadas
					$cuenta1=$dbh->prepare("select count(*) as actividad from actividad, subfase, fase, proyecto
					                       where actividad.IDsubfase=subfase.IDsubfase
										   and subfase.IDfase=fase.IDfase
										   and fase.IDproyecto=proyecto.IDproyecto
										   and proyecto.IDproyecto=?
										   and finalizado='finalizada'");
					$cuenta1->bindParam(1,$idproyecto);
					$cuenta1->execute();
					$result1=$cuenta1->fetch();
					$cantidadFinalizada=$result1[0];
					$porcentaje_progreso=($cantidadFinalizada/$cantidad)*100;//porcentaje de progreso del proyecto
					calculoTotal($idactividad,$idproyecto,$porcentaje_progreso);
					//mensaje de confirmación
					echo "Actividad finalizada";
					#recuperación de cantidades de equipos pesados una vez la actividad haya terminado
						$consulta1=$dbh->prepare("select sum(cant_asignada) as cantidad, IDmaquinaria 
						                          from actividad_maquinaria 
												  where IDactividad=? 
												  group By IDmaquinaria");
						$consulta1->bindParam(1,$idactividad);
						$consulta1->execute();
						if($consulta1->rowCount()>0){
							foreach($consulta1->fetchAll() as $resultado)
							$cantidadMaq=$resultado[0];
							$idmaquinaria=$resultado[1];
	                        $updateEquipo=$dbh->prepare("update proyecto_maquinaria set cantidad=cantidad+? 
							                             where IDproyecto=? and IDmaquinaria=?");
							$updateEquipo->bindParam(1,$cantidadMaq);
							$updateEquipo->bindParam(2,$idproyecto);
							$updateEquipo->bindParam(3,$idmaquinaria);
							$updateEquipo->execute();
							
							}
	#consulta PDO para que los trabajadores asignados a la actividad finalizada queden disponibles para posteriores actividades
					$consulta=$dbh->prepare("select CI_trabajador from actividad_trabajador where IDactividad=?");
					$consulta->bindParam(1,$idactividad);#enlaza a la actividad
					$consulta->execute();#ejecuta la consulta
					if($consulta->rowCount()>0){
#el arreglo recorrerá todas las filas involucradas y posteriormente cambiará el estado de asignado a no asignado para posteriores actividades
						foreach($consulta->fetchAll() as $fila){
						$ci=$fila[0];#captura el índice de cédula
						#consulta PDO update para dejar al trabajador disponible	
						$update1=$dbh->prepare("update participa set asignado_actividad='no' 
						                        where CI_trabajador=? and IDproyecto=?");
						$update1->bindParam(1,$ci);
						$update1->bindParam(2,$idproyecto);
						$update1->execute();
							}
						}
					?>
                    <img src="yes.jpg" height="25" width="25">
                    <?php
					}else{
						echo "No se pudo actualizar la finalización";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
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

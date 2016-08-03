<?php
#Este programa se encarga de realizar los cálculos de precios unitarios para las actividades de un proyecto, determinando impuestos, utilizadas, gastos.
#El correspondiente cálculo se realizará una vez que la actividad se haya concluido
if(isset($_SESSION["username"])){
	if(isset($_POST["IDactividad"])){
		require_once("../../db/connect.php");
		function calculoTotal($IDactividad,$IDproyecto,$porcentaje){
        global $dbh;
		#consulta actividad
		$actMaterial=$dbh->prepare("select costo_total from actividad_material where IDactividad=?");
		$actMaterial->bindParam(1,$IDactividad);
		$actMaterial->execute();
		#si existen resultados asignará la sumatoria de totales
		if($actMaterial->rowCount()>0){
			$totalActividadMaterial=0;
			foreach($actMaterial->fetchAll() as $fila){
				#valor total por material
				$totalActividadMaterial=$totalActividadMaterial+$fila[0];
				}
			}else {$totalActividadMaterial=0;}
		#cálculo total por trabajador
		$actTrabajador=$dbh->prepare("select subtotal_Manoobra from actividad_trabajador where IDactividad=?");
		$actTrabajador->bindParam(1,$IDactividad);
		$actTrabajador->execute();
		if($actTrabajador->rowCount()>0){
			$totalcostoManoobra=0;
			foreach($actTrabajador->fetchAll() as $res){
				$totalcostoManoobra=$totalcostoManoobra+$res[0];
				}
			}else{
				$totalcostoManoobra=0;
				}
		#carga social
		$sql=$dbh->prepare("select valor from parametro where valor in(60.00)");
		$sql->execute();
		$res1=$sql->fetch();
		$valor1=$res1[0];
		#impuesto de mano de obra
		$sql2=$dbh->prepare("select valor from parametro where valor in(14.94)");
		$sql2->execute();
		$res2=$sql2->fetch();
		$valor2=$res2[0];
		#division al 100%
		$cs=$valor1/100;
		$iva=$valor2/100;
		#caculo de valor por impuestos
		$csTotal=$totalcostoManoobra*$cs;
		$ivaTotal=($totalcostoManoobra+$csTotal)*$iva;
		#valor total de mano de obra
		$totalManoobra=$totalcostoManoobra+$csTotal+$iva;
		#consulta del subtotal por maquinaria
		$actMaquinaria=$dbh->prepare("select costo_total from actividad_maquinaria where IDactividad=?");
		$actMaquinaria->bindParam(1,$IDactividad);
		$actMaquinaria->execute();
		$subtotalMaquinaria=0;
		foreach($actMaquinaria->fetchAll() as $result){
			$subtotalMaquinaria=$subtotalMaquinaria+$result[0];
			}
		#recuperación de impuesto por uso de equipos
		$sql=$dbh->prepare("select valor from parametro where valor in(5.00)");
		$sql->execute();
		$res3=$sql->fetch();
		$valor3=$res3[0];
		$porc=$valor3/100;
		$impuestoH=$subtotalMaquinaria*$porc;
		$totalequipo=$subtotalMaquinaria+$impuestoH;
		
		#calculo de gastos generales administrativos
		$gA=($totalActividadMaterial+$totalcostoManoobra+$totalequipo)*0.1;
		#calculo de impuesto por utilidad
		$IU=($totalActividadMaterial+$totalcostoManoobra+$totalequipo+$gA)*0.1;
		#calculo de impuesto a la transaccion, IT
		$IT=($totalActividadMaterial+$totalcostoManoobra+$totalequipo+$gA+$IU)*0.309;
		#costo total de la actividad
		$precioUnitario=$totalActividadMaterial+$totalcostoManoobra+$totalequipo+$gA+$IU+$IT;
		#Actualización del precio unitario para la actividad
		#captura de la cantidad programada de la actividad
		$query=$dbh->prepare("select cantidad from actividad where IDactividad=?");
		$query->bindParam(1,$IDactividad);
		$query->execute();
		$resultado=$query->fetch();
		$cantidad=$resultado[0];
		$costoTotal=$precioUnitario*$cantidad;
		#consulta PDO para registrar el costo total por actividad
$update=$dbh->prepare("update actividad set t_actmaterial=?,t_acmanoobra=?,t_acmaquinaria=?,t_gastoadm=?,t_utilidad=?,t_impuesto=?,precioUnitarioBS=?,costo_total=? where IDactividad=?");
#enlaza a los parámetros numéricos de los cálculos anteriores y ejecuta la instrucción
$update->bindParam(1,$totalActividadMaterial);
$update->bindParam(2,$totalcostoManoobra);
$update->bindParam(3,$totalequipo);
$update->bindParam(4,$gA);
$update->bindParam(5,$IU);
$update->bindParam(6,$IT);
$update->bindParam(7,$precioUnitario);
$update->bindParam(8,$costoTotal);
$update->bindParam(9,$IDactividad);
$update->execute();
#sumatoria de costos para el proyecto
$query=$dbh->prepare("select sum(costo_total) as total from actividad");
$query->execute();
if($query->rowCount()>0){
	$result=$query->fetch();
	$costoReal=$result[0];
#consulta dias usados de la actividad
$consulta=$dbh->prepare("select dias_usados from actividad where IDactividad=?");
$consulta->bindParam(1,$IDactividad);
$consulta->execute();
if($consulta->rowCount()>0){
	$row=$consulta->fetch();
	$dias_usados=$row[0];
	}
#actualiza el costo real para el proyecto
$updateCosto=$dbh->prepare("update proyecto set costo_real=?,porcentaje_progreso=?,duracion_real=duracion_real+? where IDproyecto=?");
$updateCosto->bindParam(1,$costoReal);
$updateCosto->bindParam(2,$porcentaje);
$updateCosto->bindParam(3,$dias_usados);
$updateCosto->bindParam(4,$IDproyecto);
$updateCosto->execute();
		}
		}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
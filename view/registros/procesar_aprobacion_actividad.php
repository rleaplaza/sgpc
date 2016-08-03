<?php
session_start();
?>
<?php
require_once("../../db/connect.php");
if(isset($_SESSION['username'])){
	if(isset($_POST['IDactividad']) && isset($_POST['Evaluar'])){
		$idactividad=$_POST['IDactividad'];
		$arreglo=array();
		$evaluar=$_POST['Evaluar'];
		if($evaluar=='aprobado'){
		 $motivo='';	
		}else{
			  $motivo=$_POST['Motivo'];
			$arreglo=array('idactividad'=>$idactividad,'evaluar'=>$evaluar,'motivo'=>$motivo);
		}
	$json=json_encode($arreglo);
	//INGRESAMOS LA EVALUACIÓN DE LA ACTIVIDAD
	$insert=$dbh->prepare("update actividad set aprobado=?, motivo_rechazo=?,criterios=? where IDactividad=?");
	$insert->bindParam(1,$evaluar);
	$insert->bindParam(2,$motivo);
	$insert->bindParam(3,$json);
	$insert->bindParam(4,$idactividad);
	if($insert->execute()){
		echo "Evaluación de actividad procesada";
		?>
        <img src="yes.jpg" height="10" width="10">
        <?php
	}else{
		echo "No se pudo procesar la actividad";
		?>
        <img src="no.jpg" height="10" width="10">
        <?php
		}
		}else{
			echo "Debe seleccionar la evaluación";
			}
	}else{
		header("location: ../../index.php");
		}
?>
<?php session_start();//inicio de sesion?>
<?php
#Este programa se encarga de realizar registro de proyectos
if(isset($_SESSION["username"])){
	if(isset($_POST["proyecto"])){
		try{
		require_once("../../db/connect.php");
		require_once("genera.php");//generacion de 
		require_once("insertPlan.php");//insercion de planificacion
		$proyecto=$_POST["proyecto"];
		$conv=$_POST["conv"];
		$depa=$_POST["depa"];
		$fecInicio=$_POST["fecInicio"];
		$fecFin=$_POST["fecFin"];
		$idempleado=$_POST["responsable"];
		$consulta=$dbh->prepare("select CI from empleado where IDempleado=?");
		$consulta->bindParam(1,$idempleado);
		$consulta->execute();
		$fila=$consulta->fetch();
		$responsable=$fila[0];
		$monto=$_POST["monto"];
		$insertProyecto=insertProyecto($proyecto,$conv,$depa,$responsable,$fecInicio,$fecFin,$monto);
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
		#funcion para registrar el proyecto
	function insertProyecto($proy,$convocatoria,$depa,$resp,$fecIni,$fecFinal,$amount){
		global $dbh;
		$idproyecto=generaCodigo();
		$duracion=getDias($fecIni,$fecFinal);
	$sql=$dbh->prepare("insert into proyecto values(?,?,?,?,?,?,?,?,0.00,'En ejecucion',?,0.00,0.00,curdate(),curtime())");
		$sql->bindParam(1,$idproyecto);
		$sql->bindParam(2,$convocatoria);
		$sql->bindParam(3,$depa);
		$sql->bindParam(4,$proy);
		$sql->bindParam(5,$resp);
		$sql->bindParam(6,$fecIni);
		$sql->bindParam(7,$fecFinal);
		$sql->bindParam(8,$duracion);
		$sql->bindParam(9,$amount);
		$sql->execute();
		insertPlan($idproyecto);
		}
	
	function getDias($fec1,$fec2){//funcion para recuperar el valor de dias del proyecto
	$segundos=strtotime($fec2) - strtotime($fec1);//convierte a horas
$diferencia_dias=intval($segundos/60/60/24);//convierte los segundos en valos numerico
$dias=abs($diferencia_dias);//valor absoluto
return $dias;
	}
?>
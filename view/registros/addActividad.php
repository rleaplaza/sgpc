<?php
session_start();//función de inicio de sesión
?>
<?php
#Este programa se encarga de registro de actividades correspondientes a la fase de un proyecto
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	if(isset($_POST["IDsubfase"])){//verifica la existencia de subfase
		require_once("../../db/connect.php");//llama a la conexión a base de datos
		require_once("generaNumero.php");//genera el nro del registro
		require_once("propiedadActividad.php");
		require_once("updateFase.php");
		#captura de variables
		$idactividad=generaNumero();//genera el ID del registro
		$idfase=$_POST["IDfase"];
		$idsubfase=$_POST["IDsubfase"];
		$idplan=$_POST["IDplan"];
		$idproyecto=$_POST["IDproy"];
		$idpersonaltecnico=$_POST["IDpersonalTecnico"];
		$actividad=$_POST["Actividad"];
		$unidad=$_POST["Unidad"];
		$cantidad=$_POST["Cantidad"];
		$fecI=$_POST["Fec1"];
		$fecF=$_POST["Fec2"];
		$costoProg=$_POST["CostoProg"];
		$IDcosto=$_POST["IDcostofijo"];
		#consulta para recuperar el costo fijo
		$consulta=$dbh->prepare("select valor from costofijo where IDcosto=?");
		$consulta->bindParam(1,$IDcosto);
		$consulta->execute();
		$result=$consulta->fetch();
		$costoFijo=$result[0];

		//variables auxiliares para comparar las fechas
		$auxF1=strtotime($fecI);
		$auxF2=strtotime($fecF);
		if(is_null($actividad)|| is_null($unidad) || is_null($cantidad) || is_null($fecI) || is_null($fecF)){
			echo "Complete el formulario";
			}else{
				if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cantidad)) || !(preg_match('/^[0-9]+(\.[0-9]+)?$/',$costoProg))){
					echo "El valor cantidad debe ser numérico";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
	}else if(!(preg_match('/(\d{4})-(\d{2})-(\d{2})/',$fecI)) && !(preg_match('/(\d{4})-(\d{2})-(\d{2})/',$fecF))){
	   echo "Fechas incorrectas";	
	} else if($auxF1>$auxF2){
			echo "La fecha de inicio no puede ser mayor";
			?>
            <img src="no.jpg" height="25" width="25">
            <?php
	}else{
				#consulta que impide registrar actividades en dias feriados
				$consultaFeriado=$dbh->prepare("select *from calendario_feriado where Inicio_feriado=? or Inicio_feriado=? or Fin_feriado=? or Fin_feriado=?");
				$consultaFeriado->bindParam(1,$fecI);
				$consultaFeriado->bindParam(2,$fecI);
				$consultaFeriado->bindParam(3,$fecF);
				$consultaFeriado->bindParam(4,$fecF);
				$consultaFeriado->execute();
				if($consultaFeriado->rowCount()>0){
					echo "No puede registrar actividades en dias feriados";//mensaje de impedimento
					?>
                    <img src="no.jpg" height="20" width="20">
                    <?php
		 }else{
		// recuperar la duracion den días
		$tiempo=getDias($fecI,$fecF);
		$duracion=$tiempo." dias";
		$estado="sin comenzar";
		$aprobado="Por definir";
		#consulta de inserción de la actividad
		$sql=$dbh->prepare("select *from actividad where IDsubase=? and nombreActividad=?");
		$sql->bindParam(1,$idsubfase);
		$sql->bindParam(2,$actividad);
		$sql->execute();
		if($sql->rowCount()>0){
			echo "Actividad ya registrada";
			}else{
		$insertActividad=insertActividad($idactividad,$idsubfase,$idpersonaltecnico,$idplan,$actividad,$unidad,$cantidad,$costoProg,$costoFijo,$fecI,$fecF,$duracion,$estado,$aprobado,$idproyecto);
			   updateActFase($idfase);  
			      }
			}
		}
	}
}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>
<?php
function getDias($fec1,$fec2){//función para recuperar la cantidad de días del proyecto
	$segundos=strtotime($fec2) - strtotime($fec1);//convierte a segundos para realizar la diferencia
$diferencia_dias=intval($segundos/60/60/24);//convierte a valor entero
$dias=abs($diferencia_dias);//valor absoluto para convertir el valor de días a positivo
return $dias;//devuelve la cantidad de días
	}	
	function insertActividad($IDactividad,$IDsubfase,$IDpersonal,$IDplan,$Actividad,$unit,$cant,$cprog,$cfijo,$fec1,$fec2,$last,$status,$aprob,$idproy){
		global $dbh;//declaración global de la variable de ejecución de consultas
		$costoProrrateado=$cfijo/$last;//prorratea el costo fijo por la duración de días de la actividad
		#consulta PDO para realizar el registro de la actividad
		$sql=$dbh->prepare("insert into actividad values(?,?,?,?,?,0.00,0.00,0.00,0.00,0.00,0.00,?,?,0.00,0.00,0.00,?,?,?,?,?,0.00,?,?,'','',curdate(),curtime())");
		$sql->bindParam(1,$IDactividad);
		$sql->bindParam(2,$IDsubfase);
		$sql->bindParam(3,$IDpersonal);
		$sql->bindParam(4,$IDplan);
		$sql->bindParam(5,$Actividad);
		$sql->bindParam(6,$unit);
		$sql->bindParam(7,$cant);
		$sql->bindParam(8,$cprog);
		$sql->bindParam(9,$costoProrrateado);
		$sql->bindParam(10,$fec1);
		$sql->bindParam(11,$fec2);
		$sql->bindParam(12,$last);
		$sql->bindParam(13,$status);
		$sql->bindParam(14,$aprob);
		if($sql->execute()){
		    //propiedadActividad($IDactividad);
			echo "Actividad registrada";//mensaje de confirmación
			propiedadActividad($IDactividad);
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				echo "No se pudo registrar la actividad<br>";//mensaje de fallo de la inserción
				?>
                <img src="no.jpg" height="25" width="25">
                <?php			
				
				}
		
		}
?>
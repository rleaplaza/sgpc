<?php
session_start();//inicia la sesion
?>
<?php
if(isset($_SESSION["username"])){//si existe la variable de sesion, continua con las siguientes instrucciones
	require_once("genera.php");
	require_once("../../db/connect.php");
	//captura de variables del formulario
	$empID=generaCodigo();
	$nombre=trim(ucwords(strtolower($_POST["nombre"])));//captura el nombre, elimina espacios y el primer caracter lo transforma a mayúscula
	$app=trim(ucwords(strtolower($_POST["app"])));//captura el apellido paterno, elimina espacios y el primer caracter lo transforma a mayúscula
	$apm=trim(ucwords(strtolower($_POST["apm"])));//captura el apellido materno, elimina espacios y el primer caracter lo transforma a mayúscula
	$ci=trim($_POST["ci"]);//captura de cécula
	$tel=trim($_POST["tel"]);//captura de teléfono
	$dir=trim($_POST["dir"]);
	$fecn=trim($_POST["fecn"]);
	$estadocivil=$_POST["estadocivil"];
	$fecIngreso=trim($_POST["fecIngreso"]);
	
	$profesion=$_POST["profesion"];//captura la profesión
	$query=$dbh->prepare("select IDprofesion from profesion where nombre:nombre");
	$query->bindParam(':profesion',$profesion);//enlaza al nombre de la profesion
	$query->execute();
	$fila=$query->fetch();
	
	$cargo=$_POST["cargo"];
	$sql=$dbh->prepare("SELECT IDcargo from cargo where nombre=:nombre");
	$sql->bindParam(':nombre',$cargo);
	$sql->execute();
	$row=$sql->fetch();
	
	$depto=$_POST["depto"];
	$sql1=$dbh->prepare("SELECT IDdepto from departamento where nombre=:departamento");
	$sql1->bindParam(':departamento',$depto);
	$sql1->execute();
	$row1=$sql1->fetch();
     
	$salario=$_POST["salario"];
	$aniosTrabajo=getAnios($fecIngreso);
	
	$insert=insertData($empID,$nombre,$app,$apm,$ci,$tel,$dir,$fecn,$estadocivil,$fecIngreso,$cargo,$depto,$profesion,$salario,$aniosTrabajo);
	}
	else{
		header("location: ../../index.php");
		}
		
		function getAnios($fecha_ingreso){//función para recuperar la cantidad de años en valor numérico
			$segundos=strtotime($fecha_ingreso) - strtotime('now');//convierte el valor en numero
$diferencia_dias=intval($segundos/60/60/24);//captura la diferencia en valor numérico
$anio=abs(($diferencia_dias/365));//convierte a valor absoluto la diferencia de días y divide entre 365 días
return $anio;
			
			}
			
				
		//función para registrar el departamento
function insertData($empId, $nombre,$paterno,$materno,$cedula,$telefono,$direccion,$fecNacimiento,$civil,$fecIng,$carg,$dept,$prof,$sueldo,$aTrabajo){
		global $dbh;
		#consulta de inserción en base a los parámetros de la función usadas por el símbolo ?
		$insert=$dbh->prepare("insert into empleado values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,curdate(),curtime())");
		$insert->bindParam(1,$empId);
		$insert->bindParam(2,$nombre);
		$insert->bindParam(3,$paterno);
		$insert->bindParam(4,$materno);
		$insert->bindParam(5,$cedula);
		$insert->bindParam(6,$telefono);
		$insert->bindParam(7,$direccion);
		$insert->bindParam(8,$fecNacimiento);
		$insert->bindParam(9,$civil);
		$insert->bindParam(10,$fecIng);
		$insert->bindParam(11,$carg);
		$insert->bindParam(12,$dept);
		$insert->bindParam(13,$prof);
		$insert->bindParam(14,$sueldo);
		$insert->bindParam(15,$aTrabajo);
		if($insert->execute()){
			echo "Registro realizado";
			}else{
				echo "Error al registrar empleado";
				}
		}
			
?>
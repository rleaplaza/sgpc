<?php session_start(); //función de inicio de sesion?>
<?php
#Este programa se encarga de actualizar la descripción de departamentos
if(isset($_POST["idprofesion"])){//valida la existencia del departamento
	try{ require_once("../../db/connect.php");//llamada a la conexión global a base de datos
		$idprofesion=$_POST["idprofesion"];//captura el id del departamento
		$desc=$_POST["desc"];//captura la descripción a editar
		$editProfesion=editProfesion($idprofesion,$desc);//función para realizar la edición
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");//direcciona al login en caso de no existir el id especificado
		}
function editProfesion($IDprofesion,$descripcion){//función de edición
	global $dbh;//la variable $dbh debe ser global para realizar consultas PDO
	$sql=$dbh->prepare("update profesion set descripcion=? where IDprofesion=?");//consulta de actualización
	#Enlace a la descripción e identificador de departamento para ejecutar la consulta
	$sql->bindParam(1,$descripcion);
	$sql->bindParam(2,$IDprofesion);
	$sql->execute();//ejecuta la consulta
	
	return $sql;//devuelve la variable sql ejecutada
	}
?>
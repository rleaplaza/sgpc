<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../css/example.css" rel="stylesheet" type="text/css">
<link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
		      </style>
              </head>
              <body>
<?php
if(isset($_SESSION["username"])){
if(isset($_POST["idRol"])){
	require_once("../../db/connect.php");
	$idrol=$_POST["idRol"];
	if(($idrol=="SC_ADMINISTRADOR") || ($idrol=="SC_CONTRATISTA") || ($idrol=="SC_CONVOCANTE") || ($idrol=="SC_OPERADOR") || ($idrol=="SC_PROVEEDOR") || ($idrol=="SC_PROVEEDOR_MANO_OBRA") || ($idrol=="SC_SUPERVISOR")){
	echo "<label>El rol ".$idrol." no puede eliminarse</label>";
	}else{ //consulta de rol asignado a usuarios
		$consulta=$dbh->prepare("select IDrol from usuario, rol 
		                         where usuario.IDrol=rol.IDrol
				                 and IDrol=?");
	    $consulta->bindParam(1,$idrol);
		$consulta->execute();
		//consulta de opciones para el rol
		$opciones=$dbh->prepare("SELECT nombreOpcion, rol.IDrol
                                 FROM rol, rol_opcion, opcion
                                 WHERE rol.IDrol = rol_opcion.IDrol
                                 AND rol_opcion.IDopcion = opcion.IDopcion
                                 AND rol.IDrol = ?");
		$opciones->bindParam(1,$idrol);
		$opciones->execute();
		if($consulta->rowCount()>0 || $opciones->rowCount()>0){
			echo "Este rol no puede eliminarse";
			}else{
		$sql=$dbh->prepare("delete from rol where IDrol=?");
	$sql->bindParam(1,$idrol);
	$sql->execute();
	if($sql){
		echo "<label>Rol eliminado con exito</label>";
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
</body>
</html>
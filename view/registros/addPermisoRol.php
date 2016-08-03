<?php
// adición de los permisos del rol a los permisos del usuario
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	try{
	function addPermisoRol($IDrol,$IDuser){
		global $dbh;
		//consulta las opciones asignadas al rol
		$sql=$dbh->prepare("select opcion.IDopcion,nombreOpcion from rol, rol_opcion,opcion 
		                    where rol.IDrol=rol_opcion.IDrol
							AND rol_opcion.IDopcion=opcion.IDopcion
							AND rol.IDrol=?");
		$sql->bindParam(1,$IDrol);
		$sql->execute();
		//recorre el arreglo de los permisos
		foreach($sql->fetchAll() as $row){
		  $idopcion=$row[0];	//asigna la opcion asignada al rol
		  //consulta las opciones del permiso del usuario
	      $consulta=$dbh->prepare("select IDopcion from permiso where IDopcion=? and USR_UID=?");
		  $consulta->bindParam(1,$idopcion);
		  $consulta->bindParam(2,$IDuser);
		  $consulta->execute();
		     if($consulta->rowCount()==0){
	//en caso de no existir ningún permiso coincidente, realizará el registro, caso contrario el permiso no se registra
				require_once("genera.php");//archivo de generacion de identificadores
			    $idpermiso=generaCodigo();//genera el identificador
				 $insert=$dbh->prepare("insert into permiso values(?,?,?,'activo',curdate(),curtime())");
				 $insert->bindParam(1,$idpermiso);
				 $insert->bindParam(2,$IDuser);
				 $insert->bindParam(3,$idopcion);
				 $insert->execute(); 
				 } 
			}
		}
		
		
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();//genera la execpcion en caso de fallar la conexion
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>
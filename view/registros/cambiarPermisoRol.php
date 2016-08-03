<?php
#Este programa se encarga de cambiar los roles y los permisos a un usuario
if(isset($_SESSION["username"])){//verifica la existencia de la sesion
	require_once("../../db/connect.php");//llama a la conexion a base de datos
	try{//funcion para cambiar el permiso en base al nuevo rol e id de usuario
		function cambiarPermiso($nuevoRol,$IDuser){
			global $dbh;//variable para instanciar a la clase PDO
			#consulta de las opciones del usuario
			$consulta=$dbh->prepare("select IDopcion from permiso where USR_UID=?");
			$consulta->bindParam(1,$IDuser);
			$consulta->execute();
			if($consulta->rowCount()>0){
				#el arreglo recorre los permisos del usuario
				foreach($consulta->fetchAll() as $fila){
					$antiguaopcion=$fila[0];//captura el id de opcion
					$auxOpt=$antiguaopcion;//captura en variable auxiliar
					#consulta de eliminacion de permisos anteriores
					$delete=$dbh->prepare("delete from permiso where IDopcion=? and USR_UID=?");
					$delete->bindParam(1,$antiguaopcion);
					$delete->bindParam(2,$IDuser);
					$delete->execute();
					#consulta de los subpermisos
					$subpermiso=$dbh->prepare("select IDpagina from pagina_opcion where IDopcion=?");
					$subpermiso->bindParam(1,$auxOpt);//enlaza al id de opcion anetrior
					if($subpermiso->execute()){
						foreach($subpermiso->fetchAll() as $sub){//el arreglo recorre las filas
							$IDpagina=$sub["IDpagina"];//captura del id de pagina
							#borra los subpermisos del usuario
						$querysubpermiso=$dbh->prepare("delete from permiso_pagina where USR_UID=? and IDpagina=?");
						$querysubpermiso->bindParam(1,$IDuser);
						$querysubpermiso->bindParam(2,$IDpagina);
						$querysubpermiso->execute();
						 }
						}
					}
				}
					#consulta las opciones del nuevo rol asignado				 
			$sql=$dbh->prepare("select opcion.IDopcion,nombreOpcion from rol, rol_opcion,opcion 
		                    where rol.IDrol=rol_opcion.IDrol
							AND rol_opcion.IDopcion=opcion.IDopcion
							AND rol.IDrol=?");
		    $sql->bindParam(1,$nuevoRol);
		    $sql->execute();
		foreach($sql->fetchAll() as $row){
			$idopcion=$row[0];
			$consulta=$dbh->prepare("select IDopcion from permiso where IDopcion=? and USR_UID=?");
		    $consulta->bindParam(1,$idopcion);
		    $consulta->bindParam(2,$IDuser);
		    $consulta->execute();
			if($consulta->rowCount()==0){
	//en caso de no existir ningún permiso coincidente, realizará el registro, caso contrario el permiso no se registra
				require_once("genera.php");
			    $idpermiso=generaCodigo();
				 $insert=$dbh->prepare("insert into permiso values(?,?,?,'activo',curdate(),curtime())");
				 $insert->bindParam(1,$idpermiso);
				 $insert->bindParam(2,$IDuser);
				 $insert->bindParam(3,$idopcion);
				 $insert->execute(); 
			
			}
		  }
		}
		}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
		}
	}else{
		header("location: ../../index.php");
		}
?>
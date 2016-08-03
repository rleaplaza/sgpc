<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["codRol"])){
		require_once("../../db/connect.php");
		$IDrol=$_POST["codRol"];
		$IDuser=$_POST["IDusuario"];
		$rol=$dbh->prepare("select rol.IDrol, usuario.USR_UID from usuario, usuario_rol, rol
		                    where usuario.USR_UID=usuario_rol.USR_UID
							and usuario_rol.IDrol=rol.IDrol
							and usuario.USR_UID=?
							and rol.IDrol=?");
		$rol->bindParam(1,$IDuser);
		$rol->bindParam(2,$IDrol);
		$rol->execute();
		if($rol->rowCount()>0){
		$sql=$dbh->prepare("select opcion.IDopcion,nombreOpcion from rol, rol_opcion,opcion
		                    Where rol.IDrol=rol_opcion.IDrol
							and rol_opcion.IDopcion=opcion.IDopcion
							and rol.IDrol=?");
		$sql->bindParam(1,$IDrol);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchall() as $row){
				$IDopcion=$row[0];
				$consulta=$dbh->prepare("select opcion.IDopcion, usuario.USR_UID from usuario, permiso, opcion 
				                   where usuario.USR_UID=permiso.USR_UID
								   and permiso.IDopcion=opcion.IDopcion
								   and usuario.USR_UID=?
								   and opcion.IDopcion=?");
				$consulta->bindParam(1,$IDuser);
				$consulta->bindParam(2,$IDopcion);
				$consulta->execute();
				if($consulta->rowCount()>0){
					$delete=$dbh->prepare("delete from permiso where USR_UID=? and IDopcion=?");
					$delete->bindParam(1,$IDuser);
					$delete->bindParam(2,$IDopcion);
					$delete->execute();
					}
				}
			$deleteRol=$dbh->prepare("delete from usuario_rol where USR_UID=? and IDrol=?");
			$deleteRol->bindParam(1,$IDuser);
			$deleteRol->bindParam(2,$IDrol);
			if($deleteRol->execute()){
				echo "Rol eliminado para el usuario";
				}
			}
		}else{
			echo "Rol no asignado al usuario";
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
<?php
session_start();//inicio de sesion
?>
<html>
<head><meta charset="utf-8"></head>
<?php
if(isset($_SESSION["username"])){
try{ //consulta al mismo rol asignado
	sleep(1);
	require_once("../../db/connect.php");//llama a la conexion a base de datos
	require_once("genera.php");//genera el nro identificador
	require_once("cambiarPermisoRol.php");//archivo para cambiar el permiso del rol asignado al usuario
	require_once("addPermisoRol.php");//archivo para registrar los permisos
	$iduser=$_POST["IDusuario"];
	$idrol=$_POST["codRol"];
	$sql=$dbh->prepare("select rol.IDrol, nombreRol from usuario, rol
						WHERE usuario.IDrol=rol.IDrol
						and rol.IDrol=? and usuario.USR_UID=?");
						
	$sql->bindParam(1,$idrol);
	$sql->bindParam(2,$iduser);
	$sql->execute();
	$row=$sql->fetch();
	if($sql->rowCount()>0){ 
	echo "Rol <b>".$row["IDrol"] ."</b> ya asignado";
	addPermisoRol($idrol,$iduser);//agrega los permisos al usuario en caso de que se hayan registrado nuevos permisos al rol
	?>
    <img src="yes.jpg" width="15" height="15"  alt=""/><br>
    <?php
		}
		else{
			//consulta a otro rol
			
			$consulta=$dbh->prepare("select rol.IDrol, nombreRol from usuario, rol
						             WHERE usuario.IDrol=rol.IDrol
						             and rol.IDrol=? and usuario.USR_UID=?");
			$consulta->bindParam(1,$idrol);
			$consulta->bindParam(2,$iduser);
			$consulta->execute();
			if($consulta->rowCount()>0){
		    cambiarPermiso($idrol,$iduser);
			$update=$dbh->prepare("update usuario set IDrol=? where USR_UID=?");
			$update->bindParam(1,$idrol);
			$update->bindParam(2,$iduser);
			$update->execute();
            
			echo "Cambio de rol a ". $idrol;
			?>
			<img src="yes.jpg" width="15" height="15"  alt=""/><br>
            <?php
			}
			else{ //consulta de inserción de nuevo rol en caso de no estar asignado a ninguno
			$insert=$dbh->prepare("update usuario set IDrol=? where USR_UID=?");
			$insert->bindParam(1,$idrol);
			$insert->bindParam(2,$iduser);
			$insert->execute();
			if($insert){
$consulta=$dbh->prepare("select rol.IDrol, nombreRol, username from usuario, rol
						WHERE usuario.IDrol=rol.IDrol
						and rol.IDrol=? and usuario.USR_UID=?");
				$consulta->bindParam(1,$idrol);
				$consulta->bindParam(2,$iduser);
				$consulta->execute();
				$fila=$consulta->fetch();
				cambiarPermiso($idrol,$iduser);//envia a la funcion para cambiar los permisos del usuario
				
				?>
				 <table>
    <tr><td>ID de rol:</td><td><?php echo $fila["0"];?></td></tr>
    <tr><td>Nombre de Rol:</td><td><?php echo $fila["1"];?></td></tr>
    <tr><td>Username:</td><td><?php echo $fila["2"];?><img src="yes.jpg" width="10" height="10"  alt=""/></td></tr>
    </table>
				<?php
			}
				}
			}
	
	}catch(PDOException $e){
		echo("Error inesperado".$e->getMessage());
		}
}
else{
	header("location: ../../index.php");
	}
?>
</html>
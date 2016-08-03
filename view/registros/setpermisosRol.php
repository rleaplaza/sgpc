<?php session_start();//inicio de sesion?>
<html>
<head><meta charset="utf-8"></head>
<?php
#Este programa se encarga de asignar los permisos a un rol
if(isset($_SESSION["username"])){//verifica si existe la sesion
try{
	sleep(1);
	require_once("../../db/connect.php");
	require_once("genera.php");
	$idrol=$_POST["IDrol"];
	$idopcion=$_POST["codOpcion"];
	#consulta los permisos del rol
	$sql=$dbh->prepare("SELECT nombreRol, nombreOpcion, rol_opcion.estado
                        FROM rol, rol_opcion, opcion
                        WHERE rol.IDrol = rol_opcion.IDrol
                        AND rol_opcion.IDopcion = opcion.IDopcion
                        AND opcion.IDopcion =?
                        AND rol.IDrol = ?");
	$sql->bindParam(1,$idopcion);
	$sql->bindParam(2,$idrol);
	$sql->execute();
	$row=$sql->fetch();
	if($sql->rowCount()>0){ 
	echo "Rol ".$idrol."<br>";
	echo "Permiso ".$row["nombreOpcion"] ." ya asignado";
	?>
    <img src="yes.jpg" width="15" height="15"  alt=""/><br>
    <?php
	}
		else{//consulta de asignacion de permisos a roles
			$idpermisoRol=generaCodigo();
			$insert=$dbh->prepare("insert into rol_opcion values(?,?,?,'activo',curdate(),curtime())");
			$insert->bindParam(1,$idpermisoRol);
			$insert->bindParam(2,$idrol);
			$insert->bindParam(3,$idopcion);
			$insert->execute();
			if($insert){//consulta para confirmar la asignacion
			$consulta=$dbh->prepare("SELECT nombreRol, nombreOpcion, rol_opcion.estado, rol_opcion.fecAsignacion,rol_opcion.hraAsignacion
                                     FROM rol, rol_opcion, opcion
                                     WHERE rol.IDrol = rol_opcion.IDrol
                                     AND rol_opcion.IDopcion = opcion.IDopcion
                                     AND opcion.IDopcion =?
                                     AND rol.IDrol = ?");
			$consulta->bindParam(1,$idopcion);
			$consulta->bindParam(2,$idrol);
			$consulta->execute();
			$fila=$consulta->fetch();
				?>
				 <table>
    <tr><td>Nombre de Rol:</td><td><?php echo $fila[0]//nombre de rol;?></td></tr>
    <tr><td>Opción:</td><td><?php echo $fila[1];//nombre de opcion?></td></tr>
    <tr><td>Estado de permiso:</td><td><?php echo $fila[2];//estado del permiso?><img src="yes.jpg" width="10" height="10"  alt=""/></td></tr>
    <tr><td>Fecha de asignación:</td><td><?php echo $fila[3];//fecha de asignacion?></td></tr>
    <tr><td>Hora de asignación:</td><td><?php echo $fila[4];//hora de asignacion?></td></tr>
    </table>
				<?php
				}
			}
	
	}catch(PDOException $e){
		echo("Error inesperado".$e->getMessage());
		}
}
else{
	header("location: ../../index.php");//redirige al login
	}
?>
</html>
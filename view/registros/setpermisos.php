<?php
session_start();
?>
<html>
<head><meta charset="utf-8"></head>
<?php
#Este programa se encarga de guardar los permisos asignados a un usuario
if(isset($_SESSION["username"])){
try{
	sleep(1);//función para despliegue del resultado
	require_once("../../db/connect.php");//archivo de conexión a la base de datos
	require_once("genera.php");//archivo que genera un ID aleatorio
	#captura del ID de usuario y de opción
	$iduser=$_POST["IDusuario"];
	$idopcion=$_POST["codOpcion"];
	#consulta para definir si el permiso ya fue asignado
	$sql=$dbh->prepare("SELECT username, nombreOpcion, permiso.estado, permiso.fecha_asignacion,                        permiso.hraAsignacion FROM usuario, permiso, opcion
                        WHERE usuario.USR_UID = permiso.USR_UID
                        AND permiso.IDopcion = opcion.IDopcion
                        AND opcion.IDopcion =?
                        AND usuario.USR_UID = ?");
	$sql->bindParam(1,$idopcion);//enlaza el ID de opcion
	$sql->bindParam(2,$iduser);//enlaza el ID de usuario
	$sql->execute();//ejecuta la instrucción
	$row=$sql->fetch();
	if($sql->rowCount()>0){ 
	//mensaje que indica la asignación registrada
	echo "Permiso <b>".$row["nombreOpcion"] ."</b> ya asignado";
	?>
    <img src="yes.jpg" width="15" height="15"  alt=""/><br>
    <?php
		}
		else{
			//genera el ID del permiso
			$idpermiso=generaCodigo();
			//consulta para registrar el permiso de acceso
			$insert=$dbh->prepare("insert into permiso values(?,?,?,'activo',curdate(),curtime())");
			#enlaza los parámetros id del permiso, usuario y opción
			$insert->bindParam(1,$idpermiso);
			$insert->bindParam(2,$iduser);
			$insert->bindParam(3,$idopcion);
			$insert->execute();//ejecuta la instrucción
			if($insert){
				#consulta el registro resumido de la asignación
				$consulta=$dbh->prepare("SELECT username, nombreOpcion, permiso.estado, permiso.fecha_asignacion,                                                 permiso.hraAsignacion FROM usuario, permiso, opcion
                        WHERE usuario.USR_UID = permiso.USR_UID
                        AND permiso.IDopcion = opcion.IDopcion
                        AND opcion.IDopcion =?
                        AND usuario.USR_UID = ?");
				$consulta->bindParam(1,$idopcion);
				$consulta->bindParam(2,$iduser);
				$consulta->execute();
				$fila=$consulta->fetch();
				?>
				 <table>
    <tr><td>Usuario:</td><td><?php echo $fila["0"];?></td></tr>
    <tr><td>Opción:</td><td><?php echo $fila["1"];?></td></tr>
    <tr><td>Estado de permiso:</td><td><?php echo $fila["2"];?><img src="yes.jpg" width="10" height="10"  alt=""/></td></tr>
    <tr><td>Fecha de asignación:</td><td><?php echo $fila["3"];?></td></tr>
    <tr><td>Hora de asignación:</td><td><?php echo $fila["4"];?></td></tr>
    </table>
				<?php
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
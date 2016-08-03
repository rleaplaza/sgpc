<?php
session_start();
?>
<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../../db/connect.php");
	
	$uid=$_POST["userId"];
	$status=$_POST["status"];			
		$sql=$dbh->prepare("update usuario set estado=? where USR_UID=?");
		$sql->bindParam(1,$status);
		$sql->bindParam(2,$uid);
		$sql->execute();
			$consulta=$dbh->prepare("select USR_UID, username, estado, fecCreacion, hraCreacion,IDrol from usuario where USR_UID=?");
			$consulta->bindParam(1,$uid);
			$consulta->execute();
			$row=$consulta->fetch();
			?>
            <table>
            <tr><td>Información de usuario<td></tr>
            <tr><td>ID de usuario: </td><td><?php echo $row["USR_UID"];?></td></tr>
            <tr><td>Username: </td><td><?php echo $row["username"]?></td></tr>
            <tr><td>Estado actual: </td><td><?php echo $row["estado"];?><?php if($status=="activo"){?><img src="yes.jpg" width="15" height="15"/><?php }else{if($status=="inactivo"){
				?>
                <img src="no.jpg" width="15" height="15"/>
                <?php
				}
				}
			
			?></td></tr>
            <tr><td>Fecha de creacion:</td><td><?php echo $row["fecCreacion"]." ".$row["hraCreacion"];?></td></tr>
            <tr><td>Rol de usuario:</td><td><?php echo $row["IDrol"];?></td></tr>
            </table>
            
            <?php
           
		}catch(PDOException $e){
			echo("Error inesperado".$e->getMessage());
			}
	}
	else{
		header("location: ../../index.php");
		}
?>
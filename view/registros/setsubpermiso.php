<?php
session_start();
?>

<?php
if(isset($_SESSION["username"])){
try{
	sleep(1);
	require_once("../../db/connect.php");
	require_once("genera.php");
	$iduser=$_POST["IDusuario"];
	$idpagina=$_POST["codPagina"];
	$sql=$dbh->prepare("SELECT username, pagina_opcion.nombre
                        FROM usuario, pagina_opcion, permiso_pagina
                        WHERE usuario.USR_UID = permiso_pagina.USR_UID
                        AND permiso_pagina.IDpagina = pagina_opcion.IDpagina
                        AND pagina_opcion.IDpagina =?
                        AND usuario.USR_UID = ?");
	$sql->bindParam(1,$idpagina);
	$sql->bindParam(2,$iduser);
	$sql->execute();
	if($sql->rowCount()>0){
		 echo("Este Subpermiso ya fue asignado");?>
    <img src="no.jpg" width="15" height="15"  alt=""/><br>
    <?php
	$aux=$dbh->prepare("Select *from permiso_pagina where USR_UID=? and IDpagina=? and estado='inactivo'");
	$aux->bindParam(1,$iduser);
	$aux->bindParam(2,$idpagina);
	$aux->execute();
	if($aux->rowCount()>0){
	$query=$dbh->prepare("update permiso_pagina set estado='activo' where USR_UID=? and IDpagina=?");
	$query->bindParam(1,$iduser);
	$query->bindParam(2,$idpagina);
	$query->execute();
	if($query){
		echo("SubPermiso reactivado");?>
        <img src="yes.jpg" width="10" height="10"  alt=""/>
		<?php
		}
	}
		}
		else{
			$idpermiso=generaCodigo();
			$insert=$dbh->prepare("insert into permiso_pagina values(?,?,?,'activo',curdate(),curtime())");
			$insert->bindParam(1,$idpermiso);
			$insert->bindParam(2,$iduser);
			$insert->bindParam(3,$idpagina);
			$insert->execute();
			if($insert){
				echo("SubPermiso Asignado");?>
                <img src="yes.jpg" width="10" height="10"  alt=""/>
				<?php
				}
				else
				{echo("Hubo un error al asignar el SubPermiso");
				?>
                <img src="no.jpg" width="10" height="10"  alt=""/>
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
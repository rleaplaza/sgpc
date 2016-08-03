
<?php session_start();?>
<?php
try{
	sleep(1);
if(isset($_SESSION["username"])){
	if(isset($_POST["codSubpermiso"])){
		require_once("../../db/connect.php");
		require_once("genera.php");
		
		$idmensaje=generaCodigo();
		$idpagina=$_POST["codSubpermiso"];
		$desc=$_POST["Descripcion"];
		$consulta=$dbh->prepare("select *from ayuda_subpermiso where IDpagina=?");
		$consulta->bindParam(1,$idpagina);
		$consulta->execute();
		if($consulta->rowCount()){
			echo "Este subpermiso ya tiene mensaje de ayuda";
			?>
              <img src="no.jpg" height="20" width="20">
            <?php
			}else{
				if($desc==null){
					echo "Ingrese la descripción del mensaje";
					?>
                    <img src="no.jpg" height="20" width="20">
                    <?php
					}else{
		$sql=$dbh->prepare("insert into ayuda_subpermiso values(?,?,?,curdate(),curtime())");
		$sql->bindParam(1,$idmensaje);
		$sql->bindParam(2,$idpagina);
		$sql->bindParam(3,$desc);
		if($sql->execute()){
			echo "Mensaje de ayuda registrado";
			?><img src="yes.jpg" height="20" width="20">
            <?php
			}else{
			  echo "Error al registrar el mensaje";	
				}		
				}
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
}catch(PDOException $e){
	echo "Error inesperado";
	}
?>

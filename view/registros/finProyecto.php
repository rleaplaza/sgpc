<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproyecto"])){
		require_once("../../db/connect.php");
		$idproyecto=$_POST["IDproyecto"];
		$consulta=$dbh->prepare("select *from proyecto where IDproyecto=? and estado='Finalizado'");
		$consulta->bindParam(1,$idproyecto);
		$consulta->execute();
		if($consulta->rowCount()>0){
			echo "Proyecto ya finalizado";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			} else{
				$sql=$dbh->prepare("update proyecto set estado='Finalizado' where IDproyecto=?");
				$sql->bindParam(1,$idproyecto);
				if($sql->execute()){
					echo "Proyecto finalizado";
					?>
                    <img src="yes.jpg" height="20" width="20">
                    <?php
					}else{
						echo "No se pudo actualizar el proyecto";
						?>
                        <img src="no.jpg" height="20" width="20">
                        <?php
						}
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
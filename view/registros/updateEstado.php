<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmat"])){
		require_once("../../db/connect.php");
		$idmaterial=$_POST["IDmat"];
		$nuevoestado="Aprobado";
		$sqlq=$dbh->prepare("select nombres, app, apm from usuario as u, empleado as e
		                    where u.CI=e.CI
							and username=?");
		$sqlq->bindParam(1,$_SESSION["username"]);
		$sqlq->execute();
		$res=$sqlq->fetch();
		$nombre=$res["nombres"]." ".$res["app"]." ".$res["apm"];
		$sql=$dbh->prepare("update cotizacion set estado=?, fecRegistro=curdate(), hraRegistro=curtime(), aprobado_por=?                            where IDmaterial=?");
		$sql->bindParam(1,$nuevoestado);
		$sql->bindParam(2,$nombre);
		$sql->bindParam(3,$idmaterial);
		if($sql->execute()){
			echo "Aprobación realizada";
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				echo "No se pudo realizar la aprobación";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
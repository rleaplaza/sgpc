<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmat"])){
		require_once("../../db/connect.php");
		require_once("genera.php");
		$idcotizacion=generaCodigo();
		$idmat=$_POST["IDmat"];
		$estado="Agregado";
		$sql=$dbh->prepare("select *from cotizacion where IDmaterial=?");
		$sql->bindParam(1,$idmat);
		$sql->execute();
		if($sql->rowCount()>0){
			echo "Material ya registrado en cotizaciones";
			}else{
				$insert=$dbh->prepare("insert into cotizacion values(?,?,?,curdate(),curtime(),null)");
				$insert->bindParam(1,$idcotizacion);
				$insert->bindParam(2,$idmat);
				$insert->bindParam(3,$estado);
				if($insert->execute()){
					echo "Material agregado a la cotizacion";
					?>
                    <img src="yes.jpg" height="25" width="25">
                    <?php
					}else{
						echo "No se pudo agregar la cotizacion";
						?>
                        <img src="no.jpg" height="25" width="25">
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
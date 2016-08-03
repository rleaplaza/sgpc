<?php session_start();?>

<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDfase"])){
		require_once("../../db/connect.php");
		require_once("generaNumero.php");
		$idsubfase=generaNumero();
		$idfase=$_POST["IDfase"];
		$idplan=$_POST["IDplan"];
		$subfase=trim($_POST["Subfase"]);
		$desc=trim($_POST["Desc"]);
		if(empty($subfase) || empty($desc)){
			echo "Complete el formulario";
			}else{
				if(!(preg_match("/^[a-zA-Z]/",$desc))){
				echo "El campo subfase debe ser texto";
				}else{
				$sql=$dbh->prepare("select *from subfase where IDfase=? and nombre=?");
				$sql->bindParam(1,$idfase);
				$sql->bindParam(2,$subfase);
				$sql->execute();
				if($sql->rowCount()>0){
					echo "Subfase ya registrada en la fase";
					}else{
		$insertsubFase=insertSubFase($idsubfase,$idfase,$idplan,$subfase,$desc);
					}
				}
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
<?php
	function insertSubFase($IDsubfase, $IDfase,$IDplan,$nsubfase, $Desc){
		global $dbh;
		$insert=$dbh->prepare("insert into subfase values(?,?,?,?,?)");
		$insert->bindParam(1,$IDsubfase);
		$insert->bindParam(2,$IDfase);
		$insert->bindParam(3,$IDplan);
		$insert->bindParam(4,$nsubfase);
		$insert->bindParam(5,$Desc);
		if($insert->execute()){
			echo "Registro de subfase realizado";
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				echo "No se pudo registrar la subfase";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}
		}
	
?>
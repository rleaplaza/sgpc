<?php session_start();?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDplan"])){
		require_once("../../db/connect.php");
		try{
			$idplan=$_POST["IDplan"];
			$nrocotizacion=$_POST["Nrocot"];
			$consulta=$dbh->prepare("select *from pedido_material where nro_cotizacion=?");
			$consulta->bindParam(1,$nrocotizacion);
			$consulta->execute();
			if($consulta->rowCount()==0){
				echo "Debe realizar el pedido antes de finalizar cada planificación";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}else{
					$sql=$dbh->prepare("update planificacion_compra set fechaFinalizacion=curdate() where IDplan=?");
					$sql->bindParam(1,$idplan);
					if($sql->execute()){
						echo "Planificación finalizada";
						?>
                        <img src="yes.jpg" height="25" width="25">
                        <?php
						}else{
							echo "No se pudo finalizar la planificación para el item";
							?>
                            <img src="no.jpg" height="25" width="25">
                            <?php
							}
					}
			}catch(PDOException $e){
				echo "Error inesperado";
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>

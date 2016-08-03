<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de registrar incorporación de equipamiento comprometido al proyecto
if(isset($_SESSION["username"])){//verifica la existencia de sesión
	if(isset($_POST["IDproyecto"])){//verifica la existencia del proyecto
		require_once("../../db/connect.php");//llama a la conexión a base de datos
		require_once("generaNumero.php");//genera el nro de registro
		try{
			
			$uidproyecto=$_POST["IDproyecto"];//captura el id del proyecto
			$uidplan=$_POST["IDplan"];//captura el id de planeación
		 
			#consulta la incorporación
			$consulta=$dbh->prepare("select *from proyecto_maquinaria where IDproyecto=? and IDmaquinaria=?");
			$consulta->bindParam(1,$uidproyecto);
			$consulta->bindParam(2,$uidmaquinaria);
			$consulta->execute();
			if($consulta->rowCount()>0){
				echo "Maquinaria ya incorporada";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}else{
			 #consulta a la maquinaria
			$sql=$dbh->prepare("select IDmaquinaria, cantidad_disponible from maquinaria where cantidad_disponible>0");
			 $sql->execute();
			 foreach($sql->fetchAll() as $row){//el arreglo recorrerá las filas de equipamiento solicitado para insertarlo en el registro principal
				 $uidmaquinaria=$row[0];//captura el id de equipamiento
				 $cantidad=$row[1];//captura la cantidad
				 $uidIncor=generaNumero();//genera el identificador
				 #consulta de inserción en base a la cantidad de filas del arreglo
			  $insert=$dbh->prepare("insert into proyecto_maquinaria values(?,?,?,?,?,curdate(),curtime())");
			  $insert->bindParam(1,$uidIncor);
			  $insert->bindParam(2,$uidproyecto);
			  $insert->bindParam(3,$uidplan);
			  $insert->bindParam(4,$uidmaquinaria);
			  $insert->bindParam(5,$cantidad);
			  if($insert->execute()){
			  #actualizacion de cantidades
	$update=$dbh->prepare("update maquinaria set cantidad_disponible=cantidad_disponible-? where IDmaquinaria=?");
	$update->bindParam(1,$cantidad);
	$update->bindParam(2,$uidmaquinaria);
	$update->execute();
			  }
				  					}
			#consulta de confirmación
			$conf=$dbh->prepare("select *from proyecto_maquinaria where IDproyecto=?");
			$conf->bindParam(1,$uidproyecto);
			$conf->execute();
			if($conf->rowCount()>0){
				echo "Equipos incorporados";
				?>
                <img src="yes.jpg" height="20" width="20">
                <?php
				}else{
					echo "No se pudo incorporar el equipo";
					?>
                    <img src="no.jpg" height="20" width="20">
                    <?php
					}
				}
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>

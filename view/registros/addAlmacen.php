<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php 
if(isset($_SESSION["username"])){ //validación de variable de sesión
	if($_POST["Nroentrada"]){ //validación de existencia del dato de entrada
		require_once("../../db/connect.php");//llama a la conexión de base de datos
		require_once("insertItem.php");
		//captura de las variables utilizadas para el programa
		$nroentrada=$_POST["Nroentrada"];
		$nronota=$_POST["Nronota"];
		//consulta si el detalle de entrada ya existe, de tal forma para evitar registros duplicados
		$consulta=$dbh->prepare("select *from entrada, det_entrada 
		                         where entrada.IDentrada=det_entrada.IDentrada
								 and entrada.IDentrada=?");
		$consulta->bindParam(1,$nroentrada);
		$consulta->execute();
		//mensaje que indicará que el detalle ya existe
		if($consulta->rowCount()>0){
			echo "Detalle de entrada ya registrado<br>";
			echo "Presione el botón consultar";
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				//consulta del detalle de nota de remisión
		$sql=$dbh->prepare("select *from det_notaremision where nro_nota=?");
		$sql->bindParam(1,$nronota);
		$sql->execute();
		if($sql->rowCount()>0){
	#recorre el arreglo en base a la consulta anterior, de modo que se registrará el detalle de entradas de almacén
			foreach($sql->fetchAll() as $row){
				#captura de las variables de la nota de remisión para almacenar en los datos de almacén
				$idmaterial=$row[1];
				$unidad=$row[2];
				$cantidad=$row[3];
				$precio=$row[4];
				$insert=$dbh->prepare("insert into det_entrada values(?,?,?,?,?)");
				$insert->bindParam(1,$nroentrada);
				$insert->bindParam(2,$idmaterial);
				$insert->bindParam(3,$unidad);
				$insert->bindParam(4,$cantidad);
				$insert->bindParam(5,$precio);
				$insert->execute();
				
				//consulta de materiales
				$consultaMaterial=$dbh->prepare("select *from material where IDmaterial=?");
				$consultaMaterial->bindParam(1,$idmaterial);
				$consultaMaterial->execute();
				if($consultaMaterial->rowCount()>0){
					//actualiza la cantidad de materiales a partir del almacén
					$update=$dbh->prepare("update material set cant_disponible=? where IDmaterial=?");
					$update->bindParam(1,$cantidad);
					$update->bindParam(2,$idmaterial);
					$update->execute();
					InsertItem($idmaterial,$cantidad);
					}
				}//consulta para confirmar si el detalle de entrada ha sido registraro en el sistema
			$query=$dbh->prepare("select *from det_entrada where IDentrada=?");
			$query->bindParam(1,$nroentrada);
			$query->execute();
			if($query->rowCount()>0){ //mensaje que se desplegará si se cumple la condición
				echo "Detalle de almacén registrado";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}else{
					echo "No se pudo registrar el detalle de entrada";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
					}
			}else{
				echo "No se encontraron resultados";//mensaje de fallo de registro
				}		
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
			}
?>
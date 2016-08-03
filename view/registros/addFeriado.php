<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de realizar el registro de feriados
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	if(isset($_POST["Nombre"])){//verifica el nombre del feriado
		require_once("../../db/connect.php");//llama a la conexión a base de datos
		require_once("genera.php");//llama al archivo para generar el identificador
		try{
			$idferiado=generaCodigo();//función para generar el id del feriado
			$nombre=$_POST["Nombre"];//captura el nombre del feriado
			$desc=$_POST["Desc"];//captura la descripción
			$fec1=$_POST["Fec1"];//fecha de inicio
			$fec2=$_POST["Fec2"];//fecha de finalización
			#verifica que los campos estén llenos
			if(is_null($nombre) || is_null($desc) || is_null($fec1) || is_null($fec2)){
				echo "Complete todos los campos";
			}else{
				#expresión regular para respetar los tipos de dato fecha
			if(!(preg_match('/(\d{4})-(\d{2})-(\d{2})?$/',$fec1)) && !(preg_match('/(\d{4})-(\d{2})-(\d{2})?$/',$fec2))){
				echo "Fechas incorrectas";
				}else{
					if($fec1>$fec2){//validación que no permitirá insertar fechas de inicio mayores a las de culiminación
					echo "La fecha de inicio no puede ser mayor que la fecha de fin";	
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
						}else{
							#consulta de registro de feriados
			 $sql=$dbh->prepare("insert into calendario_feriado values(?,?,?,?,?)");
			 $sql->bindParam(1,$idferiado);//enlaza al id de feriado
			 $sql->bindParam(2,$nombre);//enlaza al nombre del feriado
			 $sql->bindParam(3,$desc);//enlaza a la descripción
			 $sql->bindParam(4,$fec1);//enlaza a la fecha de inicio
			 $sql->bindParam(5,$fec2);//enlaza a la fecha de finalización
			 if($sql->execute()){
				 echo "Feriado registrado";
				 ?>
                 <img src="yes.jpg" height="25" width="25">
                 <?php
				 }else{
				echo "No se pudo registrar el feriado";
				?>
                  <img src="no.jpg" height="25" width="25">
                <?php	 
					 }
							}
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
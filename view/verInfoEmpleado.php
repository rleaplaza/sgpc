<?php
session_start();//función de inicio de sesión
#Este programa despliega un formulario no editable con la información personal del empleado en sesión
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" rel="stylesheet" type="text/css">
<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	          color:#009;
	           size:auto;
				 }
				  #button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
	     #button:hover{
			background:#ddd;
			}
			</style>
</head>


<body>
<img src="../images/empleado.jpg" width="50" height="50" />
<legend>Información personal de empleado</legend>
<input type="submit" value='Volver a listado de empleados' onClick='history.back();' id="button">
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	try{
    $sql=$dbh->prepare("SELECT nombres, app, apm, CI, telefonos, direccion, fecNacimiento, estadoCivil, fechaRegistro, hraRegistro from empleado where CI=?");
	$sql->bindParam(1,$_GET["cedula"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		?>
            <form method="post" class="usuario" id="formualrio" >
            <table>
 <div><tr><td><label>Nombre completo:</label></td><td><input type="text" class="fecha" name="fecha" value="<?php echo $row[0]." ".$row[1]." ".$row[2];?>" disabled="disabled"></td></tr></div>
 <div><tr><td><label>Cedula de Identidad:</label></td><td><input type="text" class="cargo" name="cargo" value="<?php echo $row[3];?>" disabled="disabled"></td></tr></div>
 <div><tr><td><label>Telelefonos:</label></td><td><input type="text" class="depto" name="depto" value="<?php echo $row[4];?>" disabled="disabled"></td></tr></div>
 <div><tr><td><label>Direccion:</label></td><td><input type="text" class="salario" name="salario" value="<?php echo $row[5];?>" disabled="disabled"></td></tr></div>
 <div> <tr><td><label>Fecha de nacimiento:</label></td><td><input type="text" class="horario" name="horario" value="<?php echo $row[6];?>" disabled="disabled"></td></tr></div>
  <div><tr><td><label>Estado civil:</label></td><td><input type="text" class="bono" name="bono" value="<?php echo $row[7];?>" disabled="disabled"></td></tr></div>
    <div><tr><td><label>Fecha de registro:</label></td><td><input type="text" class="total" name="total" value="<?php echo $row[8];?>" disabled="disabled"></td></tr></div>
 <div><tr><td> <label>Hora de registro:</label></td><td><input type="text" class="descuento" value="<?php echo $row[9];?>" disabled="disabled"></td></tr></div>
 </table>
                </form>
       <?php
		}else{
			echo "<label>Su informacion aun no esta en sistema, consulte al administrador general de la empresa</label>";
			}
		}catch(PDOException $e){
		 echo("Error inesperado".$e->getMessage());
			}
	    }else{
		header("location: ../../index.php");//redirige al login
		}
?>
</div>
</body>
</html>
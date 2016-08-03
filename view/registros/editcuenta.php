<?php session_start();//función de inicio de sesión
#Este programa despliega el formulario de edición de cuenta de usuario como password y correo electrónico
?>
<html>
<head><title>Edicion de cuenta de usuario</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../css/example.css" rel="stylesheet" type="text/css">
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<style>
            label{
			  font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		      color:#00C;
			  font-size:12px;
	         }
	         legend{
			  font:Verdana, Geneva, sans-serif;
	          color:#009;
	          size:auto;
				 }
			</style>
</head>
<body>

<?php
if(isset($_SESSION["username"])){//verifica si existe la sesión
	try{ require_once("../../db/connect.php");//llama a la conexión a base de datos
	#consulta de la información del usuario
	$sql=$dbh->prepare("select *from usuario, rol where usuario.IDrol=rol.IDrol and username=?");
	$sql->bindParam(1,$_SESSION["username"]);
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $row){//el arreglo recorrerá la fila y cargará los registros en el formulario
			?>
            <fieldset>
            <legend>Edicion de su cuenta personal<img src="../../images/ayuda.jpg" height="20" width="20" title="Para la edicion de su cuenta, puede editar su email y password, se referencia con la imagen respectiva al lado derecho de cada campo"/></legend>
            <form method="post" class="usuario" id="formualrio" >
            <table>
<tr><td><label>Imprimir Información</label></td><td>
<input type="image" src="../../images/pdf_1.jpg" height="30" width="30" onclick="this.form.action='../../reportes/administracion/infoUsuario.php'" title="Exportar a PDF"></td></tr>
<tr><td><label>ID de usuario</label></td><td><input type="text" class="idusuario" name="idusuario" value="<?php echo $row[0];?>" disabled></td></tr>
 <tr><td><label>Usuario:</label></td><td><input type="text" id="username" class="username" name="username" value="<?php echo $row[1];?>" readonly></td></tr>
 <tr><td> <label>Email:</label></td><td><input type="text" class="email" value="<?php echo $row[3];?>" name="email" maxlength="45"><img src="../../images/editable.jpg" height="23" width="23" title="campo editable"/></td></tr>
 <tr><td><label>Password:</label></td><td><input type="password" class="password" name="password" value="" placeholder="******" maxlength="20"><img src="../../images/editable.jpg" height="20" width="20" title="campo editable"/></td></tr>
<tr><td><label>Confirmar password:</label></td><td><input type="password" class="confpassword" name="confpassword" value="" placeholder="******" maxlength="20"><img src="../../images/editable.jpg" height="20" width="20" title="campo editable"/></td></tr>
<tr><td><label>Notificar inicio de sesión por correo</label></td><td><input type="radio" checked name="rn" id="rbno" value="si" class="rbnotificacion">Sí<br><input type="radio" name="rn" id="rbsi" value="no" class="rbnotificacion">No</td></tr>
 <tr><td><label>Estado:</label></td><td><input type="text" class="estado" readonly value="<?php echo $row[6];?>"></td></tr>
<tr><td><label>Fecha de creacion: </label></td><td><input type="text" class="fecha" readonly value="<?php echo $row[7];?>"></td></tr>
<tr><td><label>Hora de creacion: </label></td><td><input type="text" class="hora" readonly value="<?php echo $row[8];?>"></td></tr>
<tr><td><label>Rol de usuario: </label></td><td><input type="text" class="rol" readonly value="<?php echo $row[9];?>"></td></tr>
               <div class="ultimo">
                <img src="ajax.gif" class="ajaxgif hide"/>
                <div class="msg"></div>
                <tr><td><button class="boton_envio" name="editar">Editar</button></td></tr>
                </div>
            </table>
            </form>
            </fieldset>
<script src="../../js/updateCuenta.js"></script>
            <?php
			}
		}
		}catch(PDOException $e){
			echo("Error inesperado ".$e->getMessage());//genera la excepción
			}
	}
	else{
		header("location: ../../index.php");//redirige al login
		}
?>
</body>
</html>
<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de envío de mensajes</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
       
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		require_once("consultas/mensajeAyuda.php");
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
        <img src="../images/email.jpg" height="40" width="40"><img src="../images/gmail.png" height="40" width="40"><br>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <fieldset>
    <legend>FORMULARIO DE ENVÍO DE CORREO</legend>
    <form method="post" class="usuario" id="form" name="formMessage" enctype="multipart/form-data">
    <table align="left">
    <div><tr><td><label>Título</label></td><td><input type="text"  class="titulo" name="titulo" id="titulo" required maxlength="80" placeholder="Asunto del mensaje"></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Email remitente</label></td><td><input type="text" name="email" id="email" class="email" placeholder="example@gmail.com" maxlength="25" required></td></tr></div>
     <div><tr><td><label>Password de email</label></td><td><input type="password" name="password" id="password" class="password" placeholder="******" maxlength="25"><img src="../images/ayuda.jpg" height="24" width="24" title="Ingrese su password email para enviar el mensaje"></td></tr></div>
      <div><tr><td><label>Email destinatario</label></td><td><input type="text" name="destino" id="destino" class="destino" placeholder="destino@gmail.com" maxlength="80" required></td></tr></div>
       <div><tr><td><label>Comentarios</label></td><td><textarea name="comentario" required class="comentario" id="comentario" cols="25" rows="4" placeholder="Cuerpo del mensaje"></textarea></td></tr></div>
       <div><tr><td><label>Adjuntar archivo</label></td><td><input type="file" class="file" name="archivo" id="archivo"></td></tr></div>
  <tr><td><input type="submit" id="sub" value="ENVIAR" onClick="this.form.action='registros/sendMessage.php'"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>
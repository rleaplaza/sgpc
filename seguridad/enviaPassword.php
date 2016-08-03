<meta charset="utf-8">
<style>
             legend{ font:Verdana, Geneva, sans-serif;
		      color:#03F;
	         }
			 label{
				 font:Verdana, Geneva, sans-serif;
		      color:#00F;
				 }
			 </style>
<?php
#Este programa se encarga de enviar nuevas contraseñas para el usuario que no puede acceder al sistema
require_once("../db/connect.php");//archivo de conexión a base datos
require_once("updatePassword.php");//archivo de actualización de password
if(isset($_POST["username"]) && isset($_POST["email"])){
$username=$_POST["username"];//captura el nombre de usuario
$email=$_POST["email"];//captura el email
$sql=$dbh->prepare("select *from usuario where username=? and email=?");
$sql->bindParam(1,$username);
$sql->bindParam(2,$email);
$sql->execute();
if($sql->rowCount()>0){
	$result=$sql->fetch();//devuelve el resultado en un arreglo
	$userID=$result["USR_UID"];
	$password=updatePassword($username,$email,$userID);
	$destino=$result["email"];//email destino
	$titulo="Cambio de contraseña";//título del mensaje
	require_once("../view/phpmailer/class.phpmailer.php");
require_once("../view/phpmailer/class.smtp.php");
	$mail = new PHPMailer();//instancia a la clase phpmailer
$mail->IsSMTP();//valida si se usa el servidor smtp
$mail->SMTPAuth = true;//activa la autencación para mayor seguridad
$mail->SMTPSecure = "ssl";//conexión segura
$mail->Host = "smtp.gmail.com";//servidor smtp gmail de donde se enviará los correos
$mail->Port = 465;//puerto gmail
#autenticación del email remitente
$mail->Username = "sercobolivia@gmail.com";
$mail->Password = "R1lch2014SC";
$mail->CharSet="UTF-8";

$mail->From = "sercobolivia@gmail.com";//direción de remitente
$mail->FromName = "Serco SRL";//nombre del remitente
$mail->Subject = $titulo;//instancia al título del mensaje

#cuerpo del mensaje
$mail->IsHTML(true);//Verifica el formato html para el mensaje
$mail->addEmbeddedImage('../images/logo.jpg','logo');
$mail->Body = "<html><meta charset=utf-8>
<body>
<b>Cambio de contraseña</b><br>
<table>
<tr><td style='background:blue;color:white;'>Su nombre de usuario:</td></tr>
<tr><td><b>".$username."</b></td></tr>
<tr><td style='background:blue;color:white;'>Su contraseña:</td></tr>
<tr><td><b>".$password."</b></td></tr>
</table>
</body>
</html>";

$mail->AddAddress($destino,"Recuperación de contraseña");

//Enviamos el correo electrónico
if($mail->Send()){
echo "<legend>Su nueva contraseña fue enviada a su cuenta de correo</legend>";//confima el envío
}else{
	echo "<legend>No se pudo enviar la solicitud</legend>";//error en caso de que el envío falle	
}
	}else{
		echo "<legend>Usuario inexistente</legend>";//mensaje que indica que la cuenta de usuario no existe
		}
}else{
	header("location: ../index.php");
	}
?>
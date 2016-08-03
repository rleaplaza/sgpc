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
function notificarSesion($user,$usruid){
require_once("phpmailer/class.phpmailer.php");
require_once("phpmailer/class.smtp.php");

#Este programa se encarga de enviar nuevas contraseñas para el usuario que no puede acceder al sistema
require_once("../db/connect.php");//archivo de conexión a base datos
global $dbh;
$sql=$dbh->prepare("select u.username, email, IDrol,fecInicio,hraInicio,dirIp from usuario as u inner join sesion as ses on u.USR_UID=ses.USR_UID and u.username=? 
and fecInicio=curdate()");
$sql->bindParam(1,$user);
$sql->execute();
	$result=$sql->fetch();//devuelve el resultado en un arreglo
	$destino=$result['email'];
	$fecInicio=$result['fecInicio'];
	$hora=$result['hraInicio'];
	$ip=$result['dirIp'];
	$titulo="Inicio de sesión";//título del mensaje
	$host=$_SERVER['HTTP_HOST'];
	$navegador=$_SERVER['HTTP_USER_AGENT'];
	$mail = new PHPMailer();//instancia a la clase phpmailer
$mail->IsSMTP();//valida si se usa el servidor smtp
$mail->SMTPAuth = true;//activa la autencación para mayor seguridad
$mail->SMTPSecure = "ssl";//conexión segura
$mail->Host = "smtp.gmail.com";//servidor smtp gmail de donde se enviará los correos
$mail->Port = 465;//puerto gmail
$mail->CharSet="UTF-8";
#autenticación del email remitente
$mail->Username = "sercobolivia@gmail.com";
$mail->Password = "R1lch2014SC";

$mail->From = "sercobolivia@gmail.com";//direción de remitente
$mail->FromName = "Serco SRL";//nombre del remitente
$mail->Subject = $titulo;//instancia al título del mensaje

#cuerpo del mensaje
$mail->IsHTML(true);//Verifica el formato html para el mensaje
//$mail->addEmbeddedImage('../images/logo.jpg','logo');
$mail->Body = "<html><meta charset=utf-8>
<body>
<b>Alerta de Inicio de sesión SGPC</b><br>
<table>
<tr><td style='background:blue;color:white;'>Recientemente se inició sesión en tu cuenta</td></tr>
<tr><td style='background:blue;color:white;'>Su nombre de usuario:</td></tr>
<tr><td><b>".$user."</b></td></tr>
<tr><td style='background:blue;color:white;'>Fecha de inicio de sesión:</td></tr>
<tr><td><b>".$fecInicio."</b></td></tr>
<tr><td style='background:blue;color:white;'>Hora de inicio de sesión:</td></tr>
<tr><td><b>".$hora."</b></td></tr>
<tr><td style='background:blue;color:white;'>Dirección de acceso:</td></tr>
<tr><td><b>".$ip."</b></td></tr>
<tr><td style='background:blue;color:white;'>Navegador:</td></tr>
<tr><td><b>".$navegador."</b></td></tr>
</table>
</body>
</html>";

$mail->AddAddress($destino,"Alerta de inicio de sesión");

//Enviamos el correo electrónico
if($mail->Send()){
	return 1;
}else{
	return 0;
	}
}
?>
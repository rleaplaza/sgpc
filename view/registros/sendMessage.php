<?php session_start();?>
<meta charset="utf-8">
<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
			 </style>
    <link href="../../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<?php
if(isset($_SESSION["username"])){
      $titulo="Solicitud de cotizaciones";
      $destino=$_POST['email'];
	
}else{
	header("location: ../../index.php");
	}
require_once("../phpmailer/class.phpmailer.php");
require_once("../phpmailer/class.smtp.php");
//Especificamos los datos y configuración del servidor


$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
 
//Nos autenticamos con nuestras credenciales en el servidor de correo Gmail
$mail->Username = "sercobolivia@gmail.com";
$mail->Password = "R1lch2014SC";
 
//Agregamos la información que el correo requiere
$mail->From = "sercobolivia@gmail.com";
$mail->FromName = "Serco SRL";
$mail->Subject = $titulo;
$mail->Body = "Adjunto el documento con la solicitud de cotizaciones";
//Adjunta el archivo ingresado desde el formulario
$mail->AddAttachment($_FILES["archivo"]["tmp_name"],$_FILES["archivo"]["name"]);
$mail->AddAddress($destino, "Notificacion");
$mail->IsHTML(true);//Verifica el formato html para el mensaje
 
//Enviamos el correo electrónico
if($mail->Send())
echo "<label>Mensaje enviado con éxito</label>";
else "no se pudo enviar el mensaje";
?>
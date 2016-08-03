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
      $titulo="Pedido de materiales";
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
$mail->Password = "Rlch2006";
 
//Agregamos la información que el correo requiere
$mail->From = "sercobolivia@gmail.com";
$mail->FromName = "SERCO SRL";
$mail->Subject = $titulo;
$mail->Body = "Adjunto el documento de pedido de materiales";
//$mail->MsgHTML("<h1>Serco LTDA!</h1>");
$mail->AddAttachment($_FILES["archivo"]["tmp_name"],$_FILES["archivo"]["name"]);
$mail->AddAddress($destino, "Notificacion");
$mail->IsHTML(true);
 
//Enviamos el correo electrónico
if($mail->Send())
echo "<label>Mensaje enviado con éxito</label>";
else "no se pudo enviar el mensaje";
?>
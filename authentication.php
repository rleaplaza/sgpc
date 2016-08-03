<?php session_start(); #función de manejo de sesiones
?>
<?php
#Este programa se encarga de realizar la autenticación al usuario en caso de cumplir con las condiciones para acceder al sistema
#llama a los archivos de ayuda para conectar a la BD y registrar las sesiones
require_once("db/connect.php");//archivo de conexión a la base de datos
require_once("reglogin.php");//registra la información del login
require_once("regvisitas.php");//registra la cantidad de accesos
try{
#captura de los datos de login
$_SESSION["username"]=trim(strtolower($_POST["username"]));
$_SESSION["password"]=trim(sha1($_POST["password"]));
#consulta de la cuenta de acceso
$sql=$dbh->prepare("select *from usuario where username=? and password=?");
$sql->bindParam(1,$_SESSION["username"]);#enlaza a los parametros de login
$sql->bindParam(2,$_SESSION["password"]);
$sql->execute();#ejecuta el query
if($sql->rowCount()>0){
   $login=$sql->fetch();
   if($login["estado"]=="activo"){#controla el estado activo del usuario
   $usruid=$login["USR_UID"];
   $sessID=session_id();
   $estado="activo";
   $notificacion=$login['notificar_sesion'];
   #consulta de la cantidad de permisos del usuario
   $query=$dbh->prepare("SELECT count( * ) AS permisos, username
                         FROM usuario, permiso
                         WHERE usuario.USR_UID = permiso.USR_UID
                         AND username = ? and permiso.estado=?");
	$query->bindParam(1,$_SESSION["username"]);//enlaza al nombre de usuario
	$query->bindParam(2,$estado);//enlaza al estado actual del usuario
	$query->execute();//ejecuta la intrucción
	$permisos=$query->fetch();
	if($permisos['permisos']>0){#si el usuario tiene al menos un permiso activado, puede ingresar al sistema
      echo("Autenticado");
	   reglogin($sessID, $usruid);//la función envía el id de sesión y el de usuario
       regvisitas();//función sin parámetros que registrará la cantidad de accesos
	}  #caso contrario no le permite el acceso
	   else 
	   echo("Usted no tiene permisos de acceso o no se encuentran activos");
		   
   }
   else 
   echo("Su cuenta ha sido deshabilitada, por tanto no puede iniciar sesión");
	   
  }
  else #las credenciales no son correctas
	  echo("Credenciales invalidas");
	  
}catch(PDOException $e){
  echo "Error inesperado " . $e.getMessage();//en caso de que la conexión falle, se genera una excepción
}
?>
<!--Este programa se encarga de desplegar el registro del título y la fecha del sistema -->
<style>
label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  text-align:center;
	         }
</style>

<link href="css/estilos.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<?php
require_once("db/connect.php");

$time=$dbh->prepare("select curtime()");//consulta para recuperar la hora actual
$time->execute();//ejecuta la instrucción
$res=$time->fetch();//devuelve el resultado en un arreglo
$hora=$res[0];//almacena el índice de la hora

$hoy=getdate();

$fecha=$hoy["mday"]."-".$hoy["mon"]."-".$hoy["year"];
echo("<p align=right><label>Fecha: ". $fecha." ".$hora."</label></p>");

?>
<html>
<body bgcolor="#FFFFFF">
<p align="center"><label>PLATAFORMA INFORMÁTICA PARA LA GESTIÓN DE PROYECTOS DE CARRETERAS</label></center>
<style type="text/css">
* { margin:0 auto;
		    padding:0;
		}
		html { background:#FFF; }
		body{    margin:1px auto;
    
}
span{	margin-top: 2px;
    padding-left: 15px;
    color: ##00FF66A6C4D5;
    font: bold 17px Arial,Helvetica;
    background: #FFF
    line-height: 50px;	
    display: block;
    cursor: pointer;
    background-repeat: no-repeat;
    background-position: 95% 0;
    text-align: center;
}
</style>
</html>
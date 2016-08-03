<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando la diferencia de duraciones de un proyecto
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de hora
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$sql=$dbh->prepare("SELECT nombreActividad
                    FROM actividad
					where IDactividad=?");
$sql->bindParam(1,$_GET["idactividad"]);
$sql->execute();// ejecuta el query
$result=$sql->fetch();
$actividad=$result[0];
$progreso=$_GET["progreso"];
$avanceprog=$_GET["avanceProg"];
$avancereal=$_GET["avanceReal"];
$unidades=$_GET["unidad"];
$diferencia=$avanceprog-$avancereal;
$datos=array($avanceprog,$avancereal,$diferencia); //array de datos para el proyecto

$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(700, 600, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set("Informe de progreso, fecha: ".$fecha);
$grafico->subtitle->Set("Actividad: ".$actividad);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Progreso de la actividad");//establece el eje x
$grafico->xaxis->SetTickLabels(array("Avance programado: ".$avanceprog." ".$unidades,"Avance Real: ".$avancereal." ".$unidades,"Avance Faltante: ".$diferencia." ".$unidades));//texto del campo proyecto
$grafico->yaxis->title->Set("Valores en unidad de ".$unidades);//setea el eje y
#dibuja el grafico de al duracion
$barplot1 =new BarPlot($datos);//carga el total de accesos
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("#221123", "#A3AAF6", GRAD_VER);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);//dibuja el gráfico
$grafico->Stroke();


}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>
<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando el avance informado total por cada trabajador asignado a una actividad
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo de captura de fecha y hora actual

$actividad=$_GET["actividad"];
$unidad=$_GET["unidad"];
 //consulta PDO que solicita el nombre del trabajador y el total avanzado por actividad
$sql=$dbh->prepare("SELECT nombre, ap_p, p.CI_trabajador, total_unidad_avance
FROM personalmanoobra AS p, actividad_trabajador AS at, actividad AS a
WHERE p.CI_trabajador = at.CI_trabajador
AND at.IDactividad = a.IDactividad
and a.IDactividad=?");
$sql->bindParam(1,$_GET["idactividad"]);
$sql->execute();// ejecuta el query
$trabajador=array();
$avanceInformado=array();
foreach($sql->fetchAll() as $row){//arreglo para recorrer todas las filas del registro recuperado
$trabajador[]=$row["nombre"]." ".$row["ap_p"]." ".$row["total_unidad_avance"]." ".$unidad;
$avanceInformado[]=$row["total_unidad_avance"];
}


$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(700, 600, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set("Informe de avance por trabajador, fecha: ".$fecha);
$grafico->subtitle->Set($actividad);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Avance informado");//establece el label del eje x
$grafico->xaxis->SetTickLabels($trabajador);//texto del campo proyecto
$grafico->yaxis->title->Set("Avances informados ".$unidad);//establece el label del eje y
#dibuja el grafico de al duracion
$barplot1 =new BarPlot($avanceInformado);//carga el total de avances informados
// establece el color en gradiente
$barplot1->SetFillGradient("#1A3321", "#B3FAF6", GRAD_VER);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);//dibuja el gráfico
$grafico->Stroke();

}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>

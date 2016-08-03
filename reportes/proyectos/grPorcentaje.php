<?php session_start();?>
<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico para mostrar la comparación de avance programado y avance real para un proyecto
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de hora
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$proyecto=$_GET["proyecto"];
$duracionPr=$_GET["duracionpr"];
$duracionReal=$_GET["duracionreal"];
$porcentaje_avance_programado=($duracionReal*100)/$duracionPr;
$porcentaje_faltante=100-$porcentaje_avance_programado;
$datos=array($porcentaje_faltante,$porcentaje_avance_programado);
$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(1000, 700, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set("Informe de porcentaje de avance programado");
$grafico->subtitle->Set("Fecha: ".$fecha);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Porcentaje de avance");//establece el eje x
$grafico->xaxis->SetTickLabels(array("Porcentaje faltante: ".round(($porcentaje_faltante),2)." %","Porcentaje programado: ".round(($porcentaje_avance_programado),2)." %"));//texto para el arreglo de cargos
$grafico->yaxis->title->Set("Valor de porcentaje");//setea el eje y
#dibuja el grafico de al duracion
$barplot1 =new BarPlot($datos);//carga el total de cargos para el gráfico
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("#221123", "#A3AAF6", GRAD_HOR);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);//dibuja el gráfico
$grafico->Stroke();

$grafico->Stroke(_IMG_HANDLER);

$fileName = "grafica1.png";
$grafico->img->Stream($fileName);

// envía al navegador
$grafico->img->Headers();
$grafico->img->Stream();

}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>

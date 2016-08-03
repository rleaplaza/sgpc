<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando la diferencia de costos programado y real en barra
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$sql=$dbh->prepare("SELECT nombreActividad
                    FROM actividad
					where IDactividad=?");
$sql->bindParam(1,$_GET["idactividad"]);
$sql->execute();// ejecuta el query
$result=$sql->fetch();
$actividad=$result[0];
#captura las variables de costo real y programado
$costoProg=$_GET["costo_prog"];
$costoReal=$_GET["costo_real"];
$datos=array($costoProg,$costoReal); //array de datos para el proyecto

$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(1100, 700, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set($actividad);
$grafico->subtitle->Set("Informe de diferencia de costos la actividad, fecha: ".$fecha);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Costos");//establece el eje x
$grafico->xaxis->SetTickLabels(array("Costo Programado ".$costoProg." Bs","Costo real: ".$costoReal." Bs"));//Labels referentes a costos para las barras
//$grafico->yaxis->title->Set("Valores de costo del la actividad");//setea el eje y
#dibuja el grafico de al duracion
$barplot1 =new BarPlot($datos);//carga el array de costos
// Establece el color en gradiente
$barplot1->SetFillGradient("#1A3321", "#B3FAF6", GRAD_VER);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(40);
$grafico->legend->SetPos(0.6,0.9,'right','botton');
$grafico->Add($barplot1);//dibuja el gráfico
$grafico->Stroke();//genera el gráfico

$grafico->Stroke(_IMG_HANDLER);//genera el gráfico en imagen

$fileName = "grafica1.png";//nombre de la imagen
$grafico->img->Stream($fileName);//define el archivo

// envía al navegador
$grafico->img->Headers();
$grafico->img->Stream();

}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>

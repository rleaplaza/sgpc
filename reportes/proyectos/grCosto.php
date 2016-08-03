<?php session_start();?>
<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando la diferencia de costos programado y real en tipo barra
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");
 if(isset($_SESSION["username"])){
	 if(isset($_GET["idproyecto"])){
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$sql=$dbh->prepare("SELECT nombre
                    FROM proyecto
					where IDproyecto=?");
$sql->bindParam(1,$_GET["idproyecto"]);
$sql->execute();// ejecuta el query
$result=$sql->fetch();
$proyecto=$result[0];
$costoProg=$_GET["costoProg"];
$costoReal=$_GET["costoReal"];
$diferencia=$costoProg-$costoReal;
$datos=array($costoProg,$costoReal,$diferencia); //array de datos para el proyecto
//$duracion_real=array();
//arreglo para recorrer todas las filas del registro recuperado

$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(700, 600, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set($proyecto);
$grafico->subtitle->Set("Informe de diferencia de costos del proyecto, fecha: ".$fecha);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Costos");//establece el eje x
$grafico->xaxis->SetTickLabels(array("Costo Programado ".$costoProg." Bs","Costo real ".$costoReal." Bs","Monto sobrante: ".$diferencia." Bs"));//texto del campo proyecto
$grafico->yaxis->title->Set("Valores de costo del proyecto");//setea el eje y
#dibuja el grafico de al duracion
$barplot1 =new BarPlot($datos);//carga el total de accesos
// establece el color en gradiente
$barplot1->SetFillGradient("#221123", "#A3AAF6", GRAD_VER);
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
	 }else{
		 header("location: ../../index.php");
		 }
 }else{
	 header("location: ../../index.php");
	 }
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>

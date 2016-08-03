<?php session_start();?>
<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando la diferencia de duraciones de un proyecto
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de hora
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$sql=$dbh->prepare("SELECT nombre
                    FROM proyecto
					where IDproyecto=?");
$sql->bindParam(1,$_GET["idproyecto"]);
$sql->execute();// ejecuta el query
$result=$sql->fetch();
$proyecto=$result[0];
$progreso=$_GET["progreso"];
$ProgresoTotal=100;
$diferencia=100-$progreso;
$datos=array($diferencia,$progreso); //array de datos para el proyecto

$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(800, 600, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set($proyecto);
$grafico->subtitle->Set("Informe de progreso, fecha: ".$fecha);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Progreso del proyecto");//establece el eje x
$grafico->xaxis->SetTickLabels(array("Progreso por completar: ".$diferencia." %","Progreso real: ".$progreso." %"));//texto del campo proyecto
$grafico->yaxis->title->Set("Valores de progreso en porcentajes");//setea el eje y
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

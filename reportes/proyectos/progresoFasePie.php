<?php 
#Este programa se encarga de desplegar el gráfico de progreso de actividades
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
require_once("../../db/connect.php");//LLama a la conexión de base de datos
require_once("../../view/hora.php");//archivo para la función de despliegue de hora
#captura de variables
$idfase=$_GET["idfase"];
$fase=$_GET["fase"];
$actProg=$_GET["actProg"];
$actcon=$_GET["actcon"];
$diferencia=$actProg-$actcon;
$data=array($actcon,$diferencia);
$fecha=getFecha(); 
$graph = new PieGraph(800,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new OrangeTheme;//define el tema de apariencia
 $graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Informe de progreso, fase: ".$fase);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("fecha: ".$fecha);
//$graph->subtitle->set("Fecha ".$fecha);
$p1 = new PiePlot3D($data);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.45);//Posición del centro del gráfico
$p1->SetLegends(array("Actividades concluidas ".$actcon,"Actividades por realizar ".$diferencia));//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.5,0.1,'right','botton');
 
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
 
?>

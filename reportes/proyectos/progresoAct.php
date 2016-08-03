<?php 
#Este programa se encarga de desplegar el gráfico de progreso de actividades
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
require_once("../../db/connect.php");//LLama a la conexión de base de datos
require_once("../../view/hora.php");//archivo para la función de despliegue de hora
#consulta para recuperar el nombre de la actividad
$idactividad=$_GET["idactividad"];
$sql=$dbh->prepare("select nombreActividad from actividad where IDactividad=?");
$sql->bindParam(1,$idactividad);//enlaza al id de la actividad
$sql->execute();
$result=$sql->fetch();
$actividad=$result[0];//almacena el valor del arreglo
#captura de variables
$avanceProg=$_GET["avanceProg"];
$avanceReal=$_GET["avanceReal"];
$progreso=$_GET["progreso"];
$unidad=$_GET["unidad"];
$diferencia=$avanceProg-$avanceReal;
$data = array($diferencia,$avanceReal);//arreglo que será utilizado para desplegar el gráfico representando el porcentaje de avances
$fecha=getFecha(); 
$graph = new PieGraph(800,600);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new OrangeTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Informe de avance, actividad: ".$actividad. " ".$avanceProg." ".$unidad);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha ".$fecha);
$p1 = new PiePlot3D($data);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.45);//Posición del centro del gráfico
$p1->SetLegends(array("Avance faltante: ".$diferencia." ".$unidad,"Avance Real: ".$avanceReal." ".$unidad));//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.2,0.1,'left','botton');
 
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
 
?>
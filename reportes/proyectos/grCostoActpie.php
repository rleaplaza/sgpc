<?php 
#Este programa se encarga de desplegar el gráfico de costo del proyecto en tipo torta
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
require_once("../../db/connect.php");//LLama a la conexión de base de datos
require_once("../../view/hora.php");//archivo para la función de despliegue de hora
#captura de variables
$sql=$dbh->prepare("SELECT nombreActividad
                    FROM actividad
					where IDactividad=?");
$sql->bindParam(1,$_GET["idactividad"]);
$sql->execute();// ejecuta el query
$result=$sql->fetch();
$actividad=$result[0];
#captura de variables
$costo_prog=$_GET["costo_prog"];
$costo_real=$_GET["costo_real"];
$diferencia=$costo_prog-$costo_real;
#calcula el porcentaje
//$porcentaje=($costo_real*100)/$costo_prog;
//$diferencia=100-$porcentaje;
$data = array($diferencia,$costo_real);//arreglo que será utilizado para desplegar el gráfico representando el porcentaje de costos
$fecha=getFecha();//captura la fecha y hora actual
$graph = new PieGraph(800,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new OrangeTheme;//define el tema de apariencia
 $graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set($actividad." costo ".$costo_prog. " Bs");//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha. ".$fecha); 
$p1 = new PiePlot3D($data);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.5,0.55);//Posición del centro del gráfico
$p1->SetLegends(array("Costo por invertir: ".$diferencia." BS","Costo real: ".$costo_real." BS"));//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.2,0.1,'left','botton');
 
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
?>
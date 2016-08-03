<?php session_start();?>
<?php 
#Este programa se encarga de desplegar el gráfico de progreso del proyecto en tipo torta
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de hora
#captura de variables
$sql=$dbh->prepare("SELECT nombre
                    FROM proyecto
					where IDproyecto=?");
$sql->bindParam(1,$_GET["idproyecto"]);
$sql->execute();// ejecuta el query
$result=$sql->fetch();
$proyecto=$result[0];
$progreso=$_GET["progreso"];
$diferencia=100-$progreso;
$fecha=getFecha();//recupera la fecha y hora actual
$data = array($diferencia,$progreso);//arreglo que será utilizado para desplegar el gráfico representando el porcentaje del proyecto
 
$graph = new PieGraph(800,600);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new AquaTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Progreso del proyecto: ".$proyecto);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha ".$fecha); 
$p1 = new PiePlot3D($data);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSliceColors(array('red','green'));
$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.45);//Posición del centro del gráfico
$p1->SetLegends(array("Progreso faltante","Progreso real"));//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.2,0.1,'left','bottom');
 
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
 
?>
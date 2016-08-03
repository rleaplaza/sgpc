<?php 
#Este programa se encarga de desplegar el gráfico de diferencias en duración del proyecto
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de fecha y hora
#consulta para recuperar el nombre del proyecto en base al ID
$sql=$dbh->prepare("SELECT nombre
                    FROM proyecto
					where IDproyecto=?");
$sql->bindParam(1,$_GET["idproyecto"]);//enlaza el id del proyecto
$sql->execute();// ejecuta el query
$result=$sql->fetch();//devolverá el resultado en un arreglo
$proyecto=$result[0];//almacena el nombre del proyecto
#captura de duraciones
$duracion_programada=$_GET["duracion_prog"];
$duracion_real=$_GET["duracion_real"];
$diferencia=$duracion_programada-$duracion_real;//realiza la resta de diferencia en duración faltante de días
$fecha=getFecha();//Llama a la función para recuperar la fecha y hora del sistema 
$data = array($diferencia,$duracion_real);//arreglo que será utilizado para desplegar el gráfico representando el porcentaje de avances
 
$graph = new PieGraph(800,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new AquaTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Duracion del proyecto: ".$proyecto);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha: ".$fecha);//imprime la fecha y hora del sistema
 
$p1 = new PiePlot3D($data);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSliceColors(array('red','green'));
$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.45);//Posición del centro del gráfico
$p1->SetLegends(array("Dias faltantes: ".$diferencia." dias","Duracion Real: ".$duracion_real." dias"));//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.2,0.1,'left','botton');//Setea la posición de los labels correspondientes a la leyenda del gráfico
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
?>
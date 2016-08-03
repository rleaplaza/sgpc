<?php 
#Este programa se encarga de desplegar el gráfico en torta referente a los avances informados del trabajador
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
require_once("../../db/connect.php");//LLama a la conexión de base de datos
require_once("../../view/hora.php");//archivo para la función de despliegue de fecha y hora
 #recuperación de las variables de actividad y material
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

foreach($sql->fetchAll() as $row){
$trabajador[]=$row["nombre"]." ".$row["ap_p"].": ".$row["total_unidad_avance"]." ".$unidad;
$avanceInformado[]=$row["total_unidad_avance"];
}
$fecha=getFecha();//recupera la fecha y hora actual
$graph = new PieGraph(800,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new OrangeTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Avance informado de trabajadores, actividad: ".$actividad);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha: ".$fecha);//imprime la fecha y hora del sistema
 
$p1 = new PiePlot3D($avanceInformado);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.65,0.55);//Posición del centro del gráfico
$p1->SetLegends($trabajador);//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.01,0.1,'left','botton');//Setea la posición de los labels correspondientes a la leyenda del gráfico
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
?>
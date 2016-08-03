<?php 
#Este programa se encarga de desplegar el gráfico en tipo torta describiendo el porcentaje de precios unitarios por fase
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de hora
#captura de variables
$idfase=$_POST["fase"];
#consulta para el nombre de la fase
$consulta=$dbh->prepare("select nombre from fase where IDfase=?");
$consulta->bindParam(1,$idfase);
$consulta->execute();
$result=$consulta->fetch();
$fase=$result[0];//almacena la fase
#consulta para recuperar las actividades y precios para la fase
$sql=$dbh->prepare("SELECT actividad.IDactividad as idactividad,nombreActividad, precioUnitarioBS
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					order by actividad.hraRegistro");
$sql->bindParam(1,$idfase);
$sql->execute();// ejecuta el query
$actividad=array();//define el arreglo de cargos 
$precio=array();//define el arraglo para el total de personas
$targets=array();
$alts=array();
$fecha=getFecha();//recupera la fecha y hora actual
foreach($sql->fetchAll() as $row){
	$actividad[]=$row["nombreActividad"]." ".$row["precioUnitarioBS"]." Bs";
	$precio[]=$row["precioUnitarioBS"];
	$targets[]="grdetPrecios.php?idactividad=$row[idactividad]";
	$alts[]="val=%s";
	}
 
$graph = new PieGraph(1200,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new VividTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Precios unitarios de actividades, Fase: ".$fase);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha: ".$fecha); 
$p1 = new PiePlot3D($precio);//dibuja el gráfico en base a los datos introducidos de precios unitarios

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.5,0.6);//Posición del centro del gráfico
$p1->SetLegends($actividad);//define la leyenda para referenciar la actividad
$p1->SetCSIMTargets($targets,$alts);
$graph->legend->SetPos(0.1,0.2,'left','bottom');
 
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
 
?>
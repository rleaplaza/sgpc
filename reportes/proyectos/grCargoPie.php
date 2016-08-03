<?php session_start();//inicio de la sesión?>
<?php 
try{
if(isset($_SESSION["username"])){
	if(isset($_GET["idproyecto"])){
#Este programa se encarga de desplegar el gráfico en tipo torta describiendo la cantidad de personas participantes de un cargo en un proyecto para saber que cargo tiene mayor cantidad de trabajadores
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
require_once("../../db/connect.php");//LLama a la conexión de base de datos
require_once("../../view/hora.php");//archivo para la función de despliegue de hora
#captura de variables
$sql=$dbh->prepare("SELECT c.nombre as cargo, sum( cantidad_contratada ) AS cantidad
                    FROM cargomanodeobra AS c, solicita AS s, proyecto AS proy
                    WHERE c.IDcargoM = s.IDcargo_M
                    AND s.IDproyecto = proy.IDproyecto
					and proy.IDproyecto=?
                    GROUP BY c.nombre asc");
$sql->bindParam(1,$_GET["idproyecto"]);
$sql->execute();// ejecuta el query
$cargo=array();//define el arreglo de cargos 
$total=array();//define el arraglo para el total de personas
$targets=array();
$alts=array();
$fecha=getFecha();//recupera la fecha y hora actual
foreach($sql->fetchAll() as $row){
	$cargo[]=$row["cargo"]." ".$row["cantidad"];
	$total[]=$row["cantidad"];
	}
 
$graph = new PieGraph(800,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new VividTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Cargos participantes");//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha: ".$fecha); 
$p1 = new PiePlot3D($total);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.5,0.6);//Posición del centro del gráfico
$p1->SetLegends($cargo);//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.2,0.2,'left','bottom');
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
	}else{
		header("location: ../../index.php");
		}
}else{
	header("location: ../../index.php");
	}
}catch(PDOException $e){
	echo "Error inesperado ".$e->getMessage();
	}
?>
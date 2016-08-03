<?php session_start();?>
<?php 
#Este programa se encarga de generar el gráfico en lineas de gastos por fase
require_once ('../../jpgraph/src/jpgraph.php');//llamada a los archivo jpgraph y jp graph line
require_once ('../../jpgraph/src/jpgraph_line.php');
require_once("../../db/connect.php");//llamada a la conexión
try{if(isset($_SESSION["username"])){//valida la sesión
	if(isset($_GET["idactividad"])){//valida el identificador de fase
		#Captura de variables del formulario
		$idactividad=$_GET["idactividad"];
	    #arreglo del avance programado
		$unidad=$_GET["unidad"];
		#Consulta para el nombre de la fase
		$consulta=$dbh->prepare("select nombreActividad, cantidad from actividad where IDactividad=?");
		$consulta->bindParam(1,$idactividad);
		$consulta->execute();
		$result=$consulta->fetch();
		$actividad=$result["nombreActividad"];
		$cantidad_programada=array();
		$cantidad_programada[]=$result["cantidad"];
		#consulta de fechas de inicio de actividades, costor programados y reales
$sql=$dbh->prepare("SELECT total_unidad_avance as avance, fecha_avance from actividad_trabajador 
                    where IDactividad=?");
$sql->bindParam(1,$idactividad);
$sql->execute();
if($sql->rowCount()>0){//si existen resultados ejecuta las instrucciones
$totalAvance=array();
$fecAvance=array();
foreach($sql->fetchAll() as $row){
	$totalAvance[]=$row["avance"];
	$fecAvance[]=$row["fecha_avance"];
	}
// Setup the graph
$graph = new Graph(800,500);
$graph->SetMarginColor('white');
$graph->SetScale("textlin");
$graph->SetMargin(80,50,30,30);

$graph->title->Set('Actividad '.$actividad);


$graph->yaxis->HideZeroLabel();
$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
$graph->xgrid->Show();

$graph->xaxis->SetTickLabels($fecAvance);

// Create the first line
$p1 = new LinePlot($cantidad_programada);
$p1->SetColor("navy");
$p1->SetLegend('Avance programado');
$graph->Add($p1);

// Create the second line
$p2 = new LinePlot($totalAvance);
$p2->SetColor("red");
$p2->SetLegend('Avance real');
$graph->Add($p2);


$graph->legend->SetShadow('gray@0.4',5);
$graph->legend->SetPos(0.1,0.9,'right','top');
// Output line
$graph->Stroke();
}else{
	echo "No se encontraron resultados";
	}
	}else{
		header("location: ../../index.php");//dirige en caso de no existir la variable identificador
		}
	}else{
		header("location: ../../index.php");//dirige al usaurio en caso de no existir la sesión
		}
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>


<?php session_start();?>
<?php
require_once("../../jpgraph/src/jpgraph.php");
require_once("../../jpgraph/src/jpgraph_gantt.php");
require_once("../../view/hora.php");
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
	if(isset($_GET["idfase"]) && isset($_GET["fase"])){
$idfase=$_GET["idfase"];
$fase=$_GET["fase"];
$fecha=getFecha();
$sql =$dbh->prepare("SELECT nombreActividad,cantidad,total_avance,fechaRealizacion, fechaFin
                     FROM fase AS f, subfase AS sf, actividad AS a
                     WHERE f.IDfase = sf.IDfase
                     AND sf.IDsubfase = a.IDsubfase
                     AND f.IDfase = ?
		     order by a.hraRegistro asc");
$sql->bindParam(1,$idfase);
$sql->execute();
$title=$fase;
$data = array();
$i = 0;
while ($rec = $sql->fetch()) {
	$total_avance=$rec['total_avance'];
	$cantidad=$rec['cantidad'];
    $porcentaje=round((($total_avance/$cantidad)*100),2);
  $data[] = array($i++,ACTYPE_NORMAL,utf8_decode($rec['nombreActividad']),$rec['fechaRealizacion'],$rec['fechaFin'],"[".$porcentaje."%]");
}

// Create the basic graph
$graph = new GanttGraph(1000,600,'auto');
$graph->SetShadow();
$graph->title->Set("Actividades de la Fase: ".$title. ", fecha: ".$fecha);

// Setup scale
$graph->scale->week->SetStyle(FF_FONT0);
$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH |GANTT_HDAY| GANTT_HWEEK );
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAYWNBR);
$graph->scale->month->SetFontcolor("white");
$graph->scale->month->SetBackgroundColor("blue");
// Add the specified activities
$graph->CreateSimple($data);
// .. and stroke the graph
$graph->Stroke();
	}else{
		header("location: ../../index.php");
		}
}else{
	header("location: ../../index.php");
	}
?>
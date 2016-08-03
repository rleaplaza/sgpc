<?php session_start();?>
<?php 
#Este programa se encarga de desplegar un gráfico de doble barra referente a costos real y previsto por fases de un proyecto
require_once ('../../jpgraph/src/jpgraph.php');
require_once ('../../jpgraph/src/jpgraph_bar.php');
require_once("../../db/connect.php");
require_once("../../view/hora.php");
$idproyecto=$_GET["idproyecto"];//captura el id del proyecto
$idfase=$_GET["idfase"];
$sql=$dbh->prepare("SELECT fase.nombre as fase, sum( costo_programado ) as costoPrevisto , sum( costo_total ) as costoReal
                    FROM fase, subfase, actividad, proyecto
                    WHERE proyecto.IDproyecto = fase.IDproyecto
                    AND fase.IDfase = subfase.IDfase
                    AND subfase.IDsubfase = actividad.IDsubfase
					and proyecto.IDproyecto=?
					and fase.IDfase=?
                    GROUP BY fase.nombre");
$sql->bindParam(1,$idproyecto);
$sql->bindParam(2,$idfase);
$sql->execute();
#definición de los arreglos de sumatorias y fases
$fase=array();
$costoPrevisto=array();
$costoReal=array();
$cpr=0;
$cr=0;
#arreglo que recorrerá todas las filase para acumular en los arrays definidos
foreach($sql->fetchAll() as $row){
	$costoPrevisto[]=$row["costoPrevisto"];
	$costoReal[]=$row["costoReal"];
	$fase[]=$row["fase"]." Previsto: ".$row["costoPrevisto"]."Bs, real: ".$row["costoReal"]." Bs";
	$cpr=$row["costoPrevisto"];
	$cr=$row["costoReal"];
	}
#arreglo que recorrerá todas las filase para acumular en los arrays definidos

$graph = new Graph(900,700);    
$graph->SetScale("textlin");

$graph->SetShadow();
$graph->img->SetMargin(80,20,10,60);
 

$b1plot = new BarPlot($costoPrevisto);
$b1plot->SetFillgradient('orange','darkred',GRAD_VER); 
$b1plot->SetWidth(40); 
$b2plot = new BarPlot($costoReal);
$b2plot->SetFillgradient('blue','darkblue',GRAD_VER); 
$b2plot->SetWidth(40); 
$b1plot->SetLegend("Costo Previsto Bs");
$b2plot->SetLegend("Costo real Bs");
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
 

$graph->Add($gbplot);
 
$graph->title->Set("Informe de costo previsto y real");
$graph->xaxis->title->Set("Costos real y previsto por fase");
$graph->yaxis->title->Set("Valores de costo");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetTitleMargin(60);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTickLabels($fase);//texto del campo proyecto 
$graph->legend->SetPos(0.32,0.85,'Left','top');
$graph->Stroke();
?>
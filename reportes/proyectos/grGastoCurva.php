<?php session_start();?>
<?php 
#Este programa se encarga de generar el gráfico en lineas de gastos por fase
require_once ('../../jpgraph/src/jpgraph.php');//llamada a los archivo jpgraph y jp graph line
require_once ('../../jpgraph/src/jpgraph_line.php');
require_once("../../db/connect.php");//llamada a la conexión
try{if(isset($_SESSION["username"])){//valida la sesión
	if(isset($_GET["idfase"])){//valida el identificador de fase
		#Captura de variables del formulario
		$idfase=$_GET["idfase"];
		$fec1=$_GET["fec1"];
		$fec2=$_GET["fec2"];
		#Consulta para el nombre de la fase
		$consulta=$dbh->prepare("select nombre from fase where IDfase=?");
		$consulta->bindParam(1,$idfase);
		$consulta->execute();
		$result=$consulta->fetch();
		$fase=$result["nombre"];
		#consulta de fechas de inicio de actividades, costor programados y reales
$sql=$dbh->prepare("SELECT fechaRealizacion AS comienzo, costo_programado, costo_total
                    FROM actividad, subfase, fase
                    WHERE actividad.IDsubfase = subfase.IDsubfase
                    AND subfase.IDfase = fase.IDfase
					and fase.IDfase=?
					and fechaRealizacion between ? and ?
                    ORDER BY fechaRealizacion ASC ");
#Enlaza al identificador y al rango de fechas
$sql->bindParam(1,$idfase);
$sql->bindParam(2,$fec1);
$sql->bindParam(3,$fec2);
$sql->execute();
if($sql->rowCount()>0){//si existen resultados ejecuta las instrucciones
$comienzo=array();//arreglo vacío para las fechas de inicio
$costo_programado=array();//arreglo vacío para costos programados
$costo_real=array();
foreach($sql->fetchAll() as $row){
	$comienzo[]=$row["comienzo"];
	$costo_programado[]=$row["costo_programado"];
	$costo_real[]=$row["costo_total"];
	}
// Setup the graph
$graph = new Graph(800,500);
$graph->SetMarginColor('white');
$graph->SetScale("textlin");
$graph->SetMargin(80,50,30,30);

$graph->title->Set('Fase '.$fase);


$graph->yaxis->HideZeroLabel();
$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
$graph->xgrid->Show();

$graph->xaxis->SetTickLabels($comienzo);

// Create the first line
$p1 = new LinePlot($costo_programado);
$p1->SetColor("navy");
$p1->SetLegend('Costo programado');
$graph->Add($p1);

// Create the second line
$p2 = new LinePlot($costo_real);
$p2->SetColor("red");
$p2->SetLegend('Costo Real');
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


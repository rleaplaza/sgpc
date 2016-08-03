<?php session_start();?>
<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando la cantidad de cargos participantes en el proyecto
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de hora
 if(isset($_GET["idproyecto"])){
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$sql=$dbh->prepare("SELECT c.nombre as cargo, cantidad_contratada  AS cantidad
                    FROM cargomanodeobra AS c, solicita AS s, proyecto AS proy
                    WHERE c.IDcargoM = s.IDcargo_M
                    AND s.IDproyecto = proy.IDproyecto
					and proy.IDproyecto=?
                    group by c.nombre 
					order by c.nombre desc");
$sql->bindParam(1,$_GET["idproyecto"]);
$sql->execute();// ejecuta el query
$result=$sql->fetch();
$cargo=array(); //array de datos para el cargo, eje x
$total=array();//array de datos para las cantidades, eje y
foreach($sql->fetchAll() as $row){
	$cargo[]=$row["cargo"];
	$total[]=$row["cantidad"];
	}

$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(808, 700, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set("Informe de cargos participantes en proyecto");
$grafico->subtitle->Set("Fecha: ".$fecha);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Cargos");//establece el eje x
$grafico->xaxis->SetTickLabels($cargo);//texto para el arreglo de cargos
$grafico->yaxis->title->Set("Cantidad participante");//setea el eje y
#dibuja el grafico de al duracion
$barplot1 =new BarPlot($total);//carga el total de cargos para el gráfico
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("#221123", "#A3AAF6", GRAD_HOR);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);//dibuja el gráfico
$grafico->Stroke();

$grafico->Stroke(_IMG_HANDLER);//prepara la exportación a imagen

$fileName = "grafica1.png";//nombre del archivo y la extensión jpg
$grafico->img->Stream($fileName);//enlaza el gráfico al archivo

// envía la imagen al directorio
$grafico->img->Headers();
$grafico->img->Stream();
 }else{
	 header("location: ../../index.php");//dirige al usuario en caso de no existir la variable de proyecto
	 }
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();//genera una excepción en caso de que la conexión falle
	}
?>

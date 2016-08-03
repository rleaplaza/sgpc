<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
#Este programa se encarga de mostrar el gráfico en tipo torta describiendo cantidades de accesos al sistema, al mes se mostrará el 100% por usuario
require_once('../../jpgraph/src/jpgraph.php');
require_once('../../jpgraph/src/jpgraph_pie.php');
require_once('../../jpgraph/src/jpgraph_pie3d.php');
require_once("../../db/connect.php");//LLama a la conexión de base de datos
require_once("../../view/hora.php");
 if(isset($_GET["anio"]) && isset($_GET["mes"])){
 $sql=$dbh->prepare("SELECT sum( num ) AS total, username
                    FROM contadoraccesos
                    WHERE YEAR( fecha ) = ?
                    AND MONTH( fecha ) = ?
                    GROUP BY username
					order by total asc");
$sql->bindParam(1,$_GET["anio"]);//enlace al parámetro año
$sql->bindParam(2,$_GET["mes"]);// enlace al parámetro mes
$sql->execute();// ejecuta el query
$total=array();//define el arreglo de cantidades
$usuarios=array();//define el arreglo de usuarios
$fecha=getFecha();//función para imprimir la fecha actual del sistema
if($sql->rowCount()>0){
foreach($sql->fetchAll() as $row){//el arreglo recorrerá todos los registros para desplegar en el gráfico
$accesos=$row["total"];
	$usuarios[]=$row["username"]." ".$row["total"]." accesos";//recorrerá todos las filas del registro
	$total[]=$row["total"];//el arreglo recorre todas las filas del registro
	}
//Instancia a la clase piegraph	
$graph = new PieGraph(800,600);//define la dimensión de la imagen
$graph->SetShadow();
$theme_class=new VividTheme();
$graph->SetTheme($theme_class);
$graph->title->Set("Estadistica de accesos ". $_GET["mes"]." ".$_GET["anio"] );//Título del gráfico
$graph->title->SetFont(FF_FONT1,FS_BOLD);//define el texto fuente
$graph->subtitle->set("Fecha: ".$fecha);

$p1 = new PiePlot3D($total);//instancia a la clase pieplot3d mediante el parámetro $total correspondiente al arreglo de accesos
$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.5,0.55);//Posición del centro del gráfico
$p1->SetLegends($usuarios);//Mostrará la leyenda correspondiente a cada pieza del gráfico
$graph->legend->SetPos(0.2,0.2,'right','bottom');//definie la posición de los labels correspondientes a la leyenda del
//$p1->value->SetFormat("%d a");
$graph->Add($p1);
$graph->Stroke();
}else{
	echo "Ningún resultado encontrado";
	}
 }else{
	 header("location: ../../index.php");
	 }
}else{
	header("location: ../../index.php");
	}
?>
<?php session_start();?>
<?php 
if(isset($_SESSION["username"])){
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando la cantidad de accesos de usuarios
#al mes
if(isset($_GET["anio"]) && isset($_GET["mes"])){
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php"); 
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$sql=$dbh->prepare("SELECT sum( num ) AS total, username
                    FROM contadoraccesos
                    WHERE YEAR( fecha ) = ?
                    AND MONTH( fecha ) = ?
                    GROUP BY username");
$sql->bindParam(1,$_GET["anio"]);//enlace al parámetro año
$sql->bindParam(2,$_GET["mes"]);// enlace al parámetro mes
$sql->execute();// ejecuta el query

$usuarios=array(); //array de datos de usuario
$total=array(); //array de datos de nro de accesos
//arreglo para recorrer todas las filas del registro recuperado
foreach($sql->fetchAll() as $row){
   $total[]=$row['total']; //el array almacena el total de accesos
   $usuarios[]=$row['username'];//el array almacena los usuarios
}
$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(700, 600, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set("Reporte de accesos de usuario Anio.".$_GET["anio"]."-Mes.".$_GET["mes"]);
$grafico->subsubtitle->Set("Fecha ".$fecha,0,1);//Muestra la fecha y hora actual
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Usuarios");//establece el eje x
$grafico->xaxis->SetTickLabels($usuarios);// carga el registro de usuarios
$grafico->yaxis->title->Set("Total de accesos al mes");//setea el eje y
$barplot1 =new BarPlot($total);//carga el total de accesos
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("#00CC00", "#B3AEF6", GRAD_VER);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);//dibuja el gráfico
$grafico->Stroke();//despliega el gráfico

$grafico->Stroke(_IMG_HANDLER);//genera la imagen

$fileName = "grafica1.png";//define el nombre del archivo para la imagen
$grafico->img->Stream($fileName);//genera la imagen

// envía al navegador
$grafico->img->Headers();
$grafico->img->Stream();
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
}else{
	header("location: ../../index.php");
	}
}else{
	header("location: ../../index.php");
	}
?>


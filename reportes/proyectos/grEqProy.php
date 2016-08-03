<?php 
#Este programa se encarga de realizar el despliegue de un reporte gráfico mostrando la diferencia de duraciones de un proyecto
try{
 require_once ('../../jpgraph/src/jpgraph.php');#Llama a los archivos requreidos para realizar el gráfico
 require_once ('../../jpgraph/src/jpgraph_bar.php');
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de hora
 //consulta PDO que solicita el número de accesos por usuario en base al mes y año
$idproyecto=$_GET["idproyecto"];
$proyecto=$_GET["proyecto"];
$idequipamiento=$_GET["equipamiento"];
$consulta=$dbh->prepare("select descripcion,unidad from maquinaria where IDmaquinaria=?");
$consulta->bindParam(1,$idequipamiento);
$consulta->execute();
if($consulta->rowCount()>0){
$res=$consulta->fetch();
$equipamiento=$res[0];
$unidad=$res[1];
$sql=$dbh->prepare("SELECT sum(cantidad_usada) as cantidad_usada, concat(month(fecha),'/',year(fecha)) AS mes
FROM maquinaria AS m, informemaquinaria AS im, actividad AS a, subfase AS sf, fase AS f, proyecto AS p
WHERE m.IDmaquinaria = im.IDmaquinaria
AND im.IDactividad = a.IDactividad
AND a.IDsubfase = sf.IDsubfase
AND sf.IDfase = f.IDfase
AND f.IDproyecto = p.IDproyecto
AND p.IDproyecto = ?
AND m.IDmaquinaria = ?
group by mes
order by mes asc");
$sql->bindParam(1,$idproyecto);
$sql->bindParam(2,$idequipamiento);
$sql->execute();
$datos=array();
$mes=array();
foreach($sql->fetchall() as $row){
	$datos[]=$row['cantidad_usada'];
	$mes[]="Mes: ".$row['mes'];
	}

$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(700, 600, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set("Proyecto: ".$proyecto);
$grafico->subtitle->Set("Informe de uso equipamiento, fecha: ".$fecha);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Uso del equipamiento: ".$equipamiento);//establece el eje x
$grafico->xaxis->SetTickLabels($mes);//texto del cantidades actuales
$grafico->yaxis->title->Set("Valores de cantidad");//setea el eje y
#dibuja el grafico de al duracion
$barplot1 =new BarPlot($datos);//carga el arreglo de cantidades
// Establece el color gradiente
$barplot1->SetFillGradient("#1A3321", "#B3FAF6", GRAD_VER);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);//dibuja el gráfico
$grafico->Stroke();

}else{
	echo "La actividad no tiene material asignado";
	}
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>
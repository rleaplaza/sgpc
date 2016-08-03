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
$idmaterial=$_GET["material"];
$consulta=$dbh->prepare("select descripcion,unidad from material where IDmaterial=?");
$consulta->bindParam(1,$idmaterial);
$consulta->execute();
if($consulta->rowCount()>0){
$res=$consulta->fetch();
$material=$res[0];
$unidad=$res[1];
$sql=$dbh->prepare("select m.descripcion,sum(cant_solicitada) as cant_solicitada,sum(cantidad_utilizada) as cantidad_utilizada
                    from material m, actividad_material am, actividad a, subfase sf, fase f, proyecto p
                    where m.IDmaterial=am.IDmaterial
                    and am.IDactividad=a.IDactividad
                    and a.IDsubfase=sf.IDsubfase
                    and sf.IDfase=f.IDfase
                    and f.IDproyecto=p.IDproyecto
					and p.IDproyecto=?
					and m.IDmaterial=?
					group by m.descripcion");
$sql->bindParam(1,$idproyecto);
$sql->bindParam(2,$idmaterial);
$sql->execute();
$res=$sql->fetch();
$cant_solicitada=$res["cant_solicitada"];
$cant_utilizada=$res["cantidad_utilizada"];
$datos=array($cant_solicitada,$cant_utilizada);

$fecha=getFecha();
// Creamos el grafico
$grafico = new Graph(800, 700, 'auto'); 
$grafico->SetScale("textint");//Escala del texto
//Titulo del reporte gráfico
$grafico->title->Set("Proyecto: ".$proyecto);
$grafico->subtitle->Set("Informe de uso de materiales, fecha: ".$fecha);
$grafico->xaxis->title->set('');//Espacio de texto
$grafico->xaxis->title->Set("Uso del material ".$material);//establece el eje x
$grafico->xaxis->SetTickLabels(array("Cantidad programada ".$cant_solicitada." ".$unidad,"Cantidad usada ".$cant_utilizada." ".$unidad));//texto del cantidades actuales
$grafico->yaxis->title->Set("Valores en unidad de ".$unidad);//setea el eje y
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
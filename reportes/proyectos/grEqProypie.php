<?php session_start();?>
<?php 
#Este programa se encarga de desplegar el gráfico de diferencias en duración del proyecto
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de fecha y hora
 #recuperación de las variables de actividad y material
 try{
	 if(isset($_SESSION["username"])){
$idproyecto=$_GET["idproyecto"];
$proyecto=$_GET["proyecto"];
$idequipamiento=$_GET["equipamiento"];
#consulta la información requerida para el material
$consulta=$dbh->prepare("select descripcion,unidad from maquinaria where IDmaquinaria=?");
$consulta->bindParam(1,$idequipamiento);
$consulta->execute();
$res=$consulta->fetch();
$equipamiento=$res[0];
$unidad=$res[1];
#consulta las cantidades solicitada y la utilizada para porcentajes
$sql=$dbh->prepare("select m.descripcion, m.unidad, sum(cant_asignada) as cant_asignada,sum(cantidad_usada) as cantidad_usada
                    from maquinaria m, actividad_maquinaria am, actividad a, subfase sf, fase f, proyecto p
                    where m.IDmaquinaria=am.IDmaquinaria
                    and am.IDactividad=a.IDactividad
                    and a.IDsubfase=sf.IDsubfase
                    and sf.IDfase=f.IDfase
                    and f.IDproyecto=p.IDproyecto
					and p.IDproyecto=?
					and m.IDmaquinaria=?");
$sql->bindParam(1,$idproyecto);
$sql->bindParam(2,$idequipamiento);
$sql->execute();
$res=$sql->fetch();
$cant_asignada=$res["cant_asignada"];
$cant_usada=$res["cantidad_usada"];
$diferencia=$cant_asignada-$cant_usada;
$datos=array($diferencia,$cant_usada);
$fecha=getFecha();
$graph = new PieGraph(700,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new OrangeTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Uso de equipamiento ".$equipamiento." ".$cant_asignada);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Proyecto: ".$proyecto." ,Fecha: ".$fecha);//imprime la fecha y hora del sistema
 
$p1 = new PiePlot3D($datos);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.45);//Posición del centro del gráfico
$p1->SetLegends(array("Cantidad sin usar: ".$diferencia,"Cantidad usada: ".$cant_usada));//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.2,0.1,'left','botton');//Setea la posición de los labels correspondientes a la leyenda del gráfico
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
	 }else{
		 header("location: ../../index.php");
		 }
 }catch(PDOExeption $e){
	 echo "Error inesperado".$e->getMessage();
	 }
?>
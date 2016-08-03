<?php
require_once('../fpdf/fpdf.php');//llama a la clase pdf
require_once("../../db/connect.php");//llama a la conexion
class PDF extends FPDF //definición de la clase pdf heradad de FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Ancho de columnas
	$this->widths=$w;
}

function SetAligns($a)
{
	//Alineación de columnas
	$this->aligns=$a;
}

function Row($data)
{
	//Calcula la altura de las filas
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Dibujo de las celdas
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
		//Guarda la posición actual
		$x=$this->GetX();
		$y=$this->GetY();
		//Dibuja los bordes
		
		$this->Rect($x,$y,$w,$h);

		$this->MultiCell($w,5,$data[$i],0,$a,'true');
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Salto de l;inea
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	// Crea una nueva pagina en caso de desbordamiento de la tabla
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Calcula el nro de lineas de las celdas
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

function Header()#define la cabecera del reporte
{

	$this->SetFont('Arial','',10);
	$this->Text(20,14,'Informe de avances por trabajador',0,'C', 0);
	$this->Ln(30);
	$this->SetFont('Arial','',8);
}

function Footer()#define el pie del reporte
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',8);
	$this->Cell(100,10,'Informe de avance por trabajador',0,0,'L');

}

}  #captura de variables de la URL
    $idactividad=$_GET["idactividad"];
	$ci=$_GET["ci"];
	$cargo=$_GET["cargo"];
	$nombre=$_GET["nombre"];
	$avance=$_GET["avance"];
	$user=$_GET["user"];
	#instancia a la clase PDF para generar el reporte
	$pdf=new PDF('L','mm','Letter');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(20,20,20);
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(90);
	$pdf->Cell(19,20,'Informe de avance de actividades');
	$pdf->Image('../../images/logo.jpg' , 20 ,22, 80 , 30,'jpg', '');
	$pdf->Ln(15);
	#consulta PDO para mostrar la fecha de impresión
	$consulta=$dbh->prepare("select curtime()");
	$consulta->execute();
	$res=$consulta->fetch();
	$hora=$res[0];
	#Define los textos que serán vistos en el reporte con la fuente, color de texto
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(10,21,137);
	$pdf->Cell(0,9,'USUARIO: '.strtoupper($user),0,1);
	$pdf->Cell(0,9,'FECHA: '.date('d/m/y')." ".$hora,0,1);
	$pdf->Cell(0,9,'TRABAJADOR: '.$nombre,0,1);
	$pdf->Cell(0,9,'CARGO: '.$cargo,0,1);
	#Consulta PDO para visualizar los datos relevantes de la actividad
	$query=$dbh->prepare("select nombreActividad,cantidad,unidades from actividad where IDactividad=?");
	$query->bindParam(1,$idactividad);//enlaza al id de la actividad
	$query->execute();
	$result=$query->fetch();
	#el resultado del arreglo será almacenado en variables
	$actividad=$result[0];
	$cantidad=$result[1];
	$unidades=$result[2];
	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(10,21,137);
	$pdf->Cell(0,9,'ACTIVIDAD: '.utf8_decode($actividad),0,1);
	$pdf->Cell(0,9,'CANTIDAD PROGRAMADA: '.$cantidad." ".$unidades,0,1);
	$pdf->Cell(0,9,'AVANCE ACUMULADO: '.$avance." ".$unidades,0,1);
	#Define los anchos de cada columna en el arreglo 
	$pdf->SetWidths(array(50,60));
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(93,94,102);
    $pdf->SetTextColor(255);
    #arreglo que recorrerá los registros 
		for($i=0;$i<1;$i++)
			{
				$pdf->Row(array('FECHA DE AVANCE','AVANCE INFORMADO'));
			}	
	$sql=$dbh->prepare("select unidad_trabajo,total_horas,unidad_avance,avance_informado,fechaAvance,i.hraRegistro
                        from actividad as a, informetrabajador as i
                        where a.IDactividad=i.IDactividad
                        and CI_trabajador=?
						and a.IDactividad=?
						order by fechaAvance desc");
	$sql->bindParam(1,$ci);
	$sql->bindParam(2,$idactividad);
	$sql->execute();
	$numfilas = $sql->rowCount();//cuenta las filas para recorrer el arreglo
	for ($i=0; $i<$numfilas; $i++)
		{
			$row = $sql->fetch();
			$pdf->SetFont('Arial','',10);
			
			if($i%2 == 1)#Define el color de las celdas para diferenciar filas pares de impares
			{
				$pdf->SetFillColor(240,45,45);
    			$pdf->SetTextColor(0);
				$pdf->Row(array($row[4],$row[3]." ".$row[2]));
			}
			else
			{
				$pdf->SetFillColor(187,195,218);
    			$pdf->SetTextColor(0);
	            $pdf->Row(array($row[4],$row[3]." ".$row[2]));
			}
		}

$pdf->Output('archivos/informeAvance.pdf','D');
?>
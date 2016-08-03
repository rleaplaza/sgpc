<?php
require_once('../fpdf/fpdf.php');
require_once("../../db/connect.php");
class PDF extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		
		$this->Rect($x,$y,$w,$h);

		$this->MultiCell($w,5,$data[$i],0,$a,'true');
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
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
	$this->Text(20,14,'Informe de material usado',0,'C', 0);
	$this->Ln(30);
	$this->SetFont('Arial','',8);
}

function Footer()#deine el pie del reporte
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',8);
	$this->Cell(100,10,'Informe de consumo de material',0,0,'L');

}

}
    $idactividad=$_GET["idactividad"];
	$idmaterial=$_GET["idmaterial"];
	$material=$_GET["descripcion"];
	$cantAsignada=$_GET["cantAsignada"];
	$cantUsada=$_GET["cantUsada"];
	$unidad=$_GET["unidad"];
	$idproyecto=$_GET["idproyecto"];
	$user=$_GET["user"];
	#instancia a la clase PDF para generar el reporte
	$pdf=new PDF('L','mm','Letter');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(20,20,20);
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(90);
	$pdf->Cell(19,20,'Informe de cantidad usada de material');
	$pdf->Image('../../images/logo.jpg' , 20 ,22, 80 , 30,'jpg', '');
	$pdf->Ln(15);
	
	#consulta para capturar la hora del sistema
	$consulta=$dbh->prepare("select curdate(), curtime()");
	$consulta->execute();
	$res=$consulta->fetch();
	$hora=$res[1];
	$fecha=$res[0];
	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(10,21,137);
	$pdf->Cell(0,9,'USUARIO: '.strtoupper($user),0,1);
	$pdf->Cell(0,9,'FECHA: '.$fecha." ".$hora,0,1);
	$pdf->Cell(0,9,'MATERIAL: '.$material,0,1);
	$pdf->Cell(0,9,'CANTIDAD ASIGNADA: '.$cantAsignada." ".$unidad,0,1);
	$pdf->Cell(0,9,'CANTIDAD UTILIZADA: '.$cantUsada." ".$unidad,0,1);
	
	$query=$dbh->prepare("select nombreActividad,cantidad,unidades from actividad where IDactividad=?");
	$query->bindParam(1,$idactividad);
	$query->execute();
	$result=$query->fetch();
	$actividad=$result[0];
	$cantidad=$result[1];
	$unidades=$result[2];
	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(10,21,137);
	$pdf->Cell(0,9,'ACTIVIDAD: '.utf8_decode($actividad),0,1);
	
	$pdf->SetWidths(array(40, 50));
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(93,94,102);
    $pdf->SetTextColor(255);

		for($i=0;$i<1;$i++)
			{ #arreglo que desplegará los nombres de las columnas
				$pdf->Row(array('FECHA DE REGISTRO','CANTIDAD USADA'));
			}	#consulta PDO para recuperar el informe de utilidad de material
	$sql=$dbh->prepare("SELECT fechaRegistro, unidad, cantidad_usada
                        FROM material AS mat, actividad AS a, informematerial AS im
                        WHERE a.IDactividad = im.IDactividad
                        AND im.IDmaterial = mat.IDmaterial
						and mat.IDmaterial=?
						and a.IDactividad=?
						order by im.fechaRegistro desc");
	$sql->bindParam(1,$idmaterial);
	$sql->bindParam(2,$idactividad);
	$sql->execute();
	$numfilas = $sql->rowCount();
	for ($i=0; $i<$numfilas; $i++)
		{
			$row = $sql->fetch();
			$pdf->SetFont('Arial','',10);
			
			if($i%2 == 1)
			{
				$pdf->SetFillColor(240,45,45);
    			$pdf->SetTextColor(0);
				$pdf->Row(array($row[0],$row[2]." ".$row[1]));//Despliega los registros requeridos
			}
			else
			{
				$pdf->SetFillColor(187,195,218);
    			$pdf->SetTextColor(0);
	            $pdf->Row(array($row[0],$row[2]." ".$row[1]));//la columna $row repite el valor para mostrar la cantidad acumulada de material
			}
		}

$pdf->Output('archivos/informeMaterial.pdf','D');
?>
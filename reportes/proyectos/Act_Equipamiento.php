<?php
require_once('../fpdf/fpdf.php');
require_once("../../db/connect.php");
require_once("getFase.php");
require_once("getsubfase.php");
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

function Header()
{

	$this->SetFont('Arial','',10);
	$this->Text(20,14,'Actividades sin equipamiento',0,'C', 0);
	$this->Ln(30);
	$this->SetFont('Arial','',8);
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',8);
	$this->Cell(100,10,'Actividades sin equipamiento',0,0,'L');

}

}
    $idfase=$_POST["fase"];
	$idsubfase=$_POST["subfase"];
	$fase=getFase($idfase);
	$subfase=getsubfase($idsubfase);
	$user=$_POST["user"];
	$pdf=new PDF('L','mm','Letter');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(20,20,20);
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(90);
	$pdf->Cell(19,30,'Informe de actividades sin equipamiento asignado');
	$pdf->Image('../../images/logo.jpg' , 20 ,22, 70 , 30,'jpg', '');
	$pdf->Ln(20);
	
	$consulta=$dbh->prepare("select curtime()");
	$consulta->execute();
	$res=$consulta->fetch();
	$hora=$res[0];
	
	$pdf->SetFont('Arial','B',14);
	$pdf->SetTextColor(10,21,137);
	$pdf->Cell(0,9,'USUARIO: '.strtoupper($user),0,1);
	$pdf->Cell(0,9,'FECHA: '.date('d/m/y')." ".$hora,0,1);
	$pdf->Cell(0,9,'FASE: '.strtoupper($fase),0,1);
	$pdf->Cell(0,9,'SUBFASE: '.strtoupper($subfase),0,1);
    $pdf->SetWidths(array(100, 50, 23, 40,40));
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(93,94,102);
    $pdf->SetTextColor(255);

		for($i=0;$i<1;$i++)
			{
				$pdf->Row(array('ACTIVIDAD', 'UNIDADES','CANTIDAD', 'INICIO','FIN'));
			}	
	$sql=$dbh->prepare("SELECT nombreActividad, unidades, cantidad, fechaRealizacion, fechaFin
                        FROM fase AS f, subfase AS sf, actividad AS a, propiedadactividad AS pa
                        WHERE f.IDfase = sf.IDfase
                        AND sf.IDsubfase = a.IDsubfase
                        AND a.IDactividad = pa.IDactividad
						and sf.IDsubfase=?
                        AND equipo_asignado = 'no'");
	$sql->bindParam(1,$idsubfase);
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
				$pdf->Row(array(utf8_encode($row[0]), $row[1],$row[2], $row[3],$row[4]));
			}
			else
			{
				$pdf->SetFillColor(187,195,218);
    			$pdf->SetTextColor(0);
	          	$pdf->Row(array(utf8_encode($row[0]), $row[1],$row[2], $row[3],$row[4]));
			}
		}

$pdf->Output('archivos/ActividadSinEquipamiento.pdf','D');
?>
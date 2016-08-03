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

function Header()
{

	$this->SetFont('Arial','',10);
	$this->Text(20,13,'Requerimiento de Materiales',0,'C', 0);
	$this->Ln(30);
	$this->SetFont('Arial','',8);
}

function Footer()
{
	$this->SetY(-15);
	$this->SetFont('Arial','B',8);
	$this->Cell(100,10,'Requerimiento de materiales',0,0,'L');

}

}
	$numero=$_GET["nro"];
	$user=$_GET["user"];
	$idproyecto=$_GET["idproyecto"];
	$sql=$dbh->prepare("select nombres, app, apm from empleado as e, usuario as u
	                    where e.CI=u.CI
						and u.username=?");
	$sql->bindParam(1,$user);
	$sql->execute();
	$row=$sql->fetch();
	$empleado=$row["nombres"]." ".$row["app"]." ".$row["apm"];
	$consulta=$dbh->prepare("select nombre from proyecto, req_material
	                         where proyecto.IDproyecto=req_material.IDproyecto
							 and proyecto.IDproyecto=?");
	$consulta->bindParam(1,$idproyecto);
	$consulta->execute();
	$row=$consulta->fetch();
	$proyecto=$row[0];
	$pdf=new PDF('L','mm','Letter');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetMargins(20,20,20);
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(90);
	$pdf->Cell(19,20,'Requerimiento de materiales');
	$pdf->Image('../../images/logo.jpg' , 20 ,22, 70 , 30,'jpg', '');
	$pdf->Ln(20);
	
	$pdf->SetFont('Arial','B',14);
	$pdf->SetTextColor(10,21,137);
	$pdf->Cell(10,9,'NRO: '.$numero,0,1);
	$pdf->Cell(10,9,'SOLICITADO POR: '.$empleado,0,1);
	$pdf->Cell(10,9,'PROYECTO: '.$proyecto,0,1);
	$pdf->Cell(10,9,'USUARIO: '.strtoupper($user),0,1);
	$consulta=$dbh->prepare("select curtime()");
	$consulta->execute();
	$res=$consulta->fetch();
	$hora=$res[0];
	$pdf->Cell(10,9,'FECHA: '.date('d/m/y')." ".$hora,0,1);
	
    $pdf->SetWidths(array(20,70, 25, 30));
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(93,94,102);
    $pdf->SetTextColor(255);

		for($i=0;$i<1;$i++)
			{
				$pdf->Row(array('NRO','DESCRIPCION', 'CANTIDAD', 'UNIDAD'));
			}	
	$sql=$dbh->prepare("select m.descripcion, dr.cantidad, dr.unidad 
	                    from material as m, det_req_material as dr, req_material as req
						where m.IDmaterial=dr.IDmaterial
						and dr.nro_requerimiento=req.nro_requerimiento
						and req.nro_requerimiento=?
						order by m.descripcion");
	$sql->bindParam(1,$numero);
	$sql->execute();
	$numfilas = $sql->rowCount();
	$c=0;
	for ($i=0; $i<$numfilas; $i++)
		{ 
		$c++;
			$row = $sql->fetch();
			$pdf->SetFont('Arial','',10);
			
			if($i%2 == 1)
			{
				$pdf->SetFillColor(240,45,45);
    			$pdf->SetTextColor(0);
				$pdf->Row(array($c,$row[0], $row[1], $row[2]));
			}
			else
			{
				$pdf->SetFillColor(187,195,218);
    			$pdf->SetTextColor(0);
			    $pdf->Row(array($c,$row[0], $row[1], $row[2]));
			}
		}

$pdf->Output('archivos/requerimientoMaterial.pdf','D');
?>
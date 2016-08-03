<?php
require_once('../fpdf/fpdf.php');
require_once("../../db/connect.php");
#Este programa se encarga de generar el informe pdf correpondient al log de auditoría, se utilizó un demo para generar el documento
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
//función para la cabecera del informe como la fuente, texto y posición de línea
	$this->SetFont('Arial','',10);
	$this->Text(20,14,'Log de auditoria',0,'C', 0);
	$this->Ln(30);
}

function Footer()
{//función para el pie del informe
	$this->SetY(-15);//establece la posición Y
	$this->SetFont('Arial','B',8);//fuente del texto
	$this->Cell(100,10,'Log de auditoria',0,0,'L');//celda para imprimir el mensaje

}

}
		//intancia a la clase PDF
	$pdf=new PDF('L','mm','Letter');//tamaño carta para el informe
	$pdf->Open();//método open para iniciar la generación del archivo
	$pdf->AddPage();//agrega a la página
	$pdf->SetMargins(20,20,20);//define los márgenes
	$pdf->SetFont('Arial','B',20);//fuente del informe
	$pdf->Cell(90);//posición de la celda
	$pdf->Cell(19,20,'Informe de log de auditoria ');//título del informe
	$pdf->Image('../../images/logo.jpg' , 20 ,22, 125 , 25,'jpg', '');//adjunta la imagen del logo de la empresa
	$pdf->Ln(20);//posición de la imagen
	#consulta para recuperar la hora actual del sistema
	$consulta=$dbh->prepare("select curtime()");
	$consulta->execute();
	$res=$consulta->fetch();
	$hora=$res[0];//devuelve el resultado
	$user=$_GET["user"];
	$pdf->SetFont('Arial','B',14);
	$pdf->SetTextColor(10,21,137);
	$pdf->Cell(0,9,'USUARIO: '.strtoupper($user),0,1);
	$pdf->Cell(0,9,'FECHA: '.date('d/m/y')." ".$hora,0,1);//imprime la fecha y hora actual
	
		$pdf->SetWidths(array(23, 40, 25, 20,25,60,45));//defini los anchos de las columnas para el informe
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(93,94,102);//color de las celdas
    $pdf->SetTextColor(255);//color de texto

		for($i=0;$i<1;$i++)//arreglo que recorrerá los textos de cabecera
			{
				$pdf->Row(array('USERNAME','FECHA DE INGRESO','IP TERMINAL','MENU','SUBMENU','OPCION','NAVEGADOR'));
			}	
			#consulta PDO del log de auditoría
	$sql=$dbh->prepare("select *from auditoria order by username");
	$sql->execute();
	$numfilas = $sql->rowCount();//cantidad de filas
	
	for ($i=0; $i<$numfilas; $i++)
		{//El arreglo recorrerá todas las filas del registro en cuestión
			$row = $sql->fetch();
			$pdf->SetFont('Arial','',10);
			
			if($i%2 == 1)//establece colores de celdas para posiciones impares
			{
				$pdf->SetFillColor(240,45,45);//color de las celdas
    			$pdf->SetTextColor(0);//color de texto
    			#imprime los registros de cada campo dentro del arrelo
				$pdf->Row(array($row['username'], $row['fecha_ingreso']." ".$row['hra_ingreso'],$row['IPterminal'],strtolower($row['Menu']),strtolower($row['Submenu']),strtolower($row['Opcion']),$row['navegador_web']));
			}
			else
			{ //color de celdas para posiciones pares
				$pdf->SetFillColor(187,195,218);
    			$pdf->SetTextColor(0);
				$pdf->Row(array($row['username'], $row['fecha_ingreso']." ".$row['hra_ingreso'],$row['IPterminal'],strtolower($row['Menu']),strtolower($row['Submenu']),strtolower($row['Opcion']),$row['navegador_web']));
			}
		}

$pdf->Output('archivos/reporteAuditoria.pdf','D');//método output para imprimir y generar el informe en formato pdf
?>
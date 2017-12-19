<?php
//pdf Asignacion de Componentes
require_once("conexionsql.php");
require_once("fpdf.php");

class PDF_MC_Table extends FPDF {
var $widths;
var $aligns;


function SetWidths($w) {
    //Set the array of column widths
    $this->widths=$w;
}
function Row($data) {
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
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}
function CheckPageBreak($h) {
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}
function SetAligns($a) {
    //Set the array of column alignments
    $this->aligns=$a;
}
function NbLines($w,$txt) {
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
	//Cabecera de página
	function titulo($titulo="",$fecha="",$asignacion="") {
		$this->titulo=$titulo;
		$this->fecha=$fecha;
		$this->asignacion=$asignacion;
		
	}

	function Header() {
    	//Logo                  
    	$this->Image('../imagenes/mibam.jpg',10,8,30);
    	$this->Image('../imagenes/cvg.jpg',170,8,15);
    	$this->Image('../imagenes/venalum.jpg',186,8,14);

    	//Arial bold 15
    	$this->SetFont('Arial','B',14);
    	//Movernos a la derecha
    	$this->Cell(80);
    	//Título
    	$this->Cell(30,8,$this->titulo,0,0,'C');
    	$this->SetFont('Arial','B',10);
     	$this->Cell(-66,35,'PRUEBA',0,0,'R');
	   	$this->Cell(145,35,'FECHA_PRUEBA',0,0,'R');
     	//Salto de línea
    	$this->Ln(20);
	}
	function Footer() {
    	//Posición: a 1,5 cm del final
    	$this->SetY(-50);
    	//Arial italic 8
    	$this->SetFont('Arial','',9);
    	//Número de página
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,90,35);
        $this->Cell(65,5,'Entregado (Div. Centro Atención Usuarios)',0,0,'C');
    	$this->Ln(6);
        $this->Cell(32,5,'Nombre y Apellido:',0,0,'C');
    	$this->Ln(5);
        $this->Cell(23,5,'N° Personal:',0,0,'C');
    	$this->Ln(15);
        $this->Cell(15,5,'Fecha:',0,0,'C');
        $this->Cell(80,5,'Firma:',0,0,'C');
        
    	//Posición: a 1,5 cm del final
    	$this->SetY(-50);
    	//Arial italic 8
    	$this->SetFont('Arial','',9);
    	//Número de página
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x+90,$y,90,35);
        $this->Cell(220,5,'Recibido (Unidad Usuaria)',0,0,'C');
    	$this->Ln(6);
        $this->Cell(210,5,'Nombre y Apellido:',0,0,'C');
    	$this->Ln(5);
        $this->Cell(201,5,'N° Personal:',0,0,'C');
    	$this->Ln(15);
        $this->Cell(193,5,'Fecha:',0,0,'C');
        $this->Cell(-100,5,'Firma:',0,0,'C');
	}
    //Cabeceras
	function tituloTabla($tituloTabla) {
	    //Arial 12
	    //Color de fondo
	    $this->SetFillColor(255,255,128);
	    //Título
	    $this->Cell(0,4,"$tituloTabla",0,1,'L',1);

	}

}



$pdf=new PDF_MC_Table();
$pdf->titulo('ASIGNACION DE COMPONENTES',"03/01/2006",$asignacion);
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
conectarMysql();
$pdf->tituloTabla('DATOS DEL USUARIO');
$pdf->SetWidths(array(30,70,60,30));
$pdf->SetFont('Arial','B',10);
$pdf->Row(array('FICHA','NOMBRE Y APELLIDO','CARGO','EXTENSION'));
$pdf->SetFont('Arial','',7);
$pdf->Row(array('nombre dfsdf sdfsdfs f sdfsdfsf sdfsfs sdfsdf','NOMBRE Y APELLIDO','CARGO','EXTENSION'));
$pdf->Row(array('FICHA','NOMBRE Y APELLIDO','CARGO','EXTENSION'));
$resultAsignacion=mysql_query($consultaAsignacion);
$pdf->SetFont('Arial','',8);
$pdf->Ln(4);

/*$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('DATOS DE UBICACION');
$pdf->SetWidths(array(50,50,50,40));
$pdf->SetFont('Arial','B',8);
$pdf->Row(array('GERENCIA','DIVISION','DEPARTAMENTO','UBICACION'));
$pdf->SetFont('Arial','',8);
$pdf->Ln(4);


$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('DATOS DEL EQUIPO');
$pdf->SetWidths(array(50,50,50,40));
$pdf->SetFont('Arial','B',8);
$pdf->Row(array('CONFIGURACION','DESCRIPCION','MARCA / MODELO','SERIAL'));
$pdf->SetFont('Arial','',8);
$modelo=$rowAsignacion[20].' / '.$rowAsignacion[22];
$pdf->Ln(4);

$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('DATOS DE LOS COMPONENTES ASIGNADOS');
$pdf->SetWidths(array(40,40,50,60));

$pdf->SetFont('Arial','',8);
$result=mysql_query($consultaComponentesAsignacion);
$pdf->SetFont('Arial','B',8);
$pdf->Row(array('DESCRIPCION','MARCA','MODELO','SERIAL'));
$pdf->SetFont('Arial','',8);
$pdf->Ln(4);

$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('DATOS DE LOS COMPONENTES REEMPLAZADOS');
$result=mysql_query($consultaComponentesReemplazados);
$pdf->SetFont('Arial','B',8);
$pdf->Row(array('DESCRIPCION','MARCA','MODELO','SERIAL'));
$pdf->SetFont('Arial','',8);
$pdf->Ln(4);
*/
$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('OBSERVACIONES');
$pdf->SetFont('Arial','',8);
$pdf->SetWidths(array(190));
$pdf->SetFont('Arial','',16);
$pdf->Output();
?>

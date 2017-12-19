<?php
session_cache_limiter ( 'private' );	
session_save_path();
/*echo $gerencia;
echo $division;
echo $tipo;
echo $fechaI;
echo  $fechaF;*/



require_once("fpdf.php"); 

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

//Cabecera de página
function titulo($titulo="",$subtitulo="") {
		$this->titulo=$titulo;
		$this->subtitulo=$subtitulo;
}
function encabezado($encabezado="",$fecha="") {
		$this->encabezado=$encabezado;
		$this->fecha=$fecha;		
}


function Header() {
    	//Logo                  
    	$this->Image('../imagenes/mibam.jpg',10,8,30);
    	$this->Image('../imagenes/cvg.jpg',170,8,15);
    	$this->Image('../imagenes/venalum.jpg',186,8,14);

    	//Arial bold 15
    	$this->SetFont('Arial','B',10);
    	//Movernos a la derecha
    	$this->Cell(80);
    	//Título
    	$this->Cell(30,8,$this->titulo,0,0,'C');
		$this->Cell(-27,15,$this->subtitulo,0,0,'C');				
    	//Salto de línea    	
    	$this->SetFont('Arial','B',8);
    	$this->Cell(30,30,$this->encabezado,0,0,'C');		
    	$this->Cell(95,45,$this->fecha,0,0,'C');				
    	$this->Ln(26);
}

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

function Row($header,$data,$swiche)
{
//Colores, ancho de línea y fuente en negrita
if ($swiche==0){    	
    $this->SetFillColor(255,189,100);
    $this->SetTextColor(0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','B',7);
    //Cabecera  
    $tam=count($header);
    if ($tam==5){    	
	$w=array(40,40,45,30,25); 
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
   }
   else if ($tam==4){   	  
	$w=array(50,50,50,30); 
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
   }
   else{
   	$w=array(60,60,60); 
    for($i=0;$i<count($header);$i++)
       $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
   }
}	
    //Restauración de colores y fuentes
    //$this->SetFillColor(255,221,174);
    //$this->SetTextColor(0);
    //$this->SetFont('');
    //Datos
    //$this->SetFont('Arial','B',5);
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=7*$nb;
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
		$this->MultiCell($w,7,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function Footer() {	        	
    	//Posición: a 1,5 cm del final
    	$this->SetY(-15);
    	//Arial italic 8
    	$this->SetFont('Arial','I',8);
    	//Número de página
    	$this->Cell(0,10,'Pág. '.$this->PageNo().'',0,0,'C');
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
}

define('FPDF_FONTPATH','font/');
require_once("conexionsql.php");
conectarMysql();
if ($gerencia =='100' && $division=='100' && $tipo=='100'){
   $gerencia=""; $division=""; $tipo="";
   $consulta="select distinct requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO ,organizacion_procedimiento.ORGANIZACION_PROCEDIMIENTO , requerimiento_organizacion_procedimiento.ID_TIPO_ORG,
              tipo_organi_procedimiento.TIPO_ORG_PROCEDIMIENTO,sum(requerimiento_organizacion_procedimiento.cantidad) from requerimiento_organizacion_procedimiento
			  inner join division on requerimiento_organizacion_procedimiento.id_division=division.id_division
			  inner join gerencia on division.id_gerencia=gerencia.id_gerencia
			  inner join organizacion_procedimiento on requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO =organizacion_procedimiento.ID_ORG_PROCEDIMIENTO 
			  inner join tipo_organi_procedimiento on requerimiento_organizacion_procedimiento.ID_TIPO_ORG =tipo_organi_procedimiento.ID_TIPO_ORG 
			  WHERE gerencia.id_gerencia like ('%$gerencia') and division.id_division like ('%$division')
			  and requerimiento_organizacion_procedimiento.ID_TIPO_ORG  like ('%$tipo')
			  and requerimiento_organizacion_procedimiento.fecha_inicio between '$fechaI'
			  and '$fechaF'
			  group by requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO,requerimiento_organizacion_procedimiento.ID_TIPO_ORG order by organizacion_procedimiento.ORGANIZACION_PROCEDIMIENTO";       
$result=mysql_query($consulta);
$fecha=getdate();
$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];

$pdf=new PDF_MC_Table();
$pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
$pdf->encabezado('REQUERIMIENTO DE ORGANIZACIÓN Y PROCEDIMIENTO DE C.V.G VENALUM',"Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(60,60,60));
$header=array('ORGANIZACIÓN Y PROCEDIMIENTO','TIPO REQUERIMIENTO','CANTIDAD');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->Row($header,array($row[1],$row[3],$row[4]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
}
else{
$consulta="select gerencia.gerencia,gerencia.id_gerencia,division.division,requerimiento_organizacion_procedimiento.id_division,requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO,organizacion_procedimiento.ORGANIZACION_PROCEDIMIENTO,
	       requerimiento_organizacion_procedimiento.ID_TIPO_ORG,tipo_organi_procedimiento.TIPO_ORG_PROCEDIMIENTO,sum(requerimiento_organizacion_procedimiento.cantidad)
	       from requerimiento_organizacion_procedimiento
		   inner join division on requerimiento_organizacion_procedimiento.id_division=division.id_division
		   inner join gerencia on division.id_gerencia=gerencia.id_gerencia
		   inner join organizacion_procedimiento on requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO =organizacion_procedimiento.ID_ORG_PROCEDIMIENTO
		   inner join tipo_organi_procedimiento on requerimiento_organizacion_procedimiento. ID_TIPO_ORG =tipo_organi_procedimiento. ID_TIPO_ORG 
		   WHERE gerencia.id_gerencia like ('%$gerencia') and division.id_division like ('%$division') and 
		   requerimiento_organizacion_procedimiento.ID_TIPO_ORG like ('%$tipo') and requerimiento_organizacion_procedimiento.fecha_inicio between '$fechaI' and '$fechaF'";
if ($gerencia=="" && $division=="" && $tipo==""){		
	$agrupar="group by gerencia.gerencia,requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO,requerimiento_organizacion_procedimiento.ID_TIPO_ORG ORDER BY gerencia.gerencia,organizacion_procedimiento.ORGANIZACION_PROCEDIMIENTO";
	$consulta=$consulta.$agrupar;
	$result=mysql_query($consulta);
$fecha=getdate();
$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];

$pdf=new PDF_MC_Table();
$pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
$pdf->encabezado('REQUERIMIENTO DE ORGANIZACIÓN Y PROCEDIMIENTO POR GERENCIAS',"Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(50,50,50,30));
$header=array('GERENCIA','ORGANIZACIÓN Y PROCEDIMIENTO','TIPO REQUERIMIENTO','CANTIDAD');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->Row($header,array($row[0],$row[5],$row[7],$row[8]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
}
else{
	$agrupar="group by gerencia.gerencia,division.division,requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO,requerimiento_organizacion_procedimiento.ID_TIPO_ORG ORDER BY gerencia.gerencia";	
	$consulta=$consulta.$agrupar;
	$result=mysql_query($consulta);
$fecha=getdate();
$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];

$pdf=new PDF_MC_Table();
$pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
$pdf->encabezado('TOTAL REQUERIMIENTO DE ORGANIZACIÓN Y PROCEDIMIENTO POR DIVISIONES',"Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(40,40,45,30,25));
$header=array('GERENCIA','DIVISION','ORGANIZACIÓN Y PROCEDIMIENTO','TIPO REQUERIMIENTO','CANTIDAD');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->Row($header,array($row[0],$row[2],$row[5],$row[7],$row[8]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
}
}
$pdf->Output();
?> 
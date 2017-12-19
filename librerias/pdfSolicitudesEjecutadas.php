<?php
session_cache_limiter ( 'private' );	
session_start();
$consulta=$_SESSION[consulta];
//$consulta2=$_SESSION[consulta2];
//echo "<br>llamada: $consulta<br>";
require_once("fpdf.php"); 
if ($sitio==100) {	    
   //echo "sitio $sitio";
	$sitio="";
}
require('../librerias/fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

//Cabecera de página
function titulo($titulo="",$fecha="") {
		$this->titulo=$titulo;
		//$this->fecha=$fecha;
}

function Header() {
    	//Logo                  
    	$this->Image('../imagenes/mibam.jpg',10,8,30);
    	$this->Image('../imagenes/cvg.jpg',170,8,15);
    	$this->Image('../imagenes/venalum.jpg',186,8,14);

    	//Arial bold 15
    	$this->SetFont('Arial','B',6);
    	//Movernos a la derecha
    	$this->Cell(80);
    	//Título
    	$this->Cell(30,8,$this->titulo,0,0,'C');
		$this->Cell(-27,15,$this->fecha,0,0,'C');
    	//Salto de línea
    	$this->Ln(20);
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
	echo $swiche;
    $this->SetFillColor(255,189,100);
    $this->SetTextColor(0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','B',6);
    //Cabecera  
	$w=array(15,30,30,45,45); 
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],5,$header[$i],1,0,'C',1);
    $this->Ln();
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

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function Footer() {
    	//Posición: a 1,5 cm del final
    	$this->SetY(-15);
    	//Arial italic 8
    	$this->SetFont('Arial','I',8);
    	//Número de página
    	$this->Cell(0,10,'Pág. '.$this->PageNo().'/{nb}',0,0,'C');
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
//$consulta="SELECT sitio,id_solicitud,des_status,fecha_i,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,descripcion from usuario inner join solicitud_equipo on usuario.ficha=solicitud_equipo.ficha inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status inner join  descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion inner join sitio on ubicacion.id_sitio=sitio.id_sitio where (solicitud_equipo.fecha_i >= '$FechaI') AND (solicitud_equipo.fecha_i <= '$FechaF')";       
/*$consulta="SELECT sitio,id_solicitud,des_status,fecha_i,solicitud_equipo.ficha,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,extension,descripcion from usuario 
inner join solicitud_equipo on usuario.ficha=solicitud_equipo.ficha inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status 
inner join  descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion 
inner join sitio on ubicacion.id_sitio=sitio.id_sitio where (sitio.id_sitio LIKE '%$sitio') AND (solicitud_equipo.fecha_i >= '$fechaI') AND (solicitud_equipo.fecha_i <= '$fechaF')";*/
$result=mysql_query($consulta);
//$fecha=getdate();
//$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];

$pdf=new PDF_MC_Table();
$pdf->titulo('SOLICITUDES EJECUTADAS');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(15,30,30,45,45));
//Títulos de las columnas
$header=array('SOLICITUD','USUARIO','EQUIPO','GERENCIA','SITIO');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->Row($header,array($row[0],$row[1],$row[3],$row[4],$row[5]),$swiche);
	   $swiche=1;
}
$pdf->Output();
?> 
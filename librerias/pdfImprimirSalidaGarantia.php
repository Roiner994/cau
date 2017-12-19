<?php
session_cache_limiter ( 'private' );	
session_save_path();
//session_start();
//$valores=$_SESSION[metete];
//$valores=$_SESSION[metete];
//$consulta1=$_SESSION[consulta1];
//echo "metete coño e madre:$valores<br>"; 
//$arreglo=array("'\'"); 
//$valores=str_replace($arreglo,"",$valores);
//echo "valor nuevo:$valores"; 
//$consulta2=$_SESSION[consulta2];
//echo "<br>llamada: $consulta<br>";

//echo substr($valores, "'\'");
//$string=$valores;
//echo $string{0};echo"<br>";
//echo "largo de esta verga:";echo strlen($valores); 
$valores=str_replace("\\","",$valores);
//echo "esta la cadena final:$valores";

require_once("fpdf.php"); 
if ($sitio==100) {	    
   echo "sitio $sitio";
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
		$this->fecha=$fecha;
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
	$w=array(30,30,30,30,30,25); 
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
$consulta="SELECT inventario.id_inventario,inventario.ID_DESCRIPCION,DESCRIPCION,inventario.ID_MARCA, marca.MARCA, inventario.ID_MODELO,
	       concat(modelo.modelo,' ',cap_vel,' ',unidad)as MODELO,inventario.SERIAL,garantia.fecha_fuera_planta, proveedor.id_proveedor,
	       proveedor FROM garantia
	       inner join inventario on garantia.id_inventario=inventario.id_inventario
	       inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
	       inner join modelo on inventario.id_modelo=modelo.id_modelo
	       inner join marca on inventario.id_marca=marca.id_marca
	       inner join pedido on inventario.id_pedido=pedido.id_pedido
	       inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
	       where inventario.serial IN ($valores) order by proveedor";
require_once("conexionsql.php");
conectarMysql();
$result=mysql_query($consulta);
$pdf=new PDF_MC_Table();
$fecha=getdate();
$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
$pdf=new PDF_MC_Table();
$pdf->titulo('REPORTE DE COMPONENTES Y/0 EQUIPOS FUERA DE PLANTA',$fecha);
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(30,30,30,30,30,25));
$header=array('SERIAL','DESCRIPCION','MARCA','MODELO','PROVEEDOR','FECHA FUERA PLANTA');
$swiche=0;
while ($row=mysql_fetch_array($result)){ 
	   $fecha=substr($row[8],8,2).'/'.substr($row[8],5,2).'/'.substr($row[8],0,4); 	  	   	   
	   $pdf->Row($header,array($row[7],$row[2],$row[4],$row[6],$row[10],$fecha),$swiche);
	   $swiche=1;
}
$pdf->Output();
?> 
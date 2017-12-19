<?php
//migracion Planilla para el usuario
require_once("conexionsql.php");
require_once("fpdf.php");
class PDF_MC_Table extends FPDF {
var $widths;
var $aligns;
var $fechaInicial;
var $fechaFinal;
var $membrete;
var $tituloReporte;
var $orientacion;
var $nombreTabla;
var $data;
var $ficha;
var $usuario;
var $tecnico;
function SetWidths($w) {
    //Set the array of column widths
    $this->widths=$w;
}
function setOrientacion($o='F') {
$this->orientacion=$o;
}

function setUsuario($ficha="",$usuario="") {
	$this->ficha=$ficha;
	$this->usuario=$usuario;
}
function setTecnico($tecnico="") {
	$this->tecnico=$tecnico;
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
function RowColumnas($data) {
    $this->data=$data;
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
    if($this->GetY()+$h>$this->PageBreakTrigger) {
        $this->AddPage($this->CurOrientation);
        $this->SetFont('Arial','B',10);
        $this->tituloTabla($this->nombreTabla);
        $this->RowColumnas($this->data);
        $this->SetFont('Arial','',10);
    }
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
	function titulo($membrete="",$tituloReporte="") {
		$this->membrete=$membrete;
		$this->fechaInicial=$fechaInicial;
		
	}

	function Header() {
    	
    	//Logo                  
    	$this->Image('../imagenes/mibam.jpg',10,8,30);
    	$this->Image('../imagenes/cvg.jpg',170,8,15);
    	$this->Image('../imagenes/venalum.jpg',186,8,14);

    	//Arial bold 15
    	$this->SetFont('Arial','B',12);
    	//Movernos a la derecha
    	$this->Cell(50);
    	//Título
    	$this->Write(1,"INVENTARIO DE SOFTWARE Y APLICACIONES");
    	$this->Ln(5);
    	$this->Cell(58);
    	$this->Write(1,"PARA FORMULACIÓN DEL PROYECTO");
	   	$this->Ln(5);
    	$this->Cell(55);
    	$this->Write(1,"DE SOFTWARE LIBRE, SEGUN DECRETO");
    	$this->Ln(5);
    	$this->Cell(73);
    	$this->Write(1,"PRESIDENCIAL # 3390.");

    	$this->Ln(10);
	}
	function Footer() {
		$fecha=getdate();
		$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];

		
    	//Posición: a 1,5 cm del final
    	$this->SetY(-50);
    	//Arial italic 8
    	$this->SetFont('Arial','',9);
    	//Número de página
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,90,35);
        $this->Cell(1);
        $this->Write(5,'Entrevistador (Div. Centro Atención Usuarios)');
    	$this->Ln(6);
        $this->Cell(1);
        $this->Write(5,'Nombre y Apellido: '.$this->tecnico);
    	$this->Ln(5);
        $this->Cell(1);
        $this->Write(5,'N° Personal:');
    	$this->Ln(15);
        $this->Cell(1);
        $this->Write(5,'Fecha: '.$fecha.'       Firma:');    	
 
        //Posición: a 1,5 cm del final
    	$this->SetY(-50);
    	//Arial italic 8
    	$this->SetFont('Arial','',9);
    	//Número de página
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x+90,$y,90,35);
        $this->Cell(90);
        $this->Write(5,'Entrevistado (Unidad Usuaria)');
    	$this->Ln(6);
 	    $this->Cell(90);
        $this->Write(5,'Nombre y Apellido: '. $this->usuario);
 
    	$this->Ln(5);
 	    $this->Cell(90);
        $this->Write(5,'N° Personal: '.$this->ficha);    	
    	$this->Ln(15);
 	    $this->Cell(90);
        $this->Write(5,'Fecha: '.$fecha.'       Firma:');    	

	
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,10,'Pág '.$this->PageNo().'/{nb}',0,0,'C');
	}
    //Cabeceras
	function tituloTabla($tituloTabla) {
	    $this->nombreTabla=$tituloTabla;
		//Arial 12
	    //Color de fondo
	    $this->SetFillColor(255,255,255);
	    //Título
	    $this->Cell(0,4,"$tituloTabla",0,1,'L',1);

	}

}
require_once("usuarioAdmin.php");
require_once("migracionAdmin.php");

$usuario=new usuario($_GET[ficha]);
$resultado=$usuario->retornaUsuario();
if ($resultado!=1) {
	$row=mysql_fetch_array($resultado);
}


$software= new migracionSoftwareEquipo($_GET[configuracion]);
$resultadoSoftware=$software->buscarSoftwareUtilizado();
$resultadoUsistema=$software->retornaUsuarioSistema();
if ($resultadoUsistema && $resultadoUsistema!=1) {
	$rowUss=mysql_fetch_array($resultadoUsistema);
}
$pdf=new PDF_MC_Table();
$pdf->setUsuario($row[0],$row[2]);
$pdf->setTecnico($rowUss[3].' '.$rowUss[4]);
$pdf->Open();
$pdf->SetAutoPageBreak(1,51);
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
$pdf->tituloTabla('EQUIPO: '.strtoupper($_GET[configuracion]));
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->tituloTabla('USUARIO: '.$row[0].' - '.$row[2]);
$pdf->Ln(5);
$pdf->SetFont('Arial','BUI',12);

$pdf->tituloTabla('SOFTWARE Y APLICACIONES UTILIZADO POR EL USUARIO');

if ($resultadoSoftware!=1) {
	while ($row=mysql_fetch_array($resultadoSoftware)) {
		$pdf->ln(5);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(0);
		$pdf->Write(3,$row[3].' ('.$row[4].')');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(0);
		$pdf->Write(3,strtoupper($row[5]));
	}

}
$pdf->Output();

?>
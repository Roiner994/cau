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
	function titulo($titulo="",$subtitulo="") {
		$this->titulo=$titulo;
		$this->subtitulo=$subtitulo;
    }
	
	function encabezado($encabezado="",$gerencia="",$fecha="") {
		$this->encabezado=$encabezado;		
		$this->gerencia=$gerencia;		
		$this->fecha=$fecha;
    }
    
	function costoTotal($totales="",$bolivar=""){
		$this->totales=$totales;			
		$this->bolivar=$bolivar;	
	}

	function Header() {
    	//Logo                  
    	$this->Image('../imagenes/mibam.jpg',10,8,30);
    	$this->Image('../imagenes/cvg.jpg',170,8,15);
    	$this->Image('../imagenes/venalum.jpg',186,8,14);

    	//Arial bold 15
    	//Arial bold 15
    	$this->SetFont('Arial','B',10);
    	//Movernos a la derecha
    	$this->Cell(80);
    	//Título
    	$this->Cell(30,8,$this->titulo,0,0,'C');
		$this->Cell(-29,17,$this->subtitulo,0,0,'C');				
    	//Salto de línea   
    	$this->SetFont('Arial','B',10); 	
    	$this->Cell(30,45,$this->encabezado,0,0,'C');		
    	$this->SetFont('Arial','B',8); 
    	$this->Cell(-29,60,$this->gerencia,0,0,'C');		
    	$this->Cell(156,70,$this->fecha,0,0,'C');				
    	$this->Ln(38);
	}
	function Footer() {
    	
    	//Posición: a 1,5 cm del final
    	$this->SetY(-15);
    	//Arial italic 8
    	$this->SetFont('Arial','I',8);
    	//Número de página
    	$this->Cell(0,10,'Pág. '.$this->PageNo().'',0,0,'C');
    	$this->SetY(-40);
    	$this->SetFont('Arial','B',10);    	
    	//costo total    	         	
    	$this->Ln();  		
		//Posición: a 1,5 cm del final
    	$this->SetY(-50);
    	//Arial italic 8
    	$this->SetFont('Arial','',9);
    	//Número de página
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border

        
    	//Posición: a 1,5 cm del final
    	$this->SetY(-50);
    	//Arial italic 8
    	$this->SetFont('Arial','',9);
    	//Número de página
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
	}
    //Cabeceras
	function tituloTabla($tituloTabla) {
	    //Arial 12
	    //Color de fondo
	    $this->SetFillColor(255,189,100);
	    //Título
	    $this->Cell(0,4,"$tituloTabla",0,1,'L',1);

	}

}
conectarMysql();
$consultaGerencia="select id_gerencia,gerencia from gerencia where id_gerencia='$gerencia'";
$mostrarGerencia=mysql_query($consultaGerencia);
$results=mysql_fetch_array($mostrarGerencia);
$consultaHardware="Select
gerencia.ID_GERENCIA,
gerencia.GERENCIA,
descripcion.DESCRIPCION,
Sum(requerimiento_hardware.CANTIDAD) AS  CANTIDAD,
descripcion.COSTO_UNITARIO,
DESCRIPCION.COSTO_UNITARIO*REQUERIMIENTO_HARDWARE.CANTIDAD AS TOTAL
From
gerencia
Inner Join division ON division.ID_GERENCIA = gerencia.ID_GERENCIA
Inner Join requerimiento_hardware ON requerimiento_hardware.ID_DIVISION = division.ID_DIVISION
Inner Join descripcion ON requerimiento_hardware.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
Where
gerencia.ID_GERENCIA = '$gerencia'
Group By
descripcion.DESCRIPCION,
gerencia.ID_GERENCIA,
gerencia.GERENCIA,
descripcion.COSTO_UNITARIO
Order By
gerencia.GERENCIA Asc,
descripcion.DESCRIPCION Asc";

$consultaSoftware="SELECT gerencia.ID_GERENCIA, gerencia.GERENCIA, software.SOFTWARE, Sum(requerimiento_software.CANTIDAD) AS SumaDeCANTIDAD, software.COSTO_UNITARIO, requerimiento_software.cantidad*software.costo_unitario AS total
FROM ((division INNER JOIN gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA) INNER JOIN requerimiento_software ON division.ID_DIVISION = requerimiento_software.ID_DIVISION) INNER JOIN software ON requerimiento_software.ID_SOFTWARE = software.ID_SOFTWARE
Where
division.ID_GERENCIA = '$gerencia'
GROUP BY gerencia.ID_GERENCIA, gerencia.GERENCIA, software.SOFTWARE, software.COSTO_UNITARIO, requerimiento_software.cantidad*software.costo_unitario
ORDER BY gerencia.GERENCIA, software.SOFTWARE";

$consultaSistemas="SELECT gerencia.ID_GERENCIA, gerencia.GERENCIA, software.SOFTWARE, Sum(requerimiento_sistema_informacion.CANTIDAD) AS SumaDeCANTIDAD, software.COSTO_UNITARIO, requerimiento_sistema_informacion.cantidad*software.costo_unitario AS TOTAL
FROM ((gerencia INNER JOIN division ON gerencia.ID_GERENCIA = division.ID_GERENCIA) INNER JOIN requerimiento_sistema_informacion ON division.ID_DIVISION = requerimiento_sistema_informacion.ID_DIVISION) INNER JOIN software ON requerimiento_sistema_informacion.ID_SOFTWARE = software.ID_SOFTWARE
Where
gerencia.ID_GERENCIA = '$gerencia'
GROUP BY gerencia.ID_GERENCIA, gerencia.GERENCIA, software.SOFTWARE, software.COSTO_UNITARIO, requerimiento_sistema_informacion.cantidad*software.costo_unitario
ORDER BY gerencia.GERENCIA, software.SOFTWARE";

$consultaAplicaciones="SELECT gerencia.ID_GERENCIA, gerencia.GERENCIA, requerimiento_aplicaciones.REQUERIMIENTO_APLICACION, migracion.MIGRACION
FROM ((gerencia INNER JOIN division ON gerencia.ID_GERENCIA = division.ID_GERENCIA) INNER JOIN requerimiento_aplicaciones ON division.ID_DIVISION = requerimiento_aplicaciones.ID_DIVISION) INNER JOIN migracion ON requerimiento_aplicaciones.ID_MIGRACION = migracion.ID_MIGRACION
where gerencia.id_gerencia='$gerencia'
GROUP BY gerencia.ID_GERENCIA, gerencia.GERENCIA, requerimiento_aplicaciones.REQUERIMIENTO_APLICACION, migracion.MIGRACION
";
$consultaRedes="SELECT gerencia.ID_GERENCIA, gerencia.GERENCIA, redes.REDES, requerimiento_redes.CANTIDAD, Sum(redes.COSTO_UNITARIO) AS SumaDeCOSTO_UNITARIO, requerimiento_redes.cantidad*redes.costo_unitario AS TOTAL
FROM ((gerencia INNER JOIN division ON gerencia.ID_GERENCIA = division.ID_GERENCIA) INNER JOIN requerimiento_redes ON division.ID_DIVISION = requerimiento_redes.ID_DIVISION) INNER JOIN redes ON requerimiento_redes.ID_REDES = redes.ID_REDES
where gerencia.id_gerencia='$gerencia'
GROUP BY gerencia.ID_GERENCIA, gerencia.GERENCIA, redes.REDES, requerimiento_redes.CANTIDAD, requerimiento_redes.cantidad*redes.costo_unitario
ORDER BY gerencia.GERENCIA, redes.REDES";

$consultaOrganizacion="SELECT gerencia.ID_GERENCIA, gerencia.GERENCIA, tipo_organi_procedimiento.TIPO_ORG_PROCEDIMIENTO, organizacion_procedimiento.ORGANIZACION_PROCEDIMIENTO, Sum(requerimiento_organizacion_procedimiento.CANTIDAD) AS SumaDeCANTIDAD
FROM (((gerencia INNER JOIN division ON gerencia.ID_GERENCIA = division.ID_GERENCIA) INNER JOIN requerimiento_organizacion_procedimiento ON division.ID_DIVISION = requerimiento_organizacion_procedimiento.ID_DIVISION) INNER JOIN organizacion_procedimiento ON requerimiento_organizacion_procedimiento.ID_ORG_PROCEDIMIENTO = organizacion_procedimiento.ID_ORG_PROCEDIMIENTO) INNER JOIN tipo_organi_procedimiento ON requerimiento_organizacion_procedimiento.ID_TIPO_ORG = tipo_organi_procedimiento.ID_TIPO_ORG
where gerencia.id_gerencia='$gerencia'
GROUP BY gerencia.ID_GERENCIA, gerencia.GERENCIA, tipo_organi_procedimiento.TIPO_ORG_PROCEDIMIENTO, organizacion_procedimiento.ORGANIZACION_PROCEDIMIENTO";

$consultaObservacion="SELECT division.ID_GERENCIA, gerencia.GERENCIA, observacion_requerimiento.observacion
FROM (observacion_requerimiento INNER JOIN division ON observacion_requerimiento.id_division = division.ID_DIVISION) INNER JOIN gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
where gerencia.id_gerencia='$gerencia'";

conectarMysql();
$resultHardware=mysql_query($consultaHardware);
mysql_close();
	if ($resultHardware) {
		$row=mysql_fetch_array($resultHardware);
		$gerencia=$row[1];
	}
$fecha=getdate();
$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];

$pdf=new PDF_MC_Table();
$pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
$pdf->encabezado('DETECCIÓN DE NECESIDADES',$results[1],"Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AddPage();
conectarMysql();
$resultHardware=mysql_query($consultaHardware);
mysql_close();

if ($resultHardware && mysql_numrows($resultHardware)) {
	$pdf->SetFont('Arial','B',10);
	$pdf->tituloTabla('HARDWARE');
	$pdf->SetWidths(array(80,30,40,40));
	$pdf->SetFont('Arial','B',10);
	$pdf->Row(array('DESCRIPCION','CANTIDAD','COSTO UNITARIO ($)','COSTO TOTAL ($)'));
	$pdf->SetFont('Arial','',7);

	while ($row=mysql_fetch_array($resultHardware))	{
		$pdf->Row(array($row[2],$row[3],number_format($row[4],2,',','.'),number_format($row[3]*$row[4],2,',','.')));

	}
}
conectarMysql();
$resultSoftware=mysql_query($consultaSoftware);
mysql_close();
if ($resultSoftware && mysql_numrows($resultSoftware)) {
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',10);
	$pdf->tituloTabla('SOFTWARE');
	$pdf->SetWidths(array(80,30,40,40));
	$pdf->SetFont('Arial','B',10);
	$pdf->Row(array('DESCRIPCION','CANTIDAD','COSTO UNITARIO ($)',' COSTO TOTAL ($)'));
	$pdf->SetFont('Arial','',7);

	while ($row=mysql_fetch_array($resultSoftware))	{
		$pdf->Row(array($row[2],$row[3],number_format($row[4],2,',','.'),number_format($row[3]*$row[4],2,',','.')));

	}
}
conectarMysql();
$resultSistemas=mysql_query($consultaSistemas);
mysql_close();
if ($resultSistemas && mysql_numrows($resultSistemas)) {
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',10);
	$pdf->tituloTabla('SISTEMAS DE INFORMACION');
	$pdf->SetWidths(array(80,30,40,40));
	$pdf->SetFont('Arial','B',10);
	$pdf->Row(array('DESCRIPCION','CANTIDAD','COSTO UNITARIO ($)','COSTO TOTAL ($)'));
	$pdf->SetFont('Arial','',7);
	while ($row=mysql_fetch_array($resultSistemas))	{
		$pdf->Row(array($row[2],$row[3],number_format($row[4],2,',','.'),number_format($row[3]*$row[4],2,',','.')));

	}
}
conectarMysql();
$resultAplicaciones=mysql_query($consultaAplicaciones);
mysql_close();
if ($resultAplicaciones && mysql_numrows($resultAplicaciones)) {
$pdf->Ln(4);
$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('REQUERIMIENTOS DE APLICACIONES');
$pdf->SetWidths(array(95,95));
$pdf->SetFont('Arial','B',10);
$pdf->Row(array('APLICACION','MIGRACION'));
$pdf->SetFont('Arial','',7);
	while ($row=mysql_fetch_array($resultAplicaciones))	{
		$pdf->Row(array($row[2],$row[3]));

	}
}
conectarMysql();
$resultRedes=mysql_query($consultaRedes);
mysql_close();
if ($resultRedes && mysql_numrows($resultRedes)) {
$pdf->Ln(4);
$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('REQUERIMIENTO DE REDES');
$pdf->SetWidths(array(80,30,40,40));
$pdf->SetFont('Arial','B',10);
$pdf->Row(array('DESCRIPCION','CANTIDAD','COSTO UNITARIO ($)','COSTO TOTAL ($)'));
$pdf->SetFont('Arial','',7);
	while ($row=mysql_fetch_array($resultRedes))	{
		$pdf->Row(array($row[2],$row[3],number_format($row[4],2,',','.'),number_format($row[3]*$row[4],2,',','.')));

	}
}
conectarMysql();
$resultOrganizacion=mysql_query($consultaOrganizacion);
mysql_close();
if ($resultOrganizacion && mysql_numrows($resultOrganizacion)) {
$pdf->Ln(4);
$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('REQUERIMIENTO DE ORGANIZACION Y PROCEDIMIENTOS');
$pdf->SetWidths(array(80,80,30));
$pdf->SetFont('Arial','B',10);
$pdf->Row(array('REQUERIMIENTO','DESCRIPCION','CANITDAD'));
$pdf->SetFont('Arial','',7);
	while ($row=mysql_fetch_array($resultOrganizacion))	{
		$pdf->Row(array($row[2],$row[3],$row[4]));

	}
}

conectarMysql();
$resultObservacion=mysql_query($consultaObservacion);
mysql_close();
if ($resultObservacion && mysql_numrows($resultObservacion)) {
$pdf->Ln(4);
$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('OBSERVACION');
$pdf->SetWidths(array(190));
$pdf->SetFont('Arial','',7);
	$row=mysql_fetch_array($resultObservacion);	
	$pdf->Row(array($row[2]));
}


$pdf->SetFont('Arial','',8);
$pdf->Ln(4);

$pdf->Output();
?>

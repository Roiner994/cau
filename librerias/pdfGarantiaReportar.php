<?php
//pdf Asignacion de Componentes
require_once("conexionsql.php");
require_once("fpdf.php");

class PDF_MC_Table extends FPDF {
var $widths;
var $aligns;
var $titulo;

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
	function titulo($titulo="",$fecha="",$asignacion="",$subT="") {
		$this->titulo=$titulo;
		$this->fecha=$fecha;
		$this->asignacion=$asignacion;
		$this->subT=$subT;
	}

	function status() {
	require_once "conexionsql.php";
	require_once "conexionsql.php";
	$conStatus="select estatus_garantia from garantia_status where id_estatus_garantia='$status'";
	$status=$conStatus;
	}
	function Header() {
		$fecha=getdate();
		$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
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
    	//$this->Cell(30,8,$this->subT,0,0,'C');
    	$this->SetFont('Arial','B',10);
     	$this->Cell(-66,35,'',0,0,'R');
     	$this->Cell(90,20,'DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS',0,0,'R');
	   	$this->Cell(-3,35,'EQUIPOS Y COMPONENTES EN GARANTIA',0,0,'R');
	   	$this->Cell(55,55,'MATANZAS.'.'  '.$fecha,0,0,'R');
	   	//$pdf->Row(array('SERIAL','DESCRIPCION','MARCA','MODELO','FECHA'));
     	//Salto de línea
    	$this->Ln(30);
	}
	/*function Footer() {
    //Go to 1.5 cm from bottom
    $this->SetY(-15);
    //Select Arial italic 8
    $this->SetFont('Arial','I',8);
    //Print centered page number
    $this->Cell(0,10,'Pág. '.$this->PageNo(),0,0,'C');
	}*/
	function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Pág. '.$this->PageNo().'/{nb}',0,0,'C');
}
    //Cabeceras
	function tituloTabla($tituloTabla) {
	    //Arial 12
	    //Color de fondo
	    
	    $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
	    $this->Rect($x,$y,$w,$h);
	    $this->SetFillColor(255,189,100);

	    //Título
	    //////$pdf->AddPage();
	    $this->Cell(0,6,"$tituloTabla",0,1,'L',1);

	}

}

if ($status!="") {
require_once("conexionsql.php");
$consulta="SELECT garantia.id_garantia,garantia.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,marca.marca
, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo,
DESCRIPCION_PROPIEDAD.ID_DESCRIPCION_PROPIEDAD,garantia.id_garantia,
GARANTIA_ESTADO.FECHA_ASOCIACION,GARANTIA_STATUS.ESTATUS_GARANTIA,GARANTIA_ESTADO.ID_ESTATUS_GARANTIA
FROM garantia
inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
INNER JOIN GARANTIA_STATUS ON GARANTIA_ESTADO.ID_ESTATUS_GARANTIA=GARANTIA_STATUS.ID_ESTATUS_GARANTIA
inner join descripcion_propiedad on descripcion.id_descripcion_propiedad=descripcion_propiedad.id_descripcion_propiedad
where inventario.serial like '%' and proveedor.id_proveedor='$reporte'
and garantia_estado.id_estatus_garantia like '%$status' 
and GARANTIA_ESTADO.STATUS_ACTIVO='1'";

if (isset($fechaInicio) &&!empty($fechaInicio) && (isset($fechaFinal) &&!empty($fechaFinal))) {
	
$fechaInicio=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4);
$fechaFinal=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4);
$rangoFecha=" and  garantia_estado.fecha_asociacion between '$fechaInicio' and '$fechaFinal'";
	$consulta=$consulta.$rangoFecha;
}
require_once("conexionsql.php");
conectarMysql();
$result=mysql_query($consulta);
$row=mysql_fetch_array($result);

$pdf=new PDF_MC_Table();
$pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN ',"03/01/2006",'$asignacion');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
for($i=1;$i<=40;$i++)
conectarMysql();

$pdf->tituloTabla($row[5].'                                                                                                                '.' ESTATUS:'.$row[17]);
$pdf->SetWidths(array(40,40,40,40,30));
$pdf->SetFont('Arial','B',10);

$pdf->Row(array('SERIAL','DESCRIPCION','MARCA','MODELO','FECHA'));
$pdf->SetFont('Arial','',7);
$result=mysql_query($consulta);

while ($row=mysql_fetch_array($result)){ 
	  
	    $fecha=substr($row[16],8,2).'/'.substr($row[16],5,2).'/'.substr($row[16],0,4);
	    $pdf->Row(array($row[2],$row[7],$row[6],$row[8],$fecha));
	    
}

} else {
	require_once("conexionsql.php");
$consulta="SELECT garantia.id_garantia,garantia.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,marca.marca
, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo,
DESCRIPCION_PROPIEDAD.ID_DESCRIPCION_PROPIEDAD,garantia.id_garantia,
GARANTIA_ESTADO.FECHA_ASOCIACION,GARANTIA_STATUS.ESTATUS_GARANTIA,GARANTIA_ESTADO.ID_ESTATUS_GARANTIA
FROM garantia
inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
INNER JOIN GARANTIA_STATUS ON GARANTIA_ESTADO.ID_ESTATUS_GARANTIA=GARANTIA_STATUS.ID_ESTATUS_GARANTIA
inner join descripcion_propiedad on descripcion.id_descripcion_propiedad=descripcion_propiedad.id_descripcion_propiedad
where inventario.serial like '%' and proveedor.id_proveedor='$reporte'
and garantia_estado.id_estatus_garantia like '%$status' 
and GARANTIA_ESTADO.STATUS_ACTIVO='1'";

if (isset($fechaInicio) &&!empty($fechaInicio) && (isset($fechaFinal) &&!empty($fechaFinal))) {
	
$fechaInicio=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4);
$fechaFinal=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4);
$rangoFecha=" and  garantia_estado.fecha_asociacion between '$fechaInicio' and '$fechaFinal'";
	$consulta=$consulta.$rangoFecha;
}
require_once("conexionsql.php");
conectarMysql();
$result=mysql_query($consulta);
$row=mysql_fetch_array($result);
//$pdf=new PDF();
/*//Títulos de las columnas
$header=array('País','Capital','Superficie (km2)','Pobl. (en miles)');
//Carga de datos
$data=$pdf->LoadData('paises.txt');*/

$pdf=new PDF_MC_Table();
$pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN',"03/01/2006",$asignacion,$row[17]);

$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
for($i=1;$i<=40;$i++)
conectarMysql();

$pdf->tituloTabla($row[5]);
$pdf->SetWidths(array(30,30,40,40,20,30));
$pdf->SetFont('Arial','B',10);
$pdf->Row(array('SERIAL','DESCRIPCION','MARCA','MODELO','FECHA','ESTATUS'));
function PrintChapter($tituloTabla)
{
    //Añadir capítulo
$pdf->tituloTabla($row[5]);
$pdf->SetWidths(array(30,30,40,40,20,30));
$pdf->SetFont('Arial','B',10);
$pdf->Row(array('SERIAL','DESCRIPCION','MARCA','MODELO','FECHA','ESTATUS'));
    //$this->ChapterBody($file);
}
$pdf->SetFont('Arial','',7);
$result=mysql_query($consulta);

while ($row=mysql_fetch_array($result)){ 
	  
	    $fecha=substr($row[16],8,2).'/'.substr($row[16],5,2).'/'.substr($row[16],0,4);
	    $pdf->Row(array($row[2],$row[7],$row[6],$row[8],$fecha,$row[17]));
	    
}
	
	
}
$resultAsignacion=mysql_query($consultaAsignacion);
$pdf->SetFont('Arial','',8);
$pdf->Ln(5);
//Creación del objeto de la clase heredada



$pdf->Output();
?>

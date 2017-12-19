<?php
//pdf Asignacion de Componentes
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

function SetWidths($w) {
    //Set the array of column widths
    $this->widths=$w;
}
function setOrientacion($o='F') {
$this->orientacion=$o;
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
	function titulo($membrete="",$tituloReporte="",$fechaInicial="",$fechaFinal) {
		$this->membrete=$membrete;
		$this->fechaInicial=$fechaInicial;
		$this->fechaFinal=$fechaFinal;
		$this->tituloReporte=$tituloReporte;
		
	}

	function Header() {
    	
		switch ($this->orientacion) {
			case 'L':
				//Logo                  
				$this->Image('../imagenes/mibam.jpg',10,8,30);
				$this->Image('../imagenes/cvg.jpg',255,8,15);
				$this->Image('../imagenes/venalum.jpg',271,8,14);
			
				//Arial bold 15
				$this->SetFont('Arial','B',14);
				//Movernos a la derecha
				$this->Cell(80);
				//Título
				$this->Cell(120,8,$this->membrete,0,0,'C');
			 	$this->SetFont('Arial','B',12);
			 	$this->Ln(5);
				$this->Cell(92);
			 	$this->Write(20,$this->tituloReporte);
			 	$this->Ln(5);
			 	$this->Cell(100);
			 	$this->SetFont('Arial','',12);
			 	$this->Write(20,"DESDE: ".$this->fechaInicial." HASTA: ".$this->fechaFinal);
			 	//Salto de línea
				$this->Ln(20);
			break 1;
			case 'F':
		    	//Logo                  
		    	$this->Image('../imagenes/mibam.jpg',10,8,30);
		    	$this->Image('../imagenes/cvg.jpg',170,8,15);
		    	$this->Image('../imagenes/venalum.jpg',186,8,14);
		
		    	//Arial bold 15
		    	$this->SetFont('Arial','B',14);
		    	//Movernos a la derecha
		    	$this->Cell(80);
		    	//Título
		    	$this->Cell(30,8,$this->membrete,0,0,'C');
		     	$this->SetFont('Arial','B',12);
		     	$this->Ln(5);
		    	$this->Cell(50);
		     	$this->Write(20,$this->tituloReporte);
		     	$this->Ln(5);
		     	$this->Cell(60);
		     	$this->SetFont('Arial','',12);
		     	$this->Write(20,"DESDE: ".$this->fechaInicial." HASTA: ".$this->fechaFinal);
		
		     	//Salto de línea
		    	$this->Ln(20);
		    break 1;
		    default:
	        	//Logo                  
		    	$this->Image('../imagenes/mibam.jpg',10,8,30);
		    	$this->Image('../imagenes/cvg.jpg',170,8,15);
		    	$this->Image('../imagenes/venalum.jpg',186,8,14);
		
		    	//Arial bold 15
		    	$this->SetFont('Arial','B',14);
		    	//Movernos a la derecha
		    	$this->Cell(80);
		    	//Título
		    	$this->Cell(30,8,$this->membrete,0,0,'C');
		     	$this->SetFont('Arial','B',12);
		     	$this->Ln(5);
		    	$this->Cell(50);
		     	$this->Write(20,$this->tituloReporte);
		     	$this->Ln(5);
		     	$this->Cell(60);
		     	$this->SetFont('Arial','',12);
		     	$this->Write(20,"DESDE: ".$this->fechaInicial." HASTA: ".$this->fechaFinal);
		
		     	//Salto de línea
		    	$this->Ln(20);
		}
	}
	function Footer() {
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
	    $this->SetFillColor(255,189,100);
	    //Título
	    $this->Cell(0,4,"$tituloTabla",0,1,'L',1);

	}

}
class rptMantemiento {
private	
$fechaInicio,
$fechaFinal,
$idDescripcion,
$critico,
$usuarioEspecializado,
$red,
$correctivo,
$idSitio;

	function __construct($fechaInicio="",$fechaFinal="",$idSitio="",$idDescripcion="",$critico="",$red="",$usuarioEspecializado="",$correctivo="") {
		$this->fechaInicio=$fechaInicio;		
		$this->fechaFinal=$fechaFinal;
		$this->idDescripcion=$idDescripcion;
		$this->idSitio=$idSitio;
		$this->critico=$critico;
		$this->usuarioEspecializado=$usuarioEspecializado;
		$this->correctivo=$correctivo;
		$this->red=$red;
	}
	
	function setFechas($fechaInicio="",$fechaFinal="") {
		$this->fechaInicio=$fechaInicio;
		$this->fechaFinal=$fechaFinal;
	}
	
	function setSitio($idSitio="") {
		$this->idSitio=$idSitio;
	}
	
	function setDescripcion($idDescripcion="") {
		$this->idDescripcion=$idDescripcion;
	}
	
	function setCritrico($critico="") {
		$this->critico=$critico;
	}
	
	function setUsuarioEspecializado($usuarioEspecializado="") {
		$this->usuarioEspecializado=$usuarioEspecializado;
	}
	

	function setRed($red="") {
		$this->red=$red;
	}
	
	function setCorrectivo($correctivo="") {
		$this->correctivo=$correctivo;
	}
	
	function retornaMantenimientos($agrupadoPor="",$orden="") {
		if (isset($agrupadoPor) && !empty($agrupadoPor)) {
			$agrupado=" group by $agrupadoPor";
		}
		if (isset($orden) && !empty($orden)) {
			$ordenado=" order by $orden";
		}
		
		$consulta="select * 
		from 
		vistamantenimientospreventivos 
		where fecha_inicio between '$this->fechaInicio' and '$this->fechaFinal' 
		and id_sitio like '%$this->idSitio' 
		and id_descripcion like '%$this->idDescripcion' and 
		critico like '%$this->critico' and 
		usuario_especializado like '%$this->usuarioEspecializado' and 
		red like '%$this->red' and
		correctivo like '%$this->correctivo' and
		status_mantenimiento=2 
		 $agrupado $ordenado";
		$this->consulta=$consulta;
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
}


$fechaInicial=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
$fechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);

$consultaDistribucionMicros="select 
	sitio as EDIFICIOS,
	count(if(id_descripcion='DES0000001',id_descripcion,null)) as MICROCOMPUTADORAS,
	count(if(id_descripcion='DES0000008',id_descripcion,null)) as IMPRESORAS,
	count(if(id_descripcion='DES0000042',id_descripcion,null)) as LAPTOPS,
	count(id_descripcion) as TOTAL

	 from vistamantenimientosPreventivos where status_mantenimiento=2 and fecha_inicio between '$fechaInicial' and '$fechaFinal' group by sitio 
	order by sitio";

conectarMysql();
$resultResumenComputadoras=mysql_query($consultaDistribucionMicros);

mysql_close();




//RESUMEN DE LA GESTION DEL MANTENIMIENTO PREVENTIVO
$pdf=new PDF_MC_Table();
$pdf->titulo('DIV. CENTRO ATENCION USUARIO',"GESTION DEL MANTENIMIENTO PREVENTIVO",$_GET[fechaInicio],$_GET[fechaFinal]);
$pdf->Open();
$pdf->setOrientacion('L');
$pdf->AddPage('L');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',10);
$pdf->tituloTabla('RESUMEN DE MANTENIMIENTOS PREVENTIVOS DE MICROCOMPUTADORAS');
$pdf->SetWidths(array(84,60,50,50,33));
$pdf->SetFont('Arial','B',10);



//Distribucion de MicroComputadoras
for ($i=0;$i<mysql_numfields($resultResumenComputadoras);$i++)
	$Nombre[$i]=mysql_field_name($resultResumenComputadoras,$i);

	
//Titulos de las Columnas	
$pdf->RowColumnas($Nombre);
$pdf->SetFont('Arial','',7);


//Distribucion de MicroComputadoras

	if ($resultResumenComputadoras && $resultResumenComputadoras!=1) {
		while($row=mysql_fetch_array($resultResumenComputadoras)) {
			if ($row[1]>0)
			$pdf->Row(array($row[0],$row[1],$row[2],$row[3],$row[4]));
			$total[1]=$total[1]+$row[1];
			$total[2]=$total[2]+$row[2];
			$total[3]=$total[3]+$row[3];
			$total[4]=$total[4]+$row[4];
			$total[5]=$total[5]+$row[5];
			$total[6]=$total[6]+$row[6];
			$total[7]=$total[7]+$row[7];

		}
		$pdf->Row(array('TOTAL: ',$total[1],$total[2],$total[3],$total[4]));
	}
	
//DETALLE DE COMPUTADORAS POR EDIFICIO

	$mantenimiento= new rptMantemiento();
	$detalleMantenimiento= new rptMantemiento();
	$mantenimiento->setFechas($fechaInicial,$fechaFinal);
	$mantenimiento->setDescripcion('DES0000001');
	$detalleMantenimiento->setDescripcion('DES0000001');
	$Sitios=$mantenimiento->retornaMantenimientos('id_sitio','sitio');
	$detalleMantenimiento->setFechas($fechaInicial,$fechaFinal);

	if ($Sitios && $Sitios!=1) {
		$pdf->setOrientacion('F');	
		$pdf->AddPage();
		while($row=mysql_fetch_array($Sitios)) {
			$pdf->SetWidths(array(45,25,90,30));
			$pdf->SetFont('Arial','B',10);
			$pdf->tituloTabla("MICROCOMPUTADORAS CON MANTENIMIENTO PREVENTIVO EN ".$row[31]);
			$detalleMantenimiento->setSitio($row[30]);
			$resultadoDetalle=$detalleMantenimiento->retornaMantenimientos();
			$pdf->RowColumnas(array('DESCRIPCION','CONF','USUARIO','EXTENSION'));
			$pdf->SetFont('Arial','',10);
			if ($resultadoDetalle && $resultadoDetalle!=1)
				while ($rowEquipos=mysql_fetch_array($resultadoDetalle)) {
					$pdf->Row(array($rowEquipos[8],$rowEquipos[1],$rowEquipos[19].' '.$rowEquipos[20],$rowEquipos[21]));
				}
				$pdf->Ln(5);			
			
			
		}
	}

	
//DETALLE DE LAPTOPS POR EDIFICIO

	$mantenimiento= new rptMantemiento();
	$detalleMantenimiento= new rptMantemiento();
	$mantenimiento->setFechas($fechaInicial,$fechaFinal);
	$mantenimiento->setDescripcion('DES0000042');
	$detalleMantenimiento->setDescripcion('DES0000042');
	$Sitios=$mantenimiento->retornaMantenimientos('id_sitio','sitio');
	$detalleMantenimiento->setFechas($fechaInicial,$fechaFinal);

	if ($Sitios && $Sitios!=1) {
		$pdf->setOrientacion('F');	
		$pdf->AddPage();
		while($row=mysql_fetch_array($Sitios)) {
			$pdf->SetWidths(array(45,25,90,30));
			$pdf->SetFont('Arial','B',10);
			$pdf->tituloTabla("LAPTOPS CON MANTENIMIENTO PREVENTIVO EN ".$row[31]);
			$detalleMantenimiento->setSitio($row[30]);
			$resultadoDetalle=$detalleMantenimiento->retornaMantenimientos();
			$pdf->RowColumnas(array('DESCRIPCION','CONF','USUARIO','EXTENSION'));
			$pdf->SetFont('Arial','',10);
			if ($resultadoDetalle && $resultadoDetalle!=1)
				while ($rowEquipos=mysql_fetch_array($resultadoDetalle)) {
					$pdf->Row(array($rowEquipos[8],$rowEquipos[1],$rowEquipos[19].' '.$rowEquipos[20],$rowEquipos[21]));
				}
				$pdf->Ln(5);			
			
			
		}
	}
		
//DETALLE DE IMPRESORAS POR EDIFICIO

	$mantenimiento= new rptMantemiento();
	$detalleMantenimiento= new rptMantemiento();
	$mantenimiento->setFechas($fechaInicial,$fechaFinal);
	$mantenimiento->setDescripcion('DES0000008');
	$detalleMantenimiento->setDescripcion('DES0000008');
	$Sitios=$mantenimiento->retornaMantenimientos('id_sitio','sitio');
	$detalleMantenimiento->setFechas($fechaInicial,$fechaFinal);
	if ($Sitios && $Sitios!=1) {
		$pdf->setOrientacion('F');	
		$pdf->AddPage();
		while($row=mysql_fetch_array($Sitios)) {
			$pdf->SetWidths(array(45,25,90,30));
			$pdf->SetFont('Arial','B',10);
			$pdf->tituloTabla("IMPRESORAS CON MANTENIMIENTO PREVENTIVO EN ".$row[31]);
			$detalleMantenimiento->setSitio($row[30]);
			$resultadoDetalle=$detalleMantenimiento->retornaMantenimientos();
			$pdf->RowColumnas(array('DESCRIPCION','CONF','USUARIO','EXTENSION'));
			$pdf->SetFont('Arial','',10);
			if ($resultadoDetalle && $resultadoDetalle!=1)			
				while ($rowEquipos=mysql_fetch_array($resultadoDetalle)) {
					$pdf->Row(array($rowEquipos[8],$rowEquipos[1],$rowEquipos[19].' '.$rowEquipos[20],$rowEquipos[21]));
				}
				$pdf->Ln(5);			
			
			
		}
	}
	
	
$pdf->Output();
?>

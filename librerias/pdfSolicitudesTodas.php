<?php
session_cache_limiter ( 'private' );	
session_save_path();
$gerencia;

 $fechaI; $fechaF;

require_once("fpdf.php");
class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;
var $data;

//Cabecera de página
function titulo($titulo="",$subtitulo="") {
		$this->titulo=$titulo;
		$this->subtitulo=$subtitulo;
}
function encabezado($encabezado="",$gerencia="",$intervalo="",$fecha="") {
		$this->encabezado=$encabezado;		
		$this->gerencia=$gerencia;				
		$this->intervalo=$intervalo;
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
		$this->Cell(-29,17,$this->subtitulo,0,0,'C');				
    	//Salto de línea   
    	$this->SetFont('Arial','B',10); 	
    	$this->Cell(30,45,$this->encabezado,0,0,'C');		
    	$this->SetFont('Arial','B',8); 
    	$this->Cell(-31,60,$this->gerencia,0,0,'C');		
    	$this->Cell(30,70,$this->intervalo,0,0,'C');		
    	$this->Cell(100,80,$this->fecha,0,0,'C');				
    	$this->Ln(42);
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

function RowRegistros($header,$data,$swiche)
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
    
    if ($tam==6){
     	$w=array(20,10,50,15,30,55);
     	for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],5,$header[$i],1,0,'C',1);
        $this->Ln(); 
    }   
    if ($tam==8) {
    	$w=array(20,10,20,15,30,30,30,30); 
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],5,$header[$i],1,0,'C',1);
        $this->Ln();      	        
      } 
     if ($tam==7){
     	$w=array(20,10,30,30,30,30,30);
     	for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],5,$header[$i],1,0,'C',1);
        $this->Ln(); 
     }  
	
}	
    
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h,$header);
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

function CheckPageBreak($h,$header)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger){
		$this->AddPage($this->CurOrientation);		
		$this->RowRegistros($header,null,0);		
	}				
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
$consultaGerencia="select id_gerencia,gerencia from gerencia where id_gerencia='$gerencia'";
$mostrarGerencia=mysql_query($consultaGerencia);
$results=mysql_fetch_array($mostrarGerencia);

$consultSitio="select id_sitio,sitio from sitio where id_sitio='$sitio'";
$mostrarSitio=mysql_query($consultSitio);
$resultad=mysql_fetch_array($mostrarSitio);
if ($gerencia!=100 && $sitio==100 && $estatus==100 && $usuario==""){	
	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
           SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
           STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
           FROM SOLICITUD_EQUIPO
	 	   INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
		   INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
		   INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
		   INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
		   INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
		   INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
		   INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
		   INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
		   WHERE GERENCIA.ID_GERENCIA LIKE'%$gerencia' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY USUARIO.FICHA";        	        	
           $result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4); 
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE SOLICITUDES',"$results[1]","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,10,30,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','MOTIVO SOLICITUD','ESTATUS SOLICITUD');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[7],$row[9]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}


if ($gerencia!=100 && $sitio!=100 && $estatus==100 && $usuario==""){	
	$estatus="";
	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
           SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
           STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
           FROM SOLICITUD_EQUIPO
	 	   INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
		   INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
		   INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
		   INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
		   INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
		   INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
		   INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
		   INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
		   WHERE GERENCIA.ID_GERENCIA LIKE'%$gerencia' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY USUARIO.FICHA";        	        	
           $result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4); 
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado("REPORTE DE SOLICITUDES","$results[1]","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,10,50,15,30,55));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','UBICACION');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[17]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}

if ($gerencia=="" && $sitio=="" && $estatus=="" && $usuario==""){											
        	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY GERENCIA.GERENCIA"; 
 $result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4); 
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE SOLICITUDES POR GERENCIAS',"TOTAL DE SOLICITUDES:$totalSolicitudes APROBADAS:$aprob, EJCUTADAS:$ejecutado, SIN PROCESAR:$sinProcesar,RECHAZADAS:$rechazado,EN PROCESO:$enProceso","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetWidths(array(20,10,20,15,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','MOTIVO SOLICITUD','ESTATUS SOLICITUD','GERENCIA');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[7],$row[9],$row[15]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}





if ($gerencia!=100 && $sitio==100 && $estatus!=100 && $usuario==""){											
        	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE GERENCIA.ID_GERENCIA LIKE '$gerencia' AND SOLICITUD_EQUIPO.ID_STATUS LIKE'$estatus' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY GERENCIA";         	
 $result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4); 
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE SOLICITUDES POR GERENCIAS Y ESTATUS DE SOLICITUD',"","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetWidths(array(20,10,20,15,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','MOTIVO SOLICITUD','ESTATUS SOLICITUD','GERENCIA');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[7],$row[9],$row[15]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}




if($estatus!=100 && $gerencia==100 && $sitio==100 && $usuario=="") {	
$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                        SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                        STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SOLICITUD_EQUIPO.ID_STATUS LIKE '%$estatus' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";     

$result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4);            
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE ESTATUS DE SOLICITUDES',"TOTAL DE SOLICITUDES CON ESTATUS $valor:$totalSolicitud","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,10,20,15,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','MOTIVO SOLICITUD','ESTATUS SOLICITUD','GERENCIA');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[7],$row[9],$row[15]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}

if($usuario!="") {	
$usua="SELECT CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO FROM USUARIO WHERE USUARIO.FICHA='$usuario'";
$mostrarUsuario=mysql_query($usua);
$results=mysql_fetch_array($mostrarUsuario); 
$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
                              SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
                              STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
                        FROM SOLICITUD_EQUIPO
						INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
						INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
						INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
						INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
						INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
						INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
						INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
						INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
						WHERE SOLICITUD_EQUIPO.FICHA LIKE '%$usuario' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF'";
$result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4); 
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE SOLICITUDES POR USUARIOS',"$results[0]","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,10,30,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','EXTENSION','DESCRIPCION','MOTIVO SOLICITUD','ESTATUS SOLICITUD','GERENCIA');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[3],$row[5],$row[7],$row[9],$row[15]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}


if ($gerencia!=100 && $sitio!=100 && $estatus!=100 && $usuario==""){
	conectarMysql();		
	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
           SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
           STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
           FROM SOLICITUD_EQUIPO
	 	   INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
		   INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
		   INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
		   INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
		   INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
		   INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
		   INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
		   INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
		   WHERE GERENCIA.ID_GERENCIA LIKE'%$gerencia' AND SITIO.ID_SITIO LIKE'%$sitio' AND SOLICITUD_EQUIPO.ID_STATUS LIKE'%$estatus' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY USUARIO.FICHA";        	        	
           $result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();           
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4);            
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE SOLICITUDES ',"$results[1]"," DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,10,30,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','ESTATUS SOLICITUD','UBICACION');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[9],$row[17]),$swiche);
	   $swiche=1;	   
	   $total++;
}
$pdf->Output();
mysql_close();
}



if ($gerencia==100 && $sitio!=100 && $estatus!=100 && $usuario==""){	
	$gerencia="";	
	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
           SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
           STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
           FROM SOLICITUD_EQUIPO
	 	   INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
		   INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
		   INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
		   INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
		   INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
		   INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
		   INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
		   INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
		   WHERE GERENCIA.ID_GERENCIA LIKE'%$gerencia' AND SITIO.ID_SITIO LIKE'%$sitio' AND SOLICITUD_EQUIPO.ID_STATUS LIKE'%$estatus' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY USUARIO.FICHA";        	        	
           $result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4); 
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE SOLICITUDES POR EDIFICIOS Y ESTATUS',"$resultad[1]","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,10,30,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','ESTATUS SOLICITUD','GERENCIA');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[9],$row[14]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}


if ($gerencia==100 && $sitio!=100 && $estatus==100 && $usuario==""){	
	$gerencia=""; $estatus="";	
	$consulta="SELECT ID_SOLICITUD, SOLICITUD_EQUIPO.FICHA,CONCAT(USUARIO. NOMBRE_USUARIO, ' ',USUARIO. APELLIDO_USUARIO) AS USUARIO, USUARIO.EXTENSION,
           SOLICITUD_EQUIPO.ID_DESCRIPCION,DESCRIPCION.DESCRIPCION,SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD, MOTIVO_SOLICITUD.MOTIVO_SOLICITUD,SOLICITUD_EQUIPO.ID_STATUS,
           STATUS_SOLICITUD.DES_STATUS,ID_USS, FECHA_I, FECHA_M, OBSERVACION_SOLICITUD,GERENCIA,DIVISION,DEPARTAMENTO,SITIO
           FROM SOLICITUD_EQUIPO
	 	   INNER JOIN DESCRIPCION ON SOLICITUD_EQUIPO.ID_DESCRIPCION=DESCRIPCION.ID_DESCRIPCION
		   INNER JOIN USUARIO ON SOLICITUD_EQUIPO.FICHA=USUARIO.FICHA
		   INNER JOIN STATUS_SOLICITUD ON SOLICITUD_EQUIPO.ID_STATUS=STATUS_SOLICITUD.ID_STATUS
		   INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
		   INNER JOIN MOTIVO_SOLICITUD ON SOLICITUD_EQUIPO.ID_MOTIVO_SOLICITUD=MOTIVO_SOLICITUD.ID_MOTIVO_SOLICITUD
		   INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
		   INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
		   INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA 
		   WHERE GERENCIA.ID_GERENCIA LIKE'%$gerencia' AND SITIO.ID_SITIO LIKE'%$sitio' AND SOLICITUD_EQUIPO.ID_STATUS LIKE'%$estatus' AND SOLICITUD_EQUIPO.FECHA_I BETWEEN '$fechaI' and '$fechaF' ORDER BY USUARIO.FICHA";        	        	
           $result=mysql_query($consulta);
           $pdf=new PDF_MC_Table();
           $fecha=getdate();
           $fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
           $fechaI=substr($fechaI,8,2).'/'.substr($fechaI,5,2).'/'.substr($fechaI,0,4); 
           $fechaF=substr($fechaF,8,2).'/'.substr($fechaF,5,2).'/'.substr($fechaF,0,4); 
           $pdf->titulo('GERENCIA DE SISTEMAS Y ORGANIZACIÓN','DIVISIÓN CENTRO DE ATENCIÓN A USUARIOS');
           $pdf->encabezado('REPORTE DE SOLICITUDES POR EDIFICIOS',"$resultad[1]","DESDE: $fechaI HASTA: $fechaF","Ciudad Guayana, $fecha");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(20,10,30,30,30,30,30));
$header=array('ID SOLICITUD','FICHA','USUARIO','EXTENSION','DESCRIPCION','GERENCIA','DIVISION');
$swiche=0;
while ($row=mysql_fetch_array($result)){   
	   $pdf->RowRegistros($header,array($row[0],$row[1],$row[2],$row[3],$row[5],$row[14],$row[15]),$swiche);
	   $swiche=1;	   
	   $total++;
}
mysql_close();
$pdf->Output();
}


?> 
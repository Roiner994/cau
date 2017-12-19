<?
require_once("fpdf.php");
class PDF extends FPDF {
private $result,$titulo,$fecha;

//Cargar los datos
function LoadData($result) {
	$this->result=$result;
}
//Una tabla más completa
function FancyTable($header,$data) {
    //Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,189,100);
    $this->SetTextColor(0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','B',10);
    //Cabecera
    $w=array(20,55,30,45,40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(255,221,174);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
 $this->SetFont('Arial','B',6);
    $fill=0;
    while($row=mysql_fetch_array($this->result)) {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
		$this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
		$this->Cell($w[4],6,$row[4],'LR',0,'L',$fill);
//        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
//        $this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
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
    	$this->SetFont('Arial','B',12);
    	//Movernos a la derecha
    	$this->Cell(80);
    	//Título
    	$this->Cell(30,8,$this->titulo,0,0,'C');
		$this->Cell(-27,15,$this->fecha,0,0,'C');
    	//Salto de línea
    	$this->Ln(20);
	}

	//Pie de página
	function Footer() {
    	//Posición: a 1,5 cm del final
    	$this->SetY(-15);
    	//Arial italic 8
    	$this->SetFont('Arial','I',8);
    	//Número de página
    	$this->Cell(0,10,'Pág. '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$consulta="select id_solicitud,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO) AS USUARIO,descripcion,gerencia,sitio 
from solicitud_equipo inner join usuario on solicitud_equipo.FICHA=usuario.FICHA inner join descripcion on solicitud_equipo.id_descripcion=descripcion.id_descripcion 
inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia 
inner join division on ubicacion.id_division= division.id_division inner join departamento on ubicacion.id_departamento=departamento.id_departamento inner join sitio on ubicacion.id_sitio=sitio.id_sitio inner join status_solicitud on solicitud_equipo.id_status=status_solicitud.id_status 
where status_solicitud.id_status ='STA0000006' ORDER BY gerencia DESC"; 
require_once("conexionsql.php");

conectarMysql();
$result=mysql_query($consulta);
$fecha=getdate();
$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];

$pdf=new PDF();
$pdf->titulo('SOLICITUDES SIN PROCESAR',$fecha);
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('SOLICITUD','NOMBRES','DESCRIPCION','GERENCIA','SITIO');
//Carga de datos
$data=$pdf->LoadData($result);
$pdf->SetFont('Arial','',6);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
//require('../prueba/torta.php');
$pdf->Output();

?> 
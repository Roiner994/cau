<?php
include ("../../src/jpgraph.php");
include ("../../src/jpgraph_pie.php");
//include ("../../src/jpgraph_pie3d.php");
require_once "../../librerias/conexionsql.php";
$consulta ="SELECT  solicitud_equipo.status,status_solicitud.DES_STATUS,count(solicitud_equipo.status) from solicitud_equipo inner join status_solicitud on solicitud_equipo.status=status_solicitud.id_status inner join ubicacion on solicitud_equipo.id_ubicacion=ubicacion.id_ubicacion inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia group by solicitud_equipo.status";

$data = array();
$leyenda= array();
conectarMysql();
$result=mysql_query($consulta);
while ($row=mysql_fetch_array($result)) {
	array_push($data,"$row[2]");
	array_push($leyenda,"$row[1]");
}

// nuevo grafico de torta
$graph = new PieGraph(450,400,"auto");
$graph->SetShadow();

// tiulo de la grafica
$Titulo="SOLICITUDES EMITIDAS";
$graph->title->Set($Titulo);
$graph->title->SetFont(FF_FONT1,FS_BOLD);

//Genera un nuevo diagrama
$p1 = new PiePlot($data);
$p1->SetLegends($leyenda);


$graph->legend->Pos(0.02,0.80);
$graph->legend->SetShadow(false);

$p1->SetSize(0.25);
$p1->SetCenter(0.45,0.52);


// 
$p1->value->SetFont(FF_FONT1,FS_BOLD);
$p1->value->SetColor("black");
$p1->SetLabelPos(1.005);
$p1->SetGuideLines(true,false);
$p1->SetGuideLinesAdjust(0.85);

// Explode all slices
$p1->ExplodeAll();

// Add drop shadow
$p1->SetShadow();

// Finally add the plot
$graph->Add($p1);

// ... and stroke it
$graph->Stroke();

?>

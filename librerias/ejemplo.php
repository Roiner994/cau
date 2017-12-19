<?php
// $Id: piebkgex1.php,v 1.3 2002/10/23 08:17:23 aditus Exp $
include ("../../src/jpgraph.php");
include ("../../src/jpgraph_pie.php");
include ("../../src/jpgraph_pie3d.php");
//echo "<img src=\"ejemplo2.php\" alt \"\" border=\"0\">";
// Some data
$data = array(
    array(50,30,65,14));
    /*array(35,28,6,34),
   array(10,28,10,5),
    array(22,22,10,17));*/
 //echo "<table border=0 align='center'>\n"; 
$piepos = array(0.50,0.5/*,0.65,0.28,0.25,0.75,0.8,0.75*/);
//$titles = array('SOLICITUDES'/*,'SISTEMA','COLADA','CARBON'*/);
$n = count($piepos)/2;

// A new graph
$graph = new PieGraph(550,400,'auto');

// Specify margins since we put the image in the plot area
//$graph->SetMargin(1,1,40,1);
//$graph->SetMarginColor('white');
$graph->SetShadow();

// Setup background
//$graph->SetBackgroundImage('IMAGEN.JPG',BGIMG_FILLPLOT);

// Setup title
$graph->title->Set("ESTADISTICOS DE SOLICITUDES");
$graph->title->SetFont(FF_COMIC,FS_BOLD);
$p1 = new PiePlot3D($data);
$p1->SetTheme("earth");
$graph->title->SetColor('red');

$p = array();
// Create the plots
for( $i=0; $i < $n; ++$i ) {
    $d = "data$i";
    $p[] = new PiePlot3D($data[$i]);
}

// Position the four pies
for( $i=0; $i < $n; ++$i ) {
    $p[$i]->SetCenter($piepos[2*$i],$piepos[2*$i+1]);
}

// Set the titles
for( $i=0; $i < $n; ++$i ) {
    $p[$i]->title->Set($titles[$i]);
    $p[$i]->title->SetColor('red');
    $p[$i]->title->SetFont(FF_ARIAL,FS_BOLD,12);
}

// Label font and color setup
for( $i=0; $i < $n; ++$i ) {
    $p[$i]->value->SetFont(FF_ARIAL,FS_BOLD);
    $p[$i]->value->SetColor('red');
}

// Show the percetages for each slice
for( $i=0; $i < $n; ++$i ) {
    $p[$i]->value->Show();
}

// Label format
for( $i=0; $i < $n; ++$i ) {
    $p[$i]->value->SetFormat("%01.1f%%");
}

// Size of pie in fraction of the width of the graph
for( $i=0; $i < $n; ++$i ) {
    $p[$i]->SetSize(0.15);
}

// Format the border around each slice


for( $i=0; $i < $n; ++$i ) {
    $p[$i]->ShowBorder(false);
    $p[$i]->ExplodeSlice(1);
}

// Use one legend for the whole graph
$p[0]->SetLegends(array("MICROCOMPUTADOR","DISCO DURO","PEN DRIVE","TECLADO"));
$graph->legend->Pos(0.02,0.80);
$graph->legend->SetShadow(false);

for( $i=0; $i < $n; ++$i ) {
    $graph->Add($p[$i]);
}
$graph->Stroke();
?>


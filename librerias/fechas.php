<?php

$actual = date("Y-m-d ");
echo "fecha_actual: $actual<br>";
$anterior = "2005-04-19";
echo "fecha_anterior:$anterior<br>";
list($fechaAct) = explode(" ", $actual);
list($yearAct, $mesAct, $dayAct) = explode("-", $fechaAct);
echo "fecha listo: list($yearAct,$mesAct,$dayAct)";
list($fechaAnt) = explode(" ", $anterior);
list($yearAnt, $mesAnt, $dayAnt) = explode("-", $fechaAnt);
$sAct = mktime( 0,0,0,$mesAct, $dayAct, $yearAct);
$sAnt = mktime( 0,0,0,$mesAnt, $dayAnt, $yearAnt);
$diffSeg = $sAct - $sAnt;
$diffMin = $diffSeg / 60;
$diffHoras = $diffMin / 60;
$diffdias =$diffHoras/24;
//echo $sAct."<br>";
//echo $sAnt."<br>";
/*echo "segundos " . $diffSeg."<br>";
echo "minutos " . $diffMin."<br>";
echo "horas " . $diffHoras."<br>";*/
echo "diferencias de dias" . $diffdias."<br>";
?>

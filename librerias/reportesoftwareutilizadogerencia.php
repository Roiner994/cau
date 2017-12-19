<?php
$fecha=getdate();
$fecha=$fecha[mday]."/".$fecha[mon]."/".$fecha[year];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../site/reportes.css">
<title>DISTRIBUCION DE LOS SOFTWARE UTILIZADO POR CADA GERENCIA</title>
</head>
<body>
<div>
<?php
require_once("conexionsql.php");

$conGerencia="select distinct id_gerencia,gerencia from vistasoftwareutilizado order by gerencia";

conectarMysql();
$result=mysql_query($conGerencia);
mysql_close();

if ($result && mysql_numrows($result)>0) {
	$columnasGerencia="";
	$cantGerencia=0;
	while ($row=mysql_fetch_array($result)) {
		$cantGerencia++;
		$columnasGerencia=$columnasGerencia."count(if(ID_GERENCIA='$row[0]',ID_GERENCIA,null)) as '$row[1]',";
		$gerencia[$cantGerencia]=$row[0];
	}
}

$conDistribucionSoftware="select 
	concat(software,' - ',descripcion_software) as SOFTWARE,
	$columnasGerencia
	ID_SOFTWARE
	from vistasoftwareutilizado
	group by SOFTWARE
	order by SOFTWARE";

conectarMysql();
$resultDistribucionsSoftware=mysql_query($conDistribucionSoftware);
mysql_close();

//Distribucion de SOFTWARE UTILIZADOS
if ($resultDistribucionsSoftware && mysql_numrows($resultDistribucionsSoftware)>0) { 

	echo "<table border=\"1\">
	<CAPTION><EM>SOFTWARE UTILIZADO POR LOS USUARIOS DISTRIBUIDOS POR GERENCIA</EM></CAPTION>";
	
	$thead="<thead><tr><th><strong>SOFTWARE / GERENCIA</strong></th>";
	for ($i=1;$i<mysql_numfields($resultDistribucionsSoftware)-1;$i++) { 
		$thead=$thead."<th><strong>".mysql_field_name($resultDistribucionsSoftware,$i)."</strong></th>";
	}
	$thead=$thead."<th><strong>TOTAL</strong></th>";
	$thead=$thead."</tr></thead>";
	
	
		unset($total);
		unset($tbody);
		while ($row=mysql_fetch_array($resultDistribucionsSoftware)) { 
			$tbody=$tbody."<tbody><tr>";
			for ($i=0;$i<=$cantGerencia;$i++) { 
				$acumulado=$acumulado+$row[$i+1];
				$tbody=$tbody."<td>$row[$i]</td>";
				$total[$i]=$total[$i]+$row[$i];

			}
			$tbody=$tbody."<td>$acumulado</td>";
			unset($acumulado);
			$tbody=$tbody."</tr></tbody>";
		}
		$tfoot="<tfoot><tr><td><strong>TOTAL</strong></td>";
		for ($i=1;$i<=$cantGerencia;$i++) {
			$tfoot=$tfoot."<td>$total[$i]</td>";
			$totalAcumulado=$totalAcumulado+$total[$i];
		}
		$tfoot=$tfoot."<td>$totalAcumulado</td>";
	$tfoot=$tfoot."</tr></tfoot>";
	
	
	echo $thead;
	echo $tfoot;
	echo $tbody;

	echo "</table>";
	}
?>
</div>

</body>
</html>
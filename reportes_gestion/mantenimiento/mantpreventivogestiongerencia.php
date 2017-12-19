<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>
<body>
<div id="contenedor">
<?php
require_once("../conexionsql.php");
require_once("mantAdmin.php");
$conGerencia="select id_gerencia,gerencia from vistamantenimientospreventivos where id_gerencia='$_GET[idGerencia]'";
$consulta="select id_sitio,sitio,id_gerencia,gerencia,date_format(fecha_inicio,'%m') as Fecha,count(*) as TOTAL 
from vistamantenimientospreventivos where id_gerencia='$_GET[idGerencia]' and ID_SITIO<>'SIT0000057' and status_mantenimiento=2 and  fecha_inicio between '2006-01-01' and '2007-01-01' 
group by fecha,sitio order by fecha_inicio,sitio";
conectarMysql();
$resultGerencia=mysql_query($conGerencia);
$result=mysql_query($consulta);
mysql_close();

if ($resultGerencia && mysql_numrows($resultGerencia)>0) {
	$rowGerencia=mysql_fetch_array($resultGerencia);
	?>
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
	<div id="cuerpo">		
	<h1>MANTENIMIENTOS PREVENTIVOS A&Ntilde;O 2006</h1>
<?php
	if ($result && mysql_numrows($result)>0) { ?>
		<table class="tabla" width="100%" border="1">
		<caption><?=$rowGerencia[1]?></caption>

		<thead>
		<tr>
		<th>MES</th>
		<th>EDIFICIO</th>
		<th>CANTIDAD</th>
		</tr>
		</thead>
	
		<tbody>
	<?php
		unset($total);
		while ($row=mysql_fetch_array($result)) {
			$i++;
			if ($i%2==0) {?>
				<tr onclick="location.href='mantpreventivogestionequipos?idSitio=<?=$row[0]?>&amp;idGerencia=<?=$rowGerencia[0]?>&amp;mes=<?=$row[4]?>'">
			<?php
			} 
			else { ?>
			<tr class="odd" onclick="location.href='mantpreventivogestionequipos?idSitio=<?=$row[0]?>&amp;idGerencia=<?=$rowGerencia[0]?>&amp;mes=<?=$row[4]?>'">					
			<?php
			} 
			if ($row[4]==$Mes) { ?>
				<td class="resaltar">&nbsp;</td>
			<?php
			} else { ?>
			<td class="resaltar"><?=convertirMes($row[4])?></td>

			<?php
			}
			?>
			<td><?=$row[1]?></td>
			<td><?=$row[5]?></td>
			</tr>
		<?php
		$Mes=$row[4];
		$total=$total+$row[5];
		} ?>
		</tbody>
		<tfoot>
		<tr>
		<td class="foottotal" colspan="2">TOTAL</td>
		<td><?=$total?></td>
		</tr>
		</tfoot>
		</table>
	<?php
	}
}



?>
	<p class="paginador"><?=$_pagi_navegacion?></p>
	<p class="reporteNavegacion">
	<a href="index.php">REGRESAR</a> |
	<a href="../index.php">REPOTES</a></p> 
	<p class="reporteExportar">
	<a href="mantpreventivogestiongerenciaexcel.php?idGerencia=<?=$_GET[idGerencia]?>">FORMATO EXCEL</a></p>
	</div>
</div>
</body>
</html>
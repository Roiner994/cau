<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>
<body>
<div id="container">
<?php
require_once("../conexionsql.php");
require_once("mantAdmin.php");
$conGerencia="select id_gerencia,gerencia from vistamantenimientospreventivos where id_gerencia='$_GET[idGerencia]' and ID_SITIO<>'SIT0000057'";


$consulta="select id_mantenimiento,
configuracion,
concat(descripcion,' ',marca,' ',modelo,' ', cap_vel,' ',unidad) as EQUIPO,
FICHA, concat(nombre_usuario, ' ', apellido_usuario) as USUARIO, 
EXTENSION, 
SITIO, 
HORA_INICIO
from vistamantenimientospreventivos
where status_mantenimiento=2 and
date_format(fecha_inicio,'%m')='$_GET[mes]' and
id_gerencia='$_GET[idGerencia]' and
id_sitio='$_GET[idSitio]'";
conectarMysql();
$resultGerencia=mysql_query($conGerencia);
$result=mysql_query($consulta);
mysql_close();

?>
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
<div id="cuerpo">		
<h1>MANTENIMIENTOS PREVENTIVOS A&Ntilde;O 2006</h1>
<?php
if ($resultGerencia && mysql_numrows($resultGerencia)>0) {
	$rowGerencia=mysql_fetch_array($resultGerencia);
	?>

<?php
	if ($result && mysql_numrows($result)>0) { ?>
		<table class="tabla" width="100%" border="1">
		<caption><?=$rowGerencia[1]?></caption>
		<thead>
		<tr>
		<th>N° MANTENIMIENTO</th>
		<th>CONFIGURACION</th>
		<th>EQUIPO</th>
		<th>FICHA</th>
		<th>USUARIO</th>
		<th>EXTENSION</th>
		<th>EDIFICIO</th>
		<th>FECHA</th>
		</tr>
		</thead>
		<tbody>
	<?php
		while ($row=mysql_fetch_array($result)) {
			$i++;
			if ($i%2==0) {?>
				<tr onclick="location.href='mantpreventivogestiondetalle.php?idMantenimiento=<?=$row[0]?>'">
			<?php
			} 
			else { ?>
			<tr class="odd" onclick="location.href='mantpreventivogestiondetalle.php?idMantenimiento=<?=$row[0]?>'">					
			<?php
			} ?>
			<td><?=$row[0]?></td>
			<td><?=$row[1]?></td>
			<td><?=$row[2]?></td>
			<td><?=$row[3]?></td>
			<td><?=$row[4]?></td>
			<td><?=$row[5]?></td>
			<td><?=$row[6]?></td>
			<td><?=substr($row[7],0,10)?></td>
			</tr>
		<?php	
		} ?>
		</tbody>
		</table>
	<?php
	}
}

?>
	</div>
</div>
</body>
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>
<body>

<?php
require_once("../conexionsql.php");
$consulta="select id_gerencia,gerencia,count(*) as cantidad FROM vistamantenimientospreventivos WHERE ID_SITIO<>'SIT0000057' group by id_gerencia order by gerencia";
conectarMysql();
$result=mysql_query($consulta);
mysql_close();
?>
<div id="contenedor">
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>	
	<div id="cuerpo">
	<h1>GESTION MANTENIMIENTO PREVENTIVO A&Ntilde;O 2006</h1>
	<?php
	if ($result && mysql_numrows($result)>0) { ?>
		<table class="tablaGerencia" width="50%" border="1">
		<caption>GERENCIAS DE CVG VENALUM</caption>
		<thead>
		<tr>
		<th>GERENCIA</th>
		<th>TOTAL</th>
		</tr>
		</thead>
		<tbody>
	<?php
		while ($row=mysql_fetch_array($result)) {
			$i++;
			if ($i%2==0) {?>
				<tr onclick="location.href='mantpreventivogestiongerencia?idGerencia=<?=$row[0]?>'">
			<?php
			} 
			else { ?>
			<tr class="odd" onclick="location.href='mantpreventivogestiongerencia?idGerencia=<?=$row[0]?>'">					
			<?php
			} ?>
			<td><?=$row[1]?></td>
			<td><?=$row[2]?></td>
			</tr>
		<?php 
		} ?>
	</ul>
	<?php
	
	}
	?>
	</tbody>
	</div>
</div>
</body>
</html>
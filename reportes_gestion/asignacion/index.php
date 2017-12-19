<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="estilomantenimiento.css">
<title>ASIGNACIONES DE EQUIPOS A&Ntilde;O 2006</title>
</head>
<body>

<?php
require_once("../conexionsql.php");
$consulta="select descripcion,count(*) as cantidad from vistainventarioequipos where fecha_inicio >= '2006-01-01' and (ficha<>'9999999' or ficha<>'') and estado='operativo' group by id_descripcion";
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
	<h1>ASIGNACIONES DE EQUIPOS A&Ntilde;O 2006</h1>
	<?php
	if ($result && mysql_numrows($result)>0) { ?>
		<table class="tablaGerencia" width="50%" border="1">
		<caption>CANTIDAD DE EQUIPOS INSTALADOS EN CVG VENALUM EN EL A&Ntilde;O 2006</caption>
		<thead>
		<tr>
		<th>TIPO DE EQUIPO</th>
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
			<td><?=$row[0]?></td>
			<td><?=$row[1]?></td>
			</tr>
		<?php 
		} ?>
	
	<?php
	
	}
	?>
	</tbody>
	</div>
</div>
</body>
</html>
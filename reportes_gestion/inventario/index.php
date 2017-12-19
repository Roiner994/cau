<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>
<body>
<div id="contenedor">
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>	
	<div id="cuerpo">
	<h1>REPORTES DE INVENTARIO</h1>
	<dl class="ddMenuPrincipal">
	<dt><a href="equiposInstalados.php">EQUIPOS INSTALADOS EN PLANTA</a></dt>
	<dd>MUESTRA LA CANTIDAD DE EQUIPOS INSTALADOS EN PLANTA ORDENADOS POR EDIFICIO</dd>
	<dt>REPORTE DE ASIGNACIONES Y REEMPLAZO DE EQUIPOS</dt>
	<dd>MUESTRA LAS ASIGNACIONES Y REEMPLAZO DE EQUIPOS HECHOS EN PLANTA</dd>
	<dt>REPORTE DE ASIGNACIONES Y REEMPLAZO DE COMPONENTES</dt>
	<dd>MUESTRA LAS ASIGNACIONES Y REEMPLAZO DE COMPONENTES HECHOS EN PLANTA</dd>
	</dl>
	<p class="paginador"><?=$_pagi_navegacion?></p>
	<p class="reportePagiInfo">Resultados <?=$_pagi_info?></p>
	<p class="reporteNavegacion">
	<a href="../index.php">REPORTES</a> |
	<a href="../../site/index2.php">SISTEMA DE CAU</a></p> 
	</div>
	
</div>
</body>
</html>
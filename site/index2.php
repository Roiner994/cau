<?php
require_once("../librerias/seguridad.php");
?>
<script language="javascript">
function MoverTop(Top) {
	document.body.scrollTop =  Top;
}
function posicionamientoPantalla() {
	var top;
	if (document.body && document.body.scrollTop) {
		top=document.body.scrollTop;
		document.forms[1].top.value=top;
	}
	if (document.documentElement && document.documentElement.scrollTop) {
		top=document.documentElement.scrollTop;
		document.forms[1].top.value=top;
	}
}
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SISTEMA DE MANTENIMIENTO Y CONTROL DE INVENTARIO DIV.CENTRO ATENCI&Oacute;N A USUARIOS- CVG VENALUM</title>
<link rel="STYLESHEET" type="text/css" href="estilos.css">
<link rel="stylesheet" type="text/css" href="estilopasante.css">
</head>
<body onload="MoverTop(<?php if (isset($_POST[top]) && !empty($_POST[top]))
								echo $_POST[top];
							else echo 0 ?>)">
<div id="contenedor" align="center">
	<div id="cabecera">
		<img src="../imagenes/encabezado.jpg" width="980" height="80"><br>

		<a class="inicioSessionDerecha" href="index2.php?item=619">CAMBIAR PASSWORD</a>
		<a class="inicioSessionDerecha" href="../librerias/salir.php">CERRAR SESI&Oacute;N</a>
	</div>
  	<div id="cuerpo">	
	    <div id="menuLateral">
			<?php require_once("../librerias/menuLateral.php"); ?>       

		</div>
			<?php require_once ("secciones.php"); ?>
		</div>
</div>
	<div id="pie">
	<p class="piePagina">Recomendamos: Resoluci&oacute;n 1024 x 768 p&iacute;xeles / Fuentes peque&ntilde;as / Navegador Microsoft Internet Explorer 6.0<br>
	&copy; CopyRight 2006  Todos los Derechos Reservados a C.V.G Venalum</p>
	</div>		
</body>
</html>
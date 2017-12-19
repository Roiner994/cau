<?php
include("...\libreria\calendario\calendario.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Gestión Mensual CAU</title>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
</head>

<body>
<div id="contenedor">
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>	
	<div id="cuerpo">
	<h1>REPORTES DE GESTIÓN MENSUAL</h1>

	<br><br><br>

	
<form name="fcalen" action="entrada_pedido.php"  method="GET">
<table width="429" border="0" align="center" cellspacing="1">
    <tr>
      <td width="216"><p>FECHA INICIO<input name="txtFechaInicio" value""><a href="javascript:show_calendar('fcalen.txtFechaInicio');"onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="../imagenes/calendario.gif" width="23" height="15" border=0></a>
      <td width="204"><p>FECHA FINAL<input name="txtFechaFinal" value""><a href="javascript:show_calendar('fcalen.txtFechaFinal');"onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="../imagenes/calendario.gif" width="23" height="15" border=0></a></p
    </tr>
    <tr>
      <td colspan="2"><div align="center">
       <p><INPUT TYPE="submit"><INPUT TYPE="Reset"> </p> 
        </div></td>
    
  </table>
</form>

</body>
</html>

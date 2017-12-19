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
	<h2>REPORTE DE PEDIDO POR SU GARANTIA</h2>

	<br><br><br>
<?php
function fecha(){
$mes = date("n");
$mesArray = array(
1 => "Enero", 
2 => "Febrero", 
3 => "Marzo", 
4 => "Abril", 
5 => "Mayo", 
6 => "Junio", 
7 => "Julio", 
8 => "Agosto", 
9 => "Septiembre", 
10 => "Octubre", 
11 => "Noviembre", 
12 => "Diciembre"
);

$semana = date("D");
$semanaArray = array(
"Mon" => "Lunes", 
"Tue" => "Martes", 
"Wed" => "Miercoles", 
"Thu" => "Jueves", 
"Fri" => "Viernes", 
"Sat" => "Sábado", 
"Sun" => "Domingo", 
);

$mesReturn = $mesArray[$mes];
$semanaReturn = $semanaArray[$semana];
$dia = date("d");
$año = date ("Y");

return $semanaReturn." ".$dia." de ".$mesReturn." de ".$año;


}
 ?>



<form name="fcalen" action="pedido_actual.php"  method="GET">
<table width="429" border="0" align="center" cellspacing="1">
    <tr>
      <td width="216"><p>Fecha  Inicial de la Garantia<input name="txtFechainicio" value""><a href="javascript:show_calendar('fcalen.txtFechainicio');"onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="../imagenes/calendario.gif" width="23" height="15" border=0></a>
      <td width="204"><p>Fecha Actual</p>
       <?echo fecha()?></p>
     
    
      </tr>
    <tr>
      <td colspan="2"><div align="center">
       <p><INPUT TYPE="submit"><INPUT TYPE="Reset"> </p> 
        </div></td>
    
  </table>
</form>

</body>
</html>

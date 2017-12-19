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
	<?php
   

?>
	<td colspan="4"><div align="center">
	<h4>REPORTE DE GESTIÓN MENSUAL DE COMPONENTES Y EQUIPOS EN GARANTIA</h4>

		
	<h2>BUSQUEDA DE COMPONENTES</h2>
    <form name="fcalen" action="componente.php"  method="GET">
    
    <table width="380" border="2" align="center" cellspacing="4">
   
   
      <td width="300"><p>INTRODUCE EL SERIAL<input name="txtserial">
      <td colspan="2"><div align="center">
       <p><INPUT TYPE="submit"><INPUT TYPE="Reset"> </p> 
        </div></td>
        
         </table>
         </form>
         
         <td colspan="2"><div align="center">
	     <td><H2>BUSQUEDA DE EQUIPO</H2></td>

	<form name="fconfiguracion" action="configuracion.php"  method="GET">
     
	
	
	
	
	
	<table width="380" border="2" align="center" cellspacing="4">
      <tr>
     
      <td width="300"><p>INTRODUCE LA CONFIGURACION<input name="txtconfiguracion">
      <td colspan="2"><div align="center">
      <p><INPUT TYPE="submit"><INPUT TYPE="Reset">  
      </table></div></td></p>
     
    </tr>
    <tr>
    

    

</body>
</html>

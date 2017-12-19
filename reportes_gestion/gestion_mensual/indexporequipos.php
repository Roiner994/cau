<?php
require_once ("./formularios.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Gestión Mensual CAU</title>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<script language="javascript" type="text/javascript"src="date-picker.js"></script>
</head>

<body>
<div id="contenedor">
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>	
	<div id="cuerpo">
	<h2>REPORTE DE PEDIDO POR EQUIPOS</h2>

	<br><br><br>
<form name="frmPedido" action="detalleequipo.php"  method="GET">
<td colspan="2"><div align="center">
  <?php 
 
$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";    
$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_GET[selPedido]","","",$conPedido,"--TODOS--","");
$selPedido=$pedido->retornar();
echo $selPedido;

   ?>
       <td colspan="2"><div align="center">
       <p><INPUT TYPE="submit"><INPUT TYPE="Reset"> </p> 
        </div></td>
	
</form>

</body>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>
<body>

<?php
require_once("conexionsql.php");
$consulta="select id_departamento,departamento as cantidad FROM vistamantenimientospreventivos" ;
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
	<h1>REPORTES DEL SISTEMA DE MANTENIMIENTOS PREVENTIVOS</h1>
	<dl class="ddMenuPrincipal">
	<dt><a href="gestion_mensual/index.php">REPORTE DE GESTION MENSUAL</a></dt>
     <dd>MUESTRA POR FECHA LOS EQUIPOS QUE SE LE HIZO MANTENIMIENTO</dd>
     <dt><a href="gestion_mensual/INDEXPEDIDOS.php">REPORTE DE PEDIDOS</a></dt>
     <dd>MUESTRA  LOS PEDIDOS CON SUS COMPONENTES</dd>
     <dt><a href="gestion_mensual/indexporequipos.php">REPORTE DE PEDIDOS </a></dt>
     <dd>MUESTRA  LOS PEDIDOS CON SUS EQUIPOS</dd>
     <dt><a href="gestion_mensual/pedidogeneralgarantia.php"><td colspan="2"><div align="center">
     </div></td>REPORTE DE PEDIDOS EN GARANTIA</a></dt>
     <dd>MUESTRA LOS EQUIPOS EN GARANTIA</dd>
     <dt><a href="gestion_mensual/pedido_ingresado.php">REPORTE DE PEDIDOS INGRESADO AL SISTEMA</a></dt>
     <dd>MUESTRA  PEDIDOS INGRESADO AL SISTEMA</dd>
	  <dt><a href="gestion_mensual/indexcomponente.php">REPORTE DE COMPONENTES EN GARANTIA</a></dt>
     <dd>MUESTRA  LOS COMPONENTES POR SERIAL O EQUIPOS QUE AUN ESTA EN  GARANTIA</dd>
     <dt><a href="gestion_mensual/proveedor.php">REPORTE DE PEDIDOS DE EQUIPOS POR PROVEEDORES</a></dt>
     <dd>MUESTRA LOS EQUIPOS INGRESADOS POR PROVEEDOR</dd>
     <dt><a href="gestion_mensual/proveedorcomponente.php">REPORTE DE PEDIDOS DE COMPONENTES POR PROVEEDORES</a></dt>
     <dd>MUESTRA LOS COMPONENTE INGRESADOS POR PROVEEDOR</dd>
     </dl>
     
     <td colspan="2"><div align="center">
	<a href="../index.php">SISTEMA CAU</a></p> 
	</div>
</div>
</body>
</html>










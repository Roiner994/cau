<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>

<?php
require_once("..\mantenimiento\mantAdmin.php");
require_once("../conexionsql.php");

//$_GET[txtFechaInicio]=substr($_GET[txtFechaInicio],6,6)."-".substr($_GET[txtFechaInicio],3,2)."-".substr($_GET[txtFechaInicio],0,2);
//$_GET[txtFechaFinal]=substr($_GET[txtFechaFinal],6,6)."-".substr($_GET[txtFechaFinal],3,2)."-".substr($_GET[txtFechaFinal],0,2);
$conGerencia="select  ID_DESCRIPCION,PROVEEDOR,DESCRIPCION,
count(*)total,ID_PEDIDO, FECHA_FINAL, FECHA_INICIO 
from vistapedidos where   FECHA_FINAL > curdate()   group by id_pedido,id_descripcion";
//$consulta= "select id_gerencia,gerencia, count(*)as  from vistamantenimientospreventivos where ID_GERENCIA='$_GET[idGerencia]'";
//echo $conGerencia;
conectarMysql();
   //envia la consulta a la bd
   $resultGerencia=@mysql_query($conGerencia);
  // $result=mysql_query(($consulta));
    //Se especifican las variables a usar por el paginador
	//cantidad de resultados por página (opcional, por defecto 20)

	//$_pagi_propagar=array("fecha_inicio","fecha_final");
	$_pagi_sql = $conGerencia;
	//$_pagi_conteo_alternativo = true;
	
//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 15;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("id_pedido","id_descripcion");//No importa si son POST o GET

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea

//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
require_once("../paginator.inc.php");
	
	?>
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
<div id="cuerpo">		
<h2> COMPONENTES Y  EQUIPOS EN  GARANTIA</h2>
<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		<table align=center border=1 cellpadding=0 cellspacing=0 borercolor width=900>
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>
		<th></th>
		
		<th>ID_PEDIDO</th>
	   	<th>PROVEEDOR</th>
		<th>DESCRIPCION</th>
		<th>INICIO DE GARANTIA</th>
		<th> FINAL DE GARANTIA</th>
		<th>CANTIDAD</th>
	   	
		</tr>
		</thead>
		<tbody>
	
		
<?php 
	
//paginacion('$_pagi_nav_siguiente,	$_pagi_conteo,$_pagi_sql,$_pagi_propagar,$_pagi_navegacion');
unset($total);
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){


	?>
<tr>

   <td> <a href="detallegarantia.php?IDPEDIDO=<?=$rowGerencia[ID_PEDIDO]?>&iddescripcion=<?=$rowGerencia[ID_DESCRIPCION]?>"><img src="../imagenes/lupas.jpg" width="23" height="15"border="0"> </a></td>
    <td><?=$rowGerencia[ID_PEDIDO]?></td>
     <td><?=$rowGerencia[PROVEEDOR]?></td>
   <td><?=$rowGerencia[DESCRIPCION]?></td>
    <td><?=$rowGerencia[FECHA_INICIO]?></td>
    <td><?=$rowGerencia[FECHA_FINAL]?></td>
	<td><?=$rowGerencia[3]?></td>
		
		   </tr>
<?php
$total=$total+$rowGerencia[3];
		
}
}
?>

		</tr>
		</tfoot>
<td class="foottotal" colspan="6">TOTAL</td>
		<td><?=$total?></td>
<?php
//}
//}
?>

		</tr>
		</tfoot>

</tbody>
</table>
</div>
</div>

  </div>
       </div>
</body>
</html>

<p class="paginador"><?=$_pagi_navegacion?></p>
	<p class="reporteNavegacion">
	<a href="javascript:history.back()">REGRESAR</a>|
	<a href="../index.php">REPORTES</a></p> 
	<p class="reportePagiInfo">Resultados <?=$_pagi_info?></p>
	<p class="reporteExportar">
    <a href="pedidograntiaexcel.php?iddescripcion=<?=$rowGerencia[0]?>&amp;id_descripcion">FORMATO EXCEL</a></p>
	<body>
<td colspan="2"><div align="center">
<form action="" method="get"> 

<input type="button" name="imprimir" value="Imprimir"  onClick="window.print();"/>
</form>

</body>
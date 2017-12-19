
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>

<?php
require_once("../conexionsql.php");
require_once("..\mantenimiento\mantAdmin.php");
$conGerencia="select DESCRIPCION,id_pedido, count(*)as CANTIDAD, date_format(fecha_inicio,'%m/%d/%y') as Fecha from vistacomponentes where id_pedido='$_GET[Pedido]'GROUP BY DESCRIPCION ";
echo $conGerencia;
conectarMysql();
$resultGerencia=@mysql_query($conGerencia);
//$result=@mysql_query($consulta);
//echo $consulta;
   //cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 5;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("selPedido");//No importa si son POST o GET

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea 
$_pagi_propagar=array("id_pedido","Pedido");
	$_pagi_sql = $conGerencia;
	$_pagi_conteo_alternativo = true;
	$_pagi_cuantos = 10;
	
  $_pagi_sql = $conGerencia;
  
include("../paginator.inc.php");	
  ?>
	
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
<div id="cuerpo">		
<h5><center>PEDIDO CON GARANTIA </h5></center>

<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		<table class="tabla" width="50%"%"%" border="1";">
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>
		<th>DESCRIPCION</th>
		<th>TOTAL</th>
		
	    </tr>
		</thead>
		</tbody>
 <?php	
	}
	?>
	
			
<?php  
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){
			//paginacion('$_pagi_nav_siguiente,	$_pagi_conteo,$_pagi_sql,$_pagi_propagar,$_pagi_navegacion');
?>
<tr>
<a href='detallegarantia.php?Pedido=<?=$_GET[Pedido]?>&amp;id_pedido'">
		  <td><?=$rowGerencia[DESCRIPCION]?></td>
		  <td><?=$rowGerencia[CANTIDAD]?></td>
</a>
		  </tr>

<?php
}

?>

</tbody>
</table>
</div>
</div>


	<p class="paginador"><?=$_pagi_navegacion?></p>
	<p class="reporteNavegacion">
	<a href="javascript:history.back()">REGRESAR</a>|
	<a href="../index.php">REPOTES</a></p> 
    <p class="reportePagiInfo">Resultados <?=$_pagi_info?></p>
    <p class="reporteExportar">    
    <a href="cuadroexcel.php?id_pedido=<?=$rowGerencia[0]?>&amp;Pedido">FORMATO EXCEL</a></p>
    
	     </div>
       </div>
</body>
</html>
	


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




$_GET[txtFechaInicio]=substr($_GET[txtFechaInicio],6,6)."-".substr($_GET[txtFechaInicio],3,2)."-".substr($_GET[txtFechaInicio],0,2);
$_GET[txtFechaFinal]=substr($_GET[txtFechaFinal],6,6)."-".substr($_GET[txtFechaFinal],3,2)."-".substr($_GET[txtFechaFinal],0,2);
$conGerencia="select id_gerencia, GERENCIA,  
count(*) as CANTIDAD,date_format(fecha_inicio,'%d/%m/%Y') as Inicio, 
date_format(fecha_final,'%d/%m/%Y') as fecha_final,id_mantenimiento 
 from vistamantenimientospreventivos 
 where FECHA_INICIO  between '$_GET[txtFechaInicio]' and '$_GET[txtFechaFinal]'
   group by id_gerencia  ORDER BY CANTIDAD";
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
$_pagi_cuantos = 20;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("idgerencia","txtFechaInicio","txtFechaFinal");//No importa si son POST o GET

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
<h2>MANTENIMIENTOS PREVENTIVOS </h2>
<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		<table align="center" border="1" cellpadding="0" cellspacing="0" borercolor width="700">
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>
	   <th></th>
	     <th>FECHA INICIO</th>
		<th>FECHA FINAL</th>
	   <th>GERENCIA</th>
	     <th>CANTIDAD</th>
	  	
	    
		</tr>
		</thead>
		<tbody>
	
		
<?php 
	if ($resultGerencia &&mysql_num_rows($resultGerencia)>0){ 	
	}	                                   

	else 
 echo "NO HAY RESULTADO PARA LA BUSQUEDA";
//paginacion('$_pagi_nav_siguiente,	$_pagi_conteo,$_pagi_sql,$_pagi_propagar,$_pagi_navegacion');
unset($total);
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){


	?>
<tr>

    <td><a href="cuadro.php?idgerencia=<?=$rowGerencia[0]?>&txtFechaInicio=<?=$_GET[txtFechaInicio]?>&txtFechaFinal=<?=$_GET[txtFechaFinal]?>&amp;gerencia"><img src="../imagenes/lupas.jpg" width="23" height="15" border="0"></a></td>

    <td><?=$rowGerencia[Inicio]?></td>
	 <td><?=$rowGerencia[fecha_final]?></td>
    <td><?=$rowGerencia[GERENCIA]?></td>
	 <td><?=$rowGerencia[CANTIDAD]?></td>
	 

		  
		   </tr>

<?php
$total=$total+$rowGerencia[CANTIDAD];
		
}
}
?>

		</tr>
		</tfoot>
<td class="foottotal" colspan="4">TOTAL</td>
		<td><?=$total?></td>
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
	<a href="index.php">REGRESAR</a> |
	<a href="../index.php">REPORTES</a></p> 
     <p class="reportePagiInfo">Resultados <?=$_pagi_info?></p>
	<p class="reporteExportar">
	<a href="reportegeneralexcel.php?idgerencia=<?=$rowGerencia[0]?>&txtFechaInicio=<?=$_GET[txtFechaInicio]?>&txtFechaFinal=<?=$_GET[txtFechaFinal]?>&amp;gerencia">FORMATO EXCEL</a></p>
	<td colspan="2"><div align="center">
<form action="" method="get"> 

<input type="button" name="imprimir" value="Imprimir"  onClick="window.print();"/>
</form>

</body>
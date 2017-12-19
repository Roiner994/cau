
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>ASIGNACIONES DE EQUIPOS A&Ntilde;O 2006</title>
</head>
<body>

<?php
require_once("../conexionsql.php");
conectarMysql();
switch ($_GET[orden]) {
	case 'sitio':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by sitio $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by sitio $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by sitio $_GET[modo]";
				$_GET[modo]="asc";
				
		}
		
	break 1;
	case 'total':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by total $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by total $_GET[modo]";
				$_GET[modo]="asc";
				break 1;                                                                                                
			default:
				$Orden="order by total $_GET[modo]";
				$_GET[modo]="asc";
		}
		break 1;
	case 'microcomputador':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by microcomputador $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by microcomputador $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by microcomputador $_GET[modo]";
				$_GET[modo]="asc";
		}
		break 1;
		
	case 'impresora':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by impresora $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by impresora $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by impresora $_GET[modo]";
				$_GET[modo]="asc";
		}
		break 1;
		
	case 'laptop':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by laptop $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by laptop $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by laptop $_GET[modo]";
				$_GET[modo]="asc";
		}
		break 1;		
}

  $_pagi_sql = "select id_gerencia, ID_SITIO,SITIO,
		count(if(id_descripcion='DES0000001',descripcion,null)) as MICROCOMPUTADOR,
		count(if(id_descripcion='DES0000042',descripcion,null)) as LAPTOP,
		count(if(id_descripcion='DES0000008',descripcion,null)) as IMPRESORA,
		count(*)  as TOTAL 
		from vistainventarioequipos 
		where id_descripcion in ('DES0000001','DES0000008','DES0000042') AND 
		ID_ESTADO='EST0000001' AND 
		ID_SITIO NOT IN ('SIT0000057','SIT0000073') 
		group by id_sitio 
		$Orden";

	
	
//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 50;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = false;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("idSitio");//No importa si son POST o GET

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
<div id="contenedor">
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>	
	<div id="cuerpo">
	<h1>INVENTARIO DE EQUIPOS INFORM&Aacute;TICOS EN CVG VENALUM</h1>
	<?php
	if ($_pagi_result && mysql_numrows($_pagi_result)>0) { ?>
		<table class="tablaGerencia" width="50%" border="1">
		<caption>CANTIDAD DE EQUIPOS INSTALADOS EN CVG VENALUM EN EL A&Ntilde;O 2006</caption>
		<thead>
		<tr>
		<th><a href="ventana.php?orden=sitio&modo=<?=$_GET[modo]?>">EDIFICIO</a></th>
		<th><a href="ventana.php?orden=microcomputador&modo=<?=$_GET[modo]?>">MICROCOMPUTADORES</a></th>
		<th><a href="ventana.php?orden=laptop&modo=<?=$_GET[modo]?>">LAPTOP</a></th>
		<th><a href="ventana.php?orden=impresora&modo=<?=$_GET[modo]?>">IMPRESORAS</a></th>
		<th><a href="ventana.php?orden= total&modo=<?=$_GET[modo]?>">TOTAL</a></th>
		</tr>
		</thead>
		<tbody>
	<?php
		while ($row=mysql_fetch_array($_pagi_result)) {
			$i++;
			if ($i%2==0) {?>
				<tr>
			<?php
			} 
			else { ?>
			<tr class="odd">					
			<?php
			} ?>
			<td onclick="location.href='ventana2.php?idSitio=<?=$row[0]?>'"><?=$row[1]?></td>
			<td onclick="location.href='ventana2.php?idSitio=<?=$row[0]?>&idDescripcion=DES0000001'"><?=$row[2]?></td>
			<td onclick="location.href='ventana2.php?idSitio=<?=$row[0]?>&idDescripcion=DES0000042'"><?=$row[3]?></td>
			<td onclick="location.href='ventana2.php?idSitio=<?=$row[0]?>&idDescripcion=DES0000008'"><?=$row[4]?></td>
			<td onclick="location.href='ventana2.php?idSitio=<?=$row[0]?>'"><?=$row[5]?></td>
			</tr>
		<?php 
		} ?>
	</ul>
	<?php
	
	}
mysql_close();	
	?>
	</tbody>
	</table>
	<p class="paginador"><?=$_pagi_navegacion?></p>
	<p class="reporteNavegacion">
	<a href="index.php">REGRESAR</a> |
	<a href="index.php">REPOTES DE INVENTARIO</a></p> 
	<p class="reporteExportar">
	<a href="equiposInstaladosExcel.php">FORMATO EXCEL</a></p>
	</div>
</div>
</body>
</html>
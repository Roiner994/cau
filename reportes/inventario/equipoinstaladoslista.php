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
	//ordenar por configuracion
	case 'configuracion':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by configuracion $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by configuracion $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by configuracion $_GET[modo]";
				$_GET[modo]="asc";
				
		}
		break 1;
	//ordenar por descripcion
	case 'descripcion':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by descripcion $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by descripcion $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by descripcion $_GET[modo]";
				$_GET[modo]="asc";
				
		}
		break 1;
	//ordenar por marca
	case 'marca':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by marca $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by marca $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by marca $_GET[modo]";
				$_GET[modo]="asc";
				
		}
		break 1;
	//ordenar por modelo
	case 'modelo':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by modelo $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by modelo $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by modelo $_GET[modo]";
				$_GET[modo]="asc";
				
		}
		break 1;
	//ordenar por serial
	case 'modelo':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by serial $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by serial $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by serial $_GET[modo]";
				$_GET[modo]="asc";
				
		}
		break 1;
	//ordenar por gerencia
	case 'modelo':
		switch ($_GET[modo]) {
			case 'asc':
				$Orden="order by gerencia $_GET[modo]";
				$_GET[modo]="desc";
				break 1;
			case 'desc':
				$Orden="order by gerencia $_GET[modo]";
				$_GET[modo]="asc";
				break 1;
			default:
				$Orden="order by gerencia $_GET[modo]";
				$_GET[modo]="asc";
		}
		break 1;
		
}


	$_pagi_sql = "select configuracion,descripcion,marca,concat(modelo,' ',cap_vel,' ',unidad) as modelo,serial,gerencia 
		from vistainventarioequipos 
		where id_descripcion in ('DES0000001','DES0000008','DES0000042') AND 
		ID_ESTADO='EST0000001' AND 
		ID_SITIO NOT IN ('SIT0000057','SIT0000073') 
		$Orden";
	
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
$_pagi_propagar = array("txtConfiguracion","txtSerial","txtActivoFijo","sitio","idGerencia","idDescripcion","idMarca",
"idModelo","idPedido","idEstado","red","critico","usuarioEspecializado","txtFicha","fechaInicio","fechaFinal","ordenado","ordentipo");//No importa si son POST o GET

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
		<table class="tablaGerencia" width="80%" border="1">
		<caption>CANTIDAD DE EQUIPOS INSTALADOS EN CVG VENALUM EN EL A&Ntilde;O 2006</caption>
		<thead>
		<tr>
		<th><a href="equipoinstaladoslista.php?orden=configuracion&modo=<?=$_GET[modo]?>">CONFIGURACION</a></th>
		<th><a href="equipoinstaladoslista.php?orden=descripcion&modo=<?=$_GET[modo]?>">DESCRIPCION</a></th>
		<th><a href="equipoinstaladoslista.php?orden=marca&modo=<?=$_GET[modo]?>">MARCA</a></th>
		<th><a href="equipoinstaladoslista.php?orden=modelo&modo=<?=$_GET[modo]?>">MODELO</a></th>
		<th><a href="equipoinstaladoslista.php?orden=serial&modo=<?=$_GET[modo]?>">SERIAL</a></th>
		<th><a href="equipoinstaladoslista.php?orden=gerencia&modo=<?=$_GET[modo]?>">GERENCIA</a></th>
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
			<tr>					
			<?php
			} ?>
			<td><?=$row[0]?></td>
			<td><?=$row[1]?></td>
			<td><?=$row[2]?></td>
			<td><?=$row[3]?></td>
			<td><?=$row[4]?></td>
			<td><?=$row[5]?></td>
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
	<p class="exportar"><a href="equiposInstaladosExcel.php">EXCEL</a></p>
	</div>
</div>
</body>
</html>
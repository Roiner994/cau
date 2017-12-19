
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>
<body>
<div id="container">
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
<?php

require_once("../conexionsql.php");
require_once("..\mantenimiento\mantAdmin.php");
$conGerencia="select division,departamento,cargo,critico, OBSERVACION,trabajo_realizado,USUARIO_ESPECIALIZADO,concat(nombre,apellido) as TECNICO,sitio,activo_fijo, id_mantenimiento,configuracion,FICHA, concat(nombre_usuario, ' ', apellido_usuario) as USUARIO, MODELO,EXTENSION, SITIO, id_gerencia,gerencia,descripcion,date_format(fecha_inicio,'%d/%m/%y')as Fecha,serial,MARCA from vistamantenimientospreventivos where ID_MANTENIMIENTO= '$_GET[idmantenimiento]'";
echo $conGerencia;
conectarMysql();
$resultGerencia=@mysql_query($conGerencia);
//$result=@mysql_query($consulta);
//echo $consulta;
    
$_pagi_propagar=array("fecha_inicio","fecha_final");
	$_pagi_sql = $conGerencia;
	$_pagi_conteo_alternativo = true;
	$_pagi_cuantos = 10;
	
  $_pagi_sql = $conGerencia;
  
include("../paginator.inc.php");	
  ?>
	
	

	</div>
<div id="cuerpo">		
<h1>MANTENIMIENTOS PREVENTIVOS DETALLADOS A&Ntilde;O 2006</h1>

<?php

	/*if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>
		
	    </tr>
		</thead>
		</tbody>
 <?php	
	}
	?>
	*/
			
 
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){
			//paginacion('$_pagi_nav_siguiente,	$_pagi_conteo,$_pagi_sql,$_pagi_propagar,$_pa
}
?>


<div id="mantDetalle">
<p class="mantParrafo"><strong>ID_MANTENIMIENTO:</strong> <?=$row[0]?><br>
<strong>FECHA:</strong> <?=substr($row[33],0,10)?></p>
<dl>
<dt><strong>USUARIO</strong></dt>
<dd><strong>FICHA:</strong> <?=$row[18]?>.</dd>
<dd class="odd"><strong>NOMBRE:</strong> <?=$row[19]?>.</dd>
<dd><strong>APELLIDO:</strong> <?=$row[20]?>.</dd>
<dd class="odd"><strong>CARGO:</strong> <?=$row[23]?>.</dd>
<dd><strong>EXTENSI&Oacute;N:</strong> <?=$row[21]?>.</dd>

<dt><strong>UBICACI&Oacute;N DEL EQUIPO EN EL MOMENTO QUE SE REALIZ&Oacute; EL MANTENIMIENTO PREVENTIVO</strong></dt>
<dd><strong>GERENCIA:</strong> <?=$row[25]?>.</dd>
<?php 
if ($row[24]!=$row[26]) { ?>
	<dd class="odd"><strong>DIVISI&Oacute;N</strong> <?=$row[27]?>.</dd>
<?php 
}

?>

<?php 
if ($row[26]!=$row[28]) { ?>
	<dd><strong>DEPARTAMENTO:</strong> <?=$row[29]?>.</dd>
<?php 
}
?>


<dd class="odd"><strong>EDIFICIO:</strong> <?=$row[31]?></dd>
	
<dt><strong>EQUIPO AL QUE SE LE HIZO MANTENIMIENTO PREVENTIVO</strong></dt>
<dd><strong>CONFIGURACI&Oacute;N:</strong> <?=$row[1]?></dd>
<dd class="odd"><strong>DESCRIPCI&Oacute;N:</strong> <?=$row[8]?></dd>
<dd><strong>MARCA:</strong> <?=$row[10]?></dd>
<dd class="odd"><strong>MODELO:</strong> <?=$row[12]?> <?=$row[13]?> <?=$row[14]?></dd>
<dd><strong>SERIAL:</strong> <?=$row[6]?></dd>

<dt><strong>TRABAJO REALIZADO</strong></dt>
<dd><?=strtoupper($row[38])?></dd>


<dt><strong>OBSERVACIONES</strong></dt>
<?php
if ($row[39]!=null || !empty($row[39])) {?>
	<dd><?=strtoupper($row[39])?></dd>
	<?php } else { ?>
	<dd>NO SE REALIZÓ NINGUNA OBSERVACI&Oacute;N</dd>
	<?php 
	}
	?>
<dt><strong>T&Eacute;CNICO QUE REALIZO EL MANTENIMIENTO</strong></dt>
<dd><?=$row[16]?> <?=$row[17]?></dd>

</dl>
</div>
<?php
//mysql_close($conexion);
?>
</div>
</div>
</body>
</html>
	<p class="reporteNavegacion">
	<a href="index">Pagina Principal</a> 
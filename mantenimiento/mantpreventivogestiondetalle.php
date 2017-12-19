<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="estilomantenimiento.css">
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
require_once("conexionsql.php");
require_once("mantAdmin.php");

$consulta="select * from vistamantenimientospreventivos where id_mantenimiento='$_GET[idMantenimiento]' and ID_SITIO<>'SIT0000057'";
conectarMysql();
$result=mysql_query($consulta);
mysql_close();

if ($result && mysql_numrows($result)>0) {
	$row=mysql_fetch_array($result); ?>
<div id="cuerpo">
<h1>MANTENIMIENTOS PREVENTIVOS A&Ntilde;O 2006</h1>
<h2>DETALLE DEL MANTEMIENTO PREVENTIVO HECHO AL EQUIPO <?=$row[1]?></h2>
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
}
?>
</div>
</div>
</body>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>

<?php
require_once("../conexionsql.php");
$registros = 1;
if (!$pagina) { 
   $inicio = 0; 
   $pagina = 1; 
} 
else { 
   $inicio = ($pagina - 1) * $registros; 
} 
 $total_registros = @mysql_num_rows($result);
require_once("..\mantenimiento\mantAdmin.php");
$conGerencia="select ID_MANTENIMIENTO, 
date_format(fecha_inicio,'%m/%d/%y') as Fecha,
division,departamento,cargo,critico, observacion,
trabajo_realizado,USUARIO_ESPECIALIZADO,concat(nombre,apellido) as TECNICO,
activo_fijo, id_mantenimiento,configuracion,
concat(descripcion,' ',marca, ' ',modelo,' ',modelo,'',cap_vel,'',unidad)as EQUIPO,
FICHA, concat(nombre_usuario, ' ', apellido_usuario)AS NOMBRE , 
MODELO,EXTENSION, SITIO, descripcion,
date_format(FECHA_INICIO,'%d/%m/%y')as Fecha,serial,
marca,id_gerencia,gerencia from vistamantenimientospreventivos 
where ID_GERENCIA='$_GET[idGerencia]'and FECHA_INICIO  between '$_GET[txtFechaInicio]' 
and '$_GET[txtFechaFinal]' ";
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
	
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
<div id="cuerpo">		
<h1>MANTENIMIENTOS PREVENTIVOS DETALLADOS A&Ntilde;O 2006</h1>
<div id="mantDetalle">
<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		
	
 <?php	
	}
	?>
<?php
			
 
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){
			//paginacion('$_pagi_nav_siguiente,	$_pagi_conteo,$_pagi_sql,$_pagi_propagar,$_pagi_navegacion');
?>
<tr>
<p class="mantParrafo"><strong>ID_MANTENIMIENTO:</strong><?=$rowGerencia[ID_MANTENIMIENTO]?> 
<strong>FECHA:</strong></dd><?=$rowGerencia[FECHA]?></p>
	
<b><dt><strong>USUARIO</strong></dt>
<dd><strong>NOMBRE</dd>:</strong><?=$rowGerencia[NOMBRE]?>
<dd><strong>FICHA:</strong></dd><?=$rowGerencia[FICHA]?>
<dd><strong>CARGO:</strong></dd><?=$rowGerencia[CARGO]?>
<dd><strong>EXTENSION:</strong></dd><?=$rowGerencia[EXTENSION]?>
<dd><strong>USUARIO ESPECIALIZADO:</strong></dd><?=$rowGerencia[USUARIO_ESPECIALIZADO]?>
		
		
        <b><dt><strong>DATOS DEL EQUIPO</strong></dt>
		<dd><strong>SERIAL:</strong><?=$rowGerencia[SERIAL]?></dd>
		<dd><strong>DESCRIPCION:</strong><?=$rowGerencia[DESCRIPCION]?>
		<dd><strong>ACTIVO FIJO:</strong><?=$rowGerencia[ACTIVO_FIJO]?>
		<dd><strong>CRITICO:</strong><?=$rowGerencia[CRITICO]?>
				
							
		<b><dt><strong>UBICACION</strong>
		<dd><strong>SITIO:</strong><?=$rowGerencia[SITIO]?>
		<dd><strong>GERENCIA:</strong><?=$rowGerencia[GERENCIA]?>
		<dd><strong>DIVISION:</strong><?=$rowGerencia[DIVISION]?>
		<dd><strong>DEPARTAMENTO:</strong><?=$rowGerencia[DEPARTAMENTO]?>
		
	
		<b><dt><strong>DATOS DEL MANTENIMIENTO</strong>
		<dd><strong>CONFIGURACION:</dd></strong><?=$rowGerencia[CONFIGURACION]?><br>
		<dd><strong>TECNICO:</strong><?=$rowGerencia[TECNICO]?>
		<dd><strong>TRABAJO RELIZADO:</strong><?=$rowGerencia[TRABAJO_REALIZADO]?>
		<dd><strong>OBSERVACION:</strong><?=$rowGerencia[OBSERVACION]?><?if ($rowGerencia[OBSERVACION]!=null || !empty($rowGerencia[OBSERVACION])) {?>
			<?=strtoupper($row[OBSERVACION])?>
	   <?php } else {?>
	   	NO SE REALIZÓ NINGUNA OBSERVACI&Oacute;N
		
	<?php 
	}
	?>
		  

<?php
}

?>

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
	<a href="../index.php">REPOTES</a></p> 
    <p class="reportePagiInfo">Resultados <?=$_pagi_info?></p>
	

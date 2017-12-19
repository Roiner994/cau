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
<div id="cuerpo">		
<h5><center>MANTENIMIENTO PREVENTIVO DETALLADO </center></h5>
<div id="mantDetalle">
<?php
require_once("../conexionsql.php");
require_once("..\mantenimiento\mantAdmin.php");

$registros = 1;
if (!$pagina) { 
   $inicio = 0; 
   $pagina = 1; 
} 
else { 
   $inicio = ($pagina - 1) * $registros; 
} 
 $total_registros = @mysql_num_rows($result);
 $total_paginas = ceil($total_registros / $registros);   
//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 1;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 2;//Elegí un número pequeño para que se note el resultad


$conGerencia="select Gerencia, if (critico=0,'NO','SI')as CRITICO,  date_format(fecha_inicio,'%d/%m/%Y') as Fecha,division,departamento,cargo, observacion,trabajo_realizado,if (USUARIO_ESPECIALIZADO=0,'NO','SI') AS USUARIO_ESPECIALIZADO,concat(nombre,apellido) as TECNICO,activo_fijo, id_mantenimiento,configuracion,concat(descripcion,' ',marca, ' ',modelo,' ',modelo,'',cap_vel,'',unidad)as EQUIPO,FICHA, concat(nombre_usuario, ' ', apellido_usuario)AS NOMBRE , MODELO,EXTENSION, SITIO, descripcion,serial,marca from vistamantenimientospreventivos where id_mantenimiento= '$_GET[idmantenimiento]' ";
//$consulta="select * from vistamantenimientospreventivos where id_mantenimiento='$_GET[idMantenimiento]'";
//ho "<br>$conGerencia<br>";
conectarMysql();
$resultGerencia=@mysql_query($conGerencia);
//$result=@mysql_query($consulta);
//echo $consulta;
    

$_pagi_sql = $conGerencia;
//cantidad de resultados por página (opcional, por defecto 20)


require_once("../paginator.inc.php");

?>
	
<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
	<?php
		}
	?>
	
	
			
<?php 
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){

?>
<tr>
<p class="mantParrafo"><strong>ID_MANTENIMIENTO:</strong><?=$rowGerencia[ID_MANTENIMIENTO]?> 
<strong>FECHA:</strong></dd><?=$rowGerencia[Fecha]?></p>
<dt><strong>USUARIO</strong></dt>
<dd><strong>NOMBRE</dd>: </strong><?=$rowGerencia[NOMBRE]?>
<dd><strong>FICHA: </strong></dd><?=$rowGerencia[FICHA]?>
<dd><strong>CARGO: </strong></dd><?=$rowGerencia[CARGO]?>
<dd><strong>EXTENSION: </strong></dd><?=$rowGerencia[EXTENSION]?>
<dd><strong>USUARIO ESPECIALIZADO: </strong></dd><?=$rowGerencia[USUARIO_ESPECIALIZADO]?>
			

<dt><strong>DATOS DEL EQUIPO</strong></dt>
		<dd><strong>SERIAL: </strong><?=$rowGerencia[SERIAL]?></dd>
		<dd><strong>DESCRIPCION: </strong><?=$rowGerencia[DESCRIPCION]?>
		<dd><strong>ACTIVO FIJO: </strong><?=$rowGerencia[ACTIVO_FIJO]?>
		<dd><strong>CRITICO: </strong><?=$rowGerencia[CRITICO]?>
				
							
<dt><strong>UBICACION</strong>
		<dd><strong>SITIO:</strong><?=$rowGerencia[SITIO]?>
		<dd><strong>GERENCIA:  </strong><?=$rowGerencia[GERENCIA]?>
		<dd><strong>DIVISION:  </strong><?=$rowGerencia[DIVISION]?>
		<dd><strong>DEPARTAMENTO:  </strong><?=$rowGerencia[DEPARTAMENTO]?>
		
	
<dt><strong>DATOS DEL MANTENIMIENTO</strong>
		<dd><strong>CONFIGURACION:  </dd></strong><?=$rowGerencia[CONFIGURACION]?><br>
		<dd><strong>TECNICO:  </strong><?=$rowGerencia[TECNICO]?>
		<dd><strong>TRABAJO RELIZADO: </strong><?=$rowGerencia[TRABAJO_REALIZADO]?>
		<dd><strong>OBSERVACION:  </strong><?=$rowGerencia[OBSERVACION]?><?if ($rowGerencia[OBSERVACION]!=null || !empty($rowGerencia[OBSERVACION])) {?>
			<?=strtoupper($row[OBSERVACION])?>
	   <?php } else {?>
	   	NO SE REALIZÓ NINGUNA OBSERVACI&Oacute;N
  </tr>

  
  
  
<?php
}
}
//}



/*
for ($i=1; $i<=$total_paginas; $i++) {
   if ($pagina == $i) 
      echo "<b>".$pagina."</b> "; */


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
	<a href="javascript:history.back()">REGRESAR</a>|
	<a href="../index.php">REPORTES</a></p> 
	<td colspan="2"><div align="center">
<form action="" method="get"> 

<input type="button" name="imprimir" value="Imprimir"  onClick="window.print();"/>
</form>

</body>
   
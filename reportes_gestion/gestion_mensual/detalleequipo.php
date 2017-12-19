<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>



</html>
<?php
require_once("..\mantenimiento\mantAdmin.php");
require_once("../conexionsql.php");

//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 30;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 5;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("selPedido","id_pedido");//No importa si son POST o GET

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea
if ($_GET[selPedido]==100) {

 $_GET[selPedido]= "";

}
$conGerencia="select id_descripcion,descripcion,ID_PEDIDO, proveedor,date_format(FECHA_INICIO,'%d/%m/%Y') as Inicio from vistainventarioequipos  where id_pedido like '%$_GET[selPedido]%' group by id_pedido ";

//echo $conGerencia;


conectarMysql();
   //envia la consulta a la bd
   $resultGerencia=@mysql_query($conGerencia);
  
	$_pagi_sql =$conGerencia;
	//$_pagi_conteo_alternativo = true;
 
//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente

require_once("../paginator.inc.php");
	
  
	?>
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
</div>
<div id="cuerpo">		
<h2>REPORTES DE PEDIDOS POR EQUIPOS</h2>
<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		<table align=center border=1 cellpadding=0 cellspacing=0 borercolor width="50%"%"%">
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>
		<th></th>
		<th>FECHA DE INGRESO DEL PEDIDO</th>
		<th>IDPEDIDO</th>
	   
		
		</tr>
		</thead>
		<tbody>
	
		
<?php 
	if ($resultGerencia &&mysql_num_rows($resultGerencia)>0){ 	
	}	                                   

	else 
 echo "NO HAY RESULTADO PARA LA BUSQUEDA";
	while ($rowGerencia=@mysql_fetch_array($_pagi_result )){



	
 ?>
<tr>
	
<td><a href='detalle_equipos.php?selPedido=<?=$rowGerencia[ID_PEDIDO]?>&amp;ID_PEDIDO'><img src="../imagenes/lupas.jpg" width="23" height="15"style=border:0></a></td>
<td><?=$rowGerencia[Inicio]?></td>

<td><?=$rowGerencia[ID_PEDIDO]?></td>


   
</tr>
</a>

<?php

	}
	}	
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

<body>

</body>

<p class="paginador"><?=$_pagi_navegacion?></p>
	<p class="reporteNavegacion">
	<a href="javascript:history.back()">REGRESAR</a>|
	<a href="../index.php">REPORTES</a></p> 
    <p class="reportePagiInfo">Resultados <?=$_pagi_info?></p>
     <p class="reporteExportar">
	<a href="detallequipoexcel.php?selPedido=<?=$_GET[selPedido]?>&amp;id_pedido">FORMATO EXCEL</a></p>
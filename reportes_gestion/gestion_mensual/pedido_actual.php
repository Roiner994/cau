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

//$_GET[txtFechainicio]=substr($_GET[txtFechainicio],6,6)."-".substr($_GET[txtFechainicio],3,2)."-".substr($_GET[txtFechainicio],0,2);
//$_GET[txtFechaActual]=substr($_GET[txtFechaActual],6,6)."-".substr($_GET[txtFechaActual],3,2)."-".substr($_GET[txtFechaActual],0,2);
$conGerencia="select ID_PEDIDO, PROVEEDOR,descripcion_descripcion, count(*) as CANTIDAD,fecha_inicio, FECHA_FINAL  from vistagarantia where '$_GET[txtFechainicio]' >= $_GET[txtFechaActual] group by  id_pedido";




//$consulta= "select id_gerencia,gerencia, count(*)as  from vistamantenimientospreventivos where ID_GERENCIA='$_GET[idGerencia]'";
echo $conGerencia;
conectarMysql();
   //envia la consulta a la bd
   $resultGerencia=@mysql_query($conGerencia);
  // $result=mysql_query(($consulta));
    //Se especifican las variables a usar por el paginador
	//cantidad de resultados por p�gina (opcional, por defecto 20)

	//$_pagi_propagar=array("fecha_inicio","fecha_final");
	$_pagi_sql = $conGerencia;
	//$_pagi_conteo_alternativo = true;
	
//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 15;//Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 30;//Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que s�lo nos interesa propagar estas dos variables
$_pagi_propagar = array("txtFechainicio","txtFechaActual");//No importa si son POST o GET

//Definimos qu� estilo CSS se utilizar� para los enlaces de paginaci�n.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qu� ir� en el enlace a la p�gina anterior
$_pagi_nav_anterior = "&lt;";// podr�a ir un tag <img> o lo que sea

//definimos qu� ir� en el enlace a la p�gina siguiente
$_pagi_nav_siguiente = "&gt;";// podr�a ir un tag <img> o lo que sea

//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
require_once("../paginator.inc.php");
	
	?>
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>
<div id="cuerpo">		
<h1><center>REPORTE DE PEDIDOS POR GARANTIA</h1></center>
<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		<table align=center border=1 cellpadding=0 cellspacing=0 borercolor width=700>
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>
	   	<th>ID_PEDIDO</th>
		<th>DESCRIPCION</th>
		<th>proveedor</th>
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
  <a href='formulario.php?idpedido=<?=$rowGerencia[0]?>&amp;id_pedido'">
  
     <td><?=$rowGerencia[ID_PEDIDO]?></td>
	 <td><?=$rowGerencia[descripcion_descripcion]?></td>
	   <td><?=$rowGerencia[PROVEEDOR]?></td>
	 <td><?=$rowGerencia[CANTIDAD]?></td>

		  </a>
		   </tr>
<?php
$total=$total+$rowGerencia[CANTIDAD];		
}
}
?>

		</tr>
		</tfoot>
<td class="foottotal" colspan="3">TOTAL</td>
		<td><?=$total?></td>


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
	<a href="../index.php">REPOTES</a></p> 
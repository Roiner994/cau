<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>

 


<?php

if( isset($_GET['txtserial']) ) { //primero se cheka si se posteo algo
    if( (empty($_GET['txtserial'])) )  { //Aki es donde empty cheka si $nombre o $nick estan vacios o no            
?>
    	<html>
       	<HEAD>
    	<TITLE></TITLE>
    	</HEAD>
    	<BODY>
     	   <h2>FALTAN DATOS</h2>
    	<form action="" method="get"> 
			<center><input type="button" name="imprimir" value="Regresar"  onClick="javascript:history.back()"/></center>
		</form>
			

    	</BODY>
    	</html>
    	
    	
<?php
    	exit(); //Manda msg de error si es TRUE osea si el espacio era vacio
        }
}
?>

 
  <?php 
require_once("..\mantenimiento\mantAdmin.php");
require_once("../conexionsql.php");
/*$_GET[txtFechaInicio]=substr($_GET[txtFechaInicio],6,6)."-".substr($_GET[txtFechaInicio],3,2)."-".substr($_GET[txtFechaInicio],0,2);
$_GET[txtFechaFinal]=substr($_GET[txtFechaFinal],6,6)."-".substr($_GET[txtFechaFinal],3,2)."-".substr($_GET[txtFechaFinal],0,2);*/
//$conGerencia="select  SERIAL,ID_PEDIDO,MARCA,DESCRIPCION,fecha_final,date_format(fecha_inicio,'%d/%m/%Y') AS  INICIO, date_format(fecha_FINAL,'%d/%m/%Y') AS  FIN,proveedor from vistainventarioequipos
 //where serial like '%$_GET[txtserial]' and   FECHA_FINAL > curdate()"; 
$conGerencia="select configuracion, 
componente_id_pedido, equipo_marca,
componente_id_pedido, 
componente_serial,
componente_descripcion, 
componente_marca, 
componente_proveedor,
componente_fecha_inicio,
date_format(componente_fecha_inicio,'%d/%m/%Y')as Inicio,
date_format(componente_fecha_final,'%d/%m/%Y')as Fin
from vistacomponentesasociadosequiposgarantia 
where componente_serial like '%$_GET[txtserial]' 
and componente_fecha_final > curdate() group by componente_descripcion";

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
$_pagi_cuantos = 50;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("txtserial");//No importa si son POST o GET

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
		<br><br>
		</h1	

	></div>
<div id="cuerpo">
<h2>COMPONENTES EN GARANTIA </h2>		
<br><br>
<?php
	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0){
	}
		
		?>
	   <table align="center" border="10" cellpadding="0"  borercolor width="90">
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>

	  	<th>Inicio Garantia</th>
	  	<th>Componente</th>
	  	<th>Marca</th>
	  	<th>Serial</th>
	  	<th>Proveedor</th>
		<th>Id_pedido</th>
		<th>Final Garantia</th>
		
				</tr>
		</thead>
		<tbody>
	
		
<?php 
	if ($resultGerencia &&mysql_num_rows($resultGerencia)>0){ 	
	}	                                   

	else 
 echo "ESTE COMPONENTE NO ESTA EN GARANTIA";
//paginacion('$_pagi_nav_siguiente,	$_pagi_conteo,$_pagi_sql,$_pagi_propagar,$_pagi_navegacion');
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){
	?>

	<tr>

	
       
	<td><?=$rowGerencia[Inicio]?></td>
	
	<td><?=$rowGerencia[componente_descripcion]?></td>
	<td><?=$rowGerencia[componente_marca]?></td>
	<td><?=$rowGerencia[componente_serial]?></td>
	<td><?=$rowGerencia[componente_proveedor]?></td>
	<td><?=$rowGerencia[componente_id_pedido]?></td>
	<td><?=$rowGerencia[Fin]?></td>

		  
		   </tr>
		  

<?php
}

?>

		
		</tfoot>

</tbody>
</table>

</body>
</html>

<p class="paginador"><?=$_pagi_navegacion?></p>
	<p class="reporteNavegacion">
	<a href="javascript:history.back()">REGRESAR</a>|
	<a href="../index.php">REPORTES</a></p> 
    <p class="reportePagiInfo">Resultados <?=$_pagi_info?></p>
    

    <td colspan="2"><div align="center">
<form action="" method="get"> 
<input type="button" name="imprimir" value="Imprimir"  onClick="window.print();"/>
</form>

</body>
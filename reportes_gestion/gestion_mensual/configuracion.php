<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>
 <?php

if( isset($_GET['txtconfiguracion']) ) { //primero se cheka si se posteo algo
    if( (empty($_GET['txtconfiguracion'])) )  { //Aki es donde empty cheka si $nombre o $nick estan vacios o no            
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

 
$conGerencia="select id_pedido, descripcion, PROVEEDOR,date_format(fecha_inicio,'%d/%m/%Y') AS  INICIO, date_format(fecha_FINAL,'%d/%m/%Y') AS  FIN from vistainventarioequipos
 where  configuracion like '$_GET[txtconfiguracion]%' and  FECHA_FINAL > curdate()group by descripcion"; 
//$consulta= "select id_gerencia,gerencia, count(*)as  from vistamantenimientospreventivos where ID_GERENCIA='$_GET[idGerencia]'";
//echo $conGerencia;

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
$_pagi_cuantos = 50;//Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 30;//Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que s�lo nos interesa propagar estas dos variables
$_pagi_propagar = array("iddescripcion");//No importa si son POST o GET

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
		</h1	

	></div>
<div id="cuerpo">		
<h2>EQUIPOS EN GARANTIA </h2>
<?php

	if  ($_pagi_result &&mysql_num_rows($_pagi_result)>0); { ?>	
		<table align=center border=1 cellpadding=0 cellspacing=0 borercolor width="1000">
		<caption><?=$rowGerencia[$conGerencia]?></caption>
		<thead>
		<tr>

	  	<th>INICIO GARANTIA</th>
		<th>PROVEEDOR</th>
		<th>DESCRIPCION</th>
		<th>ID_PEDIDO</th>
		<th>FINAL GARANTIA</th>
		</tr>
		</thead>
		<tbody>
	
		
<?php 
	if ($resultGerencia &&mysql_num_rows($resultGerencia)>0){ 	
	}	                                   

	else 
 echo "ESTE EQUIPO NO ESTA EN GARANTIA";

//paginacion('$_pagi_nav_siguiente,	$_pagi_conteo,$_pagi_sql,$_pagi_propagar,$_pagi_navegacion');
while ($rowGerencia=@mysql_fetch_array($_pagi_result)){
	?>

	<tr>

	 <td><?=$rowGerencia[INICIO]?></td>  
	<td><?=$rowGerencia[PROVEEDOR]?></td>
    <td><?=$rowGerencia[DESCRIPCION]?></td>
	<td><?=$rowGerencia[ID_PEDIDO]?></td>
	 <td><?=$rowGerencia[FIN]?></td>

		  
		   </tr>
		   

<?php
 


}
}
?>

		
		</tfoot>

</tbody>
</table>


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
</html>

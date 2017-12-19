
<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");
?>
<script language="javascript">
	
	
	
	
	function generarExcel(){						
			sitio=document.frmEquipo.sitio.value;			
			window.open('../librerias/rptMemoriaEdificiosExcel.php?sitio='+sitio);		
	}
	
	function generarReporte(){						
			sitio=document.frmEquipo.sitio.value;
			window.open('../librerias/rptResumenMemoriaEdificios.php?sitio='+sitio);		
	}
	
	function generarReporteExcel(){						
			sitio=document.frmEquipo.sitio.value;
			window.open('../librerias/rptMemoriaEdificiosExcelResumen.php?sitio='+sitio);		
	}
	function generarGrafico(){
		sitio=document.frmEquipo.sitio.value;
		window.open('../librerias/rptMemoriaEdificiosGrafico.php?sitio='+sitio);
	}
</script>

<?php 
	
	$annos=retornar_annos_preventivo("annos","annos", "formularioCampoSeleccion");
	$meses=retornar_select_meses("meses","meses","formularioCampoSeleccion");
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	$sitio= new campoSeleccion("sitio","formularioCampoSeleccion","$_POST[sitio]","","",$conSitio,"--TODOS--","");
	$sitio=$sitio->retornar();
	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
	
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">PREVENTIVO - REPORTE DE CAPACIDAD DE MEMORIA POR EDIFICIOS</td>
  				</tr>";
			echo "<tr>";
			//echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL A&Ntilde;O</td>
			//</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">EDIFICIO<br>$sitio<br>";
			echo "</tr>";		
			
			
			echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\">
			<input name=\"btnBuscar\" type=\"submit\" value=\"BUSCAR\">
			</td>
			</tr>";			
					echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarReporte();\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel();\">EXCEL </a> <a class=enlace href=\"#\" onclick=\"generarReporteExcel();\">| RESUMEN EXCEL |<a class=enlace href=\"#\" onclick=\"generarGrafico();\">GRAFICO |</a><br>		
		
		</tr>";
		echo "</table>";
		echo "</form>"		
?>


<div width="70%">


<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");	
	if(!isset($_POST['funcion'])&&!isset($_GET['meth']))
		exit(1);
	
	if(isset($_POST['funcion'])){
		$sitio=isset($_POST['sitio'])&&$_POST['sitio']!=100  ? " AND vistacomponentes.ID_SITIO='".$_POST['sitio']."'" : "";		
		unset($_GET);		
	}else	
	if(isset($_GET['meth'])){
		$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND vistacomponentes.ID_SITIO='".$_GET['sitio']."'" : "";		
	}
	 
	 
	
	
	
	conectarMysql();
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	$query="SELECT usuario_sistema.NOMBRE ,usuario_sistema.ID_USS
		FROM usuario_sistema,mantenimiento_preventivo
		WHERE usuario_sistema.ID_USS=mantenimiento_preventivo.ID_USS
		 $sitio $mes $anno
		GROUP BY usuario_sistema.ID_USS";		
		
		
		
	/*$query="SELECT modelo.CAP_VEL FROM 
inventario, modelo, sitio, inventario_ubicacion,equipo_componente_campo, inventario_propiedad, inventario_estado,usuario_sistema,componente_campo
WHERE modelo.ID_MODELO=inventario.ID_MODELO AND
inventario_ubicacion.ID_INVENTARIO=inventario.ID_INVENTARIO AND
componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_ubicacion.ID_SITIO=sitio.ID_SITIO AND
equipo_componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_propiedad.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_estado.ID_ESTADO=inventario_propiedad.ID_ESTADO AND
usuario_sistema.ID_USS=equipo_componente_campo.ID_USS AND
inventario_estado.ESTADO='OPERATIVO'  AND
inventario_ubicacion.STATUS_ACTUAL=1 AND
sitio.SITIO!='OTROS' AND
sitio.SITIO!='DEPOSITO' AND
modelo.ID_DESCRIPCION='DES0000010' $sitio  GROUP BY modelo.CAP_VEL";	
*/

$query="SELECT VISTACOMPONENTES.CAP_VEL
FROM VISTACOMPONENTES, VISTACOMPONENTESASOCIADOSEQUIPOS
WHERE VISTACOMPONENTES.STATUS_ACTUAL = 1 AND VISTACOMPONENTES.ESTADO = 'OPERATIVO' AND VISTACOMPONENTES.SITIO != 'OTROS' AND VISTACOMPONENTES.SITIO != 'DEPOSITO' AND VISTACOMPONENTES.ID_DESCRIPCION = 'DES0000010' AND VISTACOMPONENTESASOCIADOSEQUIPOS.ID_INVENTARIO = VISTACOMPONENTES.ID_INVENTARIO $sitio  
GROUP BY VISTACOMPONENTES.CAP_VEL";

	$rs=mysql_query($query);
	
	if($rs&&mysql_num_rows($rs)>0){
		$nt=mysql_num_rows($rs);
		
		while($row=mysql_fetch_array($rs)){			
			$tid[]=$row[0];					
							
		}
	}
	$tecnicos="";
	$lm=count($tid);
	$total=" ,0";
	
	for($i=0;$i!=$lm;$i++){
		$tecnicos.=" , COUNT(
					CASE (VISTACOMPONENTES.CAP_VEL)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)AS `$tid[$i]` ";
		$total.="+COUNT(
					CASE (VISTACOMPONENTES.CAP_VEL)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)";
	}
	//echo $query;
	if(!empty($tecnicos)){
/*	
	$query="SELECT equipo_componente_campo.CONFIGURACION AS CONFIGURACION ".$tecnicos."".$total."AS TOTAL".  
	"
	FROM 
inventario, modelo, sitio, inventario_ubicacion,equipo_componente_campo, inventario_propiedad, inventario_estado,usuario_sistema,componente_campo
WHERE modelo.ID_MODELO=inventario.ID_MODELO AND
inventario_ubicacion.ID_INVENTARIO=inventario.ID_INVENTARIO AND
componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_ubicacion.ID_SITIO=sitio.ID_SITIO AND
equipo_componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_propiedad.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_estado.ID_ESTADO=inventario_propiedad.ID_ESTADO AND
usuario_sistema.ID_USS=equipo_componente_campo.ID_USS AND
inventario_estado.ESTADO='OPERATIVO'  AND
inventario_ubicacion.STATUS_ACTUAL=1 AND
sitio.SITIO!='OTROS' AND
sitio.SITIO!='DEPOSITO' AND
modelo.ID_DESCRIPCION='DES0000010' $sitio  GROUP BY 	equipo_componente_campo.CONFIGURACION, equipo_componente_campo.ID_INVENTARIO";			
*/





$query="SELECT VISTACOMPONENTESASOCIADOSEQUIPOS.CONFIGURACION AS CONFIGURACION ".$tecnicos."".$total." AS TOTAL ".  
	"FROM VISTACOMPONENTES, VISTACOMPONENTESASOCIADOSEQUIPOS
WHERE VISTACOMPONENTES.STATUS_ACTUAL = 1 AND VISTACOMPONENTES.ESTADO = 'OPERATIVO' AND VISTACOMPONENTES.SITIO != 'OTROS' AND VISTACOMPONENTES.SITIO != 'DEPOSITO' AND VISTACOMPONENTES.ID_DESCRIPCION = 'DES0000010' AND VISTACOMPONENTESASOCIADOSEQUIPOS.ID_INVENTARIO = VISTACOMPONENTES.ID_INVENTARIO $sitio  
GROUP BY VISTACOMPONENTESASOCIADOSEQUIPOS.CONFIGURACION";


		set_time_limit(120);
		$neto="SELECT SUM(TOTAL) FROM ($query) as temporal";
		
		$rs=mysql_query($neto);
		if($rs){
			$row=mysql_fetch_array($rs);
			$neto=$row[0];
		}
		
		
		

		$query="SELECT * FROM ($query) as temporal";
		
		
		
		
		$anno=$_GET['anno'];		
		
		if (isset($_GET[ordenado]) && !empty($_GET[ordenado])){			
			$orden= " ORDER BY temporal.`$_GET[ordenado]` $_GET[ordentipo]";					
		}else {
			$orden="";
		}
		
		conectarMysql();
		
		$_pagi_sql=$query;
		$_pagi_sql.="".$orden;	
		
		//cantidad de resultados por página (opcional, por defecto 20)
		$_pagi_cuantos = 30;//Elegí un número pequeño para que se generen varias páginas
		
		//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
		$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

		//Decidimos si queremos que se muesten los errores de mysql
		$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

		//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
		//realizamos el conteo alternativo.
		$_pagi_conteo_alternativo = true;//recomendado false.	
		
		$_pagi_propagar = array("sitio","item","ordenado","ordentipo","meth");
		
		//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
		//El estilo debe estar definido previamente
		$_pagi_nav_estilo = "enlace";

		//definimos qué irá en el enlace a la página anterior
		$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea
		
		//definimos qué irá en el enlace a la página siguiente
		$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea	
		
		if(isset($_GET['meth'])){
			$sitio=$_GET['sitio'];		
		}
		else{
			$sitio=$_POST['sitio'];		
		}
		
		$_GET['meth']=1;
		$meth=1;
		if(!$_GET['_pagi_pg'])
			$_GET['_pagi_pg']=1;
		require_once("../paginador/paginator.inc.php");	
		
		
		
		$count = mysql_num_fields($_pagi_result);
		
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"$count\" align=\"center\">REPORTE DE CAPACIDAD DE MEMORIA POR EDIFICIOS</td>
		</tr>";

		for ($i = 0; $i < $count; $i++){
			$header = mysql_field_name($_pagi_result, $i);
			if ($_GET[ordenado]==$header && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=$header&ordentipo=asc\">$header</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=$header&ordentipo=desc\">$header</a></b></td>";			
			
		}
		
		while($row = mysql_fetch_array($_pagi_result)){
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			
			for ($j = 0; $j < $count; $j++)
				if($j!=$count-1)
				echo "<td align=\"left\">$row[$j]</td>";								
				else{
				echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('../librerias/detalleResumenMemoriaEdificios.php?configuracion=$row[0]&sitio=$sitio')\">$row[$j]</a>  </td>";				
				}
			echo "</tr>";
			$i++;			
		}
		
		if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
		}
		
		
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=".($count-1).">TOTAL</td>";
		echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('../librerias/detalleResumenMemoriaEdificios.php?sitio=$sitio')\">$neto</a>  </td>";						
		echo "</tr>"; 
		
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
		echo "</tr>";
		echo "</table>";
		echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
		mysql_close();			
		
	}
?>


</div>

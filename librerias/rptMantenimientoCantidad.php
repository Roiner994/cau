<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");
?>
<script language="javascript">
	
	
	
	
	function generarExcel(){			
			anno=document.frmEquipo.anno.value;
			mes=document.frmEquipo.mes.value;
			sitio=document.frmEquipo.sitio.value;			
			window.open('../librerias/rptMantenimientoCantidadExcel.php?anno='+anno+"&mes="+mes+"&sitio="+sitio);		
	}
	
	function generarReporte(){			
			anno=document.frmEquipo.anno.value;
			mes=document.frmEquipo.mes.value;								
			sitio=document.frmEquipo.sitio.value;
			window.open('../librerias/rptResumenMantenimientoCantidad.php?anno='+anno+"&mes="+mes+"&sitio="+sitio);		
	}
</script>

<?php 
	
	$annos=retornar_annos_preventivo("anno","anno", "formularioCampoSeleccion");
	$meses=retornar_select_meses("mes","mes","formularioCampoSeleccion");
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	$sitio= new campoSeleccion("sitio","formularioCampoSeleccion","$_POST[sitio]","","",$conSitio,"--TODOS--","");
	$sitio=$sitio->retornar();
	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
	
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">PREVENTIVO - REPORTE POR CANTIDAD DE MANTENIMIENTOS</td>
  				</tr>";
			echo "<tr>";
			//echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL A&Ntilde;O</td>
			//</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">EDIFICIO<br>$sitio<br>";
			echo "</tr>";
			
			
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">A&Ntilde;O<br>$annos<br>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">MESES<br>$meses<br>";
			echo "</tr>";		
			
			echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\">
			<input name=\"btnBuscar\" type=\"submit\" value=\"BUSCAR\">
			</td>
			</tr>";			
					echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarReporte();\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel();\">EXCEL</a><br>		
		
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
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");
	
	
	
	
	
	
	if(isset($_POST['funcion'])){
		$sitio=isset($_POST['sitio'])&&$_POST['sitio']!=100  ? " AND mantenimiento_preventivo.ID_SITIO='".$_POST['sitio']."'" : "";
	
		$mes=isset($_POST['mes'])&&$_POST['mes']!=100 ? " AND MONTH(mantenimiento_preventivo.fecha_inicio)=".$_POST['meses'] : "";	
	
		if(isset($_POST['anno']))
			$annp=$_POST['anno'];
		
		$anno=isset($_POST['anno'])&&$_POST['anno']!=100 ? "AND YEAR(mantenimiento_preventivo.fecha_inicio)=".$_POST['anno'] : "";	
		
		
		
		unset($_GET);
		
		
	}else	
	if(isset($_GET['meth'])){
		$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND mantenimiento_preventivo.ID_SITIO='".$_GET['sitio']."'" : "";
	
		$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(mantenimiento_preventivo.fecha_inicio)=".$_GET['mes'] : "";	
	
		if(isset($_GET['anno']))
			$annp=$_GET['anno'];
		
		$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(mantenimiento_preventivo.fecha_inicio)=".$_GET['anno'] : "";			
		
	}
	 
	
	
	
	conectarMysql();
	
	
	$query="SELECT SUM(TOTAL) FROM (SELECT mantenimiento_preventivo.CONFIGURACION, COUNT(mantenimiento_preventivo.CONFIGURACION) AS TOTAL, mantenimiento_preventivo.ID_MANTENIMIENTO 
		FROM mantenimiento_preventivo, sitio
		WHERE mantenimiento_preventivo.ID_SITIO=sitio.ID_SITIO $sitio $mes $anno
		GROUP BY mantenimiento_preventivo.CONFIGURACION) AS TEMPORAL";		
	//echo $query;	
	$rs=mysql_query($query);
	if($rs){
		$row=mysql_fetch_array($rs);
		$neto=$row[0];
	}
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	$query="SELECT * FROM (SELECT mantenimiento_preventivo.CONFIGURACION, COUNT(mantenimiento_preventivo.CONFIGURACION) AS TOTAL, mantenimiento_preventivo.ID_MANTENIMIENTO 
		FROM mantenimiento_preventivo, sitio
		WHERE mantenimiento_preventivo.ID_SITIO=sitio.ID_SITIO $sitio $mes $anno
		GROUP BY mantenimiento_preventivo.CONFIGURACION) AS TEMPORAL";			
		
		
	
		
	$rs=mysql_query($query);
	

		
		
		$sitio=$_GET['sitio'];
		$anno=$_GET['anno'];
		$mes=$_GET['mes'];
		
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
	
		$_pagi_propagar = array("mes","anno","sitio","item","ordenado","ordentipo","meth");
		
		//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
		//El estilo debe estar definido previamente
		$_pagi_nav_estilo = "enlace";

		//definimos qué irá en el enlace a la página anterior
		$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea
		
		//definimos qué irá en el enlace a la página siguiente
		$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea	
		
		
			
		
		if(isset($_GET['meth'])){
			$sitio=$_GET['sitio'];
			$mes=$_GET['mes'];
			$anno=$_GET['anno'];			
		}
		else{
			$sitio=$_POST['sitio'];
			$anno=$_POST['anno'];				
			$mes=$_POST['mes'];
		}
		
		$_GET['meth']=1;
		$meth=1;
		if(!$_GET['_pagi_pg'])
			$_GET['_pagi_pg']=1;
		
		
		require_once("../paginador/paginator.inc.php");	
		
		
		
		
		
		
		$count = mysql_num_fields($_pagi_result)-1	;
		
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"$count\" align=\"center\">REPORTE POR CANTIDAD DE MANTENIMIENTOS</td>
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
				echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('../librerias/detalleMantenimientoPreventivoCantidadExcel.php?mantenimiento=$row[0]&sitio=$sitio&mes=$mes&anno=$anno')\">$row[$j]</a>  </td>";				
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
		echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('../librerias/detalleMantenimientoPreventivoCantidadExcel.php?sitio=$sitio&mes=$mes&anno=$anno')\">$neto</a>  </td>";						
		echo "</tr>"; 
		
		
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
		echo "</tr>";
		echo "</table>";
		echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
		mysql_close();			
		
	
?>

</div>

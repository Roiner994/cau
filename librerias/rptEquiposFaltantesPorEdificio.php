<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");
?>
<script language="javascript">
	
	
	
	
	function generarExcel(){			
			anno=document.frmEquipo.anno.value;			
			sitio=document.frmEquipo.sitio.value;			
			window.open('../librerias/rptEquiposFaltantesPorEdificioExcel.php?anno='+anno+"&sitio="+sitio);		
	}
	
	function generarReporte(){			
			anno=document.frmEquipo.anno.value;			
			sitio=document.frmEquipo.sitio.value;
			window.open('../librerias/rptResumenEquiposFaltantesPorEdificio.php?anno='+anno+"&sitio="+sitio);		
	}
	
	function generarGrafico(){
			anno=document.frmEquipo.anno.value;			
			sitio=document.frmEquipo.sitio.value;
			window.open('../librerias/rptEquiposFaltantesPorEdificioGrafico.php?anno='+anno+"&sitio="+sitio);		
	}
</script>





<?php 

	
	

	
	$anno=retornar_annos_preventivo("anno","anno", "formularioCampoSeleccion","","",true);	
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_SITIO NOT IN ('SIT0000057','SIT0000092') ORDER BY SITIO";
	$sitio= new campoSeleccion("sitio","formularioCampoSeleccion","$_POST[sitio]","","",$conSitio,"--TODOS--","");
	$sitio=$sitio->retornar();
	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
	
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">PREVENTIVO - REPORTE DE EQUIPOS FALTANTES POR EDIFICIO</td>
  				</tr>";
			echo "<tr>";
			//echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL A&Ntilde;O</td>
			//</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">EDIFICIO<br>$sitio<br>";
			echo "</tr>";
			
			
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">A&Ntilde;O<br>$anno<br>";
			echo "</tr>";
			
			
			
			echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\">
			<input name=\"btnBuscar\" type=\"submit\" value=\"BUSCAR\">
			</td>
			</tr>";			
					echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarReporte();\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel();\">EXCEL</a> | <a class=enlace href=\"#\" onclick=\"generarGrafico();\"> GRAFICO </a> |<br>		
		
		</tr>";
		echo "</table>";
		echo "</form>";	
		
?>

	<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
	<div id="resultados" width="30%">
<?php  
	if(!isset($_POST['funcion'])&&!isset($_GET['meth']))
		exit(1);
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");	 
	
	
	
	if(isset($_POST[funcion])){
		$sitio=isset($_POST['sitio'])&&$_POST['sitio']!=100  ? " AND ID_SITIO='".$_POST['sitio']."'" : "";
	
		$mes=isset($_POST['mes'])&&$_GET['meses']!=100 ? " AND MONTH(fecha_inicio)=".$_POST['meses'] : "";	
	
		if(isset($_POST['anno']))
			$annp=$_POST['anno'];
		
		$anno=isset($_POST['anno'])&&$_POST['anno']!=100 ? "AND YEAR(fecha_inicio)=".$_POST['anno'] : "";
		unset($_GET);
		
	}else
	
	if(isset($_GET['meth'])){
		$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND ID_SITIO='".$_GET['sitio']."'" : "";
	
		$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(fecha_inicio)=".$_GET['mes'] : "";	
	
		if(isset($_GET['anno']))
			$annp=$_GET['anno'];
		
		$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(fecha_inicio)=".$_GET['anno'] : "";			
		
	}

	$sitio.=" AND ID_SITIO NOT IN ('SIT0000057','SIT0000092') AND ID_ESTADO='EST0000001'";
	
	//echo $sitio."**".$mes."-*".$anno;
	
	conectarMysql();
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	$query="SELECT descripcion FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) and 
	(configuracion not in (
							select configuracion from vistamantenimientospreventivos
							 WHERE TRUE $mes $anno
							 ))	
	 $sitio
	GROUP BY descripcion";	
	
	
	
	
	$rs=mysql_query($query) or die(mysql_error());
	
	if($rs&&mysql_num_rows($rs)>0){
		$nt=mysql_num_rows($rs);
		
		while($row=mysql_fetch_array($rs)){			
			$tid[]=$row[0];					
							
		}
	}else
	
	
	$tecnicos="";
	$lm=count($tid);
	$total=" ,0";
	
		
	for($i=0;$i!=$lm;$i++){
		$tecnicos.=" , COUNT(
					CASE (descripcion)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)AS `$tid[$i]` ";
		$total.="+COUNT(
					CASE (descripcion)
					WHEN '$tid[$i]' THEN 1                           
					END        
					)";
	}
	

	if(!empty($tecnicos)){
		$query="SELECT cantidad_mantenimientos_anual($annp)";
	$rs=mysql_query($query);
	if($rs){
		$row=mysql_fetch_array($rs);
		$cantidad=$row[0];
		$cantidad=(($cantidad+0)>4 ? 4: $cantidad);		
			
	}
		$query="SELECT ID_SITIO,SITIO ".$tecnicos."".$total."AS TOTAL".  
	"
	FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) and 
	(configuracion not in (
							select configuracion from vistamantenimientospreventivos AS vmp
							 WHERE TRUE $anno
							 
							  AND (($cantidad)>(cantidad_mantenimientos_anual_configuracion($annp,vmp.CONFIGURACION)))
							 ))	  
	 $sitio
	GROUP BY SITIO";	
		
	
		$query="SELECT * FROM ($query) as temporal";
		
		
		
		
		$anno=$_GET['anno'];		
		$mes=$_GET['mes'];		
		$sitio=$_GET['sitio'];		
		
		if (isset($_GET[ordenado]) && !empty($_GET[ordenado])){			
			$orden= " ORDER BY temporal.`$_GET[ordenado]` $_GET[ordentipo]";					
		}else {
			$orden="";
		}
		
		
		set_time_limit(45);
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
	
		$_pagi_propagar = array("anno","sitio","item","meth");
		
		//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
		//El estilo debe estar definido previamente
		$_pagi_nav_estilo = "enlace";

		//definimos qué irá en el enlace a la página anterior
		$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea
		
		//definimos qué irá en el enlace a la página siguiente
		$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea	
		
		
		
		if(isset($_GET['meth'])){
			$sitio=$_GET['sitio'];
			$anno=$_GET['anno'];			
		}
		else{
			$sitio=$_POST['sitio'];
			$anno=$_POST['anno'];				
		}
		
		$_GET['meth']=1;
		$meth=1;
		
		require_once("../paginador/paginator.inc.php");	
		
		
		
		
		
		
		$count = mysql_num_fields($_pagi_result);
		
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"$count\" align=\"center\">REPORTE DE EQUIPOS FALTANTES POR EDIFICIO</td>
		</tr>";

		for ($i = 1; $i < $count; $i++){
			$header = mysql_field_name($_pagi_result, $i);
			if ($_GET[ordenado]==$header && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace"."item=$_GET[item]&meth=1& ordenado=$header&ordentipo=asc\">$header</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace"."item=$_GET[item]&meth=1& ordenado=$header&ordentipo=desc\">$header</a></b></td>";			
			
		}
		$neto=0;
		while($row = mysql_fetch_array($_pagi_result)){
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			
			for ($j = 1; $j < $count; $j++)
				if($j!=$count-1)
				echo "<td align=\"left\">$row[$j]</td>";								
				else{
				echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('../librerias/detalleEquiposPendientesExcel.php?sitio=$row[0]&anno=$anno')\">$row[$j]</a>  </td>";
				$neto+=($row[$j]+0);
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
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=".($count-2).">TOTAL</td>";
		echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('../librerias/detalleEquiposPendientesExcel.php?sitio=$row[0]&anno=$anno&total=$neto')\">$neto</a> </td>";					
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


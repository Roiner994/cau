

<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");	 
	
	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND ID_SITIO='".$_GET['sitio']."'" : "";
	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(fecha_inicio)=".$_GET['mes'] : "";	
	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(fecha_inicio)=".$_GET['anno'] : "";
	
	conectarMysql();
	
	//se obtienen los tecnicos con mantenimientos en el periodo
	$query="SELECT descripcion FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) 	
	 $sitio
	GROUP BY descripcion";	
	
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
			$query="SELECT configuracion ".$tecnicos."".$total."AS TOTAL".  
	"
	FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) 							 
	  $sitio
	GROUP BY configuracion";	
		
	
		$query="SELECT * FROM ($query) as temporal";
		
		
		
		
		
		$sitio=$_GET['sitio'];		
		
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
	
		$_pagi_propagar = array("sitio","item");
		
		//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
		//El estilo debe estar definido previamente
		$_pagi_nav_estilo = "enlace";

		//definimos qué irá en el enlace a la página anterior
		$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea
		
		//definimos qué irá en el enlace a la página siguiente
		$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea	
		
		
		$neto="SELECT COUNT(*) FROM ($query) AS temporal";
		
		$rs=mysql_query($neto);
		if($rs){
			$row=mysql_fetch_array($rs);
			$neto=$row[0];
		}
		
		
		require_once("../paginador/paginator.inc.php");	
		
		$sitio=$_GET['sitio'];		
		
		$count = mysql_num_fields($_pagi_result);
		
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"$count\" align=\"center\">REPORTE DE INVENTARIO INICIAL</td>
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
				echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detalleInventarioInicialExcel.php?configuracion=$row[0]&anno=$anno')\">$row[$j]</a>  </td>";				
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
		echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detalleInventarioInicialExcel.php?configuracion=$row[0]&anno=$anno&sitio=$sitio')\">$neto</a>  </td>";				
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
		echo "</tr>";
		echo "</table>";
		echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
		mysql_close();			
		
	}
?>

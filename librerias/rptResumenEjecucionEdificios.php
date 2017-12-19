

<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");	 
	
	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND sitio.ID_SITIO='".$_GET['sitio']."'" : "";
	
	if(!empty($_GET['inicial'])){
				$fecha1=split("/",$_GET['inicial']);
				$fecha1=$fecha1[2]."-".$fecha1[1]."-".$fecha1[0];
				$fecha1=" AND DATE(mantenimiento_preventivo.HORA_INICIO) >= '$fecha1'";
			}
	if(!empty($_GET['final'])){
				$fecha2=split("/",$_GET['final']);
				$fecha2=$fecha2[2]."-".$fecha2[1]."-".$fecha2[0];
				$fecha2=" AND DATE(mantenimiento_preventivo.HORA_INICIO) <= '$fecha2'";
		}
	
	conectarMysql();
	
	
		$query="SELECT * FROM(Select			
			equipo_campo.CONFIGURACION,
			
			
			
			descripcion.DESCRIPCION,
			
			
			
			marca.MARCA,
			

			
			CONCAT(modelo.MODELO,' ',modelo.CAP_VEL,' ',modelo.UNIDAD) AS MODELO	,
			
			
			detalle_mantenimiento_preventivo.ERROR_PLANILLA,
			detalle_mantenimiento_preventivo.PLANILLA_ASIGNACION_MANTENIMIENTO,
			detalle_mantenimiento_preventivo.OBSERVACIONES,
			
			
			COUNT(equipo_campo.CONFIGURACION) AS TOTAL,
			mantenimiento_preventivo.ID_MANTENIMIENTO
			

			From
			equipo_campo		
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_ubicacion ON inventario_ubicacion.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			Inner Join mantenimiento_preventivo ON (equipo_campo.CONFIGURACION=mantenimiento_preventivo.CONFIGURACION AND mantenimiento_preventivo.ID_SITIO=sitio.ID_SITIO)						
			Inner Join detalle_mantenimiento_preventivo ON (detalle_mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO=mantenimiento_preventivo.ID_MANTENIMIENTO)			
			Where
			inventario_ubicacion.STATUS_ACTUAL = '1' ".$fecha1."".$fecha2.
			" $sitio 
			and mantenimiento_preventivo.STATUS_MANTENIMIENTO='2'
			and mantenimiento_preventivo.HORA_INICIO IN (SELECT MAX(mp.HORA_INICIO) FROM mantenimiento_preventivo as mp WHERE mp.CONFIGURACION=equipo_campo.CONFIGURACION)
			and descripcion.id_descripcion in ('DES0000001','DES0000008','DES0000042')
			GROUP BY equipo_campo.CONFIGURACION 			
			order by descripcion.descripcion, equipo_campo.configuracion
			
			)
			 AS temporal";
		
		
		$neto="SELECT SUM(TOTAL) FROM ($query) as temporal ";
		$rs=mysql_query($neto);
		if($rs){
			$row=mysql_fetch_array($rs);
			$neto=$row[0];
		}
		
		
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
	
		$_pagi_propagar = array("sitio","inicial","final");
		
		//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
		//El estilo debe estar definido previamente
		$_pagi_nav_estilo = "enlace";

		//definimos qué irá en el enlace a la página anterior
		$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea
		
		//definimos qué irá en el enlace a la página siguiente
		$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea	
		
		
		
		require_once("../paginador/paginator.inc.php");	
		
		$sitio=$_GET['sitio'];		
		
		$count = mysql_num_fields($_pagi_result)-1;
		
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
					echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detalleEjecucionEdificiosExcel.php?sitio=$sitio&inicial=$_GET[inicial]&final=$_GET[final]&configuracion=$row[0]')\">$row[$j]</a>  </td>";
				}			
			echo "</tr>";
			$i++;
			
		}
		
		echo "<tr>";
			echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=".($count-1).">TOTAL</td>";
			echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detalleEjecucionEdificiosExcel.php?sitio=$sitio&inicial=$_GET[inicial]&final=$_GET[final]')\">$neto</a>  </td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
		echo "</tr>";
		echo "</table>";
		echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
		mysql_close();			
		
	
?>

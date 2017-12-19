<?php
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once ("inventarioAdmin.php");
?>
<script language="javascript">
	
	
	
	
	function generarExcel(){			
			anno=document.frmEquipo.anno.value;
			meses=document.frmEquipo.mes.value;
			sitio=document.frmEquipo.sitio.value;			
			gerencia=document.frmEquipo.gerencia.value;			
			window.open('../librerias/rptPuntosPendienteExcel.php?anno='+anno+"&mes="+meses+"&sitio="+sitio+"&gerencia="+gerencia);					
	}
	
	
	
	function generarExcelResumido(){			
			anno=document.frmEquipo.anno.value;
			meses=document.frmEquipo.mes.value;
			sitio=document.frmEquipo.sitio.value;			
			gerencia=document.frmEquipo.gerencia.value;			
			window.open('../librerias/rptPuntosPendienteResumidoExcel.php?anno='+anno+"&mes="+meses+"&sitio="+sitio+"&gerencia="+gerencia);					
	}
	
	function generarReporte(){			
			anno=document.frmEquipo.anno.value;
			meses=document.frmEquipo.mes.value;								
			sitio=document.frmEquipo.sitio.value;
			window.open('../librerias/rptResumenPreventivoDetallado.php?anno='+anno+"&mes="+meses+"&sitio="+sitio);		
	}
</script>

<?php 
	
	$annos=retornar_annos_preventivo("anno","anno", "formularioCampoSeleccion");
	$meses=retornar_select_meses("mes","mes","formularioCampoSeleccion");
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	$sitio= new campoSeleccion("sitio","formularioCampoSeleccion","$_POST[sitio]","","",$conSitio,"--TODOS--","");
	$sitio=$sitio->retornar();
	$conGerencia="SELECT ID_GERENCIA,GERENCIA FROM gerencia";
	$gerencia=new campoSeleccion("gerencia","formularioCampoSeleccion","$_POST[gerencia]","","",$conGerencia,"--TODOS--","");
	$gerencia=$gerencia->retornar();
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
	
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - REPORTE DE PUNTOS PENDIENTES</td>
  				</tr>";
			echo "<tr>";
			//echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">SELECCIONE EL A&Ntilde;O</td>
			//</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">EDIFICIO<br>$sitio<br>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">GERENCIA<br>$gerencia<br>";
			echo "</tr>";
			
			
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">A&Ntilde;O<br>$annos<br>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">MESES<br>$meses<br>";
			echo "</tr>";		
			
			
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
			<a class=enlace href=\"#\" onclick=\"generarExcelResumido();\"> RESUMEN MENSUAL </a> | <a class=enlace href=\"#\" onclick=\"generarExcel();\"> GENERAL </a><br>				
			</tr>";
			
			/*
			 echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\">
			<input name=\"btnBuscar\" type=\"submit\" value=\"GENERAR\" onclick='generarExcel();'>
			</td>
			</tr>";			
			
			
					echo "<tr>";
		echo "<td class=\"formularioTablaBotones\" colspan=\"2\">GENERAR REPORTE |
		<a class=enlace href=\"#\" onclick=\"generarReporte();\">HTML</a> | <a class=enlace href=\"#\" onclick=\"generarExcel();\">EXCEL</a><br>		
		
		</tr>";*/
		echo "</table>";
		echo "</form>"		
?>


<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
	require_once("formularios.php");
	require_once("mantenimientoAdmin.php");
	require_once("conexionsql.php");
	
	$campos="SITIO";
	$suma="";
	
		
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? " WHERE ANNO=".$_GET['anno'] : "";
	if ($_GET['mes']==100){
		$campos.=", ENERO,FEBRERO,MARZO,ABRIL,MAYO,JUNIO,JULIO,AGOSTO,SEPTIEMBRE,OCTUBRE,NOVIEMBRE,DICIEMBRE ";
		$suma.=", ENERO+FEBRERO+MARZO+ABRIL+MAYO+JUNIO+JULIO+AGOSTO+SEPTIEMBRE+OCTUBRE+NOVIEMBRE+DICIEMBRE AS TOTAL";
	}else{
				switch($_GET['mes']){
			case "1":
					$campos.=", ENERO ";
					$suma=" ,ENERO";
					break 1;
			case "2":
					$campos.=", FEBRERO ";
					$suma=", FEBRERO ";
					break 1;
			case "3":
					$campos.=", MARZO ";
					$suma=", MARZO ";
					break 1;
			case "4":
					$campos.=", ABRIL ";
					$suma=", ABRIL ";
					break 1;
			case "5":
					$campos.=", MAYO ";
					$suma=", MAYO ";
					break 1;
			case "6":
					$campos.=", JUNIO ";
					$suma.=", JUNIO ";;
					break 1;
			case "7":
					$campos.=", JULIO ";
					$suma==", JULIO ";
					break 1;
			case "8":
					$campos.=", AGOSTO ";
					$suma=", AGOSTO ";
					break 1;
			case "9":
					$campos.=", SEPTIEMBRE ";
					$suma=", SEPTIEMBRE ";
					break 1;					
			case "10":
					$campos.=", OCTUBRE ";
					$suma=", OCTUBRE ";;
					break 1;
			case "11":
					$campos.=", NOVIEMBRE ";
					$suma=", NOVIEMBRE ";
					break 1;					
			case "12":
					$campos.=", DICIEMBRE ";
					$suma=", DICIEMBRE ";
					break 1;						
		}
		$suma=" ".$suma." AS TOTAL ";
	}
	
	$vistaNOINTRUSIVA="(SELECT  sitio.SITIO,    
        
        COUNT(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 1 THEN 1                           
            END        
        )AS ENERO,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 2 THEN 1           
                ELSE 0
            END        
        )AS FEBRERO,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 3 THEN 1           
                ELSE 0
            END        
        )AS MARZO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 4 THEN 1           
                ELSE 0
            END        
        )AS ABRIL,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 5 THEN 1           
                ELSE 0
            END        
        )AS MAYO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 6 THEN 1           
                ELSE 0
            END        
        )AS JUNIO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 7 THEN 1           
                ELSE 0
            END        
        )AS JULIO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 8 THEN 1           
                ELSE 0
            END        
        )AS AGOSTO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 9 THEN 1           
                ELSE 0
            END        
        )AS SEPTIEMBRE,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 10 THEN 1           
                ELSE 0
            END        
        )AS OCTUBRE,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 11 THEN 1           
                ELSE 0
            END        
        )AS NOVIEMBRE,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 12 THEN 1           
                ELSE 0
            END        
        )AS DICIEMBRE,
        YEAR(DATE(mantenimiento_preventivo.HORA_INICIO)) AS ANNO,
        sitio.ID_SITIO AS ID_SITIO
        
        

	FROM sitio, mantenimiento_preventivo
	WHERE sitio.ID_SITIO=mantenimiento_preventivo.ID_SITIO
	GROUP BY sitio.SITIO".(empty($anno)? "": ",YEAR(DATE(mantenimiento_preventivo.HORA_INICIO))").
	
	
	"
	) temporal ";

	$query="SELECT $campos $suma , ID_SITIO FROM $vistaNOINTRUSIVA $anno";
	
	$anno=$_GET['anno'];
	
	conectarMysql();
	$neto="SELECT SUM(TOTAL) FROM ($query) as temporal";
	$rs=mysql_query($neto);
	if($rs){
		$row=mysql_fetch_array($rs);
		$neto=$row[0];
	}
	
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])){
		if($_GET['mes']!=100&&$_GET['ordenado']!="TOTAL")
		$orden= " ORDER BY temporal.$_GET[ordenado] $_GET[ordentipo]";		
		else
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
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
	
	$_pagi_propagar = array("mes","anno");
	
	//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
	//El estilo debe estar definido previamente
	$_pagi_nav_estilo = "enlace";

	//definimos qué irá en el enlace a la página anterior
	$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

	//definimos qué irá en el enlace a la página siguiente
	$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea
	
	require_once("../paginador/paginator.inc.php");
	
	if($_GET['mes']!=100){
		$mes=valor_mes($_GET['mes']);
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"3\" align=\"center\">REPORTE GLOBAL DE MANTENIMIENTO</td>
		</tr>";
		
		if ($_GET[ordenado]=='SITIO' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=SITIO&ordentipo=asc\">SITIO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=SITIO&ordentipo=desc\">SITIO</a></b></td>";
		
		if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=$mes&ordentipo=asc\">$mes</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=$mes&ordentipo=desc\">$mes</a></b></td>";
		
		
		if ($_GET[ordenado]=='TOTAL' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=$mes&ordentipo=asc\">TOTAL</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=$mes&ordentipo=desc\">TOTAL</a></b></td>";
		
		
		while($row = mysql_fetch_array($_pagi_result)){
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\">$row[0]</td>";	
			echo "<td align=\"left\">$row[1]</td>";	
			echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detallePreventivoGlobal.php?meses=$mes_value&anno=$anno&sitio=$row[3]')\">$row[2]</a>  </td>";	
			echo "</tr>";
			$i++;
			
		}
		
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=2>TOTAL</td>";
		echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detallePreventivoGlobal.php?mes=$_GET[mes]&anno=$anno')\">$neto</a>  </td>";						
		echo "</tr>"; 
	
	echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
	mysql_close();	
	}else{
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"14\" align=\"center\">REPORTE GLOBAL DE MANTENIMIENTOS</td>
		</tr>";
		
		if ($_GET[ordenado]=='SITIO' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=SITIO&ordentipo=asc\">SITIO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=SITIO&ordentipo=desc\">SITIO</a></b></td>";
		
		if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ENERO&ordentipo=asc\">ENERO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ENERO&ordentipo=desc\">ENERO</a></b></td>";
		
		
		if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=FEBRERO&ordentipo=asc\">FEBERO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=FEBRERO&ordentipo=desc\">FEBERO</a></b></td>";
			
		if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=MARZO&ordentipo=asc\">MARZO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=MARZO&ordentipo=desc\">MARZO</a></b></td>";
			
		if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ABRIL&ordentipo=asc\">ABRIL</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ABRIL&ordentipo=desc\">ABRIL</a></b></td>";
			
		if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=MAYO&ordentipo=asc\">MAYO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=MAYO&ordentipo=desc\">MAYO</a></b></td>";
			
		if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=JUNIO&ordentipo=asc\">JUNIO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=JUNIO&ordentipo=desc\">JUNIO</a></b></td>";
			
			if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=JULIO&ordentipo=asc\">JULIO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=JULIO&ordentipo=desc\">JULIO</a></b></td>";
			
			if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=AGOSTO&ordentipo=asc\">AGOSTO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=AGOSTO&ordentipo=desc\">AGOSTO</a></b></td>";
			
			if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=SEPTIEMBRE&ordentipo=asc\">SEPIEMBRE</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=SEPTIEMBRE&ordentipo=desc\">SEPTIEMBRE</a></b></td>";
			
			if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=OCTUBRE&ordentipo=asc\">OCTUBRE</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=OCTUBRE&ordentipo=desc\">OCTUBRE</a></b></td>";
			
			
			if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=NOVIEMBRE&ordentipo=asc\">NOVIEMBRE</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=NOVIEMBRE&ordentipo=desc\">NOVIEMBRE</a></b></td>";
			
			if ($_GET[ordenado]=='$mes' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=DICIEMBRE&ordentipo=asc\">DICIEMBRE</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=DICIEMBRE&ordentipo=desc\">DICIEMBRE</a></b></td>";
			
			
		
		if ($_GET[ordenado]=='TOTAL' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=TOTAL&ordentipo=asc\">TOTAL</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=TOTAL&ordentipo=desc\">TOTAL</a></b></td>";
		
		
		while($row = mysql_fetch_array($_pagi_result)){
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\">$row[0]</td>";	
			echo "<td align=\"left\">$row[1]</td>";	
			echo "<td align=\"left\">$row[2]</td>";	
			echo "<td align=\"left\">$row[3]</td>";	
			echo "<td align=\"left\">$row[4]</td>";	
			echo "<td align=\"left\">$row[5]</td>";	
			echo "<td align=\"left\">$row[6]</td>";	
			echo "<td align=\"left\">$row[7]</td>";	
			echo "<td align=\"left\">$row[8]</td>";	
			echo "<td align=\"left\">$row[9]</td>";	
			echo "<td align=\"left\">$row[10]</td>";	
			echo "<td align=\"left\">$row[11]</td>";	
			echo "<td align=\"left\">$row[12]</td>";	
			echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detallePreventivoGlobal.php?sitio=$row[14]&mes=$mes&anno=$anno')\">$row[13]</a>  </td>";		
			
			
			
			if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
			}
			//detallePreventivoDetallado.php			

			
			echo "</tr>";
			
			
			
			$i++;
			
		}
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=13>TOTAL</td>";
		echo "<td align=\"left\"> <a class=enlace href=\"#\" onclick=\"window.open('detallePreventivoGlobal.php?mes=$mes&anno=$anno')\">$neto</a>  </td>";						
		echo "</tr>"; 
	
	echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
	mysql_close();	
		
	}
	
	?>

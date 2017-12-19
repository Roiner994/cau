<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php

require_once("conexionsql.php");


 	if ($_GET[sitio]==100)
		$_GET[sitio]="";

	if ($_GET[gerencia]==100)
		$_GET[gerencia]="";

	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";

	if ($_GET[idMarca]==100)
		$_GET[idMarca]="";

	if ($_GET[idModelo]==100)	
		$_GET[idModelo]="";
	
	
     conectarMysql();


	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistaInventarioEquipos.EQUIPO_FECHA_CREACION Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
    if (isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
			$conFicha=" AND (FICHA like '%$_GET[txtFicha]' OR NOMBRE_USUARIO like '%$_GET[txtFicha]%' OR APELLIDO_USUARIO like '%$_GET[txtFicha]%')  ";
		} 
     
	$_pagi_sql = "SELECT * FROM vistaInventarioEquipos 
        where
		$rangoFecha
		SERIAL LIKE '%$_GET[txtSerial]' AND
		ID_SITIO  Like '%$_GET[sitio]' AND
    	ID_GERENCIA Like '%$_GET[gerencia]' AND
    	ID_DESCRIPCION LIKE '%$_GET[idDescripcion]' AND
    	ACTIVO_FIJO LIKE '%$_GET[txtActivoFijo]' AND
    	ID_Marca Like '%$_GET[idMarca]' AND
    	ID_Modelo Like '%$_GET[idModelo]' AND       
    	CONFIGURACION like '%$_GET[txtConfiguracion]'
		$conFicha
		$orden";

	
//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 20;//Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 30;//Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que s�lo nos interesa propagar estas dos variables
$_pagi_propagar = array("txtConfiguracion","txtActivoFijo","idMarca","idModelo","txtSerial","gerencia","idDivision","idDepartamento","sitio","idEstado","idCargo","txtNombre","txtApellido","txtFicha","txtCedula","txtExtension","ordenado");//No importa si son POST o GET

//Definimos qu� estilo CSS se utilizar� para los enlaces de paginaci�n.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qu� ir� en el enlace a la p�gina anterior
$_pagi_nav_anterior = "&lt;";// podr�a ir un tag <img> o lo que sea

//definimos qu� ir� en el enlace a la p�gina siguiente
$_pagi_nav_siguiente = "&gt;";// podr�a ir un tag <img> o lo que sea

//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
require_once("../paginador/paginator.inc.php");
		
		  	 
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";		     
			echo "<td class=\"tituloPagina\" colspan=\"12\" align=\"center\">INVENTARIO EQUIPOS PLANTA 
			| <a class=\"rptResumenEquiposPlanta\" href=\"rptResumenEqpPlantaExcel.php?Configuracion=$txtConfiguracion&Descripcion=$idDescripcion&Marca=$idMarca&Modelo=$idModelo&Serial=$txtSerial&Gerencia=$gerencia&Division=$idDivision&Departamento=$idDepartamento&Sitio=$sitio&Cargo=$idCargo&Nombre=$txtNombre&Apellido=$txtApellido&Ficha=$txtFicha&Cedula=$txtCedula&Extension=$txtExtension&activofijo=$txtActivoFijo\">EXCEL</a></td>			
		</tr>
		<tr>";
			
		
		// Ordenar configuraci�n
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=asc\">CONFIGURACION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=desc\">CONFIGURACION</a></b></td>";		
		
			// Ordenar Acitvo Fijo
		if ($_GET[ordenado]=='activo_fijo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=asc\">ACTIVO FIJO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=desc\">ACTIVO FIJO</a></b></td>";		
				
		// Ordenar marca
		if ($_GET[ordenado]=='marca' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=asc\"><b>MARCA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=desc\"><b>MARCA</b></a></td>";
		// Ordenar modelo
		if ($_GET[ordenado]=='modelo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=asc\">MODELO</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=desc\">MODELO</b></a></td>";
		
			// Ordenar serial
		if ($_GET[ordenado]=='serial' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=asc\">SERIAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=desc\">SERIAL</b></a></td>";
	  			
		// Ordenar gerencia
		if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\"><b>GERENCIA</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\"><b>GERENCIA</b></a></b></td>";
					
		// Ordenar division
		if ($_GET[ordenado]=='division' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=asc\"><b>DIVISION</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=desc\"><b>DIVISION</b></a></b></td>";
			
		// Ordenar departamento
		if ($_GET[ordenado]=='departamento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=asc\"><b>DEPARTAMENTO</b></a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=desc\"><b>DEPARTAMENTO</b></a></b></td>";
		
		// Ordenar sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\"><b>SITIO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\"><b>SITIO</b></a></td>";
					
		// Ordenar estado
		if ($_GET[ordenado]=='estado' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=asc\"><b>ESTADO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=desc\"><b>ESTADO</b></a></td>";
				
		// Ordenar cargo
		if ($_GET[ordenado]=='cargo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cargo&ordentipo=asc\"><b>CARGO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cargo&ordentipo=desc\"><b>CARGO</b></a></td>";
						
			// Ordenar usario
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\"><b>NOMBRE USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\"><b>NOMBRE USUARIO</b></a></td>";	
			
		if ($_GET[ordenado]=='ficha' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=asc\"><b>FICHA USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=desc\"><b>FICHA USUARIO</b></a></td>";	
				
		if ($_GET[ordenado]=='cedula' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cedula&ordentipo=asc\"><b>CEDULA USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cedula&ordentipo=desc\"><b>CEDULA USUARIO</b></a></td>";	
							
        if ($_GET[ordenado]=='extension' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=asc\"><b>EXTENSION</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=desc\"><b>EXTENSION</b></a></td>";	
				
				
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\">$row[0]</td>";
			echo "<td align=\"left\">$row[1]</td>";
			echo "<td align=\"left\">$row[12]</td>";
			echo "<td align=\"left\">$row[14]</td>";				
			echo "<td align=\"left\">$row[7]</td>";
			echo "<td align=\"left\">$row[34]</td>";
			echo "<td align=\"left\">$row[36]</td>";
			echo "<td align=\"left\">$row[38]</td>";
			echo "<td align=\"left\">$row[32]</td>";
			echo "<td align=\"left\">$row[51]</td>";				
			echo "<td align=\"left\">$row[57]</td>";		
			echo "<td align=\"left\">$row[48] $row[49]</td>";			
			echo "<td align=\"left\">$row[46]</td>";
			echo "<td align=\"left\">$row[47]</td>";	
			echo "<td align=\"left\">$row[52]</td>";													
			echo "</tr>";
			$i++;									
			
		   }
		   
		   echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
		
//Incluimos la informaci�n de la p�gina actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
mysql_close();   	
		
		  	 
		
			
?>
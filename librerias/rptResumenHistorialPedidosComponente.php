<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php

require_once("membrete.php");
echo "<title>Historial Pedidos Componentes </title>";
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptPedidos.php");

 	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]="";
		
		
	if ($_GET[idMarca]==100)	
		$_GET[idMarca]="";
					
		
	if ($_GET[idModelo]==100)	
		$_GET[idModelo]="";
		
		
	if ($_GET[idPedido]==100)	
		$_GET[idPedido]="";
		

	conectarMysql();


	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistacomponentes.FECHA_ASOCIACION Between '$FechaInicio' AND '$FechaFinal' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	if (isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
			$conFicha=" AND (FICHA like '%$_GET[txtFicha]' OR NOMBRE_USUARIO like '%$_GET[txtFicha]%' OR APELLIDO_USUARIO like '%$_GET[txtFicha]%')  ";
		} 
     

   //  $rptComponentes= new rptComponentes();   
       
	$_pagi_sql = "SELECT * FROM vistacomponentes 

        where
		$rangoFecha 
		vistacomponentes .SERIAL like '%$_GET[txtSerial]' and				
		vistacomponentes .ID_DESCRIPCION like '%$_GET[idDescripcion]' and 
		vistacomponentes .ID_MARCA like '%$_GET[idMarca]' and
		vistacomponentes .ID_MODELO like '%$_GET[idModelo]' and
		vistacomponentes.ID_PEDIDO like '%$_GET[idPedido]' and		
		vistacomponentes.ID_INVENTARIO like '%$_GET[idInventario]' 		
		$conFicha
		$orden";
	
	
//cantidad de resultados por p�gina (opcional, por defecto 20)
$_pagi_cuantos = 30;//Eleg� un n�mero peque�o para que se generen varias p�ginas

//cantidad de enlaces que se mostrar�n como m�ximo en la barra de navegaci�n
$_pagi_nav_num_enlaces = 30;//Eleg� un n�mero peque�o para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true s�lo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

//Supongamos que s�lo nos interesa propagar estas dos variables
$_pagi_propagar = array("txtConfiguracion","txtSerial","idDescripcion","idMarca",
"idModelo","idPedido","idEstado","idProveedor","idTelefono","idSitio","idNombre","idApellido","fechaInicio","fechaFinal","ordenado");//No importa si son POST o GET

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
			echo "<td class=\"tituloPagina\" colspan=\"13\" align=\"center\">HISTORIAL DE PEDIDOS POR COMPONENTES
			| <a class=\"rptResumenHistorialPedidosCmponentes\" href=\"rptResumHistPedCompExcel.php?pedido=$idPedido&fechaIni=$fechaInicio&fechaFin=$fechaFinal&Serial=$txtSerial&Descripcion=$idDescripcion&Marca=$idMarca&Modelo=$idModelo\">EXCEL</a></td>						 			 
		</tr>
		<tr>";
			
			
		// Equipo creacion
		if ($_GET[ordenado]=='fecha_inicio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_inicio&ordentipo=asc\"><b>FECHA INICIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_inicio&ordentipo=desc\"><b>FECHA INICIO</b></a></td>";				

		if ($_GET[ordenado]=='fecha_final' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_final&ordentipo=asc\"><b>FECHA FINAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_final&ordentipo=desc\"><b>FECHA FINAL</b></a></td>";				
			
		// Ordenar serial
		if ($_GET[ordenado]=='serial' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=asc\">SERIAL</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=desc\">SERIAL</b></a></td>";
	  
		// Ordenar marca
		if ($_GET[ordenado]=='marca' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=asc\"><b>MARCA</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=desc\"><b>MARCA</b></a></td>";
		
		// Ordenar modelo
		if ($_GET[ordenado]=='modelo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=asc\">MODELO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=desc\"><b>MODELO</b></a></td>";
		
		// Ordenar estado
		if ($_GET[ordenado]=='estado' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=asc\"><b>ESTADO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=desc\"><b>ESTADO</b></a></td>";		

		// Ordenar sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\"><b>SITIO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\"><b>SITIO</b></a></td>";

		// Ordenar usario
		if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\">USUARIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\">USUARIO</b></a></td>";
			
		// Ordenar proveedor
		if ($_GET[ordenado]=='proveedor' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=proveedor&ordentipo=asc\"><b>PROVEEDOR</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=proveedor&ordentipo=desc\"><b>PROVEEDOR</b></a></td>";				

		if ($_GET[ordenado]=='telefono' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=telefono&ordentipo=asc\"><b>TELEFONO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=telefono&ordentipo=desc\"><b>TELEFONO</b></a></td>";				
		
				
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";			
			echo "<td align=\"left\">$row[32]</td>";
			echo "<td align=\"left\">$row[33]</td>";
			echo "<td align=\"left\">$row[1]</td>";
			echo "<td align=\"left\">$row[5]</td>";
			echo "<td align=\"left\">$row[7]</td>";
			echo "<td align=\"left\">$row[42]</td>";			
			echo "<td align=\"left\">$row[21]</td>";
			echo "<td align=\"left\">$row[35] $row[36]</td>";
			echo "<td align=\"left\">$row[27]</td>";
			echo "<td align=\"left\">$row[30]</td>";
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
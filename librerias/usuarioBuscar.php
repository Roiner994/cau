<?php
//Usuario Buscar
?>
<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("conexionsql.php");

if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}

		if (isset($_GET[buscar]) && !empty($_GET[buscar])) {
			$_pagi_sql="select * from vistaUsuario where ficha like '$_GET[buscar]%' or nombre_usuario like '%$_GET[buscar]%' or apellido_usuario like '%$_GET[buscar]%' $orden";
		}
		conectarMysql();
		$result=mysql_query($_pagi_sql);


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
$_pagi_propagar = array("ficha","cedula","nombre_usuario","apellido_usuario","cargo","gerencia","division","departamento","sitio","extension","buscar","ordenado","ordentipo");//No importa si son POST o GET

//Definimos qu� estilo CSS se utilizar� para los enlaces de paginaci�n.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qu� ir� en el enlace a la p�gina anterior
$_pagi_nav_anterior = "&lt;";// podr�a ir un tag <img> o lo que sea

//definimos qu� ir� en el enlace a la p�gina siguiente
$_pagi_nav_siguiente = "&gt;";// podr�a ir un tag <img> o lo que sea

//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente
require_once("../paginador/paginator.inc.php");		
		
		if ($result && mysql_numrows($result)>0) {
			echo "<table width=\"100%\" border=\"0\" align=\"center\">
			<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"10\" align=\"center\">USUARIOS ENCONTRADOS CON LA PALABRA \"".strtoupper($_GET[buscar])."\"</td>
			</tr>";
			echo "	<tr>";
			
			// Ordenar FICHA
			if ($_GET[ordenado]=='ficha' && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=asc\">FICHA</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=ficha&ordentipo=desc\">FICHA</a></b></td>";				

			// Ordenar C�dula
			if ($_GET[ordenado]=='cedula' && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cedula&ordentipo=asc\">CEDULA</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cedula&ordentipo=desc\">CEDULA</a></b></td>";					

			// Ordenar nombre_usuario
			if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\">NOMBRE</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\">NOMBRE</a></b></td>";					

			// Ordenar APELLIDO_USUARIO
			if ($_GET[ordenado]=='apellido_usuario' && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=apellido_usuario&ordentipo=asc\">APELLIDO</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=apellido_usuario&ordentipo=desc\">APELLIDO</a></b></td>";					

			// Ordenar Cargo
			if ($_GET[ordenado]=='cargo' && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cargo&ordentipo=asc\">CARGO</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=cargo&ordentipo=desc\">CARGO</a></b></td>";					
				
			// Ordenar Gerencia
			if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\">GERENCIA</a></b></td>";
			else
				echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\">GERENCIA</a></b></td>";					

		// Ordenar Divisi�n
		if ($_GET[ordenado]=='division' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=asc\">DIVISION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=division&ordentipo=desc\">DIVISION</a></b></td>";	

			// Ordenar Departamento
		if ($_GET[ordenado]=='departamento' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=asc\">DEPARTAMENTO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=departamento&ordentipo=desc\">DEPARTAMENTO</a></b></td>";	

		// Ordenar Sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\">SITIO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\">SITIO</a></b></td>";				

		// Ordenar EXTENSION
		if ($_GET[ordenado]=='extension' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=asc\">EXTENSION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=desc\">EXTENSION</a></b></td>";				
			
		echo "</tr>";

			while ($row=mysql_fetch_array($_pagi_result)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
				<td valign=top class=\"formularioCampo\">$row[0]</td>		
				<td valign=top class=\"formularioCampo\">$row[1]</td>		
				<td valign=top class=\"formularioCampo\">$row[2]</td>
				<td valign=top class=\"formularioCampo\">$row[3]</td>
				<td valign=top class=\"formularioCampo\">$row[5]</td>	
				<td valign=top class=\"formularioCampo\">$row[7]</td>	
				<td valign=top class=\"formularioCampo\">$row[9]</td>	
				<td valign=top class=\"formularioCampo\">$row[11]</td>	
				<td valign=top class=\"formularioCampo\">$row[13]</td>	
				<td valign=top class=\"formularioCampo\">$row[14]</td>				
				</tr>";
				$i++;
			}
			echo "<tr>";
			echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
			echo "</tr>";
			echo "</table>";
		
	//Incluimos la informaci�n de la p�gina actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
  

		} else {
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: USUARIO - BUSCAR USUARIO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO SE ENCONTR&Oacute; UN USUARIO CON LA PALABRA \"".strtoupper($_GET[buscar])."\"</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCerrar\" type=\"button\" value=\"CERRAR\" onclick=\"window.close()\"></td>";
				echo "</tr>";
				echo "</table>";			
				echo "</form>";	
		}
mysql_close();		

?>


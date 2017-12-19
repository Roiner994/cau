<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("membrete.php");
echo "<title>Planta Componenete</title>";
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptPedidos.php");

	
	
	if ($_GET[idDescripcion]==100)
		$_GET[idDescripcion]="";

		
     conectarMysql();

	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	/*	$_pagi_sql = "Select DISTINCT equipo_componente_campo.CONFIGURACION,						
			descripcion.DESCRIPCION,			
			marca.MARCA,			
			modelo.MODELO,
			inventario.SERIAL,			
			sitio.SITIO,			
			inventario_estado.ESTADO,

			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO			
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON proveedor.ID_PROVEEDOR = pedido.ID_PROVEEDOR
			Inner Join sitio ON inventario_propiedad.ID_SITIO = sitio.ID_SITIO
			Where
			inventario_estado.ESTADO='OPERATIVO' AND
			equipo_componente_campo.CONFIGURACION Like '%$_GET[idConfiguracion]' and 
			descripcion.ID_DESCRIPCION Like '%$idDescripcion' 
			$orden";
*/	
	$_pagi_sql = "Select DISTINCT equipo_componente_campo.CONFIGURACION,
			equipo_componente_campo.ID_EQUIPO_COMPONENTE_CAMPO,
			equipo_componente_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.ID_PEDIDO,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL,
			inventario_propiedad.ID_SITIO,
			sitio.SITIO,
			inventario_propiedad.ID_ESTADO,
			inventario_estado.ESTADO,
			equipo_componente_campo.FECHA_ASOCIACION,
			pedido.ID_PROVEEDOR,
			proveedor.PROVEEDOR
			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO			
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON proveedor.ID_PROVEEDOR = pedido.ID_PROVEEDOR
			Inner Join sitio ON inventario_propiedad.ID_SITIO = sitio.ID_SITIO
			Where
			inventario_estado.ESTADO='OPERATIVO' AND
			equipo_componente_campo.CONFIGURACION Like '%$_GET[idConfiguracion]' and 
			descripcion.ID_DESCRIPCION Like '%$idDescripcion' 
			$orden";


//cantidad de resultados por página (opcional, por defecto 20)
$_pagi_cuantos = 30;//Elegí un número pequeño para que se generen varias páginas

//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado

//Decidimos si queremos que se muesten los errores de mysql
$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.

//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
//realizamos el conteo alternativo.
$_pagi_conteo_alternativo = true;//recomendado false.

///Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("idConfiguracion","idDescripcion","marca","modelo","serial","estado","ordenado");//No importa si son POST o GET

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea

//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
require_once("../paginador/paginator.inc.php");
		
		  	 
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";		     
			echo "<td class=\"tituloPagina\" colspan=\"15\" align=\"center\"> EQUIPOS QUE POSEE MAS UN COMPONENTE
			| <a class=\"rptResumenPlantaComponente\" href=\"rptResumenCompxEquipoCompExcel.php?descripcion=$idDescripcion&configuracion=$idConfiguracion\">EXCEL</a></td>						 
		</tr>
		<tr>";
			
		// Ordenar configuracion
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=asc\">DESCRIPCION DEL EQUIPO</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=desc\">DESCRIPCION DEL EQUIPO</a></b></td>";		

		
		// Ordenar componente_descripcion
		if ($_GET[ordenado]=='descripcion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=asc\">DESCRIPCION DEL COMPONENTE</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=desc\">DESCRIPCION DEL COMPONENTE</a></b></td>";		
					
		// Ordenar componente_marca
		if ($_GET[ordenado]=='marca' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=asc\"><b>MARCA DEL COMPONENTE</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=marca&ordentipo=desc\"><b>MARCA DEL COMPONENTE</b></a></td>";
		
		// Ordenar componente_modelo
		if ($_GET[ordenado]=='modelo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=asc\">MODELO DEL COMPONENTE</b></a></td>";
		else 	
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=desc\">MODELO DEL COMPONENTE</b></a></td>";
		
		
		// Ordenar componente_serial
		if ($_GET[ordenado]=='componente_serial' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=asc\">SERIAL DEL COMPONENTE</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=desc\">SERIAL DEL COMPONENTE</b></a></td>";
	  		
			
		// Ordenar sitio
		if ($_GET[ordenado]=='sitio' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=asc\">SITIO</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=sitio&ordentipo=desc\">SITIO</b></a></td>";
	  		
			
		// Ordenar componente_estado
		if ($_GET[ordenado]=='estado' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=asc\">ESTADO DEL COMPONENTE</b></a></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=estado&ordentipo=desc\">ESTADO DEL COMPONENTE</b></a></td>";
	  		
						
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";			
			echo "<td align=\"left\">$row[0]</td>";
			echo "<td align=\"left\">$row[5]</td>";
			echo "<td align=\"left\">$row[7]</td>";		
			echo "<td align=\"left\">$row[9] </td>";
			echo "<td align=\"left\">$row[3]</td>";
			echo "<td align=\"left\">$row[20]</td>";
			echo "<td align=\"left\">$row[22]</td>";												
			echo "</tr>";
			$i++;									
			
		   }
		   echo "<tr>";
	echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";
		
//Incluimos la información de la página actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
mysql_close();   	
		
		
		  	 
		
			
?>

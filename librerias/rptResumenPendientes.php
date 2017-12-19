<?php
require_once("seguridad.php");
$priv="'PRV0000002','PRV0000003','PRV0000004','PRV0000005'";
?>

<script>
	function eliminando(frmComponente) {
		for (i=0;i<frmComponente.elements.length;i++)
			if ((frmComponente.elements[i].type=="checkbox")&&(frmComponente.elements[i].checked)){
				frmComponente.nfil.value=frmComponente.elements[i].value+"*"+frmComponente.nfil.value;
			}
		return true
	}

	function marcartodo(x) {
		if(x==true){
			for (i=0;i<frmComponente.elements.length;i++){
				if ((frmComponente.elements[i].type=="checkbox")&&(frmComponente.elements[i].checked==false)){
					frmComponente.elements[i].checked=true;
				}
			}
		}
		else{
			for (i=0;i<frmComponente.elements.length;i++){
				if ((frmComponente.elements[i].type=="checkbox")&&(frmComponente.elements[i].checked==true)){
					frmComponente.elements[i].checked=false;
				}
			}
		}
	}
</script>

<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">

<?php
require_once("conexionsql.php");
require_once("usuarioSistemaAdmin.php");
$login=$_SESSION["login"];
$user= new usuarioSistema($login);
$resultado=$user->verificarAcceso($priv);
if ($resultado==1) {
		echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: INVENTARIO - EQUIPOS</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>NO TIENE SUFICIENTE PRIVILEGIO PARA ENTRAR A ESTE MODULO.</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"location.href='index2.php'\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";	
		exit();
}


require_once("membrete.php");
echo "<title>Inventario de componentes </title>";
require_once("formularios.php");
require_once("conexionsql.php");
require_once("rptAdmin.php");

//echo "funcion: ".$_GET[idDescripcion];

    if ($_GET[sitio]==100)			$_GET[sitio]="";	
	if ($_GET[idGerencia]==100)		$_GET[idGerencia]="";
	if ($_GET[idDescripcion]==100)	$_GET[idDescripcion]="";		
	if ($_GET[idMarca]==100)		$_GET[idMarca]="";		
	if ($_GET[idModelo]==100)		$_GET[idModelo]="";		
	if ($_GET[idPedido]==100)		$_GET[idPedido]="";			
	if ($_GET[idEstado]==100)		$_GET[idEstado]="";	
	
				
	conectarMysql();

/*	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistacomponentes.FECHA_ASOCIACION Between '$FechaInicio 00:00:00' AND '$FechaFinal 23:59:59' AND ";
	}
	
	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";	
	} else {
		$orden="";
	}
	
	if (isset($_GET[sitio]) && !empty($_GET[sitio]) && ($_GET[sitio] == 'SIT0000057') ){
		$consitio=" AND vistacomponentes.ID_SITIO Like '%$_GET[sitio]' AND vistacomponentes.ID_INVENTARIO NOT IN (SELECT ID_INVENTARIO FROM vistacomponentesasociadosequipos)";
	}else
		$consitio=" AND vistacomponentes.ID_SITIO Like '%$_GET[sitio]'";
	
	if (isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
		$conFicha=" AND (FICHA like '%$_GET[txtFicha]' OR NOMBRE_USUARIO like '%$_GET[txtFicha]%' OR APELLIDO_USUARIO like '%$_GET[txtFicha]%')";
	}      

   //  $rptComponentes= new rptComponentes();   
     
	//echo */
	$_pagi_sql = "SELECT * FROM vistacomponentes WHERE $rangoFecha vistacomponentes.SERIAL like '%$_GET[txtSerial]' and vistacomponentes.ID_GERENCIA like '%$_GET[idGerencia]' and vistacomponentes.ID_DESCRIPCION like '%$_GET[idDescripcion]' and vistacomponentes.ID_MARCA like '%$_GET[idMarca]' and
				  vistacomponentes.ID_MODELO like '%$_GET[idModelo]' and vistacomponentes.ID_PEDIDO like '%$_GET[idPedido]' and vistacomponentes.ID_ESTADO like '%$_GET[idEstado]' and	
				  vistacomponentes.ID_INVENTARIO like '%$_GET[idInventario]' $consitio $conFicha $orden";
	
	if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014")	
		//cantidad de resultados por página (opcional, por defecto 20)
		$_pagi_cuantos = 100;//Elegí un número pequeño para que se generen varias páginas
	else 
		//cantidad de resultados por página (opcional, por defecto 20)
		$_pagi_cuantos = 30;//Elegí un número pequeño para que se generen varias páginas
		
	//cantidad de enlaces que se mostrarán como máximo en la barra de navegación
	$_pagi_nav_num_enlaces = 30;//Elegí un número pequeño para que se note el resultado
	
	//Decidimos si queremos que se muesten los errores de mysql
	$_pagi_mostrar_errores = false;//recomendado true sólo en tiempo de desarrollo.
	
	//Si tenemos una consulta compleja que hace que el Paginator no funcione correctamente, 
	//realizamos el conteo alternativo.
	$_pagi_conteo_alternativo = true;//recomendado false.
	
	//Supongamos que sólo nos interesa propagar estas dos variables
	$_pagi_propagar = array("txtSerial","sitio","idGerencia","idDescripcion","idMarca","idModelo","idPedido","idEstado","txtFicha","fechaInicio","fechaFinal","ordenado");//No importa si son POST o GET
	
	//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
	//El estilo debe estar definido previamente
	$_pagi_nav_estilo = "enlace";
	
	//definimos qué irá en el enlace a la página anterior
	$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea
	
	//definimos qué irá en el enlace a la página siguiente
	$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea
	
	//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
	require_once("../paginador/paginator.inc.php");
		
	echo "<form name=\"frmComponente\" enctype=\"multipart/form-data\" method=\"post\" action=\"componenteEliminar.php?sitio=$_GET[sitio]&idDescripcion=$_GET[idDescripcion]&idGerencia=$_GET[gerencia]&idMarca=$_GET[idMarca]&idModelo=$_GET[idModelo]&idPedido=$_GET[idPedido]&idEstado=$_GET[idEstado]&txtSerial=$_GET[txtSerial]&txtFicha=$_GET[txtFicha]\" onSubmit=\"return eliminando(this);\">";	 
	echo "<input name=\"nfil\" type=\"hidden\"/>";
	echo "<input name=\"haciendo\" type=\"hidden\"/>";
	echo "<table width=\"100%\" border=\"0\" align=\"center\">
	<tr>";		     
		echo "<td class=\"tituloPagina\" colspan=\"13\" align=\"center\">INVENTARIO DE COMPONENTES</td>			 
	</tr>
	<tr>";
	// Ordenar serial
	if ($_GET[ordenado]=='serial' && ($_GET[ordentipo]=='desc'))
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=asc\">SERIAL</b></a></td>";
	else 
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=serial&ordentipo=desc\">SERIAL</b></a></td>";
	// Ordenar Codigo Sap
	if ($_GET[ordenado]=='codigo_sap' && ($_GET[ordentipo]=='desc'))
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=codigo_sap&ordentipo=asc\">CODIGO SAP</b></a></td>";
	else 
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=codigo_sap&ordentipo=desc\">CODIGO SAP</b></a></td>";
  
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
	// Ordenar descripcion
	if ($_GET[ordenado]=='descripcion' && ($_GET[ordentipo]=='desc'))
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=asc\">DESCRIPCION</b></a></td>";
	else 	
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=descripcion&ordentipo=desc\">DESCRIPCION</b></a></td>";
	// Ordenar usario
	if ($_GET[ordenado]=='nombre_usuario' && ($_GET[ordentipo]=='desc'))
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=asc\">USUARIO</b></a></td>";
	else 
		echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=nombre_usuario&ordentipo=desc\">USUARIO</b></a></td>";
	
	// Ordenar extensión
	if ($_GET[ordenado]=='extension' && ($_GET[ordentipo]=='desc'))
		echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=asc\"><b>EXTENSION</b></a></td>";
	else 
		echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=extension&ordentipo=desc\"><b>EXTENSION</b></a></td>";	
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

	// Ordenar gerencia
	if ($_GET[ordenado]=='gerencia' && ($_GET[ordentipo]=='desc'))
		echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\"><b>GERENCIA</b></a></td>";
	else 
		echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\"><b>GERENCIA</b></a></td>";
		
	// Ordenar Fecha Asociacion
	if ($_GET[ordenado]=='fecha_asociacion' && ($_GET[ordentipo]=='desc'))
		echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_asociacion&ordentipo=asc\"><b>FECHA_ASOCIACION</b></a></td>";
	else 
		echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=fecha_asociacion&ordentipo=desc\"><b>FECHA_ASOCIACION</b></a></td>";
		
	if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014")
		echo "<td valign=top class=\"tablaTitulo\"><b>ELIMINAR</b><input name=\"checkbox\" type=\"checkbox\" onClick=\"marcartodo(checked);\"> </td>";			
	echo "</tr>";	
			
	while ($row=mysql_fetch_array($_pagi_result)) {
		if ($i%2==0) {
			$clase="tablaFilaPar";
		} else {
			$clase="tablaFilaNone";
		}
		echo "<tr class=\"$clase\">";
		echo "<td align=\"left\"><a class=enlace href=\"ComponenteDetalle.php?idInventario=$row[0]\">$row[1]</a></td>";				
		echo "<td align=\"left\">$row[45]</td>";
		echo "<td align=\"left\">$row[5]</td>";
		echo "<td align=\"left\">$row[7] $row[8] $row[9]</td>";
		echo "<td align=\"left\">$row[3]</td>";		
		echo "<td align=\"left\">$row[35] $row[36]</td>";
		echo "<td align=\"left\">$row[39]</td>";
		echo "<td align=\"left\">$row[42]</td>";
		echo "<td align=\"left\">$row[21]</td>";
		echo "<td align=\"left\">$row[15]</td>";
		echo "<td align=\"left\">".substr($row[24],8,2)."/".substr($row[24],5,2)."/".substr($row[24],0,4)."</td>";

		if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014")			
			echo "<td align=\"center\">					  
				  <input type=\"checkbox\" name=\"chkcomponente[]\" value=\"$row[0]\" />
				  </td>";
		echo "</tr>";
		$i++;		
	}
	
	echo "<tr>";
	if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014"){
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"9\">".$_pagi_navegacion."</td>";
		echo "<td align=\"center\" class=\"tablaFilaNone\"><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"boton2\" value=\"Eliminar\" onClick=\"hacer(1);\" tabindex=\"6\" /></td>";
	}else {
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"10\">".$_pagi_navegacion."</td>";
	}
	
	echo "</tr>";
	echo "</table>";
	echo "</form>";	
	//Incluimos la información de la página actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
	mysql_close();   	
 				
?>
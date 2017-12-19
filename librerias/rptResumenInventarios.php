<?php
require_once("seguridad.php");
$priv="'PRV0000002','PRV0000003','PRV0000004','PRV0000005'";
?>

<script>
	function eliminando(frmEquipo) {
		for (i=0;i<frmEquipo.elements.length;i++)
			if ((frmEquipo.elements[i].type=="checkbox")&&(frmEquipo.elements[i].checked)){
				frmEquipo.nfil.value=frmEquipo.elements[i].value+"*"+frmEquipo.nfil.value;
			}
		return true
	}

	function marcartodo(x) {
		if(x==true){
			for (i=0;i<frmEquipo.elements.length;i++){
				if ((frmEquipo.elements[i].type=="checkbox")&&(frmEquipo.elements[i].checked==false)){
					frmEquipo.elements[i].checked=true;
				}
			}
		}
		else{
			for (i=0;i<frmEquipo.elements.length;i++){
				if ((frmEquipo.elements[i].type=="checkbox")&&(frmEquipo.elements[i].checked==true)){
					frmEquipo.elements[i].checked=false;
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
		echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
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

require_once("rptAdmin.php");
require_once("membrete.php");
require_once("formularios.php");
echo "<title>Inventario de Equipos</title>";

    if ($_GET[sitio]==100)
		$_GET[sitio]="";
		
	if ($_GET[idGerencia]==100)
		$_GET[idGerencia]="";
	
	if ($_GET[idDescripcion]==100)	
		$_GET[idDescripcion]="";
		
	if ($_GET[idMarca]==100)	
		$_GET[idMarca]="";
					
	if ($_GET[idModelo]==100)	
		$_GET[idModelo]="";
		
		


	if ($_GET[idPedido]==100)	
		$_GET[idPedido]="";
					
	if ($_GET[idEstado]==100)		
		$_GET[idEstado]="";
		
	if ($_GET[red]==100)
		$_GET[red]=""; 
			
	if ($_GET[critico]==100)
		$_GET[critico]="";
	
	if ($_GET[usuarioEspecializado]==100)
		$_GET[usuarioEspecializado]=""; 	
		
	if ($_GET[SP]==100)
		$_GET[SP]=""; 
		
	if ($_GET[correctivo]==100)
		$_GET[correctivo]=""; 
	
	if ($_GET[encontrado]==100)
		$_GET[encontrado]=""; 
	
	if ($_GET[uso]==100)
		$_GET[uso]=""; 
	
	if ($_GET[equipodisponible]==100)
		$_GET[equipodisponible]=""; 

	if ($_GET[antivirusActualizado]==100)
		$_GET[antivirusActualizado]=""; 

	if ($_GET[soActualizado]==100)
		$_GET[soActualizado]=""; 
		
    conectarMysql();

	$rangoFecha="";
	if ((isset($_GET[fechaInicio]) && !empty($_GET[fechaInicio])) && (isset($_GET[fechaFinal]) && !empty($_GET[fechaFinal]))) {
		$FechaInicio=substr($_GET[fechaInicio],6,6)."-".substr($_GET[fechaInicio],3,2)."-".substr($_GET[fechaInicio],0,2);
		$FechaFinal=substr($_GET[fechaFinal],6,6)."-".substr($_GET[fechaFinal],3,2)."-".substr($_GET[fechaFinal],0,2);
		$rangoFecha=" vistaInventarioEquipos.FECHA_ASOCIACION Between '$FechaInicio' AND '$FechaFinal' AND ";
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
		vistaInventarioEquipos.CONFIGURACION like '%$_GET[txtConfiguracion]'and
		vistaInventarioEquipos.SERIAL like '%$_GET[txtSerial]' and	
		vistaInventarioEquipos.ACTIVO_FIJO like '%$_GET[txtActivoFijo]' and				
		vistaInventarioEquipos.ID_SITIO like '%$_GET[sitio]' and
		vistaInventarioEquipos.ID_GERENCIA like '%$_GET[idGerencia]' and
		vistaInventarioEquipos.ID_DESCRIPCION like '%$_GET[idDescripcion]' and 
		vistaInventarioEquipos.ID_MARCA like '%$_GET[idMarca]' and
		vistaInventarioEquipos.ID_MODELO like '%$_GET[idModelo]' and
		vistaInventarioEquipos.ID_PEDIDO like '%$_GET[idPedido]' and
		vistaInventarioEquipos.ID_ESTADO like '%$_GET[idEstado]' and
		vistaInventarioEquipos.RED like '%$_GET[red]' and
		vistaInventarioEquipos.CRITICO like '%$_GET[critico]' and
		vistaInventarioEquipos.USUARIO_ESPECIALIZADO like '%$_GET[usuarioEspecializado]' and
		vistaInventarioEquipos.SP like '%$_GET[SP]' and
		vistaInventarioEquipos.CORRECTIVO like '%$_GET[correctivo]' and
		vistaInventarioEquipos.ENCONTRADO like '%$_GET[encontrado]' and
		vistaInventarioEquipos.USO like '%$_GET[uso]' and
		vistaInventarioEquipos.DISPONIBLE like '%$_GET[equipodisponible]' and
		vistaInventarioEquipos.ANTIVIRUS like '%$_GET[antivirusActualizado]' and
	
		vistaInventarioEquipos.SISTEMA_OPERATIVO like '%$_GET[soActualizado]'
		$conFicha
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

//Supongamos que sólo nos interesa propagar estas dos variables
$_pagi_propagar = array("txtConfiguracion","txtSerial","txtActivoFijo","sitio","idGerencia","idDescripcion","idMarca",
"idModelo","idPedido","idEstado","red","critico","usuarioEspecializado","SP","txtFicha","fechaInicio","fechaFinal","ordenado");//No importa si son POST o GET

//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
//El estilo debe estar definido previamente
$_pagi_nav_estilo = "enlace";

//definimos qué irá en el enlace a la página anterior
$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea

//definimos qué irá en el enlace a la página siguiente
$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea

//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
require_once("../paginador/paginator.inc.php");
//*****************************************************************************************************************
//*****************************************************************************************************************
	echo "<form name=\"frmEquipo\" enctype=\"multipart/form-data\" method=\"post\" action=\"equipoEliminar.php?sitio=$_GET[sitio]&idDescripcion=$_GET[idDescripcion]&idGerencia=$_GET[gerencia]&idMarca=$_GET[idMarca]&idModelo=$_GET[idModelo]&idPedido=$_GET[idPedido]&idEstado=$_GET[idEstado]&txtSerial=$_GET[txtSerial]&txtFicha=$_GET[txtFicha]\" onSubmit=\"return eliminando(this);\">";	 
	echo "<input name=\"nfil\" type=\"hidden\"/>";
	echo "<input name=\"haciendo\" type=\"hidden\"/>";		
//*****************************************************************************************************************
//*****************************************************************************************************************
		  	 
		echo "<table width=\"100%\" border=\"0\" align=\"center\">
		<tr>";		     
			echo "<td class=\"tituloPagina\" colspan=\"10\" align=\"center\"> INVENTARIO DE EQUIPOS</td>			 
		</tr>
		<tr>";
			
		// Ordenar configuración
		if ($_GET[ordenado]=='configuracion' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=asc\">CONFIGURACION</a></b></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=configuracion&ordentipo=desc\">CONFIGURACION</a></b></td>";	
		// Ordenar activo Fijo 
		if ($_GET[ordenado]=='activo_fijo' && ($_GET[ordentipo]=='desc'))
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=asc\"><b>ACTIVO FIJO</b></a></td>";
		else
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=activo_fijo&ordentipo=desc\"><b>ACTIVO FIJO</b></a></td>";
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
			echo "<td valign=top class=\"tablaTitulo\"><b><a class=\"enlace\" href=\"$_pagi_enlace ordenado=modelo&ordentipo=desc\">MODELO</b></a></td>";
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
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=asc\"><b>GERENCIA</b></td>";
		else 
			echo "<td valign=top class=\"tablaTitulo\"><a class=\"enlace\" href=\"$_pagi_enlace ordenado=gerencia&ordentipo=desc\"><b>GERENCIA</b></td>";	
			
			
			

		//*********************************************************************************************************		
		//*********************************************************************************************************		
		if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014")
		echo "<td valign=top class=\"tablaTitulo\"><b>ELIMINAR</b><input name=\"checkbox\" type=\"checkbox\" onClick=\"marcartodo(checked);\"> </td>";			
		//*********************************************************************************************************
		//*********************************************************************************************************
		echo "</tr>";	
				
		while ($row=mysql_fetch_array($_pagi_result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">";
			echo "<td align=\"left\"><a class=enlace href=\"EquipoDetalle.php?configuracion=$row[0]\">$row[0]</a></td>";				
			echo "<td align=\"left\">$row[1]</td>";
			echo "<td align=\"left\">$row[8]</td>";
			echo "<td align=\"left\">$row[13]</td>";
			echo "<td align=\"left\">$row[15] $row[16] $row[17]</td>";
			
			echo "<td align=\"left\">$row[49] $row[50]</td>";
			echo "<td align=\"left\">$row[53]</td>";
			
			echo "<td align=\"left\">$row[46]</td>";			
			echo "<td align=\"left\">$row[33]</td>";
			echo "<td align=\"left\">$row[35]</td>";		
			
			//*****************************************************************************************************************
			//*****************************************************************************************************************
			if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014")			
			echo "<td align=\"center\">					  
				  <input type=\"checkbox\" name=\"chkequipo[]\" value=\"$row[0]\" />
				  </td>";			
			//*****************************************************************************************************************
			//*****************************************************************************************************************
			echo "</tr>";
			$i++;									
			
		   }
		   echo "<tr>";
	/*echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
	echo "</tr>";
	echo "</table>";*/
	//****************************************************************************************************************
	//****************************************************************************************************************
	if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014"){
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"9\">".$_pagi_navegacion."</td>";
		echo "<td align=\"center\" class=\"tablaFilaNone\"><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"boton2\" value=\"Eliminar\" onClick=\"hacer(1);\" tabindex=\"6\" /></td>";
	}else {
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"10\">".$_pagi_navegacion."</td>";
	}
	
	echo "</tr>";
	echo "</table>";
	echo "</form>";	
	//****************************************************************************************************************
	//****************************************************************************************************************
		
//Incluimos la información de la página actual
	echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
mysql_close();   	
?>

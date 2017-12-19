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

    $serial= (isset($GET['serial'])&&!empty($GET['serial'])) ?  " AND ".$GET['serial'] : "";

	
				
	conectarMysql();   
	$_pagi_sql = "SELECT planillas_componente.FECHA_CREACION, sitio.SITIO, departamento.DEPARTAMENTO FROM 
					inventario INNER JOIN inventario_usuario ON (inventario.ID_INVENTARIO=inventario_usuario.ID_INVENTARIO)
					INNER JOIN componente_campo ON (componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO)
					INNER JOIN planillas_componente ON (planillas_componente.SERIAL=inventario.SERIAL AND inventario_usuario.FECHA_ASOCIACION=planillas_componente.FECHA_ASOCIACION_COMPONENTE)
					INNER JOIN inventario_propiedad ON(inventario_propiedad.ID_INVENTARIO=inventario.ID_INVENTARIO)
					INNER JOIN sitio ON (inventario_propiedad.ID_SITIO=sitio.ID_SITIO)
					INNER JOIN departamento ON(inventario_propiedad.ID_DEPARTAMENTO=departamento.ID_DEPARTAMENTO)
					WHERE 1 $serial";
	
	if ($login=="USS0000003" || $login=="USS0000011" || $login=="USS0000014" || $login=="USS0000047")	
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
	$_pagi_propagar = array("serial");//No importa si son POST o GET
	
	//Definimos qué estilo CSS se utilizará para los enlaces de paginación.
	//El estilo debe estar definido previamente
	$_pagi_nav_estilo = "enlace";
	
	//definimos qué irá en el enlace a la página anterior
	$_pagi_nav_anterior = "&lt;";// podría ir un tag <img> o lo que sea
	
	//definimos qué irá en el enlace a la página siguiente
	$_pagi_nav_siguiente = "&gt;";// podría ir un tag <img> o lo que sea
	
	//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente
	require_once("../paginador/paginator.inc.php");
	
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
				echo "<td align=\"left\">$row[$j]</td>";								
			echo "</tr>";
			$i++;
			
		}
		
		echo "<tr>";
		echo "<td align=\"center\" class=\"tablaFilaNone\" colspan=\"12\">".$_pagi_navegacion."</td>";
		echo "</tr>";
		echo "</table>";
		echo"<p class=\"enlace\" >Resultados ".$_pagi_info."</p>";
		mysql_close();					

 				
?>

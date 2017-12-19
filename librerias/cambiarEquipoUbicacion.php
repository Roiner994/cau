<script language="javascript">
	function cambiarSeleccion() {
		document.frmEquipo.funcion.value=2;
		document.frmEquipo.submit();
	}
</script>
<?php
session_start();
//Cambiar Ubicacion de un Equipo
	//Datos de la Ubicacion

switch($funcion) {
	case 1:
		echo "llamada a Actualizar";
		break 1;
	case 2:
		$configuracion=$_SESSION['configuracion'];
		echo "configuracion: $configuracion";
		formularioUbicacionEquipo();
		break 1;
	default:
		require_once("formularios.php");
		require_once("conexionsql.php");
		require_once ("equipoAdmin.php");
		$configuracion=$_SESSION['configuracion'];
		echo "configuracion: $configuracion";
		$equipo= new equipo($configuracion);
		$resultado=$equipo->retornarEquipoUbicacion();
		if ($resultado) {
			$row=mysql_fetch_array($resultado);
			$_POST[selSitio]=$row[8];
			$_POST[selGerencia]=$row[2];
			$_POST[selDivision]=$row[4];
			$_POST[selDepartamento]=$row[6];
		}
		formularioUbicacionEquipo();
}


function formularioUbicacionEquipo() {
$configuracion=$_SESSION['configuracion'];
	require_once("formularios.php");
	require_once("conexionsql.php");
	require_once ("equipoAdmin.php");

	//Consultas para generar los Select de Ubicacion
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia ORDER BY GERENCIA";
	$conDivision="SELECT ID_DIVISION, DIVISION FROM division WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
	$conDepartamento="SELECT ID_DEPARTAMENTO,DEPARTAMENTO FROM departamento WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";


	//Campo del Sitio
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--SITIO--","");
	$selSitio=$sitio->retornar();
	
	//Campo de la Gerencia		
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();
	
	//Campo de la Division
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();
	//Campo Departamento	
	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","","",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();

	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	
		echo "<table class=\"formularioTabla\" align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\">INVENTARIO - NUEVO EQUIPO - ACTUALIZAR UBICACI&Oacute;N</td>
  				</tr>";
	 	echo "<tr>";
			echo "<td valign=top class=\"formularioTablaTitulo\">DATOS DE UBICACION</td>
  				</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>
			GERENCIA<br>$selGerencia<br>
			DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento<br><td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnRegresar\" type=\"button\" value=\"REGRESAR\" onclick=\"location.href='secciones.php?item=132&configuracion=$configuracion&funcion=3'\"><input name=\"btnActualizar\" type=\"button\" value=\"ACTUALIZAR\"></td>
  				</tr>";		
	echo "</table>";
	echo "</form>";
}
?>
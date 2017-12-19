<?php
require_once("seguridad.php");
?>
<script language="javascript">
	function cambiarSeleccion() {
		document.frmDespacho.funcion.value=0;
		document.frmDespacho.submit();
	}
	function cambiarGerencia() {
		document.frmDespacho.funcion.value=2;
		document.frmDespacho.submit();
	}
	function cambiarMarca() {
		document.frmDespacho.funcion.value=3;
		document.frmDespacho.submit();
	}			

</script>
<?php
//despachar Componentes

switch($funcion) {
	case 1:
	break 1;
	case 3:
		break 1;
	default:
		formularioDespacho();
	
}
function formularioDespacho() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	
	echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - DESPACHO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">NUEVOS DESPACHOS</td>";
		echo "</tr>";
			echo "<tr>
				<td valign=top class=\"formularioTablaBotones\" colspan=\"2\">
				<a class=\"botonEnlace\" href=\"index2.php?item=613\">EQUIPO</a>	
				<a class=\"botonEnlace\" href=\"index2.php?item=614\">COMPONENTES DE EQUIPO</a>
				<a class=\"botonEnlace\" href=\"index2.php?item=615\">COMPONENTES DE IMPRESORA</a>
				<a class=\"botonEnlace\" href=\"index2.php?item=616\">SUMINISTROS</a>				
				</td>
			</tr>";
	echo "</table>";
}
?>
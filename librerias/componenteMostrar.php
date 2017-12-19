<?php
require_once("seguridad.php");
?>

<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmComponente.funcion.value=2;
		document.frmComponente.pedido.value=1
		document.frmComponente.submit();
	}
	function desvincular() {
		document.frmComponente.funcion.value=3;
		document.frmComponente.submit();
	}
	function buscarSerial() {
		if (document.frmComponente.txtSerial.value!="") {
			document.frmComponente.funcion.value=3;
			document.frmComponente.submit();
		}
	}
</script>
<?php
//InventarioComponentes
switch ($funcion) {
	case 1:
		require_once "formularios.php";
		require_once "administracion.php";
		require_once "conexionsql.php";
		require_once "inventarioAdmin.php";
		require_once "usuarioSistemaAdmin.php";
		$login=$_SESSION["login"];
		$componenteCambiar= new componente();
		$componenteCambiar->setInventario($_POST[txtIdInventario],"","","","","","","","",$_POST[selPedido],$_POST[txtFechaInicio],$_POST[txtFechaFinal]);
		$componenteCambiar->setInventarioPropiedad($_POST[selEstado],$login);
		
		$componenteCambiar->setComponente($_POST[txtConfiguracion]);
		$resultado=$componenteCambiar->actualizarComponenteAsociado();
		frmComponente($_POST[txtIdInventario],1);
		break 1;
	case 2:
		frmComponente($_POST[txtIdInventario],1);
		break 1;
	case 3:
		require_once "formularios.php";
		require_once "administracion.php";
		require_once "conexionsql.php";
		require_once "inventarioAdmin.php";
		require_once "usuarioSistemaAdmin.php";
		$login=$_SESSION["login"];
		$componenteCambiar= new componente();
		$componenteCambiar->setInventario($_POST[txtIdInventario],"","","","","","","","",$_POST[selPedido],$_POST[txtFechaInicio],$_POST[txtFechaFinal]);
		$componenteCambiar->setInventarioPropiedad($_POST[selEstado],$login);
		$componenteCambiar->setComponente($_POST[txtConfiguracion]);
		$resultado=$componenteCambiar->actualizarComponenteAsociado();
		$resultado=$componenteCambiar->desvincularComponente();
		echo "<script>location.href='index2.php?item=151&config=$_POST[txtConfiguracion]'</script>";			
		break 1;
	default:
	frmComponente($serial);
}
function frmComponente($idInventario="",$enlace=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "inventarioAdmin.php";
	require_once "pedidoAdmin.php";
if ($enlace==0)	
	if (isset($idInventario) && !empty($idInventario)) {
		$_POST[txtIdInventario]=$idInventario;
		$componente= new componente();
		$componente->setInventario($idInventario);
		$resultComponente=$componente->retornarComponente();
		if ($resultComponente && $resultComponente!=1) {
			$row=mysql_fetch_array($resultComponente);
			$_POST[txtSerial]=$row[1];
			$_POST[txtCt]=$row[13];
			$_POST[txtFru]=$row[10];
			$_POST[txtSpareNumber]=$row[12];
			$_POST[txtProductNumber]=$row[11];
			$_POST[txtDescripcion]=$row[3];
			$_POST[txtMarca]=$row[5];
			$_POST[txtModelo]=$row[7].' '.$row[8].' '.$row[9];
			$fecha=substr($row[15],8,2).'/'.substr($row[15],5,2).'/'.substr($row[15],0,4);
			$_POST[txtFechaInicio]=$fecha;
			$fecha=substr($row[16],8,2).'/'.substr($row[16],5,2).'/'.substr($row[16],0,4);
			$_POST[txtFechaFinal]=$fecha;
			$_POST[selPedido]=$row[14];
			
		}
		$resultComponenteAsociado=$componente->retornarComponenteAsociado();
		if ($resultComponenteAsociado && $resultComponenteAsociado!=1) {
			$row=mysql_fetch_array($resultComponenteAsociado);
			$_POST[txtConfiguracion]=$row[1];
			$configuracion=$row[1];
		}
		

		if ($componente->retornarUltimaUbicacion('d')!=1) {
			$_POST[selSitio]=$componente->retornarUltimaUbicacion('u');
			$_POST[txtSitio]=$componente->retornarUltimaUbicacion('un');
			$_POST[txtGerencia]=$componente->retornarUltimaUbicacion('gn');
			$_POST[txtDivision]=$componente->retornarUltimaUbicacion('sn');
			$_POST[txtDepartamento]=$componente->retornarUltimaUbicacion('dn');
			$_POST[selDepartamento]=$componente->retornarUltimaUbicacion('d');
			$_POST[txtEspecifico]=$componente->retornarUltimaUbicacion('e');
		}
		
		if ($componente->retornarUltimoUsuario('f')!=1) {
			$_POST[txtFicha]=$componente->retornarUltimoUsuario('f');
			$_POST[txtNombre]=$componente->retornarUltimoUsuario('n');
			$_POST[txtApellido]=$componente->retornarUltimoUsuario('a');
			$_POST[txtExtension]=$componente->retornarUltimoUsuario('e');
		}
		$equipo= new equipo();
		$equipo->setEquipo($_POST[txtConfiguracion]);	
		$resultadoEquipo=$equipo->buscarEquipo();
		if ($resultadoEquipo && $resultadoEquipo!=1) {
			$row=mysql_fetch_array($resultadoEquipo);
			$_POST[txtMarcaEquipo]=$row[7];
			$_POST[txtModeloEquipo]="$row[9] $row[10] $row[11]";
			$_POST[txtSerialEquipo]=$row[3];	
		}
		
	}
	$componente2= new componente();
	$componente2->setInventario($_POST[txtIdInventario]);
	$_POST[selEstado]=$componente2->retornarUltimoEstado();	
		if ($componente2->verificarGarantia(0)==1) {
			$estado="'EST0000001','EST0000002'";	
		} else {
			$estado="'EST0000001','EST0000006','EST0000003','EST0000004','EST0000005'";
	}
	if ($_POST[pedido]==1) {
		
		$ped=new pedido($_POST[selPedido]);
		$resultado=$ped->retornarPedido();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$fecha=substr($row[2],8,2).'/'.substr($row[2],5,2).'/'.substr($row[2],0,4);
			$_POST[txtFechaInicio]=$fecha;
			$fecha=substr($row[3],8,2).'/'.substr($row[3],5,2).'/'.substr($row[3],0,4);
			$_POST[txtFechaFinal]=$fecha;		
		}
	}
	$configuracion=$_POST[txtConfiguracion];
	//Consultas para los Campos de Selección
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION_PROPIEDAD<>'DSP0000004' ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ',unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_UBICACION_PROPIEDAD='UBP0000003' ORDER BY SITIO";
	$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";
	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado ORDER BY ID_ESTADO";	
	//Llamadas a las clases para generar el formulario con los Campos de Texto y Selección


	$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onchange","cambiarSeleccion()",$conPedido,"--PEDIDO--","");
	$selPedido=$pedido->retornar();



	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","onkeyPress","return Letras(event)");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();


	//Campo Estado
	$estado= new campoSeleccion("selEstado","formularioCampoSeleccion","$_POST[selEstado]","","",$conEstado,"--ESTADO--","");
	$selEstado=$estado->retornar();
	
	
	echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"pedido\" type=\"hidden\" value=\"0\">";
	
	echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
	echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
	echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
	//Datos del Componente.
	
		echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">COMPONENTE</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL COMPONENTE</td>
  				</tr>
    		<td valign=top class=\"formularioCampoTitulo\">SERIAL<br><input name=\"txtSerial\" value=\"$_POST[txtSerial]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			DESCRIPCION<br><input name=\"txtDescripcion\" value=\"$_POST[txtDescripcion]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			MARCA<br><input name=\"txtMarca\" value=\"$_POST[txtMarca]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			MODELO<br><input name=\"txtModelo\" value=\"$_POST[txtModelo]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>

			<td valign=top class=\"formularioCampoTitulo\">CT<br>
			<input name=\"txtCt\" value=\"$_POST[txtCt]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			FRU<br><input name=\"txtFru\" value=\"$_POST[txtFru]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			PRODUCT NUMBER<br><input name=\"txtProductNumber\" value=\"$_POST[txtProductNumber]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			SPARE NUMBER<br><input name=\"txtSpareNumber\" value=\"$_POST[txtSpareNumber]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			ESTADO<br>$selEstado<br></td>
		</tr>";
		echo "<tr>";
			echo "<td valign=top class=\"formularioTablaTitulo\">DATOS DE UBICACION</td>
			<td valign=top class=\"formularioTablaTitulo\">EQUIPO ASOCIADO</td>
  				</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">UBICACION<br><input name=\"txtSitio\" value=\"$_POST[txtSitio]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			GERENCIA<br><input name=\"txtGerencia\" value=\"$_POST[txtGerencia]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			DIVISION<br><input name=\"txtDivision\" value=\"$_POST[txtDivision]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			DEPARTAMENTO<br><input name=\"txtDepartamento\" value=\"$_POST[txtDepartamento]\" class=\"formularioCampoTexto\" readonly=\"true\"><br></td>
			<td class=\"formularioCampoTitulo\">CONFIGURACION<br><input name=\"txtConfiguracion\" value=\"$_POST[txtConfiguracion]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			DESCRIPCION<br><input name=\"txtMarcaEquipo\" value=\"$_POST[txtMarcaEquipo]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			MARCA/MODELO<br><input name=\"txtModeloEquipo\" value=\"$_POST[txtModeloEquipo]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			SERIAL<br><input name=\"txtSerialEquipo\" value=\"$_POST[txtSerialEquipo]\" class=\"formularioCampoTexto\" readonly=\"true\"><br></td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">INFORMACION PARA GARANTIA</td><td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
  			</tr>
		<tr>
			<td class=\"formularioCampoTitulo\" valign=\"top\">PEDIDO<br>$selPedido<br>
			FECHA INICIO (GARANTIA)<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmComponente.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></br>
			FECHA FINAL (GARANTIA)<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmComponente.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
			</td>
			<td class=\"formularioCampoTitulo\" valign=\"top\">FICHA<br><input name=\"txtFicha\" value=\"$_POST[txtFicha]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			NOMBRE<br><input name=\"txtNombre\" value=\"$_POST[txtNombre]\" class=\"formularioCampoTexto\" readonly=\"true\"></br>
			APELLIDO<br><input name=\"txtApellido\" value=\"$_POST[txtApellido]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			EXTENSION<br><input name=\"txtExtension\" value=\"$_POST[txtExtension]\" class=\"formularioCampoTexto\" readonly=\"true\"><br>
			</td>

		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\">
				<input name=\"btnRegresar\" type=\"button\" value=\"REGRESAR\" onclick=\"location.href='index2.php?item=154'\">
				<input name=\"btnActualizar\" type=\"submit\" value=\"ACTUALIZAR\">";
			echo "</td>
  				</tr>";			
		echo "</table>";
	echo "</form>";
}

?>
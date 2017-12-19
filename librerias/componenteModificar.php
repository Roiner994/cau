<?php
require_once("seguridad.php");
$priv="'PRV0000003'";

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
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmComponente.funcion.value=0;
		document.frmComponente.txtCambiarSeleccion.value=1;
		document.frmComponente.submit();
	}
	function cambiarPedido() {
		document.frmComponente.funcion.value=4;
		document.frmComponente.submit();
	}
	
	function guardar() {
		if(document.frmComponente.selEstado.value!='EST0000001' && document.frmComponente.txtConfiguracionCampo.value!='') {
			document.frmComponente.funcion.value=2;
			document.frmComponente.submit();
		} else {
			document.frmComponente.funcion.value=1;
			document.frmComponente.submit();
		}
	}
	function continuar() {
		document.frmComponente.funcion.value=2;
		document.frmComponente.submit();
	}
	

	function buscarSerial() {
		if (document.frmComponente.txtSerial.value!="") {
			document.frmComponente.funcion.value=0;
			document.frmComponente.submit();
		}
	}
	
	function buscarConfiguracion() {
		if (document.frmComponente.txtConfiguracion.value!="") {
			document.frmComponente.funcion.value=0;
			document.frmComponente.txtBuscarConfiguracion.value=1;
			document.frmComponente.submit();
		}
	}
	
	function desvincularComponenteEquipoGarantia() {
		document.frmComponente.funcion.value=3;
		document.frmComponente.submit();
	}

	function casoFinVidaUtil() {
		document.frmComponente.funcion.value=2;
		document.frmComponente.selEstado.value='EST0000004';
		document.frmComponente.submit();
	}
	function casoInoperativo() {
		document.frmComponente.funcion.value=2;
		document.frmComponente.selEstado.value='EST0000002';
		document.frmComponente.submit();
	}
	function finVidaUtilOperativo()  {
		if (document.frmComponente.txtEspecifico.value=="")		
			document.frmComponente.funcion.value=1;
		else 
			document.frmComponente.funcion.value=2;
		
		document.frmComponente.submit();
	}
</script>
<?php
require_once("administracion.php");
require_once("inventarioAdmin.php");

switch($funcion) {
	case 1:
		$componente= new componente();
		
		//Datos del Equipo A Modificar
		$componente->setInventario($_POST[txtIdInventario],$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
		$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);
		
		//Datos del Estado 
		$componente->setInventarioPropiedad($_POST[selEstado],$login);
		
		//Datos de Ubicacion del Componente
		$componente->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
		$componente->setComponente($_POST[txtConfiguracionCampo]);
		
		switch ($_POST[txtEstadoAnterior]) {
			//CASO OPERATIVO
			case 'EST0000001':
				switch ($_POST[selEstado]) {
					
					//CASO OPERATIVO
					case 'EST0000001':
						$resultadoModificarEquipoGarantia=$componente->modificarEquipoGarantia($_POST[txtConfiguracion]);
							if ($resultadoModificarEquipoGarantia==0) {
								$modificarEquipoGarantia="SI";
							}
							else { 
								$modificarEquipoGarantia="NO";
							}						
						$resultado=$componente->modificarComponente();
							if ($resultado==0) {
								$modificarComponente="SI";
							} else {
								$modificarComponente="NO";
							}						

						$resultadoUbicacion=$componente->ingresarInventarioUbicacion();
						if ($resultadoUbicacion==0) {
							$modificarUbicacion="SI";
						} else {
							$modificarUbicacion="NO";
						}
						$resultadoEstado=$componente->ingresarInventarioPropiedad();
						if ($resultadoEstado==0) {
							$modificarEstado="SI";
						} else {
							$modificarEstado="NO";
						}						

							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><B>MODIFICACIONES REALIZADAS:</B><br><br>
							<b>MODIFICACION DE DATOS:</b> $modificarComponente<br>
							<b>MODIFICACION DE EQUIPO ASOCIADO EN GARANTIA:</b> $modificarEquipoGarantia<br>
							<b>MODIFICACION DE ESTADO:</b> $modificarEstado<br>
							<b>MODIFICACION DE UBICACION:</b> $modificarUbicacion<br></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
						
					break 1;
					
					
					
					//CASO INOPERATIVO
					case 'EST0000002':
						//Se Verifica si el Equipo esta o no en garantía, 0 significa que está en garantía.
						if ($componente->verificarTiempoGarantia()==0) {
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>EL COMPONENTE EST&Aacute; EN GARANT&Iacute;A Y SER&Aacute; ENVIADO AL MODULO DE GARANT&Iacute;A.</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"button\" value=\"CONTINUAR\" onclick=\"continuar()\">
							<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();							
						} else {
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>EL COMPONENTE NO TIENE GARANT&Iacute;A. ¿QUE DESEA HACER CON EL COMPONENTE?</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnInoperativo\" type=\"button\" value=\"INOPERATIVO\" onclick=\"casoInoperativo()\">
							<input name=\"btnFinVidaUtil\" type=\"button\" value=\"FIN DE VIDA &Uacute;TIL\" onclick=\"casoFinVidaUtil()\">
							<input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\">";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();
						}
						break 1;
						//CASO FIN DE VIDA UTIL OPERATIVO
						case 'EST0000003':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES NO SE PUEDEN COLOCAR EN FIN DE VIDA &Uacute;TIL (OPERATIVO).</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();						
						break 1;
						//CASO FIN DE VIDA UTIL
						case 'EST0000004':
						if ($componente->verificarTiempoGarantia()==0) {
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
							
							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>EL COMPONENTE EST&Aacute; EN GARANT&Iacute;A. ¿DESEA PONERLO FIN DE VIDA &Uacute;TIL DE TODAS MANERAS?</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnSi\" type=\"button\" value=\"SI\" value=\"CONTINUAR\" onclick=\"continuar()\">
							<input name=\"btnNo\" type=\"submit\" value=\"NO\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();
						}
						
						
						break 1;
					//CASO FIN DE VIDA UTIL GARANTIA
					case 'EST0000005':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES SOLO SE PUEDEN PONER FIN DE VIDA UTIL (GARANT&Iacute;A) DESDE EL MODULO DE GARANT&Iacute;A.</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();						
						break 1;												
					default:
				}
				break 1;
			//EN CASO DE QUE ESTE INOPERATIVO Y PASE A OTRO ESTADO.	
			case 'EST0000002':
				switch ($_POST[selEstado]) {
					case 'EST0000001':
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
						echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						//echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>RELLENE EL CAMPO CON INFORMACI&Oacute;N DE POR QU&Eacute; VA A COLOCAR EL COMPONENTE OPERATIVO NUEVAMENTE.</td>";
						echo "</tr>";				
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"finVidaUtilOperativo()\">
						<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						exit();						
						break 1;
					case 'EST0000002':
						$componente= new componente();
						
						//Datos del Equipo A Modificar
						$componente->setInventario($_POST[txtIdInventario],$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
						$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);
						
						//Datos del Estado 
						$componente->setInventarioPropiedad($_POST[selEstado],$login);
						
						//Datos de Ubicacion del Componente
						$componente->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
						$componente->setComponente($_POST[txtConfiguracionCampo]);						

						$resultadoModificarEquipoGarantia=$componente->modificarEquipoGarantia($_POST[txtConfiguracion]);
							if ($resultadoModificarEquipoGarantia==0) {
								$modificarEquipoGarantia="SI";
							}
							else { 
								$modificarEquipoGarantia="NO";
							}						
						$resultado=$componente->modificarComponente();
							if ($resultado==0) {
								$modificarComponente="SI";
							} else {
								$modificarComponente="NO";
							}						

						$resultadoUbicacion=$componente->ingresarInventarioUbicacion();
						if ($resultadoUbicacion==0) {
							$modificarUbicacion="SI";
						} else {
							$modificarUbicacion="NO";
						}
						$resultadoEstado=$componente->ingresarInventarioPropiedad();
						if ($resultadoEstado==0) {
							$modificarEstado="SI";
						} else {
							$modificarEstado="NO";
						}						


							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><B>MODIFICACIONES REALIZADAS:</B><br><br>
							<b>MODIFICACION DE DATOS:</b> $modificarComponente<br>
							<b>MODIFICACION DE EQUIPO ASOCIADO EN GARANTIA:</b> $modificarEquipoGarantia<br>
							<b>MODIFICACION DE ESTADO:</b> $modificarEstado<br>
							<b>MODIFICACION DE UBICACION:</b> $modificarUbicacion<br></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";							
						
						break 1;						
					case 'EST0000003':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES NO SE PUEDEN COLOCAR EN FIN DE VIDA &Uacute;TIL (OPERATIVO).</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();							
						break 1;
					case 'EST0000004':
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
						echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						//echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>RELLENE EL CAMPO CON INFORMACI&Oacute;N DE POR QU&Eacute; VA A COLOCAR EL COMPONENTE FIN DE VIDA UTIL.</td>";
						echo "</tr>";				
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"finVidaUtilOperativo()\">
						<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						exit();						
						break 1;
					//CASO FIN DE VIDA UTIL GARANTIA
					case 'EST0000005':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES SOLO SE PUEDEN PONER FIN DE VIDA UTIL (GARANT&Iacute;A) DESDE EL MODULO DE GARANT&Iacute;A.</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();							
						break 1;
				}
				break 1;
			case 'EST0000003':
				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
				echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
				echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
				echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
				echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
				echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
				echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
				echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

				echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
				echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES SOLO SE PUEDEN PONER FIN DE VIDA UTIL (GARANT&Iacute;A) DESDE EL MODULO DE GARANT&Iacute;A.</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				exit();					
				break 1;
			case 'EST0000004':
				
				switch ($_POST[selEstado]) {
					case 'EST0000001':
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
						echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						//echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>RELLENE EL CAMPO CON INFORMACI&Oacute;N DE POR QU&Eacute; VA A COLOCAR EL COMPONENTE OPERATIVO NUEVAMENTE.</td>";
						echo "</tr>";				
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"finVidaUtilOperativo()\">
						<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						exit();						
						break 1;
					case 'EST0000002':
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
						echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						//echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>RELLENE EL CAMPO CON INFORMACI&Oacute;N DE POR QU&Eacute; VA A COLOCAR EL COMPONENTE INOPERATIVO.</td>";
						echo "</tr>";				
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"finVidaUtilOperativo()\">
						<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						exit();							
						break 1;						
					case 'EST0000003':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES NO SE PUEDEN COLOCAR EN FIN DE VIDA &Uacute;TIL (OPERATIVO).</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();							
						break 1;
					case 'EST0000004':
						$componente= new componente();
						
						//Datos del Equipo A Modificar
						$componente->setInventario($_POST[txtIdInventario],$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
						$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);
						
						//Datos del Estado 
						$componente->setInventarioPropiedad($_POST[selEstado],$login);
						
						//Datos de Ubicacion del Componente
						$componente->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
						$componente->setComponente($_POST[txtConfiguracionCampo]);						

						$resultadoModificarEquipoGarantia=$componente->modificarEquipoGarantia($_POST[txtConfiguracion]);
							if ($resultadoModificarEquipoGarantia==0) {
								$modificarEquipoGarantia="SI";
							}
							else { 
								$modificarEquipoGarantia="NO";
							}						
						$resultado=$componente->modificarComponente();
							if ($resultado==0) {
								$modificarComponente="SI";
							} else {
								$modificarComponente="NO";
							}						

						$resultadoUbicacion=$componente->ingresarInventarioUbicacion();
						if ($resultadoUbicacion==0) {
							$modificarUbicacion="SI";
						} else {
							$modificarUbicacion="NO";
						}
						$resultadoEstado=$componente->ingresarInventarioPropiedad();
						if ($resultadoEstado==0) {
							$modificarEstado="SI";
						} else {
							$modificarEstado="NO";
						}						


							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><B>MODIFICACIONES REALIZADAS:</B><br><br>
							<b>MODIFICACION DE DATOS:</b> $modificarComponente<br>
							<b>MODIFICACION DE EQUIPO ASOCIADO EN GARANTIA:</b> $modificarEquipoGarantia<br>
							<b>MODIFICACION DE ESTADO:</b> $modificarEstado<br>
							<b>MODIFICACION DE UBICACION:</b> $modificarUbicacion<br></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";						
						break 1;
					//CASO FIN DE VIDA UTIL GARANTIA
					case 'EST0000005':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
							
							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES SOLO SE PUEDEN PONER FIN DE VIDA UTIL (GARANT&Iacute;A) DESDE EL MODULO DE GARANT&Iacute;A.</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();							
						break 1;
				}				
				
				break 1;
			case 'EST0000005':
				
				switch ($_POST[selEstado]) {
					case 'EST0000001':
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
						echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						//echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>RELLENE EL CAMPO CON INFORMACI&Oacute;N DE POR QU&Eacute; VA A COLOCAR EL COMPONENTE OPERATIVO NUEVAMENTE.</td>";
						echo "</tr>";				
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"finVidaUtilOperativo()\">
						<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						exit();						
						break 1;
					case 'EST0000002':
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
						echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
						echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
						echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						//echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>RELLENE EL CAMPO CON INFORMACI&Oacute;N DE POR QU&Eacute; VA A COLOCAR EL COMPONENTE INOPERATIVO.</td>";
						echo "</tr>";				
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"finVidaUtilOperativo()\">
						<input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						exit();							
						break 1;						
					case 'EST0000003':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES NO SE PUEDEN COLOCAR EN FIN DE VIDA &Uacute;TIL (OPERATIVO).</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();							
						break 1;
					case 'EST0000004':
						$componente= new componente();
						
						//Datos del Equipo A Modificar
						$componente->setInventario($_POST[txtIdInventario],$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
						$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);
						
						//Datos del Estado 
						$componente->setInventarioPropiedad($_POST[selEstado],$login);
						
						//Datos de Ubicacion del Componente
						$componente->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
						$componente->setComponente($_POST[txtConfiguracionCampo]);						

						$resultadoModificarEquipoGarantia=$componente->modificarEquipoGarantia($_POST[txtConfiguracion]);
							if ($resultadoModificarEquipoGarantia==0) {
								$modificarEquipoGarantia="SI";
							}
							else { 
								$modificarEquipoGarantia="NO";
							}						
						$resultado=$componente->modificarComponente();
							if ($resultado==0) {
								$modificarComponente="SI";
							} else {
								$modificarComponente="NO";
							}						

						$resultadoUbicacion=$componente->ingresarInventarioUbicacion();
						if ($resultadoUbicacion==0) {
							$modificarUbicacion="SI";
						} else {
							$modificarUbicacion="NO";
						}
						$resultadoEstado=$componente->ingresarInventarioPropiedad();
						if ($resultadoEstado==0) {
							$modificarEstado="SI";
						} else {
							$modificarEstado="NO";
						}						


							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><B>MODIFICACIONES REALIZADAS:</B><br><br>
							<b>MODIFICACION DE DATOS:</b> $modificarComponente<br>
							<b>MODIFICACION DE EQUIPO ASOCIADO EN GARANTIA:</b> $modificarEquipoGarantia<br>
							<b>MODIFICACION DE ESTADO:</b> $modificarEstado<br>
							<b>MODIFICACION DE UBICACION:</b> $modificarUbicacion<br></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"submit\" value=\"ACEPTAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";						
						break 1;
					//CASO FIN DE VIDA UTIL GARANTIA
					case 'EST0000005':
							echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
							echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
							echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
							echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
							echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";						
							echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
							echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
							echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
							echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
							echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
							echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
							echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
							echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";

							echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
							echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
							echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
							echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
							echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
							echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
							echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
							echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
							echo "<input name=\"txtEspecifico\" type=\"hidden\" value=\"$_POST[txtEspecifico]\">";											
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LOS COMPONENTES SOLO SE PUEDEN PONER FIN DE VIDA UTIL (GARANT&Iacute;A) DESDE EL MODULO DE GARANT&Iacute;A.</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							exit();							
						break 1;
				}								
				break 1;
			
				
			default:

		} 
		break 1;
	case 2:
		$componente= new componente();

		//Datos del Equipo A Modificar
		$componente->setInventario($_POST[txtIdInventario],$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
		$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);

		//Datos del Estado
		$componente->setInventarioPropiedad($_POST[selEstado],$login);

		//Datos de Ubicacion del Componente
		$componente->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
		$componente->setComponente($_POST[txtConfiguracionCampo]);
		$resultadoModificarEquipoGarantia=$componente->modificarEquipoGarantia($_POST[txtConfiguracion]);
		if ($resultadoModificarEquipoGarantia==0) {
			$modificarEquipoGarantia="SI";
		}
		else {
			$modificarEquipoGarantia="NO";
		}
		$resultado=$componente->modificarComponente();
		if ($resultado==0) {
			$modificarComponente="SI";
		} else {
			$modificarComponente="NO";
		}

		$resultadoUbicacion=$componente->ingresarInventarioUbicacion();
		if ($resultadoUbicacion==0) {
			$modificarUbicacion="SI";
		} else {
			$modificarUbicacion="NO";
		}
		$resultadoEstado=$componente->ingresarInventarioPropiedad();
		if ($resultadoEstado==0) {
			$modificarEstado="SI";
			if ($_POST[selEstado]!='EST0000001')
				$componente->desvincularComponente();
		} else {
			$modificarEstado="NO";
		}

		echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
		echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
		echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";

		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
						</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><B>MODIFICACIONES REALIZADAS:</B><br><br>
			<b>MODIFICACION DE DATOS:</b> $modificarComponente<br>
			<b>MODIFICACION DE EQUIPO ASOCIADO EN GARANTIA:</b> $modificarEquipoGarantia<br>
			<b>MODIFICACION DE ESTADO:</b> $modificarEstado<br>
			<b>MODIFICACION DE UBICACION:</b> $modificarUbicacion<br></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"submit\" value=\"ACEPTAR\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
		break 1;
		
	case 3:
		//Datos del Equipo A Modificar
		$componente= new componente();
		$componente->setInventario($_POST[txtIdInventario],$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
		$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);

		//Datos del Estado
		$componente->setInventarioPropiedad($_POST[selEstado],$login);

		//Datos de Ubicacion del Componente
		$componente->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
		$componente->setComponente($_POST[txtConfiguracionCampo]);
		$resultadoModificarEquipoGarantia=$componente->desvincularComponenteEquipoGarantia($_POST[txtConfiguracion]);
		
		if ($resultadoModificarEquipoGarantia==0) {
			echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
			echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
			echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
	
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><B>SE DESVINCUL&Oacute; EL COMPONENTE DEL EQUIPO EN GARANT&Iacute;A.</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"submit\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table>";
			echo "</form>";			
		} else {
			echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
			echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
			echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
	
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR COMPONENTE</td>
							</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><B>IMPOSIBLE DESVINCULAR EL COMPONENTE DEL EQUIPO EN GARANT&Iacute;A.</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnContinuar\" type=\"submit\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table>";
			echo "</form>";			

		}
		break 1;
		

	default:
		formularioComponente();
}


function formularioComponente($pedidoStatus=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "pedidoAdmin.php";
	require_once("inventarioAdmin.php");
	
//Busca un componente con el serial dado y lo muestra en el formulario	
	if ($_POST[txtCambiarSeleccion]==0)
	if (isset($_POST[txtSerial]) && !empty($_POST[txtSerial])) {
		$modificarComponente= new componente();
		$modificarComponente->setInventario("",$_POST[txtSerial]);
		$resultadoComponentes=$modificarComponente->buscarComponentesModificar();
		if ($resultadoComponentes && $resultadoComponentes!=1) {
			$rowComponente=mysql_fetch_array($resultadoComponentes);
			$_POST[txtIdInventario]=$rowComponente[0];
			$modificarComponente->setInventario($_POST[txtIdInventario],$_POST[txtSerial]);
			$_POST[txtSerial]=$rowComponente[1];
			$_POST[selDescripcion]=$rowComponente[2];
			$_POST[selMarca]=$rowComponente[4];
			$_POST[selModelo]=$rowComponente[6];
			$_POST[selPedido]=$rowComponente[25];

			
			$_POST[txtFechaInicio]=substr($rowComponente[32],8,2).'/'.substr($rowComponente[32],5,2).'/'.substr($rowComponente[32],0,4);
			$_POST[txtFechaFinal]=substr($rowComponente[33],8,2).'/'.substr($rowComponente[33],5,2).'/'.substr($rowComponente[33],0,4);
			$_POST[txtCt]=$rowComponente[13];
 			$_POST[txtFru]=$rowComponente[10];
			$_POST[txtProductNumber]=$rowComponente[11];
			$_POST[txtSpareNumber]=$rowComponente[12];
			$_POST[txtEspecifico]=$rowComponente[22];
			$especifico=$rowComponente[22];
			$_POST[selSitio]=$rowComponente[20];
			$sitio=$rowComponente[21];
			$_POST[selGerencia]=$rowComponente[14];
			$gerencia=$rowComponente[15];
			$_POST[selDivision]=$rowComponente[16];
			$division=$rowComponente[17];
			$_POST[selDepartamento]=$rowComponente[18];
			$departamento=$rowComponente[19];
			$_POST[selEstado]=$rowComponente[41];
			$_POST[txtEstadoAnterior]=$rowComponente[41];
			
			$configuracionAsociada= new equipo();
			$configuracionAsociada->setInventario($_POST[txtIdInventario]);
			
			$resultadoConfiguracion=$configuracionAsociada->buscarComponentesAsociados();
			if ($resultadoConfiguracion && $resultadoConfiguracion!=1) {
				$rowConfiguracion=mysql_fetch_array($resultadoConfiguracion);
				$_POST[txtConfiguracionCampo]=$rowConfiguracion[1];
				$configuracionAsociada->setEquipo($_POST[txtConfiguracionCampo]);
				$resultadoEquipoCampo=$configuracionAsociada->buscarEquipo();
				if ($resultadoEquipoCampo && $resultadoEquipoCampo!=1) {
					$rowEquipo=mysql_fetch_array($resultadoEquipoCampo);
					$descripcionEquipo=$rowEquipo[5];
					$marcaEquipo=$rowEquipo[7];
					$modeloEquipo=$rowEquipo[9].' '.$rowEquipo[10].' '.$rowEquipo[11];	
					$serialEquipo=$rowEquipo[3];	
				}
			}
			
			$equipoGarantia=$modificarComponente->buscarComponentesGarantia();

			if ($_POST[txtBuscarConfiguracion]==0)	
			if ($equipoGarantia && $equipoGarantia!=1) {

				$rowEquipoGarantia=mysql_fetch_array($equipoGarantia);
				$_POST[txtConfiguracion]=$rowEquipoGarantia[0];
				$descripcionEquipoGarantia=$rowEquipoGarantia[5];
				$marcaEquipoGarantia=$rowEquipoGarantia[7];
				$modeloEquipoGarantia=$rowEquipoGarantia[9].' '.$rowEquipoGarantia[10].' '.$rowEquipoGarantia[11];
				$serialEquipoGarantia=$rowEquipoGarantia[3];
			} else {
				unset($_POST[txtConfiguracion]);
				unset($descripcionEquipoGarantia);
				unset($marcaEquipoGarantia);
				unset($modeloEquipoGarantia);
				unset($serialEquipoGarantia);
			}
		} else {
			unset($_POST);
		}
	}
	if ($_POST[txtBuscarConfiguracion]==1)
	if (isset($_POST[txtConfiguracion]) && !empty($_POST[txtConfiguracion])) {
		$modificarEquipo=new equipo();
		$modificarEquipo->setEquipo($_POST[txtConfiguracion]);
		$resultadoEquipo=$modificarEquipo->buscarEquipo();
		if ($resultadoEquipo && $resultadoEquipo!=1) {
			$rowEquipo=mysql_fetch_array($resultadoEquipo);

			$_POST[txtConfiguracionCampo]=$rowEquipo[0];
			$descripcionEquipoGarantia=$rowEquipo[5];
			$marcaEquipoGarantia=$rowEquipo[7];
			$modeloEquipoGarantia=$rowEquipo[9].' '.$rowEquipo[10].' '.$rowEquipo[11];	
			$serialEquipoGarantia=$rowEquipo[3];	
			
		}
	}
	
	//Consultas para los Campos de Selección
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION_PROPIEDAD<>'DSP0000004' ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	$conModelo="SELECT ID_MODELO, CONCAT(MODELO,' ',CAP_VEL,' ',UNIDAD) AS MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY MODELO";

	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_UBICACION_PROPIEDAD='UBP0000003' ORDER BY SITIO";
	$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";
	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado where estatus_activo=1";
	
	//Llamadas a las clases para generar el formulario con los Campos de Texto y Selección




	$conSitio="SELECT ID_SITIO,SITIO FROM sitio where status_activo=1 ORDER BY SITIO";
	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia ORDER BY GERENCIA";
	$conDivision="SELECT ID_DIVISION, DIVISION FROM division WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
	$conDepartamento="SELECT ID_DEPARTAMENTO,DEPARTAMENTO FROM departamento WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";


	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();
		
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();
		
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();
	
	


	if (isset($_POST[txtConfiguracion]) && !empty($_POST[txtConfiguracion])) {
		$selPedido= "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">"."<b class=\"campo\">$_POST[selPedido]</b>";
		$txtFechaInicio= "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">"."<b class=\"campo\">$_POST[txtFechaInicio]</b>";
		$txtFechaFinal= "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">"."<b class=\"campo\">$_POST[txtFechaFinal]</b>";
	} else {
		$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onchange","cambiarPedido()",$conPedido,"--PEDIDO--","");
		$selPedido=$pedido->retornar();		

		if ($pedidoStatus==1) {
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
	
		$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
		$txtFechaInicio=$fechaInicio->retornar();
		$txtFechaInicio=$txtFechaInicio."<a href=\"javascript:show_calendar('frmComponente.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a>";
	
		$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
		$txtFechaFinal=$fechaFinal->retornar();	
		$txtFechaFinal=$txtFechaFinal."<a href=\"javascript:show_calendar('frmComponente.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a>";
	}


	$ct= new campo("txtCt","text","formularioCampoTexto","$_POST[txtCt]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtCt=$ct->retornar();

	$fru= new campo("txtFru","text","formularioCampoTexto","$_POST[txtFru]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtFru=$fru->retornar();

	$productNumber= new campo("txtProductNumber","text","formularioCampoTexto","$_POST[txtProductNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtProductNumber=$productNumber->retornar();
	
	$spareNumber= new campo("txtSpareNumber","text","formularioCampoTexto","$_POST[txtSpareNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSpareNumber=$spareNumber->retornar();

	
	if (isset($rowConfiguracion[1]) && !empty($rowConfiguracion[1])) {
		$selSitio= "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">"."<b class=\"campo\">$sitio</b>";
		$selGerencia="<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">"."<b class=\"campo\">$gerencia</b>";
		$selDivision="<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">"."<b class=\"campo\">$division</b>";
		$selDepartamento="<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">"."<b class=\"campo\">$departamento</b>";
	} else {
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
	}
	
	//Campo Estado
	$estado= new campoSeleccion("selEstado","formularioCampoSeleccion","$_POST[selEstado]","","",$conEstado,"--ESTADO--","");
	$selEstado=$estado->retornar();
	
	
	echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"txtBuscarConfiguracion\" type=\"hidden\" value=\"0\">";
	echo "<input name=\"txtCambiarSeleccion\" type=\"hidden\" value=\"0\">";
	echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
	echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
	echo "<input name=\"txtConfiguracionCampo\" type=\"hidden\" value=\"$_POST[txtConfiguracionCampo]\">";
	echo "<input name=\"txtEstadoAnterior\" type=\"hidden\" value=\"$_POST[txtEstadoAnterior]\">";
	//Datos del Componente.
	
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">MODIFICAR COMPONENTE</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL COMPONENTE</td>
  				</tr>
    		<td valign=top class=\"formularioCampoTitulo\">SERIAL<br>
			$txtSerial<input name=\"btnBuscarSerial\" title=\"Buscar Serial\" type=\"button\" value=\"B\" onClick=\"buscarSerial()\"><br>
			DESCRIPCION<br>$selDescripcion<br>
			MARCA<br>$selMarca<br>

			MODELO<br>$selModelo<br>

			<td valign=top class=\"formularioCampoTitulo\">CT<br>
			$txtCt<br>
			FRU<br>$txtFru<br>
			PRODUCT NUMBER<br>$txtProductNumber<br>
			SPARE NUMBER<br>$txtSpareNumber<br>
			ESTADO<br>$selEstado<br>
			</td>
		</tr>";
		echo "<tr>";
			echo "<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">EQUIPO ASOCIADO EN CAMPO</td>
  				</tr>";
  		echo "<tr>
			<td class=\"formularioCampoTitulo\">CONFIGURACION<br><b class=\"campo\">$rowConfiguracion[1]</b><br>
			MARCA / MODELO<br><b class=\"campo\">$marcaEquipo $modeloEquipo</b></td>
			<td class=\"formularioCampoTitulo\">
			DESCRIPCION<br><b class=\"campo\">$descripcionEquipo</b><br>
			SERIAL<br><b class=\"campo\">$serialEquipo</b></td>
		</tr>";			
		echo "<tr>";
			echo "<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>
  				</tr>";
			
	
  		echo "<tr>
			<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>
			GERENCIA<br>$selGerencia</td>
			<td class=\"formularioCampoTitulo\">
			DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento</td>
		</tr>";
		echo "<tr>";
		echo "<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
		echo "</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">INFORMACION PARA GARANTIA</td>
			<td class=\"formularioTablaTitulo\">EQUIPO ASOCIADO EN GARANTIA</td>
			</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">PEDIDO<br>$selPedido<br>
			FECHA INICIO (GARANTIA)<br>$txtFechaInicio</br>
			FECHA FINAL (GARANTIA)<br>$txtFechaFinal<br>
			</td>
			<td class=\"formularioCampoTitulo\" valign=\"top\">
			CONFIGURACION<br><input name=\"txtConfiguracion\" class=\"formularioCampoTexto\" type=\"text\" value=\"$_POST[txtConfiguracion]\"><input name=\"btnConfiguracion\" type=\"button\" value=\"B\" title=\"Buscar Configuracion del Equipo Original\" onClick=\"buscarConfiguracion()\"><br>
			DESCRIPCION<br><b class=\"campo\">$descripcionEquipoGarantia</b><br>
			MARCA / MODELO / SERIAL<br><b class=\"campo\">$marcaEquipoGarantia $modeloEquipoGarantia $serialEquipoGarantia</b>";
			if (isset($descripcionEquipoGarantia) && !empty($descripcionEquipoGarantia)) {
				echo "<input name=\"btnDesvincular\" type=\"button\" value=\"DESVINCULAR\" onclick=\"desvincularComponenteEquipoGarantia()\">";
			}
			echo "<br>
			</td>			
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\">
				<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=160'\">
				<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\">
				</td>
  				</tr>";			
		echo "</table>";
	echo "</form>";
}
?>

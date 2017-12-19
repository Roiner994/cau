<?php
require_once("seguridad.php");
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmComponente.funcion.value=0;
		document.frmComponente.submit();
	}
	function reincorporar() {
		document.frmComponente.funcion.value=4;
		document.frmComponente.submit();
	}
	function buscarSerial() {
		if (document.frmComponente.txtSerial.value!="") {
			document.frmComponente.funcion.value=3;
			document.frmComponente.submit();
		}
	}
	function Letras(e) { 
		tecla = (document.all) ? e.keyCode : e.which; 
		if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    		patron ="/[0-9/]/"; // Solo acepta letras 
			te = String.fromCharCode(tecla); 
    	return patron.test(te); 
	}

</script>
<?php
switch($funcion) {
	case 1:
		if (isset($_POST[txtSerial]) && empty($_POST[txtSerial])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SERIAL</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selDescripcion]) && $_POST[selDescripcion]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DESCRIPCION</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selMarca]) && $_POST[selMarca]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>MARCA</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selModelo]) && $_POST[selModelo]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>MODELO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selEstado]) && $_POST[selEstado]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>ESTADO</b>";
			$i++;
			$sw=1;
		}
		switch($i) {
			case 0:
				require_once("administracion.php");
				require_once "usuarioSistemaAdmin.php";
				require_once("inventarioAdmin.php");
				require_once "conexionsql.php";
				$login=$_SESSION["login"];
				$nuevoComponente=new componente();
				//Ingresa Datos detallados del Equipo
				$nuevoComponente->setInventario("",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
				$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);
				//Ingresa el Estado del Equipo
				$nuevoComponente->setInventarioPropiedad("EST0000001",$login);
				//Ingresa los Datos de la Ubicacion
				$nuevoComponente->setInventarioUbicacion("ORG0000065","SIT0000057","",$login);
				$resultado=$nuevoComponente->nuevoComponente();
				switch($resultado) {
					case 0:
						$nuevoComponente->setComponente($_POST[txtConfiguracion]);
						$nuevoComponente->ingresarComponenteGarantia();
						
						
						//Cambia el equipo a garantia ejecutada;
						require_once("garantiaAdmin.php");
						$garantia= new garantia();
						$garantia->setGarantia($_POST[txtIdGarantia],"","","STG0000004");
						$resultado=$garantia->cambiarStatusReemplazo();
						$viejoComponente=new componente();
						$viejoComponente->setInventario($_POST[txtIdInventarioViejo],"","","","","","","","","","","","",$login);
						$viejoComponente->setInventarioPropiedad("EST0000005",$login);
						$viejoComponente->setInventarioUbicacion("ORG0000020","SIT0000073","SALIO FUERA DE PLANTA POR GARANTIA",$login);
						$resultado=$viejoComponente->ingresarInventarioPropiedad();
						$resultado=$viejoComponente->ingresarInventarioUbicacion();
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						

						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";	
						echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";					
	
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REEMPLAZO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO NUEVO COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>
  						
						</tr>";
						
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						

						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";						

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REEMPLAZO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">
						</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					case 2:
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						

						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";						
						

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REEMPLAZO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR. SERIAL DUPLICADO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">
						</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
				}
				break 1;
			case 4:
				require_once "administracion.php";
				require_once "usuarioSistemaAdmin.php";
				require_once("inventarioAdmin.php");
				require_once "conexionsql.php";
				$login=$_SESSION["login"];
				


				$nuevoComponente=new componente();
				//Ingresa Datos detallados del Equipo
				$nuevoComponente->setInventario("",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
				$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);
				//Ingresa el Estado del Equipo
				$nuevoComponente->setInventarioPropiedad("EST0000001",$login);
				//Ingresa los Datos de la Ubicacion
				$nuevoComponente->setInventarioUbicacion("ORG0000065","SIT0000057",$_POST[txtEspecifico],$login);
				$nuevoComponente->setComponente($_POST[txtConfiguracion]);
				$resultado=$nuevoComponente->nuevoComponente();
				switch($resultado) {
					case 0:
						$nuevoComponente->ingresarComponenteGarantia();
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						

						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";	
						echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";					
	
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REEMPLAZO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO NUEVO COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>
  						
						</tr>";
						
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						

						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";						

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REEMPLAZO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">
						</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;

				}
				break 1;
				

			default:
				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

				echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
				echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
				echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
				echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
				echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
				echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
				echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
				echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";	
				echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";						
					

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REEMPLAZO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&Iacute;OS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">
				</td>";
				echo "</tr>";
				echo "</table>";				
				echo "</form>";
		}
		break 1;
	case 2:
		formularioComponente($serial);
		break 1;
	case 3:
		require_once "Administracion.php";
		require_once "usuarioSistemaAdmin.php";
		require_once "equipoAdmin.php";
		require_once "conexionsql.php";
		require_once "garantiaAdminYosmar.php";
		$equipo2=new equipo($_POST[txtConfiguracion],$_POST[txtActivoFijo],"",$_POST[txtSerial]);
		$resultado2=$equipo2->buscarSerial();
		switch($resultado2) {
			case 0:
				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
				echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
				echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
				echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
				echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
				echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
				echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
				echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
				echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
				echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";	
				echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";						
					

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>YA EXISTE UN COMPONENTE CON ESE SERIAL</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;
			case 1:
				formularioComponente($serial);
				break 1;
			case 6:
				break 1;
		}
		break 1;
case 4:
				require_once "usuarioSistemaAdmin.php";
				require_once("garantiaAdmin.php");
				require_once("inventarioAdmin.php");
				$login=$_SESSION["login"];
				$viejoComponente=new componente();
				$viejoComponente->setInventario($_POST[txtIdInventarioViejo]);
				$viejoComponente->setInventarioPropiedad("EST0000001",$login);
				//Ingresa los Datos de la Ubicacion
				$viejoComponente->setInventarioUbicacion("ORG0000065","SIT0000057","SE REINTEGRO DESDE EL MODULO GARANTIA",$login);
				$resultadoPropiedad=$viejoComponente->ingresarInventarioPropiedad();
				$resultadoUbicacion=$viejoComponente->ingresarInventarioUbicacion();
				if ($resultadoPropiedad==0 || $resultadoUbicacion==0) {
					$resultado=0;
				} else {
					$resultado=1;
				}
				switch($resultado) {
					case 0:
						$garantia= new garantia();
						$garantia->setGarantia($_POST[txtIdGarantia],"","","STG0000004");
						$resultado=$garantia->cambiarStatusReemplazo();
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						

						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";	
						echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";					
	
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REINTEGRO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE REINCORPORO COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>
  						
						</tr>";
						
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						

						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
						echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$row[13]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$row[14]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$row[3]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";						

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: GARANTIA - COMPONENTE REEMPLAZO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE GUARDAR EL COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">
						</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;

				}
				break 1;
				

		
		break 1;
		
default:
		formularioComponente($serial);
}


function formularioComponente($Serial="") {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "garantiaAdmin.php";
	$conDescripcion="SELECT distinct descripcion.ID_DESCRIPCION,DESCRIPCION FROM descripcion
					inner join inventario on inventario.id_descripcion=descripcion.id_descripcion
					WHERE ID_DESCRIPCION_PROPIEDAD<>'DSP0000004' and inventario.serial='$Serial' ";
	

	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();
		

	
		
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();

	
	$ct= new campo("txtCt","text","formularioCampoTexto","$_POST[txtCt]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtCt=$ct->retornar();

	$fru= new campo("txtFru","text","formularioCampoTexto","$_POST[txtFru]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtFru=$fru->retornar();

	$productNumber= new campo("txtProductNumber","text","formularioCampoTexto","$_POST[txtProductNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtProductNumber=$productNumber->retornar();
	
	$spareNumber= new campo("txtSpareNumber","text","formularioCampoTexto","$_POST[txtSpareNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSpareNumber=$spareNumber->retornar();

	//echo "SERIAL: SERIAL: $Serial";
	if (isset($Serial) && !empty($Serial)) {
		$componenteViejo= new garantia();
		$resultado=$componenteViejo->retornarEquiposReportados("","",$Serial);
		$row=mysql_fetch_array($resultado);
		$_POST[txtIdGarantia]=$row[0];
		$_POST[txtFechaInicio]=substr($row[22],8,2).'/'.substr($row[22],5,2).'/'.substr($row[22],0,4);
		$_POST[txtFechaFinal]=substr($row[23],8,2).'/'.substr($row[23],5,2).'/'.substr($row[23],0,4);
		$_POST[selDescripcion]=$row[9];
		$_POST[txtDescripcion]=$row[10];
		$_POST[selPedido]=$row[24];
		$_POST[txtConfiguracion]=$row[32];
		$_POST[txtSerialViejo]=$row[8];
		$_POST[txtActivoFijo]=$row[32];
		$_POST[txtIdInventarioViejo]=$row[1];
	}

	echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
	echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
	echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
	echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
	echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
	echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
	echo "<input name=\"txtIdGarantia\" type=\"hidden\" value=\"$_POST[txtIdGarantia]\">";
	echo "<input name=\"txtSerialViejo\" type=\"hidden\" value=\"$_POST[txtSerialViejo]\">";
	echo "<input name=\"txtActivoFijo\" type=\"hidden\" value=\"$_POST[txtActivoFijo]\">";
	echo "<input name=\"txtIdInventarioViejo\" type=\"hidden\" value=\"$_POST[txtIdInventarioViejo]\">";
	echo "<input name=\"txtIdEstado\" type=\"hidden\" value=\"$_POST[txtIdEstado]\">";
	
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
				WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ',unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
  
	
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();
	
	$descripcion= new campo("txtDescripcion","text","formularioCampoTexto","$_POST[txtDescripcion]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtDescripcion=$descripcion->retornar();
	//REEMPLAZO POR GARANTIA
	
		echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">COMPONENTE NUEVO POR GARANTIA</td>
  				</tr>";
//DATOS DEL COMPONENTE A SER REEMPLAZADO
				echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" align=\"center\" colspan=\"5\">DATOS COMPONENTE A REEMPLAZAR</td>
			</tr>";	
	
	
echo "<table width=\"700\" border=\"0\" align=\"center\">
		   <tr>
		  <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCI&Oacute;N</b></td>		  
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  
		  
		  </tr>";
		$componenteViejo= new garantia();
		$resultado=$componenteViejo->retornarEquiposReportados("","",$Serial);
		while($row=mysql_fetch_array($resultado)) {
			 	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			
			
		echo "<tr class=\"$clase\">			    
			<td>$row[8]</td>
			<td>$row[10]</td>				
			<td>$row[13]</td>
			<td>$row[15] $row[16] $row[17]</td>
							
				</tr>";
		$i++;
		$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";
			
	}	
			
		echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			
		//echo "</form>";
			
		
//DATOS DEL NUEVO COMPONENTE
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL NUEVO COMPONENTE</td>
  				</tr>
    		<td valign=top class=\"formularioCampoTitulo\">SERIAL<br>
			$txtSerial<input name=\"btn\" type=\"button\" value=\"C\" onClick=\"buscarSerial()\"><br>
			DESCRIPCION<br>$txtDescripcion<br>
			MARCA<br>$selMarca<br>
			MODELO<br>$selModelo<br>

			<td valign=top class=\"formularioCampoTitulo\">CT<br>
			$txtCt<br>
			FRU<br>$txtFru<br>
			PRODUCT NUMBER<br>$txtProductNumber<br>
			SPARE NUMBER<br>$txtSpareNumber<br>
			</td>
		</tr>";
		
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\">
				<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\">
				<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\">
				<input name=\"btnReincorporar\" type=\"button\" value=\"REINCORPORACION\"onClick=\"reincorporar()\">
  						
				</td>
  				</tr>";				
		echo "</table>";
	echo "</form>";
}

?>

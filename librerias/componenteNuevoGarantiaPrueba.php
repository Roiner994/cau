<?php
session_start();
$Acceso=array ("PRV0000001");
switch ($_SESSION[authUser]) {
	case '0':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
		exit();
		break 1;
	case '1':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
		exit();
		break 1;
	default:
	require_once  "../librerias/usuarioSistemaAdmin.php";
	require_once "../librerias/conexionsql.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$resultado= $acceso->validar();
	switch ($resultado) {
		case 1:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";		
			exit();
			break 1;
		case 2:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			exit();
			break 1;
		default:
			foreach($Acceso as $valor) {
				if ($_SESSION['authUser']!=$valor) {
					$sw=1;
				} else {
					$sw=0;
					break 1;
				}
			}
			if ($sw==1) {
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";	
				exit();
			}
	}
}

?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmComponente.funcion.value=0;
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
require_once "componenteAdminYosmar.php";
require_once "garantiaAdminYosmar.php";

/*$componente=new componente($idInventario,$serial,$descripcion,$marca,$modelo,$fru,$productNumber,$spareNumber,
		$ct,$fechaAsociacion,$idEstado,$fechaIngreso,$fechaFinal,$idPedido,$disponible,$idUbicacion,$idGerencia,$idDivision,
		$idDepartamento,$idSitio,$login);
$resultado=$componente->prueba();*/
switch($funcion) {
	case 1:
		require_once "Administracion.php";
		/*if ((isset($_POST[txtFechaInicio]) && !empty($_POST[txtFechaInicio])) && (isset($_POST[txtFechaFinal]) && !empty($_POST[txtFechaFinal]))) {
			$fechaInicio= new fecha($_POST[txtFechaInicio]);
			$fechaFinal= new fecha ($_POST[txtFechaFinal]);
			$fechaI=$fechaInicio->validar();
			$fechaF=$fechaFinal->validar();
			if ($fechaI!=0 && $fechaF!=0) {
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
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

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>UNO O LOS DOS CAMPOS DE FECHA SON INVALIDOS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;
			} else {
				if (compara_fechas($_POST[txtFechaFinal],$_POST[txtFechaInicio]) <0) {
					echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
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

					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - NUEVO EQUIPO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>LA FECHA FINAL NO PUEDE SER MENOR QUE LA FECHA INICIAL</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";	
					break 1;
				}
			}
		}*/
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
		if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>SITIO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>GERENCIA</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selDivision]) && $_POST[selDivision]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DIVISION</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selDepartamento]) && $_POST[selDepartamento]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DEPARTAMENTO</b>";
			$i++;
			$sw=1;
		}
		switch($i) {
			case 0:
				require_once "Administracion.php";
				require_once "usuarioSistemaAdmin.php";
				require_once "componenteAdminYosmar.php";
				require_once "conexionsql.php";
				$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
				$login=$acceso->login();
				
				//echo "configuracion-$_POST[txtConfiguracion]";
			$componente=new componente("",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],
				$_POST[txtCt],"","EST0000001",$_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selPedido],1,"","ORG0000020","ORG0000065","ORG0000065",
				'SIT0000057',$login,"","9999999","",$_POST[txtSerialViejo],0,$_POST[txtConfiguracion],$_POST[txtActivoFijo],$_POST[txtIdInventarioViejo]);

				$resultado=$componente->ingresar();
				switch($resultado) {
					case 0:
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
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='secciones.php?item=506'\"></td>
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
	default:
		formularioComponente($serial);
}


function formularioComponente($Serial="") {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "garantiaAdminYosmar.php";
	//Consultas para los Campos de Selección
	$conDescripcion="SELECT distinct descripcion.ID_DESCRIPCION,DESCRIPCION FROM descripcion
					inner join inventario on inventario.id_descripcion=descripcion.id_descripcion
					WHERE ID_DESCRIPCION_PROPIEDAD<>'DSP0000004' and inventario.serial='$Serial' ";
	
	/*$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
				WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ',unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
    */
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_UBICACION_PROPIEDAD='UBP0000003' ORDER BY SITIO";
	
	
	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado ORDER BY ID_ESTADO";	
	//Llamadas a las clases para generar el formulario con los Campos de Texto y Selección

	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	
	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia ORDER BY GERENCIA";
	
	$conDivision="SELECT ID_DIVISION, DIVISION FROM division WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
	
	$conDepartamento="SELECT ID_DEPARTAMENTO,DEPARTAMENTO FROM departamento WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";


	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();
		
	/*$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();	*/
	
		
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
	
	//Campo Estado
	$estado= new campoSeleccion("selEstado","formularioCampoSeleccion","$_POST[selEstado]","","",$conEstado,"--ESTADO--","");
	$selEstado=$estado->retornar();
	//echo "SERIAL: SERIAL: $Serial";
	if (isset($Serial) && !empty($Serial)) {
		$componenteViejo= new garantia("","","","","","","","","",$Serial);
		$resultado=$componenteViejo->equipoReemplazoPrueba();
		$row=mysql_fetch_array($resultado);
		
		$_POST[txtFechaInicio]=$row[9];
		$_POST[txtFechaFinal]=$row[10];
		$_POST[selDescripcion]=$row[15];
		$_POST[txtDescripcion]=$row[7];
		$_POST[selPedido]=$row[3];
		$_POST[txtConfiguracion]=$row[12];
		$_POST[txtSerialViejo]=$row[14];
		$_POST[txtActivoFijo]=$row[13];
		$_POST[txtIdInventarioViejo]=$row[1];
		
	
	}

	echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"txtFechaInicio\" type=\"text\" value=\"$_POST[txtFechaInicio]\">";
	echo "<input name=\"txtFechaFinal\" type=\"text\" value=\"$_POST[txtFechaFinal]\">";
	echo "<input name=\"selDescripcion\" type=\"text\" value=\"$_POST[selDescripcion]\">";
	echo "<input name=\"txtDescripcion\" type=\"text\" value=\"$_POST[txtDescripcion]\">";
	echo "<input name=\"selPedido\" type=\"text\" value=\"$_POST[selPedido]\">";
	echo "<input name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\">";
	echo "<input name=\"txtSerialViejo\" type=\"text\" value=\"$_POST[txtSerialViejo]\">";
	echo "<input name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\">";
	echo "<input name=\"txtIdInventarioViejo\" type=\"text\" value=\"$_POST[txtIdInventarioViejo]\">";
	
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
	
//$resultado=$despacho->equipoFueraPlanta();	
	
echo "<table width=\"700\" border=\"0\" align=\"center\">
		   <tr>
		  <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCI&Oacute;N</b></td>		  
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  
		  
		  </tr>";
		$resultado=$componenteViejo->equipoReemplazoPrueba();
		while($row=mysql_fetch_array($resultado)) {
			 	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			
			
		echo "<tr class=\"$clase\">			    
			<td>$row[2]</td>
			<td>$row[7]</td>				
			<td>$row[6]</td>
			<td>$row[8]</td>
							
				</tr>";
		$i++;
		$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";
			
	}	
					/*echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"7\">TOTAL: $total</td>
			</tr>";	
		echo "</table>";*/
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
			//DATOS DE LA UBICACION
					/*echo "<tr>";
			echo "<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>
  				</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>
			GERENCIA<br>$selGerencia<br>
			DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento<br><td>
		</tr>";*/
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\">
				<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\">
				<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\">
				</td>
  				</tr>";				
		echo "</table>";
	echo "</form>";
}

?>

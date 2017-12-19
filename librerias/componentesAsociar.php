<?php
require_once("seguridad.php");
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmComponente.funcion.value=0;
		document.frmComponente.submit();
	}
	function cambiarPedido() {
		document.frmComponente.funcion.value=3;
		document.frmComponente.submit();
	}
	function buscarSerial() {
		if (document.frmComponente.txtSerial.value!="") {
			document.frmComponente.funcion.value=10;
			document.frmComponente.submit();
		}
	}
</script>
<?php
//require_once "componenteAdmin.php";
//$idInventario=$_SESSION[idInventario];
/*$componente=new componente($idInventario,$serial,$descripcion,$marca,$modelo,$fru,$productNumber,$spareNumber,
		$ct,$fechaAsociacion,$idEstado,$fechaIngreso,$fechaFinal,$idPedido,$disponible,$idUbicacion,$idGerencia,$idDivision,
		$idDepartamento,$idSitio,$login);
$resultado=$componente->prueba();*/
switch($funcion) {
	case 1:
		require_once "administracion.php";
		if ((isset($_POST[txtFechaInicio]) && !empty($_POST[txtFechaInicio])) && (isset($_POST[txtFechaFinal]) && !empty($_POST[txtFechaFinal]))) {
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
				echo "<input name=\"txtProductNumber]\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
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
				echo "<input name=\"optGarantia\" type=\"hidden\" value=\"$_POST[optGarantia]\">";

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
					echo "<input name=\"txtProductNumber]\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
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
					echo "<input name=\"optGarantia\" type=\"hidden\" value=\"$_POST[optGarantia]\">";

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
		}
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
		if ($_POST[optGarantia]==0) {
			if (isset($_POST[selPedido]) && $_POST[selPedido]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PEDIDO</b>";
			$i++;
			$sw=1;
			}			
		}
		switch($i) {
			case 0:
				require_once "administracion.php";
				require_once "usuarioSistemaAdmin.php";
				require_once "inventarioAdmin.php";
				require_once "conexionsql.php";
				$login=$_SESSION["login"];
				$nuevoComponente=new componente();
				//Ingresa Datos detallados del Equipo
				$nuevoComponente->setInventario("",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],
				$_POST[txtFechaInicio],$_POST[txtFechaFinal],1);
				//Ingresa el Estado del Equipo
				$nuevoComponente->setInventarioPropiedad($_POST[selEstado],$login);
				//Ingresa los Datos de la Ubicacion
				$nuevoComponente->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
				$nuevoComponente->setComponente($_POST[txtEConfiguracion]);
				if ($_POST[optGarantia]==0)
					$resultado=$nuevoComponente->asociarNuevoComponenteEquipo();
				else
					$resultado=$nuevoComponente->asociarNuevoComponenteEquipo(1);
				switch($resultado) {
					case 0:
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber]\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
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
						echo "<input name=\"optGarantia\" type=\"hidden\" value=\"$_POST[optGarantia]\">";

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - NUEVO COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO EL NUEVO COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=151&config=$_POST[txtEConfiguracion]'\">
						</td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
						echo "<input name=\"txtProductNumber]\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
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
						echo "<input name=\"optGarantia\" type=\"hidden\" value=\"$_POST[optGarantia]\">";	
					
						
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - NUEVO COMPONENTE</td>
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
						echo "<input name=\"txtProductNumber]\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
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
						echo "<input name=\"optGarantia\" type=\"hidden\" value=\"$_POST[optGarantia]\">";	
						
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - NUEVO COMPONENTE</td>
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
				echo "<input name=\"txtProductNumber]\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
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
				echo "<input name=\"optGarantia\" type=\"hidden\" value=\"$_POST[optGarantia]\">";	
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - NUEVO COMPONENTE</td>
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
		formularioComponente(0,$configuracion);
		break 1;
	case 3:
		formularioComponente(1,$configuracion);
		break 1;
	default:
		formularioComponente(0,$configuracion);
}


function formularioComponente($pedidoStatus=0,$configuracion) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "pedidoAdmin.php";
	require_once "inventarioAdmin.php";
	$equipoBuscar= new equipo();
	$equipoBuscar->setEquipo($configuracion);
	$resultadoEquipo=$equipoBuscar->buscarEquipo();
	if ($equipoBuscar->retornarUltimaUbicacion($buscar='d')!=1) {
		$_POST[selSitio]=$equipoBuscar->retornarUltimaUbicacion($buscar='u');
		$_POST[selGerencia]=$equipoBuscar->retornarUltimaUbicacion($buscar='g');
		$_POST[selDivision]=$equipoBuscar->retornarUltimaUbicacion($buscar='s');
		$_POST[selDepartamento]=$equipoBuscar->retornarUltimaUbicacion($buscar='d');
	}
	//$idInventario=$idInventario;
	if ($resultadoEquipo && $resultadoEquipo!=1) {
		$row=mysql_fetch_array($resultadoEquipo);
			$_POST[txtEConfiguracion]=$row[0];
    		$_POST[txtEActivoFijo]=$row[1];
    		$_POST[txtESerial]=$row[3];
    		$_POST[txtEDescripcion]=$row[5];
    		$_POST[txtEMarca]=$row[7];
    		$_POST[txtEModelo]=$row[9].' '.$row[10].' '.$row[11];
   } 
	//Consultas para los Campos de Selecciï¿½n
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION_PROPIEDAD='DSP0000001' ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ', unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_UBICACION_PROPIEDAD='UBP0000003' ORDER BY SITIO";
	$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";
	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado where id_estado in ('EST0000001','EST0000002') ORDER BY ID_ESTADO";	
	//Llamadas a las clases para generar el formulario con los Campos de Texto y Selecciï¿½n

	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();


	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onchange","cambiarPedido()",$conPedido,"--PEDIDO--","");
	$selPedido=$pedido->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();

	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();

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

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();

	$ct= new campo("txtCt","text","formularioCampoTexto","$_POST[txtCt]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtCt=$ct->retornar();

	$fru= new campo("txtFru","text","formularioCampoTexto","$_POST[txtFru]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtFru=$fru->retornar();

	$productNumber= new campo("txtProductNumber","text","formularioCampoTexto","$_POST[txtProductNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtProductNumber=$productNumber->retornar();
	
	$spareNumber= new campo("txtSpareNumber","text","formularioCampoTexto","$_POST[txtSpareNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSpareNumber=$spareNumber->retornar();

	//Campo Estado
	$estado= new campoSeleccion("selEstado","formularioCampoSeleccion","$_POST[selEstado]","","",$conEstado,"--ESTADO--","");
	$selEstado=$estado->retornar();
	
	
	echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	//Datos del Componente.
	
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">NUEVO COMPONENTE</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION<br>
			<input name=\"txtEConfiguracion\" class=\"formularioCampoTexto\" type=\"text\" value=\"$_POST[txtEConfiguracion]\" readonly=\"true\"><br>
			ACTIVO FIJO<br><input name=\"txtEActivoFijo\" class=\"formularioCampoTexto\" type=\"text\" value=\"$_POST[txtEActivoFijo]\" readonly=\"true\"><br>
			SERIAL<br><input name=\"txtESerial\" class=\"formularioCampoTexto\" type=\"text\" value=\"$_POST[txtESerial]\" readonly=\"true\"></td>
    		
			<td valign=top class=\"formularioCampoTitulo\">
			DESCRIPCION<br><input name=\"txtEDescripcion\" class=\"formularioCampoTexto\" type=\"text\" value=\"$_POST[txtEDescripcion]\" readonly=\"true\"><br>
			MARCA<br><input name=\"txtEMarca\" class=\"formularioCampoTexto\" type=\"text\" value=\"$_POST[txtEMarca]\" readonly=\"true\"><br>
			MODELO<br><input name=\"txtEModelo\" class=\"formularioCampoTexto\" type=\"text\" value=\"$_POST[txtEModelo]\" readonly=\"true\"><br></td>
		</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL COMPONENTE</td>
  				</tr>
    		<td valign=top class=\"formularioCampoTitulo\">SERIAL<br>
			$txtSerial<input name=\"btn\" type=\"button\" value=\"C\" onClick=\"buscarSerial()\"><br>
			DESCRIPCION<br>$selDescripcion<br>
			MARCA<br>$selMarca<br>
			MODELO<br>$selModelo<br>

			<td valign=top class=\"formularioCampoTitulo\">CT<br>
			$txtCt<br>
			FRU<br>$txtFru<br>
			PRODUCT NUMBER<br>$txtProductNumber<br>
			SPARE NUMBER<br>$txtSpareNumber<br>
			ESTADO<br>$selEstado<br></td>
		</tr>";
		echo "<input name=\"selSitio\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$_POST[selSitio]\" readonly=\"true\">
		<input name=\"selGerencia\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$_POST[selGerencia]\" readonly=\"true\">
		<input name=\"selDivision\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$_POST[selDivision]\" readonly=\"true\">
		<input name=\"selDepartamento\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$_POST[selDepartamento]\" readonly=\"true\">";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">INFORMACION PARA GARANTIA</td>
  				</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">PEDIDO<br>$selPedido<br>
			FECHA INICIO (GARANTIA)<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmComponente.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></br>
			FECHA FINAL (GARANTIA)<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmComponente.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
			</td><td valign=\"top\" class=\"formularioCampoTitulo\">&nbsp;&nbsp;¿PERTENECE ORIGINALMENTE AL EQUIPO?<br>";
			if ($_POST[optGarantia]=="0") {
				echo "<input name=\"optGarantia\" type=\"radio\" value=\"0\" checked>NO<BR>
				<input name=\"optGarantia\" type=\"radio\" value=\"1\">SI<BR>";
			} else {
				echo "<input name=\"optGarantia\" type=\"radio\" value=\"0\">NO<BR>
				<input name=\"optGarantia\" type=\"radio\" value=\"1\" checked>SI<BR>";
			}
			echo "</td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\">
				<input name=\"btnRegresar\" type=\"button\" value=\"REGRESAR\" onclick=\"location.href='index2.php?item=151&config=$configuracion'\">
				<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\">
				</td>
  				</tr>";			
		echo "</table>";
	echo "</form>";
}

?>

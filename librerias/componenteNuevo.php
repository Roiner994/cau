<?php
require_once("seguridad.php");
?>
<script type="text/javascript" src="date-picker.js"></script>
<script language="javascript">
	function cambiarSeleccion() {
		document.frmComponente.funcion.value=0;
		document.frmComponente.submit();
	}
	function cambiarPedido() {
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
		require_once "Administracion.php";
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
		switch($i) {
			case 0:
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
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"txtSerial\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtCt\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtFru\" type=\"hidden\" value=\"\">";
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
						echo "<td align=center>MENSAJE: INVENTARIO - NUEVO COMPONENTE</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO EL NUEVO COMPONENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">";
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
		formularioComponente();
		break 1;
	case 3:
		require_once "Administracion.php";
		require_once "usuarioSistemaAdmin.php";
		//require_once "equipoAdmin.php";
		require_once "inventarioAdmin.php";
		require_once "conexionsql.php";
		$componente= new componente();
		$componente->setInventario("",$_POST[txtSerial]);
		$resultado=$componente->buscarSerial();
		switch($resultado) {
			case 0:
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<input name=\"txtActivoFijo\" type=\"hidden\" value=\"$_POST[txtActivoFijo]\">";
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
				formularioComponente();
				break 1;
			case 6:
				break 1;
		}
		break 1;
	case 4:
		formularioComponente(1);
		break 1;
	default:
		formularioComponente();
}


function formularioComponente($pedidoStatus=0) {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "pedidoAdmin.php";		
	
	//Consultas para los Campos de Selección
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION_PROPIEDAD<>'DSP0000004' ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	$conModelo="SELECT ID_MODELO, CONCAT(MODELO,' ',CAP_VEL,' ',UNIDAD) AS MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY MODELO";
	
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_UBICACION_PROPIEDAD='UBP0000003' ORDER BY SITIO";
	$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";
	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado where id_estado in ('EST0000001','EST0000002')ORDER BY ID_ESTADO";
	
	
	//Llamadas a las clases para generar el formulario con los Campos de Texto y Selección




	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
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

	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","onkeyPress","return Letras(event)");
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
	
	
	echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

	//Datos del Componente.
	
		echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">NUEVO COMPONENTE</td>
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
			</td>
		</tr>";

	 	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">INFORMACION PARA GARANTIA</td>
  				</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">PEDIDO<br>$selPedido<br>
			FECHA INICIO (GARANTIA)<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmComponente.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></br>
			FECHA FINAL (GARANTIA)<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmComponente.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
			</td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\">
				<input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=131'\">
				<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\">
				</td>
  				</tr>";			
		echo "</table>";
	echo "</form>";
}
?>

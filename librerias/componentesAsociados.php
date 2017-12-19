<?php
session_start();
$Acceso=array ("PRV0000001");
switch ($_SESSION['authUser']) {
	case '0':
		echo "<table class=\"mensaje\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"mensaje\">SITIO RESTRINGIDO. NO PUEDE ENTRAR AL SISTEMA</td>
		</tr>";
		echo "</table>";
		exit();
		break 1;
	case '1':
		echo "<table class=\"mensaje\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
		echo "<td class=\"mensaje\">SITIO RESTRINGIDO. NO PUEDE ENTRAR AL SISTEMA</td>
		</tr>";
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
			echo "<table class=\"mensaje\"align=center width=\"200\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"\">CLAVE INCORRECTA.<br> NO PUEDE ENTRAR A LA P�GINA<br></td>
			</tr>";
			echo "</table>";			
			exit();
			break 1;
		case 2:
			echo "<table class=\"mensaje\"align=center width=\"200\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"\">USTED NO EST� REGISTRADO EN EL SISTEMA</td>
			</tr>";
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
				echo "<table class=\"mensaje\"align=center width=\"200\" border=\"0\">";
				echo "<tr>";
				echo "<td class=\"mensaje\">DISCULPE,USTED NO TIENE SUFUCIENTE PRIVILEGIO PARA ENTRAR A ESTE SITIO</td>
				</tr>";
				echo "</table>";			
				exit();
			}
	}
}
?>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmComponente.funcion.value=0;
		document.frmComponente.submit();
	}
	function buscarSerial() {
		if (document.frmComponente.txtSerial.value!="") {
			document.frmComponente.funcion.value=10;
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
require_once "componenteAdmin.php";
$idInventario=$_SESSION[idInventario];
/*$componente=new componente($idInventario,$serial,$descripcion,$marca,$modelo,$fru,$productNumber,$spareNumber,
		$ct,$fechaAsociacion,$idEstado,$fechaIngreso,$fechaFinal,$idPedido,$disponible,$idUbicacion,$idGerencia,$idDivision,
		$idDepartamento,$idSitio,$login);
$resultado=$componente->prueba();*/
switch($funcion) {
	case 1:
		require_once "componenteAdmin.php";
		require_once "conexionsql.php";
		$comp=new componente("",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo]);
		$i=$comp->validarFormulario();
		switch($i) {
			case 0:
				require_once "administracion.php";
				require_once "usuarioSistemaAdmin.php";
				require_once "componenteAdmin.php";
				require_once "conexionsql.php";
				$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
				$login=$acceso->login();
				$componente=new componente("",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],
				$_POST[txtCt],"",$_POST[selEstado],$_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[selPedido],1,"",$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento],$_POST[selSitio],$login,$idInventario);
				$resultado=$componente->ingresar();
				switch($resultado) {
					case 0:
						$resultado=$componente->asociarComponente();
						echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
						echo "<tr>";
							echo "<td class=\"tituloPagina\">NUEVO COMPONENTE</td>
  						</tr>";
						echo "<tr>";
							echo "<td class=\"formularioTablaTitulo\">";
						echo "SE GUARDO EL NUEVO COMPONENTE<br>";
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "</td></tr>";
						echo "<tr>
							<td>";
						echo "<p align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">";
						echo "<input name=\"btn\" type=\"submit\" value=\"NUEVO COMPONENTE\"></p></td></tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "IMPOSIBLE GUARDAR EL COMPONENTE<br>";
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<p align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">";
						echo "</form>";	
						break 1;
					case 2:
						echo "IMPOSIBLE GUARDAR. SERIAL DUPLICADO<br>";
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
						echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
						echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
						echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
						echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
						echo "<input name=\"selPedido\" type=\"hidden\" value=\"$_POST[selPedido]\">";
						echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<p align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">";
						echo "</form>";	
						break 1;
				}
				break 1;
			case 10:
				
				break 1;
			default:
				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				$mensaje=$comp->retornaMensajeCampoVacio();
				echo $mensaje;
				echo "</form>";
		}
		break 1;
	case 2:
		formularioComponente();
		break 1;
	default:
		formularioComponente();
}


function formularioComponente() {
	require_once "formularios.php";
	require_once "conexionsql.php";

	$idInventario=$_SESSION[idInventario];
	//Consulta para Mostrar el Equipo al cual se le est� haciendo mantenimiento
	$conEquipo="select equipo_campo.CONFIGURACION, equipo_campo.ACTIVO_FIJO,equipo_campo.ID_INVENTARIO,inventario.SERIAL,
	inventario.ID_DESCRIPCION,descripcion.DESCRIPCION,inventario.ID_MARCA,marca.MARCA,inventario.ID_MODELO,modelo.MODELO
	from equipo_campo inner join inventario inner join descripcion inner join marca inner join modelo
	on equipo_campo.ID_INVENTARIO=inventario.ID_INVENTARIO on inventario.ID_DESCRIPCION=descripcion.ID_DESCRIPCION on inventario.ID_MARCA=marca.ID_MARCA on inventario.ID_MODELO=modelo.ID_MODELO
	WHERE equipo_campo.ID_INVENTARIO='$idInventario'";
	
	$conUbicacion="SELECT inventario.ID_INVENTARIO,inventario_ubicacion.ID_UBICACION,ubicacion.ID_GERENCIA,gerencia.GERENCIA,ubicacion.ID_DIVISION,division.DIVISION,ubicacion.ID_DEPARTAMENTO,departamento.DEPARTAMENTO,ubicacion.ID_SITIO,sitio.SITIO
	FROM inventario INNER JOIN inventario_ubicacion INNER JOIN ubicacion INNER JOIN gerencia INNER JOIN division INNER JOIN departamento INNER JOIN sitio
	on inventario.ID_INVENTARIO=inventario_ubicacion.ID_INVENTARIO on inventario_ubicacion.ID_UBICACION=ubicacion.ID_UBICACION on ubicacion.ID_GERENCIA=gerencia.ID_GERENCIA on ubicacion.ID_DIVISION=division.ID_DIVISION
	on ubicacion.ID_DEPARTAMENTO=departamento.ID_DEPARTAMENTO on ubicacion.ID_SITIO=sitio.ID_SITIO WHERE inventario.ID_INVENTARIO='$idInventario'";



	
	ConectarMysql();
	$result=mysql_query($conEquipo);
	$result2=mysql_query($conUbicacion);
	$row=mysql_fetch_array($result);
	$row2=mysql_fetch_array($result2);
	mysql_close();
	//Consultas para los Campos de Selecci�n
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION_PROPIEDAD='DSP0000001' ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	$conModelo="SELECT ID_MODELO, MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_UBICACION_PROPIEDAD='UBP0000003' ORDER BY SITIO";
	$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";
	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado ORDER BY ID_ESTADO";	
	//Llamadas a las clases para generar el formulario con los Campos de Texto y Selecci�n

	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();


	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onchange","cambiarSeleccion()",$conPedido,"--PEDIDO--","");
	$selPedido=$pedido->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();

	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","onkeyPress","return Letras(event)");
	$txtFechaInicio=$fechaInicio->retornar();
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();

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
	
		echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">NUEVO COMPONENTE</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION<br>
			<input name=\"txtEConfiguracion\" class=\"formularioCampoTexto\" type=\"text\" value=\"$row[0]\" readonly=\"true\"><br>
			ACTIVO FIJO<br><input name=\"txtEActivoFijo\" class=\"formularioCampoTexto\" type=\"text\" value=\"$row[1]\" readonly=\"true\"><br>
			SERIAL<br><input name=\"txtESerial\" class=\"formularioCampoTexto\" type=\"text\" value=\"$row[3]\" readonly=\"true\"></td>
    		
			<td valign=top class=\"formularioCampoTitulo\">
			DESCRIPCION<br><input name=\"txtEDescripcion\" class=\"formularioCampoTexto\" type=\"text\" value=\"$row[5]\" readonly=\"true\"><br>
			MARCA<br><input name=\"txtEMarca\" class=\"formularioCampoTexto\" type=\"text\" value=\"$row[7]\" readonly=\"true\"><br>
			MODELO<br><input name=\"txtEModelo\" class=\"formularioCampoTexto\" type=\"text\" value=\"$row[9]\" readonly=\"true\"><br></td>
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
		echo "<input name=\"selSitio\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$row2[8]\" readonly=\"true\">
		<input name=\"selGerencia\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$row2[2]\" readonly=\"true\">
		<input name=\"selDivision\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$row2[4]\" readonly=\"true\">
		<input name=\"selDepartamento\" class=\"formularioCampoTexto\" type=\"hidden\" value=\"$row2[6]\" readonly=\"true\">";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">INFORMACION PARA GARANTIA</td>
  				</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">PEDIDO<br>$selPedido<br>
			FECHA INICIO (GARANTIA)<br>$txtFechaInicio (dd/mm/aaaa)</br>
			FECHA FINAL (GARANTIA)<br>$txtFechaFinal (dd/mm/aaaa)<br>
			</td>
		</tr>";
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

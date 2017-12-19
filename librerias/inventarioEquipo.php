<?php
require_once("seguridad.php");
$priv="'PRV0000002','PRV0000003','PRV0000004','PRV0000005'";

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
<script language="javascript" type="text/javascript">
	function cargar_planilla_asignacion(){
		if (document.frmEquipo.txtConfiguracion.value!="") {
			window.open("../librerias/planillaAsignacionCargar.php?configuracion="+document.frmEquipo.txtConfiguracion.value,'','width=550,height=250,status=no,resizable=no,top=200,left=500');
		}				
	}
	function buscarConfiguracion() {
		if (document.frmEquipo.txtConfiguracion.value!="") {
			document.frmEquipo.funcion.value=3;
			posicionamientoPantalla();
			document.frmEquipo.submit();
		}
	}
	function cambiarSeleccion() {
		document.frmEquipo.funcion.value=2;
		document.frmEquipo.txtAsociar.value=1;
		posicionamientoPantalla();
		document.frmEquipo.submit();

	}
	function buscarFicha() {
		if (document.frmEquipo.txtFicha.value!="") {
			document.frmEquipo.funcion.value=2;
			posicionamientoPantalla();
			document.frmEquipo.submit();	
		}
	}
	function asociar() {
		if (document.frmEquipo.txtSerial.value!="") {
			document.frmEquipo.funcion.value=2;
			if (document.frmEquipo.txtAsociar.value==1) 
				document.frmEquipo.txtAsociar.value=0;
			else
				document.frmEquipo.txtAsociar.value=1;
			document.frmEquipo.submit();			
		}
	}
	function software() {
		if (document.frmEquipo.txtSerial.value!="") {
			document.frmEquipo.funcion.value=2;
			if (document.frmEquipo.txtAsociar.value==2) 
				document.frmEquipo.txtAsociar.value=0;
			else
				document.frmEquipo.txtAsociar.value=2;
			document.frmEquipo.submit();			
		}
	}
	function asociarComponente() {
		document.frmEquipo.funcion.value=4;
		document.frmEquipo.txtAsociar.value=0;
		document.frmEquipo.submit();			
	}
	function cambiarSeleccionOtros() {
		document.frmEquipo.funcion.value=2;
		document.frmEquipo.txtAsociar.value=0;
		posicionamientoPantalla();
		document.frmEquipo.submit();
	}
	function cambiarPedido() {
		document.frmEquipo.funcion.value=5;
		posicionamientoPantalla();
		document.frmEquipo.submit();
	}
	function cambiarEquipo() {
		document.frmEquipo.funcion.value=6;
		posicionamientoPantalla();
		document.frmEquipo.submit();
	}
	function actualizarUbicacion() {
		document.frmEquipo.funcion.value=7;
		posicionamientoPantalla();
		document.frmEquipo.submit();
	}
	function actualizarSoftware() {
		document.frmEquipo.funcion.value=8;
		document.frmEquipo.txtAsociar.value=0;
		document.frmEquipo.submit();	
	}
	function generarDespacho() {
		document.frmEquipo.funcion.value=9;
		document.frmEquipo.txtAsociar.value=0;
		document.frmEquipo.submit();	
	}
	function imprimirPlanilla() {
		configuracion=document.frmEquipo.txtConfiguracion.value;
		analista=document.frmEquipo.selUsuarioSistema.value;
		window.open('../librerias/xmlAsignacionEquipos.php?configuracion='+configuracion+'&analista='+analista);
	}
</script>
<?php

$funcion=$_POST[funcion]	;
if (isset($_GET[config]) && !empty($_GET[config])) {
	if (empty($_POST[txtConfiguracion])) {
		$_POST[txtConfiguracion]=$_GET[config];
		$funcion=3;
	}
}


switch ($funcion) {
	case 1:
		break 1;
	case 2:
		frmInventarioEquipo($_POST[txtConfiguracion],1);
		break 1;
	case 3:
		frmInventarioEquipo($_POST[txtConfiguracion]);
		break 1;
	case 4:
		//Asocia los Componentes al Equipo
		require_once "conexionsql.php";
		require_once "inventarioAdmin.php";
		//require_once "componenteAdmin.php";
		//require_once "equipoAdmin.php";
		require_once "administracion.php";
		$login=$_SESSION["login"];
		$componenteAsociar= new componente();
		$componenteAsociar->setInventario($_POST[optInventario]);
		$resultado=$componenteAsociar->buscarEquipoAsociado();
		if ($resultado==1) {
			$componenteAsociar->setComponente($_POST[txtConfiguracion]);
			$componenteAsociar->setInventarioPropiedad("",$login);
			$asociar=$componenteAsociar->asociarComponenteEquipo();
			if ($asociar==0) {
				frmInventarioEquipo($_POST[txtConfiguracion]);
			} else {
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - CONTROL EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE REALIZAR LA ASOCIACION</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\">
				</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";		
			}			
		} else {
			echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: INVENTARIO - CONTROL EQUIPO</td>
			</tr>";
			$serial=$componenteAsociar->buscarInventario();
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>EL COMPONENTE CON SERIAL 
			<B>$serial</B> ESTÁ ASOCIADO AL EQUIPO <b>$resultado</b>.<br>
			¿DESEA ASOCIARLO AHORA AL EQUIPO <b>$_POST[txtConfiguracion]</b>?</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnSI\" type=\"button\" value=\"SI\" onclick=\"cambiarEquipo()\">
			<input name=\"btnNO\" type=\"button\" value=\"NO\" onclick=\"buscarConfiguracion()\"></td>";
			echo "</tr>";
			echo "</table>";
			echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
			echo "<input name=\"optInventario\" type=\"hidden\" value=\"$_POST[optInventario]\">";
			echo "</form>";		
		}
		break 1;
		
		case 5:
		frmInventarioEquipo($_POST[txtConfiguracion],0,1);
		break 1;
		case 6:
			require_once "conexionsql.php";
			require_once "inventarioAdmin.php";
//			require_once "componenteAdmin.php";
//			require_once "equipoAdmin.php";
			require_once "administracion.php";
			$login=$_SESSION["login"];
			$componenteAsociar= new componente();
			$componenteAsociar->setInventario($_POST[optInventario]);
			$componenteAsociar->setComponente($_POST[txtConfiguracion]);
			$componenteAsociar->setInventarioPropiedad("",$login);
			$asociar=$componenteAsociar->asociarComponenteEquipo();
			if ($asociar==0) {
				frmInventarioEquipo($_POST[txtConfiguracion]);
			} else {
				echo "<br>estado de Componente<br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - CONTROL EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE REALIZAR LA ASOCIACION</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"submit\" value=\"CANCELAR\" onclick=\"\">
				</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";		
			}		
			break 1;
		case 7://actualizar Ubicacion
			require_once "conexionsql.php";
			require_once "inventarioAdmin.php";
			require_once "administracion.php";
			require_once "usuarioAdmin.php";
				$login=$_SESSION["login"];
				$nuevoEquipo=new equipo();
				//Ingresa Datos del Equipos
				$nuevoEquipo->setEquipo($_POST[txtConfiguracion],$_POST[txtActivoFijo],$_POST[chkCritico],$_POST[chkRed],$_POST[chkUsuarioEspecializado],$_POST[chkSP],$_POST[txtRed],$_POST[chkCorrectivo],$_POST[txtCorrectivo],$_POST[chkEncontrado],$_POST[txtEncontrado],$_POST[chkUso],$_POST[txtUso],$_POST[txtFechaActualizacion],$_POST[txtCritico],$_POST[chkEquipoDisponible],$_POST[txtEquipoDisponible],$_POST[chkSO],$_POST[txtSO],$_POST[chkAntivirus],$_POST[txtAntivirus],"","",$_POST[txtUbicacionEspecifica],"","","","","","","","","","",$_POST[chkConectividad]);
				$resultado=$nuevoEquipo->buscarEquipo();
				//Ingresa Datos detallados del Equipo
				$nuevoEquipo->setInventario("",$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,$login);
				//Ingresa el Estado del Equipo
				$resultado=$nuevoEquipo->buscarEquipo();
				$nuevoEquipo->setInventarioPropiedad($_POST[selEstado],$login);
				//Ingresa los Datos de la Ubicacion
				$nuevoEquipo->setInventarioUbicacion($_POST[selDepartamento],$_POST[selSitio],$_POST[txtEspecifico],$login);
				$nuevoEquipo->setInventarioUsuario($_POST[txtFicha],$login);
				$nuevoEquipo->actualizarActivoFijo();
				$resultadoEquipo=$nuevoEquipo->actualizarCritico();
				$resultadoEquipo=$nuevoEquipo->actualizarRed();
				$resultadoEquipo=$nuevoEquipo->actualizarUsuarioEspecializado();
				$resultadoEquipo=$nuevoEquipo->actualizarSP();
				//begin**20-04-09***********************************************************************
				//*********20-04-09***********************************************************************
				$resultadoEquipo=$nuevoEquipo->actualizarTextoRed();
				$resultadoEquipo=$nuevoEquipo->actualizarCorrectivo();
				$resultadoEquipo=$nuevoEquipo->actualizarTextoCorrectivo();
				$resultadoEquipo=$nuevoEquipo->actualizarEncontrado();
				$resultadoEquipo=$nuevoEquipo->actualizarTextoEncontrado();
				$resultadoEquipo=$nuevoEquipo->actualizarUso();
				$resultadoEquipo=$nuevoEquipo->actualizarTextoUso();
				$resultadoEquipo=$nuevoEquipo->actualizarFechaActualizacion();
				$resultadoEquipo=$nuevoEquipo->actualizarTextoCritico();
				$resultadoEquipo=$nuevoEquipo->actualizarSistemaOperativo();
				$resultadoEquipo=$nuevoEquipo->actualizarTextoSistemaOperativo();
				$resultadoEquipo=$nuevoEquipo->actualizarAntivirus();
				$resultadoEquipo=$nuevoEquipo->actualizarConectividad();
				$resultadoEquipo=$nuevoEquipo->actualizarTextoAntivirus();
				$resultadoEquipo=$nuevoEquipo->actualizarDisponible();
				$resultadoEquipo=$nuevoEquipo->actualizarTextoDisponible();
				$resultadoEquipo=$nuevoEquipo->actualizarUbicacionEspecifica();
				//*********20-04-09***********************************************************************
				//end******20-04-09***********************************************************************
				$nuevoEquipo->ingresarInventarioUsuario();
				$nuevoEquipo->ingresarInventarioPropiedad();
				$nuevoEquipo->actualizarComponentesAsociados();
				$nuevoEquipo->actualizarPedido();
				$usuario = new usuario($_POST[txtFicha],"","","","","","",$_POST[selDepartamento],$_POST[selSitioUsuario],$_POST[txtExtension]);
				$resultadoUsuario=$usuario->actualizarExtension();
				$resultadoUsuario=$usuario->actualizarDepartamento();
				$resultadoUsuario=$usuario->actualizarSitio();
				frmInventarioEquipo($_POST[txtConfiguracion]);
			break 1;
		case 8:
			require_once "conexionsql.php";
			require_once "inventarioAdmin.php";
			require_once "administracion.php";
			require_once "usuarioAdmin.php";
			
			$nuevoEquipo=new equipo();
			$nuevoEquipo->setEquipo($_POST[txtConfiguracion]);
			$nuevoEquipo->ingresarSoftware($_POST[chkSoftware]);
			frmInventarioEquipo($_POST[txtConfiguracion]);					
			break 1;
		case 9:
			require_once "formularios.php";
			$conUss="SELECT id_uss, concat(nombre,' ',apellido) as nombres FROM usuario_sistema  where status_activo=1 order by nombres";
			$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","","",$conUss,"--SELECCIONE--","");
			$selUsuarioSistema=$usuarioSistema->retornar();
			
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
				$_POST[txtConfiguracion]=strtoupper($_POST[txtConfiguracion]);
				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>INVENTARIO ASIGNACION DE EQUIPO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>$selUsuarioSistema</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"CANCELAR\">
				<input name=\"txtBoton\" type=\"button\" value=\"IMPRIMIR\" onclick=\"imprimirPlanilla()\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
			break 1;			
	default:
		frmInventarioEquipo();
}

function frmInventarioEquipo($configuracion="",$cambiarSeleccion=0,$pedidoStatus=0) {
	//require_once "equipoAdmin.php";
	require_once "inventarioAdmin.php";
	require_once "conexionsql.php";
	require_once "formularios.php";
	require_once "usuarioAdmin.php";
	require_once "pedidoAdmin.php";
	if (isset($configuracion) && !empty($configuracion)) {
		$equipoBuscar= new equipo();
		$equipoBuscar->setEquipo($configuracion);
		$resultado=$equipoBuscar->buscarEquipo();
		$_POST[selEstado]=$equipoBuscar->retornarUltimoEstado();
		$componenteAsociado=$equipoBuscar->buscarComponentesAsociados();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtConfiguracion]=$row[0];
			$_POST[txtActivoFijo]=$row[1];
			$idInventario=$row[2];
			$_POST[txtIdInventario]=$row[2];
			$_POST[txtSerial]=$row[3];
			$descripcionPropiedad=$row[4];
			$DESCRIPCION=$row[4];
			$_POST[txtDescripcion]=$row[5];
			$_POST[txtMarca]=$row[7];
			$_POST[txtModelo]="$row[9] $row[10] $row[11]";
			if ($pedidoStatus==0) {
				$_POST[selPedido]=$row[17];
				$fecha=substr($row[20],8,2).'/'.substr($row[20],5,2).'/'.substr($row[20],0,4);
				$_POST[txtFechaInicio]=$fecha;
				$fecha=substr($row[21],8,2).'/'.substr($row[21],5,2).'/'.substr($row[21],0,4);
				$_POST[txtFechaFinal]=$fecha;
				$_POST[chkCritico]=$row[22];
				$_POST[chkRed]=$row[23];
				$_POST[chkUsuarioEspecializado]=$row[24];
				$_POST[chkSP]=$row[25];
				$_POST[chkCorrectivo]=$row[28];
				$_POST[chkEncontrado]=$row[30];
				$_POST[chkUso]=$row[33];
			}
			$_POST[txtUso]=$row[34];
			$_POST[txtFechaActualizacion]=substr($row[35],8,2).'/'.substr($row[35],5,2).'/'.substr($row[35],0,4);
			$_POST[txtCorrectivo]=$row[29];
			$_POST[txtEncontrado]=$row[31];
			$_POST[txtCritico]=$row[36];
			$_POST[chkEquipoDisponible]=$row[37];
			$_POST[txtEquipoDisponible]=$row[38];
			$_POST[txtRed]=$row[32];
			$descrip=$row[4];
			$descrip=str_replace('DES','DSP',$descrip);
			$_POST[chkSO]=$row[39];
			$_POST[chkAntivirus]=$row[41];
			$_POST[chkConectividad]=$row[54];
			$_POST[txtSO]=$row[40];
			$_POST[txtAntivirus]=$row[42];
			$_POST[txtUbicacionEspecifica]=$row[43];
		} else {
			unset($_POST[selEstado]);
			unset($_POST[txtConfiguracion]);
			unset($_POST[txtActivoFijo]);
			unset($_POST[txtSerial]);
			unset($_POST[txtDescripcion]);
			unset($_POST[txtMarca]);
			unset($_POST[txtModelo]);
			unset($_POST[selPedido]);
			unset($_POST[txtFicha]);
			unset($_POST[txtFechaInicio]);
			unset($_POST[txtFechaFinal]);
			unset($_POST[txtFechaActualizacion]);
			unset($_POST[txtNombres]);
			unset($_POST[txtCargo]);
			unset($_POST[txtExtension]);
			unset($_POST[chkCritico]);
			unset($_POST[chkRed]);
			unset($_POST[chkEquipoDisponible]);
			unset($_POST[txtEquipoDisponible]);
			unset($_POST[chkSO]);
			unset($_POST[txtSO]);
			unset($_POST[chkAntivirus]);
			unset($_POST[txtAntivirus]);
			unset($_POST[chkConectividad]);
			unset($_POST[txtUbicacionEspecifica]);
		}
		if ($cambiarSeleccion==0) {
			if ($equipoBuscar->retornarUltimaUbicacion('d')!=1) {
				$_POST[selSitio]=$equipoBuscar->retornarUltimaUbicacion('u');
				$_POST[selGerencia]=$equipoBuscar->retornarUltimaUbicacion('g');
				$_POST[selDivision]=$equipoBuscar->retornarUltimaUbicacion('s');
				$_POST[selDepartamento]=$equipoBuscar->retornarUltimaUbicacion('d');
				$_POST[txtEspecifico]=$equipoBuscar->retornarUltimaUbicacion('e');
			}
			else {
				$_POST[selSitio]="";
				$_POST[selGerencia]="";
				$_POST[selDivision]="";
				$_POST[selDepartamento]="";
				$_POST[selEspecifico]="";
			}
			if ($equipoBuscar->retornarUltimoUsuario('f')!=1)
			$_POST[txtFicha]=$equipoBuscar->retornarUltimoUsuario('f');
			else
			$_POST[txtFicha]="";
			if ($equipoBuscar->retornarUltimoUsuario('n')!=1)
			$_POST[txtNombres]=$equipoBuscar->retornarUltimoUsuario('n'). " ".$equipoBuscar->retornarUltimoUsuario('a');
			else
			$_POST[txtNombres]="";
			if($equipoBuscar->retornarUltimoUsuario('C')!=1)
			$_POST[txtCargo]=$equipoBuscar->retornarUltimoUsuario('C');
			else
			$_POST[txtCargo]="";
			if($equipoBuscar->retornarUltimoUsuario('e')!=1)
			$_POST[txtExtension]=$equipoBuscar->retornarUltimoUsuario('e');
			else
			$_POST[txtExtension]="";
		}
		if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
			$usuarioAsignacion= new usuario($_POST[txtFicha]);
			$resultado5= $usuarioAsignacion->retornaUsuario();
			if ($resultado5 && $resultado5!=1) {
				$row5=mysql_fetch_array($resultado5);
				$_POST[txtNombres]=$row5[2];
				$_POST[txtCargo]=$row5[6];
				$_POST[selSitioUsuario]=$row5[7];
				$_POST[txtExtension]=$row5[15];
			}
		}
	}

		
	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";
	$conAnalista="select usuario_sistema.id_uss,concat(usuario_sistema.nombre,' ',usuario_sistema.apellido) as nombres from usuario_sistema order by nombres";

	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado where estatus_activo=1 ORDER BY ID_ESTADO";	

	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();
	
	$sitioUsuario= new campoSeleccion("selSitioUsuario","formularioCampoSeleccion","$_POST[selSitioUsuario]","","",$conSitio,"--UBICACION--","");
	$selSitioUsuario=$sitioUsuario->retornar();	

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccionOtros()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();		

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccionOtros()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccionOtros()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	

	$conPedido="SELECT pedido.ID_PEDIDO,CONCAT(pedido.ID_PEDIDO,', ',proveedor.PROVEEDOR) AS PROV FROM pedido INNER JOIN proveedor ON (pedido.ID_PROVEEDOR=proveedor.ID_PROVEEDOR) ORDER BY ID_PEDIDO";

	$pedido= new campoSeleccion("selPedido","formularioCampoSeleccion","$_POST[selPedido]","onchange","cambiarPedido()",$conPedido,"--PEDIDO--","");
	$selPedido=$pedido->retornar();
	
	$fechaActualizacion= new campo("txtFechaActualizacion","text","formularioCampoTexto","$_POST[txtFechaActualizacion]","10","10");
	$txtFechaActualizacion=$fechaActualizacion->retornar();

	//Campo Estado
	$estado= new campoSeleccion("selEstado","formularioCampoSeleccion","$_POST[selEstado]","","",$conEstado,"--ESTADO--","");
	$selEstado=$estado->retornar();	
	
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
		
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10");
	$txtFechaInicio=$fechaInicio->retornar();

	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
	
	
//Equipos con sus Componentes Asociados
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"top\" type=\"hidden\" value=\"\">";
	echo "<input name=\"txtIdInventario\" type=\"hidden\" value=\"$_POST[txtIdInventario]\">";
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">EQUIPO - INFORMACI&Oacute;N</td>
  				</tr>";

			echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td><td class=\"formularioTablaTitulo\"></td>
			</tr>";
			conectarMysql();
			
			$qu="SELECT COUNT(ec1.CONFIGURACION), (SELECT ID_PLANILLA_ASIGNACION FROM planillas_asignacion WHERE  CONFIGURACION='$configuracion'  ORDER BY FECHA_CREACION DESC LIMIT 1)AS pla
			  FROM
				usuario AS u1,inventario_usuario AS iu1, equipo_campo AS ec1,inventario AS i1, planillas_asignacion AS pa1
				WHERE
				ec1.CONFIGURACION='$_POST[txtConfiguracion]' AND
				i1.ID_INVENTARIO=ec1.ID_INVENTARIO AND
				iu1.ID_INVENTARIO=i1.ID_INVENTARIO AND
				iu1.FICHA=u1.FICHA AND 
				iu1.FICHA='$_POST[txtFicha]' AND 
				iu1.FECHA_ASOCIACION IN (SELECT MAX(iu2.FECHA_ASOCIACION) FROM
											inventario_usuario as iu2
											WHERE
											iu2.FICHA=iu1.FICHA AND
											iu2.ID_INVENTARIO=iu1.ID_INVENTARIO
											GROUP BY iu2.FICHA
										)AND 
				pa1.FECHA_ASOCIACION_EQUIPO=iu1.FECHA_ASOCIACION AND
				ec1.CONFIGURACION=pa1.CONFIGURACION
				GROUP BY ec1.CONFIGURACION;
				";
				
				
			
			
			
			
			
			$dsa=mysql_query($qu);			
			$ff=mysql_fetch_array($dsa);
			$anterior=$ff[1];
			
			$valor=$ff[0];
			
			if($valor+0==0)
				$agregar="(SE DEBE ACTUALIZAR LA PLANILLA DE ASIGNACION)";
			
				
			
			
			
			
			
			
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION:<br><input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\" onKeyPress=\"if (event.keyCode==13) buscarConfiguracion();\" onBlur=\"buscarConfiguracion()\">
				<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarConfiguracion()\" ><br>
				SERIAL:<br><input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=\"$_POST[txtSerial]\" readonly=\"true\"><br>
				MARCA:<br><input class=\"formularioCampoTexto\" name=\"txtMarca\" type=\"text\" value=\"$_POST[txtMarca]\" readonly=\"true\"><br><br>
				<a class=\"enlace\" href=\"#\" onclick=\"window.open('../librerias/puntoPendienteGenerar.php?configuracion=$_POST[txtConfiguracion]')\">GENERAR PUNTO PENDIENTE</a><br>
				<a class=\"enlace\" href=\"#\" onclick='cargar_planilla_asignacion();'>CARGAR PLANILLA DE ASIGNACI&Oacute;N $agregar</a><br>				</td>
				<td valign=top class=\"formularioCampoTitulo\">ACTIVO FIJO:<br><input class=\"formularioCampoTexto\" name=\"txtActivoFijo\" type=\"text\" value=\"$_POST[txtActivoFijo]\"><br>
				DESCRIPCION:<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" value=\"$_POST[txtDescripcion]\" readonly=\"true\"><br>
				MODELO:<br><input class=\"formularioCampoTexto\" name=\"txtModelo\" type=\"text\" value=\"$_POST[txtModelo]\" readonly=\"true\">";
			
			if ($_POST[txtDescripcion]=='IMPRESORA') {
			echo "<br><br>
				<a class=\"enlace\" href=\"#\" onclick=\"window.open('../librerias/hojas_impresas.php?configuracion=$_POST[txtConfiguracion]')\">HOJAS IMPRESAS</a><br>";
			}
			echo "<br><br><a class=enlace href=\"index2.php?item=161&idInventario=$idInventario\">MODIFICAR DATOS</a>";
			
			if(isset($anterior)&&!empty($anterior))
			echo "<br><a class=\"enlace\" href=\"#\" onclick=\"window.open('../librerias/planillas_asignacion.php?url=$anterior');\">DESCARGAR PLANILLA DE ASIGNACION</a><br>";
			
			
			echo "	</td>

			</tr>";
		echo "</table><BR>";
		
	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">COMPONENTES ASOCIADOS</td>
		</tr>";


	if ($componenteAsociado && $componenteAsociado!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			</tr>";
			while ($row=mysql_fetch_array($componenteAsociado)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\"><a class=enlace href=\"index2.php?item=152&serial=$row[2]\">$row[5]</a></td>
					<td>$row[7]</td>
					<td>$row[9] $row[10] $row[11]</td>
					<td>$row[3]</td>
				</tr>";
				$i++;
			}
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";	
	}
	echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">";
		if ($_POST[txtSerial]!="")
			echo "<a class=\"botonEnlace\" href=\"index2.php?item=135&configuracion=$_POST[txtConfiguracion]\" onSelect=\"buscarConfiguracion()\">Nuevo Componente</a>";
		else
			echo "<a class=\"botonEnlace\">Nuevo Componente</a>";
		echo "<a class=\"botonEnlace\" href=\"#\" onClick=\"asociar()\">Vincular Componente</a>";
		
		if ($DESCRIPCION=='DES0000001' || $DESCRIPCION=='DES0000042' ) {
			echo "<a class=\"botonEnlace\" href=\"#\" onClick=\"software()\">Vincular Software</a>";
		}
		echo "</td>
	</tr>";

	echo "</table>";

echo "<input name=\"txtAsociar\" type=\"hidden\" value=\"$_POST[txtAsociar]\">";
if ($_POST[txtAsociar]==1) {
	if($descrip=='DSP0000042') {
		$buscarEquipopor=" or ID_DESCRIPCION_PROPIEDAD='DSP0000001' ";
	} else {
		unset($buscarEquipopor);
	}
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION_PROPIEDAD='$descrip' $buscarEquipopor ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY MARCA";
	$conModelo="SELECT ID_MODELO, CONCAT(MODELO,' ',CAP_VEL,' ',UNIDAD) AS MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY MODELO";
	
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--SELECCIONE--","");
	$selDescripcion=$descripcion->retornar();
		
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--SELECCIONE--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--SELECCIONE--","");
	$selModelo=$modelo->retornar();

	echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ASOCIAR COMPONENTE</td>
			</tr>";
			echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">SERIAL<br>
				<input class=\"formularioCampoTexto\" name=\"txtSerialDisponible\" type=\"text\" value=\"$_POST[txtSerialDisponible]\" onKeyPress=\"if (event.keyCode==13) cambiarSeleccion();\"><input name=\"button\" type=\"button\" value=\"B\" onclick=\"cambiarSeleccion()\"><br>
				MARCA<BR>$selMarca<br>
			</td>
				<td valign=top class=\"formularioCampoTitulo\">
				DESCRIPCION<BR>$selDescripcion<br>
				MODELO<BR>$selModelo<br>
			</td>

			</tr>";

	echo "</table>";
	
		if ($_POST[selDescripcion]==100) {
			$_POST[selDescripcion]="";
			$_POST[selMarca]="";
		}
		if ($_POST[selMarca]==100) {
			$_POST[selMarca]="";
			$_POST[selModelo]="";
		}
		if ($_POST[selModelo]==100)
			$_POST[selModelo]="";
		$descripcion=$_POST[selDescripcion];
		
		$equipoBuscar->setInventario("",$_POST[txtSerialDisponible],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo]);

			$resultado6=$equipoBuscar->buscarComponentesDisponibles();

	if ((isset($_POST[selDescripcion]) && $_POST[selDescripcion]!="") || (isset($_POST[txtSerialDisponible]) && !empty($_POST[txtSerial]))) { 
		if ($resultado6!=1) {

			echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">INVENTARIO - TOTAL: $total </td>
			</tr>";	
			echo "<tr valign=top class=\"tablaTitulo\">
				<td align=\"left\" class=\"tablaTitulo\">SERIAL</td>
				<td valign=top class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
				<td valign=top class=\"tablaTitulo\">MARCA</td>
				<td valign=top class=\"tablaTitulo\">MODELO</td>
				</tr>";
				if ($resultado6) {
					while ($row=mysql_fetch_array($resultado6)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\"><input name=\"optInventario\" type=\"radio\" value=\"$row[0]\" checked>$row[1]</td>
						<td>$row[3]</td>	
						<td>$row[5]</td>
						<td>$row[7] $row[8] $row[9]</td>
						</tr>";
						$i++;	
					}	
			}
		echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">
		<input name=\"btnDespachar\" type=\"button\" value=\"ASOCIAR\" onclick=\"asociarComponente()\">
		</td>
		</tr>";
		}


	}
		echo "</table>";
}
if ($_POST[txtAsociar]==2 && isset($_POST[txtConfiguracion]) && !empty($_POST[txtConfiguracion])) {
	require_once("softwareAdmin.php");
		$software=new software();
		$resultadoTipoSoftware=$software->retornarSoftware(1);
		echo "<table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
		 	echo "<tr>";
				echo "<td class=\"formularioTablaTitulo\" colspan=\"4\">SOFTWARE ASOCIADO</td>
	  			</tr>";
				$i=0;
				$resultadoSoftware=$software->retornarSoftware();
				$y=0;
				while ($row2=mysql_fetch_array($resultadoSoftware)) {
					
					$y++;
			
					
					if ($i==0 ) {
						echo "<tr>";
					}
				

					$resultadoSoftwareEquipo=$equipoBuscar->verificarSoftwareInstalado($row2[2]);
					if ($resultadoSoftwareEquipo==1) {
						echo "<td class=\"formularioCampo\" valign=\"top\"><input name=\"chkSoftware[]\" type=\"checkbox\" value=\"$row2[2]\" checked>&nbsp;&nbsp;$row2[3]</td>";					
					} else {
						echo "<td class=\"formularioCampo\" valign=\"top\"><input name=\"chkSoftware[]\" type=\"checkbox\" value=\"$row2[2]\">&nbsp;&nbsp;$row2[3]</td>";					
					}
					$i++;
					if ($i==4) {
						$i=0;
						echo "</tr>";	
					}
					if ($y==$software->retornaTotal()) {
						$valor=$y;
						$i=0;
						$encontrado=0;
						while ($encontrado==0) {
							if (($valor % 4)==0) {
								$encontrado=1;	
							} else {
								$valor++;	
							}
						}
						for ($x=1;$x<=$valor-$software->retornaTotal();$x++) {
							echo "<td>&nbsp;</td>";
						}
						echo "</tr>";
						
					}
				
			}
		echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\"><input name=\"btnActualizarSoftware\" type=\"button\" value=\"ACTUALIZAR\" onclick=\"actualizarSoftware()\"></td>
		</tr>";	
		echo "</table>";
	}
		


	echo "<br><table class=\"formularioTabla\" align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">INFORMACION PARA GARANTIA</td>
			<td class=\"formularioTablaTitulo\">ESTADO</td> 
  			</tr>
		<tr>
			<td class=\"formularioCampoTitulo\">PEDIDO<br>$selPedido<br>
			FECHA INICIO (GARANTIA)<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmEquipo.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a></br>
			FECHA FINAL (GARANTIA)<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmEquipo.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br><br>
			FECHA ACTUALIZACION <br>$txtFechaActualizacion<a href=\"javascript:show_calendar('frmEquipo.txtFechaActualizacion');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br>
			</td>
			<td valign=\"top\" class=\"formularioCampoTitulo\">ESTADO<br>$selEstado<br>
			
			¿EQUIPO CRITICO?<br>";
				if ($_POST[chkCritico]==1){
					echo "<input name=\"chkCritico\" type=\"checkbox\" value=\"1\" checked>SI<br>";
					echo "<textarea name=\"txtCritico\" cols=\"35\" rows=\"1\">$_POST[txtCritico]</textarea><br>";
				}else
					echo "<input name=\"chkCritico\" type=\"checkbox\" value=\"1\">SI<br>";
			echo "¿CONECTADO A RED?<br>";
				if ($_POST[chkRed]==1){
					echo "<input name=\"chkRed\" type=\"checkbox\" value=\"1\" checked>NO<br>";
					echo "<textarea name=\"txtRed\" cols=\"35\" rows=\"1\">$_POST[txtRed]</textarea><br>";
				}else 
					echo "<input name=\"chkRed\" type=\"checkbox\" value=\"1\">NO<br>";
				
	//***20-04-09************************************************************************************************
			echo "CORRECTIVO?<br>";
				if ($_POST[chkCorrectivo]==1){
					echo "<input name=\"chkCorrectivo\" type=\"checkbox\" value=\"1\" checked>SI<br>";
					///USAR PARA CUESTION DE PRIVILEGIOS echo "<input class=\"formularioCampoTexto\" name=\"txtCorrectivo\" type=\"text\" value=\"$_POST[txtCorrectivo]\" readonly=\"true\">";
					echo "<textarea name=\"txtCorrectivo\" cols=\"35\" rows=\"1\">$_POST[txtCorrectivo]</textarea><br>";
				}else 
					echo "<input name=\"chkCorrectivo\" type=\"checkbox\" value=\"1\">SI<br>";
			
			echo "ENCONTRADO?<br>";
				if ($_POST[chkEncontrado]==1){
					echo "<input name=\"chkEncontrado\" type=\"checkbox\" value=\"1\" checked>NO<br>";
					echo "<textarea name=\"txtEncontrado\" cols=\"35\" rows=\"1\">$_POST[txtEncontrado]</textarea><br>";
				}else 
					echo "<input name=\"chkEncontrado\" type=\"checkbox\" value=\"1\">NO<br>";
					
			echo "SIN USO?<br>";
				if ($_POST[chkUso]==1){
					echo "<input name=\"chkUso\" type=\"checkbox\" value=\"1\" checked>SI<br>";
					echo "<textarea name=\"txtUso\" cols=\"35\" rows=\"1\">$_POST[txtUso]</textarea><br>";
				}else 
					echo "<input name=\"chkUso\" type=\"checkbox\" value=\"1\">SI<br>";
	
				echo "DISPONIBLE POR USUARIO?<br>";
				if ($_POST[chkEquipoDisponible]==1){
					echo "<input name=\"chkEquipoDisponible\" type=\"checkbox\" value=\"1\" checked>NO<br>";
					echo "<textarea name=\"txtEquipoDisponible\" cols=\"35\" rows=\"1\">$_POST[txtEquipoDisponible]</textarea><br>";
				}else 
					echo "<input name=\"chkEquipoDisponible\" type=\"checkbox\" value=\"1\">NO<br>";
	//***20-04-09************************************************************************************************
			//echo "<br>$login<br>";
			echo "USUARIO ESPECIALIZADO?<br>";
				if ($_POST[chkUsuarioEspecializado]==1)
					echo "<input name=\"chkUsuarioEspecializado\" type=\"checkbox\" value=\"1\" checked>SI<br>";
				else 
					echo "<input name=\"chkUsuarioEspecializado\" type=\"checkbox\" value=\"1\">SI<br>";
			echo "WINDOWS SERVICE PACK<br>";
				if ($_POST[chkSP]==1)
					echo "<input name=\"chkSP \" type=\"checkbox\" value=\"1\" checked>SP1";
				else 
					echo "<input name=\"chkSP\" type=\"checkbox\" value=\"1\">SP1";
				if ($_POST[chkSP]==2)
					echo "<input name=\"chkSP\" type=\"checkbox\" value=\"2\" checked>SP2";
				else 
					echo "<input name=\"chkSP\" type=\"checkbox\" value=\"2\">SP2";
				if ($_POST[chkSP]==3)
					echo "<input name=\"chkSP\" type=\"checkbox\" value=\"3\" checked>SP3";
				else 
					echo "<input name=\"chkSP\" type=\"checkbox\" value=\"3\">SP3";
			echo "<br>SISTEMA OPERATIVO ACTUALIZADO?<br>";
				if ($_POST[chkSO]==1){
					echo "<input name=\"chkSO\" type=\"checkbox\" value=\"1\" checked>NO<br>";
					echo "<textarea name=\"txtSO\" cols=\"35\" rows=\"1\">$_POST[txtSO]</textarea><br>";
				}else 
					echo "<input name=\"chkSO\" type=\"checkbox\" value=\"1\">NO<br>";
			echo "ANTIVIRUS ACTUALIZADO?<br>";
				if ($_POST[chkAntivirus]==1){
					echo "<input name=\"chkAntivirus\" type=\"checkbox\" value=\"1\" checked>NO<br>";
					echo "<textarea name=\"txtAntivirus\" cols=\"35\" rows=\"1\">$_POST[txtAntivirus]</textarea><br>";
				}else 
					echo "<input name=\"chkAntivirus\" type=\"checkbox\" value=\"1\">NO<br>";
			echo "UBICACION ESPECIFICA<br>";
					echo "<textarea name=\"txtUbicacionEspecifica\" cols=\"35\" rows=\"1\">$_POST[txtUbicacionEspecifica]</textarea><br>";
			echo "CONECTIVIDAD A RED?<br>";
				if ($_POST[chkConectividad]==1){
					echo "<input name=\"chkConectividad\" type=\"checkbox\" value=\"1\" checked>NO<br>";
				}else 
					echo "<input name=\"chkConectividad\" type=\"checkbox\" value=\"1\">NO<br>";
			echo "</td>";
		echo "</tr>";			
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>";
			echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioCampoTitulo\">FICHA:<br><input class=\"formularioCampoTexto\" name=\"txtFicha\" type=\"text\" value=\"$_POST[txtFicha]\" onKeyPress=\"if (event.keyCode==13) buscarFicha();\">
			<input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFicha()\"><br>
			NOMBRES<br>
			<input class=\"formularioCampoTexto\" name=\"txtNombres\" type=\"text\" value=\"$_POST[txtNombres]\" readonly=\"true\"></td>
			<td valign=top class=\"formularioCampoTitulo\">CARGO<br>
			<input class=\"formularioCampoTexto\" name=\"txtCargo\" type=\"text\" value=\"$_POST[txtCargo]\" readonly=\"true\"><br>
			EXTENSION<br>
			<input class=\"formularioCampoTexto\" name=\"txtExtension\" type=\"text\" value=\"$_POST[txtExtension]\">
			<br>UBICACION:<br>$selSitioUsuario<br></td>";
			echo "</tr>";
			echo "<tr>
			<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE UBICACION</td>";
			echo "</tr>
	  		<tr>
			<td class=\"formularioCampoTitulo\">UBICACION<br>$selSitio<br>
			GERENCIA<br>$selGerencia</td>
			<td class=\"formularioCampoTitulo\">
			DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento</td>
		</tr>";
		echo "<tr>";
		echo "<td colspan=\"2\" align=\"center\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>";
		echo "</tr>";
		echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">
			<input name=\"btnActualiazar\" type=\"button\" value=\"ACTUALIZAR\" onclick=\"actualizarUbicacion()\">";
		
	if (isset($_POST[selSitio]) && !empty($_POST[selSitio])) {
		if ($_POST[selSitio]=='SIT0000057' && $_POST[selEstado]=='EST0000001') {
			$despacho= new despachoEquipo();
			$despacho->setDespacho("","","",1);
			$despacho->setDetalleDespacho("",$_POST[txtConfiguracion]);
			$resultadoDespacho=$despacho->buscarDespachoEquipos();
			if ($resultadoDespacho==1) {
				echo "<input name=\"btnDespachar\" type=\"button\" value=\"DESPACHAR EQUIPO\" onclick=\"location.href='index2.php?item=621&configuracion=$_POST[txtConfiguracion]'\">";
			}
		}
	}
		echo "<input name=\"btnImprimir\" type=\"button\" value=\"IMPRIMIR ASIGNACION\" onclick=\"window.open('../librerias/xmlasignacionequipoinventario.php?configuracion=$_POST[txtConfiguracion]')\">";
		echo "<input name=\"btnImprimir\" type=\"button\" value=\"IMPRIMIR RETIRO/DEVOLUCION\" onclick=\"window.open('../librerias/xmlretiroequipo.php?configuracion=$_POST[txtConfiguracion]')\">";
		echo "</td>
		</tr>";
	echo "</table>";
}
?>

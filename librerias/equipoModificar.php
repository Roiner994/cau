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

<script type="text/javascript">
	function cambiarSeleccion() {
		document.frmEquipo.funcion.value=0;
		document.frmEquipo.txtCambiarSeleccion.value=1;
		document.frmEquipo.submit();
	}
</script>

<?php

switch ($funcion) {
	case 1:
		require_once("administracion.php");
		require_once("inventarioAdmin.php");
		
		$equipo = new equipo();
		$equipo->setInventario($_GET[idInventario],$_POST[txtSerial],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],$_POST[txtFru],$_POST[txtProductNumber],$_POST[txtSpareNumber],$_POST[txtCt],$_POST[selPedido],$_POST[txtFechaInicio],$_POST[txtFechaFinal],1,"",$login,$_POST[txtServiceTag],$_POST[txtExpressService]);
		
		$equipo->setEquipo($_POST[txtConfiguracionAnterior],$_POST[txtActivoFijo],0,0,0,0,"",0,"",0,"",0,"","","",0,"",0,"",0,"",0,"","",$_POST[txtIpImpresora],$_POST[txtColaImpresora],$_POST[txtMacImpresora],$_POST[txtTonerNegroImpresora],$_POST[txtTonerMagentaImpresora],$_POST[txtTonerAmarilloImpresora],$_POST[txtTonerCyanImpresora],$_POST[txtTamborImagenImpresora],$_POST[txtCantidadUsuarios],$_POST[txtDistanciaMaxima]);
		$equipo->setInventarioPropiedad("",$login);
		
		$resultado=$equipo->modificarEquipo($_POST[txtConfiguracion]);	
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
					//*******************************************************************************************
					//*******************************************************************************************
					echo "<input name=\"txtServiceTag\" type=\"hidden\" value=\"$_POST[txtServiceTag]\">";
					echo "<input name=\"txtExpressService\" type=\"hidden\" value=\"$_POST[txtExpressService]\">";
					//*******************************************************************************************
					//*******************************************************************************************
					echo "<input name=\"txtIpImpresora\" type=\"hidden\" value=\"$_POST[txtIpImpresora]\">";
					echo "<input name=\"txtColaImpresora\" type=\"hidden\" value=\"$_POST[txtColaImpresora]\">";
					echo "<input name=\"txtMacImpresora\" type=\"hidden\" value=\"$_POST[txtMacImpresora]\">";
					echo "<input name=\"txtTonerNegroImpresora\" type=\"hidden\" value=\"$_POST[txtTonerNegroImpresora]\">";
					echo "<input name=\"txtTonerCyanImpresora\" type=\"hidden\" value=\"$_POST[txtTonerCyanImpresora]\">";
					echo "<input name=\"txtTonerAmarilloImpresora\" type=\"hidden\" value=\"$_POST[txtTonerAmarilloImpresora]\">";
					echo "<input name=\"txtTonerMagentaImpresora\" type=\"hidden\" value=\"$_POST[txtTonerMagentaImpresora]\">";
					echo "<input name=\"txtTamborImagenImpresora\" type=\"hidden\" value=\"$_POST[txtTamborImagenImpresora]\">";
					echo "<input name=\"txtCantidadUsuarios\" type=\"hidden\" value=\"$_POST[txtCantidadUsuarios]\">";
					echo "<input name=\"txtDistanciaMaxima\" type=\"hidden\" value=\"$_POST[txtDistanciaMaxima]\">";					
					//*******************************************************************************************
					//*******************************************************************************************
					echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
					echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
					echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
				
					echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";

					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR EQUIPO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO EL EQUIPO.</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\" onclick=\"location.href='index2.php?item=151&config=$_POST[txtConfiguracion]'\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";				
				break 1;
			case 1:
					echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

					echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
					echo "<input name=\"txtActivoFijo\" type=\"hidden\" value=\"$_POST[txtActivoFijo]\">";
					echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
					echo "<input name=\"txtCt\" type=\"hidden\" value=\"$_POST[txtCt]\">";
					echo "<input name=\"txtFru\" type=\"hidden\" value=\"$_POST[txtFru]\">";
					echo "<input name=\"txtProductNumber\" type=\"hidden\" value=\"$_POST[txtProductNumber]\">";
					echo "<input name=\"txtSpareNumber\" type=\"hidden\" value=\"$_POST[txtSpareNumber]\">";
					//*******************************************************************************************
					//*******************************************************************************************
					echo "<input name=\"txtServiceTag\" type=\"hidden\" value=\"$_POST[txtServiceTag]\">";
					echo "<input name=\"txtExpressService\" type=\"hidden\" value=\"$_POST[txtExpressService]\">";
					//*******************************************************************************************
					//*******************************************************************************************
					echo "<input name=\"txtIpImpresora\" type=\"hidden\" value=\"$_POST[txtIpImpresora]\">";
					echo "<input name=\"txtColaImpresora\" type=\"hidden\" value=\"$_POST[txtColaImpresora]\">";
					echo "<input name=\"txtMacImpresora\" type=\"hidden\" value=\"$_POST[txtMacImpresora]\">";
					echo "<input name=\"txtTonerNegroImpresora\" type=\"hidden\" value=\"$_POST[txtTonerNegroImpresora]\">";
					echo "<input name=\"txtTonerCyanImpresora\" type=\"hidden\" value=\"$_POST[txtTonerCyanImpresora]\">";
					echo "<input name=\"txtTonerAmarilloImpresora\" type=\"hidden\" value=\"$_POST[txtTonerAmarilloImpresora]\">";
					echo "<input name=\"txtTonerMagentaImpresora\" type=\"hidden\" value=\"$_POST[txtTonerMagentaImpresora]\">";
					echo "<input name=\"txtTamborImagenImpresora\" type=\"hidden\" value=\"$_POST[txtTamborImagenImpresora]\">";
					echo "<input name=\"txtCantidadUsuarios\" type=\"hidden\" value=\"$_POST[txtCantidadUsuarios]\">";
					echo "<input name=\"txtDistanciaMaxima\" type=\"hidden\" value=\"$_POST[txtDistanciaMaxima]\">";					
					//*******************************************************************************************
					//*******************************************************************************************
					echo "<input name=\"selEstado\" type=\"hidden\" value=\"$_POST[selEstado]\">";
					echo "<input name=\"selDescripcion\" type=\"hidden\" value=\"$_POST[selDescripcion]\">";
					echo "<input name=\"selMarca\" type=\"hidden\" value=\"$_POST[selMarca]\">";
					echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";


					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: INVENTARIO - MODIFICAR EQUIPO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDIERON HACER LOS CAMBIOS EN EL EQUIPO.</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";				

				break 1;
		}

		break 1;
	default:
		formularioEquipo();
}


function formularioEquipo() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "pedidoAdmin.php";
	require_once("inventarioAdmin.php");

	if (!isset($_POST[txtCambiarSeleccion]) || $_POST[txtCambiarSeleccion==0]) {
		$equipo= new equipo();
		$equipo->setInventario($_GET[idInventario]);
		$resultado=$equipo->buscarEquipo();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			$_POST[txtConfiguracion]=$row[0];
			$_POST[txtConfiguracionAnterior]=$row[0];
			$_POST[txtActivoFijo]=$row[1];
			$_POST[txtSerial]=$row[3];
			$_POST[selDescripcion]=$row[4];
			$_POST[selMarca]=$row[6];

			$_POST[selModelo]=$row[8];
			$_POST[txtCt]=$row[16];
			$_POST[txtFru]=$row[13];
			$_POST[txtProductNumber]=$row[14];
			$_POST[txtSpareNumber]=$row[15];
			$_POST[txtServiceTag]=$row[26];
			$_POST[txtExpressService]=$row[27];
			$_POST[txtIpImpresora]=$row[44];
			$_POST[txtColaImpresora]=$row[45];
			$_POST[txtMacImpresora]=$row[46];
			$_POST[txtTonerNegroImpresora]=$row[47];
			$_POST[txtTonerMagentaImpresora]=$row[48];
			$_POST[txtTonerAmarilloImpresora]=$row[49];
			$_POST[txtTonerCyanImpresora]=$row[50];
			$_POST[txtTamborImagenImpresora]=$row[51];
			$_POST[txtCantidadUsuarios]=$row[52];
			$_POST[txtDistanciaMaxima]=$row[53];
		}
	}
	
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION_PROPIEDAD='DSP0000004' ORDER BY DESCRIPCION";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY MARCA";
	$conModelo="SELECT modelo.ID_MODELO, CONCAT(modelo.MODELO,' ',modelo.CAP_VEL,' ',modelo.UNIDAD) AS MODELO FROM modelo WHERE modelo.ID_MARCA='$_POST[selMarca]' AND modelo.ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY MODELO";
	

	
	//Campo Configuracion
	$configuracion= new campo("txtConfiguracion","text","formularioCampoTexto","$_POST[txtConfiguracion]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtConfiguracion=$configuracion->retornar();
	
	//Campo Activo Fijo
	$activoFijo= new campo("txtActivoFijo","text","formularioCampoTexto","$_POST[txtActivoFijo]","12","12","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtActivoFijo=$activoFijo->retornar();

	//Campo Serial
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();
	
	//Campo Descripción
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();	
	
	//Campo Marca
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onChange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	//Campo Modelo
	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onChange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();
	
	

	//Campo CT
	$ct= new campo("txtCt","text","formularioCampoTexto","$_POST[txtCt]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtCt=$ct->retornar();

	//Campo FRU
	$fru= new campo("txtFru","text","formularioCampoTexto","$_POST[txtFru]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtFru=$fru->retornar();
	//Campo Product Number
	$productNumber= new campo("txtProductNumber","text","formularioCampoTexto","$_POST[txtProductNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtProductNumber=$productNumber->retornar();
	
	//Campo Spare Number
	$spareNumber= new campo("txtSpareNumber","text","formularioCampoTexto","$_POST[txtSpareNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSpareNumber=$spareNumber->retornar();

	//*************************************************************************************************************************
	//*************************************************************************************************************************
	//Campo Service Tag
	$ServiceTag= new campo("txtServiceTag","text","formularioCampoTexto","$_POST[txtServiceTag]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtServiceTag=$ServiceTag->retornar();

	//Campo Express Service
	$ExpressService= new campo("txtExpressService","text","formularioCampoTexto","$_POST[txtExpressService]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtExpressService=$ExpressService->retornar();
	
	//*************************************************************************************************************************
	//*************************************************************************************************************************
	//******21-02-11*******************************************************************************************************************
	//*************************************************************************************************************************
	//Campo Ip Impresora
	$IpImpresora= new campo("txtIpImpresora","text","formularioCampoTexto","$_POST[txtIpImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtIpImpresora=$IpImpresora->retornar();

	//Campo Cola Impresora
	$ColaImpresora= new campo("txtColaImpresora","text","formularioCampoTexto","$_POST[txtColaImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtColaImpresora=$ColaImpresora->retornar();
	
	//Campo Mac Impresora
	$MacImpresora= new campo("txtMacImpresora","text","formularioCampoTexto","$_POST[txtMacImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtMacImpresora=$MacImpresora->retornar();
	
	//Campo Toner Negro Impresora
	$TonerNegroImpresora= new campo("txtTonerNegroImpresora","text","formularioCampoTexto","$_POST[txtTonerNegroImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtTonerNegroImpresora=$TonerNegroImpresora->retornar();
	
	//Campo Toner Magenta Impresora
	$TonerMagentaImpresora= new campo("txtTonerMagentaImpresora","text","formularioCampoTexto","$_POST[txtTonerMagentaImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtTonerMagentaImpresora=$TonerMagentaImpresora->retornar();

	//Campo Toner Magenta Impresora
	$TonerAmarilloImpresora= new campo("txtTonerAmarilloImpresora","text","formularioCampoTexto","$_POST[txtTonerAmarilloImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtTonerAmarilloImpresora=$TonerAmarilloImpresora->retornar();
	
	//Campo Toner Cyan Impresora
	$TonerCyanImpresora= new campo("txtTonerCyanImpresora","text","formularioCampoTexto","$_POST[txtTonerCyanImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtTonerCyanImpresora=$TonerCyanImpresora->retornar();

	//Campo Tambor Imagen Impresora
	$TamborImagenImpresora= new campo("txtTamborImagenImpresora","text","formularioCampoTexto","$_POST[txtTamborImagenImpresora]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtTamborImagenImpresora=$TamborImagenImpresora->retornar();
	
	//Campo Cantidad Usuarios
	$CantidadUsuarios= new campo("txtCantidadUsuarios","text","formularioCampoTexto","$_POST[txtCantidadUsuarios]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtCantidadUsuarios=$CantidadUsuarios->retornar();
	
	//Campo Distancia Maxima
	$DistanciaMaxima= new campo("txtDistanciaMaxima","text","formularioCampoTexto","$_POST[txtDistanciaMaxima]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtDistanciaMaxima=$DistanciaMaxima->retornar();
	
	//*************************************************************************************************************************
	//*************************************************************************************************************************
	
	
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"txtConfiguracionAnterior\" type=\"hidden\" value=\"$_POST[txtConfiguracionAnterior]\">";
	echo "<input name=\"txtCambiarSeleccion\" type=\"hidden\" value=\"0\">";

//Datos del Componente.
	
	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - NUEVO EQUIPO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL EQUIPO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">CONFIGURACION<br>
			$txtConfiguracion<br>
			ACTIVO FIJO<br>$txtActivoFijo<br>
			SERIAL<br>$txtSerial<br>
			DESCRIPCION<br>$selDescripcion<br>
			MARCA<br>$selMarca<br>

			MODELO<br>$selModelo<br>
			CONSUMIBLES DE IMPRESORA<br>
			NEGRO<br>$txtTonerNegroImpresora<br>
			CYAN<br>$txtTonerCyanImpresora<br>
			AMARILLO<br>$txtTonerAmarilloImpresora<br>
			MAGENTA<br>$txtTonerMagentaImpresora<br>
			TAMBOR IMAGEN<br>$txtTamborImagenImpresora<br></td>
    		
			<td valign=top class=\"formularioCampoTitulo\">CT<br>
			$txtCt<br>
			FRU<br>$txtFru<br>
			PRODUCT NUMBER<br>$txtProductNumber<br>
			SPARE NUMBER<br>$txtSpareNumber<br>
			SERVICE TAG<br>$txtServiceTag<br>
			EXPRESS SERVICE<br>$txtExpressService<br>
			COLA IMPRESORA<br>$txtColaImpresora<br>
			IP IMPRESORA<br>$txtIpImpresora<br>
			MAC IMPRESORA<br>$txtMacImpresora<br>
			CANTIDAD USUARIOS<br>$txtCantidadUsuarios<br>
			DISTANCIA MAXIMA<br>$txtDistanciaMaxima<br>			
			</td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnRegresar\" type=\"button\" value=\"REGRESAR\" onclick=\"location.href='index2.php?item=151&config=$_POST[txtConfiguracion]'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";
}
?>

<?php
require_once("seguridad.php");
?>
<script language="javascript">
	function buscarFicha() {
		if (document.frmDespacho.txtFicha.value!="") {
			document.frmDespacho.funcion.value=2;
			document.frmDespacho.submit();	
		}
	}
	function buscarConfiguracion() {
		if (document.frmDespacho.txtConfiguracion.value!="") {
			document.frmDespacho.funcion.value=2;
			document.frmDespacho.submit();
		}
	}
	function cambiarSeleccion() {
		document.frmDespacho.funcion.value=2;
		document.frmDespacho.submit();
	}
	function quitarDespacho() {
		document.frmDespacho.funcion.value=3;
		document.frmDespacho.submit();
	}	
	function asociar() {
			document.frmDespacho.funcion.value=4;
			document.frmDespacho.submit();			
	}
	function despacharComponentes() {
			document.frmDespacho.funcion.value=1;
			document.frmDespacho.submit();			
	}	
</script>
<?php
require_once("inventarioAdmin.php");
require_once("administracion.php");
//Despacho de Componentes de Impresoras
switch ($funcion) {
	case 1:
		if (isset($_POST[selUsuarioSistema]) && $_POST[selUsuarioSistema]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>ANALISTA</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[despachar]) && empty($_POST[despachar])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>LISTA DE DESPACHO</b>";
			$i++;
			$sw=1;
		}		
		switch ($i) {
			case 0:
			
					
				$tmp="'".$_POST[despachar]."'";
				$tmp=str_replace("',","'",$tmp);
				$tmp=str_replace(",","','",$tmp);	
				$login=$_SESSION["login"];
				$despacho= new despacho();
				$despacho->setDespacho("","",$tmp,$_POST[selUsuarioSistema],$login,$_POST[txtCasoHelpDesk],$_POST[txtObservacion],"",$_POST[txtFicha],$_POST[txtConfiguracion]);
				$resultado=$despacho->ingresarDespacho();
				switch ($resultado) {
					case 0:
						echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
						$idDespacho=$despacho->retornarIdDespacho();

						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE COMPONENTES</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO EL NUEVO DESPACHO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">";
						if (isset($_POST[txtFicha]) && !empty($_POST[txtFicha])) {
							echo "<input name=\"btn\" type=\"button\" value=\"IMPRIMIR\" onClick=\"window.open('../librerias/xmlAsignacionComponentes.php?idDespacho=$idDespacho&ficha=$_POST[txtFicha]&suministro=si')\"></td>";
						} else {
							echo "<input name=\"btn\" type=\"button\" value=\"IMPRIMIR\" onClick=\"window.open('../librerias/xmlAsignacionComponentes.php?idDespacho=$idDespacho')\"></td>";
						}
						echo "</tr>";
						echo "</table>";
						echo "</form>";	
						break 1;
					case 1:
						echo "Caso 1";
						break 1;
				}
				break 1;
			case 1:
				echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"despachar\" type=\"hidden\" value=\"$_POST[despachar]\">";
				echo "<input name=\"txtObservacion\" type=\"hidden\" value=\"$_POST[txtObservacion]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: INVENTARIO - DESPACHO DE EQUIPOS</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTA VAC&Iacute;O</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;			
			default:
			
		}
		break 1;
	case 2:
		$tmp="'".$_POST[despachar]."'";
		$tmp=str_replace("',","'",$tmp);
		$tmp=str_replace(",","','",$tmp);	
		frmDespacho($tmp);	
		break 1;
	case 3:
		unset($_POST[despachar]);
		frmDespacho($tmp);		
		break 1;
	case 4:
		if (!empty($_POST[optInventario]))
			$_POST[despachar]=$_POST[despachar].",".$_POST[optInventario];
			$tmp="'".$_POST[despachar]."'";
			$tmp=str_replace("',","'",$tmp);
			$tmp=str_replace(",","','",$tmp);
		frmDespacho($tmp);
		break 1;
	default:
		frmDespacho();	
}




function frmDespacho($elementos="",$quitar="") {
	require_once ("formularios.php");
	//require_once ("inventarioAdmin.php");
		

	$conDescripcion="Select
		descripcion.ID_DESCRIPCION,
		descripcion.DESCRIPCION
		From
		descripcion
		Where
		descripcion.SUMINISTRO = 1
		Order By
		descripcion.DESCRIPCION Asc";
	$conMarca="Select
		descripcion_marca.ID_MARCA,
		marca.MARCA
		From
		marca
		Inner Join descripcion_marca ON descripcion_marca.ID_MARCA = marca.ID_MARCA
		Where
		descripcion_marca.ID_DESCRIPCION = '$_POST[selDescripcion]'
		Order By
		marca.MARCA Asc";
	$conModelo="Select
		modelo.ID_MODELO,concat(modelo.MODELO,'  ',modelo.CAP_VEL,' ',modelo.UNIDAD) as modelo
		From
		modelo
		Where
		modelo.ID_DESCRIPCION = '$_POST[selDescripcion]' AND
		modelo.ID_MARCA = '$_POST[selMarca]'
		Order By
		modelo.MODELO Asc";
	

	$conUss="SELECT distinct usuario_sistema.id_uss, concat(nombre,' ',apellido) as nombres From
		usuario_sistema
		Inner Join usuario_sistema_privilegio ON usuario_sistema.ID_USS = usuario_sistema_privilegio.ID_USS order by nombres";


	$usuarioSistema= new campoSeleccion("selUsuarioSistema","formularioCampoSeleccion","$_POST[selUsuarioSistema]","","",$conUss,"--SELECCIONE--","");
	$selUsuarioSistema=$usuarioSistema->retornar();

	
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--SELECCIONE--","");
	$selDescripcion=$descripcion->retornar();
		
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--SELECCIONE--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--SELECCIONE--","");
	$selModelo=$modelo->retornar();
echo "<form name=\"frmDespacho\" method=\"post\" action=\"\">";
echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";		
echo "<input name=\"despachar\" type=\"hidden\" value=\"$_POST[despachar]\">";

	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">DESPACHO DE COMPONENTES PARA MICROCOMPUTADORAS</td>
	</tr>";
	echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"4\">LISTA DE COMPONENTES A DESPACHAR</td>
		</tr>";

	$despacho=new despacho();
	$resultadoComponentesADespachar=$despacho->mostrarComponentesADespachar($elementos);
	if ($resultadoComponentesADespachar && $resultadoComponentesADespachar!=1) {
		echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">SERIAL</td>
			</tr>";
		$i=0;
			while ($row=mysql_fetch_array($resultadoComponentesADespachar)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\">$row[3]</td>
					<td>$row[5]</td>
					<td>$row[7] $row[8] $row[9]</td>
					<td>$row[1]</td>
				</tr>";
				$i++;
			}
		echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">";
				echo "<a class=\"botonEnlace\" href=\"#\" onClick=\"quitarDespacho()\">LIMPIAR</a>
			</td>
		</tr>";				
	   } else {
		echo "<tr class=\"$clase\">
					<td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
		echo "</tr>";
	}
	
	echo "</table>";
	
	

echo "<table class=\"formularioTabla\"align=center width=\"40%\" border=\"0\">";
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
	
			echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">INVENTARIO - TOTAL: $total </td>
			</tr>";	
			echo "<tr valign=top class=\"tablaTitulo\">
				<td align=\"left\" class=\"tablaTitulo\">SERIAL</td>
				<td valign=top class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
				<td valign=top class=\"tablaTitulo\">MARCA</td>
				<td valign=top class=\"tablaTitulo\">MODELO</td>
				<td valign=top class=\"tablaTitulo\">ESTADO</td>
				</tr>";
			if ($_POST[selDescripcion]==100)
				$_POST[selDescripcion]="";
			if ($_POST[selMarca]==100)
				$_POST[selMarca]="";
			if ($_POST[selModelo]==100)
				$_POST[selModelo]="";
			$componente = new componente();
			$componente->setInventario("",$_POST[txtSerialDisponible],$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo]);
			$resultadoBuscar=$componente->retornarSuministrosDisponibles("",10);
			$despachado= new despacho();
			if ($resultadoBuscar && $resultadoBuscar!=1) {
					while ($row=mysql_fetch_array($resultadoBuscar)) {
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">
						<td align=\"left\"><input name=\"optInventario\" type=\"radio\" value=\"$row[0]\">$row[1]</td>
						<td>$row[3]</td>	
						<td>$row[5]</td>
						<td>$row[7] $row[8] $row[9]</td>
						<td>".$despachado->statusDespacho($row[0])."</td>
						</tr>";
						$i++;	
					}
			}	
		echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">";
				echo "<a class=\"botonEnlace\" href=\"#\" onClick=\"asociar()\">Agregar al Despacho</a>
			</td>
		</tr>";
		echo "</table>";

	echo "<table class=\"formularioTabla\"align=center width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td valign=top class=\"formularioTablaTitulo\" colspan=\"5\">DESPACHAR A</td>
		</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"formularioCampoTitulo\">ANALISTA<br>$selUsuarioSistema</td>
	<td valign=top class=\"formularioCampoTitulo\">CASO HELP DESK<br><input name=\"txtCasoHelpDesk\" value=\"$_POST[txtCasoHelpDesk]\" class=\"formularioCampoTexto\"></td>
	</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"formularioCampoTitulo\">
	FICHA<br>
	<input name=\"txtFicha\" value=\"$_POST[txtFicha]\" class=\"formularioCampoTexto\"></td>
	</tr>";

	echo "<tr>";
	echo "<td valign=top class=\"formularioCampoTitulo\" colspan=\"5\">OBSERVACION<br>
	<textarea class=\"formularioAreaTextoPlanilla\" name=\"txtObservacion\" cols=\"500\" rows=\"2\">$_POST[txtObservacion]</textarea></td>
	</tr>";
	
	echo "<tr>
	<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">
	<input name=\"btnDespachar\" type=\"button\" value=\"DESPACHAR\" onclick=\"despacharComponentes()\">
	</tr>";	
	echo "</table>";
	echo "</form>";
}
?>
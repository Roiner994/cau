<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
 function cambiarSeleccion() {
 	document.frmGarantia.funcion.value=3;
 	document.frmGarantia.submit();
 }
 function buscarSerial() {
 	if (document.frmComponente.txtSerial.value!="") {
 		document.frmComponente.funcion.value=3;
 		document.frmComponente.submit();
 	}
 }
 function buscar() {
 	document.frmGarantia.funcion.value=2;
 	document.frmGarantia.submit();
 }


</script>


<?php
//REPORTES DE GARANTIA

require_once "administracion.php";
require_once "garantiaAdminYosmar.php";
require_once "conexionsql.php";
require_once "formularios.php";
switch ($funcion){
	case 1:

	if (isset($_POST[selStatus]) && $_POST[selStatus]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>ESTATUS GARANTIA</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selProveedor]) && $_POST[selProveedor]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>PROVEEDOR</b>";
		$i++;
		$sw=1;
	}

	if ( empty($_POST[chkGarantia])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>SERIAL</b>";
		$i++;
		$sw=1;
	}

	switch($i) {

		case 0:
		require_once "administracion.php";
		require_once "garantiaAdminYosmar.php";
		require_once "conexionsql.php";
		require_once "formularios.php";
		$estatus= new garantia($_POST[chkGarantia],"",$_POST[selStatus],"","","","","","","","","",$_POST[tipo],"");
		$resultado=$estatus->cambiarStatusGarantia();

		switch($resultado){
			case 0:
			if ($_POST[selStatus]=='STG0000001') {
				$aLista=$_POST['chkGarantia'];
				$valores="'".implode(',',$aLista)."'";
				$valores=str_replace(',','\',\'',$valores);
				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
				echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: GARANTIA - CAMBIAR ESTATUS</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE CAMBIO EL ESTATUS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>
  						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"IMPRIMIR\" onclick=window.open(\"../librerias/xmlSalidaEquipos.php?valores=$valores\")></td>
  						</tr>";
				echo "</table>";
				echo "</form>";
				break 1;
			} else {

				echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
				echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: GARANTIA - CAMBIAR ESTATUS</td>
						</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE CAMBIO EL ESTATUS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnLimpiar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=506'\"></td>
  						</tr>";

				echo "</table>";
				echo "</form>";
				break 1;

			}
		}

		break 1;
		
		case 1:
			echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";


		echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
		echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";

		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: GARANTIA </td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE ".$mensaje. " </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">
				</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
		break 1;
		default:
		echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";


		echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
		echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";

		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: GARANTIA </td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE ".$mensaje. " </td>";
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
		if (isset($_POST[selStatus]) && $_POST[selStatus]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>ESTATUS GARANTIA</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selProveedor]) && $_POST[selProveedor]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>PROVEEDOR</b>";
		$i++;
		$sw=1;
	}
	switch($i) {
		case 0:
			formularioSeleccionarProveedor(1);		
		break 1;
		case 1:
			echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
	
	
			echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
			echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
	
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: GARANTIA </td>
					</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE ".$mensaje. " </td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\">
					</td>";
			echo "</tr>";
			echo "</table>";
			echo "</form>";
		break 1;
		
		default:
			echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
	
	
			echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
			echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
	
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: GARANTIA </td>
					</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE ".$mensaje. " </td>";
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
	formularioSeleccionarProveedor();
}
?>


<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FUNCION MOSTRAR PROVEEDOR
function formularioSeleccionarProveedor($algo=0) {
	require_once "conexionsql.php";
	require_once "formularios.php";
	$conProveedor= "SELECT distinct proveedor.id_proveedor,proveedor from proveedor
				inner join pedido on pedido.id_proveedor=proveedor.id_proveedor
				inner join inventario on inventario.id_pedido=pedido.id_pedido
				inner join garantia on inventario.id_inventario=garantia.id_inventario
        		inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
       			where garantia_estado.id_estatus_garantia<>'STG0000004'
        		and garantia.status_activo='1'
        		and garantia_estado.status_activo='1'
        		order by proveedor desc";

	$conEstatusGarantia= "select distinct garantia_estado.id_estatus_garantia, garantia_status.estatus_garantia
					from garantia_estado
					inner join garantia_status on garantia_status.id_estatus_garantia=garantia_estado.id_estatus_garantia
					inner join garantia on garantia.id_garantia=garantia_estado.id_garantia	
					inner join inventario on garantia.id_inventario=inventario.id_inventario
					inner join pedido on inventario.id_pedido=pedido.id_pedido
					inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor		
					where garantia_estado.id_estatus_garantia<>'STG0000004'
					and garantia.status_activo='1'
          			and garantia_estado.status_activo='1'
          			and proveedor.id_proveedor='$_POST[selProveedor]'
					order by id_estatus_garantia asc";


	//CAMPO STATUS
	$status= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","","",$conEstatusGarantia,"--SELECCIONE--","");
	$selStatus=$status->retornar();

	//Campo Proveedor
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","cambiarSeleccion()",$conProveedor,"--SELECCIONE--","");
	$selProveedor=$proveedor->retornar();

	$descripcion= new campo("txtDescripcion","text","formularioCampoTexto","$_POST[txtDescripcion]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtDescripcion=$descripcion->retornar();
	//CAMPO FECHA INICIO
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
	$txtFechaInicio=$fechaInicio->retornar();

	//CAMPO FECHA FINAL
	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();

	//CAMPO SERIAL
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30");
	$txtSerial=$serial->retornar();
	if (isset($Serial) && !empty($Serial)) {
		$componenteViejo= new garantia("","","","","","","","","",$Serial);
		$resultado=$despacho->equipoFueraPlantaPrueba() ;
		$total=$despacho->total();
		$row=mysql_fetch_array($resultado);
		$_POST[txtGarantia]=$row[0];


	}

	echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">GARANTIA</td>
  				</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">EQUIPOS Y COMPONENTES EN GARANTIA</td>
			
  				</tr>";
	echo "<tr>";
	echo "<tr align=center></tr>
  				</tr>
  
<td valign=top class=\"formularioCampoTitulo\" >PROVEEDOR<br>$selProveedor<br>
ESTATUS GARANTIA<br>$selStatus<br>
SERIAL<br>$txtSerial<br></td>

</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=503'\"><input name=\"Limpiar\" type=\"button\" value=\"BUSCAR\" onClick=\"buscar()\"></td>
  				
			</tr>";
	echo "</table>";

	if ($algo==0) {
		if ($_POST[selProveedor]==100) {
			$_POST[selProveedor]="";
		}
	}

	$garantiaI=$_POST[selProveedor];
	$despacho=new garantia($_POST[chkGarantia],$_POST[txtIdInventario],$_POST[selStatus],"","","","","","",$_POST[txtSerial],$_POST[selProveedor]);
	$resultado=$despacho->equipoFueraPlantaPrueba() ;
	$total=$despacho->total();
	if ($resultado<>1){
	$row=mysql_fetch_array($resultado);
	$_POST[txtIdInventario]=$row[1];
	//echo "<input name=\"txtIdInventario\" type=\"TEXT\" value=\"$_POST[txtIdInventario]\">";
	if ($total>0) {
		//$tituloProveedor="$this->proveedor";
		echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
		echo "<tr>
			<td class=\"formularioTablaTituloCentrado\" align=\"center\" colspan=\"5\">$row[5]</td>
			</tr>";	

		$resultado=$despacho->equipoFueraPlantaPrueba();

		echo "<table width=\"700\" border=\"0\" align=\"center\">
		   <tr>
		  <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCI&Oacute;N</b></td>		  
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  
		  
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {

			//echo "aqui <input name=\"txtGarantia\" type=\"text\" value=\"$_POST[txtGarantia]\">";
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
            }
			if ($row[14]!='DSP0000004') {
				echo "<tr class=\"$clase\">
				<td>";
				if ($_POST[selStatus]=='STG0000003') {
					echo "<a class=enlace href=\"index2.php?item=507&serial=$row[2]\">$row[2]</td>";
				} else {
					echo "<input name=\"chkGarantia[]\" type=\"checkbox\" value=\"$row[0]\">$row[2]</td>";
				}
				echo "<td>$row[7]</td>
				<td>$row[6]</td>
				<td>$row[8]</td>
								
				</tr>";
				$i++;
				$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";
			} else {

				echo "<tr class=\"$clase\">
				<td>";
				if ($_POST[selStatus]=='STG0000003') {
					echo "<a class=enlace href=\"index2.php?item=505&serial=$row[2]\">$row[2]</td>";
				} else {
					echo "<input name=\"chkGarantia[]\" type=\"checkbox\" value=\"$row[0]\">$row[2]</td>";
				}
				echo "<td>$row[7]</td>
				<td>$row[6]</td>
				<td>$row[8]</td>
				</tr>";
				$i++;
				$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";
			}
		}

		echo "</table>";

		switch ($_POST[selStatus]){
			case 'STG0000001':
			echo "<input name=\"tipo\" type=\"hidden\" value=\"STG0000002\">";
			//echo "<input name=\"txtGarantia\" type=\"text\" value=\"$_POST[txtGarantia]\">";
			echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"GENERAR SALIDA\">
			</td>
  		</tr>";
			break 1;
			case 'STG0000002':
			echo "<input name=\"tipo\" type=\"hidden\" value=\"STG0000003\">";
			//echo "<input name=\"txtGarantia\" type=\"text\" value=\"$_POST[txtGarantia]\">";

			echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"FUERA DE PLANTA\">
			</td>
  		</tr>";
			break 1;
			case 'STG0000003':
			//echo "<input name=\"tipo\" type=\"text\" value=\"$row[15]\">";
			break 1;
		}


		echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";

	} else {

	}

}
echo "</form>";

		?>
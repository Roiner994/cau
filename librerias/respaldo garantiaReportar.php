<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmGarantia.funcion.value=3;
		document.frmGarantia.submit();
	}

	function buscar() {
		document.frmGarantia.funcion.value=0;
		document.frmGarantia.submit();
	}


</script>


<?php
//REPORTES DE GARANTIA

/*require_once "administracion.php";
require_once "garantiaAdminYosmar.php";
require_once "conexionsql.php";
require_once "formularios.php";
switch ($funcion){
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
		}

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
	require_once "administracion.php";
	require_once "garantiaAdminYosmar.php";
	require_once "conexionsql.php";
	require_once "formularios.php";
	$estatus= new garantia("","",$_POST[selStatus],"","","","","","","","","",$_POST[tipo],"");

	$resultado=$estatus->cambiarStatusGarantia();

	switch($resultado){

				case 1:
			
		require_once "administracion.php";

			
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
	formularioSeleccionarProveedor(1);
		break 1;
	default:
	formularioSeleccionarProveedor();
}*/
?>
<?php
//REPORTES DE GARANTIA

require_once "administracion.php";
require_once "garantiaAdminYosmar.php";
require_once "conexionsql.php";
require_once "formularios.php";


switch($funcion) {
	case 0:
	formularioSeleccionarProveedor();
		break 1;
	case 1:
			
		require_once "administracion.php";
		if ((isset($_POST[txtFechaInicio]) && !empty($_POST[txtFechaInicio])) && (isset($_POST[txtFechaFinal]) && !empty($_POST[txtFechaFinal]))) {
			$fechaInicio= new fecha($_POST[txtFechaInicio]);
			$fechaFinal= new fecha ($_POST[txtFechaFinal]);
			$fechaI=$fechaInicio->validar();
			$fechaF=$fechaFinal->validar();
			if ($fechaI!=0 && $fechaF!=0) {
				echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

				echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
				echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
				

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: GARANTIA</td>
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
					echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

					echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
					echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\"$_POST[txtFechaInicio]\">";
					echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\"$_POST[txtFechaFinal]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: GARANTIA</td>
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
				
			
	case 2:
	formularioSeleccionarProveedor();
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
       			where  garantia_estado.status_activo='1'
        		order by proveedor desc";

$conEstatusGarantia= "select distinct garantia_estado.id_estatus_garantia, garantia_status.estatus_garantia
					from garantia_estado
					inner join garantia_status on garantia_status.id_estatus_garantia=garantia_estado.id_estatus_garantia
					inner join garantia on garantia.id_garantia=garantia_estado.id_garantia	
					inner join inventario on garantia.id_inventario=inventario.id_inventario
					inner join pedido on inventario.id_pedido=pedido.id_pedido
					inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor		
					where garantia_estado.status_activo='1'
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
		$resultado=$despacho->equipoGarantiaReportar() ;
		$total=$despacho->total();
		$row=mysql_fetch_array($resultado);
		$_POST[txtGarantia]=$row[15];
		
	
	}
	
	
echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REPORTES GARANTIA</td>
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
<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmGarantia.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmGarantia.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
</td>

</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='secciones.php?item=503'\"><input name=\"Limpiar\" type=\"button\" value=\"BUSCAR\" onClick=\"buscar()\"></td>
  				
			</tr>";
echo "</table>";

if ($algo==0) {
if ($_POST[selProveedor]==100) {
			$_POST[selProveedor]="";
}
}
	
	$garantiaI=$_POST[selProveedor];
		$despacho=new garantia("",$_POST[txtIdInventario],$_POST[selStatus],"","","","","","",$_POST[txtSerial],$_POST[selProveedor]);
		$resultado=$despacho->equipoGarantiaReportar() ;
		$total=$despacho->total();
		$row=mysql_fetch_array($resultado);
	
		if ($total>0) {
	   		//$tituloProveedor="$this->proveedor";
				echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTituloCentrado\" align=\"center\" colspan=\"5\">$row[5]</td>
			</tr>";	
	
$resultado=$despacho->equipoGarantiaReportar();	
	
echo "<table width=\"700\" border=\"0\" align=\"center\">
		   <tr>
		  <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCI&Oacute;N</b></td>		  
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>ESTATUS</b></td>
		  
		  
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			$fecha=substr($row[16],8,2).'/'.substr($row[16],5,2).'/'.substr($row[16],0,4);	

				 
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
				<td>$fecha</td>
				<td>$row[17]</td>
				</tr>";
		$i++;
		$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";	
						
	}		
		echo "</table>";
			echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"IMPRIMIR\">
			</td>
  		</tr>";			
		echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";						
		} else {
		
		}

}
		echo "</form>";	


		?>
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
//REPORTES DE GARANTIA

require_once "administracion.php";
require_once "garantiaAdminYosmar.php";
require_once "conexionsql.php";
require_once "formularios.php";
switch ($funcion){
	case 1:
			if (isset($_POST[selProveedor]) && $_POST[selProveedor]==100) {
			echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
			echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
			echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: GARANTIA - REEMPLAZO COMPONENTE</td>
			</tr>";	
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE UN PROVEEEDOR</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			echo "</form>";	
		} else {
			formularioSeleccionarProveedor();			
		}
		break 1;
	/*case 2:
		$sw=0;
		$mensaje="";
		if (isset($_POST[selProveedor]) && empty($_POST[selProveedor])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>MODIFICAR MARCA</b>";
			$i++;
			$sw=1;
		}*/
		
switch($i) {
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
				echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				

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
					echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
				
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
				
}	
	case 3:
	formularioSeleccionarProveedor();
		break 1;
	default:
	formularioSeleccionarProveedor();
}



?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FUNCION MOSTRAR PROVEEDOR
function formularioSeleccionarProveedor() {
require_once "conexionsql.php";
require_once "formularios.php";
$conProveedor= "SELECT distinct proveedor.id_proveedor,proveedor from proveedor
				inner join pedido on pedido.id_proveedor=proveedor.id_proveedor
				inner join inventario on inventario.id_pedido=pedido.id_pedido
				inner join garantia_prueba on inventario.id_inventario=garantia_prueba.id_inventario
        inner join garantia_estado on garantia_prueba.id_garantia=garantia_estado.id_garantia
        where garantia_estado.id_estatus_garantia='STG0000003'
         and garantia_prueba.status_activo='1'
        order by proveedor desc";

	//Campo Proveedor
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","",$conProveedor,"--SELECCIONE--","");
	$selProveedor=$proveedor->retornar();
	
	//CAMPO FECHA INICIO
	$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
	$txtFechaInicio=$fechaInicio->retornar();
	
	//CAMPO FECHA FINAL
	$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	$txtFechaFinal=$fechaFinal->retornar();
 
	//CAMPO SERIAL
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30");
	$txtSerial=$serial->retornar();
	
	
echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REEMPLAZO POR GARANTIA</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">EQUIPOS REEMPLAZO</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
  
<td valign=top class=\"formularioCampoTitulo\" >PROVEEDOR<br>$selProveedor<br>
SERIAL<br>$txtSerial<br></td>

</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='secciones.php?item=503'\"><input name=\"Limpiar\" type=\"submit\" value=\"BUSCAR\"></td>
  				
			</tr>";
echo "</table>";
echo "</form>";
if ($_POST[selProveedor]==100) {
			$_POST[selProveedor]="";
}
}

	$garantiaI=$_POST[selProveedor];
		$despacho=new garantia("","","","","","","","","",$_POST[txtSerial],$_POST[selProveedor]);
		$resultado=$despacho->equipoFueraPlantaPrueba() ;
		$total=$despacho->total();
		$row=mysql_fetch_array($resultado);
		
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
			//$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4); 	  	   
			//$fecha1=substr($row[11],8,2).'/'.substr($row[11],5,2).'/'.substr($row[11],0,4); 	  	   
			//$fecha2=substr($row[12],8,2).'/'.substr($row[12],5,2).'/'.substr($row[12],0,4); 	  	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			
			if ($row[25]!='DSP0000004') {
			echo "<tr class=\"$clase\">			    
				<td><a class=enlace href=\"secciones.php?item=507&serial=$row[2]\">$row[2]</td>
				<td>$row[7]</td>				
				<td>$row[6]</td>
				<td>$row[8]</td>
								
				</tr>";
		$i++;
		$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";	
			} else {
				
		echo "<tr class=\"$clase\">			    
				<td><a class=enlace href=\"secciones.php?item=505&serial=$row[2]\">$row[2]</td>
				<td>$row[6]</td>				
				<td>$row[8]</td>
				<td>$row[10]</td>
								
				</tr>";
		$i++;
		$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";	
			}			
	}	
					echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"7\">TOTAL: $total</td>
			</tr>";	
		echo "</table>";
		echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			
		echo "</form>";	
			
		
		
		} else {
			
		}


?>
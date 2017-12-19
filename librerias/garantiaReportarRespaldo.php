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
function formularioSeleccionarProveedor() {
require_once "conexionsql.php";
require_once "formularios.php";
$conProveedor= "SELECT distinct proveedor.id_proveedor,proveedor from proveedor
				inner join pedido on pedido.id_proveedor=proveedor.id_proveedor
				inner join inventario on inventario.id_pedido=pedido.id_pedido
				inner join garantia on inventario.id_inventario=garantia.id_inventario order by proveedor desc";

	//Campo Proveedor
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","",$conProveedor,"TODOS","");
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
			echo "<td class=\"tituloPagina\" colspan=\"2\">GARANTIA</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">EQUIPOS REPORTADOS</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
  
<td valign=top class=\"formularioCampoTitulo\" >PROVEEDOR<br>$selProveedor<br>
SERIAL<br>$txtSerial<br></td>
<td valign=top class=\"formularioCampoTitulo\" >FECHA INICIAL<br>$txtFechaInicio<a href=\"javascript:show_calendar('frmGarantia.txtFechaInicio');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmGarantia.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>

</td>
</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='secciones.php?item=502'\"><input name=\"Limpiar\" type=\"submit\" value=\"BUSCAR\"></td>
  				</tr>";
echo "</table>";
echo "</form>";
if ($_POST[selProveedor]==100) {
			$_POST[selProveedor]="";
}

}

	$garantiaI=$_POST[selProveedor];
		$despacho=new garantia("","","","","","","",$_POST[txtFechaInicio],$_POST[txtFechaFinal],$_POST[txtSerial],$_POST[selProveedor]);
		$resultado=$despacho->buscar4();
		$total=$despacho->total();
	
	$row=mysql_fetch_array($resultado);
		if ($total>0) {
	   		//$tituloProveedor="$this->proveedor";
				echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTituloCentrado\" align=\"center\" colspan=\"5\">$row[4]</td>
			</tr>";	
	
$resultado=$despacho->buscar4();		
echo "<table width=\"700\" border=\"0\" align=\"center\">
		   <tr>
		  <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA REPORTADO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA SALIDA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA FUERA DE PLANTA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA REINTEGRO</b></td>		  
		  <td valign=top class=\"tablaTitulo\"><b>FIN GARANTIA</b></td>
		  
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4); 	  	   
			$fecha1=substr($row[11],8,2).'/'.substr($row[11],5,2).'/'.substr($row[11],0,4); 	  	   
			$fecha2=substr($row[14],8,2).'/'.substr($row[14],5,2).'/'.substr($row[14],0,4); 
			$fecha3=substr($row[15],8,2).'/'.substr($row[15],5,2).'/'.substr($row[15],0,4);	
			$fecha4=substr($row[16],8,2).'/'.substr($row[16],5,2).'/'.substr($row[16],0,4);	

			if ($fecha2!='00/00/0000') {
				$fecha2= $fecha2.' ('.$row[21].')';
			} else {
				$fecha2='NO TIENE';	
			}
			if ($fecha3!='00/00/0000') {
				$fecha3= $fecha3.' ('.$row[22].')';
			} else {
				$fecha3='NO TIENE';	
			}   
			
			if ($fecha4!='00/00/0000') {
				$fecha4= $fecha4.' ('.$row[23].')';
			} else {
				$fecha4='NO TIENE';	
			} 
			 
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">			    
				<td>$row[2]</td>
				<td>$row[6]</td>
				<td>$fecha1</td>				
				<td>$fecha2</td>
				<td>$fecha3</td>
				<td>$fecha4</td>
				<td>$fecha</td>
				
				</tr>";
		$i++;
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
<script language="javascript">
function ChequearTodos(chkbox){
for (var i=0;i < document. forms[0].elements.length;i++){
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox"){
elemento.checked = chkbox.checked
}
}
}

function cambiarSeleccion() {
	document.frmGarantia.funcion.value=2;
	document.frmGarantia.selStatus.value="";	
	document.frmGarantia.submit();
}
</script>

<?php
//MODULO GARANTIA
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
				echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
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
					echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
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
		
		if (isset($_POST[selStatus]) && $_POST[selStatus]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>STATUS</b>";
			$i++;
			$sw=1;
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
	//$fechaInicio= new campo("txtFechaInicio","text","formularioCampoTexto","$_POST[txtFechaInicio]","10","10","","");
	//$txtFechaInicio=$fechaInicio->retornar();
	
	//CAMPO FECHA FINAL
	//$fechaFinal= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","10","10");
	//$txtFechaFinal=$fechaFinal->retornar();
	
$conEstatusGarantia= "select distinct  status_garantia.id_estatus_garantia,estatus_garantia from status_garantia
					inner join garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
					order by estatus_garantia desc";

	//CAMPO STATUS
	$status= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","onChange","",$conEstatusGarantia,"TODOS","");
	$selStatus=$status->retornar();
	
	echo "<input name=\"selStatus\" type=\"hidden\" value=\$_POST[selStatus]\>";
	
echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">GARANTIA</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">EQUIPOS EN GARANTIA</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<tr align center><td valign=top class=\"formularioCampoTitulo\" >PROVEEDOR<br>$selProveedor<br>
STATUS DE GARANTIA<br>$selStatus</br>


</td>
</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"BUSCAR\">
			</td>
  		</tr>";
echo "</table>";
if ($_POST[selProveedor]==100) {
			$_POST[selProveedor]="";
}
if ($_POST[selStatus]==100) {
			$_POST[selStatus]="";
}
/*if ($_POST[selStatus]==100) {
			$_POST[selStatus]="";
			echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
					echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: GARANTIA</td>
					</tr>";	
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>SELECCIONE STATUS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";	
					echo "</form>";			
}*/
}

	$garantiaI=$_POST[selProveedor];
		$despacho=new garantia("","",$_POST[selStatus],"","","","","","","",$_POST[selProveedor]);
		$resultado=$despacho->buscar();
		$total=$despacho->total();
	
	
		if ($total>0) {
	   		
				echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">TOTAL EQUIPOS: $total </td>
			</tr>";	
	
		
echo "<table width=\"700\" border=\"0\" align=\"center\">
		   <tr>
		  <td valign=top align=left class=\"tablaTituloIzquierda\"><b><input type=\"checkbox\" align =\"right\" name=\"campo1[]\" value=\"\" onClick=\"ChequearTodos(this);\">SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>ESTATUS</b></td>		  
		  <td valign=top class=\"tablaTitulo\"><b>FIN GARANTIA</b></td>		  
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4); 	  	   
			//$fecha1=substr($row[11],8,2).'/'.substr($row[11],5,2).'/'.substr($row[11],0,4); 	  	   
			//$fecha2=substr($row[12],8,2).'/'.substr($row[12],5,2).'/'.substr($row[12],0,4); 	  	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			
			echo "<tr class=\"$clase\" title=\"PROVEEDOR: $row[4] \">			    
				<td align=\"left\"><input name=\"campo[]\" type=\"checkbox\" value=\"$row[2]\">$row[2]</td>
				<td>$row[16]$row[17]</td>				
				<td>$row[6]</td>
				<td>$row[8]</td>
				<td>$row[10]</td>
				<td>$row[15]</td>				
				<td>$fecha</td>				
				</tr>";
		$i++;
		}
		echo "</table>";
		echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"CAMBIAR STATUS\">
			</td>
  		</tr>";
		echo "</form>";	
			
		
		
		} else {
			
			/*echo "<form name=\"frmGarantia1\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
					echo "<input name=\"selStatus\" type=\"hidden\" value=\"$_POST[selStatus]\">";
					echo "<input name=\"selProveedor\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: GARANTIA</td>
					</tr>";	
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>NO SE OBTUVIERON RESULTADOS DE SU BUSQUEDA</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"onclick=\"location.href='secciones.php?item=501'\"></td>";
					echo "</tr>";
					echo "</table>";	
					echo "</form>";	*/
			
		}
//}
}else {
	/*	$garantiaI=$_POST[selProveedor];
		$resultado=$despacho->buscar();
		$total=$despacho->total();
	if ($total>0) {
			echo "<input name=\"txtFechaInicio\" type=\"hidden\" value=\$_POST[txtFechaInicio]\>";
			echo "<input name=\"txtFechaFinal\" type=\"hidden\" value=\$_POST[txtFechaFinal]\>";
			echo "<input name=\"selStatus\" type=\"hidden\" value=\$_POST[selStatus]\>";
			echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">TOTAL EQUIPOS: $total </td>
			</tr>";	
		
echo "<table width=\"700\" border=\"0\" align=\"center\">
		  <tr>
		  <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA</b></td>
		  
		  <td valign=top class=\"tablaTitulo\"><b>FIN GARANTIA</b></td>
		  
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4); 	  	   
			$fecha1=substr($row[11],8,2).'/'.substr($row[11],5,2).'/'.substr($row[11],0,4); 	  	   
			$fecha2=substr($row[12],8,2).'/'.substr($row[12],5,2).'/'.substr($row[12],0,4); 	  	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\" title=\"PROVEEDOR: $row[4] \">			    
				<td align=\"left\"><input name=\"\" type=\"checkbox\" value=\"$row[2]\">$row[2]</td>	
				<td>$row[16]$row[17]</td>			
				<td>$row[6]</td>
				<td>$row[8]</td>
				<td>$row[10]</td>
				<td>$fecha1</td>
				
				<td>$fecha</td>
				
				</tr>";
		$i++;
		}
		echo "</table>";
		echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"submit\" value=\"CAMBIAR STATUS\">
			</td>
  		</tr>";
		}*/ else {
			
		}
}




?>




<?php
session_start();
$Acceso=array ("PRV0000001","PRV0000002");
switch ($_SESSION[authUser]) {
	case '0':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table>";
		exit();
		break 1;
	case '1':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
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
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
			echo "</table>";		
			exit();
			break 1;
		case 2:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
			echo "</tr>";
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
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\"></td>";
				echo "</tr>";
				echo "</table>";	
				exit();
			}
	}
}

?>

<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script language="javascript">
	function cambiarSeleccion() {
		document.frmGarantia.funcion.value=1;
		document.frmGarantia.submit();
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

	function Num(e){ 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    patron =/[0-9]/; // Solo numeros  
	te = String.fromCharCode(tecla); 
    return patron.test(te); 
    }
    
    function fuera() {
		document.frmRequrimientoRedes.funcion.value=2;
		document.frmRequrimientoRedes.submit();
    }
    function entrarDenuevo() {
		 document.frmRequrimientoRedes.funcion.value=3;
		 document.frmRequrimientoRedes.submit();
}			
</script>


<?php
//REPORTES DE GARANTIA
require_once "administracion.php";
require_once "garantiaAdmin.php";
require_once "conexionsql.php";
require_once "formularios.php";

switch($funcion) {	
	case 1:	
	if (isset($_POST[selGerencia]) && ($_POST[selGerencia]==100)) {		
		if ($sw==1) {			
			$mensaje=$mensaje."<b>,</b>";
		}		
		$mensaje=$mensaje."<b>GERENCIA</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selDivision]) && ($_POST[selDivision]==100)) {		
		if ($sw==1) {			
			$mensaje=$mensaje."<b>,</b>";
		}		
		$mensaje=$mensaje."<b>DIVISION</b>";
		$i++;
		$sw=1;
	}  
  if (empty($_POST[txtRedes]) && ($_POST[selEstRedes]=='IDR0000001' || $_POST[selEstRedes]=='100')) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>AREA</b>";
		$i++;
		$sw=1;
  }
  if (isset($_POST[selEstRedes]) && $_POST[selEstRedes]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>TIPO REQUERIMIENTO</b>";
		$i++;
		$sw=1;
	}
	
	if (isset($_POST[txtCantidad]) && empty($_POST[txtCantidad])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>CANTIDAD</b>";
		$i++;
		$sw=1;
	}	
	switch($i) {
		case 0:
		$fechaInicio=getdate();
		$fechaInicio=$fechaInicio[year]."-".$fechaInicio[mon]."-".$fechaInicio[mday]." ".$fechaInicio[hours].":".$fechaInicio[minutes].":".$fechaInicio[seconds];								
		$consulReqRedes="select id_req_redes from requerimiento_redes order by id_req_redes desc";
		$consec= new consecutivo("IDR", $consulReqRedes);
		$reqRedes=$consec->retornar();
		$area=strtoupper($_POST[txtRedes]);			
		$consulta="insert into requerimiento_redes(ID_REQ_REDES, ID_DIVISION, ID_REDES, DESCRIPCION_REDES, FECHA_INICIO, CANTIDAD)
	    values ('$reqRedes','$_POST[selDivision]','$_POST[selEstRedes]','$area','$fechaInicio','$_POST[txtCantidad]')";		
		$resultado=mysql_query($consulta);
		if ($resultado){
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoRedes\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
			    echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"txtRedes\" type=\"hidden\" value=\"$_POST[txtRedes]\">";
				echo "<input name=\"selEstRedes\" type=\"hidden\" value=\"$_POST[selEstRedes]\">";					
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - REDES</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN ÉXITOSA</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			    echo "</tr>";
			    echo "</table>";			    
				}
				else{
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoRedes\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - REDES</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN FALLIDA INTENTELO DE NUEVO</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			    echo "</tr>";
			    echo "</table>";
				}
		break 1;
		case 1:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoRedes\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"txtRedes\" type=\"hidden\" value=\"$_POST[txtRedes]\">";
		echo "<input name=\"selEstRedes\" type=\"hidden\" value=\"$_POST[selEstRedes]\">";	
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - REDES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTÁ VACIO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
		echo "</tr>";
		echo "</table>";			
		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoRedes\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"txtRedes\" type=\"hidden\" value=\"$_POST[txtRedes]\">";
		echo "<input name=\"selEstRedes\" type=\"hidden\" value=\"$_POST[selEstRedes]\">";	
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - REDES</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
		echo "</tr>";
		echo "</table>";			
	}	
	break 1;				
	case 2:
	exit();
	break 1;
	case 3:
	formularioRequerimientoHardware();
	break 1;
	default:
	formularioRequerimientoHardware();
}



?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FUNCION MOSTRAR PROVEEDOR
function formularioRequerimientoHardware() {
require_once "conexionsql.php";
require_once "formularios.php";
$conGerencia= "SELECT ID_GERENCIA,GERENCIA FROM GERENCIA";
$conDivision="SELECT ID_DIVISION,DIVISION FROM DIVISION WHERE ID_GERENCIA='$_POST[selGerencia]'";
$conHardware="select distinct id_descripcion,descripcion from descripcion where descripcion.descripcion='MICROCOMPUTADOR' or descripcion.descripcion='PORTATIL' or
			  descripcion.descripcion='TELEFONO CELULAR' or descripcion.descripcion='IMPRESORA' or descripcion.descripcion='VIDEO BEAM' or descripcion.descripcion='SCANER' or descripcion.descripcion='FAX'
			  or descripcion.descripcion='TELEFONO' or descripcion.descripcion='CD-RW' or descripcion.descripcion='PEN DRIVE' order by descripcion.descripcion";
$conEstatusRedes="select id_redes,redes from redes where status_activo ='1' order by redes.redes";
	//Campo Proveedor
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","entrarDenuevo()",$conGerencia,"--SELECCIONE--","");
	$selGerencia=$gerencia->retornar();
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","",$conDivision,"--SELECCIONE--","");
	$selDivision=$division->retornar();	
    $estatusRedes= new campoSeleccion("selEstRedes","formularioCampoSeleccion","$_POST[selEstRedes]","onChange","",$conEstatusRedes,"--SELECCIONE--","");
	$selEstatusRedes=$estatusRedes->retornar();			
	//cantidad
	$txtCantidad= new campo("txtCantidad","text","formularioCampoTexto","$_POST[txtCantidad]","5","3","onKeyPress","return Num(event)");
	$cantidad=$txtCantidad->retornar(); 		
echo "<form name=\"frmRequrimientoRedes\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">REQUERIMIENTOS</td>
  		</tr>";
		echo "<tr>";
		echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REQUERIMIENTO DE REDES</td>
		</tr>";
	    echo "<tr>";
		echo "<tr align=center></tr>
  		</tr>  
<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia<br>DIVISION<br>$selDivision<br>ÁREA<br>
                         <textarea name=\"txtRedes\" cols=\"35\" rows=\"3\"></textarea><br></td>
<td valign=top class=\"formularioCampoTitulo\" >TIPO REQUERIMIENTO<br>$selEstatusRedes<br>
CANTIDAD<br>$cantidad<br>
</td>
</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" title=\"Almacenar requerimiento en la base de dato\" type=\"submit\" value=\"ALMACENAR\"><input name=\"Limpiar\" title=\"Cancelar requerimiento\" type=\"button\" value=\"CANCELAR\" onclick=\"fuera()\"></td>
  				</tr>";
echo "</table>";
echo "</form>";
}
?>
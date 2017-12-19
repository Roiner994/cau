<?php
session_start();
$Acceso=array ("PRV0000001");
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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
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
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
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
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
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
		document.frmRequrimientoHardware.funcion.value=2;
		document.frmRequrimientoHardware.submit();
    }
    function entrarDenuevo() {
		 document.frmRequrimientoHardware.funcion.value=3;
		 document.frmRequrimientoHardware.submit();
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

	if (isset($_POST[selHardware]) && ($_POST[selHardware]==100)) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>HARDWARE</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selEstHardware]) && $_POST[selEstHardware]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>ESTATUS</b>";
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
		$consulReqHardware="select id_req_hardware from requerimiento_hardware order by id_req_hardware desc";
		$consec= new consecutivo("RQH", $consulReqHardware);
		$reqHardware=$consec->retornar();			
		$consulta="insert into requerimiento_hardware(ID_REQ_HARDWARE, ID_DESCRIPCION, ID_DIVISION, ESTATUS_REQUERIMIENTO,FECHA_INICIO,CANTIDAD)
	    values ('$reqHardware','$_POST[selHardware]','$_POST[selDivision]','$_POST[selEstHardware]','$fechaInicio','$_POST[txtCantidad]')";		
		$resultado=mysql_query($consulta);
		if ($resultado){
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoHardware\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selHardware\" type=\"hidden\" value=\"$_POST[selHardware]\">";
				echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";			
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - HARDWARE</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN ÉXITOSA</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			    echo "</tr>";
			    echo "</table>";			    
				}
				else{
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoHardware\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - HARDWARE</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN FALLIDA INTENTELO DE NUEVO</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			    echo "</tr>";
			    echo "</table>";
				}
		break 1;
		case 1:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoHardware\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selHardware\" type=\"hidden\" value=\"$_POST[selHardware]\">";
		echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - HARDWARE</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTÁ VACIO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";			
		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmRequrimientoHardware\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selHardware\" type=\"hidden\" value=\"$_POST[selHardware]\">";
		echo "<input name=\"selEstHardware\" type=\"hidden\" value=\"$_POST[selEstHardware]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - HARDWARE</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
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
$conEstatus="select id_Motivo_Solicitud,Motivo_Solicitud from motivo_solicitud
			 where status_activo ='1' and id_Motivo_Solicitud='MOT0000001' or id_Motivo_Solicitud='MOT0000004'
			 order by Motivo_Solicitud";
	//Campo Proveedor
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","entrarDenuevo()",$conGerencia,"--SELECCIONE--","");
	$selGerencia=$gerencia->retornar();
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","",$conDivision,"--SELECCIONE--","");
	$selDivision=$division->retornar();
	$hardware= new campoSeleccion("selHardware","formularioCampoSeleccion","$_POST[selHardware]","onChange","",$conHardware,"--SELECCIONE--","");
	$selHardware=$hardware->retornar();
    $estatusHardware= new campoSeleccion("selEstHardware","formularioCampoSeleccion","$_POST[selEstHardware]","onChange","",$conEstatus,"--SELECCIONE--","");
	$selEstatusHardware=$estatusHardware->retornar();			
	//cantidad
	$txtCantidad= new campo("txtCantidad","text","formularioCampoTexto","$_POST[txtCantidad]","5","10","onKeyPress","return Num(event)");
	$cantidad=$txtCantidad->retornar(); 		
echo "<form name=\"frmRequrimientoHardware\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REQUERIMIENTOS</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REQUERIMIENTO DE HARDWARE</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
  
<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia<br>DIVISION<br>$selDivision<br>HARDWARE<br>$selHardware<br></td>
<td valign=top class=\"formularioCampoTitulo\" >TIPO REQUERIMIENTO<br>$selEstatusHardware<br>
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
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
		document.frmRequrimientoOrganizacionRequerimiento.funcion.value=2;
		document.frmRequrimientoOrganizacionRequerimiento.submit();
    }
    function entrarDenuevo() {
		 document.frmRequrimientoOrganizacionRequerimiento.funcion.value=3;
		 document.frmRequrimientoOrganizacionRequerimiento.submit();
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

	if (isset($_POST[selOrganizacionProcedimiento]) && ($_POST[selOrganizacionProcedimiento]==100)) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>ORGANIZACIÓN Y PROCEDIMIENTO</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selEstOrganizacionProcedimiento]) && $_POST[selEstOrganizacionProcedimiento]==100) {
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
		$consulReqOrganizacionProcedimiento="select ID_REQ_PROCEDIMIENTO from requerimiento_organizacion_procedimiento order by ID_REQ_PROCEDIMIENTO desc";
		$consec= new consecutivo("IRP", $consulReqOrganizacionProcedimiento);
		$reqOrganizacionProcedimiento=$consec->retornar();			
		$consulta="insert into requerimiento_organizacion_procedimiento(ID_REQ_PROCEDIMIENTO, ID_DIVISION, ID_ORG_PROCEDIMIENTO, ID_TIPO_ORG, FECHA_INICIO, CANTIDAD)
	    values ('$reqOrganizacionProcedimiento','$_POST[selDivision]','$_POST[selOrganizacionProcedimiento]','$_POST[selEstOrganizacionProcedimiento]','$fechaInicio','$_POST[txtCantidad]')";				
		$resultado=mysql_query($consulta);
		if ($resultado){
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoOrganizacionRequerimiento\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selOrganizacionProcedimiento]\">";
				echo "<input name=\"selEstOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selEstOrganizacionProcedimiento]\">";								
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - ORGANIZACIÓN Y PROCEDIMIENTO</td>
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
				echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoOrganizacionRequerimiento\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selOrganizacionProcedimiento]\">";
				echo "<input name=\"selEstOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selEstOrganizacionProcedimiento]\">";								
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - ORGANIZACIÓN Y PROCEDIMIENTO</td>
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
		echo "<form name=\"frmRequrimientoOrganizacionRequerimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selOrganizacionProcedimiento]\">";
		echo "<input name=\"selEstOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selEstOrganizacionProcedimiento]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - ORGANIZACIÓN Y PROCEDIMIENTO</td>
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
		echo "<form name=\"frmRequrimientoOrganizacionRequerimiento\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selOrganizacionProcedimiento]\">";
		echo "<input name=\"selEstOrganizacionProcedimiento\" type=\"hidden\" value=\"$_POST[selEstOrganizacionProcedimiento]\">";
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"600\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - ORGANIZACIÓN Y PROCEDIMIENTO</td>
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
	formularioRequerimientOrganizacionRequerimiento();
	break 1;
	default:
	formularioRequerimientOrganizacionRequerimiento();
}



?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FUNCION MOSTRAR PROVEEDOR
function formularioRequerimientOrganizacionRequerimiento() {
require_once "conexionsql.php";
require_once "formularios.php";
$conGerencia= "SELECT ID_GERENCIA,GERENCIA FROM GERENCIA";
$conDivision="SELECT ID_DIVISION,DIVISION FROM DIVISION WHERE ID_GERENCIA='$_POST[selGerencia]'";
$conOrganizacionProcedimiento="select ID_ORG_PROCEDIMIENTO,ORGANIZACION_PROCEDIMIENTO from organizacion_procedimiento where ESTATUS_ORG_PROCEDIMIENTO='1' order by ORGANIZACION_PROCEDIMIENTO";
$conTipOrganizacionProcedimiento="SELECT ID_TIPO_ORG, TIPO_ORG_PROCEDIMIENTO from tipo_organi_procedimiento where status_activo='1' order by TIPO_ORG_PROCEDIMIENTO";
	//Campo Proveedor
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","entrarDenuevo()",$conGerencia,"--SELECCIONE--","");
	$selGerencia=$gerencia->retornar();
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","",$conDivision,"--SELECCIONE--","");
	$selDivision=$division->retornar();
	$organizacionProcedimiento= new campoSeleccion("selOrganizacionProcedimiento","formularioCampoSeleccion","$_POST[selOrganizacionProcedimiento]","onChange","",$conOrganizacionProcedimiento,"--SELECCIONE--","");
	$selOrganizacionProcedimiento=$organizacionProcedimiento->retornar();
    $estatusOrganizacionProcedimiento= new campoSeleccion("selEstOrganizacionProcedimiento","formularioCampoSeleccion","$_POST[selEstOrganizacionProcedimiento]","onChange","",$conTipOrganizacionProcedimiento,"--SELECCIONE--","");
	$selEstatusOrgProcedimiento=$estatusOrganizacionProcedimiento->retornar();			
	//cantidad
	$txtCantidad= new campo("txtCantidad","text","formularioCampoTexto","$_POST[txtCantidad]","3","3","onKeyPress","return Num(event)");
	$cantidad=$txtCantidad->retornar(); 		
echo "<form name=\"frmRequrimientoOrganizacionRequerimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REQUERIMIENTOS</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REQUERIMIENTO DE ORGANIZACIÓN Y PROCEDIMIENTO</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
  
<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia<br>DIVISION<br>$selDivision<br>ORGANIZACIÓN Y PROCEDIMIENTO<br>$selOrganizacionProcedimiento<br></td>
<td valign=top class=\"formularioCampoTitulo\" >TIPO REQUERIMIENTO<br>$selEstatusOrgProcedimiento<br>
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
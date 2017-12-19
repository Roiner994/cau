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
		document.frmRequrimientoSistemaInformacion.funcion.value=2;
		document.frmRequrimientoSistemaInformacion.submit();
    }
    function entrarDenuevo() {
		 document.frmRequrimientoSistemaInformacion.funcion.value=3;
		 document.frmRequrimientoSistemaInformacion.submit();
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

	if (isset($_POST[selSistemaInformacion]) && ($_POST[selSistemaInformacion]==100)) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>SISTEMA DE INFORMACIÓN</b>";
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
		$consulReqSistemaInformacion="select ID_REQ_INFORMACION  from requerimiento_sistema_informacion order by  ID_REQ_INFORMACION desc";
		$consec= new consecutivo("RQI", $consulReqSistemaInformacion);
		$reqSistemaInformacion=$consec->retornar();			
		$consulta="insert into requerimiento_sistema_Informacion(ID_REQ_INFORMACION, ID_SOFTWARE, ID_DIVISION, CANTIDAD, FECHA_INICIAL)
	    values ('$reqSistemaInformacion','$_POST[selSistemaInformacion]','$_POST[selDivision]','$_POST[txtCantidad]','$fechaInicio')";			
		$resultado=mysql_query($consulta);
		if ($resultado){
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selSistemaInformacion\" type=\"hidden\" value=\"$_POST[selSistemaInformacion]\">";										
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - SISTEMA INFORMACIÓN</td>
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
			    echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
			    echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selSistemaInformacion\" type=\"hidden\" value=\"$_POST[selSistemaInformacion]\">";										
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - REQUERIMIENTO - SISTEMA INFORMACIÓN</td>
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
		echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selSistemaInformacion\" type=\"hidden\" value=\"$_POST[selSistemaInformacion]\">";		
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE - REQUERIMIENTO - SISTEMA INFORMACIÓN</td>
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
		echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selSistemaInformacion\" type=\"hidden\" value=\"$_POST[selSistemaInformacion]\">";		
		echo "<input name=\"txtCantidad\" type=\"hidden\" value=\"$_POST[txtCantidad]\">";		
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE - REQUERIMIENTO - SISTEMA INFORMACIÓN</td>
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
	formularioRequerimientoSistemaInformacion();
	break 1;
	default:
	formularioRequerimientoSistemaInformacion();
}



?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FUNCION MOSTRAR PROVEEDOR
function formularioRequerimientoSistemaInformacion() {
require_once "conexionsql.php";
require_once "formularios.php";
$conGerencia= "SELECT ID_GERENCIA,GERENCIA FROM GERENCIA";
$conDivision="SELECT ID_DIVISION,DIVISION FROM DIVISION WHERE ID_GERENCIA='$_POST[selGerencia]'";
$conSistemaInformacion="select distinct id_software,software from software
						inner join tipo_software on software.id_tipo_software=tipo_software.id_tipo_software
						where software.id_tipo_software='ITS0000003'";	
$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","entrarDenuevo()",$conGerencia,"--SELECCIONE--","");
$selGerencia=$gerencia->retornar();
$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","entrarDenuevo()",$conDivision,"--SELECCIONE--","");
$selDivision=$division->retornar();
$SistemaInformacion= new campoSeleccion("selSistemaInformacion","formularioCampoSeleccion","$_POST[selSistemaInformacion]","onChange","",$conSistemaInformacion,"--SELECCIONE--","");
$selSistemaInformacion=$SistemaInformacion->retornar();    
	//cantidad
$txtCantidad= new campo("txtCantidad","text","formularioCampoTexto","$_POST[txtCantidad]","3","3","onKeyPress","return Num(event)");
$cantidad=$txtCantidad->retornar(); 		
echo "<form name=\"frmRequrimientoSistemaInformacion\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REQUERIMIENTOS</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REQUERIMIENTO DE SISTEMA DE INFORMACIÓN</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
  
<td valign=top class=\"formularioCampoTitulo\" >GERENCIA<br>$selGerencia<br>DIVISION<br>$selDivision<br></td>
<td valign=top class=\"formularioCampoTitulo\" >
SISTEMA INFORMACIÓN<br>$selSistemaInformacion<br>
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
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
		document.frmRequrimientoAplicaciones.funcion.value=1;
		document.frmRequrimientoAplicaciones.submit();
	}
	function buscarSerial() {
		if (document.frmComponente.txtSerial.value!="") {
			document.frmComponente.funcion.value=3;
			document.frmComponente.submit();
		}
	}	
	function Num(e){ 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    patron =/[0-9]/; // Solo numeros  
	te = String.fromCharCode(tecla); 
    return patron.test(te); 
}
function fuera() {
		document.frmRequrimientoAplicaciones.funcion.value=2;
		document.frmRequrimientoAplicaciones.submit();
}	
function entrarDenuevo() {
		 document.frmRequrimientoAplicaciones.funcion.value=3;
		 document.frmRequrimientoAplicaciones.submit();
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

	if (isset($_POST[selAplicacion]) && ($_POST[selAplicacion]==100)) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>PLATAFORMA</b>";
		$i++;
		$sw=1;
	}
	
	if  (isset($_POST[selAplicacion]) && (empty($_POST[txtAplicacion]))) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje."<b>APLICACIÓN</b>";
		$i++;
		$sw=1;
	}		
	switch($i) {
		case 0:
		$fechaInicio=getdate();
		$fechaInicio=$fechaInicio[year]."-".$fechaInicio[mon]."-".$fechaInicio[mday]." ".$fechaInicio[hours].":".$fechaInicio[minutes].":".$fechaInicio[seconds];								
		$consulReqAplicacion="select ID_REQ_APLICACIONES  from requerimiento_aplicaciones order by ID_REQ_APLICACIONES  desc";
		$consec= new consecutivo("RQA", $consulReqAplicacion);
		$reqAplicacion=$consec->retornar();
		$txtAplicacion=strtoupper($_POST[txtAplicacion]);		
		$consulta="insert into requerimiento_aplicaciones(ID_REQ_APLICACIONES, REQUERIMIENTO_APLICACION, ID_DIVISION, ID_MIGRACION, FECHA_INICIO)
	    values ('$reqAplicacion','$txtAplicacion','$_POST[selDivision]','$_POST[selAplicacion]','$fechaInicio')";						
		$resultado=mysql_query($consulta);
		if ($resultado){
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";			    
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"txtAplicacion\" type=\"hidden\" value=\"$_POST[txtAplicacion]\">"; 										
				echo "<input name=\"selAplicacion\" type=\"hidden\" value=\"$_POST[selAplicacion]\">";				
				echo "<tr>";
		     	echo "<td align=center>MENSAJE: REQUERIMIENTOS  DE APLICACIONES</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN ÉXITOSA</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"ACEPTAR\"></td>";
			    echo "</tr>";
			    echo "</table></form>";			    
				}
				else{
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";			   		    			    
			    echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";			    
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"txtAplicacion\" type=\"hidden\" value=\"$_POST[txtAplicacion]\">";										
				echo "<input name=\"selAplicacion\" type=\"hidden\" value=\"$_POST[selAplicacion]\">";				
				echo "<tr>";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE: REQUERIMIENTOS  DE APLICACIONES</td>
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
		echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"txtAplicacion\" type=\"hidden\" value=\"$_POST[txtAplicacion]\">";
		echo "<input name=\"selAplicacion\" type=\"hidden\" value=\"$_POST[selAplicacion]\">";						
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS  DE APLICACIONES</td>
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
		echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"txtAplicacion\" type=\"hidden\" value=\"$_POST[txtAplicacion]\">";
		echo "<input name=\"selAplicacion\" type=\"hidden\" value=\"$_POST[selAplicacion]\">";					
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: REQUERIMIENTOS - APLICACIONES</td>
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
	formularioRequerimientoSoftware();
	break 1;
	default:
	formularioRequerimientoSoftware();
}



?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FUNCION MOSTRAR PROVEEDOR
function formularioRequerimientoSoftware() {
require_once "conexionsql.php";
require_once "formularios.php";
$conGerencia= "SELECT ID_GERENCIA,GERENCIA FROM GERENCIA";
$conDivision="SELECT ID_DIVISION,DIVISION FROM DIVISION WHERE ID_GERENCIA='$_POST[selGerencia]'";
$conAplicacion="select distinct ID_MIGRACION,MIGRACION from migracion  where status_activo='1' order by MIGRACION";
	//Campo Proveedor
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","entrarDenuevo()",$conGerencia,"--SELECCIONE--","");
	$selGerencia=$gerencia->retornar();
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","entrarDenuevo()",$conDivision,"--SELECCIONE--","");
	$selDivision=$division->retornar();
	$aplicacion= new campoSeleccion("selAplicacion","formularioCampoSeleccion","$_POST[selAplicacion]","","",$conAplicacion,"--SELECCIONE--","");
	$selAplicacion=$aplicacion->retornar();    	
echo "<form name=\"frmRequrimientoAplicaciones\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">REQUERIMIENTOS</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">REQUERIMIENTO DE APLICACIONES</td>
			
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
  
<td valign=top class=\"formularioCampoTitulo\">GERENCIA<br>$selGerencia<br>
DIVISION<br>$selDivision<br></td>
<td valign=top class=\"formularioCampoTitulo\">APLICACIÓN<br>
<textarea name=\"txtAplicacion\" cols=\"35\" rows=\"3\"></textarea><br>
PLATAFORMA<br>$selAplicacion<br></td>
</td></tr>";
echo "<tr>";
echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" title=\"Almacenar requerimiento en la base de dato\" type=\"submit\" value=\"ALMACENAR\"><input name=\"cancelar\" title=\"Cancelar requerimiento\" type=\"button\" value=\"CANCELAR\" onclick=\"fuera()\"></td></tr>";
echo "</table>";
echo "</form>";
}
?>
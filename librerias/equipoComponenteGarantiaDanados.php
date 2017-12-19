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
	$login=$acceso->login();
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
<script language="javascript">
function buscar() {
	document.frmDesperfectos.funcion.value=0;
	document.frmDesperfectos.submit();
}
function cambiarSeleccion() {
	document.frmDesperfectos.funcion.value=0;
	document.frmDesperfectos.seleccion.value=1;
	document.frmDesperfectos.submit();
}
/*function cambiarGerencia() {
document.frmDesperfectos.funcion.value=2;
document.frmDesperfectos.submit();
}
function cambiarMarca() {
document.frmDesperfectos.funcion.value=3;
document.frmDesperfectos.submit();
}*/

</script>
<?php
require_once "administracion.php";
require_once("inventarioAdmin.php");
//EQUIPOS DAÑADOS

switch($funcion) {
	case 1:
	if (isset($_POST[txtSerial]) && empty($_POST[txtSerial])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>SERIAL</b>";
		$i++;
		$sw=1;
	}

	if (isset($_POST[txtDescripcion]) && empty($_POST[txtDescripcion])) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>DESCRIPCION</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selInventarioEstado]) && $_POST[selInventarioEstado]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>ESTATUS</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selSitio]) && $_POST[selSitio]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>UBICACION</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>GERENCIA</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selDivision]) && $_POST[selDivision]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>DIVISION</b>";
		$i++;
		$sw=1;
	}
	if (isset($_POST[selDepartamento]) && $_POST[selDepartamento]==100) {
		if ($sw==1) {
			$mensaje=$mensaje."<b>,</b>";
		}
		$mensaje=$mensaje." <b>DEPARTAMENTO</b>";
		$i++;
		$sw=1;
	}
	switch($i) {
		case 0:		
		$desperfecto=new inventarioGarantia("",$_POST[txtSerial],"","","","","");
		$resultado=$desperfecto->buscarPorSerial();		
		conectarMysql();		
		$row2 = mysql_fetch_array($resultado);
		$fechaAsociacion=getdate();
		$fechaAsociacion=$fechaAsociacion[year]."-".$fechaAsociacion[mon]."-".$fechaAsociacion[mday]." ".$fechaAsociacion[hours].":".$fechaAsociacion[minutes].":".$fechaAsociacion[seconds];								
				
		if ($_POST[selInventarioEstado]!=$row2[18]||$_POST[selSitio]!=$row2[10]||$_POST[selGerencia]!=$row2[12]||
			$_POST[selDivision]!=$row2[14]||$_POST[selDepartamento]!=$row2[16]){
			if ($row2[22]>0 && $row2[23]!='PRO0000000' && $_POST[selInventarioEstado]=='EST0000002'){			
			//506HFXH056810						 				
		 	$consulGarantia="select id_garantia from garantia order by id_garantia desc";
		    $idConse2= new consecutivo("GAR", $consulGarantia);
			$garantia=$idConse2->retornar();						
		 	$garantinsert= "insert into garantia(ID_GARANTIA,ID_INVENTARIO,FECHA_REPORTADO,STATUS_ACTIVO)
		 	                value ('$garantia','$row2[0]','$fechaAsociacion','1')";		 		 			 	
		 	$result3 = mysql_query($garantinsert);				 	
		 	$garantiaEstado="insert into garantia_estado(ID_GARANTIA,ID_ESTATUS_GARANTIA,FECHA_ASOCIACION,STATUS_ACTIVO) 
		 	                 VALUE('$garantia','STG0000001','$fechaAsociacion','1')";
		 	$result = mysql_query($garantiaEstado);			 	
		 	$garantiaDisponible="update inventario set disponible='0' where id_inventario='$row2[0]'";		 	
		 	$result4=mysql_query($garantiaDisponible);		 	
		    }
		    else if($_POST[selInventarioEstado]=='EST0000001'){
		    	echo "se modifica aqui a 1";
		      	 $garantiaDisponible="update inventario set disponible='1' where id_inventario='$row2[0]'";		 	
		 	     $result4=mysql_query($garantiaDisponible);
		    }			
				$consulUbicacion="select ubicacion.id_ubicacion from ubicacion order by id_ubicacion desc";
				$idConse= new consecutivo("UBI", $consulUbicacion);
				$ubicacion=$idConse->retornar();				
				$consInvProp= "select ID_INVENTARIO_PROPIEDAD from inventario_propiedad ORDER BY ID_INVENTARIO_PROPIEDAD DESC";
				$idConse1= new consecutivo("INP", $consInvProp);

				$idInvenPropiedad=$idConse1->retornar();
				$result2="insert into ubicacion (ID_UBICACION,ID_GERENCIA,ID_DIVISION,ID_DEPARTAMENTO,ID_SITIO)
				VALUES ('$ubicacion','$_POST[selGerencia]','$_POST[selDivision]','$_POST[selDepartamento]','$_POST[selSitio]')";				
				$consul2 = mysql_query($result2);				
				$consul1="insert into inventario_propiedad(ID_INVENTARIO_PROPIEDAD,ID_INVENTARIO,ID_ESTADO,ID_USS,ID_UBICACION,FICHA,FECHA_CAMBIO)
				VALUES ('$idInvenPropiedad','$row2[0]','$_POST[selInventarioEstado]','$login','$ubicacion','$row2[25]','$fechaAsociacion')";											
				$result1 = mysql_query($consul1);
				if ($result1){
				echo "<br><br>";				
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			    echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - COMPONENTE - REPORTADO</td>
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
			    echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";			    
			    echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - COMPONENTE - REPORTADO</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN FALLIDA INTENTELO DE NUEVO</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			    echo "</tr>";
			    echo "</table>";
				}					 
		}
			else {
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";
			echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
			echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
			echo "<input name=\"selInventarioEstado\" type=\"hidden\" value=\"$_POST[selInventarioEstado]\">";
			echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
			echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
			echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
			echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
			echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE - COMPONENTE - EXISTENTE</td>
					</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>NO SE ORIGINARON CAMBIOS, IMPOSIBLE GUARDAR</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			}

		break 1;
		default:
		echo "<br><br><br><br>";
		echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";
		echo "<input name=\"txtSerial\" type=\"hidden\" value=\"$_POST[txtSerial]\">";
		echo "<input name=\"txtDescripcion\" type=\"hidden\" value=\"$_POST[txtDescripcion]\">";
		echo "<input name=\"selInventarioEstado\" type=\"hidden\" value=\"$_POST[selInventarioEstado]\">";
		echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
		echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
		echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
		echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: COMPONENTES - DAÑADOS</td>
				</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VACIOS</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	}
	break 1;
	case 2:
	formularioDesperfectos();
	break 1;
	case 3:
	//formularioDesperfectos();
	break 1;
	default:
	formularioDesperfectos();

}
function formularioDesperfectos() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once("inventarioAdmin.php");
	
	
	if (isset($_POST[txtSerial]) && !empty($_POST[txtSerial])) {
		$desperfecto=new inventarioGarantia("",$_POST[txtSerial],"","","","","");
		$resultado=$desperfecto->buscarPorSerial();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			if ($_POST[seleccion]!=1){
				$_POST[selSitio]=$row[10];
				$_POST[selGerencia]=$row[12];
				$_POST[selDivision]=$row[14];
				$_POST[selDepartamento]=$row[16];
				$_POST[selInventarioEstado]=$row[18];
			}
		}
	}
	$conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio desc";
	$conGerencia="select id_gerencia,gerencia from gerencia where status_activo=1 order by gerencia";
	$conDivision="select id_division,division from division where id_gerencia='$_POST[selGerencia]' and status_activo=1 order by division";
	$conDepartamento="select id_departamento, departamento from departamento where id_division='$_POST[selDivision]' and status_activo=1 ORDER BY departamento";

	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
	$selSitio=$sitio->retornar();

	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();

	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();

	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();

	$conEstado="SELECT ID_ESTADO,ESTADO FROM inventario_estado WHERE ESTADO='OPERATIVO' OR ESTADO='INOPERATIVO'";
	$inventarioEstado= new campoSeleccion("selInventarioEstado","formularioCampoSeleccion","$_POST[selInventarioEstado]","","",$conEstado,"--SELECCIONE--","");
	$selInventarioEstado=$inventarioEstado->retornar();

	echo "<form name=\"frmDesperfectos\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"seleccion\" type=\"hidden\" value=\"0\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">COMPONENTES SUJETOS A CAMBIOS</td>
  				</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\">BUSCAR COMPONENTE</td>";
	echo "<td class=\"formularioTablaTitulo\">DATOS DE UBICACIÓN</td>
			</tr>";
	echo "<tr>
				<td valign=top class=\"formularioCampoTitulo\">SERIAL<br>
				<input class=\"formularioCampoTexto\" name=\"txtSerial\" type=\"text\" value=$_POST[txtSerial]><input name=\"button\" type=\"button\" title=\"Buscar Serial\" value=\"B\" onclick=\"buscar();\"><br>
				DESCRIPCION<br><input class=\"formularioCampoTexto\" name=\"txtDescripcion\" type=\"text\" readonly=\"true\" value=\"$row[2]   $row[4]   $row[6]\"><br>
				ESTATUS DEL COMPONENTE<br>$selInventarioEstado<br>
				</td>
				<td valign=top class=\"formularioCampoTitulo\">								
				UBICACION<BR>$selSitio<br>GERENCIA<BR>$selGerencia<br>DIVISION<BR>$selDivision<br>DEPARTAMENTO<BR>$selDepartamento<br>
				</td><tr>				
				</td>
			</tr>";
	echo "<tr align=\"center\">
		<td class=\"formularioTablaBotones\" colspan=2>		
		<input name=\"btnDesperfectos\" type=\"submit\" value=\"ACTUALIZAR\">
		</td>
	</tr>";	
	echo "</table>";	
}
?>
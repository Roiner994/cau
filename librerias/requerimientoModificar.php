<?php
//Requerimiento Modificar
require_once("seguridad.php");
?>

<?php
switch ($funcion) {
	case 1:
		if (isset($_POST[txtEspecifico]) && empty($_POST[txtEspecifico])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>DETALLE REQUERIMIENTO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selRequerimientoEstado]) && $_POST[selRequerimientoEstado]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>ESTADO</b>";
			$i++;
			$sw=1;
		}		
		
		switch($i) {
			case 0:
		require_once("requerimientoAdmin.php");
		$login=$_SESSION["login"];
		$requerimiento= new requerimientoHardware();
		$requerimiento->setRequerimientoHardware("","",$login);
		$requerimiento->setDetalleRequerimiento($_GET[idRequerimiento],"",$_POST[txtEspecifico],"",$_POST[selRequerimientoEstado]);
		$resultado=$requerimiento->modificarRequerimiento();
		switch ($resultado) {
			case 0:
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - NUEVO REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>SE MODIFICO EL REQUERIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=201'\"></td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";	
				break 1;
			case 1:
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - NUEVO REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>NO SE PUDO MODIFICAR EL REQUERIMIENTO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=202&idRequerimiento=SOL0000002'\">
				</td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";	
				break 1;
			case 2:
				echo "<br><br><br><br>";
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - NUEVO REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL ESTADO DEL REQUERIMIENTO ES EL MISMO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>
				<input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=202&idRequerimiento=SOL0000002'\">
				</td>";
				echo "</tr>";
				echo "</table>";						
				echo "</form>";	
				break 1;
		}
		break 1;				
				break 1;
			case 1:
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - NUEVO REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>EL CAMPO ".$mensaje. " ESTA VAC&Iacute;O</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";					
				break 1;
			default:
				echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: REQUERIMIENTO - NUEVO REQUERIMIENTO DE SOLICITUDES</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>LOS CAMPOS ".$mensaje. " ESTAN VAC&Iacute;OS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";			
				echo "</form>";					
				
				break 1;
		}
	case 1:
		break 1;
	default:
		frmRequerimientoEquipo();
}


function frmRequerimientoEquipo() {
	require_once("formularios.php");
	require_once("conexionsql.php");
	require_once("requerimientoAdmin.php");
	
	$requerimiento= new requerimientoHardware();
	$requerimiento->setDetalleRequerimiento($_GET[idRequerimiento]);
	$resultado=$requerimiento->mostrarRequerimientoPorId();
	if ($resultado && $resultado!=1) {
		$row=mysql_fetch_array($resultado);
		$Usuario=$row[2];
		$nombreApellido=$row[3]." ".$row[4];
		$cargo=$row[6];
		$gerencia=$row[10];
		$division=$row[12];
		$departamento=$row[14];
		$sitio=$row[8];		
		$extension=$row[15];
		$selDescripcion=$row[21];
		$selRequerimientoMotivo=$row[25];
		$_POST[selRequerimientoEstado]=$row[26];
		$detalleRequerimiento=$row[22];
	}
	
	
	$conRequerimientoEstado="select id_estado_requerimiento,estado_requerimiento from requerimiento_estado order by estado_requerimiento";
	
	$requerimientoEstado= new campoSeleccion("selRequerimientoEstado","formularioCampoSeleccion",$_POST[selRequerimientoEstado],"","",$conRequerimientoEstado,"--SELECCIONE--","");
	$selRequerimientoEstado=$requerimientoEstado->retornar();
	
	echo "<form name=\"frmRequerimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\" align=\"center\" width=\"70%\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\" colspan=\"2\">NUEVO REQUERIMIENTO DE HARDWARE</td>
  	</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL USUARIO</td>
  	</tr>";
	echo "<tr>
    		<td valign=top class=\"formularioCampoTitulo\">FICHA<br>
    		<b class=\"campo\">$Usuario</b>
			<br>
			NOMBRE Y APELLIDO<br><b class=\"campo\">$nombreApellido</b><br>
			CARGO<br><b class=\"campo\">$cargo</b><br>
			EXTENSION<br><b class=\"campo\">$extension</b><br>
			</td>
    		
			<td valign=top class=\"formularioCampoTitulo\">GERENCIA<br>
			<b class=\"campo\">$gerencia</b><br>
			DIVISION<br><b class=\"campo\">$division</b><br>
			DEPARTAMENTO<br><b class=\"campo\">$departamento</b><br>
			SITIO<br><b class=\"campo\">$sitio</b><br>
			</td>
		</tr>";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DEL REQUERIMIENTO</td>
  	</tr>";	
	echo "<tr>
    		<td valign=top class=\"formularioCampoTitulo\">MOTIVO SOLICITUD<br>
			<b class=\"campo\">$selRequerimientoMotivo</b><br>
			</td>
    		
			<td valign=top class=\"formularioCampoTitulo\">TIPO DE REQUERIMIENTO<br>
			<b class=\"campo\">$selDescripcion</b><br>
			</td>
		</tr>";
	
	echo "<tr>
		<td colspan=\"2\" align=\"center\" class=\"formularioCampoTitulo\">DETALLE DEL REQUERIMIENTO</td>
		</tr>
		<tr>
		<td colspan=\"2\" valign=top class=\"formularioCampoTitulo\"><b class=\"campo\">".strtoupper($detalleRequerimiento)."</b></td>
		</tr>";	
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\"></td>
  	</tr>";		

	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">CAMBIAR REQUERIMIENTO</td>
  	</tr>";		
	
		echo "<tr>
		<td colspan=\"2\" align=\"center\" class=\"formularioCampoTitulo\">ESTADO</td>
		</tr>
		<tr>
		<td valign=top class=\"formularioCampoTitulo\">$selRequerimientoEstado</td>
		</tr>
		<tr>
		<td colspan=\"2\" align=\"center\" class=\"formularioCampoTitulo\">DESCRIBA AQUI EL CAMBIO DEL ESTADO</td>
		</tr>		
		<tr>
		<td colspan=\"2\" valign=top class=\"formularioCampoTitulo\"><textarea class=\"formularioAreaTextoPlanilla\" name=\"txtEspecifico\" cols=\"600\" rows=\"2\">$_POST[txtEspecifico]</textarea></td>
		</tr>";		

	echo "<tr>";
		echo "<td colspan=\"4\" align=\"center\">
		<input name=\"btnEliminar\" type=\"button\" value=\"ELIMINAR SOLICITUD\" onclick=\"location.href='index2.php?item=204&idRequerimiento=$_GET[idRequerimiento]'\">
		<input name=\"btnGuardar\" type=\"submit\" value=\"GUARDAR\"></td>
		</tr>";
	echo "</table>";
	echo "</form>";		
}
?>
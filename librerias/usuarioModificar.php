<script>
	function cambiarSeleccion() {
		document.frmUsuario.funcion.value=2;
		document.frmUsuario.submit();
	}
	function agregar() {
		document.frmUsuario.funcion.value=3;
			document.frmUsuario.submit();
	}
	function numero(){ 
		var key=window.event.keyCode; 
 		if (key < 48 || key > 57){  
    		window.event.keyCode=0; 
 		}

} 
</script>

<?php
require_once "conexionsql.php";
require_once "administracion.php";
require_once "usuarioAdmin.php";
require_once "formularios.php";
//Modulo usuarioModificar
if (isset($ficha) && !empty($ficha)) {
	if ($_POST[funcion]!=3) {
		$_POST[funcion]=2;
	}
}
	

switch ($funcion) {
	case 1:
		mostrarResultado($_POST[txtBuscar]);
		break 1;
	case 2:
		formularioModificar($ficha);
		break 1;
	case 3:
		$sw=0;
		$mensaje="";
		if (isset($_POST[txtFicha]) && empty($_POST[txtFicha])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>FICHA</b>";
			$i++;
			$sw=1;  
		}
		if (isset($_POST[txtCedula]) && empty($_POST[txtCedula])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>CEDULA</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtNombres])  && empty($_POST[txtNombres])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>NOMBRES</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtApellidos])  && empty($_POST[txtApellidos])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>APELLIDO</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selCargo]) && $_POST[selCargo]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>CARGO</b>";
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
		if (isset($_POST[txtExtension]) && $_POST[txtExtension]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>EXTENSION</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[txtEmail])  && empty($_POST[txtEmail])) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>CORREO</b>";
			$i++;
			$sw=1;
		}
		switch($i) {
			case 0:
				$user= new usuario($_POST[txtFicha],$_POST[txtCedula],$_POST[txtNombres],$_POST[txtApellidos],$_POST[selCargo],$_POST[selGerencia],$_POST[selDivision],$_POST[selDepartamento],$_POST[selSitio],$_POST[txtExtension],"","$ficha",$_POST[txtEmail]);
				$resultado=$user->modificar();
				switch($resultado) {
					case 1:
						echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"5\">";
						echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
						echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
						echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
						echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
						echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
						echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ACTUALIZAR, CEDULA DUPLICADA</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
						</td>";
						echo "</tr>";
						echo "</table>";						
						echo "</form>";	
						break 1;
					case 2:
						echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"5\">";
						echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
						echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
						echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
						echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
						echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
						echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
						echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ACTUALIZAR, FICHA DUPLICADA</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\">
						</td>";
						echo "</tr>";
						echo "</table>";						
						echo "</form>";	
						break 1;
					case 0:
						echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"txtFicha\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtCedula\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtNombres\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selCargo\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selExtension\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtEmail\" type=\"hidden\" value=\"\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>SE ACTUALIZÓ EL NUEVO USUARIO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
						</td>";
						echo "</tr>";
						echo "</table>";						
						echo "</form>";	
						break 1;
					case 3:
						echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
						echo "<input name=\"txtFicha\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtCedula\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtNombres\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selCargo\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selSitio\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selGerencia\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selDivision\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"\">";
						echo "<input name=\"selExtension\" type=\"hidden\" value=\"\">";
						echo "<input name=\"txtEmail\" type=\"hidden\" value=\"\">";
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>IMPOSIBLE ACTUALIZAR EL USUARIO</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>
						<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
						</td>";
						echo "</tr>";
						echo "</table>";						
						echo "</form>";
						break 1;
				}
				break 1;
			case 1:	
				echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
				echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
				echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
				echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
				echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
				echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
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
				echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
				echo "<input name=\"txtFicha\" type=\"hidden\" value=\"$_POST[txtFicha]\">";
				echo "<input name=\"txtCedula\" type=\"hidden\" value=\"$_POST[txtCedula]\">";
				echo "<input name=\"txtNombres\" type=\"hidden\" value=\"$_POST[txtNombres]\">";
				echo "<input name=\"txtApellidos\" type=\"hidden\" value=\"$_POST[txtApellidos]\">";
				echo "<input name=\"selCargo\" type=\"hidden\" value=\"$_POST[selCargo]\">";
				echo "<input name=\"selSitio\" type=\"hidden\" value=\"$_POST[selSitio]\">";
				echo "<input name=\"selGerencia\" type=\"hidden\" value=\"$_POST[selGerencia]\">";
				echo "<input name=\"selDivision\" type=\"hidden\" value=\"$_POST[selDivision]\">";
				echo "<input name=\"selDepartamento\" type=\"hidden\" value=\"$_POST[selDepartamento]\">";
				echo "<input name=\"txtExtension\" type=\"hidden\" value=\"$_POST[txtExtension]\">";
				echo "<input name=\"txtEmail\" type=\"hidden\" value=\"$_POST[txtEmail]\">";
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: ADMINCAU - NUEVO USUARIO</td>
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
	case 4:
		break 1;
	default:
		formularioBuscar();
}


//Formulario para poder Modificar los datos de un Usuario
function formularioModificar($ficha) {
	if (isset($_POST[selGerencia]) && $_POST[selGerencia]==100 && $gerencia<>$_POST[selGerencia]) {
			$_POST[selDivision]=100;
			$_POST[selDepartamento]=100;
	}
		if (!isset($_POST[txtFicha]) && empty($_POST[txtFicha])) {
			$conUsuario="Select
				usuario.FICHA,
				usuario.CEDULA,
				usuario.NOMBRE_USUARIO,
				usuario.APELLIDO_USUARIO,
				usuario.ID_CARGO,
				cargo.CARGO,
				gerencia.ID_GERENCIA,
				gerencia.GERENCIA,
				division.ID_DIVISION,
				division.DIVISION,
				departamento.ID_DEPARTAMENTO,
				departamento.DEPARTAMENTO,
				sitio.ID_SITIO,
				sitio.SITIO,
				usuario.EXTENSION,
				usuario.EMAIL
				From
				usuario
				Inner Join departamento ON usuario.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
				Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
				Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
				Inner Join sitio ON usuario.ID_SITIO = sitio.ID_SITIO
				Inner Join cargo ON usuario.ID_CARGO = cargo.ID_CARGO where ficha='$ficha'";
			conectarMysql();
			$resultado=mysql_query($conUsuario);
			mysql_close();
			if ($resultado && mysql_numrows($resultado)>0) {
				$row=mysql_fetch_array($resultado);
				$_POST[txtFicha]=$row[0];
				$_POST[txtCedula]=$row[1];
				$_POST[txtNombres]=$row[2];
				$_POST[txtApellidos]=$row[3];
				$_POST[selCargo]=$row[4];
				$_POST[selGerencia]=$row[6];
				$_POST[selDivision]=$row[8];
				$_POST[selDepartamento]=$row[10];
				$_POST[selSitio]=$row[12];			
				$_POST[txtExtension]=$row[14];
				$_POST[txtEmail]=$row[15];
			}

		}
		$conCargo="SELECT ID_CARGO, CARGO FROM CARGO ORDER BY CARGO";
		$conSitio="SELECT ID_SITIO, SITIO FROM SITIO ORDER BY SITIO";
		$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM GERENCIA ORDER BY GERENCIA";
		$conDivision="SELECT ID_DIVISION, DIVISION FROM DIVISION  WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
		$conDepartamento="SELECT ID_DEPARTAMENTO, DEPARTAMENTO FROM DEPARTAMENTO  WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";

		$ficha= new campo("txtFicha","text","formularioCampoTexto","$_POST[txtFicha]","8","8","onKeyPress","numero()");
		$txtFicha=$ficha->retornar();

		$cedula= new campo("txtCedula","text","formularioCampoTexto","$_POST[txtCedula]","8","8","onKeyPress","numero()");
		$txtCedula=$cedula->retornar();

		$nombres= new campo("txtNombres","text","formularioCampoTexto","$_POST[txtNombres]","30","30");
		$txtNombres=$nombres->retornar();

		$apellidos= new campo("txtApellidos","text","formularioCampoTexto","$_POST[txtApellidos]","30","30");
		$txtApellidos=$apellidos->retornar();

		$cargo= new campoSeleccion("selCargo","formularioCampoSeleccion","$_POST[selCargo]","","",$conCargo,"--CARGO--","");
		$selCargo=$cargo->retornar();

		$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
		$selSitio=$sitio->retornar();

		$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
		$selGerencia=$gerencia->retornar();

		$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
		$selDivision=$division->retornar();

		$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
		$selDepartamento=$departamento->retornar();

		$extension= new campo("txtExtension","text","formularioCampoTexto","$_POST[txtExtension]","30","30");
		$txtExtension=$extension->retornar();
	
		$email= new campo("txtEmail","text","formularioCampoTexto","$_POST[txtEmail]","30","50");
		$txtEmail=$email->retornar();


	echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\">";

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - MODIFICAR USUARIO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">FICHA<br>
			$txtFicha<br>
			CEDULA<br>$txtCedula<br>
			NOMBRES<br>$txtNombres<br>
			APELLIDOS<br>$txtApellidos<br>
			CARGO<br>$selCargo<br>
			UBICACION<br>$selSitio<br>
			GERENCIA<br>$selGerencia<br>
			DIVISION<br>$selDivision<br>
			DEPARTAMENTO<br>$selDepartamento<br>
			EXTENSION<br>$txtExtension<br>
			CORREO<br>$txtEmail<br>
			</td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\">
			<input name=\"btnSalir\" type=\"button\" value=\"SALIR\" onclick=\"location.href='index2.php?item=1000'\">
			<input name=\"btnAgregar\" type=\"button\" onClick=\"agregar()\" value=\"ACTUALIZAR\">
			</td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
	}
	
function formularioBuscar() {
	$buscar= new campo("txtBuscar","text","$clase","$_POST[txtBuscar]","30","30");
	$txtBuscar=$buscar->retornar();
	echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - USUARIO MODIFICAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">BUSCAR USUARIO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">FICHA, CEDULA, NOMBRES<br>
			$txtBuscar<br>
		</td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\"><input name=\"btnBuscar\" type=\"submit\" onClick=\"\" value=\"BUSCAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
		
	}
	
	function mostrarResultado($txtBuscar) {
		$buscar=new usuario($txtBuscar,$txtBuscar,$txtBuscar,$txtBuscar);
		$resultado=$buscar->buscarUsuario();
		if ($resultado>0) {
		echo "<table width=\"500\" border=\"0\">
		  <tr>
		  <td valign=top class=\"tablaTitulo\"><b>FICHA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>CEDULA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>NOMBRES</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>APELLIDOS</b></td>
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
				<td><a class=enlace href=\"index2.php?item=24&funcion=2&ficha=$row[0]\">$row[0]</a></td>
				<td>$row[1]</td>
				<td>$row[2]</td>
				<td>$row[3]</td>
				</tr>";
		$i++;
		}
		echo "</table>";
		} else {
			
		}
	} 
?>

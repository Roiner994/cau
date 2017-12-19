
<?php
//Usuario del Sistema Agregar

switch ($_POST[funcion]) {
		case 1:
			$sw=0;
			$mensaje="";
			if (isset($_POST[txtTipoSoftware]) && empty($_POST[txtTipoSoftware])) {
				if ($sw==1) {
					$mensaje=$mensaje."<b>,</b>";
				}
				$mensaje=$mensaje." <b>TIPO DE SOFTWARE</b>";
				$i++;
				$sw=1; 
		 }		
			require_once "usuarioSistemaAdmin.php";
			require_once "conexionsql.php";
			require_once "administracion.php";
			
					echo "<br>LOGIN $POST[txtLogin]<br>";
					echo "<br>NOMBRE $_POST[txtNombre]<br>";
					echo "<br>APELLIDO $_POST[txtApellido]<br>";
			$listaPrivilegio=$_POST[campo];

					$tmp;
					for ($i=0;$i<count($idPrivilegio);$i++) {
						$tmp=$tmp."'".$idPrivilegio[$i]."',";
					}
					$total=strlen($tmp);
					$tmp=substr($tmp,0,strlen($tmp)-1);
					echo "<br>LOGIN $POST[txtUsuario]<br>";
					echo "<br>NOMBRE $_POST[txtNombre]<br>";
					echo "<br>APELLIDO $_POST[txtApellido]<br>";
					$usuarioSistema= new usuarioSistema("",$POST[txtLogin],"",$_POST[txtNombre],$_POST[txtApellido],"",1,1,$_POST[campo]);
					$resultado=$usuarioSistema->ingresar();
			break 1;
		default:
			formularioUsuarioSistema();
}
function formularioUsuarioSistema() {
	include "formularios.php";
	include "conexionsql.php";
	$conPrivilegio="select id_privilegio,privilegio from privilegio order by privilegio";

/*	$nombre= new campo("txtNombre","text","$clase","$_POST[txtNombre]","20","20","","");
	$txtNombre=$nombre->retornar();

	$apellido= new campo("txtApellido","text","$clase","$_POST[txtApellido]","20","20","","");
	$txtApellido=$apellido->retornar();
	
	$login= new campo("txtLogin","text","$clase","$_POST[txtLogin]","20","20","","");
	$txtLogin=$login->retornar();*/
	//$login= new campo("txtLogin","text","$clase","$POST[txtLogin]","32","32","onKeyPress","return Letras(event)");
	//$txtLogin=$login->retornar();

	echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	//echo "<input name=\"txtLogin\" type=\"text\" value=\"$POST[txtLogin]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - NUEVO USUARIO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">NOMBRE<br>
   			<input name=\"txtNombre\" type=\"text\" value=\"$_POST[txtNombre]\"><br>
    		APELLIDO<br><input name=\"txtLogin\" type=\"text\" value=\"$_POST[txtLogin]\"><br>
    		LOGIN<br><input name=\"txtApellido\" type=\"text\" value=\"$_POST[txtApellido]\"><br>
    		PRIVILEGIO<br>";
			conectarMysql();
			$result=mysql_query($conPrivilegio);
			mysql_close();
			while ($row=mysql_fetch_array($result)) {
		   		echo "<input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\">$row[1]<br>";
			}
			echo "</td>
		</tr>";
	 	echo "<tr>";
	 	echo "<td class=\"formularioTablaBotones\"><input name=\"btnLimpiar\" type=\"reset\" value=\"LIMPIAR\">
		<input name=\"btnAgregar\" type=\"submit\" value=\"AGREGAR\"></td>
		</tr>";
	echo "</table>";
	echo "</form>";

}
?>
<?php
//session_start();
$_SESSION['authUser']=1;
if (isset($_POST['txtUsuario']) && !empty($_POST['txtUsuario'])) {
	require_once "../librerias/usuarioSistemaAdmin.php";
	require_once "../librerias/conexionsql.php";
	$acceso= new usuarioSistema("",$_POST[txtUsuario],$_POST[txtClave]);
	$resultado= $acceso->validar();
	switch ($resultado) {
		case 1:
			$_SESSION['NOMBRE']="";
			$_SESSION['authUser']=1;
			break 1;
		case 2:
			$_SESSION['NOMBRE']="";
			$_SESSION['authUser']=1;
			break 1;
		default:
			$_SESSION['NOMBRE']=$acceso->retornaUsuario();
			$_SESSION['userName']=$_POST[txtUsuario];
			$_SESSION['userPass']=$_POST[txtClave];
			$_SESSION['authUser']=$acceso->validar();
	}
}
?>
<img src="../imagenes/logo-web-2.JPG" width="1000" height="80">
<?php
if ($_SESSION['authUser']==1) {
	session_start();
	// Destruye todas las variables de la sesi&oacute;n
	session_unset();
	// Finalmente, destruye la sesi&oacute;n
	session_destroy();
echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td class=\"inicioSessionIzquierda\"></td>
	<td class=\"inicioSessionDerecha\">";
	
	echo "<form name=\"frmProveedor\" method=\"post\" action=\"\">";
	echo "USUARIO:<input name=\"txtUsuario\" type=\"text\" size=\"20\" maxlength=\"20\"> | 
	CLAVE: <input class=\"formularioCampoTitulo\" name=\"txtClave\" type=\"password\" size=\"20\" maxlength=\"20\">
	<input class=\"formularioCampoTitulo\" name=\"btnAceptar\" type=\"submit\" value=\"Aceptar\"></td>";
	echo "</form>
	</tr>
	</table>";
} else {
	echo "<table width=\"1000\" border=\"0\">
  	<tr>
    <td valign=top class=\"inicioSessionIzquierda\">$_SESSION[NOMBRE]</td>
	<td valign=top class=\"inicioSessionDerecha\">
		<form name=\"frmProveedor\" method=\"post\" action=\"\">
			<a class=\"inicioSessionDerecha\" href=\"#\" onClick=\"frame.location.href='secciones.php?item=2'\">CAMBIAR CLAVE</a> | 
			<input name=\"funcion\" type=\"hidden\" value=\"2\">
			<a class=\"inicioSessionDerecha\" href=\"#\" onClick=\"document.frmProveedor.submit()\">CERRAR SESI&Oacute;N</a>
	</td>
	</form>
	</tr>
	</table>";
}
?>

<?php
require_once("seguridad.php");
$priv="'PRV0000002','PRV0000003','PRV0000004','PRV0000005'";

require_once("conexionsql.php");
require_once("usuarioSistemaAdmin.php");
$login=$_SESSION["login"];
$user= new usuarioSistema($login);
$resultado=$user->verificarAcceso($priv);
if ($resultado==1) {
		echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: INVENTARIO - EQUIPOS</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>NO TIENE SUFICIENTE PRIVILEGIO PARA ENTRAR A ESTE MODULO.</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"location.href='index2.php'\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";	
		exit();
}


//migracionsoftwareutilizado.php
require_once("conexionsql.php");
require_once("migracionAdmin.php");
if(isset($_GET[txtFicha]) && !empty($_GET[txtFicha])) {
	require_once ("usuarioAdmin.php");
	$usuario= new usuario($_GET[txtFicha]);
	$resultadoUsuario=$usuario->retornaUsuario();
	if ($resultadoUsuario && $resultadoUsuario!=1) {
		$rowUsuario=mysql_fetch_array($resultadoUsuario);
	} else {
		echo"<p>NO HAY UN USUARIO REGISTRADO CON LA FICHA N&Uacute;MERO $_GET[txtFicha]. VERIFIQUE SI EL NUMERO ES CORRECTO O LLAME AL NUMERO XXXX PARA CREAR EL USUARIO</p>";
		echo "<p><a href=\"migracionsoftwareusuario.php\">REGRESAR</a></p>";
		exit();
	}
} else {
	echo "<p>EL CAMPO FICHA DEL USUARIO EST&Aacute; VAC&Iacute;O</p>";
	echo "<p><a href=\"migracionsoftwareusuario.php\">REGRESAR</a></p>";
	exit();

}

if (isset($_GET[txtConfiguracion]) && !empty($_GET[txtConfiguracion])) {
	require_once("inventarioAdmin.php");
	$equipo= new equipo();
	$equipo->setEquipo($_GET[txtConfiguracion]);
	$resultadoEquipo=$equipo->buscarEquipo();
	if ($resultadoEquipo && $resultadoEquipo!=1) {
		$rowEquipo=mysql_fetch_array($resultadoEquipo);
	} else {
		echo "<p>NO HAY EQUIPO REGISTRADO CON LA CONFIGURACION N&Uacute;MERO $_GET[txtConfiguracion]. VERIFIQUE SI EL NUMERO ES CORRECTO O CREE EL EQUIPO.</p>";
		echo "<p><a href=\"migracionsoftwareusuario.php\">REGRESAR</a></p>";
		exit();
	}
} else {
	echo "<p>EL CAMPO CONFIGURACION DEL EQUIPO EST&Aacute; VAC&Iacute;O</p>";
	echo "<p><a href=\"migracionsoftwareusuario.php\">REGRESAR</a></p>";
	exit();

}
$migracion= new migracionSoftwareEquipo($_GET[txtConfiguracion],$login,$_GET[txtFicha]);
$migracion->ingresarSoftware($_GET[chkSoftware]);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>MIGRACION SOFTWARE LIBRE- SOFTWARE INSTALADO</title>
</head>
<body>
<h3>USUARIO</h3>
<p>
<label>FICHA:&nbsp; <?php echo $rowUsuario[0] ?><br>
NOMBRE:&nbsp; <?php echo $rowUsuario[3] ?><br>
APELLIDO:&nbsp; <?php echo $rowUsuario[4] ?><br>
CARGO:&nbsp; <?php echo $rowUsuario[6] ?><br>
GERENCIA:&nbsp; <?php echo $rowUsuario[10] ?><br>
DIVISION:&nbsp; <?php echo $rowUsuario[12] ?><br>
DEPARTAMENTO:&nbsp;<?php echo $rowUsuario[14] ?><br>
SITIO:&nbsp; <?php echo $rowUsuario[8] ?><br>
EXTENSION:&nbsp; <?php echo $rowUsuario[15] ?>
</p>
<h3>EQUIPO</h3>
<p>
CONFIGURACION:&nbsp; <?php echo $rowEquipo[0] ?><br>
DESCRIPCION:&nbsp; <?php echo $rowEquipo[5] ?><br>
MARCA:&nbsp; <?php echo $rowEquipo[7] ?><br>
MODELO:&nbsp; <?php echo $rowEquipo[9]." ".$rowEquipo[10]." ".$rowEquipo[11] ?><br>
SERIAL:&nbsp; <?php echo $rowEquipo[3] ?><br>
</p>

<p>
<fieldset class="front" id="validate-by-uri"><legend>INGRESE EN CADA UNO DE LOS ENLACES Y DESCRIBA EL USO QUE SE LE DA A CADA SOFTWARE</legend>
<form name="frmSoftwareInstalado" action="migracionsoftwareutilizado.php" method="get">
<input type="hidden" name="txtConfiguracion" value="<?=$_GET[txtConfiguracion]?>">
<input type="hidden" name="txtFicha" value="<?=$_GET[txtFicha]?>">
<?php
$softwareInstalado=new migracionSoftware();
	$resultado=$softwareInstalado->retornaSoftwareInstalado();
	
	$softwareEquipoInstalado= new migracionSoftwareEquipo($_GET[txtConfiguracion]);
	$resultado=$softwareEquipoInstalado->retornarSoftwareInstalado();
	
	if ($resultado && $resultado!=1) { ?>
		<dl>
		<?php
		while ($row=mysql_fetch_array($resultado)) { 
			
			?>
			
			<dt><strong><a href="migracionsoftwaredetalle.php?idSoftware=<?=$row[2];?>&txtFicha=<?=$_GET[txtFicha] ?>&txtConfiguracion=<?=$_GET[txtConfiguracion] ?>" ><?php echo "<br>$row[3] ($row[4])<br>"; ?></a></strong></dt>
			<dd><?php if ($softwareEquipoInstalado->retornaUtilizacionSoftware($row[2])!=1) echo $softwareEquipoInstalado->retornaUtilizacionSoftware($row[2]) ?></dd>
			
	
	<?php } ?>
	</dl>
<?php	}
?>
<INPUT type="button" value="IMPRIMIR" onclick="href=location.href='migracionplanilla.php?configuracion=<?=$_GET[txtConfiguracion]?>&ficha=<?=$_GET[txtFicha]?>&uss=<?=$_SESSION["login"]?>'">
<INPUT type="button" value="REGRESAR" onclick="href=location.href='migracionsoftwareinstalados.php?txtConfiguracion=<?=$_GET[txtConfiguracion]?>&txtFicha=<?=$_GET[txtFicha]?>'">
</form>
</p>
</body>
</html>




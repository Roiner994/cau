<?php
//Migracion Guardar Detalle
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

require_once("conexionsql.php");
require_once("migracionAdmin.php");
$migracion= new migracionSoftwareEquipo($_GET[txtConfiguracion],$login,"",$_GET[idSoftware]);
$resultado=$migracion->ingresarSoftwareUtilizado($_GET[txtDetalle]);
if ($resultado==0) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>MIGRACION SOFTWARE LIBRE- SOFTWARE INSTALADO</title>
</head>
<body>
<script language="javascript">
location.href="migracionsoftwareutilizado.php?txtFicha=<?=$_GET[txtFicha]?>&txtConfiguracion=<?=$_GET[txtConfiguracion]?>";
</script>
</body>
</html>
<?php } else { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>MIGRACION SOFTWARE LIBRE- SOFTWARE INSTALADO</title>
</head>
<body>
<p>NO SE GUARDO LA UTILIZACI&Oacute;N DEL SOFTWARE</p>
<p><a href="migracionsoftwareutilizado.php?txtFicha=<?=$_GET[txtFicha]?>&txtConfiguracion=<?=$_GET[txtConfiguracion]?>">REGRESAR</a></p>
</body>
</html>
<?php }

?>
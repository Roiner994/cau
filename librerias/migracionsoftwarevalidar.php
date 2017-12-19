<?php
//Migracion Software Nuevo - Validar Software Nuevo
require_once("migracionAdmin.php");
if (isset($_POST[txtSoftware]) && empty($_POST[txtSoftware])) {
	echo "<p>EL CAMPO SOFTWARE EST&Aacute; VAC&Iacute;O.</p>";
	echo "<p><a href=\"migracionsoftwareNuevo.php\">REGRESAR</a></p>";
	exit();
}

if (isset($_POST[txtDescripcionSoftware]) && empty($_POST[txtDescripcionSoftware])) {
	echo "<p>EL CAMPO DESCRIPCION DEL SOFTWARE EST&Aacute; VAC&Iacute;O.</p>";
	echo "<p><a href=\"migracionsoftwareNuevo.php\">REGRESAR</a></p>";
	exit();
}

$migracion= new migracionSoftware("",$_POST[txtSoftware],$_POST[txtDescripcionSoftware]);
$resultado=$migracion->ingresar();

switch ($resultado) {
	case 0: ?>
		<script type="text/javascript">
		function cerrar() {
			opener.location.reload();
			window.close();
		}
		</script>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
		<html>
		<head>
		<title>MIGRACION SOFTWARE LIBRE - AGREGAR NUEVO SOFTWARE</title>
		</head>
		<body>
		<p>SE GUARDO EL NUEVO SOFTWARE</p>
		<p><a href="#" onclick="cerrar()">CERRAR</a></p>
		</body>
		</html>
		
		<?php
		break 1;
	case 1: ?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
		<html>
		<head>
		<title>MIGRACION SOFTWARE LIBRE - AGREGAR NUEVO SOFTWARE</title>
		</head>
		<body>
		<p>NO SE PUDO GUARDAR EL NUEVO SOFTWARE</p>
		<p><a href="migracionSoftwareNuevo.php">REGRESAR</a></p>
		</body>
		</html>

		<?php
		break 1;
	case 2: ?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
		<html>
		<head>
		<title>MIGRACION SOFTWARE LIBRE - AGREGAR NUEVO SOFTWARE</title>
		</head>
		<body>
		<p>NO SE PUDO GUARDAR EL NUEVO SOFTWARE. YA EXISTE UN SOFTWARE CON ESE NOMBRE</p>
		<p><a href="migracionSoftwareNuevo.php">REGRESAR</a></p>
		</body>
		</html>
		<?php		
		break 1;
}
?>

